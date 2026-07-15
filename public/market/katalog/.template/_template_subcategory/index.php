<?php
// =====================
// Универсальный шаблон подкатегории
// Получаем все товары и фильтруем по текущей подкатегории
$allProducts = Setting\route\function\Functions::listProducts();

// Фильтруем товары текущей подкатегории
$tableProducts = array_filter($allProducts, function ($p) use ($tableName) {
    $catId = $p['categories']['id'] ?? '';
    return $catId === $tableName && empty($p['badge']); // только товары (не категории/подкатегории)
});

// Сбрасываем ключи массива для корректного отображения
$tableProducts = array_values($tableProducts);

// Автогенерация страниц всех товаров подкатегории
foreach ($tableProducts as $productItem) {
    $productId = $productItem['id'] ?? null;
    $productCat = $productItem['categories'] ?? [];
    $parentCatId = $productCat['parent_id'] ?? $katalog ?? '';
    $subCatId = $productCat['id'] ?? $tableName;

    if ($productId && $subCatId) {
        $productPath = "./public/market/katalog/$parentCatId/$subCatId/$productId/index.php";
        if (!file_exists($productPath)) {
            Setting\route\function\Functions::autoGeneratePage(
                $productPath,
                [
                    'katalog' => $parentCatId,
                    'subcategory' => $subCatId,
                    'name' => $productId
                ]
            );
        }
    }
}

// Ищем информацию о подкатегории в виртуальных записях
$subcategoryInfo = null;
foreach ($allProducts as $p) {
    if (($p['badge'] ?? '') === 'Подкатегория' && ($p['id'] ?? '') === $tableName) {
        $subcategoryInfo = $p;
        break;
    }
}

// Берём информацию о подкатегории
$firstRow = $tableProducts[0] ?? [];
$INFO = [
    'id' => $tableName,
    'title' => $subcategoryInfo['title'] ?? $firstRow['categories']['subcategory_title'] ?? 'Категория',
    'name' => $subcategoryInfo['name'] ?? $firstRow['categories']['subcategory_title'] ?? 'Категория',
    'description' => $firstRow['description'] ?? '',
    'seo' => $subcategoryInfo['seo'] ?? $firstRow['seo'] ?? ['canonicalUrl' => '/market/katalog/' . ($katalog ?? '') . '/' . $tableName],
    'categories' => $subcategoryInfo['categories'] ?? $firstRow['categories'] ?? ['parent_id' => $katalog],
];

$site = Setting\route\function\Functions::site();
// =====================

// Извлекаем уникальные значения для фильтров
$filterDiameters = [];
$filterMarkas = [];
$filterGosts = [];
foreach ($allProducts as $p) {
    if (!empty($p['диаметр'])) $filterDiameters[] = $p['диаметр'];
    if (!empty($p['title'])) $filterMarkas[] = $p['title'];
    if (!empty($p['specs']['ГОСТ'])) $filterGosts[] = $p['specs']['ГОСТ'];
}
$uniqueDiameters = array_values(array_unique($filterDiameters));
sort($uniqueDiameters);
$uniqueMarkas = array_values(array_unique($filterMarkas));
sort($uniqueMarkas);
$uniqueGosts = array_values(array_unique($filterGosts));
sort($uniqueGosts);

