<?php
$categoryID = $katalog ?? basename(dirname(__FILE__));
$allProducts = Setting\route\function\Functions::listProducts();
$category = null;
$productsInCategory = [];

foreach ($allProducts as $product) {
    if ($product['id'] === $categoryID) {
        $category = $product;
    }
    $productCategoryId = $product['categories']['id'] ?? null;
    if ($productCategoryId === $categoryID) {
        $productsInCategory[] = $product;
    }
    if (($product['categories']['parent_id'] ?? null) === $categoryID && ($product['badge'] ?? '') === 'Подкатегория') {
        $productsInCategory[] = $product;
    }
}

shuffle($productsInCategory);

$site = Setting\route\function\Functions::site();

// Extract unique specs for filters
$allDiameters = [];
$allBrands = [];
$allGosts = [];
foreach ($productsInCategory as $item) {
    if (($item['badge'] ?? '') === 'Подкатегория') continue;
    $specs = $item['specs'] ?? [];
    if (!empty($specs['диаметр'])) {
        $allDiameters[] = $specs['диаметр'];
    }
    if (!empty($specs['Марка'])) {
        $allBrands[] = $specs['Марка'];
    } elseif (!empty($specs['марка'])) {
        $allBrands[] = $specs['марка'];
    }
    if (!empty($specs['ГОСТ'])) {
        $allGosts[] = $specs['ГОСТ'];
    } elseif (!empty($specs['гост'])) {
        $allGosts[] = $specs['гост'];
    }
}
$allDiameters = array_values(array_unique(array_filter($allDiameters)));
$allBrands = array_values(array_unique(array_filter($allBrands)));
$allGosts = array_values(array_unique(array_filter($allGosts)));
sort($allDiameters, SORT_NATURAL);
sort($allBrands, SORT_STRING);
sort($allGosts, SORT_NATURAL);

// Separate subcategories and products
$subcategories = array_filter($productsInCategory, function ($item) {
    return ($item['badge'] ?? '') === 'Подкатегория';
});
$products = array_filter($productsInCategory, function ($item) {
    return ($item['badge'] ?? '') !== 'Подкатегория';
});

