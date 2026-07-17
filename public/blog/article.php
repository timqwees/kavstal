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

$img = $article['image'] ?? '/public/assets/images/bgpage/product.png';
    $ogImg = (str_starts_with($img, 'http')) ? $img : $site['baseUrl'] . $img;
    $pageUrl = $site['baseUrl'] . '/blog/' . htmlspecialchars($article['slug']);
    $pageTitle = $article['title'] . ' | Блог КАВ СТАЛЬ';
    $pageDescription = $article['metaDescription'] ?? $article['excerpt'] ?? '';
    $datePublished = $article['created_at'] ?? '';
    $dateModified = $article['updated_at'] ?? $datePublished;

// Простой рендер контента (markdown-lite)
function renderContent(string $text): string
{
    $html = '';
    $blocks = preg_split('/\n\n+/', $text);
    foreach ($blocks as $block) {
        $block = trim($block);
        if ($block === '') continue;
        if (preg_match('/^##\s+(.+)$/u', $block, $m)) {
            $html .= '<h2 class="text-2xl font-bold text-zinc-900 mt-8 mb-4">' . htmlspecialchars($m[1]) . '</h2>';
        } elseif (preg_match('/^###\s+(.+)$/u', $block, $m)) {
            $html .= '<h3 class="text-xl font-semibold text-zinc-900 mt-6 mb-3">' . htmlspecialchars($m[1]) . '</h3>';
        } elseif (preg_match('/^\|(.+)\|$/mu', $block) && substr_count($block, '|') > 1) {
            // Таблица (примитивно)
            $lines = array_filter(explode("\n", $block), 'trim');
            $html .= '<div class="overflow-x-auto my-4"><table class="min-w-full border border-zinc-200 text-sm">';
            $first = true;
            foreach ($lines as $line) {
                $cells = array_map('trim', explode('|', trim($line, '|')));
                $html .= $first ? '<thead><tr class="bg-zinc-100">' : '<tr>';
                foreach ($cells as $c) {
                    if ($first) $html .= '<th class="border px-3 py-2 text-left">' . htmlspecialchars($c) . '</th>';
                    else $html .= '<td class="border px-3 py-2">' . htmlspecialchars($c) . '</td>';
                }
                $html .= $first ? '</tr></thead>' : '</tr>';
                if ($first) { $first = false; }
            }
            $html .= '</table></div>';
        } elseif (preg_match('/^[-*]\s+/mu', $block)) {
            $html .= '<ul class="list-disc pl-6 my-3 space-y-1 text-zinc-700">';
            foreach (explode("\n", $block) as $li) {
                $li = trim(preg_replace('/^[-*]\s+/u', '', $li));
                if ($li !== '') $html .= '<li>' . htmlspecialchars($li) . '</li>';
            }
            $html .= '</ul>';
        } else {
            $html .= '<p class="my-3 text-zinc-700 leading-relaxed">' . nl2br(htmlspecialchars($block)) . '</p>';
        }
    }
    return $html;
}
$contentHtml = renderContent($article['content'] ?? '');