// Собираем список всех категорий для боковой панели
$allCategories = [];
foreach ($allProducts as $p) {
    if (($p['badge'] ?? '') === 'Категория') {
        $allCategories[] = $p;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($INFO['title'] ?? 'Категория') ?> – цены, сортамент, характеристики | КАВ СТАЛЬ</title>
    <meta name="description"
        content="<?= htmlspecialchars($INFO['description'] ?? ($INFO['title'] ?? '') . ' - купить в Москве по выгодной цене. Поставка металлопроката от КАВ СТАЛЬ.') ?>">
    <meta name="keywords"
        content="<?= htmlspecialchars($INFO['title'] ?? '') ?>, <?= htmlspecialchars($INFO['name'] ?? $INFO['title'] ?? '') ?>, купить <?= htmlspecialchars($INFO['title'] ?? '') ?> в Москве, <?= htmlspecialchars($INFO['title'] ?? '') ?> цена за тонну, металлопрокат москва, сортовой прокат, доставка металлопроката, <?= htmlspecialchars($INFO['categories']['title'] ?? '') ?>">
    <link rel="canonical"
        href="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($INFO['seo']['canonicalUrl'] ?? '/market') ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= htmlspecialchars($INFO['title'] ?? 'Категория') ?> – цены, сортамент, характеристики | КАВ СТАЛЬ">
    <meta property="og:description" content="<?= htmlspecialchars($INFO['description'] ?? ($INFO['title'] ?? '')) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url"
        content="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($INFO['seo']['canonicalUrl'] ?? '/market') ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company'] ?? 'КАВ СТАЛЬ') ?>">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/market.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($INFO['title'] ?? 'Категория') ?> – цены, сортамент, характеристики | КАВ СТАЛЬ">
    <meta name="twitter:description" content="<?= htmlspecialchars($INFO['description'] ?? ($INFO['title'] ?? '')) ?>">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/market.png">

    <!-- Additional SEO Meta Tags -->
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= htmlspecialchars($site['company'] ?? 'КАВ СТАЛЬ') ?>">

    <!-- Resource Hints -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="<?php echo $site['baseUrl']; ?>" crossorigin>

    <!-- favicon -->
    <link rel="icon" type="image/png"
        href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml"
        href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon.svg" />
    <link rel="shortcut icon" href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Металл" />
    <link rel="manifest" href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/site.webmanifest" />

    <!-- Structured Data JSON-LD -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "CollectionPage",
            "name": "<?= htmlspecialchars($INFO['title'] ?? 'Категория') ?>",
            "description": "<?= htmlspecialchars($INFO['description'] ?? ($INFO['title'] ?? '')) ?>",
            "url": <?= json_encode($site['baseUrl'] . ($INFO['seo']['canonicalUrl'] ?? '/market'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
        }
    </script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Local Styles -->
    <link rel="preload" href="/public/assets/styles/catalog.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="/public/assets/styles/main.css">
    </noscript>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body class="bg-gray-50">

    <!-- Mobile Menu Styles -->
    <style>
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        .mobile-menu.active {
            transform: translateX(0);
        }
        .mobile-menu-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }
        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .mobile-menu-toggle span:nth-child(1) {
            transform-origin: top left;
        }
        .mobile-menu-toggle span:nth-child(3) {
            transform-origin: bottom left;
        }
        .mobile-menu.active .mobile-menu-toggle span:nth-child(1) {
            transform: rotate(45deg) translate(3px, -3px);
        }
        .mobile-menu.active .mobile-menu-toggle span:nth-child(2) {
            opacity: 0;
        }
        .mobile-menu.active .mobile-menu-toggle span:nth-child(3) {
            transform: rotate(-45deg) translate(3px, 3px);
        }
    </style>

    <!-- Inline Header -->
    <header class="bg-white border-b border-gray-200 fixed w-full top-0 z-50">
        <nav class="mx-auto px-6 py-4 lg:py-0 max-w-7xl">
            <div class="flex justify-between items-center">
                <a href="/" class="relative flex items-center">
                    <img loading="lazy" class="h-12 translate-y-1"
                        src="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg"
                        alt="<?= htmlspecialchars($site['company']) ?>">
                </a>
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="/#catalog" class="py-6 text-gray-600 hover:text-red-600 transition">Каталог</a>
                    <a href="/market" class="py-6 text-gray-600 hover:text-red-600 transition">Купить металл</a>
                    <a href="/#calculator" class="py-6 text-gray-600 hover:text-red-600 transition">Калькулятор</a>
                    <a href="/#prices" class="py-6 text-gray-600 hover:text-red-600 transition">Цены</a>
                    <a href="/#about" class="py-6 text-gray-600 hover:text-red-600 transition">О компании</a>
                    <a href="/#contacts" class="py-6 text-gray-600 hover:text-red-600 transition">Контакты</a>
                </div>
                <div class="hidden lg:flex items-center gap-6">
                    <a href="/cart" class="relative p-2 text-gray-700 hover:text-red-600 transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="cart-count-badge absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1">0</span>
                    </a>
                    <div class="flex flex-col justify-center items-center lg:hidden xl:flex">
                        <a href="tel:<?= preg_replace('/[^0-9+]/', '', $site['phone']) ?>"
                            class="text-xl font-bold text-gray-800"><?= htmlspecialchars($site['phone']) ?></a>
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($site['workingHours']) ?></p>
                    </div>
                    <button class="bg-red-600 hidden md:block text-white px-6 rounded-lg hover:bg-red-700 transition py-2" aria-label="Заказать обратный звонок">Заказать звонок</button>
                </div>
                <div class="lg:hidden flex items-center gap-4">
                    <a href="/cart" class="relative text-gray-700 p-2">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span class="cart-count-badge absolute -top-0.5 -right-0.5 bg-red-600 text-white text-[10px] font-bold rounded-full min-w-[16px] h-[16px] flex items-center justify-center px-0.5">0</span>
                    </a>
                    <button class="hidden md:block lg:hidden text-sm bg-red-600 text-white p-2 rounded-lg hover:bg-red-700 transition" aria-label="Заказать звонок">Заказать звонок</button>
                    <button class="lg:hidden mobile-menu-toggle p-2" aria-label="Открыть меню">
                        <div class="relative w-6 h-5">
                            <span class="absolute top-0 left-0 w-full h-0.5 bg-gray-800 transition-all duration-300"></span>
                            <span class="absolute top-2 left-0 w-full h-0.5 bg-gray-800 transition-all duration-300"></span>
                            <span class="absolute top-4 left-0 w-full h-0.5 bg-gray-800 transition-all duration-300"></span>
                        </div>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>
    <div class="mobile-menu fixed left-0 top-0 h-full w-80 bg-white shadow-xl z-50 lg:hidden overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-8">
                <a href="/" class="relative flex items-center">
                    <img loading="lazy" class="h-12 translate-y-1"
                        src="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg"
                        alt="<?= htmlspecialchars($site['company']) ?>">
                </a>
                <button class="mobile-menu-close p-2" aria-label="Закрыть меню">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav class="space-y-4 mb-8">
                <a href="/#catalog" class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">Каталог <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                <a href="/market" class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">Купить металл <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                <a href="/#calculator" class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">Калькулятор <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                <a href="/#prices" class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">Цены <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                <a href="/#about" class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">О компании <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                <a href="/#contacts" class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">Контакты <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
            </nav>
            <div class="border-t pt-6">
                <div class="text-center mb-6">
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $site['phone']) ?>" class="text-2xl font-bold text-gray-800 block mb-2"><?= htmlspecialchars($site['phone']) ?></a>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($site['workingHours']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 pt-32 pb-12">
        <!-- Breadcrumb -->
        <div class="bg-white border-b border-gray-200 mb-6 rounded-lg shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-2">
                <nav class="flex items-center space-x-2 text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="/" class="text-gray-600 hover:text-red-600 transition-colors" itemprop="item" itemscope
                            itemtype="https://schema.org/Thing" itemid="<?php echo $site['baseUrl']; ?>/">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span itemprop="name">Главная</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </span>
                    <span class="text-gray-400">/</span>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="/market" class="text-gray-600 hover:text-red-600 transition-colors" itemprop="item"
                            itemscope itemtype="https://schema.org/Thing"
                            itemid="<?php echo $site['baseUrl']; ?>/market">
                            <span itemprop="name">Каталог</span>
                        </a>
                        <meta itemprop="position" content="2">
                    </span>
                    <span class="text-gray-400">/</span>
                    <?php
                    $parentId = $INFO['categories']['parent_id'] ?? $katalog ?? null;
                    $parentTitle = $INFO['categories']['title'] ?? $katalog ?? null;
                    if ($parentId && $parentTitle):
                        ?>
                        <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a href="/market/katalog/<?= htmlspecialchars($parentId) ?>"
                                class="text-gray-600 hover:text-red-600 transition-colors" itemprop="item" itemscope
                                itemtype="https://schema.org/Thing"
                                itemid="<?php echo $site['baseUrl']; ?>/market/katalog/<?= htmlspecialchars($parentId) ?>">
                                <span itemprop="name"><?= htmlspecialchars($parentTitle) ?></span>
                            </a>
                            <meta itemprop="position" content="3">
                        </span>
                        <span class="text-gray-400">/</span>
                    <?php endif; ?>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span itemprop="name"
                            class="text-gray-900 font-medium"><?= htmlspecialchars($INFO['title'] ?? 'Категория') ?></span>
                        <meta itemprop="position" content="<?= ($parentId && $parentTitle) ? '4' : '3' ?>">
                    </span>
                </nav>
            </div>
        </div>

        <!-- Two-Column Layout -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Sidebar -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sticky top-28">
                    <!-- Categories Section -->
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            Категории
                        </h3>
                        <ul class="space-y-1">
                            <?php foreach ($allCategories as $cat): ?>
                                <li>
                                    <a href="/market/katalog/<?= htmlspecialchars($cat['id']) ?>"
                                        class="block px-3 py-2 text-sm text-gray-700 rounded-lg transition-colors <?= ($cat['id'] === $katalog) ? 'bg-red-50 text-red-600 font-medium' : 'hover:bg-gray-100' ?>">
                                        <?= htmlspecialchars($cat['title']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Filters Section -->
                    <div class="border-t pt-5">
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Фильтры
                        </h3>

                        <!-- Diameter Filter -->
                        <?php if (!empty($uniqueDiameters)): ?>
                            <div class="mb-4">
                                <label class="block text-xs font-medium text-gray-500 mb-2">Диаметр</label>
                                <select class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none">
                                    <option value="">Все диаметры</option>
                                    <?php foreach ($uniqueDiameters as $d): ?>
                                        <option value="<?= htmlspecialchars($d) ?>"><?= htmlspecialchars($d) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <!-- Marka Filter -->
                        <?php if (!empty($uniqueMarkas)): ?>
                            <div class="mb-4">
                                <label class="block text-xs font-medium text-gray-500 mb-2">Марка стали</label>
                                <select class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none">
                                    <option value="">Все марки</option>
                                    <?php foreach ($uniqueMarkas as $m): ?>
                                        <option value="<?= htmlspecialchars($m) ?>"><?= htmlspecialchars($m) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <!-- GOST Filter -->
                        <?php if (!empty($uniqueGosts)): ?>
                            <div class="mb-4">
                                <label class="block text-xs font-medium text-gray-500 mb-2">ГОСТ</label>
                                <select class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none">
                                    <option value="">Все ГОСТы</option>
                                    <?php foreach ($uniqueGosts as $g): ?>
                                        <option value="<?= htmlspecialchars($g) ?>"><?= htmlspecialchars($g) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <button class="w-full bg-red-600 text-white text-sm font-semibold py-2.5 rounded-lg hover:bg-red-700 transition shadow-sm">
                            Применить
                        </button>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 min-w-0">
                <!-- Subcategory Header -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">
                        <?= htmlspecialchars($INFO['title'] ?? 'Категория') ?> – купить в Москве
                    </h1>
                    <?php if (!empty($INFO['description'])): ?>
                        <p class="text-gray-600 text-sm leading-relaxed"><?= htmlspecialchars($INFO['description']) ?></p>
                    <?php endif; ?>
                    <div class="flex items-center gap-4 mt-4 text-sm text-gray-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <?= count($tableProducts) ?> товаров
                        </span>
                    </div>
                </div>

                <!-- Products Grid -->
                <?php if (!empty($tableProducts)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
                        <?php foreach ($tableProducts as $product):
                            $productName = $product['name'] ?? 'Без названия';
                            $productBrand = $product['title'] ?? '';
                            $diameter = $product['диаметр'] ?? '';
                            $inStock = $product['in_stock'] ?? false;
                            $productUrl = $product['seo']['canonicalUrl'] ?? '#';
                            $productImages = $product['images'] ?? [];
                            $firstImage = !empty($productImages) ? $productImages[0] : ($site['baseUrl'] . '/public/assets/images/unknown/unknown.png');
                            $gost = $product['specs']['ГОСТ'] ?? '';
                            $firstUnitName = !empty($product['units']) ? array_key_first($product['units']) : '';
                            $firstUnitPrice = !empty($product['units']) ? $product['units'][$firstUnitName] : 0;
                            ?>
                            <article class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col">
                                <!-- Product Image -->
                                <a href="<?= htmlspecialchars($productUrl) ?>" class="block relative overflow-hidden bg-gray-100">
                                    <img loading="lazy" src="<?= htmlspecialchars($firstImage) ?>"
                                        alt="<?= htmlspecialchars($productName) ?>"
                                        class="w-full h-48 object-contain p-4 hover:scale-105 transition-transform duration-300">
                                </a>
                                <!-- Product Info -->
                                <div class="p-4 flex flex-col flex-1">
                                    <a href="<?= htmlspecialchars($productUrl) ?>" class="block mb-3">
                                        <h3 class="text-sm font-semibold text-gray-900 leading-snug hover:text-red-600 transition-colors line-clamp-2">
                                            <?= htmlspecialchars($productName) ?>
                                        </h3>
                                    </a>
                                    <!-- Specs Tags -->
                                    <div class="flex flex-wrap gap-1.5 mb-3">
                                        <?php if ($productBrand): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                <?= htmlspecialchars($productBrand) ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($diameter): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                                Ø <?= htmlspecialchars($diameter) ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($gost): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                                <?= htmlspecialchars($gost) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Price -->
                                    <div class="mt-auto">
                                        <?php if (!empty($product['units'])): ?>
                                            <?php $firstPrice = reset($product['units']); $firstUnit = key($product['units']); ?>
                                            <div class="text-2xl font-bold text-gray-900">
                                                <?= number_format($firstPrice, 0, '', ' ') ?>
                                                <span class="text-sm font-normal text-gray-500">₽</span>
                                            </div>
                                            <div class="text-xs text-gray-500 mb-3">за <?= htmlspecialchars($firstUnit) ?></div>
                                        <?php else: ?>
                                            <div class="text-sm text-gray-400 mb-3">Цена по запросу</div>
                                        <?php endif; ?>
                                        <!-- Add to Cart -->
                                        <div class="flex items-center gap-1.5" data-pid="<?= htmlspecialchars($product['id'] ?? '') ?>">
                                            <?php if ($inStock): ?>
                                                <span class="inline-flex items-center gap-1 text-[10px] font-medium text-green-600 shrink-0">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                    В наличии
                                                </span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center gap-1 text-[10px] font-medium text-red-500 shrink-0">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    Под заказ
                                                </span>
                                            <?php endif; ?>
                                            <?php $firstU = !empty($product['units']) ? array_key_first($product['units']) : ''; ?>
                                            <input type="number" value="1" min="1"
                                                class="cart-qty w-12 h-8 text-center border border-gray-200 rounded-lg text-xs focus:outline-none"
                                                data-pid="<?= htmlspecialchars($product['id'] ?? '') ?>">
                                            <span class="text-[10px] text-gray-400 w-6"><?= htmlspecialchars($firstU) ?></span>
                                            <button type="button"
                                                class="add-to-cart-btn bg-red-600 hover:bg-red-700 text-white text-xs font-semibold py-1.5 px-2.5 rounded-lg transition flex items-center justify-center gap-1 shrink-0"
                                                data-pid="<?= htmlspecialchars($product['id'] ?? '') ?>"
                                                data-unit="<?= htmlspecialchars($firstU) ?>">
                                                <i class="fas fa-shopping-cart text-[10px]"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <p class="text-gray-500 text-lg">В этой категории пока нет товаров.</p>
                        <p class="text-gray-400 text-sm mt-1">Попробуйте выбрать другую категорию.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="/public/assets/scripts/main/header.js" defer></script>

    <!-- Mobile Menu Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.querySelector('.mobile-menu-toggle');
            const close = document.querySelector('.mobile-menu-close');
            const menu = document.querySelector('.mobile-menu');
            const overlay = document.querySelector('.mobile-menu-overlay');

            function openMenu() {
                menu.classList.add('active');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeMenu() {
                menu.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (toggle) toggle.addEventListener('click', openMenu);
            if (close) close.addEventListener('click', closeMenu);
            if (overlay) overlay.addEventListener('click', closeMenu);
        });
    </script>

    <script>
    function updateCartCount() {
        fetch('/api/cart/count').then(r => r.json()).then(d => {
            document.querySelectorAll('.cart-count-badge').forEach(el => {
                el.textContent = d.count > 99 ? '99+' : d.count;
                el.style.display = d.count > 0 ? 'flex' : 'none';
            });
        });
    }

    function addToCart(pid, qty, unit) {
        const fd = new URLSearchParams();
        fd.append('product_id', pid);
        fd.append('quantity', qty);
        fd.append('unit', unit);
        return fetch('/api/cart/add', { method: 'POST', body: fd }).then(r => r.json());
    }

    updateCartCount();
    fetch('/api/cart/products').then(r => r.json()).then(d => {
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

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('[data-pid]');
                const pid = this.dataset.pid;
                const qtyInput = card.querySelector('.cart-qty');
                const qty = parseFloat(qtyInput ? qtyInput.value : 1) || 1;
                const unit = this.dataset.unit;
                const wasInCart = this.classList.contains('in-cart');
                const originalCart = '<i class="fas fa-shopping-cart text-[10px]"></i> В корзину';
                const originalInCart = '<i class="fas fa-plus"></i>';

                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                addToCart(pid, qty, unit).then(r => {
                    if (r.success) {
                        this.innerHTML = '<i class="fas fa-plus"></i>';
                        this.classList.add('bg-green-600', 'in-cart');
                        setTimeout(() => {
                            this.disabled = false;
                            this.innerHTML = originalInCart;
                        }, 1500);
                        updateCartCount();
                    } else {
                        this.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
                        setTimeout(() => {
                            this.disabled = false;
                            this.innerHTML = wasInCart ? originalInCart : originalCart;
                        }, 2000);
                    }
                }).catch(() => {
                    this.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
                    setTimeout(() => {
                        this.disabled = false;
                        this.innerHTML = wasInCart ? originalInCart : originalCart;
                    }, 2000);
                });
            });
        });
    });
    </script>
</body>

</html>
