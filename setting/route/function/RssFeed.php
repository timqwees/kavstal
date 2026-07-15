<?php declare(strict_types=1);

namespace Setting\route\function;

class RssFeed
{
    public static function generate(): string
    {
        $site = Functions::site();
        $products = Functions::listProducts();
        $now = date('r');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
        $xml .= '  <channel>' . "\n";
        $xml .= '    <title>КАВ СТАЛЬ — Металлопрокат в Москве</title>' . "\n";
        $xml .= '    <link>' . htmlspecialchars($site['baseUrl']) . '</link>' . "\n";
        $xml .= '    <description>Актуальные цены и новости металлопроката от компании КАВ СТАЛЬ</description>' . "\n";
        $xml .= '    <language>ru</language>' . "\n";
        $xml .= '    <lastBuildDate>' . $now . '</lastBuildDate>' . "\n";
        $xml .= '    <atom:link href="' . $site['baseUrl'] . '/rss.xml" rel="self" type="application/rss+xml"/>' . "\n";
        $xml .= '    <image>' . "\n";
        $xml .= '      <url>' . htmlspecialchars($site['logo']) . '</url>' . "\n";
        $xml .= '      <title>КАВ СТАЛЬ</title>' . "\n";
        $xml .= '      <link>' . htmlspecialchars($site['baseUrl']) . '</link>' . "\n";
        $xml .= '    </image>' . "\n";

        $count = 0;
        foreach ($products as $product) {
            if ($count >= 50) break;
            $badge = $product['badge'] ?? '';
            if ($badge === 'Категория' || $badge === 'Подкатегория') continue;
            $canonicalUrl = $product['seo']['canonicalUrl'] ?? '';
            if (empty($canonicalUrl)) continue;

            $title = $product['name'] ?? $product['title'] ?? 'Товар';
            $description = $product['description'] ?? '';
            $link = $site['baseUrl'] . $canonicalUrl;
            $firstPrice = '';
            if (!empty($product['units'])) {
                $firstUnit = array_key_first($product['units']);
                $firstPrice = number_format((float) $product['units'][$firstUnit], 0, '.', ' ') . ' ₽/' . $firstUnit;
            }

            $xml .= '    <item>' . "\n";
            $xml .= '      <title>' . htmlspecialchars('Купить ' . $title . ' — цена ' . $firstPrice) . '</title>' . "\n";
            $xml .= '      <link>' . htmlspecialchars($link) . '</link>' . "\n";
            $xml .= '      <guid isPermaLink="true">' . htmlspecialchars($link) . '</guid>' . "\n";
            $xml .= '      <description>' . htmlspecialchars(mb_substr($description, 0, 500)) . '</description>' . "\n";
            $xml .= '      <pubDate>' . $now . '</pubDate>' . "\n";
            if (!empty($product['categories']['title'])) {
                $xml .= '      <category>' . htmlspecialchars($product['categories']['title']) . '</category>' . "\n";
            }
            $xml .= '    </item>' . "\n";
            $count++;
        }

        $xml .= '  </channel>' . "\n";
        $xml .= '</rss>' . "\n";

        return $xml;
    }

    public static function output(): void
    {
        $filePath = './file/rss.xml';
        if (file_exists($filePath)) {
            $etag = md5_file($filePath);
            if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] === $etag) {
                http_response_code(304);
                return;
            }
            header('Content-Type: application/rss+xml; charset=utf-8');
            header('ETag: ' . $etag);
            header('Cache-Control: public, max-age=3600');
            readfile($filePath);
            return;
        }
        $xml = self::generate();
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($filePath, $xml);
        header('Content-Type: application/rss+xml; charset=utf-8');
        header('Content-Length: ' . strlen($xml));
        echo $xml;
    }
}
