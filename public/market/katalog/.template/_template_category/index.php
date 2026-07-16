<?php
$allProducts = Setting\route\function\Functions::listProducts();
$site = Setting\route\function\Functions::site();

$categoryID = $katalog ?? '';

$categoryInfo = null;
foreach ($allProducts as $p) {
    if (($p['badge'] ?? '') === 'Категория' && ($p['id'] ?? '') === $categoryID) {
        $categoryInfo = $p;
        break;
    }
}

$allCategoryProducts = array_filter($allProducts, function ($p) use ($categoryID) {
    $parentId = $p['categories']['parent_id'] ?? '';
    return $parentId === $categoryID && empty($p['badge']);
});
$allCategoryProducts = array_values($allCategoryProducts);

$allDiameters = [];
$allBrands = [];
$allGosts = [];
foreach ($allCategoryProducts as $p) {
    $specs = $p['specs'] ?? [];
    if (!empty($specs['диаметр'])) $allDiameters[] = $specs['диаметр'];
    $brand = $specs['Марка'] ?? $specs['марка'] ?? '';
    if (!empty($brand)) $allBrands[] = $brand;
    $gost = $specs['ГОСТ'] ?? $specs['гост'] ?? '';
    if (!empty($gost)) $allGosts[] = $gost;
}
$allDiameters = array_values(array_unique(array_filter($allDiameters)));
$allBrands = array_values(array_unique(array_filter($allBrands)));
$allGosts = array_values(array_unique(array_filter($allGosts)));
sort($allDiameters, SORT_NATURAL);
sort($allBrands, SORT_STRING);
sort($allGosts, SORT_NATURAL);

