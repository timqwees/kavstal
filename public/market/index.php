<?php
$site = Setting\route\function\Functions::site();
$products = Setting\route\function\Functions::listProducts();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>КАВ СТАЛЬ | Поставки металлопроката по Москве и МО</title>
    <meta name="description" content="МЕТАЛЛОБАЗА 'КАВ СТАЛЬ' - поставки металлопроката по Москве и МО. Арматура, балка, круг, лист, полоса, проволока, профнастил, сваи, рельс, сетка, труба, уголок, швеллер и другая продукция.">
    <meta property="og:title" content="КАВ СТАЛЬ | Металлобаза - поставки металлопроката по Москве и МО">
    <meta property="og:description" content="МЕТАЛЛОБАЗА 'КАВ СТАЛЬ' - поставки металлопроката по Москве и МО. Арматура, балка, круг, лист, полоса, проволока, профнастил, сваи, рельс, сетка, труба, уголок, швеллер. ООО 'КАВ Сталь' ИНН: 9719080724.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $site['baseUrl']; ?>/market">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/market.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="КАВ СТАЛЬ">
    <meta property="og:locale" content="ru_RU">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="КАВ СТАЛЬ | Металлобаза - поставки металлопроката">
    <meta name="twitter:description" content="Поставки металлопроката по Москве и МО.">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/market.png">
    <meta name="robots" content="index, follow">
    <meta name="author" content="ООО 'КАВ Сталь'">
    <meta name="keywords" content="металлобаза, металлопрокат, арматура, балка, круг, лист, труба, Москва, МО, ГОСТ, КАВ СТАЛЬ">
    <link rel="canonical" href="<?php echo $site['baseUrl']; ?>/market">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://www.kavstal.ru">
    <link rel="preconnect" href="<?php echo $site['baseUrl']; ?>" crossorigin>
    <link rel="search" type="application/opensearchdescription+xml" title="КАВ СТАЛЬ" href="<?php echo $site['baseUrl']; ?>/opensearch.xml" />
    <link rel="alternate" type="application/rss+xml" title="КАВ СТАЛЬ — Металлопрокат в Москве" href="<?php echo $site['baseUrl']; ?>/rss.xml" />
    <link rel="icon" type="image/png" href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon.svg" />
    <link rel="shortcut icon" href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Металл" />
    <link rel="manifest" href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/site.webmanifest" />
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "LocalBusiness", "@id": <?= json_encode($site['baseUrl'] . '#business', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "name": "КАВ СТАЛЬ", "url": <?= json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "telephone": "+7-495-989-24-20", "email": "zakaz@kavstal.ru",
                "address": { "@type": "PostalAddress", "streetAddress": "Семёновская площадь, 7", "addressLocality": "Москва", "addressRegion": "Московская область", "postalCode": "107023", "addressCountry": "RU" },
                "openingHours": "Mo-Su 09:00-18:00", "priceRange": "$$"
            },
            {
                "@type": "Store", "@id": <?= json_encode($site['baseUrl'] . '/market', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "name": "КАВ СТАЛЬ - Металлобаза", "description": "Интернет-магазин металлопроката",
                "url": <?= json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "telephone": "+7-495-989-24-20", "email": "zakaz@kavstal.ru",
                "currenciesAccepted": "RUB", "priceRange": "₽₽"
            },
            {
                "@type": "WebSite", "@id": <?= json_encode($site['baseUrl'] . '#website', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "url": <?= json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "name": "КАВ СТАЛЬ",
                "potentialAction": { "@type": "SearchAction", "target": <?= json_encode($site['baseUrl'] . '/search?q={search_term_string}', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>, "query": "required name=search_term_string" }
            }
        ]
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <?php include_once __DIR__ . "/../components/seo-head.php"; ?>
</head>
<body class="pb-20 lg:pb-0">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-red-500 focus:text-white focus:px-4 focus:py-2 focus:rounded-lg">Перейти к основному содержанию</a>

    <?php include './public/components/header-ozon.php'; ?>

    <!-- ===================== MAIN CONTENT ===================== -->
    <main>
        <section class="bg-zinc-50 py-6 md:py-8">
            <div class="mx-auto max-w-7xl px-4">

                <!-- Heading & Filters -->
                <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-6">
                    <div>
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-2" itemscope itemtype="https://schema.org/BreadcrumbList">
                                <li class="inline-flex items-center" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                    <a href="/" class="inline-flex items-center text-sm font-medium text-zinc-500 hover:text-red-500 transition-colors" itemprop="item" itemscope itemtype="https://schema.org/Thing" itemid="<?php echo $site['baseUrl']; ?>/">
                                        <svg class="me-2 h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                        </svg>
                                        <span itemprop="name">Главная</span>
                                    </a>
                                    <meta itemprop="position" content="1">
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-zinc-300 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                                        </svg>
                                        <span class="ms-1 text-sm font-medium text-zinc-400 md:ms-2">Каталог продукции</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                        <h2 class="mt-3 text-xl font-bold text-zinc-900 sm:text-2xl">Металлопрокат</h2>
                    </div>
                    <div class="flex items-center gap-1 bg-zinc-100 rounded-lg p-0.5">
                            <button id="grid-view" class="flex items-center justify-center rounded-md bg-white text-red-500 p-2 shadow-sm transition-colors" title="Сетка">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z" />
                                </svg>
                            </button>
                            <button id="list-view" class="flex items-center justify-center rounded-md border border-zinc-200 bg-white p-2 text-zinc-600 hover:text-red-500 transition-colors" title="Список">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <?php
                $productsOnly = array_filter($products, function ($product) {
                    return !empty($product['categories']['id']) && ($product['badge'] ?? '') !== 'Категория' && ($product['badge'] ?? '') !== 'Подкатегория';
                });
                $searchTerm = $_GET['search'] ?? '';
                if ($searchTerm) {
                    $searchTermLower = mb_strtolower($searchTerm);
                    $productsOnly = array_filter($productsOnly, function ($product) use ($searchTermLower) {
                        $name = mb_strtolower($product['name'] ?? ''); $title = mb_strtolower($product['title'] ?? ''); $description = mb_strtolower($product['description'] ?? '');
                        return mb_strpos($name, $searchTermLower) !== false || mb_strpos($title, $searchTermLower) !== false || mb_strpos($description, $searchTermLower) !== false;
                    });
                }
                $activeCategory = $_GET['category'] ?? ''; $activeMarka = $_GET['marka'] ?? ''; $activeGost = $_GET['gost'] ?? ''; $activeSize = $_GET['size'] ?? '';
                $activePriceFrom = $_GET['price_from'] ?? ''; $activePriceTo = $_GET['price_to'] ?? '';
                if ($activeCategory) { $productsOnly = array_filter($productsOnly, function ($product) use ($activeCategory) { return ($product['categories']['parent_id'] ?? '') === $activeCategory; }); }
                if ($activeMarka) { $productsOnly = array_filter($productsOnly, function ($product) use ($activeMarka) { $val = $product['specs']['Марка'] ?? ''; return $val === $activeMarka; }); }
                if ($activeGost) { $productsOnly = array_filter($productsOnly, function ($product) use ($activeGost) { $val = $product['specs']['ГОСТ'] ?? ''; return $val === $activeGost; }); }
                if ($activeSize) { $productsOnly = array_filter($productsOnly, function ($product) use ($activeSize) { $val = $product['specs']['Размер'] ?? ''; return $val == $activeSize; }); }
                if ($activePriceFrom !== '' && is_numeric($activePriceFrom)) {
                    $pf = (float)$activePriceFrom;
                    $productsOnly = array_filter($productsOnly, function ($product) use ($pf) {
                        $units = $product['units'] ?? []; if (empty($units)) return false;
                        $minPrice = min($units); return $minPrice >= $pf;
                    });
                }
                if ($activePriceTo !== '' && is_numeric($activePriceTo)) {
                    $pt = (float)$activePriceTo;
                    $productsOnly = array_filter($productsOnly, function ($product) use ($pt) {
                        $units = $product['units'] ?? []; if (empty($units)) return false;
                        $minPrice = min($units); return $minPrice <= $pt;
                    });
                }
                $productsOnly = array_values($productsOnly);

                $cacheDir = __DIR__ . '/../file/cache';
                if (!is_dir($cacheDir)) @mkdir($cacheDir, 0755, true);
                $cacheFile = $cacheDir . '/catalog_shuffle.cache';
                $cacheKey = md5(implode(',', array_map(fn($p) => $p['id'] ?? '', $productsOnly)) . count($productsOnly));

                $useCache = false;
                if (file_exists($cacheFile)) {
                    $cached = @unserialize(file_get_contents($cacheFile));
                    if (is_array($cached) && ($cached['key'] ?? '') === $cacheKey) {
                        $cachedIds = $cached['order'];
                        $idMap = [];
                        foreach ($productsOnly as $p) $idMap[$p['id']] = $p;
                        $productsOnly = [];
                        foreach ($cachedIds as $id) {
                            if (isset($idMap[$id])) $productsOnly[] = $idMap[$id];
                        }
                        $useCache = true;
                    }
                }

                if (!$useCache) {
                    shuffle($productsOnly);
                    file_put_contents($cacheFile, serialize(['key' => $cacheKey, 'order' => array_map(fn($p) => $p['id'], $productsOnly)]));
                }

                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
                $itemsPerPage = 48;
                $totalItems = count($productsOnly);
                $totalPages = ceil($totalItems / $itemsPerPage);
                $offset = ($page - 1) * $itemsPerPage;
                $pageProducts = array_slice($productsOnly, $offset, $itemsPerPage);

                // Build filter options
                $filterCategories = []; $filterMarkas = []; $filterGosts = []; $filterSizes = [];
                $allPrices = [];
                foreach ($products as $p) {
                    if (($p['badge'] ?? '') !== '') continue;
                    $cats = $p['categories'] ?? [];
                    if (!empty($cats['parent_id']) && !empty($cats['title'])) {
                        $pid = $cats['parent_id'];
                        if (!isset($filterCategories[$pid])) $filterCategories[$pid] = ['title' => $cats['title'], 'count' => 0];
                        $filterCategories[$pid]['count']++;
                    }
                    if (!empty($p['specs'])) {
                        $specs = $p['specs'];
                        if (!empty($specs['Марка'])) $filterMarkas[$specs['Марка']] = ($filterMarkas[$specs['Марка']] ?? 0) + 1;
                        if (!empty($specs['ГОСТ'])) $filterGosts[$specs['ГОСТ']] = ($filterGosts[$specs['ГОСТ']] ?? 0) + 1;
                        if (!empty($specs['Размер'])) $filterSizes[$specs['Размер']] = ($filterSizes[$specs['Размер']] ?? 0) + 1;
                    }
                    $units = $p['units'] ?? [];
                    if (!empty($units)) $allPrices[] = min($units);
                }
                ksort($filterCategories, SORT_NATURAL | SORT_FLAG_CASE);
                arsort($filterMarkas);  $filterMarkas  = array_slice($filterMarkas, 0, 60, true);
                arsort($filterGosts);   $filterGosts   = array_slice($filterGosts, 0, 60, true);
                arsort($filterSizes);   $filterSizes   = array_slice($filterSizes, 0, 60, true);
                $minSitePrice = !empty($allPrices) ? (int)min($allPrices) : 0;
                $maxSitePrice = !empty($allPrices) ? (int)max($allPrices) : 0;
                ?>

                <div class="flex gap-6 max-w-7xl mx-auto">
                    <!-- Left Sidebar: Filters -->
                    <aside class="hidden lg:block w-64 shrink-0">
                        <div class="sticky top-28 bg-white border border-zinc-200 rounded-xl p-3 space-y-3 max-h-[calc(100vh-120px)] overflow-y-auto">

                            <!-- Категория -->
                            <?php if (!empty($filterCategories)): ?>
                            <div>
                                <div class="flex items-center gap-1.5 text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5 px-2"><svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>Категория</div>
                                <div class="space-y-0.5 max-h-24 overflow-y-auto pr-1">
                                    <?php foreach ($filterCategories as $catSlug => $catInfo):
                                        $params = $_GET; unset($params['page']);
                                        if ($activeCategory === $catSlug) unset($params['category']); else $params['category'] = $catSlug;
                                        $url = '/market?' . http_build_query($params);
                                        $isActive = $activeCategory === $catSlug;
                                    ?>
                                    <a href="<?= htmlspecialchars($url) ?>" class="flex items-center justify-between px-2 py-1.5 rounded-lg text-[13px] transition-colors <?= $isActive ? 'bg-red-50 text-red-500 font-semibold' : 'text-zinc-700 hover:bg-zinc-50' ?>">
                                        <span class="truncate"><?= htmlspecialchars($catInfo['title']) ?></span>
                                        <span class="text-zinc-400 text-[10px] ml-1 flex-shrink-0"><?= $catInfo['count'] ?></span>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Цена -->
                            <div>
                                <div class="flex items-center gap-1.5 text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5 px-2"><svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a1.99 1.99 0 011.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"/></svg>Цена, ₽</div>
                                <form method="GET" action="/market" class="px-2">
                                    <?php foreach (['search','category','marka','size'] as $fk): ?>
                                        <?php if (!empty($_GET[$fk])): ?><input type="hidden" name="<?= $fk ?>" value="<?= htmlspecialchars($_GET[$fk]) ?>"><?php endif; ?>
                                    <?php endforeach; ?>
                                    <div class="flex items-center gap-1.5">
                                        <input type="number" name="price_from" value="<?= htmlspecialchars($activePriceFrom) ?>" placeholder="<?= $minSitePrice ?>" min="0" class="w-full text-xs border border-zinc-200 rounded-lg px-2 py-1.5 focus:outline-none focus:border-red-400 placeholder:text-zinc-300">
                                        <span class="text-zinc-300 text-xs">—</span>
                                        <input type="number" name="price_to" value="<?= htmlspecialchars($activePriceTo) ?>" placeholder="<?= $maxSitePrice ?>" min="0" class="w-full text-xs border border-zinc-200 rounded-lg px-2 py-1.5 focus:outline-none focus:border-red-400 placeholder:text-zinc-300">
                                    </div>
                                    <button type="submit" class="mt-2 w-full text-[11px] font-medium text-white bg-red-500 hover:bg-red-500 rounded-lg py-1.5 transition-colors">Применить</button>
                                </form>
                            </div>

                            <!-- Марка стали -->
                            <?php if (!empty($filterMarkas)): ?>
                            <div>
                                <div class="flex items-center gap-1.5 text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5 px-2"><svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>Марка стали</div>
                                <div class="relative mb-1 px-2">
                                    <input type="text" placeholder="Поиск..." class="filter-search w-full text-[11px] border border-zinc-200 rounded-lg px-2 py-1 pr-6 focus:outline-none focus:border-red-400 placeholder:text-zinc-300" data-target="filter-marka-list">
                                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3 h-3 text-zinc-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4-4m0 0A7 7 0 105 5a7 7 0 0012 0z"/></svg>
                                </div>
                                <div id="filter-marka-list" class="space-y-0.5 max-h-24 overflow-y-auto pr-1">
                                    <?php foreach ($filterMarkas as $val => $count):
                                        $params = $_GET; unset($params['page']);
                                        if ($activeMarka === $val) unset($params['marka']); else $params['marka'] = $val;
                                        $url = '/market?' . http_build_query($params);
                                        $isActive = $activeMarka === $val;
                                    ?>
                                    <a href="<?= htmlspecialchars($url) ?>" class="filter-item flex items-center justify-between px-2 py-1 rounded-lg text-xs transition-colors <?= $isActive ? 'bg-red-50 text-red-500 font-semibold' : 'text-zinc-600 hover:bg-zinc-50' ?>" data-text="<?= strtolower(htmlspecialchars($val)) ?>">
                                        <span class="truncate"><?= htmlspecialchars($val) ?></span>
                                        <span class="text-zinc-400 text-[10px] ml-1 flex-shrink-0"><?= $count ?></span>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Размер -->
                            <?php if (!empty($filterSizes)): ?>
                            <div>
                                <div class="flex items-center gap-1.5 text-xs font-semibold text-zinc-500 uppercase tracking-wider mb-1.5 px-2"><svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>Размер</div>
                                <div class="relative mb-1 px-2">
                                    <input type="text" placeholder="Поиск..." class="filter-search w-full text-[11px] border border-zinc-200 rounded-lg px-2 py-1 pr-6 focus:outline-none focus:border-red-400 placeholder:text-zinc-300" data-target="filter-size-list">
                                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-3 h-3 text-zinc-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4-4m0 0A7 7 0 105 5a7 7 0 0012 0z"/></svg>
                                </div>
                                <div id="filter-size-list" class="space-y-0.5 max-h-24 overflow-y-auto pr-1">
                                    <?php foreach ($filterSizes as $val => $count):
                                        $params = $_GET; unset($params['page']);
                                        if ($activeSize === $val) unset($params['size']); else $params['size'] = $val;
                                        $url = '/market?' . http_build_query($params);
                                        $isActive = $activeSize === $val;
                                    ?>
                                    <a href="<?= htmlspecialchars($url) ?>" class="filter-item flex items-center justify-between px-2 py-1 rounded-lg text-xs transition-colors <?= $isActive ? 'bg-red-50 text-red-500 font-semibold' : 'text-zinc-600 hover:bg-zinc-50' ?>" data-text="<?= strtolower(htmlspecialchars($val)) ?>">
                                        <span><?= htmlspecialchars($val) ?></span>
                                        <span class="text-zinc-400 text-[10px] ml-1 flex-shrink-0"><?= $count ?></span>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>



                            <!-- Сбросить -->
                            <?php if ($activeCategory || $activeMarka || $activeSize || $activePriceFrom !== '' || $activePriceTo !== '' || $searchTerm): ?>
                            <a href="/market" class="block text-center text-xs text-red-500 hover:text-red-500 font-medium py-1.5 rounded-lg hover:bg-red-50 transition-colors border border-red-100">Сбросить все фильтры</a>
                            <?php endif; ?>
                        </div>
                    </aside>

                    <!-- Products Area -->
                    <div class="flex-1 min-w-0">
                    <!-- Products Grid -->
                    <div id="products-container" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5" itemscope itemtype="https://schema.org/ItemList">
                    <?php if (!empty($pageProducts)): ?>
                        <?php foreach ($pageProducts as $product):
                            $canonicalUrl = $product['seo']['canonicalUrl'] ?? '#';
                            $units = $product['units'] ?? [];
                            $firstUnit = array_key_first($units);
                            $firstPrice = $firstUnit ? number_format($units[$firstUnit], 0, '', ' ') : '0';
                            $productImages = $product['images'] ?? [];
                            if (empty($productImages)) $productImages = [$site['baseUrl'] . '/public/assets/images/unknown/unknown.png'];
                            $specLabels = ['Марка', 'Размер', 'ГОСТ', 'диаметр'];
                            $inStock = $product['in_stock'] ?? false;
                        ?>
                        <div itemscope itemtype="https://schema.org/Product" class="product-card border border-zinc-200 hover:border-zinc-300 transition-all duration-200 rounded-xl p-3 flex flex-col w-full">
                            <meta itemprop="category" content="Строительные материалы">
                            <meta itemprop="productID" content="<?php echo htmlspecialchars($product['id']); ?>">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <span class="bg-red-500 text-white text-[11px] px-2 py-0.5 rounded-md font-semibold flex-shrink-0 leading-relaxed"><?php echo !empty($product['badge']) ? htmlspecialchars($product['badge']) : 'Новинка'; ?></span>
                                <button type="button" class="add-to-fav-btn w-7 h-7 rounded-md border border-zinc-200 flex items-center justify-center shrink-0 hover:border-zinc-400 hover:bg-zinc-50 transition-colors" data-pid="<?= htmlspecialchars($product['id'] ?? '') ?>" title="В избранное">
                                    <svg width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.5 10.01l-5.657 3.14a.584.584 0 0 1-.779-.205.54.54 0 0 1-.076-.277V3.61c0-.295.12-.577.335-.786A1.16 1.16 0 0 1 1.843 2.5c.922 0 1.823.435 2.657 1.268a.88.88 0 0 1 .082 1.067c-.47.722-1.285 1.333-2.018 1.626a.88.88 0 0 1-1.134 0L6.5 1.01V10.01z" stroke="#a1a1aa" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                            <a href="<?php echo htmlspecialchars($canonicalUrl); ?>" class="card-image flex items-center justify-center h-[120px] mb-3 rounded-lg overflow-hidden">
                                <img src="<?php echo htmlspecialchars($productImages[0]); ?>" alt="<?php echo htmlspecialchars($product['name'] ?? $product['title'] ?? 'Товар'); ?>" class="max-h-full max-w-full object-contain" loading="lazy" />
                            </a>
                            <div class="card-body flex-1 flex flex-col min-w-0">
                                <a href="<?php echo htmlspecialchars($canonicalUrl); ?>" class="text-[13px] font-semibold text-neutral-800 hover:text-red-500 transition-colors line-clamp-2 leading-snug mb-2 block min-h-[36px]"><?php echo htmlspecialchars($product['name'] ?? $product['title'] ?? 'Товар'); ?></a>
                                <?php if (!empty($product['specs']) && is_array($product['specs'])): ?>
                                <div class="flex flex-wrap gap-1 mb-2">
                                    <?php foreach ($specLabels as $label): $val = $product['specs'][$label] ?? null; if ($val && $val !== ''): ?>
                                    <span class="text-[10px] text-neutral-500 bg-neutral-50 border border-neutral-100 px-1.5 py-0.5 rounded-md font-medium"><?= htmlspecialchars($label) ?>: <strong class="text-neutral-700"><?= htmlspecialchars($val) ?></strong></span>
                                    <?php endif; endforeach; ?>
                                </div>
                                <?php endif; ?>
                                <div class="mt-auto">
                                    <div class="flex items-center gap-1.5 mb-2">
                                        <span class="inline-block w-1.5 h-1.5 rounded-full <?= $inStock ? 'bg-emerald-500' : 'bg-zinc-300' ?>"></span>
                                        <span class="text-[11px] font-medium <?= $inStock ? 'text-emerald-600' : 'text-zinc-400' ?>"><?= $inStock ? 'В наличии' : 'Под заказ' ?></span>
                                    </div>
                                    <div class="flex items-end justify-between gap-2">
                                        <div itemprop="offers" itemscope itemtype="https://schema.org/Offer" class="min-w-0">
                                            <meta itemprop="priceCurrency" content="RUB">
                                            <meta itemprop="availability" content="<?= $inStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' ?>">
                                            <div itemprop="price" content="<?php echo $firstPrice; ?>" class="price-display text-[15px] font-bold text-neutral-900 leading-tight"><?php echo $firstPrice; ?> ₽</div>
                                            <div class="flex gap-0.5 mt-1">
                                                <?php foreach ($units as $unit => $price): ?>
                                                <button type="button" class="text-[9px] px-1.5 py-0.5 rounded font-medium transition-all <?= $unit === $firstUnit ? 'bg-red-100 text-red-500' : 'bg-neutral-100 text-neutral-500 hover:bg-red-50 hover:text-red-500' ?>" data-unit="<?php echo htmlspecialchars($unit); ?>" data-price="<?php echo htmlspecialchars($price); ?>" onclick="switchUnit(this)"><?php echo htmlspecialchars($unit); ?></button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <button type="button" class="add-to-cart-btn w-8 h-8 rounded-full bg-red-500 hover:bg-red-500 text-white flex items-center justify-center shrink-0 transition-colors" data-pid="<?= htmlspecialchars($product['id'] ?? '') ?>" data-unit="<?= htmlspecialchars($firstUnit ?? '') ?>" title="В корзину">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="flex flex-col items-center justify-center py-16 text-center w-full min-w-[300px]">
                            <svg class="mb-4 h-12 w-12 text-neutral-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4-4M3 11a8 8 0 1 0 16 0 8 8 0 0 0-16 0Z"/>
                            </svg>
                            <h3 class="text-sm font-semibold text-neutral-800">Товары не найдены</h3>
                            <p class="mt-1 text-xs text-neutral-500 max-w-xs"><?php if ($searchTerm): ?>По запросу &laquo;<?php echo htmlspecialchars($searchTerm); ?>?&raquo; ничего не найдено.<?php else: ?>К сожалению, товаров нет.<?php endif; ?></p>
                            <?php if ($searchTerm): ?>
                            <a href="/market" class="mt-3 inline-flex items-center text-xs font-medium text-red-500 hover:text-red-500">
                                <svg class="mr-1 h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h13M10 6l3 3-3 3"/></svg>
                                Сбросить поиск
                            </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalItems > 0): ?>
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                    <p class="text-xs text-neutral-500">Показано <span class="font-semibold text-neutral-800"><?= min($offset + $itemsPerPage, $totalItems) ?></span> из <span class="font-semibold text-neutral-800"><?= $totalItems ?></span></p>
                    <?php if ($totalPages > 1): ?>
                    <nav class="inline-flex items-center gap-1" aria-label="Pagination">
                        <?php $queryParams = $_GET; if ($page > 1): $queryParams['page'] = $page - 1; $prevUrl = '/market?' . http_build_query($queryParams); ?>
                        <a href="<?php echo htmlspecialchars($prevUrl); ?>" aria-label="Предыдущая страница" class="inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white px-2.5 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 hover:text-zinc-700 transition-colors">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/></svg>
                        </a>
                        <?php endif; $range = 2; $showPages = []; $showPages[] = 1; for ($i = max(2, $page - $range); $i <= min($totalPages - 1, $page + $range); $i++) { $showPages[] = $i; } if ($totalPages > 1) $showPages[] = $totalPages; $showPages = array_unique($showPages); sort($showPages); $prevPage = 0; foreach ($showPages as $i): if ($prevPage > 0 && $i > $prevPage + 1): ?>
                        <span class="px-1.5 text-sm text-zinc-400">...</span>
                        <?php endif; $prevPage = $i; $queryParams['page'] = $i; $pageUrl = '/market?' . http_build_query($queryParams); $active = $i === $page; ?>
                        <a href="<?php echo htmlspecialchars($pageUrl); ?>" class="<?= $active ? 'bg-red-500 text-white border-red-500 shadow-sm' : 'border border-zinc-200 bg-white text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900' ?> inline-flex items-center justify-center rounded-lg min-w-[36px] h-9 px-2 text-sm font-medium transition-colors"><?php echo $i; ?></a>
                        <?php endforeach; if ($page < $totalPages): $queryParams['page'] = $page + 1; $nextUrl = '/market?' . http_build_query($queryParams); ?>
                        <a href="<?php echo htmlspecialchars($nextUrl); ?>" aria-label="Следующая страница" class="inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white px-2.5 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 hover:text-zinc-700 transition-colors">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                        </a>
                        <?php endif; ?>
                    </nav>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once './public/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js" defer></script>
    <script src="/public/assets/scripts/components/catalog.min.js" defer></script>
    <script>
    function __initCatalog(){ if (typeof window.catalogAPI !== 'undefined') { window.catalogAPI.init(); } }
    if (window.jQuery) { jQuery(__initCatalog); } else { document.addEventListener('DOMContentLoaded', __initCatalog); }
    </script>
    <script>
    window.switchUnit = function(button) {
        var parent = button.parentElement;
        Array.from(parent.querySelectorAll('button')).forEach(function(b) {
            b.classList.remove('bg-red-100', 'text-red-500');
            b.classList.add('bg-neutral-100', 'text-neutral-500');
        });
        button.classList.remove('bg-neutral-100', 'text-neutral-500');
        button.classList.add('bg-red-100', 'text-red-500');
        var card = button.closest('[itemscope]');
        if (card) { var pd = card.querySelector('.price-display'); if (pd) pd.textContent = Math.round(parseFloat(button.getAttribute('data-price'))).toLocaleString('ru-RU') + ' ₽'; }
    };

    document.addEventListener('DOMContentLoaded', function() {
        var gv = document.getElementById('grid-view'), lv = document.getElementById('list-view'), pc = document.getElementById('products-container');
        if (gv && lv && pc) {
            function setActive(btn, other) {
                btn.classList.add('bg-red-500', 'text-white', 'border-red-500', 'shadow-sm');
                btn.classList.remove('border', 'border-zinc-200', 'bg-white', 'text-zinc-600');
                other.classList.remove('bg-red-500', 'text-white', 'border-red-500', 'shadow-sm');
                other.classList.add('border', 'border-zinc-200', 'bg-white', 'text-zinc-600');
            }
            gv.addEventListener('click', function() {
                pc.classList.remove('list-view');
                pc.className = 'grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5';
                setActive(gv, lv);
            });
            lv.addEventListener('click', function() {
                pc.classList.remove('grid', 'grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3');
                pc.classList.add('list-view');
                pc.className = 'flex flex-col gap-3 list-view';
                setActive(lv, gv);
            });
        }

        document.querySelectorAll('.filter-search').forEach(function(input) {
            input.addEventListener('input', function() {
                var q = this.value.toLowerCase().trim();
                var list = document.getElementById(this.getAttribute('data-target'));
                if (!list) return;
                list.querySelectorAll('.filter-item').forEach(function(item) {
                    var text = item.getAttribute('data-text') || '';
                    item.style.display = text.indexOf(q) !== -1 ? '' : 'none';
                });
            });
        });
    });
    </script>
</body>
</html>