// Похожие статьи (та же категория)
$related = array_filter($articles, function ($a) use ($article, $slug) {
    return ($a['slug'] ?? '') !== $slug && ($a['category'] ?? '') === ($article['category'] ?? '');
});
$related = array_slice(array_values($related), 0, 3);
if (count($related) < 3) {
    foreach ($articles as $a) {
        if (($a['slug'] ?? '') !== $slug && count($related) < 3 && !in_array($a, $related, true)) $related[] = $a;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($article['tags'] ?? '') ?>">
    <link rel="canonical" href="<?= htmlspecialchars($pageUrl) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($article['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= htmlspecialchars($pageUrl) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company']) ?>">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="<?= htmlspecialchars($ogImg) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($article['title']) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImg) ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= htmlspecialchars($article['author'] ?? $site['company']) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <?php include_once __DIR__ . '/../components/seo-head.php'; ?>
</head>
<body class="bg-zinc-50 text-zinc-900">

<?php include __DIR__ . '/../components/header-shared.php'; ?>

<main class="max-w-3xl mx-auto px-4 py-8">
    <nav class="flex items-center space-x-1.5 text-sm mb-6" aria-label="Breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
        <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="<?= htmlspecialchars($site['baseUrl']) ?>" itemprop="item" class="text-zinc-500 hover:text-red-500"><span itemprop="name">Главная</span></a>
            <meta itemprop="position" content="1">
        </span>
        <span class="text-zinc-300">/</span>
        <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="<?= htmlspecialchars($site['baseUrl']) ?>/blog" itemprop="item" class="text-zinc-500 hover:text-red-500"><span itemprop="name">Блог</span></a>
            <meta itemprop="position" content="2">
        </span>
        <span class="text-zinc-300">/</span>
        <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <span itemprop="name" class="text-zinc-700 font-medium"><?= htmlspecialchars($article['title']) ?></span>
            <meta itemprop="position" content="3">
        </span>
    </nav>

    <article itemscope itemtype="https://schema.org/BlogPosting">
        <div class="flex items-center gap-2 text-xs text-zinc-500 mb-3">
            <span class="bg-red-50 text-red-600 px-2 py-0.5 rounded"><?= htmlspecialchars($article['category'] ?? 'Статья') ?></span>
            <time datetime="<?= htmlspecialchars($datePublished) ?>" itemprop="datePublished"><?= htmlspecialchars(date('d.m.Y', strtotime($datePublished))) ?></time>
            <meta itemprop="dateModified" content="<?= htmlspecialchars($dateModified) ?>">
        </div>
        <h1 class="text-3xl font-bold text-zinc-900 mb-4" itemprop="headline"><?= htmlspecialchars($article['title']) ?></h1>
        <meta itemprop="author" content="<?= htmlspecialchars($article['author'] ?? $site['company']) ?>">
        <meta itemprop="publisher" content="<?= htmlspecialchars($site['company']) ?>">
        <img src="<?= htmlspecialchars($ogImg) ?>" alt="<?= htmlspecialchars($article['title']) ?>" width="800" height="450" itemprop="image" class="w-full rounded-xl mb-6 object-cover">
        <div itemprop="articleBody">
            <?= $contentHtml ?>
        </div>
    </article>

    <?php if (!empty($related)): ?>
    <section class="mt-12 border-t border-zinc-200 pt-8">
        <h2 class="text-xl font-bold text-zinc-900 mb-5">Похожие статьи</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <?php foreach ($related as $r): ?>
            <a href="<?= htmlspecialchars($site['baseUrl'] . '/blog/' . $r['slug']) ?>" class="block bg-white rounded-lg border border-zinc-100 overflow-hidden hover:shadow-md transition-shadow">
                <img src="<?= htmlspecialchars($site['baseUrl'] . ($r['image'] ?? '/public/assets/images/bgpage/product.png')) ?>" alt="<?= htmlspecialchars($r['title']) ?>" loading="lazy" width="300" height="180" class="w-full h-32 object-cover">
                <div class="p-3">
                    <h3 class="text-sm font-semibold text-zinc-900 leading-snug hover:text-red-500"><?= htmlspecialchars($r['title']) ?></h3>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": <?= json_encode($article['title'], JSON_UNESCAPED_UNICODE); ?>,
    "alternativeHeadline": <?= json_encode($article['metaDescription'] ?? '', JSON_UNESCAPED_UNICODE); ?>,
    "url": <?= json_encode($pageUrl, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
    "datePublished": <?= json_encode($datePublished, JSON_UNESCAPED_UNICODE); ?>,
    "dateModified": <?= json_encode($dateModified, JSON_UNESCAPED_UNICODE); ?>,
    "author": { "@type": "Organization", "name": <?= json_encode($article['author'] ?? $site['company'], JSON_UNESCAPED_UNICODE); ?> },
    "publisher": {
        "@type": "Organization",
        "name": <?= json_encode($site['company'], JSON_UNESCAPED_UNICODE); ?>,
        "logo": { "@type": "ImageObject", "url": <?= json_encode($site['baseUrl'] . '/public/assets/images/icons/favicon/favicon.svg', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?> }
    },
    "image": <?= json_encode($ogImg, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
    "description": <?= json_encode($pageDescription, JSON_UNESCAPED_UNICODE); ?>,
    "mainEntityOfPage": { "@type": "WebPage", "@id": <?= json_encode($pageUrl, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?> }
}
</script>

</body>
</html>
