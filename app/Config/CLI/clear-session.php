<?php
/**
 * Очистка cookie-сессии сайта (Session::init(null)).
 * Используется в npm run clean — обнуляет данные сессии.
 * ВАЖНО: сам браузерный cookie этим скриптом не удалить —
 * полная очистка браузером/инкогнито.
 */

require_once dirname(__DIR__, 3) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__, 3) . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 3));
    $dotenv->load();
}

\App\Config\Session::init(null);

echo "Session cleared\n";
