<?php
$site = Setting\route\function\Functions::site();
$articlesFile = __DIR__ . '/data/articles.json';
$articles = [];
if (file_exists($articlesFile)) {
    $articles = json_decode(file_get_contents($articlesFile), true) ?? [];
}
// Сортируем по дате (новые сверху)
usort($articles, function ($a, $b) {
    return strtotime($b['created_at'] ?? '0') <=> strtotime($a['created_at'] ?? '0');
});

$pageTitle = 'Блог о металлопрокате — статьи, ГОСТ, расчёты | КАВ СТАЛЬ';
$pageDescription = 'Полезные статьи о металлопрокате: виды арматуры и балки, ГОСТ, таблицы веса, резка и доставка. Экспертные советы от металлобазы КАВ СТАЛЬ.';
$pageUrl = $site['baseUrl'] . '/blog';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords" content="металлопрокат, блог, арматура, балка, труба, ГОСТ, вес металла, статьи">
    <link rel="canonical" href="<?= htmlspecialchars($pageUrl) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($pageUrl) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company']) ?>">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="<?= htmlspecialchars($site['baseUrl'] . '/public/assets/images/bgpage/market.png') ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($site['baseUrl'] . '/public/assets/images/bgpage/market.png') ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= htmlspecialchars($site['company']) ?>">
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

<main class="max-w-7xl mx-auto px-4 py-8">
    <nav class="flex items-center space-x-1.5 text-sm mb-6" aria-label="Breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
        <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="<?= htmlspecialchars($site['baseUrl']) ?>" itemprop="item" class="text-zinc-500 hover:text-red-500"><span itemprop="name">Главная</span></a>
            <meta itemprop="position" content="1">
        </span>
        <span class="text-zinc-300">/</span>
        <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <span itemprop="name" class="text-zinc-700 font-medium">Блог</span>
            <meta itemprop="position" content="2">
        </span>
    </nav>

    <h1 class="text-3xl font-bold text-zinc-900 mb-2">Блог о металлопрокате</h1>
    <p class="text-zinc-600 mb-8 max-w-3xl">Экспертные статьи о видах металлопроката, ГОСТ, расчёте веса, резке и доставке. Помогаем выбрать правильный металл для стройки и производства.</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($articles as $article):
            $url = $site['baseUrl'] . '/blog/' . htmlspecialchars($article['slug']);
            $img = $article['image'] ?? '/public/assets/images/bgpage/product.png';
            $date = date('d.m.Y', strtotime($article['created_at'] ?? 'now'));
        ?>
        <article class="bg-white rounded-xl overflow-hidden shadow-sm border border-zinc-100 hover:shadow-md transition-shadow" itemscope itemtype="https://schema.org/BlogPosting">
            <a href="<?= htmlspecialchars($url) ?>" class="block">
                <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($article['title']) ?>" loading="lazy" width="400" height="250" class="w-full h-48 object-cover">
            </a>
            <div class="p-5">
                <div class="flex items-center gap-2 text-xs text-zinc-500 mb-2">
                    <span class="bg-red-50 text-red-600 px-2 py-0.5 rounded"><?= htmlspecialchars($article['category'] ?? 'Статья') ?></span>
                    <time datetime="<?= htmlspecialchars($article['created_at'] ?? '') ?>" itemprop="datePublished"><?= htmlspecialchars($date) ?></time>
                </div>
                <h2 class="text-lg font-semibold text-zinc-900 mb-2 leading-snug">
                    <a href="<?= htmlspecialchars($url) ?>" itemprop="headline" class="hover:text-red-500"><?= htmlspecialchars($article['title']) ?></a>
                </h2>
                <p class="text-sm text-zinc-600 line-clamp-3" itemprop="description"><?= htmlspecialchars($article['excerpt'] ?? '') ?></p>
                <a href="<?= htmlspecialchars($url) ?>" class="inline-block mt-3 text-red-500 font-medium text-sm hover:underline">Читать далее →</a>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Blog",
    "name": "Блог КАВ СТАЛЬ о металлопрокате",
    "url": <?= json_encode($pageUrl, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
    "description": <?= json_encode($pageDescription, JSON_UNESCAPED_UNICODE); ?>,
    "publisher": {
        "@type": "Organization",
        "name": <?= json_encode($site['company'], JSON_UNESCAPED_UNICODE); ?>,
        "logo": {
            "@type": "ImageObject",
            "url": <?= json_encode($site['baseUrl'] . '/public/assets/images/icons/favicon/favicon.svg', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
        }
    },
    "blogPost": [
        <?php foreach ($articles as $i => $article): ?>
        {
            "@type": "BlogPosting",
            "headline": <?= json_encode($article['title'], JSON_UNESCAPED_UNICODE); ?>,
            "url": <?= json_encode($site['baseUrl'] . '/blog/' . $article['slug'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
            "datePublished": <?= json_encode($article['created_at'] ?? '', JSON_UNESCAPED_UNICODE); ?>,
            "dateModified": <?= json_encode($article['updated_at'] ?? $article['created_at'] ?? '', JSON_UNESCAPED_UNICODE); ?>,
            "author": { "@type": "Organization", "name": <?= json_encode($article['author'] ?? $site['company'], JSON_UNESCAPED_UNICODE); ?> }
        }<?= $i < count($articles) - 1 ? ',' : '' ?>
        <?php endforeach; ?>
    ]
}
</script>

</body>
</html>