// Build category tree for sidebar
$categoryTree = [];
foreach ($allProducts as $p) {
    if (($p['badge'] ?? '') === 'Категория' || ($p['badge'] ?? '') === 'Подкатегория') {
        $categoryTree[] = $p;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($category['title'] ?? 'Категория') ?> – цены, сортамент, характеристики | КАВ СТАЛЬ</title>
    <meta name="description"
        content="<?= htmlspecialchars($category['description'] ?? $category['title'] . ' - купить в Москве по выгодной цене. Поставка металлопроката от КАВ СТАЛЬ.') ?>">
    <meta name="keywords"
        content="<?= htmlspecialchars($category['title']) ?>, <?= htmlspecialchars($category['name'] ?? $category['title']) ?>, купить <?= htmlspecialchars($category['title']) ?> в Москве, <?= htmlspecialchars($category['title']) ?> цена за тонну, металлопрокат москва, сортовой прокат, доставка металлопроката">
    <link rel="canonical"
        href="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($category['seo']['canonicalUrl'] ?? '/market') ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= htmlspecialchars($category['title'] ?? 'Категория') ?> – цены, сортамент, характеристики | КАВ СТАЛЬ">
    <meta property="og:description" content="<?= htmlspecialchars($category['description'] ?? $category['title']) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url"
        content="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($category['seo']['canonicalUrl'] ?? '/market') ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company']) ?>">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/market.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($category['title'] ?? 'Категория') ?> – цены, сортамент, характеристики | КАВ СТАЛЬ">
    <meta name="twitter:description" content="<?= htmlspecialchars($category['description'] ?? $category['title']) ?>">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/market.png">

    <!-- Additional SEO Meta Tags -->
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= htmlspecialchars($site['company']) ?>">

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
            "name": "<?= htmlspecialchars($category['title'] ?? 'Категория') ?>",
            "description": "<?= htmlspecialchars($category['description'] ?? $category['title']) ?>",
            "url": <?= json_encode($site['baseUrl'] . ($category['seo']['canonicalUrl'] ?? '/market'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
        .mobile-menu.active .mobile-menu-toggle span:nth-child(3) {
            transform: rotate(-45deg) translate(3px, 3px);
        }
        .product-card:hover .product-card-image img {
            transform: scale(1.05);
        }
        .product-card-image img {
            transition: transform 0.3s ease;
        }
        .sidebar-link.active {
            background-color: #fef2f2;
            color: #dc2626;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Top Bar -->
    <div class="bg-gray-900 text-gray-300 text-xs hidden lg:block">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9">
            <div class="flex items-center space-x-4">
                <span><i class="far fa-clock mr-1"></i>Работаем с 9:00 до 18:00</span>
                <span><i class="fas fa-truck mr-1"></i>Доставка по Москве и МО</span>
            </div>
            <div class="flex items-center space-x-6">
                <a href="/delivery" class="hover:text-white transition">Доставка и оплата</a>
                <a href="/guarantees" class="hover:text-white transition">Гарантии</a>
                <a href="/contacts" class="hover:text-white transition">Контакты</a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center flex-shrink-0">
                    <img loading="lazy" class="h-10 lg:h-12"
                        src="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg"
                        alt="<?= htmlspecialchars($site['company']) ?>">
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="/market" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Каталог</a>
                    <a href="/#services" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Услуги</a>
                    <a href="/#about" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">О компании</a>
                    <a href="/delivery" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Доставка и оплата</a>
                    <a href="/guarantees" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Гарантии</a>
                    <a href="/contacts" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Контакты</a>
                </div>

                <!-- Phone & CTA -->
                <div class="hidden lg:flex items-center space-x-4">
                    <a href="/cart" class="relative p-2 text-gray-700 hover:text-red-600 transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="cart-count-badge absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1">0</span>
                    </a>
                    <div class="text-right">
                        <a href="tel:<?= preg_replace('/[^0-9+]/', '', $site['phone']) ?>"
                            class="text-lg font-bold text-gray-900 hover:text-red-600 transition whitespace-nowrap">
                            <?= htmlspecialchars($site['phone']) ?>
                        </a>
                        <p class="text-xs text-gray-500"><?= htmlspecialchars($site['workingHours']) ?></p>
                    </div>
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $site['phone']) ?>"
                        class="bg-red-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-red-700 transition flex items-center gap-2">
                        <i class="fas fa-phone-alt"></i>
                        <span class="hidden xl:inline">Заказать звонок</span>
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="lg:hidden flex items-center gap-3">
                    <a href="/cart" class="relative text-gray-700 p-2">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span class="cart-count-badge absolute -top-0.5 -right-0.5 bg-red-600 text-white text-[10px] font-bold rounded-full min-w-[16px] h-[16px] flex items-center justify-center px-0.5">0</span>
                    </a>
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $site['phone']) ?>"
                        class="text-gray-700 p-2">
                        <i class="fas fa-phone-alt text-lg"></i>
                    </a>
                    <button class="mobile-menu-toggle p-2" aria-label="Открыть меню">
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
    <div class="mobile-menu-overlay fixed inset-0 bg-black/50 z-40 lg:hidden"></div>
    <div class="mobile-menu fixed left-0 top-0 h-full w-80 bg-white shadow-xl z-50 lg:hidden overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-8">
                <a href="/" class="flex items-center">
                    <img loading="lazy" class="h-10"
                        src="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg"
                        alt="<?= htmlspecialchars($site['company']) ?>">
                </a>
                <button class="mobile-menu-close p-2" aria-label="Закрыть меню">
                    <i class="fas fa-times text-2xl text-gray-800"></i>
                </button>
            </div>
            <nav class="space-y-1 mb-8">
                <a href="/market" class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">
                    Каталог <i class="fa fa-arrow-right text-sm"></i>
                </a>
                <a href="/#services" class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">
                    Услуги <i class="fa fa-arrow-right text-sm"></i>
                </a>
                <a href="/#about" class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">
                    О компании <i class="fa fa-arrow-right text-sm"></i>
                </a>
                <a href="/delivery" class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">
                    Доставка и оплата <i class="fa fa-arrow-right text-sm"></i>
                </a>
                <a href="/guarantees" class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">
                    Гарантии <i class="fa fa-arrow-right text-sm"></i>
                </a>
                <a href="/contacts" class="flex justify-between items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">
                    Контакты <i class="fa fa-arrow-right text-sm"></i>
                </a>
            </nav>
            <div class="border-t pt-6">
                <div class="text-center mb-4">
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $site['phone']) ?>"
                        class="text-xl font-bold text-gray-800 block mb-1">
                        <?= htmlspecialchars($site['phone']) ?>
                    </a>
                    <p class="text-sm text-gray-500"><?= htmlspecialchars($site['workingHours']) ?></p>
                </div>
                <a href="tel:<?= preg_replace('/[^0-9+]/', '', $site['phone']) ?>"
                    class="block text-center bg-red-600 text-white px-5 py-3 rounded-lg text-sm font-medium hover:bg-red-700 transition">
                    <i class="fas fa-phone-alt mr-2"></i>Заказать звонок
                </a>
            </div>
        </div>
    </div>

    <!-- Breadcrumbs -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <nav class="flex items-center space-x-2 text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" class="text-gray-500 hover:text-red-600 transition-colors" itemprop="item" itemscope
                        itemtype="https://schema.org/Thing" itemid="<?php echo $site['baseUrl']; ?>/">
                        <i class="fas fa-home"></i> <span itemprop="name">Главная</span>
                    </a>
                    <meta itemprop="position" content="1">
                </span>
                <span class="text-gray-300">/</span>
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/market" class="text-gray-500 hover:text-red-600 transition-colors" itemprop="item"
                        itemscope itemtype="https://schema.org/Thing"
                        itemid="<?php echo $site['baseUrl']; ?>/market">
                        <span itemprop="name">Каталог</span>
                    </a>
                    <meta itemprop="position" content="2">
                </span>
                <span class="text-gray-300">/</span>
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name"
                        class="text-gray-900 font-medium"><?= htmlspecialchars($category['title'] ?? 'Категория') ?></span>
                    <meta itemprop="position" content="3">
                </span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6 lg:py-8">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">

            <!-- Left Sidebar -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="lg:sticky lg:top-24 space-y-6">

                    <!-- Category Navigation -->
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Категории</h3>
                        </div>
                        <nav class="p-2 space-y-0.5">
                            <?php foreach ($categoryTree as $cat): ?>
                                <?php
                                $isActive = ($cat['id'] === $categoryID) || ($cat['categories']['id'] ?? '') === $categoryID;
                                $catUrl = $cat['seo']['canonicalUrl'] ?? '#';
                                $indent = ($cat['badge'] ?? '') === 'Подкатегория' ? 'ml-3' : '';
                                ?>
                                <a href="<?= htmlspecialchars($catUrl) ?>"
                                    class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition <?= $isActive ? 'sidebar-link active bg-red-50 text-red-600 font-semibold' : 'text-gray-600 hover:text-red-600 hover:bg-gray-50' ?> <?= $indent ?>">
                                    <?php if (($cat['badge'] ?? '') !== 'Подкатегория'): ?>
                                        <i class="fas fa-folder-open text-gray-400 text-xs w-4"></i>
                                    <?php else: ?>
                                        <i class="fas fa-chevron-right text-gray-300 text-xs w-4"></i>
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($cat['title']) ?></span>
                                </a>
                            <?php endforeach; ?>
                        </nav>
                    </div>

                    <!-- Filter: Diameter -->
                    <?php if (!empty($allDiameters)): ?>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Диаметр</h3>
                        </div>
                        <div class="p-3 max-h-60 overflow-y-auto space-y-1.5">
                            <?php foreach ($allDiameters as $d): ?>
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" class="filter-checkbox rounded border-gray-300 text-red-600 focus:ring-red-500" data-filter="diameter" value="<?= htmlspecialchars($d) ?>">
                                <span class="text-sm text-gray-600 group-hover:text-gray-900 transition"><?= htmlspecialchars($d) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Filter: Brand -->
                    <?php if (!empty($allBrands)): ?>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Марка стали</h3>
                        </div>
                        <div class="p-3 max-h-60 overflow-y-auto space-y-1.5">
                            <?php foreach ($allBrands as $b): ?>
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" class="filter-checkbox rounded border-gray-300 text-red-600 focus:ring-red-500" data-filter="brand" value="<?= htmlspecialchars($b) ?>">
                                <span class="text-sm text-gray-600 group-hover:text-gray-900 transition"><?= htmlspecialchars($b) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Filter: GOST -->
                    <?php if (!empty($allGosts)): ?>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">ГОСТ</h3>
                        </div>
                        <div class="p-3 max-h-60 overflow-y-auto space-y-1.5">
                            <?php foreach ($allGosts as $g): ?>
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" class="filter-checkbox rounded border-gray-300 text-red-600 focus:ring-red-500" data-filter="gost" value="<?= htmlspecialchars($g) ?>">
                                <span class="text-sm text-gray-600 group-hover:text-gray-900 transition"><?= htmlspecialchars($g) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </aside>

            <!-- Content Area -->
            <div class="flex-1 min-w-0">

                <!-- Category Header -->
                <div class="mb-6">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">
                        <?= htmlspecialchars($category['title'] ?? 'Категория') ?> – купить в Москве
                    </h1>
                    <?php if (!empty($category['description'])): ?>
                        <p class="text-gray-500 text-sm leading-relaxed"><?= htmlspecialchars($category['description']) ?></p>
                    <?php endif; ?>
                    <p class="text-sm text-gray-400 mt-2">
                        Найдено: <span class="font-medium text-gray-700"><?= count($products) ?></span> товаров
                    </p>
                </div>

                <!-- Subcategory Cards -->
                <?php if (!empty($subcategories)): ?>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                    <?php foreach ($subcategories as $sub): ?>
                    <a href="<?= htmlspecialchars($sub['seo']['canonicalUrl'] ?? '#') ?>"
                        class="group bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md hover:border-red-200 transition-all">
                        <?php if (!empty($sub['images'])): ?>
                        <div class="aspect-[4/3] rounded-lg overflow-hidden mb-3 bg-gray-100">
                            <img loading="lazy" src="<?= htmlspecialchars($sub['images'][0]) ?>"
                                alt="<?= htmlspecialchars($sub['title']) ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <?php endif; ?>
                        <h3 class="text-sm font-semibold text-gray-900 group-hover:text-red-600 transition"><?= htmlspecialchars($sub['title']) ?></h3>
                        <p class="text-xs text-gray-400 mt-1">Перейти к подкатегории <i class="fas fa-arrow-right ml-1"></i></p>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Product Grid -->
                <?php if (!empty($products)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-5" id="product-grid">
                    <?php foreach ($products as $item): ?>
                    <?php
                    $productImages = $item['images'] ?? [];
                    if (empty($productImages)) {
                        $productImages = [$site['baseUrl'] . "/public/assets/images/unknown/unknown.png"];
                    }
                    $specs = $item['specs'] ?? [];
                    $units = $item['units'] ?? [];
                    ?>
                    <div class="product-card bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-200 flex flex-col">
                        <!-- Image -->
                        <a href="<?= htmlspecialchars($item['seo']['canonicalUrl'] ?? '#') ?>" class="product-card-image block aspect-square bg-gray-100 relative overflow-hidden">
                            <?php if (count($productImages) > 1): ?>
                            <div class="swiper product-swiper w-full h-full"
                                data-product-id="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                <div class="swiper-wrapper">
                                    <?php foreach ($productImages as $imgIndex => $imgUrl): ?>
                                    <div class="swiper-slide flex justify-center items-center bg-gray-100">
                                        <img loading="lazy" src="<?= htmlspecialchars($imgUrl) ?>"
                                            alt="<?= htmlspecialchars($item['title']) ?> - фото <?= $imgIndex + 1 ?>"
                                            class="w-full h-full object-contain p-4">
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <?php else: ?>
                            <img loading="lazy" src="<?= htmlspecialchars($productImages[0]) ?>"
                                alt="<?= htmlspecialchars($item['title']) ?>"
                                class="w-full h-full object-contain p-4">
                            <?php endif; ?>

                            <!-- Availability Badge -->
                            <?php if ($item['in_stock'] ?? false): ?>
                            <span class="absolute top-2 left-2 bg-green-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1">
                                <i class="fas fa-check-circle text-[8px]"></i> В наличии
                            </span>
                            <?php else: ?>
                            <span class="absolute top-2 left-2 bg-red-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1">
                                <i class="fas fa-clock text-[8px]"></i> Под заказ
                            </span>
                            <?php endif; ?>
                        </a>

                        <!-- Info -->
                        <div class="p-4 flex flex-col flex-1">
                            <a href="<?= htmlspecialchars($item['seo']['canonicalUrl'] ?? '#') ?>">
                                <h3 class="text-sm font-semibold text-gray-900 hover:text-red-600 transition leading-snug mb-2 line-clamp-2">
                                    <?= htmlspecialchars($item['title']) ?>
                                </h3>
                            </a>

                            <!-- Specs Tags -->
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                <?php
                                $specLabels = ['Марка', 'Размер', 'ГОСТ'];
                                foreach ($specLabels as $label):
                                    $value = $specs[$label] ?? $specs[mb_strtolower($label)] ?? '';
                                    if (!empty($value)):
                                ?>
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full">
                                    <?= htmlspecialchars($label) ?>: <?= htmlspecialchars($value) ?>
                                </span>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>

                            <!-- Spacer -->
                            <div class="flex-1"></div>

                            <!-- Price -->
                            <?php if (!empty($units)): ?>
                            <div class="space-y-1 mb-3">
                                <?php foreach ($units as $unit => $price): ?>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-lg font-bold text-gray-900"><?= number_format($price, 0, '', ' ') ?></span>
                                    <span class="text-sm font-bold text-gray-900">₽</span>
                                    <span class="text-xs text-gray-400">/ <?= htmlspecialchars($unit) ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

                            <!-- Add to Cart -->
                            <div class="flex items-center gap-2" data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                <?php $firstU = !empty($units) ? array_key_first($units) : ''; ?>
                                <input type="number" value="1" min="1"
                                    class="cart-qty w-14 h-9 text-center border border-gray-200 rounded-lg text-sm focus:outline-none"
                                    data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                <?php if (count($units) > 1): ?>
                                <select class="cart-unit h-9 px-2 border border-gray-200 rounded-lg text-xs bg-white focus:outline-none"
                                    data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                    <?php foreach ($units as $u => $p): ?>
                                    <option value="<?= htmlspecialchars($u) ?>" <?= $u === $firstU ? 'selected' : '' ?>><?= htmlspecialchars($u) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php else: ?>
                                <span class="text-xs text-gray-400 w-9"><?= htmlspecialchars($firstU) ?></span>
                                <?php endif; ?>
                                <button type="button"
                                    class="add-to-cart-btn flex-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold py-2 px-3 rounded-lg transition flex items-center justify-center gap-1"
                                    data-pid="<?= htmlspecialchars($item['id'] ?? '') ?>"
                                    data-unit="<?= htmlspecialchars($firstU) ?>">
                                    <i class="fas fa-shopping-cart"></i> В корзину
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination (simple) -->
                <?php if (count($products) > 24): ?>
                <div class="mt-8 flex justify-center">
                    <nav class="flex items-center gap-2">
                        <button class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg font-medium">1</button>
                        <button class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-600">2</button>
                        <button class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-600">3</button>
                        <button class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-600">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </nav>
                </div>
                <?php endif; ?>

                <?php else: ?>
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                    <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">В этой категории пока нет товаров.</p>
                    <p class="text-gray-400 text-sm mt-2">Пожалуйста, загляните позже или <a href="/contacts" class="text-red-600 hover:underline">свяжитесь с нами</a>.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Header JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile menu toggle
            const toggle = document.querySelector('.mobile-menu-toggle');
            const menu = document.querySelector('.mobile-menu');
            const overlay = document.querySelector('.mobile-menu-overlay');
            const closeBtn = document.querySelector('.mobile-menu-close');

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
            if (closeBtn) closeBtn.addEventListener('click', closeMenu);
            if (overlay) overlay.addEventListener('click', closeMenu);

            // Product Swiper init
            document.querySelectorAll('.product-swiper').forEach(function (swiperEl) {
                new Swiper(swiperEl, {
                    loop: false,
                    pagination: {
                        el: swiperEl.querySelector('.swiper-pagination'),
                        clickable: true
                    },
                    autoplay: false
                });
            });

            // Filter checkboxes
            document.querySelectorAll('.filter-checkbox').forEach(function (cb) {
                cb.addEventListener('change', function () {
                    const filterType = this.dataset.filter;
                    const value = this.value;
                    const checked = this.checked;
                    const cards = document.querySelectorAll('#product-grid .product-card');

                    cards.forEach(function (card) {
                        const cardData = card.dataset;
                        let match = true;

                        document.querySelectorAll('.filter-checkbox:checked').forEach(function (checkedCb) {
                            const type = checkedCb.dataset.filter;
                            const val = checkedCb.value;
                            if (type === 'diameter') {
                                if (!cardData.diameter || !cardData.diameter.includes(val)) match = false;
                            }
                            if (type === 'brand') {
                                if (!cardData.brand || !cardData.brand.includes(val)) match = false;
                            }
                            if (type === 'gost') {
                                if (!cardData.gost || !cardData.gost.includes(val)) match = false;
                            }
                        });

                        card.style.display = match ? '' : 'none';
                    });
                });
            });

            // Set data attributes on product cards for filtering
            <?php foreach ($products as $item): ?>
            <?php
            $cardSpecs = $item['specs'] ?? [];
            $diameter = $cardSpecs['диаметр'] ?? '';
            $brand = $cardSpecs['Марка'] ?? $cardSpecs['марка'] ?? '';
            $gost = $cardSpecs['ГОСТ'] ?? $cardSpecs['гост'] ?? '';
            ?>
            var card = document.querySelector('#product-grid .product-card:nth-child(<?= array_search($item, array_values($products)) + 1 ?>)');
            if (card) {
                card.dataset.diameter = '<?= htmlspecialchars($diameter) ?>';
                card.dataset.brand = '<?= htmlspecialchars($brand) ?>';
                card.dataset.gost = '<?= htmlspecialchars($gost) ?>';
            }
            <?php endforeach; ?>
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
                const unitSelect = card.querySelector('.cart-unit');
                const qty = parseFloat(qtyInput ? qtyInput.value : 1) || 1;
                const unit = unitSelect ? unitSelect.value : this.dataset.unit;
                const wasInCart = this.classList.contains('in-cart');
                const originalCart = '<i class="fas fa-shopping-cart"></i> В корзину';
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
