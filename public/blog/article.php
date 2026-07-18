<?php
$site = Setting\route\function\Functions::site();
$slug = $slug ?? ($_GET['slug'] ?? '');
$articlesFile = __DIR__ . '/data/articles.json';
$articles = [];
if (file_exists($articlesFile)) {
    $articles = json_decode(file_get_contents($articlesFile), true) ?? [];
}
$article = null;
foreach ($articles as $a) {
    if (($a['slug'] ?? '') === $slug) { $article = $a; break; }
}
if (!$article) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

$pageUrl = $site['baseUrl'] . '/blog/' . htmlspecialchars($article['slug']);
$rawImg = $article['image'] ?? '/public/assets/images/bgpage/product.png';
$ogImg = (str_starts_with($rawImg, 'http://') || str_starts_with($rawImg, 'https://')) ? $rawImg : $site['baseUrl'] . $rawImg;
$datePublished = $article['created_at'] ?? '';
$dateModified = $article['updated_at'] ?? $datePublished;

function renderContent(string $text, array $contentImages = []): string {
    if (!$text) return '';
    $html = $text;
    $html = htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
    $html = preg_replace('/^###\s+(.+)$/m', '<h3>$1</h3>', $html);
    $html = preg_replace('/^##\s+(.+)$/m', '<h2>$1</h2>', $html);
    $html = preg_replace('/^#\s+(.+)$/m', '<h1>$1</h1>', $html);
    $html = preg_replace('/^>\s+(.+)$/m', '<blockquote><p>$1</p></blockquote>', $html);
    $html = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $html);
    $html = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $html);
    $lines = explode("\n", $html);
    $inList = false;
    $inTable = false;
    $result = [];
    $h2Count = 0;
    $imgIdx = 0;
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if (preg_match('/^\|(.+)\|$/', $trimmed)) {
            if (!$inTable) {
                $inTable = true;
                $result[] = '<div class="table-wrap"><table>';
            }
            if (preg_match('/^\|[\s\-:|]+\|$/', $trimmed)) {
                continue;
            }
            $cells = array_map('trim', explode('|', trim($trimmed, '| ')));
            $result[] = '<tr>';
            foreach ($cells as $cell) {
                $result[] = '<td>' . $cell . '</td>';
            }
            $result[] = '</tr>';
        } else {
            if ($inTable) {
                $inTable = false;
                $result[] = '</table></div>';
            }
            if (preg_match('/<h2>/', $line)) {
                $h2Count++;
                $result[] = $line;
                if ($imgIdx < count($contentImages) && $h2Count > 1 && $h2Count % 2 === 0) {
                    $imgSrc = $contentImages[$imgIdx];
                    $result[] = '<figure class="article-content-img"><img src="' . $imgSrc . '" alt="" loading="lazy"></figure>';
                    $imgIdx++;
                }
            } elseif (preg_match('/^-\s+(.+)$/', $line, $m)) {
                if (!$inList) { $result[] = '<ul>'; $inList = 'ul'; }
                $result[] = '<li>' . $m[1] . '</li>';
            } elseif ($inList) {
                $result[] = '</' . $inList . '>';
                $inList = false;
                $result[] = $line;
            } else {
                $result[] = $line;
            }
        }
    }
    if ($inList) $result[] = '</' . $inList . '>';
    if ($inTable) $result[] = '</table></div>';
    $html = implode("\n", $result);
    $html = preg_replace('/\n\n+/', '</p><p>', $html);
    $html = preg_replace('/\n/', '<br>', $html);
    $html = '<p>' . $html . '</p>';
    $html = preg_replace('/<p>\s*<(h[1-3]|ul|ol|li|blockquote|div|table|figure)/', '<$1', $html);
    $html = preg_replace('/<\/(h[1-3]|ul|ol|li|blockquote|div|table|figure)>\s*<\/p>/', '</$1>', $html);
    $html = preg_replace('/<p>\s*<\/p>/', '', $html);
    $html = str_replace(["<br><table", "<br><tr", "<br><td", "<br><div", "<br><figure"], ["<table", "<tr", "<td", "<div", "<figure"], $html);
    $html = str_replace(["</table><br>", "</tr><br>", "</td><br>", "</div><br>", "</figure><br>"], ["</table>", "</tr>", "</td>", "</div>", "</figure>"], $html);
    $html = str_replace(["</td>\n<td"], ["</td><td"], $html);
    return $html;
}

