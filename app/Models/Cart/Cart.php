<?php declare(strict_types=1);

namespace App\Models\Cart;

use App\Config\Database;
use App\Config\Session;
use Setting\route\function\Functions;

class Cart
{
    private static ?string $sessionId = null;
    private static bool $tablesChecked = false;

    private static function initTables(): void
    {
        if (self::$tablesChecked) return;
        self::$tablesChecked = true;

        Database::send("CREATE TABLE IF NOT EXISTS cart_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            session_id TEXT NOT NULL,
            product_id TEXT NOT NULL,
            product_name TEXT NOT NULL DEFAULT '',
            unit TEXT NOT NULL DEFAULT '',
            price REAL NOT NULL DEFAULT 0,
            quantity REAL NOT NULL DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(session_id, product_id, unit)
        )");
    }

    private static function getSessionId(): string
    {
        if (self::$sessionId !== null) return self::$sessionId;

        $token = Session::init('cart_token');
        if (!$token || !is_string($token) || strlen($token) < 10) {
            $token = bin2hex(random_bytes(16));
            Session::init('cart_token', $token);
        }
        self::$sessionId = $token;
        return $token;
    }

    public static function add(string $productId, float $quantity, string $unit = ''): array
    {
        self::initTables();
        $sid = self::getSessionId();
        $product = Functions::showProduct($productId);

        if (!$product || empty($product['units'])) {
            return ['success' => false, 'error' => 'Товар не найден'];
        }

        if ($quantity <= 0) {
            return ['success' => false, 'error' => 'Некорректное количество'];
        }

        if (!$unit) {
            $unit = array_key_first($product['units']);
        }

        $price = $product['units'][$unit] ?? 0;
        if ($price <= 0) {
            return ['success' => false, 'error' => 'Цена не найдена для указанной единицы'];
        }

        $existing = Database::send(
            "SELECT id, quantity FROM cart_items WHERE session_id = ? AND product_id = ? AND unit = ?",
            [$sid, $productId, $unit]
        );

        if ($existing && count($existing) > 0) {
            Database::send(
                "UPDATE cart_items SET quantity = quantity + ? WHERE id = ?",
                [$quantity, $existing[0]['id']]
            );
        } else {
            Database::send(
                "INSERT INTO cart_items (session_id, product_id, product_name, unit, price, quantity) VALUES (?, ?, ?, ?, ?, ?)",
                [$sid, $productId, $product['name'] ?? $product['title'] ?? $productId, $unit, $price, $quantity]
            );
        }

        return ['success' => true, 'count' => self::getCount()];
    }

    public static function update(string $productId, float $quantity, string $unit = ''): array
    {
        self::initTables();
        $sid = self::getSessionId();

        if ($quantity <= 0) {
            return self::remove($productId, $unit);
        }

        $whereUnit = $unit ? " AND unit = ?" : "";
        $params = [$quantity, $sid, $productId];
        if ($unit) $params[] = $unit;

        Database::send(
            "UPDATE cart_items SET quantity = ? WHERE session_id = ? AND product_id = ?{$whereUnit}",
            $params
        );

        return ['success' => true, 'count' => self::getCount()];
    }

    public static function remove(string $productId, string $unit = ''): array
    {
        self::initTables();
        $sid = self::getSessionId();

        $whereUnit = $unit ? " AND unit = ?" : "";
        $params = [$sid, $productId];
        if ($unit) $params[] = $unit;

        Database::send(
            "DELETE FROM cart_items WHERE session_id = ? AND product_id = ?{$whereUnit}",
            $params
        );

        return ['success' => true, 'count' => self::getCount()];
    }

    public static function clear(): void
    {
        self::initTables();
        $sid = self::getSessionId();
        Database::send("DELETE FROM cart_items WHERE session_id = ?", [$sid]);
    }

    public static function getItems(): array
    {
        self::initTables();
        $sid = self::getSessionId();

        $rows = Database::send(
            "SELECT product_id, product_name, unit, price, quantity FROM cart_items WHERE session_id = ? ORDER BY created_at ASC",
            [$sid]
        );

        if (!$rows) return [];

        $items = [];
        foreach ($rows as $row) {
            $product = Functions::showProduct($row['product_id']);
            $items[] = [
                'product_id' => $row['product_id'],
                'product_name' => $row['product_name'],
                'unit' => $row['unit'],
                'price' => (float)$row['price'],
                'quantity' => (float)$row['quantity'],
                'subtotal' => round((float)$row['price'] * (float)$row['quantity'], 2),
                'image' => $product['images'][0] ?? '/public/assets/images/no-image.svg',
                'specs' => $product['specs'] ?? [],
                'product_url' => !empty($product['categories']['parent_id']) && !empty($product['categories']['id'])
                    ? "/market/katalog/{$product['categories']['parent_id']}/{$product['categories']['id']}/{$row['product_id']}"
                    : ($product['seo']['canonicalUrl'] ?? '#'),
            ];
        }

        return $items;
    }

    public static function getProductIds(): array
    {
        self::initTables();
        $sid = self::getSessionId();
        $rows = Database::send(
            "SELECT DISTINCT product_id FROM cart_items WHERE session_id = ?",
            [$sid]
        );
        if (!$rows) return [];
        return array_map(fn($r) => $r['product_id'], $rows);
    }

    public static function getCount(): int
    {
        self::initTables();
        $sid = self::getSessionId();
        $result = Database::send(
            "SELECT COALESCE(SUM(quantity), 0) as cnt FROM cart_items WHERE session_id = ?",
            [$sid]
        );
        return (int)(is_array($result) && isset($result[0]['cnt']) ? $result[0]['cnt'] : 0);
    }

    public static function getTotal(): float
    {
        self::initTables();
        $sid = self::getSessionId();
        $result = Database::send(
            "SELECT COALESCE(SUM(price * quantity), 0) as total FROM cart_items WHERE session_id = ?",
            [$sid]
        );
        return round((float)(is_array($result) && isset($result[0]['total']) ? $result[0]['total'] : 0), 2);
    }
}
