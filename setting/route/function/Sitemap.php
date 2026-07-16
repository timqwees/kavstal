<?php declare(strict_types=1);

namespace Setting\route\function;

/**
 * Генератор XML Sitemap для SEO
 */
class Sitemap
{

    /**
     * Генерация sitemap.xml
     * @param string $format 'yandex' или 'google'
     */
    public static function generate(string $format = 'yandex'): string
    {
        $instance = new self();
        return $instance->buildXml($format);
    }

    /**
     * Сохранение sitemap в файл
     */
    public static function saveToFile(string $path, string $content): bool
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return file_put_contents($path, $content) !== false;
    }

    /**
     * Отдача XML с gzip сжатием
     * @param string $format 'yandex' или 'google'
     * @param bool $createFile создать файл если его нет
     */
    public static function outputCompressed(string $format = 'yandex', bool $createFile = false): void
    {
        $filePath = './file/sitemap_' . $format . '.xml';

        // Проверяем кэш (1 час)
        if (file_exists($filePath)) {
            $fileAge = time() - filemtime($filePath);
            if ($fileAge < 3600) {
                $etag = md5_file($filePath);
                if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] === $etag) {
                    http_response_code(304);
                    return;
                }
                header('Content-Type: application/xml; charset=utf-8');
                header('ETag: ' . $etag);
                header('Cache-Control: public, max-age=3600');
                readfile($filePath);
                return;
            }
        }

        // Генерируем свежий sitemap
        $xml = self::generate($format);
        $etag = md5($xml);

        if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] === $etag) {
            http_response_code(304);
            return;
        }

        if ($createFile) {
            self::saveToFile($filePath, $xml);
        }

        header('Content-Type: application/xml; charset=utf-8');
        header('ETag: ' . $etag);
        header('Cache-Control: public, max-age=3600');
        header('Content-Length: ' . strlen($xml));
        echo $xml;
    }

    /**
     * Построение XML
     * @param string $format 'yandex' или 'google'
     */
    private function buildXml(string $format = 'yandex'): string
    {
        $urls = $this->collectUrls();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= $this->buildUrlEntry($url, $format);
        }

        $xml .= '</urlset>' . "\n";
        return $xml;
    }

    /**
     * Сбор всех URL
     */
    private function collectUrls(): array
    {
        $urls = [];

        // Главная страница
        $urls[] = [
            'loc' => '/',
            'priority' => '1.0',
            'changefreq' => 'daily'
        ];

        // Страница маркета
        $urls[] = [
            'loc' => '/market',
            'priority' => '0.9',
            'changefreq' => 'daily'
        ];

        // Страницы раздела other
        $otherPages = [
            '/market/other/about',
            '/market/other/contacts',
            '/market/other/delivery',
            '/market/other/guarantees',
            '/market/other/services'
        ];
        foreach ($otherPages as $page) {
            $urls[] = [
                'loc' => $page,
                'priority' => '0.5',
                'changefreq' => 'monthly'
            ];
        }

        // Получаем все продукты/категории/подкатегории
        $products = Functions::listProducts();

        // Собираем уникальные категории
        $categories = [];
        $subcategories = [];
        $productUrls = [];

        foreach ($products as $product) {
            $badge = $product['badge'] ?? null;
            $canonicalUrl = $product['seo']['canonicalUrl'] ?? null;

            if (!$canonicalUrl) {
                continue;
            }

            // Очищаем URL
            $canonicalUrl = str_replace(\Setting\route\function\Functions::site()['baseUrl'], '', $canonicalUrl);

            // Категории (priority 0.8)
            if ($badge === 'Категория') {
                $categories[$canonicalUrl] = [
                    'loc' => $canonicalUrl,
                    'priority' => '0.8',
                    'changefreq' => 'weekly'
                ];
            }
            // Подкатегории (priority 0.7)
            elseif ($badge === 'Подкатегория') {
                $subcategories[$canonicalUrl] = [
                    'loc' => $canonicalUrl,
                    'priority' => '0.7',
                    'changefreq' => 'weekly'
                ];
            }
            // Товары (priority 0.6)
            else {
                $productUrls[$canonicalUrl] = [
                    'loc' => $canonicalUrl,
                    'priority' => '0.6',
                    'changefreq' => 'weekly'
                ];
            }
        }

        // Добавляем в порядке важности
        $urls = array_merge($urls, $categories, $subcategories, $productUrls);

        return $urls;
    }

    /**
     * Построение записи URL
     * @param string $format 'yandex' или 'google'
     */
    private function buildUrlEntry(array $url, string $format = 'yandex'): string
    {
        $fullUrl = \Setting\route\function\Functions::site()['baseUrl'] . $url['loc'];
        $lastmod = date('Y-m-d');

        $xml = "  <url>\n";
        $xml .= "    <loc>" . htmlspecialchars($fullUrl, ENT_XML1, 'UTF-8') . "</loc>\n";
        $xml .= "    <lastmod>" . $lastmod . "</lastmod>\n";

        // Для Яндекса добавляем changefreq и priority
        if ($format === 'yandex') {
            $xml .= "    <changefreq>" . $url['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $url['priority'] . "</priority>\n";
        }

        $xml .= "  </url>\n";

        return $xml;
    }
}
