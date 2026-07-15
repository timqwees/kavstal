<?php declare(strict_types=1);

namespace Setting\route\function;
use App\Config\Database;
use App\Models\Network\Message;
use App\Models\Network\Network;

class Reviews extends Network
{
    public static $table_name = 'reviews';
    public static function addReview($data): bool
    {
        try {
            // Convert array to object if needed
            if (is_array($data)) {
                $data = (object) $data;
            }
            $name = trim(htmlspecialchars($data->name ?? ''));
            $email = trim(htmlspecialchars($data->email ?? ''));
            $rating = (int) ($data->rating ?? 0);
            $review = trim(htmlspecialchars($data->review ?? ''));
            $productId = $data->product_id ?? '';
            // Базовая валидация с установкой сообщений об ошибках
            if (empty($name) || strlen($name) < 2) {
                Message::set('error', 'Имя должно содержать минимум 2 символа');
                return false;
            }
            if ($rating < 1 || $rating > 5) {
                Message::set('error', 'Выберите оценку от 1 до 5');
                return false;
            }
            if (empty($review) || strlen($review) < 10) {
                Message::set('error', 'Отзыв должен содержать минимум 10 символов');
                return false;
            }
            $result = Database::send("INSERT INTO " . self::$table_name . " (product_id, name, email, rating, review, ip_address, approved, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, 1, CURRENT_TIMESTAMP)", [
                $productId,
                $name,
                $email,
                $rating,
                $review,
                $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            // Установка сообщения об успехе
            Message::set('success', 'Спасибо за ваш отзыв!');
            // Перенаправление обратно на страницу
            Network::onRedirect($data->redirect_url ?? $_SERVER['HTTP_REFERER'] ?? '/');
            return $result;
        } catch (\Exception $e) {
            error_log('Review save error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Получение отзывов для товара
     */
    public static function getReviews(string $productId): array
    {
        try {
            $result = Database::send("SELECT * FROM " . self::$table_name . " 
                    WHERE product_id = ? 
                    ORDER BY created_at DESC 
                    LIMIT 50", [$productId]);
            return is_array($result) ? $result : [];
        } catch (\Exception $e) {
            error_log('Reviews load error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Получение среднего рейтинга
     */
    public static function getAverageRating(string $productId): float
    {
        try {
            $result = Database::send("SELECT AVG(rating) as avg_rating, COUNT(*) as count FROM " . self::$table_name . " WHERE product_id = ?", [$productId]);
            if (!empty($result) && isset($result[0]['avg_rating'])) {
                return (float) $result[0]['avg_rating'];
            }
            return 0.0;
        } catch (\Exception $e) {
            error_log('Rating calc error: ' . $e->getMessage());
            return 0.0;
        }
    }

    /**
     * Обновление статуса отзыва (одобрение/отклонение)
     */
    public static function updateReviewStatus(int $reviewId, bool $approved): bool
    {
        try {
            $result = Database::send("UPDATE " . self::$table_name . " SET approved = ? WHERE id = ?", [$approved ? 1 : 0, $reviewId]);
            return $result;
        } catch (\Exception $e) {
            error_log('Review status update error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Удаление отзыва
     */
    public static function deleteReview(int $reviewId): bool
    {
        try {
            $result = Database::send("DELETE FROM " . self::$table_name . " WHERE id = ?", [$reviewId]);
            return $result !== false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Получение всех отзывов (для админки)
     */
    public static function getAllReviews(): array
    {
        try {
            $result = Database::send("SELECT * FROM " . self::$table_name . " ORDER BY created_at DESC");
            return is_array($result) ? $result : [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