$categoryTree = [];
foreach ($allProducts as $p) {
    if (($p['badge'] ?? '') === 'Категория') {
        $categoryTree[] = $p;
    }
}

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 24;
$totalItems = count($allCategoryProducts);
$totalPages = max(1, (int)ceil($totalItems / $itemsPerPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $itemsPerPage;
$pageProducts = array_slice($allCategoryProducts, $offset, $itemsPerPage);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($categoryInfo['title'] ?? 'Категория') ?> – цены, сортамент, характеристики | КАВ СТАЛЬ</title>
    <meta name="description" content="<?= htmlspecialchars($categoryInfo['description'] ?? ($categoryInfo['title'] ?? 'Категория') . ' - купить в Москве по выгодной цене. Поставка металлопроката от КАВ СТАЛЬ.') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($categoryInfo['title'] ?? 'Категория') ?>, металлопрокат, купить <?= htmlspecialchars($categoryInfo['title'] ?? 'Категория') ?> в Москве, цена, доставка">
    <link rel="canonical" href="<?= $site['baseUrl'] ?><?= htmlspecialchars($categoryInfo['seo']['canonicalUrl'] ?? '/market') ?>">

    <meta property="og:title" content="<?= htmlspecialchars($categoryInfo['title'] ?? 'Категория') ?> – цены | КАВ СТАЛЬ">
    <meta property="og:description" content="<?= htmlspecialchars($categoryInfo['description'] ?? $categoryInfo['title'] ?? 'Категория') ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $site['baseUrl'] ?><?= htmlspecialchars($categoryInfo['seo']['canonicalUrl'] ?? '/market') ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company']) ?>">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="<?= $site['baseUrl'] ?>/public/assets/images/bgpage/market.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($categoryInfo['title'] ?? 'Категория') ?> – КАВ СТАЛЬ">
    <meta name="twitter:description" content="<?= htmlspecialchars($categoryInfo['description'] ?? $categoryInfo['title'] ?? 'Категория') ?>">
    <meta name="twitter:image" content="<?= $site['baseUrl'] ?>/public/assets/images/bgpage/market.png">
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= htmlspecialchars($site['company']) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="<?= $site['baseUrl'] ?>" crossorigin>

    <link rel="icon" type="image/png" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon.svg">
    <link rel="shortcut icon" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/apple-touch-icon.png">
    <meta name="apple-mobile-web-app-title" content="Металл">
    <link rel="manifest" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/site.webmanifest">
    <link rel="alternate" type="application/rss+xml" title="КАВ СТАЛЬ" href="<?= $site['baseUrl'] ?>/rss.xml">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": <?= json_encode($categoryInfo['title'] ?? 'Категория', JSON_UNESCAPED_UNICODE); ?>,
        "description": <?= json_encode($categoryInfo['description'] ?? $categoryInfo['title'] ?? '', JSON_UNESCAPED_UNICODE); ?>,
        "url": <?= json_encode($site['baseUrl'] . ($categoryInfo['seo']['canonicalUrl'] ?? '/market'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
    }
    </script>

    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>

    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <script src="/public/assets/scripts/components/search.min.js" defer></script>
    <script src="/public/assets/scripts/components/cart-favorites.min.js" defer></script>

    <link rel="preload" href="/public/assets/styles/catalog.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="/public/assets/styles/catalog.min.css"></noscript>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>

<body class="bg-zinc-50">

    <?php include_once './public/components/header-shared.php'; ?>

    <main class="max-w-7xl mx-auto px-4 pt-4 pb-12 lg:pt-6">

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-1.5 text-sm mb-6" aria-label="Breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <a href="/" class="inline-flex items-center text-zinc-500 hover:text-red-600 transition-colors" itemprop="item" itemscope itemtype="https://schema.org/Thing" itemid="<?= $site['baseUrl'] ?>/">
                <svg class="me-1.5 h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/></svg>
                <span itemprop="name">Главная</span>
            </a>
            <meta itemprop="position" content="1">
            <svg class="h-4 w-4 text-zinc-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>

            <a href="/market" class="text-zinc-500 hover:text-red-600 transition-colors" itemprop="item" itemscope itemtype="https://schema.org/Thing" itemid="<?= $site['baseUrl'] ?>/market">
                <span itemprop="name">Каталог</span>
            </a>
            <meta itemprop="position" content="2">
            <svg class="h-4 w-4 text-zinc-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>

            <?php
            $parentTitle = $categoryInfo['categories']['title'] ?? null;
            if ($parentTitle):
            ?>
            <a href="/market/katalog/<?= htmlspecialchars($katalog) ?>" class="text-zinc-500 hover:text-red-600 transition-colors" itemprop="item" itemscope itemtype="https://schema.org/Thing" itemid="<?= $site['baseUrl'] ?>/market/katalog/<?= htmlspecialchars($katalog) ?>">
                <span itemprop="name"><?= htmlspecialchars($parentTitle) ?></span>
            </a>
            <meta itemprop="position" content="3">
            <svg class="h-4 w-4 text-zinc-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
            <?php endif; ?>

            <span class="text-zinc-900 font-medium" itemprop="name"><?= htmlspecialchars($categoryInfo['title'] ?? 'Категория') ?></span>
            <meta itemprop="position" content="<?= $parentTitle ? '4' : '3' ?>">
        </nav>

        <!-- Two-Column Layout -->
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">

            <!-- Left Sidebar -->
            <aside class="w-full lg:w-64 shrink-0">
                <div class="lg:sticky lg:top-24 space-y-5">

                    <!-- Categories (unified list) -->
                    <div class="bg-white rounded-xl border border-zinc-200 overflow-hidden">
                        <div class="px-4 py-3 bg-zinc-50 border-b border-zinc-200">
                            <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Категории</h3>
                        </div>
                        <nav class="p-2 space-y-0.5 max-h-64 overflow-y-auto">
                            <?php foreach ($categoryTree as $cat):
                                $isActive = ($cat['id'] === $categoryID);
                                $catUrl = $cat['seo']['canonicalUrl'] ?? '#';
                            ?>
                            <a href="<?= htmlspecialchars($catUrl) ?>"
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition <?= $isActive ? 'bg-red-50 text-red-600 font-semibold' : 'text-zinc-600 hover:text-red-600 hover:bg-zinc-50' ?>">
                                <i class="fas fa-folder-open text-xs w-4 <?= $isActive ? 'text-red-400' : 'text-zinc-300' ?>"></i>
                                <span class="truncate"><?= htmlspecialchars($cat['title']) ?></span>
                            </a>
                            <?php endforeach; ?>
                        </nav>
                    </div>

                    <!-- Filter: Diameter -->
                    <?php if (!empty($allDiameters)): ?>
                    <div class="bg-white rounded-xl border border-zinc-200 overflow-hidden">
                        <div class="px-4 py-3 bg-zinc-50 border-b border-zinc-200">
                            <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Диаметр</h3>
                        </div>
                        <div class="p-3 max-h-52 overflow-y-auto space-y-1">
                            <?php foreach ($allDiameters as $d): ?>
                            <label class="flex items-center gap-2 cursor-pointer group px-2 py-1 rounded-md hover:bg-zinc-50 transition">
                                <input type="checkbox" class="filter-checkbox rounded border-zinc-300 text-red-600 focus:ring-red-500 w-4 h-4" data-filter="diameter" value="<?= htmlspecialchars($d) ?>">
                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 transition"><?= htmlspecialchars($d) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Filter: Brand -->
                    <?php if (!empty($allBrands)): ?>
                    <div class="bg-white rounded-xl border border-zinc-200 overflow-hidden">
                        <div class="px-4 py-3 bg-zinc-50 border-b border-zinc-200">
                            <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Марка стали</h3>
                        </div>
                        <div class="p-3 max-h-52 overflow-y-auto space-y-1">
                            <?php foreach ($allBrands as $b): ?>
                            <label class="flex items-center gap-2 cursor-pointer group px-2 py-1 rounded-md hover:bg-zinc-50 transition">
                                <input type="checkbox" class="filter-checkbox rounded border-zinc-300 text-red-600 focus:ring-red-500 w-4 h-4" data-filter="brand" value="<?= htmlspecialchars($b) ?>">
                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 transition"><?= htmlspecialchars($b) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Filter: GOST -->
                    <?php if (!empty($allGosts)): ?>
                    <div class="bg-white rounded-xl border border-zinc-200 overflow-hidden">
                        <div class="px-4 py-3 bg-zinc-50 border-b border-zinc-200">
                            <h3 class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">ГОСТ</h3>
                        </div>
                        <div class="p-3 max-h-52 overflow-y-auto space-y-1">
                            <?php foreach ($allGosts as $g): ?>
                            <label class="flex items-center gap-2 cursor-pointer group px-2 py-1 rounded-md hover:bg-zinc-50 transition">
                                <input type="checkbox" class="filter-checkbox rounded border-zinc-300 text-red-600 focus:ring-red-500 w-4 h-4" data-filter="gost" value="<?= htmlspecialchars($g) ?>">
                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 transition"><?= htmlspecialchars($g) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </aside>

            <!-- Content Area -->
            <div class="flex-1 min-w-0">

                <!-- Header -->
                <div class="mb-5">
                    <h1 class="text-2xl lg:text-3xl font-bold text-zinc-900 mb-2">
                        <?= htmlspecialchars($categoryInfo['title'] ?? 'Категория') ?> – купить в Москве
                    </h1>
                    <?php if (!empty($categoryInfo['description'])): ?>
                    <p class="text-zinc-500 text-sm leading-relaxed max-w-2xl"><?= htmlspecialchars($categoryInfo['description']) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Toolbar -->
                <div class="flex items-center justify-between gap-3 mb-5 bg-white rounded-xl border border-zinc-200 px-4 py-3">
                    <p class="text-sm text-zinc-500">
                        Найдено: <span class="font-semibold text-zinc-800" id="visibleCount"><?= count($pageProducts) ?></span> товаров
                    </p>
                    <div class="flex items-center gap-1 bg-zinc-100 rounded-lg p-0.5">
                        <button id="grid-view" class="flex items-center justify-center rounded-md bg-white text-red-600 p-2 shadow-sm transition-colors" title="Сетка">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z"/></svg>
                        </button>
                        <button id="list-view" class="flex items-center justify-center rounded-md border border-zinc-200 bg-white p-2 text-zinc-600 hover:text-red-600 transition-colors" title="Список">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Product Grid -->
                <?php if (!empty($pageProducts)): ?>
                <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
                    <?php foreach ($pageProducts as $item):
                        $productImages = $item['images'] ?? [];
                        if (empty($productImages)) $productImages = [$site['baseUrl'] . '/public/assets/images/unknown/unknown.png'];
                        $specs = $item['specs'] ?? [];
                        $units = $item['units'] ?? [];
                        $inStock = $item['in_stock'] ?? false;
                        $canonicalUrl = $item['seo']['canonicalUrl'] ?? '#';
                        $productUrl = htmlspecialchars($canonicalUrl);
                        $productName = htmlspecialchars($item['name'] ?? $item['title'] ?? 'Товар');
                        $firstUnit = !empty($units) ? array_key_first($units) : '';
                        $firstPrice = !empty($units) ? $units[$firstUnit] : 0;

                        $diameter = $specs['диаметр'] ?? '';
                        $brand = $specs['Марка'] ?? $specs['марка'] ?? '';
                        $gost = $specs['ГОСТ'] ?? $specs['гост'] ?? '';
                        $razmer = $specs['Размер'] ?? '';
                    ?>
                    <div class="product-card bg-white rounded-xl border border-zinc-200 overflow-hidden hover:shadow-lg transition-all duration-200 flex flex-col"
                         data-diameter="<?= htmlspecialchars($diameter) ?>"
                         data-brand="<?= htmlspecialchars($brand) ?>"
                         data-gost="<?= htmlspecialchars($gost) ?>">

                        <!-- Image -->
                        <a href="<?= $productUrl ?>" class="product-card-image block aspect-square bg-zinc-100 relative overflow-hidden group">
                            <?php if (count($productImages) > 1): ?>
                            <div class="swiper product-swiper w-full h-full" data-product-id="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                <div class="swiper-wrapper">
                                    <?php foreach ($productImages as $imgIdx => $imgUrl): ?>
                                    <div class="swiper-slide flex justify-center items-center bg-zinc-100">
                                        <img loading="lazy" src="<?= htmlspecialchars($imgUrl) ?>" alt="<?= $productName ?> - фото <?= $imgIdx + 1 ?>" class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <?php else: ?>
                            <img loading="lazy" src="<?= htmlspecialchars($productImages[0]) ?>" alt="<?= $productName ?>" class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-300">
                            <?php endif; ?>

                            <!-- Availability Badge -->
                            <?php if ($inStock): ?>
                            <span class="absolute top-2 left-2 bg-emerald-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1 shadow-sm">
                                <i class="fas fa-check-circle text-[8px]"></i> В наличии
                            </span>
                            <?php else: ?>
                            <span class="absolute top-2 left-2 bg-zinc-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1 shadow-sm">
                                <i class="fas fa-clock text-[8px]"></i> Под заказ
                            </span>
                            <?php endif; ?>

                            <!-- Favorites -->
                            <button type="button" class="add-to-fav-btn absolute top-2 right-2 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm border border-zinc-200 flex items-center justify-center shadow-sm hover:border-zinc-400 hover:bg-white transition-all" data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>" title="В избранное">
                                <svg width="14" height="12" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 10.01l-5.657 3.14a.584.584 0 0 1-.779-.205.54.54 0 0 1-.076-.277V3.61c0-.295.12-.577.335-.786A1.16 1.16 0 0 1 1.843 2.5c.922 0 1.823.435 2.657 1.268a.88.88 0 0 1 .082 1.067c-.47.722-1.285 1.333-2.018 1.626a.88.88 0 0 1-1.134 0L6.5 1.01V10.01z" stroke="#a1a1aa" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </a>

                        <!-- Info -->
                        <div class="p-4 flex flex-col flex-1">
                            <a href="<?= $productUrl ?>">
                                <h3 class="text-sm font-semibold text-zinc-900 hover:text-red-600 transition leading-snug mb-2 line-clamp-2 min-h-[36px]"><?= $productName ?></h3>
                            </a>

                            <!-- Specs Tags -->
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                <?php if ($brand): ?>
                                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 text-[10px] px-2 py-0.5 rounded-full font-medium"><?= htmlspecialchars($brand) ?></span>
                                <?php endif; ?>
                                <?php if ($razmer): ?>
                                <span class="inline-flex items-center gap-1 bg-zinc-100 text-zinc-600 text-[10px] px-2 py-0.5 rounded-full font-medium"><?= htmlspecialchars($razmer) ?></span>
                                <?php endif; ?>
                                <?php if ($gost): ?>
                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] px-2 py-0.5 rounded-full font-medium"><?= htmlspecialchars($gost) ?></span>
                                <?php endif; ?>
                                <?php if ($diameter): ?>
                                <span class="inline-flex items-center gap-1 bg-zinc-100 text-zinc-600 text-[10px] px-2 py-0.5 rounded-full font-medium">Ø <?= htmlspecialchars($diameter) ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="flex-1"></div>

                            <!-- Price -->
                            <?php if (!empty($units)): ?>
                            <div class="mb-3" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                <meta itemprop="priceCurrency" content="RUB">
                                <meta itemprop="availability" content="<?= $inStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' ?>">
                                <div itemprop="price" content="<?= number_format($firstPrice, 0, '', '') ?>" class="price-display text-xl font-bold text-zinc-900 leading-tight">
                                    <?= number_format($firstPrice, 0, '', ' ') ?> <span class="text-sm font-normal text-zinc-500">₽</span>
                                </div>
                                <div class="flex gap-0.5 mt-1.5">
                                    <?php foreach ($units as $unit => $price): ?>
                                    <button type="button"
                                        class="unit-btn text-[10px] px-2 py-0.5 rounded-md font-medium transition-all <?= $unit === $firstUnit ? 'bg-red-100 text-red-800' : 'bg-zinc-100 text-zinc-500 hover:bg-red-50 hover:text-red-700' ?>"
                                        data-unit="<?= htmlspecialchars($unit) ?>" data-price="<?= htmlspecialchars($price) ?>">
                                        <?= htmlspecialchars($unit) ?>
                                    </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="text-sm text-zinc-400 mb-3">Цена по запросу</div>
                            <?php endif; ?>

                            <!-- Add to Cart -->
                            <div class="flex items-center gap-2" data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                <input type="number" value="1" min="1"
                                    class="cart-qty w-14 h-9 text-center border border-zinc-200 rounded-lg text-sm focus:outline-none focus:border-red-400"
                                    data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                <?php if (count($units) > 1): ?>
                                <select class="cart-unit h-9 px-2 border border-zinc-200 rounded-lg text-xs bg-white focus:outline-none focus:border-red-400"
                                    data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                    <?php foreach ($units as $u => $p): ?>
                                    <option value="<?= htmlspecialchars($u) ?>" <?= $u === $firstUnit ? 'selected' : '' ?>><?= htmlspecialchars($u) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php else: ?>
                                <span class="text-xs text-zinc-400 w-9 shrink-0"><?= htmlspecialchars($firstUnit) ?></span>
                                <?php endif; ?>
                                <button type="button"
                                    class="add-to-cart-btn flex-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold py-2 px-3 rounded-lg transition flex items-center justify-center gap-1.5"
                                    data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>"
                                    data-unit="<?= htmlspecialchars($firstUnit) ?>">
                                    <i class="fas fa-shopping-cart text-[10px]"></i> В корзину
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <div class="mt-8 flex justify-center">
                    <nav class="inline-flex items-center gap-1" aria-label="Pagination">
                        <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>" class="inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 hover:text-zinc-700 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/></svg>
                        </a>
                        <?php endif; ?>
                        <?php
                        $range = 2;
                        $showPages = [1];
                        for ($i = max(2, $page - $range); $i <= min($totalPages - 1, $page + $range); $i++) $showPages[] = $i;
                        if ($totalPages > 1) $showPages[] = $totalPages;
                        $showPages = array_unique($showPages);
                        sort($showPages);
                        $prevPage = 0;
                        foreach ($showPages as $i):
                            if ($prevPage > 0 && $i > $prevPage + 1):
                        ?>
                        <span class="px-1.5 text-sm text-zinc-400">...</span>
                        <?php endif; $prevPage = $i; $active = $i === $page; ?>
                        <a href="?page=<?= $i ?>" class="<?= $active ? 'bg-red-600 text-white border-red-600 shadow-sm' : 'border border-zinc-200 bg-white text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900' ?> inline-flex items-center justify-center rounded-lg min-w-[36px] h-9 px-2 text-sm font-medium transition-colors"><?= $i ?></a>
                        <?php endforeach; ?>
                        <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>" class="inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 hover:text-zinc-700 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                        </a>
                        <?php endif; ?>
                    </nav>
                </div>
                <?php endif; ?>

                <?php else: ?>
                <div class="bg-white rounded-xl border border-zinc-200 p-16 text-center">
                    <svg class="w-16 h-16 text-zinc-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <p class="text-zinc-500 text-lg font-medium">В этой категории пока нет товаров.</p>
                    <p class="text-zinc-400 text-sm mt-1">Попробуйте выбрать другую категорию.</p>
                    <a href="/market" class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-red-600 hover:text-red-700 transition-colors">
                        <i class="fas fa-arrow-left text-xs"></i> Вернуться в каталог
                    </a>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <script src="/public/assets/scripts/components/search.min.js" defer></script>
    <script src="/public/assets/scripts/components/cart-favorites.min.js" defer></script>

    <script>
    function updateCartCount() {
        fetch('/api/cart/count').then(function(r) { return r.json(); }).then(function(d) {
            document.querySelectorAll('.cart-count-badge').forEach(function(el) {
                el.textContent = d.count > 99 ? '99+' : d.count;
                el.style.display = d.count > 0 ? 'flex' : 'none';
            });
        });
    }

    function addToCart(pid, qty, unit) {
        var fd = new URLSearchParams();
        fd.append('product_id', pid);
        fd.append('quantity', qty);
        fd.append('unit', unit);
        return fetch('/api/cart/add', { method: 'POST', body: fd }).then(function(r) { return r.json(); });
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();

        fetch('/api/cart/products').then(function(r) { return r.json(); }).then(function(d) {
            var ids = d.products || [];
            if (!ids.length) return;
            document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
                var pid = btn.getAttribute('data-pid');
                if (ids.indexOf(pid) !== -1) {
                    btn.innerHTML = '<i class="fas fa-plus"></i>';
                    btn.classList.add('bg-green-600', 'in-cart');
                }
            });
        });

        fetch('/api/favorites/products').then(function(r) { return r.json(); }).then(function(d) {
            var ids = d.products || [];
            if (!ids.length) return;
            document.querySelectorAll('.add-to-fav-btn').forEach(function(btn) {
                var pid = btn.getAttribute('data-pid');
                if (ids.indexOf(pid) !== -1) {
                    btn.querySelector('svg path').setAttribute('fill', '#dc2626');
                    btn.querySelector('svg path').setAttribute('stroke', '#dc2626');
                    btn.classList.add('in-fav');
                }
            });
        });

        // Cart buttons
        document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var card = this.closest('[data-pid]');
                var pid = this.dataset.pid;
                var qtyInput = card ? card.querySelector('.cart-qty') : null;
                var unitSelect = card ? card.querySelector('.cart-unit') : null;
                var qty = parseFloat(qtyInput ? qtyInput.value : 1) || 1;
                var unit = unitSelect ? unitSelect.value : this.dataset.unit;
                var wasInCart = this.classList.contains('in-cart');
                var originalCart = '<i class="fas fa-shopping-cart text-[10px]"></i> В корзину';
                var originalInCart = '<i class="fas fa-plus"></i>';

                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                addToCart(pid, qty, unit).then(function(r) {
                    if (r.success) {
                        btn.innerHTML = '<i class="fas fa-plus"></i>';
                        btn.classList.add('bg-green-600', 'in-cart');
                        setTimeout(function() { btn.disabled = false; btn.innerHTML = originalInCart; }, 1500);
                        updateCartCount();
                    } else {
                        btn.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
                        setTimeout(function() { btn.disabled = false; btn.innerHTML = wasInCart ? originalInCart : originalCart; }, 2000);
                    }
                }).catch(function() {
                    btn.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
                    setTimeout(function() { btn.disabled = false; btn.innerHTML = wasInCart ? originalInCart : originalCart; }, 2000);
                });
            });
        });

        // Favorites buttons
        document.querySelectorAll('.add-to-fav-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var pid = this.dataset.pid;
                var self = this;
                var path = self.querySelector('svg path');
                var wasFav = self.classList.contains('in-fav');
                var fd = new URLSearchParams();
                fd.append('product_id', pid);

                fetch('/api/favorites/toggle', { method: 'POST', body: fd })
                    .then(function(r) { return r.json(); })
                    .then(function(r) {
                        if (r.success) {
                            if (wasFav) {
                                self.classList.remove('in-fav');
                                path.setAttribute('fill', 'none');
                                path.setAttribute('stroke', '#a1a1aa');
                            } else {
                                self.classList.add('in-fav');
                                path.setAttribute('fill', '#dc2626');
                                path.setAttribute('stroke', '#dc2626');
                            }
                            if (typeof r.count !== 'undefined') {
                                var badge = document.getElementById('favCountBadge');
                                if (badge) {
                                    badge.textContent = r.count;
                                    badge.style.display = r.count > 0 ? 'flex' : 'none';
                                }
                            }
                        }
                    });
            });
        });

        // Unit switching
        document.querySelectorAll('.unit-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var parent = this.parentElement;
                parent.querySelectorAll('.unit-btn').forEach(function(b) {
                    b.classList.remove('bg-red-100', 'text-red-800');
                    b.classList.add('bg-zinc-100', 'text-zinc-500');
                });
                this.classList.remove('bg-zinc-100', 'text-zinc-500');
                this.classList.add('bg-red-100', 'text-red-800');

                var card = this.closest('.product-card');
                if (card) {
                    var pd = card.querySelector('.price-display');
                    if (pd) pd.innerHTML = Math.round(parseFloat(this.dataset.price)).toLocaleString('ru-RU') + ' <span class="text-sm font-normal text-zinc-500">₽</span>';
                }

                var cardOuter = this.closest('[data-pid]');
                if (cardOuter) {
                    var unitSelect = cardOuter.querySelector('.cart-unit');
                    if (unitSelect) unitSelect.value = this.dataset.unit;
                    var cartBtn = cardOuter.querySelector('.add-to-cart-btn');
                    if (cartBtn) cartBtn.dataset.unit = this.dataset.unit;
                }
            });
        });

        // Grid / List view toggle
        var gv = document.getElementById('grid-view');
        var lv = document.getElementById('list-view');
        var pg = document.getElementById('product-grid');
        if (gv && lv && pg) {
            function setActive(btn, other) {
                btn.classList.add('bg-white', 'text-red-600', 'shadow-sm');
                btn.classList.remove('border', 'border-zinc-200', 'text-zinc-600');
                other.classList.remove('bg-white', 'text-red-600', 'shadow-sm');
                other.classList.add('border', 'border-zinc-200', 'text-zinc-600');
            }
            gv.addEventListener('click', function() {
                pg.className = 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5';
                setActive(gv, lv);
            });
            lv.addEventListener('click', function() {
                pg.className = 'flex flex-col gap-3';
                pg.querySelectorAll('.product-card').forEach(function(c) { c.classList.add('flex-row'); });
                setActive(lv, gv);
            });
        }

        // Product Swiper init
        document.querySelectorAll('.product-swiper').forEach(function(swiperEl) {
            new Swiper(swiperEl, {
                loop: false,
                pagination: { el: swiperEl.querySelector('.swiper-pagination'), clickable: true },
                autoplay: false
            });
        });

        // Filter checkboxes
        document.querySelectorAll('.filter-checkbox').forEach(function(cb) {
            cb.addEventListener('change', function() {
                var cards = document.querySelectorAll('#product-grid .product-card');
                var visible = 0;

                cards.forEach(function(card) {
                    var match = true;
                    document.querySelectorAll('.filter-checkbox:checked').forEach(function(checkedCb) {
                        var type = checkedCb.dataset.filter;
                        var val = checkedCb.value;
                        var cardVal = card.dataset[type] || '';
                        if (cardVal.indexOf(val) === -1) match = false;
                    });
                    card.style.display = match ? '' : 'none';
                    if (match) visible++;
                });

                var counter = document.getElementById('visibleCount');
                if (counter) counter.textContent = visible;
            });
        });
    });
    </script>
</body>
</html>
