<?php declare(strict_types=1);

namespace App\Models\Order;

use App\Config\Database;
use App\Config\Session;
use App\Models\Cart\Cart;
use Setting\route\function\Functions;
use Dompdf\Dompdf;
use Dompdf\Options;

class Order
{
    private static bool $tablesChecked = false;

    private static function initTables(): void
    {
        if (self::$tablesChecked) return;
        self::$tablesChecked = true;

        Database::send("CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            session_id TEXT NOT NULL,
            customer_name TEXT NOT NULL,
            customer_phone TEXT NOT NULL,
            customer_email TEXT NOT NULL DEFAULT '',
            comment TEXT NOT NULL DEFAULT '',
            delivery_method TEXT NOT NULL DEFAULT '',
            payment_method TEXT NOT NULL DEFAULT '',
            total REAL NOT NULL DEFAULT 0,
            status TEXT NOT NULL DEFAULT 'new',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        Database::send("CREATE TABLE IF NOT EXISTS order_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER NOT NULL,
            product_id TEXT NOT NULL,
            product_name TEXT NOT NULL DEFAULT '',
            unit TEXT NOT NULL DEFAULT '',
            price REAL NOT NULL DEFAULT 0,
            quantity REAL NOT NULL DEFAULT 1,
            subtotal REAL NOT NULL DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
        )");

        try {
            Database::send("ALTER TABLE orders ADD COLUMN delivery_method TEXT NOT NULL DEFAULT ''");
        } catch (\Throwable $e) {}
        try {
            Database::send("ALTER TABLE orders ADD COLUMN payment_method TEXT NOT NULL DEFAULT ''");
        } catch (\Throwable $e) {}
    }

    public static function create(array $data): array
    {
        self::initTables();

        $cartItems = Cart::getItems();
        if (empty($cartItems)) {
            return ['success' => false, 'error' => 'Корзина пуста'];
        }

        $total = Cart::getTotal();
        $sessionId = Session::init('cart_token') ?? '';

        $name = trim($data['name'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $email = trim($data['email'] ?? '');
        $comment = trim($data['comment'] ?? '');
        $delivery = trim($data['delivery'] ?? '');
        $payment = trim($data['payment'] ?? '');

        if (empty($name)) return ['success' => false, 'error' => 'Укажите имя'];
        if (empty($phone)) return ['success' => false, 'error' => 'Укажите телефон'];

        Database::send(
            "INSERT INTO orders (session_id, customer_name, customer_phone, customer_email, comment, delivery_method, payment_method, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            [$sessionId, $name, $phone, $email, $comment, $delivery, $payment, $total]
        );

        $orderId = Database::getConnection()->lastInsertId();

        foreach ($cartItems as $item) {
            Database::send(
                "INSERT INTO order_items (order_id, product_id, product_name, unit, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$orderId, $item['product_id'], $item['product_name'], $item['unit'], $item['price'], $item['quantity'], $item['subtotal']]
            );
        }

        Cart::clear();

        try {
            $pdfContent = self::generatePdf((int)$orderId);
            $pdfPath = self::savePdf((int)$orderId, $pdfContent);

            $order = self::getById((int)$orderId);
            $data = (object)[
                'имя' => $order['customer_name'],
                'телефон' => $order['customer_phone'],
                'email' => $order['customer_email'] ?: '—',
                'комментарий' => $order['comment'] ?: '—',
                'сумма' => number_format((float)$order['total'], 2, ',', ' ') . ' ₽',
                'доставка' => self::deliveryLabel($order['delivery_method'] ?? ''),
                'оплата' => self::paymentLabel($order['payment_method'] ?? ''),
                'Чек (PDF)' => 'прикреплён к письму',
                'both' => true,
            ];
            Functions::sendMail($data, $pdfPath);
            @unlink($pdfPath);
        } catch (\Exception $e) {
            error_log('Order email error: ' . $e->getMessage());
        }

        return ['success' => true, 'order_id' => (int)$orderId];
    }

    private static array $deliveryLabels = [
        'pickup' => 'Самовывоз',
        'moscow' => 'Доставка по Москве',
        'oblast' => 'Доставка по области',
        'russia' => 'Доставка по России',
    ];

    private static array $paymentLabels = [
        'cash' => 'Наличные',
        'card' => 'Картой при получении',
        'transfer' => 'Безналичный расчёт',
    ];

    public static function deliveryLabel(?string $key): string
    {
        return self::$deliveryLabels[$key] ?? ($key ?: '—');
    }

    public static function paymentLabel(?string $key): string
    {
        return self::$paymentLabels[$key] ?? ($key ?: '—');
    }

    public static function getById(int $orderId): ?array
    {
        self::initTables();
        $result = Database::send("SELECT * FROM orders WHERE id = ?", [$orderId]);
        return is_array($result) && isset($result[0]) ? $result[0] : null;
    }

    public static function getItems(int $orderId): array
    {
        self::initTables();
        $result = Database::send("SELECT * FROM order_items WHERE order_id = ? ORDER BY id ASC", [$orderId]);
        return is_array($result) ? $result : [];
    }

    public static function getBySession(): array
    {
        self::initTables();
        $sessionId = Session::init('cart_token') ?? '';
        if (!$sessionId) return [];
        $result = Database::send("SELECT * FROM orders WHERE session_id = ? ORDER BY created_at DESC", [$sessionId]);
        return is_array($result) ? $result : [];
    }

    public static function quickCreate(string $name, string $phone, string $productId): int
    {
        self::initTables();
        $sessionId = Session::init('cart_token') ?? bin2hex(random_bytes(16));
        Database::send(
            "INSERT INTO orders (session_id, customer_name, customer_phone, comment, total) VALUES (?, ?, ?, ?, ?)",
            [$sessionId, $name, $phone, 'Быстрый заказ: ' . $productId, 0]
        );
        return (int)Database::getConnection()->lastInsertId();
    }

    public static function generatePdf(int $orderId): string
    {
        $order = self::getById($orderId);
        if (!$order) {
            throw new \RuntimeException('Заказ не найден');
        }
        $items = self::getItems($orderId);
        $site = Functions::site();

        $rows = '';
        foreach ($items as $item) {
            $rows .= '
                <tr>
                    <td>' . htmlspecialchars($item['product_name']) . '</td>
                    <td>' . htmlspecialchars($item['unit']) . '</td>
                    <td class="amount">' . number_format((float)$item['price'], 2, ',', ' ') . ' ₽</td>
                    <td class="amount">' . number_format((float)$item['quantity'], 2, ',', ' ') . '</td>
                    <td class="amount">' . number_format((float)$item['subtotal'], 2, ',', ' ') . ' ₽</td>
                </tr>';
        }

        $html = '
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<style>
    @page { margin: 0; }
    body {
        font-family: "DejaVu Sans", sans-serif;
        font-size: 10px;
        color: #111111;
        background: #f5f5f5;
        margin: 0;
        padding: 0;
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
    }
    .page {
        width: 210mm;
        min-height: 297mm;
        margin: 0 auto;
        background: #ffffff;
        position: relative;
    }
    .top-strip { height: 4px; background: #dc2626; }
    .header {
        padding: 20px 30px 16px;
        border-bottom: 1px solid #e5e7eb;
    }
    .header-inner { width: 100%; }
    .header-left { float: left; }
    .header-right { float: right; text-align: right; }
    .company-name {
        font-size: 22px;
        font-weight: 800;
        color: #dc2626;
        letter-spacing: 1px;
        margin: 0 0 2px;
    }
    .company-tagline {
        font-size: 9px;
        color: #6b7280;
        margin: 0;
    }
    .order-badge {
        display: inline-block;
        background: #dc2626;
        color: #ffffff;
        font-size: 10px;
        font-weight: 700;
        padding: 4px 14px;
        border-radius: 4px;
        margin-bottom: 4px;
    }
    .order-number {
        font-size: 16px;
        font-weight: 700;
        color: #111111;
        margin: 2px 0;
    }
    .order-date {
        font-size: 9px;
        color: #6b7280;
        margin: 0;
    }
    .content { padding: 20px 30px; }
    .section-title {
        font-size: 11px;
        font-weight: 700;
        color: #111111;
        margin: 0 0 10px;
        padding-bottom: 6px;
        border-bottom: 2px solid #dc2626;
    }
    .info-grid { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
    .info-grid td {
        padding: 4px 8px;
        font-size: 10px;
        vertical-align: top;
    }
    .info-grid td.label {
        font-weight: 600;
        color: #6b7280;
        width: 100px;
    }
    .info-grid td.value { color: #111111; }
    .customer-card {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 20px;
        width: 100%;
    }
    .customer-card td { padding: 3px 8px; font-size: 10px; }
    .customer-card td.label { font-weight: 600; color: #6b7280; width: 90px; }
    .customer-card td.value { color: #111111; }
    .items-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    .items-table th {
        background: #dc2626;
        color: #ffffff;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 8px 10px;
        text-align: left;
    }
    .items-table th.amount { text-align: right; }
    .items-table td {
        padding: 7px 10px;
        font-size: 9px;
        border-bottom: 1px solid #e5e7eb;
        color: #111111;
    }
    .items-table td.amount { text-align: right; }
    .items-table tr:nth-child(even) td { background: #f9fafb; }
    .items-table tr:last-child td { border-bottom: none; }
    .total-section {
        text-align: right;
        padding: 12px 0 4px;
        border-top: 2px solid #dc2626;
        margin-bottom: 20px;
    }
    .total-label {
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        margin-right: 12px;
    }
    .total-amount {
        font-size: 18px;
        font-weight: 800;
        color: #dc2626;
    }
    .delivery-info {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 16px;
    }
    .delivery-info td { padding: 3px 8px; font-size: 10px; }
    .delivery-info td.label { font-weight: 600; color: #6b7280; width: 90px; }
    .delivery-info td.value { color: #111111; }
    .footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: #111111;
        color: #9ca3af;
        padding: 16px 30px;
        font-size: 8px;
    }
    .footer table { width: 100%; }
    .footer td { padding: 2px 10px; vertical-align: top; }
    .footer .footer-title {
        font-size: 9px;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 4px;
    }
    .footer .footer-label { color: #6b7280; }
    .footer .footer-value { color: #d1d5db; }
    .watermark {
        position: fixed;
        bottom: 60px;
        right: 30px;
        font-size: 48px;
        font-weight: 900;
        color: #fef2f2;
        letter-spacing: 4px;
        z-index: -1;
    }
    .clearfix::after {
        content: "";
        display: table;
        clear: both;
    }
</style>
</head>
<body>
<div class="page">
    <div class="top-strip"></div>

    <div class="header">
        <div class="header-inner clearfix">
            <div class="header-left">
                <div class="company-name">' . htmlspecialchars($site['company'] ?? 'КАВ СТАЛЬ') . '</div>
                <div class="company-tagline">Металлопрокат • Доставка по России</div>
            </div>
            <div class="header-right">
                <div class="order-badge">ЗАКАЗ</div>
                <div class="order-number">№' . $orderId . '</div>
                <div class="order-date">от ' . date('d.m.Y', strtotime($order['created_at'])) . ' · ' . date('H:i', strtotime($order['created_at'])) . '</div>
            </div>
        </div>
    </div>

    <div class="content">
        <table class="info-grid">
            <tr>
                <td class="label">Статус:</td>
                <td class="value"><strong>Новый</strong></td>
                <td class="label">Оплата:</td>
                <td class="value">' . htmlspecialchars(self::paymentLabel($order['payment_method'] ?? '')) . '</td>
            </tr>
            <tr>
                <td class="label">Доставка:</td>
                <td class="value">' . htmlspecialchars(self::deliveryLabel($order['delivery_method'] ?? '')) . '</td>
                <td class="label">Менеджер:</td>
                <td class="value">—</td>
            </tr>
        </table>

        <div class="section-title">ДАННЫЕ ПОКУПАТЕЛЯ</div>
        <table class="customer-card">
            <tr>
                <td class="label">ФИО:</td>
                <td class="value">' . htmlspecialchars($order['customer_name']) . '</td>
                <td class="label">Email:</td>
                <td class="value">' . htmlspecialchars($order['customer_email'] ?: '—') . '</td>
            </tr>
            <tr>
                <td class="label">Телефон:</td>
                <td class="value">' . htmlspecialchars($order['customer_phone']) . '</td>
                <td class="label">Комментарий:</td>
                <td class="value">' . htmlspecialchars($order['comment'] ?: '—') . '</td>
            </tr>
        </table>

        <div class="section-title">СОСТАВ ЗАКАЗА</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width:50%;">Наименование</th>
                    <th style="width:12%;">Ед.</th>
                    <th class="amount" style="width:14%;">Цена</th>
                    <th class="amount" style="width:12%;">Кол-во</th>
                    <th class="amount" style="width:12%;">Сумма</th>
                </tr>
            </thead>
            <tbody>' . $rows . '
            </tbody>
        </table>

        <div class="total-section">
            <span class="total-label">Итого к оплате:</span>
            <span class="total-amount">' . number_format((float)$order['total'], 2, ',', ' ') . ' ₽</span>
        </div>

        <p style="font-size:8px;color:#9ca3af;margin:8px 0 0;line-height:1.4;">
            Спасибо за заказ! Наш менеджер свяжется с вами в ближайшее время для подтверждения.<br>
            Все цены указаны с НДС. Точная стоимость доставки рассчитывается индивидуально.
        </p>
    </div>

    <div class="footer">
        <table>
            <tr>
                <td style="width:30%;">
                    <div class="footer-title">' . htmlspecialchars($site['company'] ?? 'КАВ СТАЛЬ') . '</div>
                    <div>' . htmlspecialchars($site['address'] ?? '') . '</div>
                </td>
                <td style="width:25%;">
                    <div class="footer-title">Контакты</div>
                    <div class="footer-label">Тел:</div>
                    <div class="footer-value">' . htmlspecialchars($site['phone'] ?? '') . '</div>
                    <div class="footer-label">Email:</div>
                    <div class="footer-value">' . htmlspecialchars($site['email'] ?? '') . '</div>
                </td>
                <td style="width:25%;">
                    <div class="footer-title">График работы</div>
                    <div class="footer-value">' . htmlspecialchars($site['workingHours'] ?? 'Пн-Пт: 9:00-18:00') . '</div>
                </td>
                <td style="width:20%;">
                    <div class="footer-title">Сайт</div>
                    <div class="footer-value">' . htmlspecialchars($site['baseUrl'] ?? 'https://www.kavstal.ru') . '</div>
                </td>
            </tr>
        </table>
        <div style="text-align:center;margin-top:8px;font-size:7px;color:#6b7280;">
            © ' . date('Y') . ' ' . htmlspecialchars($site['company'] ?? 'КАВ СТАЛЬ') . ' · Все права защищены
        </div>
    </div>

    <div class="watermark">PDF</div>
</div>
</body>
</html>';

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4');
        $dompdf->render();

        return $dompdf->output();
    }

    public static function savePdf(int $orderId, string $pdfContent): string
    {
        $dir = dirname(__DIR__, 3) . '/app/Storage/orders';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $path = $dir . '/order-' . $orderId . '.pdf';
        file_put_contents($path, $pdfContent);
        return $path;
    }
}
