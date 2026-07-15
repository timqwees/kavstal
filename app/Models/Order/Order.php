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

        if (empty($name)) return ['success' => false, 'error' => 'Укажите имя'];
        if (empty($phone)) return ['success' => false, 'error' => 'Укажите телефон'];

        Database::send(
            "INSERT INTO orders (session_id, customer_name, customer_phone, customer_email, comment, total) VALUES (?, ?, ?, ?, ?, ?)",
            [$sessionId, $name, $phone, $email, $comment, $total]
        );

        $orderId = Database::getConnection()->lastInsertId();

        foreach ($cartItems as $item) {
            Database::send(
                "INSERT INTO order_items (order_id, product_id, product_name, unit, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$orderId, $item['product_id'], $item['product_name'], $item['unit'], $item['price'], $item['quantity'], $item['subtotal']]
            );
        }

        Cart::clear();

        return ['success' => true, 'order_id' => (int)$orderId];
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

    public static function generatePdf(int $orderId): string
    {
        $order = self::getById($orderId);
        if (!$order) {
            throw new \RuntimeException('Заказ не найден');
        }
        $items = self::getItems($orderId);
        $site = Functions::site();

        $html = '
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<style>
    @page { margin: 20mm 15mm; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
    .header { text-align: center; border-bottom: 2px solid #1a56db; padding-bottom: 15px; margin-bottom: 20px; }
    .header h1 { font-size: 22px; color: #1a56db; margin: 0 0 5px; }
    .header p { margin: 2px 0; color: #555; font-size: 11px; }
    .order-info { margin-bottom: 20px; }
    .order-info table { width: 100%; border-collapse: collapse; }
    .order-info td { padding: 3px 8px; }
    .order-info td:first-child { font-weight: bold; width: 150px; color: #555; }
    .customer { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px 15px; margin-bottom: 20px; }
    .customer h3 { margin: 0 0 8px; font-size: 14px; color: #1a56db; }
    .customer p { margin: 3px 0; font-size: 11px; }
    table.items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    table.items th { background: #1a56db; color: #fff; padding: 8px 10px; text-align: left; font-size: 11px; }
    table.items th:nth-child(4),
    table.items th:nth-child(5) { text-align: right; }
    table.items td { padding: 7px 10px; border-bottom: 1px solid #e2e8f0; font-size: 11px; }
    table.items td:nth-child(4),
    table.items td:nth-child(5) { text-align: right; }
    table.items tr:nth-child(even) { background: #f8fafc; }
    .total { text-align: right; font-size: 16px; font-weight: bold; padding: 10px 0; border-top: 2px solid #1a56db; }
    .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #888; border-top: 1px solid #e2e8f0; padding-top: 10px; }
</style>
</head>
<body>
<div class="header">
    <h1>' . htmlspecialchars($site['company'] ?? '') . '</h1>
    <p>' . htmlspecialchars($site['address'] ?? '') . '</p>
    <p>Тел: ' . htmlspecialchars($site['phone'] ?? '') . ' | Email: ' . htmlspecialchars($site['email'] ?? '') . '</p>
</div>
<div class="order-info">
    <table>
        <tr><td>Номер заказа:</td><td>#' . $orderId . '</td></tr>
        <tr><td>Дата:</td><td>' . date('d.m.Y H:i', strtotime($order['created_at'])) . '</td></tr>
        <tr><td>Статус:</td><td>Новый</td></tr>
    </table>
</div>
<div class="customer">
    <h3>Данные покупателя</h3>
    <p><strong>ФИО:</strong> ' . htmlspecialchars($order['customer_name']) . '</p>
    <p><strong>Телефон:</strong> ' . htmlspecialchars($order['customer_phone']) . '</p>
    <p><strong>Email:</strong> ' . htmlspecialchars($order['customer_email'] ?: '—') . '</p>
    <p><strong>Комментарий:</strong> ' . htmlspecialchars($order['comment'] ?: '—') . '</p>
</div>
<table class="items">
    <thead>
        <tr>
            <th>Товар</th>
            <th>Ед.</th>
            <th>Цена</th>
            <th>Кол-во</th>
            <th>Сумма</th>
        </tr>
    </thead>
    <tbody>';

        foreach ($items as $item) {
            $html .= '
        <tr>
            <td>' . htmlspecialchars($item['product_name']) . '</td>
            <td>' . htmlspecialchars($item['unit']) . '</td>
            <td>' . number_format((float)$item['price'], 2, ',', ' ') . ' ₽</td>
            <td>' . number_format((float)$item['quantity'], 2, ',', ' ') . '</td>
            <td>' . number_format((float)$item['subtotal'], 2, ',', ' ') . ' ₽</td>
        </tr>';
        }

        $html .= '
    </tbody>
</table>
<div class="total">
    Итого: ' . number_format((float)$order['total'], 2, ',', ' ') . ' ₽
</div>
<div class="footer">
    <p>Спасибо за заказ! Для получения дополнительной информации свяжитесь с нами.</p>
    <p>' . htmlspecialchars($site['baseUrl'] ?? '') . '</p>
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
