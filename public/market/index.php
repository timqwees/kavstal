<?php
$site = Setting\route\function\Functions::site();
$products = Setting\route\function\Functions::getMarketProducts();
$hasFilters = !empty($_GET['search']) || !empty($_GET['marka']) || !empty($_GET['gost']) || !empty($_GET['size']) || !empty($_GET['price_from']) || !empty($_GET['price_to']) || (isset($_GET['stock']) && (string) $_GET['stock'] === '1');
$marketPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$noindexMarket = $hasFilters || $marketPage > 1;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>КАВ СТАЛЬ | Поставки металлопроката по Москве и МО</title>
    <meta name="description" content="КАВ СТАЛЬ — поставки металлопроката по Москве и МО. Арматура, балка, круг, лист, полоса, проволока, профнастил, сваи, рельс, сетка, труба, уголок, швеллер и другая продукция.">
    <meta property="og:title" content="КАВ СТАЛЬ | Поставки металлопроката по Москве и МО">
    <meta property="og:description" content="КАВ СТАЛЬ — поставки металлопроката по Москве и МО. Арматура, балка, круг, лист, полоса, проволока, профнастил, сваи, рельс, сетка, труба, уголок, швеллер.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $site['baseUrl']; ?>/market">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/market.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="КАВ СТАЛЬ">
    <meta property="og:locale" content="ru_RU">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="КАВ СТАЛЬ | Поставки металлопроката">
    <meta name="twitter:description" content="Поставки металлопроката по Москве и МО.">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/market.png">
    <meta name="robots" content="<?= $noindexMarket ? 'noindex, follow' : 'index, follow' ?>">
    <meta name="author" content="ООО 'КАВ Сталь'">
    <meta name="keywords" content="металлопрокат, арматура, балка, круг, лист, труба, Москва, МО, ГОСТ, КАВ СТАЛЬ">
    <link rel="canonical" href="<?php echo $site['baseUrl']; ?>/market">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap"></noscript>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700;800&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700;800&display=swap"></noscript>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="<?php echo $site['baseUrl']; ?>">
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
                "telephone": "+7-495-989-24-20", "email": "<?= $site['email'] ?>",
                "address": { "@type": "PostalAddress", "streetAddress": "Семёновская площадь, 7", "addressLocality": "Москва", "addressRegion": "Московская область", "postalCode": "107023", "addressCountry": "RU" },
                "openingHours": "Mo-Su 09:00-18:00", "priceRange": "$$"
            },
            {
                "@type": "CollectionPage", "@id": <?= json_encode($site['baseUrl'] . '/market', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "name": "Каталог металлопроката КАВ СТАЛЬ", "description": "Поставки металлопроката по Москве и МО",
                "url": <?= json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "telephone": "+7-495-989-24-20", "email": "<?= $site['email'] ?>",
                "currenciesAccepted": "RUB", "priceRange": "₽₽"
            },
            {
                "@type": "WebSite", "@id": <?= json_encode($site['baseUrl'] . '#website', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "url": <?= json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "name": "КАВ СТАЛЬ",
                "potentialAction": { "@type": "SearchAction", "target": <?= json_encode($site['baseUrl'] . '/market?search={search_term_string}', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>, "query": "required name=search_term_string" }
            }
        ]
    }
    </script>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>
    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <script src="/public/assets/scripts/components/cart-favorites.min.js" defer></script>
    <link rel="preload" href="/public/assets/styles/catalog.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="/public/assets/styles/catalog.min.css"></noscript>
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"></noscript>
  <?php include_once __DIR__ . "/../components/seo-head.php"; ?>
</head>
<body class="pb-20 lg:pb-0">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-red-500 focus:text-white focus:px-4 focus:py-2 focus:rounded-lg">Перейти к основному содержанию</a>

    <?php include './public/components/header-market.php'; ?>

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
                        <h1 class="mt-3 text-xl font-bold text-zinc-900 sm:text-2xl">Металлопрокат</h1>
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
                $catTreeData = \Setting\route\function\Functions::getCatalogTree();
                $catTreeCategories = $catTreeData['categories'] ?? [];
                $catTreeSubcategories = $catTreeData['subcategories'] ?? [];
                $catIconMap = [
                    'armatura' => '/public/assets/images/icons/product_icons/арматура.webp',
                    'balki' => '/public/assets/images/icons/product_icons/балки.webp',
                    'truby' => '/public/assets/images/icons/product_icons/трубы.webp',
                    'ugolok' => '/public/assets/images/icons/product_icons/угол.webp',
                    'setka' => '/public/assets/images/icons/product_icons/сетка.webp',
                    'shveller' => '/public/assets/images/icons/product_icons/швеллер.webp',
                    'profnastil' => '/public/assets/images/icons/product_icons/профнастил.webp',
                    'provoloka' => '/public/assets/images/icons/product_icons/проволка.webp',
                    'vodostochnaya-sistema' => '/public/assets/images/icons/product_icons/водосточнаясистема.webp',
                    'krepezh-i-metizy' => '/public/assets/images/icons/product_icons/метизы.webp',
                    'tsvetnye-metally' => '/public/assets/images/icons/product_icons/цветныеметаллы.webp',
                    'detali-truboprovodov' => '/public/assets/images/icons/product_icons/деталитрубопровода.webp',
                    'polimery-i-tekhnicheskie-materialy' => '/public/assets/images/icons/product_icons/полимеры.webp',
                    'truboprovodnaya-armatura' => '/public/assets/images/icons/product_icons/трубопроводнаяарматура.webp',
                    'listovoy-prokat' => '/public/assets/images/icons/product_icons/листовойпрокат.webp',
                    'nerzhaveyushchaya-stal' => '/public/assets/images/icons/product_icons/нержавеющяя сталь.webp',
                    'krug-kvadrat-polosa' => '/public/assets/images/icons/product_icons/кругполосаквадрат.jpg',
                    'izdeliya-i-proektnye-pozitsii' => '/public/assets/images/icons/product_icons/изделияпроектныепозицииоптом.png',
                    'kachestvennye-i-spetsialnye-stali' => '/public/assets/images/icons/product_icons/качественныестали.jpg',
                ];
                ?>
                <div class="max-w-7xl mx-auto mb-6 pl-2 sm:pl-0">
                    <h2 class="text-lg sm:text-xl font-semibold text-zinc-900 leading-snug mb-1">Каталог металлопроката</h2>
                    <p class="text-xs sm:text-sm text-zinc-400 leading-relaxed mb-4">Выберите категорию товара или воспользуйтесь фильтрами для поиска по характеристикам</p>
                    <div class="relative lg:hidden">
                    <div class="flex gap-3 overflow-x-auto pb-3 pl-2 pr-4 -mx-4 sm:flex-wrap sm:overflow-visible sm:pb-0 sm:mx-0 sm:px-0" style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none;" id="cat-slider">
                        <?php foreach ($catTreeCategories as $cat):
                            $catSlug = $cat['id'];
                            $catSubs = $catTreeSubcategories[$catSlug] ?? [];
                            $catCount = (int)($cat['products'] ?? 0);
                        ?>
                            <a href="/market/katalog/<?= htmlspecialchars($catSlug) ?>"
                                class="group relative flex items-center gap-3 bg-white border border-zinc-200 rounded-2xl p-3 hover:border-red-300 hover:shadow-md transition-all duration-200 shrink-0 snap-start w-[72vw] max-w-[280px] sm:w-[calc(50%_-_6px)] sm:max-w-none sm:shrink md:w-[calc(33.333%_-_8px)]">
                                <span class="absolute top-2.5 right-2.5 w-5 h-5 rounded-full bg-zinc-100 text-zinc-400 group-hover:bg-red-500 group-hover:text-white flex items-center justify-center transition-all duration-200">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </span>
                                <div class="w-14 h-14 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-center shrink-0 overflow-hidden group-hover:bg-red-50 group-hover:border-red-100 transition-colors">
                                    <?php if (!empty($catIconMap[$catSlug])): ?>
                                        <img src="<?= htmlspecialchars($catIconMap[$catSlug]) ?>" alt="<?= htmlspecialchars($cat['name']) ?>"
                                            class="object-contain" loading="lazy">
                                    <?php else: ?>
                                        <i class="fas fa-cube text-zinc-300 text-base"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-[13px] font-semibold text-zinc-800 group-hover:text-red-500 transition-colors leading-tight block truncate"><?= htmlspecialchars($cat['name']) ?></span>
                                    <span class="text-[11px] text-zinc-400 leading-tight"><?= $catCount ?> <?= $catCount === 1 ? 'товар' : ($catCount < 5 ? 'товара' : 'товаров') ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <style>#cat-slider::-webkit-scrollbar{display:none}</style>
                    <div class="pointer-events-none absolute right-0 top-0 bottom-3 w-8 bg-gradient-to-l from-white rounded-r-2xl"></div>
                    </div>
                    <style>#cat-desktop{display:none}</style>
                    <div id="cat-desktop" class="cat-desktop-grid gap-3">
                        <?php foreach ($catTreeCategories as $cat):
                            $catSlug = $cat['id'];
                            $catSubs = $catTreeSubcategories[$catSlug] ?? [];
                            $catCount = (int)($cat['products'] ?? 0);
                        ?>
                            <a href="/market/katalog/<?= htmlspecialchars($catSlug) ?>"
                                class="group relative flex items-center gap-3 bg-white border border-zinc-200 rounded-2xl p-4 hover:border-red-300 hover:shadow-md transition-all duration-200">
                                <span class="absolute top-3 right-3 w-6 h-6 rounded-full bg-zinc-100 text-zinc-400 group-hover:bg-red-500 group-hover:text-white flex items-center justify-center transition-all duration-200">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </span>
                                <div class="w-16 h-16 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-center shrink-0 overflow-hidden group-hover:bg-red-50 group-hover:border-red-100 transition-colors">
                                    <?php if (!empty($catIconMap[$catSlug])): ?>
                                        <img src="<?= htmlspecialchars($catIconMap[$catSlug]) ?>" alt="<?= htmlspecialchars($cat['name']) ?>"
                                            class="object-contain" loading="lazy">
                                    <?php else: ?>
                                        <i class="fas fa-cube text-zinc-300 text-lg"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-sm font-semibold text-zinc-800 group-hover:text-red-500 transition-colors leading-tight block truncate"><?= htmlspecialchars($cat['name']) ?></span>
                                    <span class="text-xs text-zinc-400 leading-tight"><?= $catCount ?> <?= $catCount === 1 ? 'товар' : ($catCount < 5 ? 'товара' : 'товаров') ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <style>
                    @media (min-width: 1024px) {
                        #cat-desktop { display: grid !important; grid-template-columns: repeat(5, 1fr); }
                    }
                </style>

                <div class="max-w-7xl mx-auto mt-6 mb-4 pl-2 sm:pl-0">
                    <h1 class="text-base sm:text-lg font-semibold text-zinc-900 leading-snug mb-1">Интернет-магазин металлопроката КАВ СТАЛЬ</h1>
                    <p class="text-xs sm:text-sm text-zinc-400 leading-relaxed">Прямые поставки от производителей. Склад в Москве. Доставка по России.</p>
                </div>

                <?php
                $productsOnly = array_filter($products, function ($product) {
                    return !empty($product['categories']['id']) && ($product['badge'] ?? '') !== 'Категория' && ($product['badge'] ?? '') !== 'Подкатегория';
                });
                $searchTerm = $_GET['search'] ?? '';
                if ($searchTerm) {
                    $searchTermLower = mb_strtolower($searchTerm);
                    $productsOnly = array_filter($productsOnly, function ($product) use ($searchTermLower) {
                        $name = mb_strtolower($product['name'] ?? '');
                        $title = mb_strtolower($product['title'] ?? '');
                        $description = mb_strtolower($product['description'] ?? '');
                        $keywords = mb_strtolower($product['keywords'] ?? '');
                        if (mb_strpos($name, $searchTermLower) !== false || mb_strpos($title, $searchTermLower) !== false || mb_strpos($description, $searchTermLower) !== false || mb_strpos($keywords, $searchTermLower) !== false)
                            return true;
                        $words = array_values(array_filter(explode(' ', $searchTermLower)));
                        if (count($words) < 2)
                            return false;
                        $text = $name . ' ' . $title . ' ' . $description . ' ' . $keywords;
                        foreach ($words as $w) {
                            if (mb_strpos($text, $w) === false)
                                return false;
                        }
                        return true;
                    });
                }
                $activeMarka = $_GET['marka'] ?? '';
                $activeGost = $_GET['gost'] ?? '';
                $activeSize = $_GET['size'] ?? '';
                $activePriceFrom = $_GET['price_from'] ?? '';
                $activePriceTo = $_GET['price_to'] ?? '';
                $fMarka = $activeMarka !== '' ? (array) $activeMarka : [];
                $fGost = $activeGost !== '' ? (array) $activeGost : [];
                $fSize = $activeSize !== '' ? (array) $activeSize : [];
                $fStock = (isset($_GET['stock']) && (string) $_GET['stock'] === '1');
                if (!empty($fMarka)) {
                    $productsOnly = array_filter($productsOnly, function ($product) use ($fMarka) {
                        $val = $product['specs']['Марка'] ?? '';
                        return in_array($val, $fMarka, true); });
                }
                if (!empty($fGost)) {
                    $productsOnly = array_filter($productsOnly, function ($product) use ($fGost) {
                        $val = $product['specs']['ГОСТ'] ?? '';
                        return in_array($val, $fGost, true); });
                }
                if (!empty($fSize)) {
                    $productsOnly = array_filter($productsOnly, function ($product) use ($fSize) {
                        $val = $product['specs']['Размер'] ?? '';
                        return in_array($val, $fSize, true); });
                }
                if ($fStock) {
                    $productsOnly = array_filter($productsOnly, function ($product) {
                        return !empty($product['in_stock']); });
                }
                if ($activePriceFrom !== '' && is_numeric($activePriceFrom)) {
                    $pf = (float) $activePriceFrom;
                    $productsOnly = array_filter($productsOnly, function ($product) use ($pf) {
                        $units = $product['units'] ?? [];
                        if (empty($units))
                            return false;
                        $minPrice = min($units);
                        return $minPrice >= $pf;
                    });
                }
                if ($activePriceTo !== '' && is_numeric($activePriceTo)) {
                    $pt = (float) $activePriceTo;
                    $productsOnly = array_filter($productsOnly, function ($product) use ($pt) {
                        $units = $product['units'] ?? [];
                        if (empty($units))
                            return false;
                        $minPrice = min($units);
                        return $minPrice <= $pt;
                    });
                }
                $productsOnly = array_values($productsOnly);

                $cacheDir = __DIR__ . '/../file/cache';
                if (!is_dir($cacheDir))
                    @mkdir($cacheDir, 0755, true);
                $cacheFile = $cacheDir . '/catalog_shuffle.cache';
                $cacheKey = md5(implode(',', array_map(fn($p) => $p['id'] ?? '', $productsOnly)) . count($productsOnly));

                $useCache = false;
                if (file_exists($cacheFile)) {
                    $cached = @unserialize(file_get_contents($cacheFile));
                    if (is_array($cached) && ($cached['key'] ?? '') === $cacheKey) {
                        $cachedIds = $cached['order'];
                        $idMap = [];
                        foreach ($productsOnly as $p)
                            $idMap[$p['id']] = $p;
                        $productsOnly = [];
                        foreach ($cachedIds as $id) {
                            if (isset($idMap[$id]))
                                $productsOnly[] = $idMap[$id];
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
                $filterCategories = [];
                $filterMarkas = [];
                $filterGosts = [];
                $filterSizes = [];
                $allPrices = [];
                foreach ($products as $p) {
                    if (($p['badge'] ?? '') !== '')
                        continue;
                    $cats = $p['categories'] ?? [];
                    if (!empty($cats['parent_id']) && !empty($cats['title'])) {
                        $pid = $cats['parent_id'];
                        if (!isset($filterCategories[$pid]))
                            $filterCategories[$pid] = ['title' => $cats['title'], 'count' => 0];
                        $filterCategories[$pid]['count']++;
                    }
                    if (!empty($p['specs'])) {
                        $specs = $p['specs'];
                        if (!empty($specs['Марка']))
                            $filterMarkas[$specs['Марка']] = ($filterMarkas[$specs['Марка']] ?? 0) + 1;
                        if (!empty($specs['ГОСТ']))
                            $filterGosts[$specs['ГОСТ']] = ($filterGosts[$specs['ГОСТ']] ?? 0) + 1;
                        if (!empty($specs['Размер']))
                            $filterSizes[$specs['Размер']] = ($filterSizes[$specs['Размер']] ?? 0) + 1;
                    }
                    $units = $p['units'] ?? [];
                    if (!empty($units))
                        $allPrices[] = min($units);
                }
                ksort($filterCategories, SORT_NATURAL | SORT_FLAG_CASE);
                arsort($filterMarkas);
                $filterMarkas = array_slice($filterMarkas, 0, 60, true);
                arsort($filterGosts);
                $filterGosts = array_slice($filterGosts, 0, 60, true);
                arsort($filterSizes);
                $filterSizes = array_slice($filterSizes, 0, 60, true);
                $minSitePrice = !empty($allPrices) ? (int) min($allPrices) : 0;
                $maxSitePrice = !empty($allPrices) ? (int) max($allPrices) : 0;
                ?>

                <div class="flex gap-6 max-w-7xl mx-auto">
                    <!-- Left Sidebar: Filters -->
                    <aside class="hidden lg:block w-64 shrink-0 self-start">
                        <div class="lg:sticky lg:top-[196px] lg:max-h-[calc(100vh-12.5rem)] lg:overflow-y-auto space-y-5 pr-1">

                            <form method="get" action="/market" id="filter-form" class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
                                <?php foreach ($_GET as $fk => $fv): ?>
                                    <?php if ($fk === 'page' || $fk === 'sort')
                                        continue; ?>
                                    <?php if (is_array($fv)): foreach ($fv as $fvv): ?>
                                        <input type="hidden" name="<?= htmlspecialchars($fk) ?>[]" value="<?= htmlspecialchars($fvv) ?>">
                                    <?php endforeach; else: ?>
                                        <input type="hidden" name="<?= htmlspecialchars($fk) ?>" value="<?= htmlspecialchars((string) $fv) ?>">
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <div class="flex items-center justify-between px-4 pt-4 pb-3 border-b border-zinc-100">
                                    <span class="text-xs font-semibold text-zinc-500 uppercase tracking-wider">Фильтры</span>
                                    <?php if ($hasFilters): ?>
                                        <a href="/market" class="text-xs font-medium text-zinc-400 hover:text-red-500 transition-colors">Сбросить</a>
                                    <?php endif; ?>
                                </div>

                                <!-- Filter: Цена -->
                                <div class="filter-group border-b border-zinc-100">
                                    <button type="button" class="filter-group-toggle w-full flex items-center justify-between gap-2 px-4 py-3 text-left transition hover:bg-zinc-50">
                                        <span class="text-sm font-medium text-zinc-700">Цена</span>
                                        <i class="fas fa-chevron-down filter-group-arrow text-[10px] text-zinc-300 transition-transform duration-200"></i>
                                    </button>
                                    <div class="filter-group-body px-4 pt-1.5 pb-5">
                                        <div class="relative">
                                            <div class="grid grid-cols-2 gap-0">
                                                <input type="text" inputmode="numeric" autocomplete="off" name="price_from" id="price-min-input"
                                                    value="<?= $activePriceFrom !== '' ? htmlspecialchars((string) $activePriceFrom) : '' ?>"
                                                    placeholder="<?= number_format($minSitePrice, 0, '', ' ') ?>"
                                                    class="text-sm text-zinc-700 bg-white px-3 py-2.5 rounded-l-lg border border-zinc-200 border-r-0 tabular-nums placeholder:text-zinc-400 focus:outline-none focus:border-zinc-400 focus:z-10 transition">
                                                <input type="text" inputmode="numeric" autocomplete="off" name="price_to" id="price-max-input"
                                                    value="<?= $activePriceTo !== '' ? htmlspecialchars((string) $activePriceTo) : '' ?>"
                                                    placeholder="<?= number_format($maxSitePrice, 0, '', ' ') ?>"
                                                    class="text-sm text-zinc-700 bg-white px-3 py-2.5 rounded-r-lg border border-zinc-200 tabular-nums text-right placeholder:text-zinc-400 focus:outline-none focus:border-zinc-400 focus:z-10 transition">
                                            </div>
                                            <div class="price-slider relative h-5 select-none mt-px"
                                                data-min="<?= $minSitePrice ?>" data-max="<?= max($minSitePrice + 1, $maxSitePrice) ?>"
                                                data-from="<?= $activePriceFrom !== '' ? (int) $activePriceFrom : $minSitePrice ?>"
                                                data-to="<?= $activePriceTo !== '' ? (int) $activePriceTo : $maxSitePrice ?>">
                                                <div class="absolute top-1/2 -translate-y-1/2 left-0 right-0 h-[3px] bg-zinc-200 rounded-full"></div>
                                                <div class="price-slider-active absolute top-1/2 -translate-y-1/2 h-[3px] bg-zinc-900 rounded-full" style="left:0%;right:0%"></div>
                                                <div class="price-slider-handle left absolute left-0 top-1/2 -translate-y-1/2 ml-[-9px] w-[18px] h-[18px] rounded-full bg-white border-[1.5px] border-zinc-900 cursor-grab touch-none shadow-sm" style="left:0%" data-side="from"></div>
                                                <div class="price-slider-handle right absolute left-full top-1/2 -translate-y-1/2 ml-[-9px] w-[18px] h-[18px] rounded-full bg-white border-[1.5px] border-zinc-900 cursor-grab touch-none shadow-sm" style="left:100%" data-side="to"></div>
                                                <div class="absolute top-full left-0 mt-1 text-[10px] text-zinc-400 select-none pointer-events-none">от</div>
                                                <div class="absolute top-full right-0 mt-1 text-[10px] text-zinc-400 select-none pointer-events-none">до</div>
                                            </div>
                                            <button type="submit" class="mt-3.5 w-full inline-flex items-center justify-center gap-2 bg-zinc-900 text-white text-sm font-semibold py-2.5 rounded-lg hover:bg-red-500 hover:text-white transition-colors">
                                                <i class="fas fa-search text-xs"></i> Поиск
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Filter: Марка стали -->
                                <?php if (!empty($filterMarkas)): ?>
                                <div class="filter-group border-b border-zinc-100">
                                    <button type="button" class="filter-group-toggle w-full flex items-center justify-between gap-2 px-4 py-3 text-left transition hover:bg-zinc-50">
                                        <span class="text-sm font-medium text-zinc-700">Марка стали</span>
                                        <i class="fas fa-chevron-down filter-group-arrow text-[10px] text-zinc-300 transition-transform duration-200 <?= empty($fMarka) ? 'rotate-180' : '' ?>"></i>
                                    </button>
                                    <div class="filter-group-body px-4 pt-1.5 pb-4 <?= empty($fMarka) ? 'hidden' : '' ?>">
                                        <div class="relative mb-2.5">
                                            <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] text-zinc-400 pointer-events-none"></i>
                                            <input type="text" placeholder="Поиск…" data-filter-input class="w-full text-xs bg-zinc-50 border border-zinc-200 rounded-md pl-7 pr-2 py-2 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 focus:bg-white transition">
                                        </div>
                                        <div class="space-y-1 max-h-60 overflow-y-auto pr-1.5">
                                            <?php $i = 0; foreach ($filterMarkas as $val => $cnt): $i++; ?>
                                            <label class="flex items-center gap-2 cursor-pointer group px-2 py-2 rounded-md hover:bg-zinc-50 transition <?= $i > 5 ? 'filter-extra hidden' : '' ?>">
                                                <input type="radio" name="marka" value="<?= htmlspecialchars($val) ?>"
                                                    <?= in_array($val, $fMarka, true) ? 'checked' : '' ?>
                                                    onchange="this.form.submit()"
                                                    class="w-4 h-4 accent-red-500 cursor-pointer shrink-0">
                                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 transition truncate"><?= htmlspecialchars($val) ?></span>
                                                <span class="ml-auto text-[11px] text-zinc-400 shrink-0"><?= $cnt ?></span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                        <p class="hidden text-xs text-zinc-400 px-2 py-1.5" data-filter-empty>Ничего не найдено</p>
                                        <?php if (count($filterMarkas) > 5): ?>
                                        <button type="button" class="filter-more-btn mt-2.5 text-xs font-medium text-zinc-500 hover:text-red-500 transition">+ Еще</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- Filter: ГОСТ -->
                                <?php if (!empty($filterGosts)): ?>
                                <div class="filter-group border-b border-zinc-100">
                                    <button type="button" class="filter-group-toggle w-full flex items-center justify-between gap-2 px-4 py-3 text-left transition hover:bg-zinc-50">
                                        <span class="text-sm font-medium text-zinc-700">ГОСТ</span>
                                        <i class="fas fa-chevron-down filter-group-arrow text-[10px] text-zinc-300 transition-transform duration-200 <?= empty($fGost) ? 'rotate-180' : '' ?>"></i>
                                    </button>
                                    <div class="filter-group-body px-4 pt-1.5 pb-4 <?= empty($fGost) ? 'hidden' : '' ?>">
                                        <div class="relative mb-2.5">
                                            <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] text-zinc-400 pointer-events-none"></i>
                                            <input type="text" placeholder="Поиск…" data-filter-input class="w-full text-xs bg-zinc-50 border border-zinc-200 rounded-md pl-7 pr-2 py-2 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 focus:bg-white transition">
                                        </div>
                                        <div class="space-y-1 max-h-60 overflow-y-auto pr-1.5">
                                            <?php $i = 0; foreach ($filterGosts as $val => $cnt): $i++; ?>
                                            <label class="flex items-center gap-2 cursor-pointer group px-2 py-2 rounded-md hover:bg-zinc-50 transition <?= $i > 5 ? 'filter-extra hidden' : '' ?>">
                                                <input type="radio" name="gost" value="<?= htmlspecialchars($val) ?>"
                                                    <?= in_array($val, $fGost, true) ? 'checked' : '' ?>
                                                    onchange="this.form.submit()"
                                                    class="w-4 h-4 accent-red-500 cursor-pointer shrink-0">
                                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 transition truncate"><?= htmlspecialchars($val) ?></span>
                                                <span class="ml-auto text-[11px] text-zinc-400 shrink-0"><?= $cnt ?></span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                        <p class="hidden text-xs text-zinc-400 px-2 py-1.5" data-filter-empty>Ничего не найдено</p>
                                        <?php if (count($filterGosts) > 5): ?>
                                        <button type="button" class="filter-more-btn mt-2.5 text-xs font-medium text-zinc-500 hover:text-red-500 transition">+ Еще</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- Filter: Размер -->
                                <?php if (!empty($filterSizes)): ?>
                                <div class="filter-group border-b border-zinc-100">
                                    <button type="button" class="filter-group-toggle w-full flex items-center justify-between gap-2 px-4 py-3 text-left transition hover:bg-zinc-50">
                                        <span class="text-sm font-medium text-zinc-700">Размер</span>
                                        <i class="fas fa-chevron-down filter-group-arrow text-[10px] text-zinc-300 transition-transform duration-200 <?= empty($fSize) ? 'rotate-180' : '' ?>"></i>
                                    </button>
                                    <div class="filter-group-body px-4 pt-1.5 pb-4 <?= empty($fSize) ? 'hidden' : '' ?>">
                                        <div class="relative mb-2.5">
                                            <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] text-zinc-400 pointer-events-none"></i>
                                            <input type="text" placeholder="Поиск…" data-filter-input class="w-full text-xs bg-zinc-50 border border-zinc-200 rounded-md pl-7 pr-2 py-2 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 focus:bg-white transition">
                                        </div>
                                        <div class="space-y-1 max-h-60 overflow-y-auto pr-1.5">
                                            <?php $i = 0; foreach ($filterSizes as $val => $cnt): $i++; ?>
                                            <label class="flex items-center gap-2 cursor-pointer group px-2 py-2 rounded-md hover:bg-zinc-50 transition <?= $i > 5 ? 'filter-extra hidden' : '' ?>">
                                                <input type="radio" name="size" value="<?= htmlspecialchars($val) ?>"
                                                    <?= in_array($val, $fSize, true) ? 'checked' : '' ?>
                                                    onchange="this.form.submit()"
                                                    class="w-4 h-4 accent-red-500 cursor-pointer shrink-0">
                                                <span class="text-sm text-zinc-600 group-hover:text-zinc-900 transition truncate"><?= htmlspecialchars($val) ?></span>
                                                <span class="ml-auto text-[11px] text-zinc-400 shrink-0"><?= $cnt ?></span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                        <p class="hidden text-xs text-zinc-400 px-2 py-1.5" data-filter-empty>Ничего не найдено</p>
                                        <?php if (count($filterSizes) > 5): ?>
                                        <button type="button" class="filter-more-btn mt-2.5 text-xs font-medium text-zinc-500 hover:text-red-500 transition">+ Еще</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- Filter: В наличии -->
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

                    <!-- Products Area -->
                    <div class="flex-1 min-w-0">
                    <!-- Products Grid -->
                    <div id="products-container" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5" itemscope itemtype="https://schema.org/ItemList">
                    <?php if (!empty($pageProducts)): ?>
                            <?php foreach ($pageProducts as $idx => $product):
                                $cardOpts = ['filter' => false, 'qty' => true, 'swiper' => false, 'itemscope' => true];
                                ?>
                                <?php include __DIR__ . '/../components/product_card.php'; ?>
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
                                <?php $queryParams = $_GET;
                                if ($page > 1):
                                    $queryParams['page'] = $page - 1;
                                    $prevUrl = '/market?' . http_build_query($queryParams); ?>
                                    <a href="<?php echo htmlspecialchars($prevUrl); ?>" aria-label="Предыдущая страница" class="inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white px-2.5 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 hover:text-zinc-700 transition-colors">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/></svg>
                                    </a>
                                <?php endif;
                                $range = 2;
                                $showPages = [];
                                $showPages[] = 1;
                                for ($i = max(2, $page - $range); $i <= min($totalPages - 1, $page + $range); $i++) {
                                    $showPages[] = $i;
                                }
                                if ($totalPages > 1)
                                    $showPages[] = $totalPages;
                                $showPages = array_unique($showPages);
                                sort($showPages);
                                $prevPage = 0;
                                foreach ($showPages as $i):
                                    if ($prevPage > 0 && $i > $prevPage + 1): ?>
                                        <span class="px-1.5 text-sm text-zinc-400">...</span>
                                    <?php endif;
                                    $prevPage = $i;
                                    $queryParams['page'] = $i;
                                    $pageUrl = '/market?' . http_build_query($queryParams);
                                    $active = $i === $page; ?>
                                    <a href="<?php echo htmlspecialchars($pageUrl); ?>" class="<?= $active ? 'bg-red-500 text-white border-red-500 shadow-sm' : 'border border-zinc-200 bg-white text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900' ?> inline-flex items-center justify-center rounded-lg min-w-[36px] h-9 px-2 text-sm font-medium transition-colors"><?php echo $i; ?></a>
                                <?php endforeach;
                                if ($page < $totalPages):
                                    $queryParams['page'] = $page + 1;
                                    $nextUrl = '/market?' . http_build_query($queryParams); ?>
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

    <section class="bg-zinc-50 border-t border-zinc-200">
        <div class="max-w-4xl mx-auto px-4 py-12 md:py-16 text-center">
            <h2 class="section-title mb-3 text-center">Не нашли то, что искали?</h2>
            <p class="text-sm md:text-base text-zinc-500 mb-8 max-w-xl mx-auto">У нас есть все возможные материалы, и некоторые могут не отображаться в каталоге. Оставьте заявку — мы подберём нужный товар и свяжемся с вами.</p>
            <form id="market-feedback-form" data-goal="market_feedback" method="POST" action="/send/email" class="ajax-form max-w-2xl mx-auto">
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-3 mb-4 sm:mb-3">
                    <input type="text" name="name" placeholder="Ваше имя" required
                        class="flex-1 h-14 sm:h-12 px-3 py-2.5 bg-white border border-zinc-300 rounded-xl text-base sm:text-sm outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                    <input type="tel" name="phone" placeholder="Номер телефона" required
                        class="flex-1 h-14 sm:h-12 px-3 py-2.5 bg-white border border-zinc-300 rounded-xl text-base sm:text-sm outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                    <button type="submit"
                        class="h-14 sm:h-12 px-6 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl transition-colors whitespace-nowrap">Отправить</button>
                </div>
                <textarea name="message" placeholder="Что именно вас интересует? (размер, марка стали, количество)" rows="2"
                    class="w-full px-4 py-4 sm:py-3 bg-white border border-zinc-300 rounded-xl text-base sm:text-sm outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all resize-none"></textarea>
                <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
            </form>
        </div>
    </section>

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

        // Filter: collapsible groups (accordion)
        document.querySelectorAll('.filter-group-toggle').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var group = btn.closest('.filter-group');
                if (!group) return;
                var body = group.querySelector('.filter-group-body');
                var arrow = btn.querySelector('.filter-group-arrow');
                if (body) body.classList.toggle('hidden');
                if (arrow) arrow.classList.toggle('rotate-180');
            });
        });

        // Filter: expand hidden values ("+ Еще")
        document.querySelectorAll('.filter-more-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var block = btn.closest('.filter-group-body');
                if (!block) return;
                var extra = block.querySelectorAll('.filter-extra');
                var expanded = btn.getAttribute('data-expanded') === '1';
                extra.forEach(function(el) { el.classList.toggle('hidden', expanded); });
                btn.textContent = expanded ? '+ Еще' : 'Скрыть';
                btn.setAttribute('data-expanded', expanded ? '0' : '1');
            });
        });

        // Filter: live search within group lists
        document.querySelectorAll('[data-filter-input]').forEach(function(input) {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') e.preventDefault();
            });
            input.addEventListener('input', function() {
                var group = input.closest('.filter-group-body');
                if (!group) return;
                var q = input.value.trim().toLowerCase();
                var labels = Array.prototype.slice.call(group.querySelectorAll('label'));
                var visible = 0;
                labels.forEach(function(label, idx) {
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
        document.querySelectorAll('.price-slider').forEach(function(slider) {
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
                handle.addEventListener('pointerdown', function(e) {
                    e.preventDefault();
                    if (!handle.setPointerCapture) return;
                    handle.setPointerCapture(e.pointerId);
                    var moved = false;
                    var move = function(ev) {
                        var v = valueFromPos(ev.clientX);
                        if (side === 'from') setValues(v, to);
                        else setValues(from, v);
                        moved = true;
                    };
                    var up = function() {
                        handle.removeEventListener('pointermove', move);
                        handle.removeEventListener('pointerup', up);
                    };
                    handle.addEventListener('pointermove', move);
                    handle.addEventListener('pointerup', up);
                });
            }
            bindHandle(leftHandle, 'from');
            bindHandle(rightHandle, 'to');

            fromInput.addEventListener('change', function() {
                var v = parseFloat(String(fromInput.value).replace(/[^\d.]/g, ''));
                if (!isNaN(v)) setValues(v, to);
            });
            toInput.addEventListener('change', function() {
                var v = parseFloat(String(toInput.value).replace(/[^\d.]/g, ''));
                if (!isNaN(v)) setValues(from, v);
            });
            fromInput.addEventListener('input', function() {
                var v = parseFloat(String(fromInput.value).replace(/[^\d.]/g, ''));
                if (!isNaN(v)) setValues(v, to);
                else setValues(min, to);
            });
            toInput.addEventListener('input', function() {
                var v = parseFloat(String(toInput.value).replace(/[^\d.]/g, ''));
                if (!isNaN(v)) setValues(from, v);
                else setValues(from, max);
            });
            var form = fromInput.closest('form');
            if (form) {
                form.addEventListener('submit', function() {
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
</body>
</html>