$contentHtml = renderContent($article['content'] ?? '', $article['contentImages'] ?? []);

$related = array_filter($articles, fn($a) => ($a['slug'] ?? '') !== $slug && ($a['category'] ?? '') === ($article['category'] ?? ''));
if (count($related) < 4) {
    foreach ($articles as $a) {
        if (($a['slug'] ?? '') !== $slug && count($related) < 4 && !in_array($a, $related, true)) $related[] = $a;
    }
}
$related = array_slice(array_values($related), 0, 4);

function ozDateArticle(string $dateStr): string {
    $ts = strtotime($dateStr);
    $months = ['янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек'];
    return date('d', $ts) . ' ' . $months[(int)date('m', $ts) - 1] . ' ' . date('Y', $ts);
}

function estimateReadTime(string $content): int {
    $text = strip_tags($content ?? '');
    return max(1, (int)ceil(mb_strlen($text) / 1500));
}

$readTime = estimateReadTime($article['content'] ?? '');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title'] . ' — Блог КАВ СТАЛЬ') ?></title>
    <meta name="description" content="<?= htmlspecialchars($article['metaDescription'] ?? $article['excerpt'] ?? '') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($article['tags'] ?? '') ?>">
    <link rel="canonical" href="<?= htmlspecialchars($pageUrl) ?>">
    <link rel="alternate" type="application/rss+xml" title="Блог КАВ СТАЛЬ — RSS" href="<?= htmlspecialchars($site['baseUrl'] . '/rss.xml') ?>">
    <meta property="og:title" content="<?= htmlspecialchars($article['title'] . ' — Блог КАВ СТАЛЬ') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($article['metaDescription'] ?? $article['excerpt'] ?? '') ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= htmlspecialchars($pageUrl) ?>">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="<?= htmlspecialchars($ogImg) ?>">
    <meta property="article:published_time" content="<?= htmlspecialchars($datePublished) ?>">
    <meta property="article:modified_time" content="<?= htmlspecialchars($dateModified) ?>">
    <?php if (!empty($article['category'])): ?><meta property="article:section" content="<?= htmlspecialchars($article['category']) ?>"><?php endif; ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($article['title'] . ' — Блог КАВ СТАЛЬ') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($article['metaDescription'] ?? $article['excerpt'] ?? '') ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImg) ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= htmlspecialchars($article['author'] ?? $site['company']) ?>">

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="<?= $site['baseUrl'] ?>">

    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="stylesheet" href="/public/assets/styles/catalog.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <link rel="preload" href="/public/assets/styles/main.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="/public/assets/styles/main.css"></noscript>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>
    <?php include_once __DIR__ . '/../components/seo-head.php'; ?>
    
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; scroll-padding-top: 80px; }
        body {
            margin: 0; font-family: 'Onest', system-ui, -apple-system, sans-serif;
            background: #fff; color: #1a1a1a;
            -webkit-font-smoothing: antialiased;
        }
        img { max-width: 100%; display: block; }
        a { color: inherit; text-decoration: none; }

        /* ── Container ─────────────────────────────────────── */
        .article-container { max-width: 1152px; margin: 0 auto; padding: 0 16px; }
        @media (min-width: 640px) { .article-container { padding: 0 24px; } }
        .article-py { padding-top: 24px; padding-bottom: 48px; }

        /* ── Breadcrumbs (domozmsk style) ──────────────────── */
        .breadcrumbs {
            display: flex; flex-wrap: wrap; align-items: center;
            gap: 8px; font-size: 14px; color: #6b7280;
            margin-bottom: 20px;
        }
        .breadcrumbs a { color: #6b7280; transition: color 0.2s; }
        .breadcrumbs a:hover { color: #dc2626; }
        .breadcrumbs__sep { color: #d1d5db; }
        .breadcrumbs__current { color: #111827; font-weight: 500; }

        /* ── Content Grid (domozmsk 12-col) ────────────────── */
        .article-grid {
            display: grid; grid-template-columns: 1fr;
            gap: 32px;
        }
        .article-main { max-width: 100%; overflow: hidden; overflow-wrap: break-word; }
        @media (min-width: 960px) {
            .article-grid {
                grid-template-columns: repeat(12, 1fr);
                gap: 32px;
            }
            .article-main { grid-column: span 8; }
            .article-sidebar { grid-column: span 4; }
        }

        /* ── Article Meta Row (domozmsk) ───────────────────── */
        .article-meta-row {
            display: flex; flex-wrap: wrap; align-items: center;
            justify-content: space-between;
            gap: 12px; margin-bottom: 14px;
        }
        .article-meta-left { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; font-size: 13px; color: #6b7280; }
        .article-meta-left time { display: inline-flex; align-items: center; gap: 5px; }
        .article-meta-left time svg { width: 14px; height: 14px; opacity: 0.5; }
        .article-readtime { display: inline-flex; align-items: center; gap: 5px; }
        .article-readtime svg { width: 14px; height: 14px; opacity: 0.5; }
        .article-meta-sep { color: #d1d5db; }

        .article-tags { display: flex; flex-wrap: wrap; gap: 8px; }
        .article-tags a {
            font-size: 12px; font-weight: 600; color: #16a34a;
            padding: 2px 8px; border-radius: 6px;
            background: #f0fdf4;
            transition: all 0.2s;
        }
        .article-tags a:hover { color: #15803d; background: #dcfce7; }

        .article-title {
            font-size: 32px; line-height: 1.2; font-weight: 800; color: #111827;
            margin: 0 0 12px;
        }
        @media (min-width: 768px) { .article-title { font-size: 40px; } }

        .article-excerpt {
            font-size: 15px; line-height: 1.6; color: #7a7f8c;
            max-width: 650px; margin-bottom: 20px;
        }

        /* ── Author Row (domozmsk style) ───────────────────── */
        .article-author-row {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; flex-wrap: wrap;
        }
        .article-author-info { display: flex; align-items: center; gap: 10px; }
        .article-author-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background: #dc2626; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 800;
        }
        .article-author-name { font-size: 13px; font-weight: 700; color: #111827; }
        .article-author-label { font-size: 12px; color: #9ca3af; }

        .article-author-cta { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn-cta {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 10px 24px; border-radius: 10px;
            font-size: 13px; font-weight: 600; font-family: 'Onest', sans-serif;
            transition: all 0.2s; cursor: pointer;
        }
        .btn-cta--primary { background: #dc2626; color: #fff; border: none; }
        .btn-cta--primary:hover { background: #b91c1c; }
        .btn-cta--outline {
            background: #fff; color: #111827;
            border: 1px solid #e5e7eb;
        }
        .btn-cta--outline:hover { background: #f9fafb; border-color: #d1d5db; }

        /* ── Article Body ──────────────────────────────────── */
        .article-body {
            margin-top: 28px;
            font-size: 16px; line-height: 1.75; color: #1a1a1a;
            max-width: 100%; overflow-wrap: break-word;
        }
        .article-body h2 {
            font-size: 22px; font-weight: 700; margin-top: 2em; margin-bottom: 0.5em;
            color: #111827; padding-bottom: 0.4em; border-bottom: 1px solid #e5e7eb;
        }
        .article-body h3 {
            font-size: 17px; font-weight: 600; margin-top: 1.4em; margin-bottom: 0.4em;
            color: #111827;
        }
        .article-body p { margin-bottom: 1.1em; }
        .article-body ul, .article-body ol { margin-bottom: 1.2em; padding-left: 1.2em; }
        .article-body li { margin-bottom: 0.3em; line-height: 1.6; }
        .article-body strong { font-weight: 600; color: #111827; }
        .article-body blockquote {
            padding: 1em 1.25em; margin: 1.25em 0;
            background: #f5f5f5; border-radius: 10px;
            font-size: 0.95em; color: #6b7280;
            border-left: 3px solid #dc2626;
        }
        .article-body blockquote p { margin-bottom: 0; }
        .article-body .table-wrap {
            overflow-x: auto; margin: 1.25em 0;
            border: 1px solid #e5e7eb; border-radius: 10px;
        }
        .article-body table {
            width: 100%; border-collapse: collapse;
            font-size: 14px; line-height: 1.5;
        }
        .article-body thead th {
            background: #f5f5f5; padding: 10px 14px;
            text-align: left; font-weight: 700; color: #111827;
            border-bottom: 1px solid #e5e7eb;
        }
        .article-body tbody td {
            padding: 8px 14px; border-bottom: 1px solid #f0f0f0;
            color: #374151;
        }
        .article-body tbody tr:last-child td { border-bottom: none; }
        .article-body tbody tr:hover { background: #fafbfc; }
        .article-body tbody td:first-child { font-weight: 600; color: #111827; }
        .article-body img {
            width: 100%; border-radius: 10px;
            margin: 1.25em 0;
        }
        .article-hero-img {
            margin-top: 20px; margin-bottom: 6px;
            border-radius: 12px; overflow: hidden;
        }
        .article-hero-img img {
            width: 100%; aspect-ratio: 16/9; object-fit: cover;
        }
        .article-content-img {
            margin: 1.5em 0; border-radius: 10px; overflow: hidden;
            max-width: 100%;
        }
        .article-content-img img {
            width: 100%; aspect-ratio: 16/9; object-fit: cover;
            margin: 0;
        }
        .article-body a {
            color: #dc2626; text-decoration: underline;
            text-underline-offset: 3px; transition: color 0.2s;
        }
        .article-body a:hover { color: #b91c1c; }

        /* ── Sidebar (domozmsk style) ──────────────────────── */
        .article-sidebar { display: flex; flex-direction: column; gap: 16px; }
        @media (min-width: 960px) { .article-sidebar { position: sticky; top: 24px; height: fit-content; } }

        .sidebar-card {
            background: #fff; border: 1px solid #e6e7ee;
            border-radius: 16px; overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }
        .sidebar-card__header {
            padding: 16px 20px; background: transparent;
            border-bottom: 1px solid #e6e7ee;
            font-size: 14px; font-weight: 700; color: #111827;
        }
        .sidebar-card__body { padding: 12px 14px 16px; }

        .toc-link {
            display: block; padding: 6px 10px; font-size: 12px;
            color: #6b7280; border-radius: 6px;
            transition: all 0.15s; line-height: 1.4; text-decoration: none;
            border-left: 2px solid transparent;
        }
        .toc-link:hover { color: #dc2626; background: #fef2f2; }
        .toc-link.active { color: #dc2626; background: #fef2f2; border-left-color: #dc2626; font-weight: 600; }

        .sidebar-related-item {
            display: flex; gap: 10px; padding: 8px;
            border-radius: 10px; text-decoration: none;
            transition: background 0.2s;
        }
        .sidebar-related-item:hover { background: #f9fafb; }
        .sidebar-related-img {
            width: 84px; height: 64px; border-radius: 8px;
            object-fit: cover; flex-shrink: 0; background: #f5f5f5;
        }
        .sidebar-related-title {
            font-size: 13px; font-weight: 600; line-height: 1.35; color: #111827;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
            transition: color 0.2s;
        }
        .sidebar-related-item:hover .sidebar-related-title { color: #dc2626; }
        .sidebar-related-date { font-size: 11px; color: #9ca3af; margin-top: 3px; }

        .sidebar-cta-gradient {
            border-radius: 16px; overflow: hidden;
            background: linear-gradient(135deg, #dc2626 0%, #7f1d1d 100%);
            padding: 24px; color: #fff;
        }
        .sidebar-cta-gradient__title {
            font-size: 18px; font-weight: 800; color: #fff; margin-bottom: 6px;
        }
        .sidebar-cta-gradient__desc {
            font-size: 13px; color: rgba(255,255,255,0.7); margin-bottom: 16px; line-height: 1.5;
        }
        .sidebar-cta-gradient__btn {
            display: flex; align-items: center; justify-content: center;
            width: 100%; padding: 12px; border-radius: 10px;
            background: #fff; color: #dc2626;
            font-size: 13px; font-weight: 700;
            transition: background 0.2s; text-decoration: none;
        }
        .sidebar-cta-gradient__btn:hover { background: #fef2f2; }
        .sidebar-cta-gradient__btn svg { margin-left: 6px; width: 14px; height: 14px; }

        /* ── CTA Section ───────────────────────────────────── */
        .cta-section {
            margin-top: 40px; padding: 36px;
            background: #f5f5f5; border: 1px solid #e5e7eb;
            border-radius: 14px; text-align: center;
        }
        .cta-section__title {
            font-size: 20px; font-weight: 800; color: #111827; margin: 0 0 8px;
        }
        .cta-section__desc {
            font-size: 14px; line-height: 1.6; color: #6b7280;
            max-width: 480px; margin: 0 auto 20px;
        }
        .cta-section__actions { display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; }

        /* ── Share ─────────────────────────────────────────── */
        .article-share {
            display: flex; align-items: center; gap: 6px;
        }
        .article-share__label {
            font-size: 12px; color: #9ca3af; font-weight: 500;
        }
        .article-share__btn {
            width: 30px; height: 30px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px; border: 1px solid #e5e7eb;
            background: #fff; color: #6b7280; cursor: pointer;
            transition: all 0.2s; padding: 0;
        }
        .article-share__btn svg { width: 14px; height: 14px; }
        .article-share__btn:hover { border-color: #dc2626; color: #dc2626; background: #fef2f2; }
        .article-share__btn.copied { background: #dc2626; color: #fff; border-color: #dc2626; }

        /* ── Author Bio ────────────────────────────────────── */
        .author-bio {
            margin-top: 28px; padding: 20px;
            background: #f5f5f5; border: 1px solid #e5e7eb;
            border-radius: 12px;
            display: flex; align-items: center; gap: 14px;
        }
        .author-bio__avatar {
            width: 48px; height: 48px; border-radius: 50%;
            background: #dc2626; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: 800; flex-shrink: 0;
        }
        .author-bio__name {
            font-size: 14px; font-weight: 700; color: #111827;
        }
        .author-bio__role {
            font-size: 12px; color: #9ca3af; margin-top: 2px;
        }
        .author-bio__desc {
            font-size: 12px; line-height: 1.5; color: #6b7280; margin-top: 4px;
        }

        /* ── Back to Top ───────────────────────────────────── */
        .back-to-top {
            position: fixed; bottom: 24px; right: 24px;
            width: 40px; height: 40px; border-radius: 10px;
            background: #dc2626; color: #fff;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; border: none;
            box-shadow: 0 2px 10px rgba(220,38,38,0.3);
            opacity: 0; visibility: hidden;
            transform: translateY(8px);
            transition: all 0.25s;
            z-index: 100;
        }
        .back-to-top.visible {
            opacity: 1; visibility: visible;
            transform: translateY(0);
        }
        .back-to-top:hover { background: #b91c1c; }
        .back-to-top svg { width: 18px; height: 18px; }

        /* ── Reading Progress ──────────────────────────────── */
        .reading-progress {
            position: fixed; top: 0; left: 0; right: 0;
            height: 2px; z-index: 9999;
        }
        .reading-progress__bar {
            height: 100%; width: 0%;
            background: #dc2626;
            transition: width 0.1s linear;
        }

        @media (max-width: 600px) {
            .article-share { display: none; }
        }
        *:focus-visible { outline: 2px solid #dc2626; outline-offset: 2px; border-radius: 4px; }
    </style>
</head>
<body>

<div class="reading-progress" id="reading-progress"><div class="reading-progress__bar" id="reading-progress-bar"></div></div>

<?php include __DIR__ . '/../components/header-shared.php'; ?>

<main class="py-8 lg:py-20 mb-[5%]">
    <section class="article-py">
        <div class="article-container">

            <!-- Breadcrumbs (Schema.org) -->
            <nav class="breadcrumbs" aria-label="Breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= htmlspecialchars($site['baseUrl']) ?>"><span itemprop="name">Главная</span></a>
                    <meta itemprop="position" content="1">
                </span>
                <span class="breadcrumbs__sep">/</span>
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= htmlspecialchars($site['baseUrl'] . '/blog') ?>"><span itemprop="name">Блог</span></a>
                    <meta itemprop="position" content="2">
                </span>
                <span class="breadcrumbs__sep">/</span>
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span class="breadcrumbs__current" itemprop="name"><?= htmlspecialchars(mb_strimwidth($article['title'], 0, 50, '...')) ?></span>
                    <meta itemprop="position" content="3">
                </span>
            </nav>

            <div class="article-grid">

                <!-- Article Main (8 cols) -->
                <article class="article-main" itemscope itemtype="https://schema.org/BlogPosting">
                    <meta itemprop="datePublished" content="<?= htmlspecialchars($datePublished) ?>">
                    <meta itemprop="dateModified" content="<?= htmlspecialchars($dateModified) ?>">
                    <meta itemprop="author" content="<?= htmlspecialchars($article['author'] ?? $site['company']) ?>">
                    <meta itemprop="articleSection" content="<?= htmlspecialchars($article['category'] ?? '') ?>">

                    <div class="article-meta-row">
                        <div class="article-meta-left">
                            <time datetime="<?= htmlspecialchars($datePublished) ?>">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <?= ozDateArticle($datePublished) ?>
                            </time>
                            <span class="article-meta-sep">·</span>
                            <span class="article-readtime">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <?= $readTime ?> мин чтения
                            </span>
                        </div>
                        <div class="article-share">
                            <button type="button" class="article-share__btn" title="Поделиться" onclick="if(navigator.share){navigator.share({title:'<?= htmlspecialchars($article['title'], ENT_QUOTES) ?>',url:'<?= htmlspecialchars($pageUrl, ENT_QUOTES) ?>'})}else{navigator.clipboard.writeText('<?= htmlspecialchars($pageUrl, ENT_QUOTES) ?>');this.classList.add('copied');setTimeout(()=>this.classList.remove('copied'),1500)}">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                            </button>
                        </div>
                    </div>

                    <h1 class="article-title" itemprop="headline"><?= htmlspecialchars($article['title']) ?></h1>

                    <?php if (!empty($article['excerpt'])): ?>
                    <p class="article-excerpt" itemprop="description"><?= htmlspecialchars($article['excerpt']) ?></p>
                    <?php endif; ?>

                    <div class="article-author-row">
                        <div class="article-author-info">
                            <div class="article-author-avatar"><?= htmlspecialchars(mb_substr($article['author'] ?? $site['company'], 0, 1)) ?></div>
                            <div>
                                <div class="article-author-name"><?= htmlspecialchars($article['author'] ?? $site['company']) ?></div>
                                <div class="article-author-label">Автор</div>
                            </div>
                        </div>
                        <div class="article-author-cta">
                            <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="btn-cta btn-cta--primary">
                                Позвонить
                            </a>
                            <a href="/contacts" class="btn-cta btn-cta--outline">
                                Написать нам
                            </a>
                        </div>
                    </div>

                    <!-- Article Body -->
                    <?php if (!empty($rawImg)): ?>
                    <div class="article-hero-img">
                        <img src="<?= htmlspecialchars($ogImg) ?>" alt="<?= htmlspecialchars($article['title']) ?>" loading="eager">
                    </div>
                    <?php endif; ?>
                    <div class="article-body" id="article-body"><?= $contentHtml ?></div>

                    <!-- Tags -->
                    <?php if (!empty($article['tags'])): ?>
                    <div class="article-tags" style="margin-top:24px;">
                        <?php foreach (array_slice(explode(',', $article['tags']), 0, 3) as $tag):
                            $tag = trim($tag); if ($tag): ?>
                            <a href="#"><?= htmlspecialchars($tag) ?></a>
                        <?php endif; endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Author Bio -->
                    <div class="author-bio">
                        <div class="author-bio__avatar"><?= htmlspecialchars(mb_substr($article['author'] ?? $site['company'], 0, 1)) ?></div>
                        <div>
                            <div class="author-bio__name"><?= htmlspecialchars($article['author'] ?? $site['company']) ?></div>
                            <div class="author-bio__role">Специалист по металлопрокату</div>
                            <div class="author-bio__desc">Пишем экспертные статьи на основе реального опыта работы с металлом.</div>
                        </div>
                    </div>

                </article>

                <!-- Sidebar (4 cols) -->
                <aside class="article-sidebar">

                    <!-- Table of Contents -->
                    <div class="sidebar-card" id="toc-sidebar" style="display:none">
                        <div class="sidebar-card__header">Содержание</div>
                        <div class="sidebar-card__body" id="toc-sidebar-body"></div>
                    </div>

                    <!-- Related Articles -->
                    <?php if (!empty($related)): ?>
                    <div class="sidebar-card">
                        <div class="sidebar-card__header">Читайте также</div>
                        <div class="sidebar-card__body">
                            <?php foreach ($related as $r):
                                $rImg = $r['image'] ?? '/public/assets/images/bgpage/product.png';
                                $rImg = (str_starts_with($rImg, 'http://') || str_starts_with($rImg, 'https://')) ? $rImg : $site['baseUrl'] . $rImg;
                                $rDate = ozDateArticle($r['created_at'] ?? 'now');
                            ?>
                            <a href="<?= htmlspecialchars($site['baseUrl'] . '/blog/' . $r['slug']) ?>" class="sidebar-related-item">
                                <img class="sidebar-related-img" src="<?= htmlspecialchars($rImg) ?>" alt="<?= htmlspecialchars($r['title']) ?>" loading="lazy">
                                <div>
                                    <div class="sidebar-related-title"><?= htmlspecialchars($r['title']) ?></div>
                                    <div class="sidebar-related-date"><?= $rDate ?></div>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- CTA Gradient Card -->
                    <div class="sidebar-cta-gradient">
                        <div class="sidebar-cta-gradient__title">Расчёт стоимости</div>
                        <div class="sidebar-cta-gradient__desc">Ответим за 5 минут · Бесплатно</div>
                        <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="sidebar-cta-gradient__btn">
                            Позвонить: <?= htmlspecialchars($site['phone'] ?? '+7 (495) 989-24-20') ?>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                </aside>
            </div>

            <!-- CTA -->
            <div class="cta-section">
                <div class="cta-section__title">Нужна консультация по закупке металла?</div>
                <p class="cta-section__desc">Позвоните или напишите — подберём оптимальный сорт, рассчитаем вес и стоимость.</p>
                <div class="cta-section__actions">
                    <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="btn-cta btn-cta--primary">Позвонить: <?= htmlspecialchars($site['phone'] ?? '+7 (495) 989-24-20') ?></a>
                    <a href="/contacts" class="btn-cta btn-cta--outline">Написать нам</a>
                </div>
            </div>
        </div>
    </section>
</main>

<button class="back-to-top" id="back-to-top" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
</button>

<?php include_once __DIR__ . '/../components/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var articleBody = document.getElementById('article-body');
    var tocSidebar = document.getElementById('toc-sidebar');
    var tocBody = document.getElementById('toc-sidebar-body');

    if (articleBody) {
        var h2s = articleBody.querySelectorAll('h2');
        if (h2s.length >= 2 && tocSidebar && tocBody) {
            tocSidebar.style.display = '';
            h2s.forEach(function(h2, i) {
                var id = 'section-' + i;
                h2.id = id;
                var link = document.createElement('a');
                link.href = '#' + id;
                link.className = 'toc-link';
                link.textContent = h2.textContent;
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    h2.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    history.pushState(null, '', '#' + id);
                });
                tocBody.appendChild(link);
            });

            var tocLinks = tocBody.querySelectorAll('.toc-link');
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        tocLinks.forEach(function(l) { l.classList.remove('active'); });
                        var idx = Array.prototype.indexOf.call(h2s, entry.target);
                        if (tocLinks[idx]) tocLinks[idx].classList.add('active');
                    }
                });
            }, { rootMargin: '-80px 0px -60% 0px', threshold: 0 });
            h2s.forEach(function(h2) { observer.observe(h2); });
        } else {
            h2s.forEach(function(h2, i) { h2.id = 'section-' + i; });
        }
    }

    var progressBar = document.getElementById('reading-progress-bar');
    if (progressBar) {
        window.addEventListener('scroll', function() {
            var scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
            var scrolled = (window.scrollY / scrollHeight) * 100;
            progressBar.style.width = Math.min(scrolled, 100) + '%';
        }, { passive: true });
    }

    var backToTop = document.getElementById('back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 400) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        }, { passive: true });
    }
});
</script>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": <?= json_encode($article['title'], JSON_UNESCAPED_UNICODE) ?>,
    "description": <?= json_encode($article['metaDescription'] ?? $article['excerpt'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
    "image": <?= json_encode($ogImg, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
    "author": { "@type": "Organization", "name": <?= json_encode($article['author'] ?? $site['company'], JSON_UNESCAPED_UNICODE) ?> },
    "publisher": {
        "@type": "Organization",
        "name": <?= json_encode($site['company'], JSON_UNESCAPED_UNICODE) ?>,
        "logo": { "@type": "ImageObject", "url": <?= json_encode($site['baseUrl'] . '/public/assets/images/icons/favicon/favicon.svg', JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?> }
    },
    "datePublished": <?= json_encode($datePublished, JSON_UNESCAPED_UNICODE) ?>,
    "dateModified": <?= json_encode($dateModified, JSON_UNESCAPED_UNICODE) ?>,
    "url": <?= json_encode($pageUrl, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
}
</script>
</body>
</html>
