<?php
// HTML-кэш для страниц без фильтров/пагинации
$cacheKey = '';
$_noCache = !empty($_GET['search']) || !empty($_GET['marka']) || !empty($_GET['gost']) || !empty($_GET['size']) || !empty($_GET['diameter']) || !empty($_GET['ral']) || !empty($_GET['stock']) || !empty($_GET['price_from']) || !empty($_GET['price_to']) || !empty($_GET['sort']) || !empty($_GET['page']);
if (!$_noCache) {
    $cacheKey = 'katalog_' . md5($_SERVER['REQUEST_URI'] ?? '');
    $cacheFile = __DIR__ . '/../../../../../app/Storage/cache/html/' . $cacheKey . '.html';
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < 300) {
        readfile($cacheFile);
        return;
    }
    ob_start();
}

$allProducts = Setting\route\function\Functions::listProducts();
$site = Setting\route\function\Functions::site();

$subAliases = require __DIR__ . '/../../../../../setting/config/subcategory_aliases.php';

$categoryID = $katalog ?? '';
$subcategoryID = $subcategory ?? '';

$categoryInfo = null;
foreach ($allProducts as $p) {
    if (($p['badge'] ?? '') === 'Категория' && ($p['id'] ?? '') === $categoryID) {
        $categoryInfo = $p;
        break;
    }
}

$subcategoryInfo = null;
if (!empty($subcategoryID)) {
    $subCatFullId = $categoryID . '-' . $subcategoryID;
    foreach ($allProducts as $p) {
        if (($p['badge'] ?? '') === 'Подкатегория' && (($p['categories']['id'] ?? '') === $subcategoryID || ($p['categories']['id'] ?? '') === $subCatFullId)) {
            $subcategoryInfo = $p;
            break;
        }
    }
}

$allCategoryProducts = array_filter($allProducts, function ($p) use ($categoryID, $subcategoryID) {
    $parentId = $p['categories']['parent_id'] ?? '';
    if ($parentId !== $categoryID)
        return false;
    if (!empty($subcategoryID)) {
        $subId = $p['categories']['id'] ?? '';
        if ($subId !== $subcategoryID && $subId !== $categoryID . '-' . $subcategoryID)
            return false;
    }
    return empty($p['badge']);
});
$allCategoryProducts = array_values($allCategoryProducts);

// --- Вспомогательные функции товара ---
$priceOf = function ($p): float {
    $units = $p['units'] ?? [];
    if (empty($units))
        return 0.0;
    return (float) ($units[array_key_first($units)] ?? 0);
};
$ralOf = function ($p): string {
    $specs = $p['specs'] ?? [];
    $brand = (string) ($specs['Марка'] ?? '');
    if (preg_match('/\bRAL\s*(\d{4})\b/i', $brand, $m))
        return 'RAL ' . $m[1];
    $name = (string) ($p['name'] ?? '');
    if (preg_match('/\bRAL\s*(\d{4})\b/i', $name, $m))
        return 'RAL ' . $m[1];
    return '';
};

// --- Границы цен для слайдера (по всем товарам категории, без фильтров) ---
$priceMin = null;
$priceMax = null;
foreach ($allCategoryProducts as $p) {
    $price = $priceOf($p);
    if ($price <= 0)
        continue;
    if ($priceMin === null || $price < $priceMin)
        $priceMin = $price;
    if ($priceMax === null || $price > $priceMax)
        $priceMax = $price;
}
$priceMin = $priceMin ?? 0;
$priceMax = $priceMax ?? 0;
if ($priceMax <= $priceMin)
    $priceMax = $priceMin + 1;
$priceStep = max(1, (int) round(($priceMax - $priceMin) / 4));
$priceScale = [$priceMin, $priceMin + $priceStep, $priceMin + 2 * $priceStep, $priceMin + 3 * $priceStep, $priceMax];

// --- Разбор GET-фильтров ---
$strArr = function ($v): array {
    if (!is_array($v))
        return [];
    $out = [];
    foreach ($v as $x) {
        $x = trim((string) $x);
        if ($x !== '')
            $out[] = $x;
    }
    return array_values(array_unique($out));
};
$fMarka = $strArr($_GET['marka'] ?? []);
$fSize = $strArr($_GET['size'] ?? []);
$fGost = $strArr($_GET['gost'] ?? []);
$fDiam = $strArr($_GET['diameter'] ?? []);
$fRal = $strArr($_GET['ral'] ?? []);
$fStock = !empty($_GET['stock']);
$fPriceFrom = (isset($_GET['price_from']) && is_numeric($_GET['price_from'])) ? (float) $_GET['price_from'] : null;
$fPriceTo = (isset($_GET['price_to']) && is_numeric($_GET['price_to'])) ? (float) $_GET['price_to'] : null;
$fSort = trim((string) ($_GET['sort'] ?? ''));

$filterActive = $fMarka || $fSize || $fGost || $fDiam || $fRal || $fStock || $fPriceFrom !== null || $fPriceTo !== null;

// --- Применение фильтров к товарам категории ---
if ($filterActive) {
    $allCategoryProducts = array_values(array_filter($allCategoryProducts, function ($p) use ($fMarka, $fSize, $fGost, $fDiam, $fRal, $fStock, $fPriceFrom, $fPriceTo, $priceOf, $ralOf) {
        $specs = $p['specs'] ?? [];
        $brand = (string) ($specs['Марка'] ?? '');
        $razmer = (string) ($specs['Размер'] ?? '');
        $gost = (string) ($specs['ГОСТ'] ?? '');
        $diam = (string) ($p['диаметр'] ?? '');
        if ($fMarka && !in_array($brand, $fMarka, true))
            return false;
        if ($fSize && !in_array($razmer, $fSize, true))
            return false;
        if ($fGost && !in_array($gost, $fGost, true))
            return false;
        if ($fDiam && !in_array($diam, $fDiam, true))
            return false;
        if ($fRal && !in_array($ralOf($p), $fRal, true))
            return false;
        if ($fStock && empty($p['in_stock']))
            return false;
        if ($fPriceFrom !== null || $fPriceTo !== null) {
            $price = $priceOf($p);
            if ($fPriceFrom !== null && $price < $fPriceFrom)
                return false;
            if ($fPriceTo !== null && $price > $fPriceTo)
                return false;
        }
        return true;
    }));
}

// --- Сортировка ---
$sortOptions = ['price_asc' => 1, 'price_desc' => 1, 'name_asc' => 1, 'name_desc' => 1, 'size' => 1];
if (isset($sortOptions[$fSort])) {
    usort($allCategoryProducts, function ($a, $b) use ($fSort, $priceOf) {
        switch ($fSort) {
            case 'price_asc':
                return $priceOf($a) <=> $priceOf($b);
            case 'price_desc':
                return $priceOf($b) <=> $priceOf($a);
            case 'name_asc':
                return strnatcasecmp((string) ($a['name'] ?? ''), (string) ($b['name'] ?? ''));
            case 'name_desc':
                return strnatcasecmp((string) ($b['name'] ?? ''), (string) ($a['name'] ?? ''));
            case 'size':
                return strnatcmp((string) ($a['specs']['Размер'] ?? ''), (string) ($b['specs']['Размер'] ?? ''));
        }
        return 0;
    });
}

// --- Подсчёт значений для фильтров (по всем товарам категории) ---
$countBy = function (array $products, callable $get): array {
    $counts = [];
    foreach ($products as $p) {
        $v = trim((string) $get($p));
        if ($v === '')
            continue;
        $counts[$v] = ($counts[$v] ?? 0) + 1;
    }
    uksort($counts, function ($a, $b) use ($counts) {
        return $counts[$b] <=> $counts[$a] ?: strnatcmp($a, $b);
    });
    return $counts;
};
$sizeCounts = $countBy($allCategoryProducts, fn($p) => $p['specs']['Размер'] ?? '');
$markaCounts = $countBy($allCategoryProducts, fn($p) => $p['specs']['Марка'] ?? '');
$diamCounts = $countBy($allCategoryProducts, fn($p) => $p['диаметр'] ?? '');
$gostCounts = $countBy($allCategoryProducts, function ($p) {
    $v = (string) ($p['specs']['ГОСТ'] ?? '');
    if (preg_match('/[\x{FFFD}\x00-\x08\x0B\x0C\x0E-\x1F]/u', $v))
        return '';
    return $v;
});
$ralCounts = $countBy($allCategoryProducts, $ralOf);
$allDiameters = [];
$allBrands = array_keys($markaCounts);
$allRals = array_keys($ralCounts);
sort($allBrands, SORT_STRING);
sort($allRals, SORT_NATURAL);

