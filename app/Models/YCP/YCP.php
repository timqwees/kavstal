<?php declare(strict_types=1);

namespace App\Models\YCP;

use App\Config\Database;
use App\Models\Order\Order;
use App\Config\Session;
use Setting\route\function\Functions;

class YCP
{
    private const ACCESS_TOKEN = '8825f1c0ddd178d4826605d32655cb034bda97511b1ff2eaf26353087fd922fb';

    private static bool $tablesChecked = false;

    private static function initTables(): void
    {
        if (self::$tablesChecked) return;
        self::$tablesChecked = true;

        Database::send("CREATE TABLE IF NOT EXISTS ycp_sessions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            session_id TEXT NOT NULL UNIQUE,
            items TEXT NOT NULL DEFAULT '[]',
            locality TEXT NOT NULL DEFAULT '',
            customer_name TEXT NOT NULL DEFAULT '',
            customer_phone TEXT NOT NULL DEFAULT '',
            customer_email TEXT NOT NULL DEFAULT '',
            delivery_method TEXT NOT NULL DEFAULT '',
            payment_method TEXT NOT NULL DEFAULT '',
            delivery_address TEXT NOT NULL DEFAULT '',
            comment TEXT NOT NULL DEFAULT '',
            status TEXT NOT NULL DEFAULT 'pending',
            order_id INTEGER DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public static function authenticate(): ?array
    {
        $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (preg_match('/^Bearer\s+(.+)$/i', $header, $m)) {
            if (hash_equals(self::ACCESS_TOKEN, $m[1])) {
                return null;
            }
        }
        http_response_code(401);
        self::json(['error' => 'Unauthorized']);
        return null;
    }

    public static function handleBasketCheck(): void
    {
        $input = self::getJsonInput();
        if ($input === null) return;

        $isHealthCheck = !empty($input['is_health_check']);
        $items = $input['items'] ?? [];
        $locality = $input['locality'] ?? '';
        $offersFromMerchant = !empty($input['offers_id_from_merchant_center']);

        $products = Functions::listProducts();
        $productMap = [];
        foreach ($products as $p) {
            $productMap[$p['id']] = $p;
        }

        $resultItems = [];
        foreach ($items as $item) {
            $id = $item['id'] ?? '';
            $quantity = (int)($item['quantity'] ?? 1);
            $product = $productMap[$id] ?? null;

            if (!$product) {
                http_response_code(404);
                self::json(['error' => "Product not found: $id"]);
                return;
            }

            $units = $product['units'] ?? [];
            $firstUnit = array_key_first($units);
            $price = $firstUnit ? (int)($units[$firstUnit] ?? 0) : 0;

            $images = $product['images'] ?? [];
            $imageUrl = !empty($images) ? $images[0] : '';
            $url = $product['seo']['canonicalUrl'] ?? '';
            $baseUrl = Functions::site()['baseUrl'] ?? 'https://kavstal.ru';

            if ($imageUrl && strpos($imageUrl, 'http') !== 0) {
                $imageUrl = $baseUrl . $imageUrl;
            }
            if ($url && strpos($url, 'http') !== 0) {
                $url = $baseUrl . $url;
            }

            $resultItems[] = [
                'id' => $id,
                'name' => $product['name'] ?? $product['title'] ?? '',
                'regular_price' => $price,
                'final_price' => $price,
                'img' => $imageUrl,
                'url' => $url,
                'vat' => 20,
                'available_quantity' => ($product['in_stock'] ?? false) ? 999 : 0,
                'warehouses' => [
                    [
                        'id' => '1',
                        'name' => 'Основной склад',
                        'available_quantity' => ($product['in_stock'] ?? false) ? 999 : 0,
                    ],
                ],
                'dimensions' => [
                    'weight' => null,
                    'length' => null,
                    'width' => null,
                    'height' => null,
                ],
                'characteristics' => [],
                'variations' => [],
            ];
        }

        self::json(['items' => $resultItems]);
    }

    public static function handleCreateSession(): void
    {
        $input = self::getJsonInput();
        if ($input === null) return;

        $items = $input['items'] ?? [];
        $locality = $input['locality'] ?? '';
        $sessionId = self::generateUuid();

        self::initTables();
        Database::send(
            "INSERT INTO ycp_sessions (session_id, items, locality, status) VALUES (?, ?, ?, 'pending')",
            [$sessionId, json_encode($items, JSON_UNESCAPED_UNICODE), $locality]
        );

        self::json(['session_id' => $sessionId, 'status' => 'pending']);
    }

    public static function handleSubmitOrder(string $sessionId): void
    {
        $input = self::getJsonInput();
        if ($input === null) return;

        self::initTables();
        $rows = Database::send("SELECT * FROM ycp_sessions WHERE session_id = ? AND status = 'pending'", [$sessionId]);
        if (!$rows || !isset($rows[0])) {
            http_response_code(404);
            self::json(['error' => 'Session not found or already processed']);
            return;
        }
        $session = $rows[0];

        $customer = $input['customer'] ?? [];
        $delivery = $input['delivery'] ?? [];
        $payment = $input['payment'] ?? [];

        $name = trim($customer['name'] ?? '');
        $phone = trim($customer['phone'] ?? '');
        $email = trim($customer['email'] ?? '');
        $deliveryMethod = $delivery['method'] ?? 'pickup';
        $paymentMethod = $payment['method'] ?? 'transfer';
        $deliveryAddress = $delivery['address'] ?? '';
        $comment = trim($input['comment'] ?? '');

        if (empty($name)) {
            http_response_code(400);
            self::json(['error' => 'Customer name is required']);
            return;
        }
        if (empty($phone)) {
            http_response_code(400);
            self::json(['error' => 'Customer phone is required']);
            return;
        }

        $sessionItems = json_decode($session['items'], true) ?? [];
        $products = Functions::listProducts();
        $productMap = [];
        foreach ($products as $p) {
            $productMap[$p['id']] = $p;
        }

        $total = 0;
        $orderItemsData = [];
        foreach ($sessionItems as $item) {
            $id = $item['id'] ?? '';
            $quantity = (float)($item['quantity'] ?? 1);
            $product = $productMap[$id] ?? null;
            if (!$product) continue;

            $units = $product['units'] ?? [];
            $firstUnit = array_key_first($units);
            $price = $firstUnit ? (float)($units[$firstUnit] ?? 0) : 0;
            $subtotal = $price * $quantity;
            $total += $subtotal;

            $orderItemsData[] = [
                'product_id' => $id,
                'product_name' => $product['name'] ?? $product['title'] ?? '',
                'unit' => $firstUnit ?? '',
                'price' => $price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }

        $sessionIdStr = Session::init('cart_token') ?? bin2hex(random_bytes(16));

        Database::send(
            "INSERT INTO orders (session_id, customer_name, customer_phone, customer_email, comment, delivery_method, payment_method, total, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'new')",
            [$sessionIdStr, $name, $phone, $email, $comment, $deliveryMethod, $paymentMethod, $total]
        );
        $orderId = (int)Database::getConnection()->lastInsertId();

        foreach ($orderItemsData as $item) {
            Database::send(
                "INSERT INTO order_items (order_id, product_id, product_name, unit, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$orderId, $item['product_id'], $item['product_name'], $item['unit'], $item['price'], $item['quantity'], $item['subtotal']]
            );
        }

        Database::send(
            "UPDATE ycp_sessions SET status = 'completed', order_id = ?, customer_name = ?, customer_phone = ?, customer_email = ?, delivery_method = ?, payment_method = ?, delivery_address = ?, comment = ?, updated_at = CURRENT_TIMESTAMP WHERE session_id = ?",
            [$orderId, $name, $phone, $email, $deliveryMethod, $paymentMethod, $deliveryAddress, $comment, $sessionId]
        );

        try {
            $pdfContent = Order::generatePdf($orderId);
            $pdfPath = Order::savePdf($orderId, $pdfContent);
            $order = Order::getById($orderId);
            $mailData = (object)[
                'имя' => $order['customer_name'],
                'телефон' => $order['customer_phone'],
                'email' => $order['customer_email'] ?: '—',
                'комментарий' => $order['comment'] ?: '—',
                'сумма' => number_format((float)$order['total'], 2, ',', ' ') . ' ₽',
                'доставка' => Order::deliveryLabel($order['delivery_method'] ?? ''),
                'оплата' => Order::paymentLabel($order['payment_method'] ?? ''),
                'Чек (PDF)' => 'прикреплён к письму',
                'Источник' => 'Яндекс (YCP)',
                'yclid' => $input['yclid'] ?? '',
                'both' => true,
            ];
            Functions::sendMail($mailData, $pdfPath);
            @unlink($pdfPath);
        } catch (\Exception $e) {
            error_log('YCP order email error: ' . $e->getMessage());
        }

        self::json([
            'order_id' => $orderId,
            'status' => 'success',
            'total' => $total,
        ]);
    }

    public static function handleCancelSession(string $sessionId): void
    {
        self::initTables();
        Database::send(
            "UPDATE ycp_sessions SET status = 'cancelled', updated_at = CURRENT_TIMESTAMP WHERE session_id = ? AND status = 'pending'",
            [$sessionId]
        );
        self::json(['status' => 'cancelled']);
    }

    public static function handleCancelOrder(int $orderId): void
    {
        try {
            Database::send("UPDATE orders SET status = 'cancelled' WHERE id = ?", [$orderId]);

            self::initTables();
            Database::send(
                "UPDATE ycp_sessions SET status = 'cancelled', updated_at = CURRENT_TIMESTAMP WHERE order_id = ?",
                [$orderId]
            );

            self::json(['status' => 'cancelled']);
        } catch (\Exception $e) {
            http_response_code(500);
            self::json(['error' => 'Failed to cancel order']);
        }
    }

    public static function handleWarehouses(): void
    {
        self::json([
            'warehouses' => [
                [
                    'id' => '1',
                    'name' => 'Основной склад',
                    'address' => 'г. Москва, ул. Промышленная, д. 1',
                ],
            ],
        ]);
    }

    public static function handleHealthCheck(): void
    {
        self::json(['status' => 'ok', 'time' => date('c')]);
    }

    private static function getJsonInput(): ?array
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        if (!is_array($data)) {
            http_response_code(400);
            self::json(['error' => 'Invalid JSON']);
            return null;
        }
        return $data;
    }

    private static function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    private static function json(array $data): void
    {
        header('Content-Type: application/json; charset=utf-8');
        print json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}
