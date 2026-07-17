<?php declare(strict_types=1);

namespace Setting\route\function;

class BlogRssFeed
{
    public static function generate(): string
    {
        $site = Functions::site();
        $blogFile = __DIR__ . '/../../../public/blog/data/articles.json';
        $articles = [];

        if (file_exists($blogFile)) {
            $articles = json_decode(file_get_contents($blogFile), true) ?? [];
        }

        // Сортируем по дате (новые сверху)
        usort($articles, function ($a, $b) {
            return strtotime($b['created_at'] ?? '0') <=> strtotime($a['created_at'] ?? '0');
        });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/">' . "\n";
        $xml .= '  <channel>' . "\n";
        $xml .= '    <title>Блог КАВ СТАЛЬ — Статьи о металлопрокате</title>' . "\n";
        $xml .= '    <link>' . htmlspecialchars($site['baseUrl'] . '/blog') . '</link>' . "\n";
        $xml .= '    <description>Экспертные статьи о видах металлопроката, ГОСТ, расчёте веса, резке и доставке. Помогаем выбрать правильный металл для стройки и производства.</description>' . "\n";
        $xml .= '    <language>ru</language>' . "\n";
        $xml .= '    <lastBuildDate>' . date('r') . '</lastBuildDate>' . "\n";
        $xml .= '    <atom:link href="' . htmlspecialchars($site['baseUrl'] . '/blog/rss.xml') . '" rel="self" type="application/rss+xml" />' . "\n";
        $xml .= '    <image>' . "\n";
        $xml .= '      <url>' . htmlspecialchars($site['baseUrl'] . '/public/assets/images/icons/favicon/favicon.svg') . '</url>' . "\n";
        $xml .= '      <title>Блог КАВ СТАЛЬ</title>' . "\n";
        $xml .= '      <link>' . htmlspecialchars($site['baseUrl'] . '/blog') . '</link>' . "\n";
        $xml .= '    </image>' . "\n";

        foreach ($articles as $article) {
            if (empty($article['slug'])) continue;

            $url = $site['baseUrl'] . '/blog/' . htmlspecialchars($article['slug']);
            $rawImg = $article['image'] ?? '/public/assets/images/bgpage/product.png';
            $img = (str_starts_with($rawImg, 'http://') || str_starts_with($rawImg, 'https://')) ? $rawImg : $site['baseUrl'] . $rawImg;

            $pubDate = !empty($article['created_at']) ? date('r', strtotime($article['created_at'])) : date('r');
            $title = htmlspecialchars($article['title'] ?? '');
            $description = htmlspecialchars($article['excerpt'] ?? '');
            $category = htmlspecialchars($article['category'] ?? 'Статья');

            // Полный контент для content:encoded
            $fullContent = $article['content'] ?? '';
            $fullContentHtml = '';
            if (!empty($fullContent)) {
                $blocks = preg_split('/\n\n+/', $fullContent);
                foreach ($blocks as $block) {
                    $block = trim($block);
                    if ($block === '') continue;
                    if (preg_match('/^##\s+(.+)$/u', $block, $m)) {
                        $fullContentHtml .= '<h2>' . htmlspecialchars($m[1]) . '</h2>';
                    } elseif (preg_match('/^###\s+(.+)$/u', $block, $m)) {
                        $fullContentHtml .= '<h3>' . htmlspecialchars($m[1]) . '</h3>';
                    } elseif (preg_match('/^\|(.+)\|$/mu', $block)) {
                        $fullContentHtml .= '<p>[Таблица]</p>';
                    } elseif (preg_match('/^[-*]\s+/mu', $block)) {
                        $items = explode("\n", $block);
                        $fullContentHtml .= '<ul>';
                        foreach ($items as $li) {
                            $li = trim(preg_replace('/^[-*]\s+/u', '', $li));
                            if ($li !== '') $fullContentHtml .= '<li>' . htmlspecialchars($li) . '</li>';
                        }
                        $fullContentHtml .= '</ul>';
                    } else {
                        $fullContentHtml .= '<p>' . nl2br(htmlspecialchars($block)) . '</p>';
                    }
                }
            }

            $xml .= '    <item>' . "\n";
            $xml .= '      <title>' . $title . '</title>' . "\n";
            $xml .= '      <link>' . htmlspecialchars($url) . '</link>' . "\n";
            $xml .= '      <guid isPermaLink="true">' . htmlspecialchars($url) . '</guid>' . "\n";
            $xml .= '      <pubDate>' . $pubDate . '</pubDate>' . "\n";
            $xml .= '      <category>' . $category . '</category>' . "\n";
            $xml .= '      <description>' . $description . '</description>' . "\n";
            if (!empty($fullContentHtml)) {
                $xml .= '      <content:encoded><![CDATA[' . $fullContentHtml . ']]></content:encoded>' . "\n";
            }
            if (!empty($img)) {
                $xml .= '      <enclosure url="' . htmlspecialchars($img) . '" type="image/jpeg" />' . "\n";
            }
            $xml .= '    </item>' . "\n";
        }

        $xml .= '  </channel>' . "\n";
        $xml .= '</rss>' . "\n";

        return $xml;
    }

    public static function output(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        header('Cache-Control: public, max-age=3600');
        echo self::generate();
    }
}