$categoryTree = [];
foreach ($allProducts as $p) {
    if (($p['badge'] ?? '') === 'Категория') {
        $categoryTree[] = $p;
    }
}

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$hasFilters = $filterActive || !empty($fSort);
$noindexPage = ($page > 1) || $hasFilters;
$itemsPerPage = 24;
$totalItems = count($allCategoryProducts);
$totalPages = max(1, (int) ceil($totalItems / $itemsPerPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $itemsPerPage;
$pageProducts = array_slice($allCategoryProducts, $offset, $itemsPerPage);

// URL-хелперы: базовый путь и сохранение активных параметров
$basePageUrl = explode('?', $_SERVER['REQUEST_URI'] ?? '')[0];
$activeFilterParams = [];
if ($fSort)
    $activeFilterParams['sort'] = $fSort;
if ($fMarka)
    $activeFilterParams['marka'] = $fMarka;
if ($fSize)
    $activeFilterParams['size'] = $fSize;
if ($fDiam)
    $activeFilterParams['diameter'] = $fDiam;
if ($fGost)
    $activeFilterParams['gost'] = $fGost;
if ($fRal)
    $activeFilterParams['ral'] = $fRal;
if ($fStock)
    $activeFilterParams['stock'] = '1';
if ($fPriceFrom !== null)
    $activeFilterParams['price_from'] = $fPriceFrom;
if ($fPriceTo !== null)
    $activeFilterParams['price_to'] = $fPriceTo;
$filterQs = http_build_query($activeFilterParams);
$filterQsSuffix = $filterQs !== '' ? '&' . $filterQs : '';

$subIconMap = [
    'armatura' => '/public/assets/images/icons/product_icons/арматура.webp',
    'balki' => '/public/assets/images/icons/product_icons/балки.webp',
    'vodostochnaya' => '/public/assets/images/icons/product_icons/водосточнаясистема.webp',
    'provoloka' => '/public/assets/images/icons/product_icons/проволка.webp',
    'profnastil' => '/public/assets/images/icons/product_icons/профнастил.webp',
    'setka' => '/public/assets/images/icons/product_icons/сетка.webp',
    'truby' => '/public/assets/images/icons/product_icons/трубы.webp',
    'armatura-truboprovodnaya' => '/public/assets/images/icons/product_icons/трубопроводнаяарматура.webp',
    'ugolok' => '/public/assets/images/icons/product_icons/угол.webp',
    'tsvetnye' => '/public/assets/images/icons/product_icons/цветныеметаллы.webp',
    'shveller' => '/public/assets/images/icons/product_icons/швеллер.webp',
    'krepezh' => '/public/assets/images/icons/product_icons/метизы.webp',
    'detali-truboprovodov' => '/public/assets/images/icons/product_icons/деталитрубопровода.webp',
    'kachestvennye' => '/public/assets/images/icons/product_icons/деталитрубопровода.webp',
    'nerzhaveyushchaya' => '/public/assets/images/icons/product_icons/цветныеметаллы.webp',
    'polimery' => '/public/assets/images/icons/product_icons/полимеры.webp',
    'izdeliya' => '/public/assets/images/icons/product_icons/деталитрубопровода.webp',
    'katanka' => '/public/assets/images/icons/product_icons/проволка.webp',
];
$subIconKeys = array_keys($subIconMap);
usort($subIconKeys, fn($a, $b) => strlen($b) <=> strlen($a));
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($subcategoryInfo['name'] ?? $categoryInfo['title'] ?? 'Категория') ?> купить в Москве —
        сортамент, ГОСТ | КАВ СТАЛЬ</title>
    <meta name="description"
        content="<?= htmlspecialchars(($subcategoryInfo['name'] ?? $categoryInfo['title'] ?? 'Категория') . ' — цена, характеристики, сортамент по ГОСТ. ' . ($categoryInfo['description'] ?: 'Уточняйте наличие и условия поставки у менеджера.')) ?>">
    <meta name="keywords"
        content="<?= htmlspecialchars($subcategoryInfo['name'] ?? $categoryInfo['title'] ?? 'Категория') ?>, купить <?= htmlspecialchars(mb_strtolower($subcategoryInfo['name'] ?? $categoryInfo['title'] ?? 'Категория')) ?> в Москве, металлопрокат, сортамент, ГОСТ, доставка">
    <link rel="canonical"
        href="<?= $site['baseUrl'] ?><?= htmlspecialchars(($subcategoryInfo['seo']['canonicalUrl'] ?? $categoryInfo['seo']['canonicalUrl'] ?? parse_url($_SERVER['REQUEST_URI'] ?? '/market', PHP_URL_PATH))) ?>">

    <meta property="og:title" content="<?= htmlspecialchars($categoryInfo['title'] ?? 'Категория') ?> | КАВ СТАЛЬ">
    <meta property="og:description"
        content="<?= htmlspecialchars($categoryInfo['description'] ?? $categoryInfo['title'] ?? 'Категория') ?>">
    <meta property="og:type" content="website">
    <meta property="og:url"
        content="<?= $site['baseUrl'] ?><?= htmlspecialchars(($subcategoryInfo['seo']['canonicalUrl'] ?? $categoryInfo['seo']['canonicalUrl'] ?? '/market')) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company']) ?>">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="<?= $site['baseUrl'] ?>/public/assets/images/bgpage/market.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($categoryInfo['title'] ?? 'Категория') ?> – КАВ СТАЛЬ">
    <meta name="twitter:description"
        content="<?= htmlspecialchars($categoryInfo['description'] ?? $categoryInfo['title'] ?? 'Категория') ?>">
    <meta name="twitter:image" content="<?= $site['baseUrl'] ?>/public/assets/images/bgpage/market.png">
    <meta name="robots" content="<?= $noindexPage ? 'noindex, follow' : 'index, follow' ?>">
    <meta name="author" content="<?= htmlspecialchars($site['company']) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap">
    </noscript>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700;800&display=swap"
        as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700;800&display=swap">
    </noscript>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="<?= $site['baseUrl'] ?>" crossorigin>

    <link rel="icon" type="image/png"
        href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon.svg">
    <link rel="shortcut icon" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/apple-touch-icon.png">
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

    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    </noscript>

    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="stylesheet" href="/public/assets/styles/main.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <script src="/public/assets/scripts/components/cart-favorites.min.js" defer></script>

    <link rel="preload" href="/public/assets/styles/catalog.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="/public/assets/styles/catalog.min.css">
    </noscript>

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    </noscript>
    <?php include_once __DIR__ . "/../../../../components/seo-head.php"; ?>
</head>

<body class="bg-zinc-50">

    <?php include_once './public/components/header-shared.php'; ?>

    <main class="max-w-7xl mx-auto pl-2 pr-4 lg:px-4 pt-4 pb-12 lg:pt-6">

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-1.5 text-sm mb-6" aria-label="Breadcrumb" itemscope
            itemtype="https://schema.org/BreadcrumbList">
            <a href="/" class="inline-flex items-center text-zinc-500 hover:text-red-500 transition-colors"
                itemprop="item" itemscope itemtype="https://schema.org/Thing" itemid="<?= $site['baseUrl'] ?>/">
                <svg class="me-1.5 h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                </svg>
                <span itemprop="name">Главная</span>
            </a>
            <meta itemprop="position" content="1">
            <svg class="h-4 w-4 text-zinc-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
            </svg>

            <a href="/market" class="text-zinc-500 hover:text-red-500 transition-colors" itemprop="item"
                itemscope itemtype="https://schema.org/Thing" itemid="<?= $site['baseUrl'] ?>/market">
                <span itemprop="name">Каталог</span>
            </a>
            <meta itemprop="position" content="2">
            <svg class="h-4 w-4 text-zinc-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
            </svg>

            <?php
            $parentTitle = $categoryInfo['categories']['title'] ?? null;
            if ($parentTitle):
                ?>
                    <a href="/market/katalog/<?= htmlspecialchars($katalog) ?>"
                        class="text-zinc-500 hover:text-red-500 transition-colors" itemprop="item" itemscope
                        itemtype="https://schema.org/Thing"
                        itemid="<?= $site['baseUrl'] ?>/market/katalog/<?= htmlspecialchars($katalog) ?>">
                        <span itemprop="name"><?= htmlspecialchars($parentTitle) ?></span>
                    </a>
                    <meta itemprop="position" content="<?= $subcategoryID ? '3' : '3' ?>">
                    <?php if (!$subcategoryID): ?>
                            <svg class="h-4 w-4 text-zinc-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                            </svg>
                    <?php endif; ?>
            <?php endif; ?>

            <?php if ($subcategoryID): ?>
                    <div class="relative group">
                        <a href="/market/katalog/<?= htmlspecialchars($katalog) ?>"
                            class="text-zinc-500 hover:text-red-500 transition-colors inline-flex items-center gap-1"
                            itemprop="item" itemscope itemtype="https://schema.org/Thing"
                            itemid="<?= $site['baseUrl'] ?>/market/katalog/<?= htmlspecialchars($katalog) ?>">
                            <span itemprop="name"><?= htmlspecialchars($categoryInfo['title'] ?? $katalog) ?></span>
                            <svg class="h-3 w-3 text-zinc-400 transition-transform duration-200 group-hover:rotate-180"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                            </svg>
                        </a>
                        <div class="absolute left-0 top-full pt-2 z-40 hidden group-hover:block">
                            <div class="bg-white rounded-xl border border-zinc-200 shadow-xl w-[620px] max-h-[70vh] overflow-y-auto p-2">
                                <div class="flex items-center gap-1.5 px-1 pb-2 mb-1 border-b border-zinc-100">
                                    <i class="fas fa-arrows-up-down text-[11px] text-zinc-300"></i>
                                    <span class="text-[11px] font-semibold uppercase tracking-wider text-zinc-400">Выберите категорию</span>
                                    <span class="ml-auto text-[11px] text-zinc-300 hidden sm:block">наведите, чтобы переключиться</span>
                                </div>
                                <div class="grid grid-cols-2 gap-1">
                                <?php foreach ($categoryTree as $cat):
                                    $isActive = ($cat['id'] === $categoryID);
                                    $catUrl = $cat['seo']['canonicalUrl'] ?? '#';
                                    $catThumb = ($cat['images'][0] ?? '');
                                    if ($catThumb !== '' && mb_strpos($catThumb, 'unknown') !== false) {
                                        $catThumb = '';
                                    }
                                    $catIcon = '';
                                    if ($catThumb === '') {
                                        foreach ($subIconKeys as $key) {
                                            if (stripos($cat['id'], $key) !== false) {
                                                $catIcon = $subIconMap[$key];
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                        <a href="<?= htmlspecialchars($catUrl) ?>"
                                            class="group/item flex items-center justify-between gap-3 px-2.5 py-2 rounded-lg text-sm transition <?= $isActive ? 'bg-red-50 text-red-500 font-semibold' : 'text-zinc-600 hover:bg-red-50 hover:text-red-500' ?>">
                                            <span class="truncate"><?= htmlspecialchars($cat['title']) ?></span>
                                            <span class="w-11 h-11 rounded-lg overflow-hidden bg-zinc-50 border border-zinc-100 shrink-0 flex items-center justify-center">
                                                <?php if ($catThumb): ?>
                                                    <img src="<?= htmlspecialchars($catThumb) ?>" alt="" class="w-full h-full object-cover" loading="lazy">
                                                <?php elseif ($catIcon): ?>
                                                    <img src="<?= $catIcon ?>" alt="" class="w-6 h-6 object-contain" loading="lazy">
                                                <?php else: ?>
                                                    <i class="fas fa-folder-open text-xs <?= $isActive ? 'text-red-400' : 'text-zinc-300' ?>"></i>
                                                <?php endif; ?>
                                            </span>
                                        </a>
                                <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <meta itemprop="position" content="<?= $parentTitle ? '4' : '3' ?>">
                    <svg class="h-4 w-4 text-zinc-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                    </svg>
                    <div class="relative group">
                        <?php
                        $crumbSubs = [];
                        foreach ($allProducts as $_p) {
                            if (($_p['badge'] ?? '') === 'Подкатегория' && ($_p['categories']['parent_id'] ?? '') === $categoryID) {
                                $crumbSubs[] = $_p;
                            }
                        }
                        $crumbSubUrl = '/market/katalog/' . htmlspecialchars($katalog) . '/' . htmlspecialchars($subcategoryID);
                        foreach ($crumbSubs as $_cs) {
                            if (($_cs['categories']['id'] ?? '') === $subcategoryID) {
                                $crumbSubUrl = $_cs['seo']['canonicalUrl'] ?? $crumbSubUrl;
                                break;
                            }
                        }
                        ?>
                        <a href="<?= htmlspecialchars($crumbSubUrl) ?>"
                            class="text-zinc-900 font-medium inline-flex items-center gap-1 underline decoration-zinc-300 decoration-dashed underline-offset-8 hover:decoration-red-400 hover:text-red-500 transition-colors"
                            itemprop="item" itemscope itemtype="https://schema.org/Thing"
                            itemid="<?= $site['baseUrl'] ?><?= htmlspecialchars($crumbSubUrl) ?>">
                            <span itemprop="name"><?= htmlspecialchars($subcategoryInfo['name'] ?? $subcategoryID) ?></span>
                            <svg class="h-3 w-3 text-zinc-400 transition-transform duration-200 group-hover:rotate-180"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                            </svg>
                        </a>
                        <div class="absolute left-0 top-full pt-2 z-40 hidden group-hover:block">
                            <div class="bg-white rounded-xl border border-zinc-200 shadow-xl w-[480px] max-h-[70vh] overflow-y-auto p-2">
                                <div class="flex items-center gap-1.5 px-1 pb-2 mb-1 border-b border-zinc-100">
                                    <i class="fas fa-arrows-up-down text-[11px] text-zinc-300"></i>
                                    <span class="text-[11px] font-semibold uppercase tracking-wider text-zinc-400">Подкатегории «<?= htmlspecialchars($categoryInfo['title'] ?? $katalog) ?>»</span>
                                    <span class="ml-auto text-[11px] text-zinc-300 hidden sm:block">наведите, чтобы переключиться</span>
                                </div>
                                <div class="grid grid-cols-1 gap-1">
                                <?php foreach ($crumbSubs as $sub):
                                    $isSubActive = ($sub['categories']['id'] ?? '') === $subcategoryID;
                                    $subUrl = $sub['seo']['canonicalUrl'] ?? '/market/katalog/' . htmlspecialchars($katalog) . '/' . htmlspecialchars($sub['categories']['id'] ?? '');
                                    $subThumb = ($sub['images'][0] ?? '');
                                    if ($subThumb !== '' && mb_strpos($subThumb, 'unknown') !== false) {
                                        $subThumb = '';
                                    }
                                    $subIcon = '';
                                    if ($subThumb === '') {
                                        foreach ($subIconKeys as $key) {
                                            if (stripos($sub['categories']['id'] ?? '', $key) !== false) {
                                                $subIcon = $subIconMap[$key];
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                        <a href="<?= htmlspecialchars($subUrl) ?>"
                                            class="group/item flex items-center justify-between gap-3 px-2.5 py-2 rounded-lg text-sm transition <?= $isSubActive ? 'bg-red-50 text-red-500 font-semibold' : 'text-zinc-600 hover:bg-red-50 hover:text-red-500' ?>">
                                            <span class="truncate"><?= htmlspecialchars($subAliases[$sub['categories']['id'] ?? '']['display'] ?? $sub['name']) ?></span>
                                            <span class="w-11 h-11 rounded-lg overflow-hidden bg-zinc-50 border border-zinc-100 shrink-0 flex items-center justify-center">
                                                <?php if ($subThumb): ?>
                                                    <img src="<?= htmlspecialchars($subThumb) ?>" alt="" class="w-full h-full object-cover" loading="lazy">
                                                <?php elseif ($subIcon): ?>
                                                    <img src="<?= $subIcon ?>" alt="" class="w-6 h-6 object-contain" loading="lazy">
                                                <?php else: ?>
                                                    <i class="fas fa-cube text-xs text-zinc-300"></i>
                                                <?php endif; ?>
                                            </span>
                                        </a>
                                <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <meta itemprop="position" content="<?= $parentTitle ? '5' : '4' ?>">
            <?php else: ?>
                    <div class="relative group">
                        <a href="/market/katalog/<?= htmlspecialchars($katalog) ?>"
                            class="text-zinc-900 font-medium inline-flex items-center gap-1" itemprop="item"
                            itemscope itemtype="https://schema.org/Thing"
                            itemid="<?= $site['baseUrl'] ?>/market/katalog/<?= htmlspecialchars($katalog) ?>">
                            <span itemprop="name"><?= htmlspecialchars($categoryInfo['title'] ?? $katalog) ?></span>
                            <svg class="h-3 w-3 text-zinc-400 transition-transform duration-200 group-hover:rotate-180"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                            </svg>
                        </a>
                        <div class="absolute left-0 top-full pt-2 z-40 hidden group-hover:block">
                            <div class="bg-white rounded-xl border border-zinc-200 shadow-xl w-[620px] max-h-[70vh] overflow-y-auto p-2">
                                <div class="flex items-center gap-1.5 px-1 pb-2 mb-1 border-b border-zinc-100">
                                    <i class="fas fa-arrows-up-down text-[11px] text-zinc-300"></i>
                                    <span class="text-[11px] font-semibold uppercase tracking-wider text-zinc-400">Выберите категорию</span>
                                    <span class="ml-auto text-[11px] text-zinc-300 hidden sm:block">наведите, чтобы переключиться</span>
                                </div>
                                <div class="grid grid-cols-2 gap-1">
                                <?php foreach ($categoryTree as $cat):
                                    $isActive = ($cat['id'] === $categoryID);
                                    $catUrl = $cat['seo']['canonicalUrl'] ?? '#';
                                    $catThumb = ($cat['images'][0] ?? '');
                                    if ($catThumb !== '' && mb_strpos($catThumb, 'unknown') !== false) {
                                        $catThumb = '';
                                    }
                                    $catIcon = '';
                                    if ($catThumb === '') {
                                        foreach ($subIconKeys as $key) {
                                            if (stripos($cat['id'], $key) !== false) {
                                                $catIcon = $subIconMap[$key];
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                        <a href="<?= htmlspecialchars($catUrl) ?>"
                                            class="group/item flex items-center justify-between gap-3 px-2.5 py-2 rounded-lg text-sm transition <?= $isActive ? 'bg-red-50 text-red-500 font-semibold' : 'text-zinc-600 hover:bg-red-50 hover:text-red-500' ?>">
                                            <span class="truncate"><?= htmlspecialchars($cat['title']) ?></span>
                                            <span class="w-11 h-11 rounded-lg overflow-hidden bg-zinc-50 border border-zinc-100 shrink-0 flex items-center justify-center">
                                                <?php if ($catThumb): ?>
                                                    <img src="<?= htmlspecialchars($catThumb) ?>" alt="" class="w-full h-full object-cover" loading="lazy">
                                                <?php elseif ($catIcon): ?>
                                                    <img src="<?= $catIcon ?>" alt="" class="w-6 h-6 object-contain" loading="lazy">
                                                <?php else: ?>
                                                    <i class="fas fa-folder-open text-xs <?= $isActive ? 'text-red-400' : 'text-zinc-300' ?>"></i>
                                                <?php endif; ?>
                                            </span>
                                        </a>
                                <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <meta itemprop="position" content="<?= $parentTitle ? '4' : '3' ?>">
            <?php endif; ?>
        </nav>

        <!-- Header -->
        <div class="mb-6 flex items-center gap-3">
            <h1 class="section-title">
                <?= htmlspecialchars($subAliases[$subcategoryID]['display'] ?? ($subcategoryInfo['name'] ?? ($categoryInfo['title'] ?? 'Категория'))) ?><?= $subcategoryInfo ? '' : ' оптом' ?>
            </h1>
            <?php if ($totalItems > 0): ?>
                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-zinc-100 text-zinc-500 shrink-0">
                    <?= $totalItems ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- Subcategory Cards (shown when viewing parent category) -->
                <?php if (empty($subcategoryID) && !empty($categoryInfo)):
                    $subcats = [];
                    $subCounts = [];
                    foreach ($allProducts as $p) {
                        $pid = $p['categories']['parent_id'] ?? '';
                        $sid = $p['categories']['id'] ?? '';
                        if (($p['badge'] ?? '') === 'Подкатегория' && $pid === $categoryID) {
                            $subcats[] = $p;
                        }
                        if (empty($p['badge']) && $pid === $categoryID && $sid !== '') {
                            $subCounts[$sid] = ($subCounts[$sid] ?? 0) + 1;
                        }
                    }
                    if (!empty($subcats)):
                ?>
        <div class="mb-6">
            <div class="lg:hidden relative">
            <div class="flex gap-3 overflow-x-auto pb-3 pl-2 pr-4 -mx-4 sm:flex-wrap sm:overflow-visible sm:pb-0 sm:mx-0 sm:px-0" style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scrollbar-width: none;" id="sub-slider">
                <?php foreach ($subcats as $sub):
                    $subUrl = $sub['seo']['canonicalUrl'] ?? '/market/katalog/' . htmlspecialchars($katalog) . '/' . htmlspecialchars($sub['categories']['id'] ?? '');
                    $subImg = ($sub['images'][0] ?? '');
                    $sid = $sub['categories']['id'] ?? '';
                    $subCount = $subCounts[$sid] ?? 0;
                    $subIcon = '';
                    foreach ($subIconMap as $key => $path) {
                        if (stripos($sid, $key) !== false) {
                            $subIcon = $path;
                            break;
                        }
                    }
                ?>
                <a href="<?= htmlspecialchars($subUrl) ?>"
                    class="flex items-center gap-3 bg-white border border-zinc-200 rounded-2xl p-3 hover:border-red-300 hover:shadow-md transition-all duration-200 group shrink-0 snap-start w-[72vw] max-w-[280px] sm:w-[calc(50%_-_6px)] sm:max-w-none sm:shrink md:w-[calc(33.333%_-_8px)]">
                    <div class="w-14 h-14 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-center shrink-0 overflow-hidden group-hover:bg-red-50 group-hover:border-red-100 transition-colors">
                        <?php if ($subImg): ?>
                            <img src="<?= htmlspecialchars($subImg) ?>" alt="<?= htmlspecialchars($sub['name']) ?>"
                                class="w-full h-full object-cover" loading="lazy">
                        <?php elseif ($subIcon): ?>
                            <img src="<?= $subIcon ?>" alt="<?= htmlspecialchars($sub['name']) ?>"
                                class="w-10 h-10 object-contain" loading="lazy">
                        <?php else: ?>
                            <i class="fas fa-cube text-zinc-300 text-base"></i>
                        <?php endif; ?>
                    </div>
                    <div class="min-w-0">
                        <span class="text-[13px] font-semibold text-zinc-800 group-hover:text-red-500 transition-colors leading-tight block truncate"><?= htmlspecialchars($subAliases[$sid]['display'] ?? $sub['name']) ?></span>
                        <?php if ($subCount > 0): ?>
                            <span class="text-[11px] text-zinc-400 leading-tight"><?= $subCount ?> <?= $subCount === 1 ? 'товар' : ($subCount < 5 ? 'товара' : 'товаров') ?></span>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <style>#sub-slider::-webkit-scrollbar{display:none}</style>
            <div class="pointer-events-none absolute right-0 top-0 bottom-3 w-8 bg-gradient-to-l from-white rounded-r-2xl"></div>
            </div>
            <div id="sub-desktop" style="display:none" class="gap-3">
                <?php foreach ($subcats as $sub):
                    $subUrl = $sub['seo']['canonicalUrl'] ?? '/market/katalog/' . htmlspecialchars($katalog) . '/' . htmlspecialchars($sub['categories']['id'] ?? '');
                    $subImg = ($sub['images'][0] ?? '');
                    $sid = $sub['categories']['id'] ?? '';
                    $subCount = $subCounts[$sid] ?? 0;
                    $subIcon = '';
                    foreach ($subIconMap as $key => $path) {
                        if (stripos($sid, $key) !== false) {
                            $subIcon = $path;
                            break;
                        }
                    }
                ?>
                <a href="<?= htmlspecialchars($subUrl) ?>"
                    class="flex items-center gap-3 bg-white border border-zinc-200 rounded-2xl p-4 hover:border-red-300 hover:shadow-md transition-all duration-200 group">
                    <div class="w-16 h-16 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-center shrink-0 overflow-hidden group-hover:bg-red-50 group-hover:border-red-100 transition-colors">
                        <?php if ($subImg): ?>
                            <img src="<?= htmlspecialchars($subImg) ?>" alt="<?= htmlspecialchars($sub['name']) ?>"
                                class="w-full h-full object-cover" loading="lazy">
                        <?php elseif ($subIcon): ?>
                            <img src="<?= $subIcon ?>" alt="<?= htmlspecialchars($sub['name']) ?>"
                                class="w-11 h-11 object-contain" loading="lazy">
                        <?php else: ?>
                            <i class="fas fa-cube text-zinc-300 text-lg"></i>
                        <?php endif; ?>
                    </div>
                    <div class="min-w-0">
                        <span class="text-sm font-semibold text-zinc-800 group-hover:text-red-500 transition-colors leading-tight block truncate"><?= htmlspecialchars($subAliases[$sid]['display'] ?? $sub['name']) ?></span>
                        <?php if ($subCount > 0): ?>
                            <span class="text-xs text-zinc-400 leading-tight"><?= $subCount ?> <?= $subCount === 1 ? 'товар' : ($subCount < 5 ? 'товара' : 'товаров') ?></span>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <style>@media (min-width: 1024px) { #sub-desktop { display: grid !important; grid-template-columns: repeat(5, 1fr); } }</style>
        <?php endif; endif; ?>

        <!-- SmartSEO Tags (filter chips by characteristics) -->
        <?php if (!empty($allDiameters) || !empty($allBrands)): ?>
        <div class="mb-5 space-y-3">
            <?php if (!empty($allDiameters)): ?>
            <div>
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mr-2">Размер:</span>
                <div class="inline-flex flex-wrap gap-1.5 mt-1">
                    <?php foreach ($allDiameters as $d): ?>
                        <a href="?diameter[]=<?= urlencode($d) ?>"
                           class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-white border border-zinc-200 text-zinc-600 hover:border-red-300 hover:text-red-500 hover:bg-red-50 transition-all duration-200">
                            <?= htmlspecialchars($d) ?> мм
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($allBrands)): ?>
            <div>
                <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider mr-2">Марка стали:</span>
                <div class="inline-flex flex-wrap gap-1.5 mt-1">
                    <?php foreach (array_slice($allBrands, 0, 20) as $b): ?>
                        <a href="?marka[]=<?= urlencode($b) ?>"
                           class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-white border border-zinc-200 text-zinc-600 hover:border-red-300 hover:text-red-500 hover:bg-red-50 transition-all duration-200">
                            <?= htmlspecialchars($b) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Two-Column Layout -->
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">

            <!-- Left Sidebar -->
            <aside class="w-full lg:w-64 shrink-0">
                <div class="lg:sticky lg:top-20 lg:max-h-[calc(100vh-6rem)] lg:overflow-y-auto space-y-5 pr-1">

                    <!-- Filters (server-side) -->
                    <form method="get" action="<?= htmlspecialchars($basePageUrl) ?>" id="filter-form" class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
                        <?php foreach ($activeFilterParams as $fk => $fv): ?>
                            <?php if ($fk === 'sort')
                                continue; ?>
                            <?php if (is_array($fv)): foreach ($fv as $fvv): ?>
                                <input type="hidden" name="<?= htmlspecialchars($fk) ?>[]" value="<?= htmlspecialchars($fvv) ?>">
                            <?php endforeach; else: ?>
                                <input type="hidden" name="<?= htmlspecialchars($fk) ?>" value="<?= htmlspecialchars((string) $fv) ?>">
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <div class="flex items-center justify-between px-4 pt-4 pb-3 border-b border-zinc-100">
                            <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Фильтры</span>
                            <?php if ($filterActive || !empty($fSort)): ?>
                                <a href="<?= htmlspecialchars($basePageUrl) ?>"
                                    class="text-xs font-medium text-zinc-400 hover:text-red-500 transition-colors">Сбросить</a>
                            <?php endif; ?>
                        </div>

                        <!-- Filter: Price -->
                        <div class="filter-group border-b border-zinc-100">
                            <button type="button"
                                class="filter-group-toggle w-full flex items-center justify-between gap-2 px-4 py-3 text-left transition hover:bg-zinc-50">
                                <span class="text-sm font-medium text-zinc-700">Цена</span>
                                <i
                                    class="fas fa-chevron-down filter-group-arrow text-[10px] text-zinc-300 transition-transform duration-200"></i>
                            </button>
                            <div class="filter-group-body px-4 pt-1.5 pb-5">
                                <div class="relative">
                                    <div class="grid grid-cols-2 gap-0">
                                        <input type="text" inputmode="numeric" autocomplete="off" name="price_from" id="price-min-input"
                                            value="<?= $fPriceFrom !== null ? htmlspecialchars((string) $fPriceFrom) : '' ?>"
                                            placeholder="<?= number_format($priceMin, 0, '', ' ') ?>"
                                            class="text-sm text-zinc-700 bg-white px-3 py-2.5 rounded-l-lg border border-zinc-200 border-r-0 tabular-nums placeholder:text-zinc-400 focus:outline-none focus:border-zinc-400 focus:z-10 transition">
                                        <input type="text" inputmode="numeric" autocomplete="off" name="price_to" id="price-max-input"
                                            value="<?= $fPriceTo !== null ? htmlspecialchars((string) $fPriceTo) : '' ?>"
                                            placeholder="<?= number_format($priceMax, 0, '', ' ') ?>"
                                            class="text-sm text-zinc-700 bg-white px-3 py-2.5 rounded-r-lg border border-zinc-200 tabular-nums text-right placeholder:text-zinc-400 focus:outline-none focus:border-zinc-400 focus:z-10 transition">
                                    </div>
                                    <div class="price-slider relative h-5 select-none mt-px"
                                        data-min="<?= $priceMin ?>" data-max="<?= $priceMax ?>"
                                        data-from="<?= $fPriceFrom !== null ? (int) $fPriceFrom : $priceMin ?>"
                                        data-to="<?= $fPriceTo !== null ? (int) $fPriceTo : $priceMax ?>">
                                        <div class="absolute top-1/2 -translate-y-1/2 left-0 right-0 h-[3px] bg-zinc-200 rounded-full"></div>
                                        <div class="price-slider-active absolute top-1/2 -translate-y-1/2 h-[3px] bg-zinc-900 rounded-full" style="left:0%;right:0%"></div>
                                        <div class="price-slider-handle left absolute left-0 top-1/2 -translate-y-1/2 ml-[-9px] w-[18px] h-[18px] rounded-full bg-white border-[1.5px] border-zinc-900 cursor-grab touch-none shadow-sm" style="left:0%" data-side="from"></div>
                                        <div class="price-slider-handle right absolute left-full top-1/2 -translate-y-1/2 ml-[-9px] w-[18px] h-[18px] rounded-full bg-white border-[1.5px] border-zinc-900 cursor-grab touch-none shadow-sm" style="left:100%" data-side="to"></div>
                                        <div class="absolute top-full left-0 mt-1 text-[10px] text-zinc-400 select-none pointer-events-none">от</div>
                                        <div class="absolute top-full right-0 mt-1 text-[10px] text-zinc-400 select-none pointer-events-none">до</div>
                                    </div>
                                    <button type="submit"
                                        class="mt-3.5 w-full inline-flex items-center justify-center gap-2 bg-zinc-900 text-white text-sm font-semibold py-2.5 rounded-lg hover:bg-red-500 hover:text-white transition-colors">
                                        <i class="fas fa-search text-xs"></i> Поиск
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Filter: Size -->
                        <?php if (!empty($sizeCounts)): ?>
                        <div class="filter-group border-b border-zinc-100">
                            <button type="button"
                                class="filter-group-toggle w-full flex items-center justify-between gap-2 px-4 py-3 text-left transition hover:bg-zinc-50">
                                <span class="text-sm font-medium text-zinc-700">Размер</span>
                                <i
                                    class="fas fa-chevron-down filter-group-arrow text-[10px] text-zinc-300 transition-transform duration-200 <?= !empty($fSize) ? '' : 'rotate-180' ?>"></i>
                            </button>
                            <div class="filter-group-body px-4 pt-1.5 pb-4 <?= !empty($fSize) ? '' : 'hidden' ?>">
                                <div class="relative mb-2.5">
                                    <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] text-zinc-400 pointer-events-none"></i>
                                    <input type="text" placeholder="Поиск…" data-filter-input
                                        class="w-full text-xs bg-zinc-50 border border-zinc-200 rounded-md pl-7 pr-2 py-2 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 focus:bg-white transition">
                                </div>
                                <div class="space-y-1 max-h-60 overflow-y-auto pr-1.5">
                                    <?php $i = 0; foreach ($sizeCounts as $val => $cnt): $i++; ?>
                                    <label
                                        class="flex items-center gap-2 cursor-pointer group px-2 py-2 rounded-md hover:bg-zinc-50 transition <?= $i > 5 ? 'filter-extra hidden' : '' ?>">
                                        <input type="checkbox" name="size[]" value="<?= htmlspecialchars($val) ?>"
                                            <?= in_array($val, $fSize, true) ? 'checked' : '' ?>
                                            onchange="this.form.submit()"
                                            class="w-4 h-4 accent-red-500 cursor-pointer shrink-0">
                                        <span
                                            class="text-sm text-zinc-600 group-hover:text-zinc-900 transition truncate"><?= htmlspecialchars($val) ?></span>
                                        <span
                                            class="ml-auto text-[11px] text-zinc-400 shrink-0"><?= $cnt ?></span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                                <p class="hidden text-xs text-zinc-400 px-2 py-1.5" data-filter-empty>Ничего не найдено</p>
                                <?php if (count($sizeCounts) > 5): ?>
                                <button type="button"
                                    class="filter-more-btn mt-2.5 text-xs font-medium text-zinc-500 hover:text-red-500 transition">+ Еще</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Filter: Diameter -->
                        <?php if (!empty($diamCounts)): ?>
                        <div class="filter-group border-b border-zinc-100">
                            <button type="button"
                                class="filter-group-toggle w-full flex items-center justify-between gap-2 px-4 py-3 text-left transition hover:bg-zinc-50">
                                <span class="text-sm font-medium text-zinc-700">Диаметр</span>
                                <i
                                    class="fas fa-chevron-down filter-group-arrow text-[10px] text-zinc-300 transition-transform duration-200 <?= !empty($fDiam) ? '' : 'rotate-180' ?>"></i>
                            </button>
                            <div class="filter-group-body px-4 pt-1.5 pb-4 <?= !empty($fDiam) ? '' : 'hidden' ?>">
                                <div class="relative mb-2.5">
                                    <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] text-zinc-400 pointer-events-none"></i>
                                    <input type="text" placeholder="Поиск…" data-filter-input
                                        class="w-full text-xs bg-zinc-50 border border-zinc-200 rounded-md pl-7 pr-2 py-2 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 focus:bg-white transition">
                                </div>
                                <div class="space-y-1 max-h-60 overflow-y-auto pr-1.5">
                                    <?php $i = 0; foreach ($diamCounts as $val => $cnt): $i++; ?>
                                    <label
                                        class="flex items-center gap-2 cursor-pointer group px-2 py-2 rounded-md hover:bg-zinc-50 transition <?= $i > 5 ? 'filter-extra hidden' : '' ?>">
                                        <input type="checkbox" name="diameter[]" value="<?= htmlspecialchars($val) ?>"
                                            <?= in_array($val, $fDiam, true) ? 'checked' : '' ?>
                                            onchange="this.form.submit()"
                                            class="w-4 h-4 accent-red-500 cursor-pointer shrink-0">
                                        <span
                                            class="text-sm text-zinc-600 group-hover:text-zinc-900 transition truncate"><?= htmlspecialchars($val) ?></span>
                                        <span
                                            class="ml-auto text-[11px] text-zinc-400 shrink-0"><?= $cnt ?></span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                                <p class="hidden text-xs text-zinc-400 px-2 py-1.5" data-filter-empty>Ничего не найдено</p>
                                <?php if (count($diamCounts) > 5): ?>
                                <button type="button"
                                    class="filter-more-btn mt-2.5 text-xs font-medium text-zinc-500 hover:text-red-500 transition">+ Еще</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Filter: Brand -->
                        <?php if (!empty($markaCounts)): ?>
                        <div class="filter-group border-b border-zinc-100">
                            <button type="button"
                                class="filter-group-toggle w-full flex items-center justify-between gap-2 px-4 py-3 text-left transition hover:bg-zinc-50">
                                <span class="text-sm font-medium text-zinc-700">Марка стали</span>
                                <i
                                    class="fas fa-chevron-down filter-group-arrow text-[10px] text-zinc-300 transition-transform duration-200 <?= !empty($fMarka) ? '' : 'rotate-180' ?>"></i>
                            </button>
                            <div class="filter-group-body px-4 pt-1.5 pb-4 <?= !empty($fMarka) ? '' : 'hidden' ?>">
                                <div class="relative mb-2.5">
                                    <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] text-zinc-400 pointer-events-none"></i>
                                    <input type="text" placeholder="Поиск…" data-filter-input
                                        class="w-full text-xs bg-zinc-50 border border-zinc-200 rounded-md pl-7 pr-2 py-2 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 focus:bg-white transition">
                                </div>
                                <div class="space-y-1 max-h-60 overflow-y-auto pr-1.5">
                                    <?php $i = 0; foreach ($markaCounts as $val => $cnt): $i++; ?>
                                    <label
                                        class="flex items-center gap-2 cursor-pointer group px-2 py-2 rounded-md hover:bg-zinc-50 transition <?= $i > 5 ? 'filter-extra hidden' : '' ?>">
                                        <input type="checkbox" name="marka[]" value="<?= htmlspecialchars($val) ?>"
                                            <?= in_array($val, $fMarka, true) ? 'checked' : '' ?>
                                            onchange="this.form.submit()"
                                            class="w-4 h-4 accent-red-500 cursor-pointer shrink-0">
                                        <span
                                            class="text-sm text-zinc-600 group-hover:text-zinc-900 transition truncate"><?= htmlspecialchars($val) ?></span>
                                        <span
                                            class="ml-auto text-[11px] text-zinc-400 shrink-0"><?= $cnt ?></span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                                <p class="hidden text-xs text-zinc-400 px-2 py-1.5" data-filter-empty>Ничего не найдено</p>
                                <?php if (count($markaCounts) > 5): ?>
                                <button type="button"
                                    class="filter-more-btn mt-2.5 text-xs font-medium text-zinc-500 hover:text-red-500 transition">+ Еще</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Filter: GOST -->
                        <?php if (!empty($gostCounts)): ?>
                        <div class="filter-group border-b border-zinc-100">
                            <button type="button"
                                class="filter-group-toggle w-full flex items-center justify-between gap-2 px-4 py-3 text-left transition hover:bg-zinc-50">
                                <span class="text-sm font-medium text-zinc-700">ГОСТ</span>
                                <i
                                    class="fas fa-chevron-down filter-group-arrow text-[10px] text-zinc-300 transition-transform duration-200 <?= !empty($fGost) ? '' : 'rotate-180' ?>"></i>
                            </button>
                            <div class="filter-group-body px-4 pt-1.5 pb-4 <?= !empty($fGost) ? '' : 'hidden' ?>">
                                <div class="relative mb-2.5">
                                    <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] text-zinc-400 pointer-events-none"></i>
                                    <input type="text" placeholder="Поиск…" data-filter-input
                                        class="w-full text-xs bg-zinc-50 border border-zinc-200 rounded-md pl-7 pr-2 py-2 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 focus:bg-white transition">
                                </div>
                                <div class="space-y-1 max-h-60 overflow-y-auto pr-1.5">
                                    <?php $i = 0; foreach ($gostCounts as $val => $cnt): $i++; ?>
                                    <label
                                        class="flex items-center gap-2 cursor-pointer group px-2 py-2 rounded-md hover:bg-zinc-50 transition <?= $i > 5 ? 'filter-extra hidden' : '' ?>">
                                        <input type="checkbox" name="gost[]" value="<?= htmlspecialchars($val) ?>"
                                            <?= in_array($val, $fGost, true) ? 'checked' : '' ?>
                                            onchange="this.form.submit()"
                                            class="w-4 h-4 accent-red-500 cursor-pointer shrink-0">
                                        <span
                                            class="text-sm text-zinc-600 group-hover:text-zinc-900 transition truncate"><?= htmlspecialchars($val) ?></span>
                                        <span
                                            class="ml-auto text-[11px] text-zinc-400 shrink-0"><?= $cnt ?></span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                                <p class="hidden text-xs text-zinc-400 px-2 py-1.5" data-filter-empty>Ничего не найдено</p>
                                <?php if (count($gostCounts) > 5): ?>
                                <button type="button"
                                    class="filter-more-btn mt-2.5 text-xs font-medium text-zinc-500 hover:text-red-500 transition">+ Еще</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Filter: RAL color -->
                        <?php if (!empty($ralCounts)):
                            $ralNames = [
                                '1000' => 'зеленовато-бежевый', '1001' => 'бежевый', '1002' => 'жёлтый', '1003' => 'сигнальный жёлтый', '1004' => 'золотисто-жёлтый', '1005' => 'медово-жёлтый', '1006' => 'кукурузный', '1007' => 'жёлтый', '1011' => 'коричнево-бежевый', '1012' => 'лимонно-жёлтый', '1013' => 'жемчужно-белый', '1014' => 'слоновая кость', '1015' => 'светлая слоновая кость', '1016' => 'серно-жёлтый', '1017' => 'шафраново-жёлтый', '1018' => 'цинково-жёлтый', '1019' => 'серо-бежевый', '1020' => 'оливково-жёлтый', '1021' => 'рапсово-жёлтый', '1023' => 'транспортный жёлтый', '1024' => 'охра жёлтая', '1027' => 'дынно-жёлтый', '1028' => 'желто-золотой', '1032' => 'желтый ракитник', '1033' => 'георгиново-жёлтый', '1034' => 'пастельно-жёлтый', '1035' => 'перламутрово-бежевый', '1036' => 'перламутрово-золотой', '1037' => 'солнечно-жёлтый',
                                '2000' => 'жёлто-оранжевый', '2001' => 'красно-оранжевый', '2002' => 'кроваво-красный', '2003' => 'пастельно-оранжевый', '2004' => 'чисто-оранжевый', '2005' => 'люминесцентный ярко-оранжевый', '2007' => 'люминесцентный ярко-красный', '2008' => 'ярко-красно-оранжевый', '2009' => 'транспортный оранжевый', '2010' => 'сигнальный оранжевый', '2011' => 'глубокий оранжевый', '2012' => 'лососёво-оранжевый', '2013' => 'перламутрово-оранжевый',
                                '3000' => 'огненно-красный', '3001' => 'сигнальный красный', '3002' => 'карминно-красный', '3003' => 'рубиново-красный', '3004' => 'пурпурно-красный', '3005' => 'вишнёвый', '3007' => 'чёрно-красный', '3009' => 'оксид красный', '3011' => 'коричнево-красный', '3012' => 'бежево-красный', '3013' => 'томатно-красный', '3014' => 'античный розовый', '3015' => 'светло-розовый', '3016' => 'кораллово-красный', '3017' => 'розовый антик', '3018' => 'клубнично-красный', '3020' => 'транспортный красный', '3022' => 'лососёво-красный', '3024' => 'люминесцентный красный', '3026' => 'люминесцентный ярко-красный', '3027' => 'малиново-красный', '3028' => 'чистый красный', '3031' => 'ориент красный', '3032' => 'рубиновый перламутровый', '3033' => 'перламутрово-розовый',
                                '4001' => 'красно-сиреневый', '4002' => 'красно-фиолетовый', '4003' => 'вересково-фиолетовый', '4004' => 'бордово-фиолетовый', '4005' => 'сине-сиреневый', '4006' => 'транспортный пурпурный', '4007' => 'пурпурно-фиолетовый', '4008' => 'сигнальный фиолетовый', '4009' => 'пастельно-фиолетовый', '4010' => 'телемагента', '4011' => 'перламутрово-фиолетовый', '4012' => 'перламутровый ежевичный',
                                '5000' => 'фиолетово-синий', '5001' => 'зелёно-синий', '5002' => 'ультрамариново-синий', '5003' => 'сапфирово-синий', '5004' => 'чёрно-синий', '5005' => 'сигнально синий', '5007' => 'бриллиантово-синий', '5008' => 'серо-синий', '5009' => 'лазурно-синий', '5010' => 'горечавково-синий', '5011' => 'стально-синий', '5012' => 'светло-синий', '5013' => 'кобальтово-синий', '5014' => 'голубино-синий', '5015' => 'небесно-синий', '5017' => 'транспортный синий', '5018' => 'бирюзово-синий', '5019' => 'капри синий', '5020' => 'океанская синь', '5021' => 'водная синь', '5022' => 'ночной синий', '5023' => 'отдалённо-синий', '5024' => 'пастельно-синий', '5025' => 'перламутровый горечавково-синий', '5026' => 'перламутровый ночной синий',
                                '6000' => 'патиново-зелёный', '6001' => 'изумрудно-зелёный', '6002' => 'лиственно-зелёный', '6003' => 'оливково-зелёный', '6004' => 'сине-зелёный', '6005' => 'зелёный мох', '6006' => 'серо-оливковый', '6007' => 'бутылочно-зелёный', '6008' => 'коричнево-зелёный', '6009' => 'пихтовый зелёный', '6010' => 'травяной зелёный', '6011' => 'резедово-зелёный', '6012' => 'чёрно-зелёный', '6013' => 'тростниково-зелёный', '6014' => 'жёлто-оливковый', '6015' => 'чёрно-оливковый', '6016' => 'бирюзово-зелёный', '6017' => 'майский зелёный', '6018' => 'жёлто-зелёный', '6019' => 'светло-зелёный', '6020' => 'хромовый зелёный', '6021' => 'бледно-зелёный', '6022' => 'оливковый', '6024' => 'транспортный зелёный', '6025' => 'папоротниково-зелёный', '6026' => 'опаловый зелёный', '6027' => 'светло-зелёный', '6028' => 'сосновый зелёный', '6029' => 'мятно-зелёный', '6032' => 'сигнальный зелёный', '6033' => 'перламутрово-мятный', '6034' => 'перламутровый бирюзовый', '6035' => 'перламутрово-зелёный', '6036' => 'перламутровый опаловый зелёный', '6037' => 'чисто-зелёный', '6038' => 'люминесцентный зелёный',
                                '7000' => 'серо-беличий', '7001' => 'серебристо-серый', '7002' => 'оливково-серый', '7003' => 'серый мох', '7004' => 'сигнально серый', '7005' => 'мышино-серый', '7006' => 'бежево-серый', '7008' => 'серое хаки', '7009' => 'зеленовато-серый', '7010' => 'брезентово-серый', '7011' => 'стально-серый', '7012' => 'базальтово-серый', '7013' => 'коричнево-серый', '7015' => 'сланцево-серый', '7016' => 'антрацитово-серый', '7021' => 'чёрно-серый', '7022' => 'умбра серая', '7023' => 'серый бетон', '7024' => 'графитово серый', '7026' => 'гранитово-серый', '7030' => 'каменно-серый', '7031' => 'сине-серый', '7032' => 'галечный серый', '7033' => 'цементно-серый', '7034' => 'жёлто-серый', '7035' => 'светло-серый', '7036' => 'платиново-серый', '7037' => 'пыльно-серый', '7038' => 'агатово-серый', '7039' => 'кварцевый серый', '7040' => 'серое окно', '7042' => 'транспортный серый A', '7043' => 'транспортный серый B', '7044' => 'тёмно-серый', '7045' => 'телемагента 1', '7046' => 'телемагента 2', '7047' => 'телемагента 4', '7048' => 'перламутровый мышино-серый',
                                '8000' => 'зеленовато-коричневый', '8001' => 'охра коричневая', '8002' => 'сигнальный коричневый', '8003' => 'глиняный коричневый', '8004' => 'медно-коричневый', '8007' => 'олень коричневый', '8008' => 'оливково-коричневый', '8011' => 'орехово-коричневый', '8012' => 'красно-коричневый', '8014' => 'сепия коричневый', '8015' => 'каштаново-коричневый', '8016' => 'махагон коричневый', '8017' => 'шоколадно-коричневый', '8019' => 'серо-коричневый', '8022' => 'чёрно-коричневый', '8023' => 'оранжево-коричневый', '8024' => 'бежево-коричневый', '8025' => 'бледно-коричневый', '8028' => 'терракотовый', '8029' => 'медно-красный',
                                '9001' => 'кремово-белый', '9002' => 'серо-белый', '9003' => 'сигнально-белый', '9004' => 'чёрный', '9005' => 'глубокий чёрный', '9006' => 'бело-алюминиевый', '9007' => 'серо-алюминиевый', '9010' => 'чисто-белый', '9011' => 'графитно-чёрный', '9016' => 'транспортный белый', '9017' => 'транспортный чёрный', '9018' => 'папирусно-белый', '9022' => 'перламутровый светло-серый', '9023' => 'перламутровый тёмно-серый',
                            ];
                            $ralColorSwatch = fn(string $code): string => match ($code) {
                                '3005' => '#6F2C2C', '5005' => '#20529B', '6005' => '#264B2C', '7004' => '#96969A', '7024' => '#44454A', '8017' => '#3E2A22', '9003' => '#F4F6F5', '5021' => '#006A74', '1015' => '#E6D2B5', '1018' => '#FCA50C', '7016' => '#383E42', '9005' => '#0A0A0A', '3011' => '#7E292C', default => '#B9B9CC',
                            };
                        ?>
                        <div class="filter-group border-b border-zinc-100">
                            <button type="button"
                                class="filter-group-toggle w-full flex items-center justify-between gap-2 px-4 py-3 text-left transition hover:bg-zinc-50">
                                <span class="text-sm font-medium text-zinc-700">Цвет RAL</span>
                                <i
                                    class="fas fa-chevron-down filter-group-arrow text-[10px] text-zinc-300 transition-transform duration-200 <?= !empty($fRal) ? '' : 'rotate-180' ?>"></i>
                            </button>
                            <div class="filter-group-body px-4 pt-1.5 pb-4 <?= !empty($fRal) ? '' : 'hidden' ?>">
                                <div class="relative mb-2.5">
                                    <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] text-zinc-400 pointer-events-none"></i>
                                    <input type="text" placeholder="Поиск…" data-filter-input
                                        class="w-full text-xs bg-zinc-50 border border-zinc-200 rounded-md pl-7 pr-2 py-2 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 focus:bg-white transition">
                                </div>
                                <div class="space-y-1 max-h-60 overflow-y-auto pr-1.5">
                                    <?php $i = 0; foreach ($ralCounts as $val => $cnt):
                                        $ralCode = substr($val, 4);
                                        $ralLabel = ($ralNames[$ralCode] ?? '') ? $val . ' ' . $ralNames[$ralCode] : $val;
                                        $i++; ?>
                                    <label
                                        class="flex items-center gap-2 cursor-pointer group px-2 py-2 rounded-md hover:bg-zinc-50 transition <?= $i > 5 ? 'filter-extra hidden' : '' ?>">
                                        <input type="checkbox" name="ral[]" value="<?= htmlspecialchars($val) ?>"
                                            <?= in_array($val, $fRal, true) ? 'checked' : '' ?>
                                            onchange="this.form.submit()"
                                            class="w-4 h-4 accent-red-500 cursor-pointer shrink-0">
                                        <span class="w-4 h-4 rounded-full border border-zinc-300 shrink-0"
                                            style="background-color: <?= $ralColorSwatch($ralCode) ?>"></span>
                                        <span
                                            class="text-sm text-zinc-600 group-hover:text-zinc-900 transition truncate"><?= htmlspecialchars($ralLabel) ?></span>
                                        <span
                                            class="ml-auto text-[11px] text-zinc-400 shrink-0"><?= $cnt ?></span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                                <p class="hidden text-xs text-zinc-400 px-2 py-1.5" data-filter-empty>Ничего не найдено</p>
                                <?php if (count($ralCounts) > 5): ?>
                                <button type="button"
                                    class="filter-more-btn mt-2.5 text-xs font-medium text-zinc-500 hover:text-red-500 transition">+ Еще</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Filter: In stock -->
                        <div class="px-4 py-3 border-b border-zinc-100">
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" name="stock" value="1"
                                    <?= $fStock ? 'checked' : '' ?> onchange="this.form.submit()"
                                    class="w-4 h-4 accent-red-500 cursor-pointer shrink-0">
                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 transition">Только в наличии</span>
                            </label>
                        </div>
                    </form>

                </div>
            </aside>

            <!-- Content Area -->
            <div class="flex-1 min-w-0">

                <!-- Toolbar -->
                <div class="flex items-center justify-between gap-3 mb-5 px-1 py-1">
                    <div class="flex items-center gap-3">
                        <p class="text-sm text-zinc-500">
                            Найдено: <span class="font-semibold text-zinc-800"
                                id="visibleCount"><?= $totalItems ?></span> товаров
                        </p>
                        <form method="get" action="<?= htmlspecialchars($basePageUrl) ?>" id="sort-form">
                            <?php foreach ($activeFilterParams as $fk => $fv): ?>
                                <?php if ($fk === 'sort')
                                    continue; ?>
                                <?php if (is_array($fv)): foreach ($fv as $fvv): ?>
                                    <input type="hidden" name="<?= htmlspecialchars($fk) ?>[]" value="<?= htmlspecialchars($fvv) ?>">
                                <?php endforeach; else: ?>
                                    <input type="hidden" name="<?= htmlspecialchars($fk) ?>" value="<?= htmlspecialchars((string) $fv) ?>">
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <select name="sort" onchange="this.form.submit()"
                                class="text-sm border border-zinc-200 rounded-lg bg-white px-2 py-1.5 text-zinc-600 focus:outline-none focus:ring-2 focus:ring-red-500 cursor-pointer">
                                <option value="">По умолчанию</option>
                                <option value="price_asc" <?= $fSort === 'price_asc' ? 'selected' : '' ?>>Сначала дешевые</option>
                                <option value="price_desc" <?= $fSort === 'price_desc' ? 'selected' : '' ?>>Сначала дорогие</option>
                                <option value="name_asc" <?= $fSort === 'name_asc' ? 'selected' : '' ?>>С начала алфавита</option>
                                <option value="name_desc" <?= $fSort === 'name_desc' ? 'selected' : '' ?>>С конца алфавита</option>
                                <option value="size" <?= $fSort === 'size' ? 'selected' : '' ?>>По размеру</option>
                            </select>
                        </form>
                    </div>
                    <div class="flex items-center gap-1 bg-zinc-100 rounded-lg p-0.5">
                        <button id="grid-view"
                            class="flex items-center justify-center rounded-md bg-white text-red-500 p-2 shadow-sm transition-colors"
                            title="Сетка">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z" />
                            </svg>
                        </button>
                        <button id="list-view"
                            class="flex items-center justify-center rounded-md border border-zinc-200 bg-white p-2 text-zinc-600 hover:text-red-500 transition-colors"
                            title="Список">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14M5 12l4-4m-4 4 4 4" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Product Grid -->
                <?php if (!empty($pageProducts)): ?>
                        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-5">
                            <?php foreach ($pageProducts as $idx => $item):
                                $productImages = $item['images'] ?? [];
                                if (empty($productImages))
                                    $productImages = [$site['baseUrl'] . '/public/assets/images/unknown/unknown.png'];
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
                                $ral = '';
                                if (preg_match('/\bRAL\s*(\d{4})\b/i', (string) $brand, $mRal)) {
                                    $ral = 'RAL ' . $mRal[1];
                                } elseif (preg_match('/\bRAL\s*(\d{4})\b/i', (string) ($item['name'] ?? $item['title'] ?? ''), $mRal2)) {
                                    $ral = 'RAL ' . $mRal2[1];
                                }
                                ?>
                                    <div class="product-card bg-white rounded-xl border border-zinc-200 hover:border-zinc-300 transition-all duration-200 flex flex-col w-full"
                                        data-diameter="<?= htmlspecialchars($diameter) ?>" data-brand="<?= htmlspecialchars($brand) ?>"
                                        data-gost="<?= htmlspecialchars($gost) ?>" data-ral="<?= htmlspecialchars($ral) ?>">

                                        <!-- Header: Badge + Fav -->
                                        <div class="flex items-start justify-between gap-2 p-3 pb-0">
                                            <span
                                                class="bg-red-500 text-white text-[11px] px-2 py-0.5 rounded-md font-semibold leading-relaxed">
                                                <?= $inStock ? 'Уточняйте наличие' : 'Под заказ' ?>
                                            </span>
                                            <button type="button"
                                                class="add-to-fav-btn w-7 h-7 rounded-md border border-zinc-200 flex items-center justify-center shrink-0 hover:border-zinc-400 hover:bg-zinc-50 transition-colors"
                                                data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>" title="В избранное">
                                                <svg width="13" height="11" viewBox="0 0 13 11" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6.5 10.01l-5.657 3.14a.584.584 0 0 1-.779-.205.54.54 0 0 1-.076-.277V3.61c0-.295.12-.577.335-.786A1.16 1.16 0 0 1 1.843 2.5c.922 0 1.823.435 2.657 1.268a.88.88 0 0 1 .082 1.067c-.47.722-1.285 1.333-2.018 1.626a.88.88 0 0 1-1.134 0L6.5 1.01V10.01z"
                                                        stroke="#a1a1aa" stroke-width="1.2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Image -->
                                        <a href="<?= $productUrl ?>"
                                            class="product-card-image flex items-center justify-center h-[140px] mx-3 mt-3 mb-2 rounded-lg overflow-hidden bg-zinc-50">
                                            <?php if (count($productImages) > 1): ?>
                                                    <div class="swiper product-swiper w-full h-full"
                                                        data-product-id="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                                        <div class="swiper-wrapper">
                                                            <?php foreach ($productImages as $imgIdx => $imgUrl): ?>
                                                                    <div class="swiper-slide flex justify-center items-center">
                                                                        <img <?= $idx === 0 && $imgIdx === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>
                                                                            src="<?= htmlspecialchars($imgUrl) ?>"
                                                                            alt="<?= $productName ?> - фото <?= $imgIdx + 1 ?>" width="140" height="140"
                                                                            class="max-h-full max-w-full object-contain p-2 hover:scale-105 transition-transform duration-300">
                                                                    </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                            <?php else: ?>
                                                    <img <?= $idx === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>
                                                        src="<?= htmlspecialchars($productImages[0]) ?>" alt="<?= $productName ?>" width="140"
                                                        height="140"
                                                        class="max-h-full max-w-full object-contain p-2 hover:scale-105 transition-transform duration-300">
                                            <?php endif; ?>
                                        </a>

                                        <!-- Info -->
                                        <div class="card-body flex-1 flex flex-col min-w-0 px-3 pb-3">
                                            <a href="<?= $productUrl ?>">
                                                <h3
                                                    class="text-[13px] font-semibold text-zinc-800 hover:text-red-500 transition-colors line-clamp-2 leading-snug mb-2 block min-h-[36px]">
                                                    <?= $productName ?></h3>
                                            </a>

                                            <!-- Specs -->
                                            <div class="flex flex-wrap gap-1 mb-2">
                                                <?php if ($brand): ?>
                                                        <span
                                                            class="text-[10px] text-zinc-500 bg-zinc-50 border border-zinc-100 px-1.5 py-0.5 rounded-md font-medium">Марка:
                                                            <strong class="text-zinc-700"><?= htmlspecialchars($brand) ?></strong></span>
                                                <?php endif; ?>
                                                <?php if ($razmer): ?>
                                                        <span
                                                            class="text-[10px] text-zinc-500 bg-zinc-50 border border-zinc-100 px-1.5 py-0.5 rounded-md font-medium">Размер:
                                                            <strong class="text-zinc-700"><?= htmlspecialchars($razmer) ?></strong></span>
                                                <?php endif; ?>
                                                <?php if ($gost): ?>
                                                        <span
                                                            class="text-[10px] text-zinc-500 bg-zinc-50 border border-zinc-100 px-1.5 py-0.5 rounded-md font-medium">ГОСТ:
                                                            <strong class="text-zinc-700"><?= htmlspecialchars($gost) ?></strong></span>
                                                <?php endif; ?>
                                                <?php if ($diameter): ?>
                                                        <span
                                                            class="text-[10px] text-zinc-500 bg-zinc-50 border border-zinc-100 px-1.5 py-0.5 rounded-md font-medium">Ø:
                                                            <strong class="text-zinc-700"><?= htmlspecialchars($diameter) ?></strong></span>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Price & Cart -->
                                            <div class="mt-auto">
                                                <?php if (!empty($units)): ?>
                                                        <div itemprop="offers" itemscope itemtype="https://schema.org/Offer" class="mb-2">
                                                            <meta itemprop="priceCurrency" content="RUB">
                                                            <meta itemprop="availability"
                                                                content="<?= $inStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' ?>">
                                                            <div class="flex items-baseline gap-2">
                                                                <div itemprop="price" content="<?= number_format($firstPrice, 0, '', '') ?>"
                                                                    class="price-display text-[15px] font-bold text-zinc-900 leading-tight">
                                                                    <?= number_format($firstPrice, 0, '', ' ') ?> <span
                                                                        class="text-[11px] font-normal text-zinc-400">₽</span>
                                                                </div>
                                                            </div>
                                                            <div class="flex gap-0.5 mt-1">
                                                                <?php foreach ($units as $unit => $price): ?>
                                                                        <button type="button"
                                                                            class="unit-btn text-[9px] px-1.5 py-0.5 rounded font-medium transition-all <?= $unit === $firstUnit ? 'bg-red-100 text-red-500' : 'bg-zinc-100 text-zinc-500 hover:bg-red-50 hover:text-red-500' ?>"
                                                                            data-unit="<?= htmlspecialchars($unit) ?>"
                                                                            data-price="<?= htmlspecialchars($price) ?>">
                                                                            <?= htmlspecialchars($unit) ?>
                                                                        </button>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                <?php else: ?>
                                                        <div class="text-[13px] text-zinc-400 mb-2">Цена по запросу</div>
                                                <?php endif; ?>

                                                <!-- Add to Cart -->
                                                <div class="flex items-center gap-2"
                                                    data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                                    <div class="flex items-center border border-zinc-200 rounded-lg overflow-hidden">
                                                        <button type="button"
                                                            class="qty-btn w-6 h-7 flex items-center justify-center text-zinc-400 hover:text-zinc-700 hover:bg-zinc-50 transition border-r border-zinc-200 bg-transparent cursor-pointer"
                                                            data-dir="minus">
                                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3"
                                                                viewBox="0 0 24 24">
                                                                <line x1="5" y1="12" x2="19" y2="12" />
                                                            </svg>
                                                        </button>
                                                        <input type="number" value="1" min="1"
                                                            class="cart-qty w-9 h-7 text-center text-[11px] border-0 focus:outline-none focus:ring-0"
                                                            data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                                        <button type="button"
                                                            class="qty-btn w-6 h-7 flex items-center justify-center text-zinc-400 hover:text-zinc-700 hover:bg-zinc-50 transition border-l border-zinc-200 bg-transparent cursor-pointer"
                                                            data-dir="plus">
                                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3"
                                                                viewBox="0 0 24 24">
                                                                <line x1="12" y1="5" x2="12" y2="19" />
                                                                <line x1="5" y1="12" x2="19" y2="12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <?php if (count($units) > 1): ?>
                                                            <select
                                                                class="cart-unit h-7 px-1.5 border border-zinc-200 rounded-lg text-[10px] bg-white focus:outline-none focus:border-red-400"
                                                                data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                                                <?php foreach ($units as $u => $p): ?>
                                                                        <option value="<?= htmlspecialchars($u) ?>" <?= $u === $firstUnit ? 'selected' : '' ?>><?= htmlspecialchars($u) ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                    <?php else: ?>
                                                            <span
                                                                class="text-[10px] text-zinc-400 w-7 shrink-0 text-center"><?= htmlspecialchars($firstUnit) ?></span>
                                                    <?php endif; ?>
                                                    <button type="button"
                                                        class="add-to-cart-btn w-8 h-7 rounded-lg bg-red-500 hover:bg-red-500 active:bg-red-500 text-white flex items-center justify-center shrink-0 transition-colors"
                                                        data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>"
                                                        data-unit="<?= htmlspecialchars($firstUnit) ?>" title="В заявку">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5"
                                                            viewBox="0 0 24 24">
                                                            <circle cx="9" cy="21" r="1" />
                                                            <circle cx="20" cy="21" r="1" />
                                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                                                        </svg>
                                                    </button>
                                                </div>
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
                                                <a href="?page=<?= $page - 1 ?><?= $filterQsSuffix ?>"
                                                    class="inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 hover:text-zinc-700 transition-colors">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="m15 19-7-7 7-7" />
                                                    </svg>
                                                </a>
                                        <?php endif; ?>
                                        <?php
                                        $range = 2;
                                        $showPages = [1];
                                        for ($i = max(2, $page - $range); $i <= min($totalPages - 1, $page + $range); $i++)
                                            $showPages[] = $i;
                                        if ($totalPages > 1)
                                            $showPages[] = $totalPages;
                                        $showPages = array_unique($showPages);
                                        sort($showPages);
                                        $prevPage = 0;
                                        foreach ($showPages as $i):
                                            if ($prevPage > 0 && $i > $prevPage + 1):
                                                ?>
                                                        <span class="px-1.5 text-sm text-zinc-400">...</span>
                                                <?php endif;
                                            $prevPage = $i;
                                            $active = $i === $page; ?>
                                                <a href="?page=<?= $i ?><?= $filterQsSuffix ?>"
                                                    class="<?= $active ? 'bg-red-500 text-white border-red-500 shadow-sm' : 'border border-zinc-200 bg-white text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900' ?> inline-flex items-center justify-center rounded-lg min-w-[36px] h-9 px-2 text-sm font-medium transition-colors"><?= $i ?></a>
                                        <?php endforeach; ?>
                                        <?php if ($page < $totalPages): ?>
                                                <a href="?page=<?= $page + 1 ?><?= $filterQsSuffix ?>"
                                                    class="inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 hover:text-zinc-700 transition-colors">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="m9 5 7 7-7 7" />
                                                    </svg>
                                                </a>
                                        <?php endif; ?>
                                    </nav>
                                </div>
                        <?php endif; ?>

                <?php else: ?>
                        <div class="bg-white rounded-xl border border-zinc-200 p-16 text-center">
                            <svg class="w-16 h-16 text-zinc-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <p class="text-zinc-500 text-lg font-medium">В этой категории пока нет товаров.</p>
                            <p class="text-zinc-400 text-sm mt-1">Попробуйте выбрать другую категорию.</p>
                            <a href="/market"
                                class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-red-500 hover:text-red-500 transition-colors">
                                <i class="fas fa-arrow-left text-xs"></i> Вернуться в каталог
                            </a>
                        </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- Ассортимент (другие виды того же товара из одной группы) -->
        <?php
        $subFullId = $categoryID . '-' . $subcategoryID;
        $currentGroup = $subAliases[$subFullId]['group'] ?? $subAliases[$subcategoryID]['group'] ?? '';
        if (!empty($subcategoryID) && $currentGroup):
            $relatedProducts = [];
            foreach ($allProducts as $p) {
                if (($p['badge'] ?? '') === 'Подкатегория') {
                    $pSid = $p['categories']['id'] ?? '';
                    if (($subAliases[$pSid]['group'] ?? '') === $currentGroup) {
                        $relatedProducts[] = $p;
                    }
                }
            }
            $relatedProducts = array_slice($relatedProducts, 0, 10);
            if (!empty($relatedProducts)):
        ?>
        <div class="mt-10">
            <h2 class="section-title mb-4">Ассортимент</h2>
            <div class="lg:hidden relative">
            <div class="flex gap-3 overflow-x-auto pb-3 pl-2 pr-4 -mx-4 sm:flex-wrap sm:overflow-visible sm:pb-0 sm:mx-0 sm:px-0" style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scrollbar-width: none;" id="assort-slider">
                <?php foreach ($relatedProducts as $rel):
                    $relUrl = $rel['seo']['canonicalUrl'] ?? '#';
                    $relImg = ($rel['images'][0] ?? '');
                    $relSid = $rel['categories']['id'] ?? '';
                    $relIcon = '';
                    foreach ($subIconMap as $key => $path) {
                        if (stripos($relSid, $key) !== false) {
                            $relIcon = $path;
                            break;
                        }
                    }
                    $relCount = 0;
                    foreach ($allProducts as $cp) {
                        if (empty($cp['badge']) && ($cp['categories']['parent_id'] ?? '') === $categoryID && ($cp['categories']['id'] ?? '') === $relSid) {
                            $relCount++;
                        }
                    }
                ?>
                <a href="<?= htmlspecialchars($relUrl) ?>"
                    class="flex items-center gap-3 bg-white border border-zinc-200 rounded-2xl p-3 hover:border-red-300 hover:shadow-md transition-all duration-200 group shrink-0 snap-start w-[72vw] max-w-[280px] sm:w-[calc(50%_-_6px)] sm:max-w-none sm:shrink md:w-[calc(33.333%_-_8px)]">
                    <div class="w-14 h-14 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-center shrink-0 overflow-hidden group-hover:bg-red-50 group-hover:border-red-100 transition-colors">
                        <?php if ($relImg): ?>
                            <img src="<?= htmlspecialchars($relImg) ?>" alt="<?= htmlspecialchars($rel['name']) ?>"
                                class="w-full h-full object-cover" loading="lazy">
                        <?php elseif ($relIcon): ?>
                            <img src="<?= $relIcon ?>" alt="<?= htmlspecialchars($rel['name']) ?>"
                                class="w-10 h-10 object-contain" loading="lazy">
                        <?php else: ?>
                            <i class="fas fa-cube text-zinc-300 text-base"></i>
                        <?php endif; ?>
                    </div>
                    <div class="min-w-0">
                        <span class="text-[13px] font-semibold text-zinc-800 group-hover:text-red-500 transition-colors leading-tight block truncate"><?= htmlspecialchars($subAliases[$relSid]['display'] ?? $rel['name']) ?></span>
                        <?php if ($relCount > 0): ?>
                            <span class="text-[11px] text-zinc-400 leading-tight"><?= $relCount ?> <?= $relCount === 1 ? 'товар' : ($relCount < 5 ? 'товара' : 'товаров') ?></span>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <style>#assort-slider::-webkit-scrollbar{display:none}</style>
            <div class="pointer-events-none absolute right-0 top-8 bottom-3 w-8 bg-gradient-to-l from-white rounded-r-2xl"></div>
            </div>
            <div id="assort-desktop" style="display:none" class="gap-3">
                <?php foreach ($relatedProducts as $rel):
                    $relUrl = $rel['seo']['canonicalUrl'] ?? '#';
                    $relImg = ($rel['images'][0] ?? '');
                    $relSid = $rel['categories']['id'] ?? '';
                    $relIcon = '';
                    foreach ($subIconMap as $key => $path) {
                        if (stripos($relSid, $key) !== false) {
                            $relIcon = $path;
                            break;
                        }
                    }
                    $relCount = 0;
                    foreach ($allProducts as $cp) {
                        if (empty($cp['badge']) && ($cp['categories']['parent_id'] ?? '') === $categoryID && ($cp['categories']['id'] ?? '') === $relSid) {
                            $relCount++;
                        }
                    }
                ?>
                <a href="<?= htmlspecialchars($relUrl) ?>"
                    class="flex items-center gap-3 bg-white border border-zinc-200 rounded-2xl p-4 hover:border-red-300 hover:shadow-md transition-all duration-200 group">
                    <div class="w-14 h-14 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-center shrink-0 overflow-hidden group-hover:bg-red-50 group-hover:border-red-100 transition-colors">
                        <?php if ($relImg): ?>
                            <img src="<?= htmlspecialchars($relImg) ?>" alt="<?= htmlspecialchars($rel['name']) ?>"
                                class="w-full h-full object-cover" loading="lazy">
                        <?php elseif ($relIcon): ?>
                            <img src="<?= $relIcon ?>" alt="<?= htmlspecialchars($rel['name']) ?>"
                                class="w-8 h-8 object-contain" loading="lazy">
                        <?php else: ?>
                            <i class="fas fa-cube text-zinc-300 text-sm"></i>
                        <?php endif; ?>
                    </div>
                    <div class="min-w-0">
                        <span class="text-sm font-semibold text-zinc-800 group-hover:text-red-500 transition-colors leading-tight block truncate"><?= htmlspecialchars($subAliases[$relSid]['display'] ?? $rel['name']) ?></span>
                        <?php if ($relCount > 0): ?>
                            <span class="text-xs text-zinc-400 leading-tight"><?= $relCount ?> <?= $relCount === 1 ? 'товар' : ($relCount < 5 ? 'товара' : 'товаров') ?></span>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <style>@media (min-width: 1024px) { #assort-desktop { display: grid !important; grid-template-columns: repeat(5, 1fr); } }</style>
        <?php endif; endif; ?>

    </main>

    <!-- SEO-описание категории (для охвата поисковых запросов по металлопрокату) -->
    <section class="max-w-7xl mx-auto px-4 lg:px-8 py-10" aria-label="Описание раздела">
        <?php
        $seoTitle = $subAliases[$subcategoryID]['display'] ?? ($subcategoryInfo['name'] ?? ($categoryInfo['title'] ?? 'Металлопрокат'));
        $seoParent = $categoryInfo['title'] ?? '';
        $seoDesc = !empty($categoryInfo['description']) ? $categoryInfo['description'] : '';
        ?>
        <h2 class="section-title mb-3">
            <?= htmlspecialchars($seoTitle) ?> — купить в Москве с доставкой по выгодной цене
        </h2>
        <div class="text-sm text-zinc-600 leading-relaxed space-y-3">
            <p>
                <?= htmlspecialchars($seoTitle) ?><?= $seoParent && $seoParent !== $seoTitle ? ' (раздел «' . htmlspecialchars($seoParent) . '»)' : '' ?>
                —
                это широкий сортамент металлопроката от «КАВ СТАЛЬ». В нашем каталоге представлены
                <?= htmlspecialchars(mb_strtolower($seoTitle)) ?> по ГОСТ и ТУ с сертификатами качества, в наличии и под
                заказ.
                Мы осуществляем продажу металлопроката оптом и в розницу с резкой в размер и доставкой по Москве и
                Московской области.
            </p>
            <?php if ($seoDesc): ?>
                    <p><?= htmlspecialchars($seoDesc) ?></p>
            <?php endif; ?>
            <p>
                Цена на <?= htmlspecialchars(mb_strtolower($seoTitle)) ?> за тонну и за метр зависит от марки стали,
                размера и объёма заказа.
                Чтобы узнать актуальную стоимость, выберите позицию в таблице выше или оставьте заявку —
                менеджер рассчитает цену с учётом объёма заказа. Сроки и условия доставки уточняйте при подтверждении
                заказа.
            </p>
            <p class="text-zinc-500">
                Похожие разделы:
                <?php
                $relCats = [
                    'Трубы' => 'truby',
                    'Швеллер' => 'shveller',
                    'Балки' => 'balki',
                    'Уголок' => 'ugolok',
                    'Арматура' => 'armatura',
                    'Круг, квадрат, полоса' => 'krug-kvadrat-polosa',
                    'Листовой прокат' => 'listovoy-prokat',
                    'Профнастил' => 'profnastil',
                    'Водосточная система' => 'vodostochnaya-sistema',
                    'Проволока' => 'provoloka',
                    'Сетка' => 'setka',
                    'Нержавеющая сталь' => 'nerzhaveyushchaya-stal',
                    'Цветные металлы' => 'tsvetnye-metally',
                    'Качественные и специальные стали' => 'kachestvennye-i-spetsialnye-stali',
                    'Крепёж и метизы' => 'krepezh-i-metizy',
                    'Детали трубопроводов' => 'detali-truboprovodov',
                    'Трубопроводная арматура' => 'truboprovodnaya-armatura',
                    'Полимеры и технические материалы' => 'polimery-i-tekhnicheskie-materialy',
                    'Изделия и проектные позиции' => 'izdeliya-i-proektnye-pozitsii',
                ];
                $relLinks = [];
                foreach ($relCats as $rt => $rslug) {
                    if ($rslug === ($katalog ?? ''))
                        continue;
                    $relLinks[] = '<a href="/market/katalog/' . htmlspecialchars($rslug) . '" class="text-red-500 hover:underline">' . htmlspecialchars(mb_strtolower($rt)) . '</a>';
                }
                echo implode(', ', $relLinks);
                ?>
            </p>
        </div>
    </section>

    <?php include_once './public/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <script src="/public/assets/scripts/components/cart-favorites.min.js" defer></script>

    <script>
        function updateCartCount() {
            fetch('/api/cart/count').then(function (r) { return r.json(); }).then(function (d) {
                document.querySelectorAll('.cart-count-badge').forEach(function (el) {
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
            return fetch('/api/cart/add', { method: 'POST', body: fd }).then(function (r) { return r.json(); });
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateCartCount();

            fetch('/api/cart/products').then(function (r) { return r.json(); }).then(function (d) {
                var ids = d.products || [];
                if (!ids.length) return;
                document.querySelectorAll('.add-to-cart-btn').forEach(function (btn) {
                    var pid = btn.getAttribute('data-pid');
                    if (ids.indexOf(pid) !== -1) {
                        btn.innerHTML = '<i class="fas fa-plus"></i>';
                        btn.classList.add('bg-green-600', 'in-cart');
                    }
                });
            });

            fetch('/api/favorites/products').then(function (r) { return r.json(); }).then(function (d) {
                var ids = d.products || [];
                if (!ids.length) return;
                document.querySelectorAll('.add-to-fav-btn').forEach(function (btn) {
                    var pid = btn.getAttribute('data-pid');
                    if (ids.indexOf(pid) !== -1) {
                        btn.querySelector('svg path').setAttribute('fill', '#ef4444');
                        btn.querySelector('svg path').setAttribute('stroke', '#ef4444');
                        btn.classList.add('in-fav');
                    }
                });
            });

            // Cart buttons
            document.querySelectorAll('.add-to-cart-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var card = this.closest('[data-pid]');
                    var pid = this.dataset.pid;
                    var qtyInput = card ? card.querySelector('.cart-qty') : null;
                    var unitSelect = card ? card.querySelector('.cart-unit') : null;
                    var qty = parseFloat(qtyInput ? qtyInput.value : 1) || 1;
                    var unit = unitSelect ? unitSelect.value : this.dataset.unit;
                    var wasInCart = this.classList.contains('in-cart');
                    var originalCart = '<i class="fas fa-shopping-cart text-[10px]"></i> В заявку';
                    var originalInCart = '<i class="fas fa-plus"></i>';

                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                    addToCart(pid, qty, unit).then(function (r) {
                        if (r.success) {
                            btn.innerHTML = '<i class="fas fa-plus"></i>';
                            btn.classList.add('bg-green-600', 'in-cart');
                            setTimeout(function () { btn.disabled = false; btn.innerHTML = originalInCart; }, 1500);
                            updateCartCount();
                        } else {
                            btn.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
                            setTimeout(function () { btn.disabled = false; btn.innerHTML = wasInCart ? originalInCart : originalCart; }, 2000);
                        }
                    }).catch(function () {
                        btn.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
                        setTimeout(function () { btn.disabled = false; btn.innerHTML = wasInCart ? originalInCart : originalCart; }, 2000);
                    });
                });
            });

            // Favorites buttons
            document.querySelectorAll('.add-to-fav-btn').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var pid = this.dataset.pid;
                    var self = this;
                    var path = self.querySelector('svg path');
                    var wasFav = self.classList.contains('in-fav');
                    var fd = new URLSearchParams();
                    fd.append('product_id', pid);

                    fetch('/api/favorites/toggle', { method: 'POST', body: fd })
                        .then(function (r) { return r.json(); })
                        .then(function (r) {
                            if (r.success) {
                                if (wasFav) {
                                    self.classList.remove('in-fav');
                                    path.setAttribute('fill', 'none');
                                    path.setAttribute('stroke', '#a1a1aa');
                                } else {
                                    self.classList.add('in-fav');
                                    path.setAttribute('fill', '#ef4444');
                                    path.setAttribute('stroke', '#ef4444');
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
            document.querySelectorAll('.unit-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var parent = this.parentElement;
                    parent.querySelectorAll('.unit-btn').forEach(function (b) {
                        b.classList.remove('bg-red-100', 'text-red-500');
                        b.classList.add('bg-zinc-100', 'text-zinc-500');
                    });
                    this.classList.remove('bg-zinc-100', 'text-zinc-500');
                    this.classList.add('bg-red-100', 'text-red-500');

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
                    btn.classList.add('bg-white', 'text-red-500', 'shadow-sm');
                    btn.classList.remove('border', 'border-zinc-200', 'text-zinc-600');
                    other.classList.remove('bg-white', 'text-red-500', 'shadow-sm');
                    other.classList.add('border', 'border-zinc-200', 'text-zinc-600');
                }
                gv.addEventListener('click', function () {
                    pg.className = 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-5';
                    pg.querySelectorAll('.product-card').forEach(function (c) {
                        c.classList.remove('flex-row');
                        var img = c.querySelector('.product-card-image');
                        img.classList.remove('w-36', 'shrink-0', 'm-3', 'mb-2');
                        img.classList.add('h-[140px]', 'mx-3', 'mt-3', 'mb-2');
                        var header = c.querySelector('.flex.items-start');
                        if (header) header.classList.remove('hidden');
                    });
                    setActive(gv, lv);
                });
                lv.addEventListener('click', function () {
                    pg.className = 'flex flex-col gap-3';
                    pg.querySelectorAll('.product-card').forEach(function (c) {
                        c.classList.add('flex-row');
                        var img = c.querySelector('.product-card-image');
                        img.classList.remove('h-[140px]', 'mx-3', 'mt-3', 'mb-2');
                        img.classList.add('w-36', 'shrink-0', 'm-3');
                        var header = c.querySelector('.flex.items-start');
                        if (header) header.classList.add('hidden');
                    });
                    setActive(lv, gv);
                });
            }

            // Qty buttons
            document.querySelectorAll('.qty-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var input = this.parentElement.querySelector('.cart-qty');
                    if (!input) return;
                    var val = parseFloat(input.value) || 1;
                    if (this.dataset.dir === 'minus' && val > 1) {
                        input.value = val - 1;
                    } else if (this.dataset.dir === 'plus') {
                        input.value = val + 1;
                    }
                });
            });

            // Product Swiper init
            document.querySelectorAll('.product-swiper').forEach(function (swiperEl) {
                new Swiper(swiperEl, {
                    loop: false,
                    pagination: { el: swiperEl.querySelector('.swiper-pagination'), clickable: true },
                    autoplay: false
                });
            });

            // Works Swiper init
            var worksSwiper = document.querySelector('.works-swiper');
            if (worksSwiper) {
                new Swiper(worksSwiper, {
                    loop: true,
                    slidesPerView: 1,
                    spaceBetween: 12,
                    pagination: { el: '.works-swiper .swiper-pagination', clickable: true },
                    navigation: { nextEl: '.works-swiper .swiper-button-next', prevEl: '.works-swiper .swiper-button-prev' },
                    autoplay: { delay: 5000, disableOnInteraction: false },
                    breakpoints: {
                        640: { slidesPerView: 2 },
                        1024: { slidesPerView: 3 }
                    }
                });
            }

            // Filter: collapsible groups (accordion)
            document.querySelectorAll('.filter-group-toggle').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var group = btn.closest('.filter-group');
                    if (!group) return;
                    var body = group.querySelector('.filter-group-body');
                    var arrow = btn.querySelector('.filter-group-arrow');
                    if (body) body.classList.toggle('hidden');
                    if (arrow) arrow.classList.toggle('rotate-180');
                });
            });

            // Filter: expand hidden values ("+ Еще")
            document.querySelectorAll('.filter-more-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var block = btn.closest('.filter-group-body');
                    if (!block) return;
                    var extra = block.querySelectorAll('.filter-extra');
                    var expanded = btn.getAttribute('data-expanded') === '1';
                    extra.forEach(function (el) { el.classList.toggle('hidden', expanded); });
                    btn.textContent = expanded ? '+ Еще' : 'Скрыть';
                    btn.setAttribute('data-expanded', expanded ? '0' : '1');
                });
            });

            // Filter: live search within group lists
            document.querySelectorAll('[data-filter-input]').forEach(function (input) {
                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') e.preventDefault();
                });
                input.addEventListener('input', function () {
                    var group = input.closest('.filter-group-body');
                    if (!group) return;
                    var q = input.value.trim().toLowerCase();
                    var labels = Array.prototype.slice.call(group.querySelectorAll('label'));
                    var visible = 0;
                    labels.forEach(function (label, idx) {
                        var nameEl = label.querySelector('.truncate');
                        var text = ((nameEl || label).textContent || '').toLowerCase();
                        var match = q === '' || text.indexOf(q) !== -1;
                        if (q !== '') {
                            label.classList.remove('filter-extra', 'hidden');
                        } else {
                            var isExtra = idx >= 5;
                            label.classList.toggle('filter-extra', isExtra);
                            label.classList.toggle('hidden', isExtra);
                        }
                        label.style.display = match ? '' : 'none';
                        if (match) visible++;
                    });
                    var empty = group.querySelector('[data-filter-empty]');
                    if (empty) empty.classList.toggle('hidden', visible !== 0);
                    var more = group.querySelector('.filter-more-btn');
                    if (more) more.style.display = q !== '' ? 'none' : '';
                });
            });

            // Price slider (range)
            document.querySelectorAll('.price-slider').forEach(function (slider) {
                var min = parseFloat(slider.dataset.min);
                var max = parseFloat(slider.dataset.max);
                var initFrom = parseFloat(slider.dataset.from);
                var initTo = parseFloat(slider.dataset.to);
                var fromInput = document.getElementById('price-min-input');
                var toInput = document.getElementById('price-max-input');
                var activeBar = slider.querySelector('.price-slider-active');
                var leftHandle = slider.querySelector('.price-slider-handle.left');
                var rightHandle = slider.querySelector('.price-slider-handle.right');
                var range = max - min;
                var from = min, to = max;

                function pct(v) { return range > 0 ? ((v - min) / range) * 100 : 0; }
                function clamp(v, a, b) { return Math.min(b, Math.max(a, v)); }

                function formatNumber(n) {
                    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                }

                function setValues(f, t) {
                    f = clamp(Math.round(f), min, max);
                    t = clamp(Math.round(t), min, max);
                    if (f > t) { var tmp = f; f = t; t = tmp; }
                    from = f; to = t;
                    var fl = pct(f), tl = pct(t);
                    leftHandle.style.left = fl + '%';
                    rightHandle.style.left = tl + '%';
                    activeBar.style.left = fl + '%';
                    activeBar.style.right = (100 - tl) + '%';
                    fromInput.value = f > min ? formatNumber(f) : '';
                    toInput.value = t < max ? formatNumber(t) : '';
                }

                setValues(initFrom, initTo);

                function valueFromPos(px) {
                    var rect = slider.getBoundingClientRect();
                    var p = clamp((px - rect.left) / rect.width, 0, 1);
                    return min + p * range;
                }

                function bindHandle(handle, side) {
                    handle.addEventListener('pointerdown', function (e) {
                        e.preventDefault();
                        if (!handle.setPointerCapture) return;
                        handle.setPointerCapture(e.pointerId);
                        var moved = false;
                        var move = function (ev) {
                            var v = valueFromPos(ev.clientX);
                            if (side === 'from') setValues(v, to);
                            else setValues(from, v);
                            moved = true;
                        };
                        var up = function () {
                            handle.removeEventListener('pointermove', move);
                            handle.removeEventListener('pointerup', up);
                        };
                        handle.addEventListener('pointermove', move);
                        handle.addEventListener('pointerup', up);
                    });
                }
                bindHandle(leftHandle, 'from');
                bindHandle(rightHandle, 'to');

                fromInput.addEventListener('change', function () {
                    var v = parseFloat(String(fromInput.value).replace(/[^\d.]/g, ''));
                    if (!isNaN(v)) setValues(v, to);
                });
                toInput.addEventListener('change', function () {
                    var v = parseFloat(String(toInput.value).replace(/[^\d.]/g, ''));
                    if (!isNaN(v)) setValues(from, v);
                });
                fromInput.addEventListener('input', function () {
                    var v = parseFloat(String(fromInput.value).replace(/[^\d.]/g, ''));
                    if (!isNaN(v)) setValues(v, to);
                    else setValues(min, to);
                });
                toInput.addEventListener('input', function () {
                    var v = parseFloat(String(toInput.value).replace(/[^\d.]/g, ''));
                    if (!isNaN(v)) setValues(from, v);
                    else setValues(from, max);
                });
                var form = fromInput.closest('form');
                if (form) {
                    form.addEventListener('submit', function () {
                        var fv = String(fromInput.value).replace(/[^\d]/g, '');
                        var tv = String(toInput.value).replace(/[^\d]/g, '');
                        fromInput.value = fv;
                        toInput.value = tv;
                        if (fv === '') fromInput.removeAttribute('name');
                        if (tv === '') toInput.removeAttribute('name');
                    });
                }
            });
        });
    </script>
    <?php if (!$_noCache):
        $dir = dirname($cacheFile);
        if (!is_dir($dir))
            mkdir($dir, 0755, true);
        file_put_contents($cacheFile, ob_get_contents(), LOCK_EX);
        ob_end_flush();
    endif; ?>
</body>

</html>