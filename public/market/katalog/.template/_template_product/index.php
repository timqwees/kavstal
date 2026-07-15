<?php
// $productID передан из роута как $name (последний сегмент URL)
$productID = $name ?? basename(dirname(__FILE__));
// =====================
$product = Setting\route\function\Functions::showProduct($productID);
$site = Setting\route\function\Functions::site();
// =====================
// Загрузка отзывов для текущего продукта
$reviews = Setting\route\function\Reviews::getReviews($productID);
$averageRating = Setting\route\function\Reviews::getAverageRating($productID);
$reviewCount = is_array($reviews) ? count($reviews) : 0;
$structuredReviews = [];
if ($reviewCount > 0) {
    foreach ($reviews as $r) {
        if (!is_array($r)) {
            continue;
        }
        $structuredReviews[] = [
            '@type' => 'Review',
            'author' => [
                '@type' => 'Person',
                'name' => (string) ($r['name'] ?? ''),
            ],
            'datePublished' => !empty($r['created_at']) ? date('Y-m-d', strtotime((string) $r['created_at'])) : null,
            'reviewBody' => (string) ($r['review'] ?? ''),
            'reviewRating' => [
                '@type' => 'Rating',
                'ratingValue' => (string) ($r['rating'] ?? ''),
                'bestRating' => '5',
                'worstRating' => '1',
            ],
        ];
    }
    $structuredReviews = array_values(array_filter($structuredReviews, static function ($x) {
        return !empty($x['author']['name']) && !empty($x['reviewBody']) && !empty($x['reviewRating']['ratingValue']);
    }));
}
// =====================
// Сообщения для пользователя
$notification = App\Models\Network\Message::controll();
$successMessage = $notification['type'] === 'success' ? $notification['message'] : '';
$errorMessage = $notification['type'] === 'error' ? $notification['message'] : '';
// =====================
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['seo']['metaTitle'] ?? ($product['name'] . ' | Купить в Москве | КАВ СТАЛЬ')) ?></title>
    <meta name="description" content="<?= htmlspecialchars($product['seo']['metaDescription'] ?? '') ?>">
    <meta name="keywords"
        content="<?= htmlspecialchars($product['name'] ?? $product['title'] ?? 'Товар') ?>, <?= htmlspecialchars($product['title'] ?? '') ?>, купить <?= htmlspecialchars($product['categories']['title'] ?? 'металлопрокат') ?>, <?= htmlspecialchars($product['categories']['title'] ?? '') ?> цена за тонну, <?= htmlspecialchars($product['categories']['subcategory_title'] ?? '') ?>, металлопрокат москва, сортовой прокат, купить арматуру, доставка металлопроката">
    <link rel="canonical" href="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($product['seo']['canonicalUrl'] ?? '/') ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= htmlspecialchars($product['seo']['metaTitle'] ?? ($product['name'] . ' | Купить в Москве | КАВ СТАЛЬ')) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($product['seo']['metaDescription'] ?? '') ?>">
    <meta property="og:type" content="product">
    <meta property="og:url" content="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($product['seo']['canonicalUrl'] ?? '/') ?>">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/product.png">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company'] ?? 'КАВ СТАЛЬ') ?>">
    <meta property="og:locale" content="ru_RU">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($product['seo']['metaTitle'] ?? ($product['name'] . ' | Купить в Москве | КАВ СТАЛЬ')) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($product['seo']['metaDescription'] ?? '') ?>">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/product.png">

    <!-- Additional SEO Meta Tags -->
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= htmlspecialchars($site['company'] ?? 'КАВ СТАЛЬ') ?>">

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
        "@type": "Organization",
        "name": <?= json_encode($site['company'], JSON_UNESCAPED_UNICODE); ?>,
        "url": <?= json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        "logo": <?= json_encode($site['logo'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        "description": "Металлопрокат и Металлобаза в Москве и МО | КавСталь"
        }
    </script>

    <script type="application/ld+json">
    <?php
    $breadcrumbItems = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Главная',
            'item' => $site['baseUrl'] . '/'
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Каталог',
            'item' => $site['baseUrl'] . '/market'
        ]
    ];

    $position = 3;
    $categoryId = $product['categories']['id'] ?? null;
    $parentId = $product['categories']['parent_id'] ?? null;

    if ($parentId && $categoryId) {
        $allProducts = Setting\route\function\Functions::listProducts();
        $parentCategory = null;
        foreach ($allProducts as $p) {
            if ($p['id'] === $parentId) {
                $parentCategory = $p;
                break;
            }
        }

        if ($parentCategory) {
            $breadcrumbItems[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $parentCategory['title'],
                'item' => $site['baseUrl'] . '/' . ($parentCategory['seo']['canonicalUrl'] ?? '/market')
            ];

            $subcategory = null;
            foreach ($allProducts as $p) {
                if ($p['id'] === $categoryId && ($p['badge'] ?? '') === 'Подкатегория') {
                    $subcategory = $p;
                    break;
                }
            }

            if ($subcategory) {
                $breadcrumbItems[] = [
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => $subcategory['title'],
                    'item' => $site['baseUrl'] . '/' . ($subcategory['seo']['canonicalUrl'] ?? '/market')
                ];
            }
        }
    }

    $breadcrumbItems[] = [
        '@type' => 'ListItem',
        'position' => $position,
        'name' => $product['name'] ?? $product['title'],
        'item' => $site['baseUrl'] . '/' . ($product['seo']['canonicalUrl'] ?? '')
    ];

    $breadcrumbList = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'numberOfItems' => count($breadcrumbItems),
        'itemListElement' => $breadcrumbItems
    ];
    echo json_encode($breadcrumbList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    ?>
    </script>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Product",
            "@id": <?= json_encode($site['baseUrl'] . ($product['seo']['canonicalUrl'] ?? '/') . '#product', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
            "name": "<?= htmlspecialchars($product['name'] ?? $product['title']) ?>",
            "description": "<?= htmlspecialchars($product['description']) ?>",
            "image": <?= json_encode($product['images'][0] ?? $site['baseUrl'] . '/public/assets/images/bgpage/product.png', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
            "url": <?= json_encode($site['baseUrl'] . ($product['seo']['canonicalUrl'] ?? '/'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
            "sku": "<?= htmlspecialchars($productID) ?>",
            "mpn": "<?= htmlspecialchars($productID) ?>",
            "brand": {
                "@type": "Brand",
                "name": "<?= htmlspecialchars($site['company']) ?>"
            },
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "<?= htmlspecialchars(number_format((float) (empty($averageRating) ? 4.5 : $averageRating), 1, '.', '')) ?>",
                "reviewCount": "<?= max(1, (int) $reviewCount) ?>",
                "bestRating": "5",
                "worstRating": "1"
            },
            "offers": {
                "@type": "Offer",
                "url": <?= json_encode($site['baseUrl'] . ($product['seo']['canonicalUrl'] ?? '/'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "price": "<?= number_format($product['units'][array_key_first($product['units'])], 0, '', '') ?>",
                "priceCurrency": "RUB",
                "availability": "<?= $product['in_stock'] ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' ?>",
                "seller": {
                    "@type": "Organization",
                    "name": "<?= htmlspecialchars($site['company']) ?>",
                    "telephone": "<?= htmlspecialchars($site['phone']) ?>",
                    "email": "<?= htmlspecialchars($site['email']) ?>",
                    "image": <?= json_encode($site['baseUrl'] . '/public/assets/images/icons/favicon/favicon.svg', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                    "address": {
                        "@type": "PostalAddress",
                        "streetAddress": "Семёновская площадь, 7",
                        "addressLocality": "Москва",
                        "addressRegion": "Московская область",
                        "postalCode": "115035",
                        "addressCountry": "RU"
                    }
                },
                "shippingDetails": {
                    "@type": "OfferShippingDetails",
                    "deliveryTime": {
                        "@type": "ShippingDeliveryTime",
                        "handlingTime": {
                            "@type": "QuantitativeValue",
                            "minValue": "0",
                            "maxValue": "1",
                            "unitCode": "DAY"
                        },
                        "transitTime": {
                            "@type": "QuantitativeValue",
                            "minValue": "0",
                            "maxValue": "3",
                            "unitCode": "DAY"
                        }
                    },
                    "shippingRate": {
                        "@type": "MonetaryAmount",
                        "value": "0",
                        "currency": "RUB"
                    },
                    "shippingDestination": {
                        "@type": "DefinedRegion",
                        "addressCountry": "RU"
                    }
                }
            }<?php if ($reviewCount > 0 && (float) $averageRating > 0): ?>,
            "review": <?= json_encode($structuredReviews, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
            <?php endif; ?>
        }
    </script>

    <!-- Font Awesome -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    </noscript>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Swiper Slider CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Local Styles -->
    <link rel="preload" href="/public/assets/styles/catalog.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="/public/assets/styles/main.css">
    </noscript>

    <style>
        .swiper-pagination-bullet {
            width: 8px;
            height: 8px;
            background: #d1d5db;
            opacity: 0.7;
            transition: all 0.3s ease;
        }
        .swiper-pagination-bullet-active {
            width: 24px;
            border-radius: 4px;
            background: #ef4444;
            opacity: 1;
        }
        .thumbnail-btn.active {
            border-color: #ef4444;
        }
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
        #main-image { transition: transform 0.3s ease; cursor: zoom-in; }
        #main-image:hover { transform: scale(1.05); }
        @media (max-width: 1024px) { #main-image:hover { transform: none; cursor: default; } }

        /* Mobile gallery */
        .product-gallery-mobile .swiper-slide-active > div { box-shadow: none; }
        .product-gallery-pagination .swiper-pagination-bullet { background: #d1d5db; opacity: 0.7; width: 8px; height: 8px; transition: all 0.3s ease; }
        .product-gallery-pagination .swiper-pagination-bullet-active { background: #dc2626; opacity: 1; width: 20px; border-radius: 4px; }

        /* Image skeleton loader */
        .product-gallery-img { background: #f9fafb; }
        .product-gallery-img[data-loaded="false"] { opacity: 0; }
        .product-gallery-img[data-loaded="true"] { opacity: 1; transition: opacity 0.3s ease; }

        /* Accordion */
        .accordion-header { cursor: pointer; user-select: none; }
        .accordion-header:hover { background: #fafafa; }
        .accordion-header .accordion-icon { transition: transform 0.25s ease; }
        .accordion-header[aria-expanded="true"] .accordion-icon { transform: rotate(180deg); }
        .accordion-body { overflow: hidden; max-height: 0; transition: max-height 0.3s ease, padding 0.3s ease; }
        .accordion-body.open { max-height: 2000px; }

        /* Sticky mobile cart */
        @media (max-width: 1023px) {
            .mobile-sticky-cart {
                position: fixed; bottom: 0; left: 0; right: 0; z-index: 40;
                background: white; border-top: 1px solid #e5e7eb;
                padding: 10px 16px; box-shadow: 0 -4px 16px rgba(0,0,0,0.08);
            }
            body { padding-bottom: 72px; }
        }
        @media (min-width: 1024px) { .mobile-sticky-cart { display: none; } }

        /* Buy in 1 click modal */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 60; display: flex; align-items: flex-end; justify-content: center; opacity: 0; visibility: hidden; transition: opacity 0.2s ease, visibility 0.2s ease; }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        .modal-overlay.active .modal-sheet { transform: translateY(0); }
        .modal-sheet { background: white; border-radius: 16px 16px 0 0; width: 100%; max-width: 480px; max-height: 80vh; overflow-y: auto; transform: translateY(100%); transition: transform 0.3s ease; padding: 24px; }
        @media (min-width: 640px) { .modal-sheet { border-radius: 16px; margin: auto; max-height: 70vh; } }
    </style>
</head>

<body class="bg-gray-50">
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-red-600 focus:text-white focus:px-4 focus:py-2 focus:rounded-lg">
        Перейти к основному содержанию
    </a>

    <?php include_once __DIR__ . '/../../../../components/header-shared.php'; ?>

    <main id="main-content" class="max-w-7xl mx-auto px-4 pt-[100px] pb-12">

        <!-- Breadcrumbs -->
        <nav class="flex flex-wrap items-center text-sm text-gray-500 mb-6" itemscope itemtype="https://schema.org/BreadcrumbList">
            <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="/" itemprop="item" class="hover:text-gray-900 transition-colors">
                    <span itemprop="name">Главная</span>
                </a>
                <meta itemprop="position" content="1">
            </span>
            <span class="mx-2 text-gray-300">/</span>
            <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="/market" itemprop="item" class="hover:text-gray-900 transition-colors">
                    <span itemprop="name">Каталог</span>
                </a>
                <meta itemprop="position" content="2">
            </span>
            <?php
            $categoryId = $subcategory ?? (is_string($product['categories']['id'] ?? null) ? $product['categories']['id'] : null);
            $parentId = $katalog ?? (is_string($product['categories']['parent_id'] ?? null) ? $product['categories']['parent_id'] : null);
            $parentTitle = is_string($product['categories']['title'] ?? null) ? $product['categories']['title'] : 'Каталог';
            $subcategoryTitle = is_string($product['categories']['subcategory_title'] ?? null) ? $product['categories']['subcategory_title'] : ($categoryId ? ucfirst($categoryId) : 'Категория');
            $pos = 3;

            if ($parentId && is_string($parentId)) {
                echo '<span class="mx-2 text-gray-300">/</span>';
                echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<a href="/market/katalog/' . htmlspecialchars($parentId) . '" itemprop="item" class="hover:text-gray-900 transition-colors">';
                echo '<span itemprop="name">' . htmlspecialchars($parentTitle) . '</span></a>';
                echo '<meta itemprop="position" content="' . $pos++ . '"></span>';

                if ($categoryId && is_string($categoryId)) {
                    echo '<span class="mx-2 text-gray-300">/</span>';
                    echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                    echo '<a href="/market/katalog/' . htmlspecialchars($parentId) . '/' . htmlspecialchars($categoryId) . '" itemprop="item" class="hover:text-gray-900 transition-colors">';
                    echo '<span itemprop="name">' . htmlspecialchars($subcategoryTitle) . '</span></a>';
                    echo '<meta itemprop="position" content="' . $pos++ . '"></span>';
                }
            }
            ?>
            <span class="mx-2 text-gray-300">/</span>
            <span class="text-gray-900 font-medium"><?= htmlspecialchars($product['name'] ?? $product['title'] ?? 'Товар') ?></span>
        </nav>

        <!-- Two-Column Product Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10">

            <!-- Left Column: Gallery -->
            <div class="lg:col-span-5 xl:col-span-5">
                <!-- Desktop: Static image + thumbnails -->
                <div class="hidden lg:block">
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-4">
                        <img id="main-image"
                            src="<?= htmlspecialchars($product['images'][0] ?? $site['baseUrl'] . '/public/assets/images/unknown/unknown.png') ?>"
                            alt="<?= htmlspecialchars($product['name'] ?? $product['title']) ?>"
                            title="<?= htmlspecialchars($product['name'] ?? $product['title']) ?>"
                            class="w-full h-auto object-contain"
                            style="aspect-ratio: 4/3;">
                    </div>
                    <div class="flex gap-2 overflow-x-auto pb-2" id="thumbnail-list">
                        <?php foreach ($product['images'] as $index => $image): ?>
                        <button class="thumbnail-btn flex-shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-lg overflow-hidden border-2 <?= $index === 0 ? 'active border-red-500' : 'border-gray-200' ?> hover:border-red-300 transition-colors"
                            data-src="<?= htmlspecialchars($image) ?>"
                            data-alt="<?= htmlspecialchars($product['name'] ?? $product['title']) . ($index > 0 ? ' - фото ' . ($index + 1) : '') ?>">
                            <img src="<?= htmlspecialchars($image) ?>"
                                alt="<?= htmlspecialchars($product['name'] ?? $product['title']) ?>"
                                class="w-full h-full object-cover"
                                loading="lazy">
                        </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Mobile: Swiper gallery -->
                <div class="lg:hidden">
                    <div class="swiper product-gallery-mobile" style="border-radius: 12px; overflow: hidden;">
                        <div class="swiper-wrapper">
                            <?php foreach ($product['images'] as $index => $image): ?>
                            <div class="swiper-slide">
                                <div class="bg-white border border-gray-200 overflow-hidden" style="aspect-ratio: 1;">
                                    <img src="<?= htmlspecialchars($image) ?>"
                                        alt="<?= htmlspecialchars($product['name'] ?? $product['title']) ?> <?= $index > 0 ? '- фото ' . ($index + 1) : '' ?>"
                                        class="w-full h-full object-contain product-gallery-img"
                                        loading="<?= $index < 2 ? 'eager' : 'lazy' ?>">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination product-gallery-pagination"></div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Product Info -->
            <div class="lg:col-span-7 xl:col-span-7 space-y-5">

                <!-- Title + Fav + Share -->
                <div class="flex items-start justify-between gap-3">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight flex-1">
                        <?= htmlspecialchars($product['name'] ?? $product['title']) ?>
                    </h1>
                    <div class="flex items-center gap-2 shrink-0 mt-1">
                        <button type="button" id="product-fav-btn" class="w-9 h-9 rounded-lg border border-zinc-200 flex items-center justify-center transition-colors hover:border-red-300 hover:bg-red-50" data-pid="<?= htmlspecialchars($productID) ?>" title="В избранное">
                            <svg width="16" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </button>
                        <button type="button" id="product-share-btn" class="w-9 h-9 rounded-lg border border-zinc-200 flex items-center justify-center transition-colors hover:border-zinc-300 hover:bg-zinc-50" title="Поделиться">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Rating + Availability -->
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center">
                            <?php $rating = (float) ($averageRating ?: 4.5); for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star text-sm <?= $i <= floor($rating) ? 'text-yellow-400' : 'text-gray-200' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-sm font-medium text-gray-700"><?= number_format($rating, 1) ?></span>
                        <span class="text-sm text-gray-400">(<?= $reviewCount ?: 0 ?>)</span>
                    </div>
                    <?php if ($product['in_stock']): ?>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                            <i class="fas fa-check-circle"></i> В наличии
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                            <i class="fas fa-times-circle"></i> Под заказ
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Trust Badges -->
                <div class="flex flex-wrap items-center gap-4 text-sm">
                    <span class="flex items-center gap-1 text-green-600"><i class="fas fa-check-circle"></i> Официальный дилер</span>
                    <span class="flex items-center gap-1 text-red-600"><i class="fas fa-shield-alt"></i> Гарантия качества</span>
                    <span class="flex items-center gap-1 text-blue-600"><i class="fas fa-file-invoice"></i> Сертификаты ГОСТ</span>
                </div>

                <!-- Price Section -->
                <div class="bg-white rounded-xl border border-gray-200 p-5 space-y-4">
                    <div class="flex flex-wrap items-baseline gap-4">
                        <?php
                        $firstUnit = array_key_first($product['units'] ?? []);
                        $firstPrice = is_numeric($product['units'][$firstUnit] ?? null) ? (float) $product['units'][$firstUnit] : 0;
                        ?>
                        <span class="text-3xl font-bold text-gray-900" id="current-price">
                            <?= $firstPrice > 0 ? number_format($firstPrice, 0, '', ' ') : 'Цена по запросу' ?>
                        </span>
                        <span class="text-lg text-gray-500" id="current-unit"><?= $firstPrice > 0 ? '₽ / ' . $firstUnit : '' ?></span>
                    </div>
                    <div class="flex flex-wrap gap-3 text-sm" id="alternative-prices">
                        <?php foreach (($product['units'] ?? []) as $unit => $price):
                            if ($unit !== $firstUnit && is_numeric($price)): ?>
                            <span class="bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                                <strong class="text-red-600"><?= number_format((float) $price, 0, '', ' ') ?> ₽</strong> / <?= htmlspecialchars($unit) ?>
                            </span>
                        <?php endif; endforeach; ?>
                    </div>
                    <button type="button" id="buy-one-click-btn"
                        class="w-full sm:w-auto border-2 border-red-600 text-red-600 py-2.5 px-6 rounded-lg hover:bg-red-50 transition-all font-medium text-sm flex items-center justify-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Купить в 1 клик
                    </button>
                </div>

                <!-- Key Specs -->
                <?php if (!empty($product['specs']) && is_array($product['specs'])): ?>
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3 uppercase tracking-wide">Характеристики</h3>
                    <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm">
                        <?php $specCount = 0;
                        $specEntries = [];
                        foreach ($product['specs'] as $key => $val) {
                            if (is_array($val) && isset($val['label'], $val['value'])) {
                                $specEntries[$val['label']] = $val['value'];
                            } elseif (is_string($val) && $val !== '') {
                                $specEntries[$key] = $val;
                            }
                        }
                        foreach ($specEntries as $label => $value):
                            if ($specCount >= 8) break;
                            $specCount++; ?>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500"><?= htmlspecialchars($label) ?></span>
                                <span class="font-medium text-gray-900 text-right ml-2"><?= htmlspecialchars($value) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($specEntries) > 8): ?>
                    <button onclick="document.querySelector('[data-section=specs]').scrollIntoView({behavior:'smooth'})" class="mt-3 text-sm text-red-600 hover:text-red-700 font-medium">
                        Все характеристики <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Delivery Info -->
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-sm">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-truck text-blue-600 mt-0.5"></i>
                        <div>
                            <p class="font-medium text-blue-900">Доставка по Москве и всей России</p>
                            <p class="text-blue-700">От 1 дня. Бесплатно от 100 000 ₽. Возможен самовывоз.</p>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart — sticky on desktop -->
                <div class="space-y-3 lg:sticky lg:top-[120px] lg:z-10" id="add-to-cart-section">
                    <div class="bg-white rounded-xl border border-gray-200 p-5 space-y-4 shadow-sm">
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Количество</label>
                                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                    <button type="button" class="cart-qty-btn cart-qty-minus w-9 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition text-lg font-medium" data-product-id="<?= htmlspecialchars($productID) ?>">−</button>
                                    <input type="number" id="cart-qty-input" value="1" min="1"
                                        class="w-full h-10 text-center border-x border-gray-200 text-sm font-medium focus:outline-none"
                                        data-product-id="<?= htmlspecialchars($productID) ?>">
                                    <button type="button" class="cart-qty-btn cart-qty-plus w-9 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition text-lg font-medium" data-product-id="<?= htmlspecialchars($productID) ?>">+</button>
                                </div>
                                <div class="flex gap-1 mt-1.5">
                                    <button type="button" class="qty-preset text-[10px] px-2 py-0.5 rounded border border-gray-200 text-gray-500 hover:border-red-300 hover:text-red-600 hover:bg-red-50 transition" data-qty="1">1</button>
                                    <button type="button" class="qty-preset text-[10px] px-2 py-0.5 rounded border border-gray-200 text-gray-500 hover:border-red-300 hover:text-red-600 hover:bg-red-50 transition" data-qty="5">5</button>
                                    <button type="button" class="qty-preset text-[10px] px-2 py-0.5 rounded border border-gray-200 text-gray-500 hover:border-red-300 hover:text-red-600 hover:bg-red-50 transition" data-qty="10">10</button>
                                    <button type="button" class="qty-preset text-[10px] px-2 py-0.5 rounded border border-gray-200 text-gray-500 hover:border-red-300 hover:text-red-600 hover:bg-red-50 transition" data-qty="20">20</button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Единица</label>
                                <select id="cart-unit-select"
                                    class="w-full h-10 px-3 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white">
                                    <?php foreach ($product['units'] as $unit => $price): ?>
                                        <option value="<?= htmlspecialchars($unit) ?>" data-price="<?= (float)$price ?>">
                                            <?= htmlspecialchars($unit) ?> — <?= number_format((float)$price, 0, '', ' ') ?> ₽
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="sm:col-span-2 flex items-end">
                                <button type="button" id="add-to-cart-btn"
                                    class="w-full bg-red-600 text-white py-2.5 px-6 rounded-lg hover:bg-red-700 transition-all font-medium shadow-sm flex items-center justify-center gap-2">
                                    <i class="fas fa-shopping-cart"></i> В корзину
                                </button>
                            </div>
                        </div>
                        <div id="cart-feedback" class="hidden text-sm font-medium"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <a href="tel:<?= preg_replace('/[^0-9+]/', '', $site['phone']) ?>"
                            class="flex items-center justify-center gap-2 border border-gray-300 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-50 transition font-medium text-sm">
                            <i class="fas fa-phone-alt text-red-600"></i> Заказать по телефону
                        </a>
                        <a href="mailto:<?= htmlspecialchars($site['email']) ?>"
                            class="flex items-center justify-center gap-2 border border-gray-300 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-50 transition font-medium text-sm">
                            <i class="fas fa-envelope text-red-600"></i> Отправить запрос
                        </a>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $site['phone']) ?>"
                            target="_blank" rel="noopener noreferrer"
                            class="flex items-center justify-center gap-2 bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition font-medium text-sm">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Below the Fold Sections -->
        <div class="mt-12">

            <!-- Horizontal Tabs: Описание | Характеристики | Доставка и оплата -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200">
                    <div class="flex overflow-x-auto" role="tablist">
                        <button class="tab-btn px-6 lg:px-8 py-4 text-sm font-medium whitespace-nowrap border-b-2 -mb-px transition-colors text-red-600 border-red-600" data-tab="tab-desc" role="tab" aria-selected="true">Описание</button>
                        <button class="tab-btn px-6 lg:px-8 py-4 text-sm font-medium whitespace-nowrap border-b-2 -mb-px transition-colors text-gray-500 border-transparent hover:text-gray-700" data-tab="tab-specs" role="tab" aria-selected="false">Характеристики</button>
                        <button class="tab-btn px-6 lg:px-8 py-4 text-sm font-medium whitespace-nowrap border-b-2 -mb-px transition-colors text-gray-500 border-transparent hover:text-gray-700" data-tab="tab-delivery" role="tab" aria-selected="false">Доставка и оплата</button>
                    </div>
                </div>

                <!-- Tab: Описание -->
                <div id="tab-desc" class="tab-content px-6 lg:px-8 py-6 lg:py-8" role="tabpanel">
                    <?php if (!empty($product['description'])): ?>
                    <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                    </div>
                    <?php else: ?>
                    <p class="text-sm text-gray-400">Описание не указано</p>
                    <?php endif; ?>
                </div>

                <!-- Tab: Характеристики -->
                <div id="tab-specs" class="tab-content px-6 lg:px-8 py-6 lg:py-8 hidden" data-section="specs" role="tabpanel">
                    <?php if (!empty($product['specs']) && is_array($product['specs'])): ?>
                        <?php
                        $allSpecs = [];
                        foreach ($product['specs'] as $key => $val) {
                            if (is_array($val) && isset($val['label'], $val['value'])) {
                                $allSpecs[$val['label']] = $val['value'];
                            } elseif (is_string($val) && $val !== '') {
                                $allSpecs[$key] = $val;
                            }
                        }
                        ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1">
                            <?php foreach ($allSpecs as $label => $value): ?>
                                <div class="flex justify-between py-3 border-b border-gray-100">
                                    <span class="text-gray-500 text-sm"><?= htmlspecialchars($label) ?></span>
                                    <span class="font-medium text-gray-900 text-sm text-right ml-2"><?= htmlspecialchars($value) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-gray-400">Характеристики не указаны</p>
                    <?php endif; ?>
                </div>

                <!-- Tab: Доставка и оплата -->
                <div id="tab-delivery" class="tab-content px-6 lg:px-8 py-6 lg:py-8 hidden" role="tabpanel">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-gray-900">Автотранспорт</h4>
                                    <span class="text-sm text-gray-500">1-3 дня</span>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">Доставка по Москве и Московской области</p>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li>• Грузовики 5-20 тонн</li>
                                    <li>• Разгрузка на объекте</li>
                                    <li>• Страховка груза</li>
                                </ul>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-gray-900">Ж/д транспорт</h4>
                                    <span class="text-sm text-gray-500">3-7 дней</span>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">Доставка в регионы России</p>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li>• Вагоны и контейнеры</li>
                                    <li>• До ж/д станции</li>
                                    <li>• Трекинг груза</li>
                                </ul>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-medium text-gray-900 mb-2">Безналичный расчет</h4>
                                <p class="text-gray-600 text-sm mb-3">Для юридических лиц и ИП</p>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li>• Счет с НДС</li>
                                    <li>• Отсрочка платежа</li>
                                    <li>• Договор поставки</li>
                                </ul>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-medium text-gray-900 mb-2">Наличный расчет</h4>
                                <p class="text-gray-600 text-sm mb-3">Для физических лиц</p>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li>• Оплата при получении</li>
                                    <li>• Кассовые чеки</li>
                                    <li>• Расписка о получении</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-gray-500 mt-0.5"></i>
                            <div class="text-sm text-gray-700 space-y-1">
                                <p>• Минимальная сумма заказа — 50 000 ₽</p>
                                <p>• Бесплатная доставка при заказе от 100 000 ₽ по Москве</p>
                                <p>• Возможен самовывоз со склада в Москве</p>
                                <p>• Сертификаты на всю продукцию</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end tabs wrapper -->

            <!-- Reviews Section — Accordion -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <button class="accordion-header w-full flex items-center justify-between p-6 lg:p-8 text-left" aria-expanded="true" data-accordion="reviews">
                    <div class="flex items-center gap-3">
                        <h2 class="text-xl font-bold text-gray-900">Отзывы</h2>
                        <?php if ($reviewCount > 0): ?>
                        <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-0.5 rounded-full"><?= $reviewCount ?></span>
                        <?php endif; ?>
                    </div>
                    <svg class="accordion-icon w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="accordion-body open px-6 lg:px-8 pb-6 lg:pb-8">

                <?php if ($successMessage): ?>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                            <span class="text-green-800"><?= htmlspecialchars($successMessage) ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($errorMessage): ?>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                            <span class="text-red-800"><?= htmlspecialchars($errorMessage) ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Reviews Summary -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 mb-8">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star text-lg <?= $i <= floor($averageRating) ? 'text-yellow-400' : 'text-gray-200' ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="text-2xl font-bold text-gray-900"><?= $averageRating > 0 ? number_format($averageRating, 1) : '—' ?></span>
                            <span class="text-gray-500"><?php
                                $cnt = count($reviews);
                                $word = 'отзывов';
                                if ($cnt % 100 < 11 || $cnt % 100 > 14) {
                                    if ($cnt % 10 == 1) $word = 'отзыв';
                                    elseif ($cnt % 10 >= 2 && $cnt % 10 <= 4) $word = 'отзыва';
                                }
                                echo $cnt . ' ' . $word;
                            ?></span>
                        </div>
                        <button onclick="document.getElementById('review-form').scrollIntoView({behavior:'smooth'})"
                            class="bg-red-600 text-white px-5 py-2.5 rounded-lg hover:bg-red-700 transition font-medium text-sm">
                            Написать отзыв
                        </button>
                    </div>
                </div>

                <?php if (isset($reviews) && !empty($reviews)): ?>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Отзывы покупателей</h3>
                    <div class="flex items-center gap-2">
                        <button class="reviews-button-prev w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center hover:bg-gray-50 transition">
                            <i class="fas fa-chevron-left text-xs text-gray-600"></i>
                        </button>
                        <button class="reviews-button-next w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center hover:bg-gray-50 transition">
                            <i class="fas fa-chevron-right text-xs text-gray-600"></i>
                        </button>
                    </div>
                </div>
                <div class="swiper reviews-slider" style="padding-bottom: 40px;">
                    <div class="swiper-wrapper">
                        <?php foreach ($reviews as $review): ?>
                            <div class="swiper-slide" itemscope itemtype="https://schema.org/Review">
                                <div class="border border-gray-100 rounded-lg p-5 h-full bg-white hover:shadow-md transition-shadow">
                                    <div class="flex items-start gap-3 mb-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center shrink-0">
                                            <span class="text-sm font-medium text-gray-600"><?= mb_substr(htmlspecialchars($review['name']), 0, 1) ?></span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-2">
                                                <span itemprop="author" class="font-medium text-gray-900 truncate"><?= htmlspecialchars($review['name']) ?></span>
                                                <span class="text-xs text-gray-500 whitespace-nowrap"><?= date('d.m.Y', strtotime($review['created_at'])) ?></span>
                                            </div>
                                            <div itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating" class="mt-1">
                                                <meta itemprop="ratingValue" content="<?= $review['rating'] ?>">
                                                <div class="flex items-center">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i class="fas fa-star text-xs <?= $i <= $review['rating'] ? 'text-yellow-400' : 'text-gray-200' ?>"></i>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p itemprop="reviewBody" class="text-gray-700 text-sm leading-relaxed">
                                        <?= htmlspecialchars($review['review']) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-xl text-gray-400"></i>
                    </div>
                    <p class="text-lg font-medium text-gray-700 mb-1">Пока нет отзывов</p>
                    <p class="text-sm text-gray-500">Станьте первым, кто оставит отзыв об этом товаре</p>
                </div>
                <?php endif; ?>

                <!-- Review Form -->
                <div id="review-form" class="border-t border-gray-200 pt-8 mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Оставить отзыв</h3>
                    <form action="/api/reviews" method="POST" class="space-y-5">
                        <input type="hidden" name="product_id" value="<?= strval($productID) ?>">
                        <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ваше имя *</label>
                                <input type="text" name="name" required
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                    placeholder="Иван Иванов">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email (не публикуется)</label>
                                <input type="email" name="email"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                    placeholder="ivan@example.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Оценка *</label>
                            <div class="flex items-center gap-3">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="<?= $i ?>" class="sr-only" required <?= $i === 5 ? 'checked' : '' ?>>
                                        <i class="far fa-star text-2xl text-gray-300 hover:text-yellow-400 transition-colors"></i>
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ваш отзыв *</label>
                            <textarea name="review" rows="4" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                placeholder="Расскажите о вашем опыте использования..."></textarea>
                        </div>

                        <div class="hidden">
                            <input type="text" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-xs text-gray-500">* Email не публикуется.</p>
                            <button type="submit"
                                class="bg-red-600 text-white px-6 py-2.5 rounded-lg hover:bg-red-700 transition font-medium text-sm">
                                Отправить отзыв
                            </button>
                        </div>
                    </form>
                </div>
                </div>
            </div>

            <!-- Similar Products -->
            <?php
            $similarProducts = [];
            if (!empty($product['categories']['id'])) {
                $allProducts = Setting\route\function\Functions::listProducts();
                $currentCatId = $product['categories']['id'];
                foreach ($allProducts as $p) {
                    if (isset($p['categories']['id']) && $p['categories']['id'] === $currentCatId && $p['id'] !== $productID) {
                        $similarProducts[] = $p;
                    }
                }
                $similarProducts = array_slice($similarProducts, 0, 6);
            }
            ?>
            <?php if (!empty($similarProducts)): ?>
            <div class="bg-white rounded-xl border border-gray-200 p-6 lg:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Похожие товары</h2>
                    <div class="flex items-center gap-2">
                        <button class="similar-prev w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center hover:bg-gray-50 transition">
                            <i class="fas fa-chevron-left text-xs text-gray-600"></i>
                        </button>
                        <button class="similar-next w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center hover:bg-gray-50 transition">
                            <i class="fas fa-chevron-right text-xs text-gray-600"></i>
                        </button>
                    </div>
                </div>
                <div class="swiper similar-slider" style="padding-bottom: 40px;">
                    <div class="swiper-wrapper">
                        <?php foreach ($similarProducts as $item): ?>
                        <div class="swiper-slide">
                            <a href="<?= htmlspecialchars($item['seo']['canonicalUrl'] ?? '#') ?>"
                                class="group block border border-gray-100 rounded-lg p-3 hover:shadow-md transition-shadow h-full">
                                <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden mb-3">
                                    <img src="<?= htmlspecialchars($item['images'][0] ?? $site['baseUrl'] . '/public/assets/images/unknown/unknown.png') ?>"
                                        alt="<?= htmlspecialchars($item['name'] ?? '') ?>"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                                        loading="lazy">
                                </div>
                                <p class="text-sm font-medium text-gray-900 line-clamp-2 leading-tight"><?= htmlspecialchars($item['name'] ?? '') ?></p>
                                <?php if (!empty($item['units'])): ?>
                                <p class="text-sm font-bold text-red-600 mt-1">
                                    от <?= number_format((float) min($item['units']), 0, '', ' ') ?> ₽
                                </p>
                                <?php endif; ?>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination similar-pagination"></div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>

    <!-- Image Lightbox -->
    <div class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4" id="imageLightbox" role="dialog" aria-modal="true">
        <button class="absolute top-4 right-4 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition text-white" id="closeLightbox" aria-label="Закрыть">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <button class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition text-white" id="lbPrev" aria-label="Предыдущее">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition text-white" id="lbNext" aria-label="Следующее">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
        <img id="lbImage" src="" alt="" class="max-w-full max-h-[85vh] object-contain rounded-lg select-none">
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white/70 text-sm" id="lbCounter"></div>
    </div>

    <!-- Buy in 1 Click Modal -->
    <div class="modal-overlay" id="buyOneClickModal">
        <div class="modal-sheet">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Купить в 1 клик</h3>
                <button id="closeBuyModal" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="flex items-center gap-3 mb-5 p-3 bg-gray-50 rounded-lg">
                <img src="<?= htmlspecialchars($product['images'][0] ?? $site['baseUrl'] . '/public/assets/images/unknown/unknown.png') ?>"
                    alt="" class="w-14 h-14 rounded-lg object-contain bg-white border border-gray-100">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($product['name'] ?? $product['title']) ?></p>
                    <?php if ($firstPrice > 0): ?>
                    <p class="text-sm font-bold text-red-600 mt-0.5"><?= number_format($firstPrice, 0, '', ' ') ?> ₽ / <?= htmlspecialchars($firstUnit) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <form id="buyOneClickForm" class="space-y-4">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($productID) ?>">
                <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ваше имя *</label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" placeholder="Иван Иванов">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Телефон *</label>
                    <input type="tel" name="phone" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" placeholder="+7 (___) ___-__-__">
                </div>
                <div class="hidden"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>
                <div class="g-recaptcha" data-sitekey="6LeAE6csAAAAAAWm3hHXzuXTbyr-xeAGTvAcd2lB" style="transform:scale(0.85);transform-origin:left;"></div>
                <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition font-medium text-sm">
                    Отправить заявку
                </button>
                <p class="text-xs text-gray-400 text-center">Мы перезвоним в течение 15 минут</p>
            </form>
        </div>
    </div>

    <!-- Sticky Mobile Cart Bar -->
    <div class="mobile-sticky-cart lg:hidden" id="mobileStickyCart">
        <div class="flex items-center gap-2">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] text-gray-400 truncate leading-tight"><?= htmlspecialchars($product['name'] ?? $product['title']) ?></p>
                <p class="text-lg font-bold text-gray-900 leading-tight">
                    <?php if ($firstPrice > 0): ?>
                        <?= number_format($firstPrice, 0, '', ' ') ?> <span class="text-xs font-normal text-gray-500">₽/<?= htmlspecialchars($firstUnit) ?></span>
                    <?php else: ?>
                        Цена по запросу
                    <?php endif; ?>
                </p>
            </div>
            <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden shrink-0">
                <button type="button" class="cart-qty-btn cart-qty-minus w-8 h-9 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition text-sm font-medium" data-product-id="<?= htmlspecialchars($productID) ?>">−</button>
                <input type="number" id="mobile-qty-input" value="1" min="1"
                    class="w-9 h-9 text-center border-x border-gray-200 text-xs font-medium focus:outline-none"
                    data-product-id="<?= htmlspecialchars($productID) ?>">
                <button type="button" class="cart-qty-btn cart-qty-plus w-8 h-9 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition text-sm font-medium" data-product-id="<?= htmlspecialchars($productID) ?>">+</button>
            </div>
            <button type="button" id="mobile-add-to-cart-btn"
                class="shrink-0 bg-red-600 text-white py-2.5 px-4 rounded-lg hover:bg-red-700 transition font-medium text-xs flex items-center gap-1.5">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                В корзину
            </button>
        </div>
    </div>

    <!-- Swiper Slider JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="/public/assets/scripts/main/header.js" defer></script>
    <script src="/public/assets/scripts/components/toggleWindow.js" defer></script>
    <script src="/public/assets/scripts/components/share.js" defer></script>
    <script src="/public/assets/scripts/components/swiper.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Image gallery: click thumbnails to switch main image
            const mainImage = document.getElementById('main-image');
            const thumbnails = document.querySelectorAll('.thumbnail-btn');
            thumbnails.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    thumbnails.forEach(function (t) { t.classList.remove('active', 'border-red-500'); t.classList.add('border-gray-200'); });
                    this.classList.add('active', 'border-red-500');
                    this.classList.remove('border-gray-200');
                    mainImage.src = this.dataset.src;
                    mainImage.alt = this.dataset.alt;
                    mainImage.title = this.dataset.alt;
                });
            });

            // Star rating interaction
            const ratingInputs = document.querySelectorAll('input[name="rating"]');
            ratingInputs.forEach(function (input, index) {
                input.addEventListener('change', function () {
                    document.querySelectorAll('input[name="rating"]').forEach(function (radioInput, radioIndex) {
                        const icon = radioInput.nextElementSibling;
                        if (radioIndex < index + 1) {
                            icon.classList.remove('far');
                            icon.classList.add('fas', 'text-yellow-400');
                        } else {
                            icon.classList.remove('fas', 'text-yellow-400');
                            icon.classList.add('far');
                        }
                    });
                });
            });

            // Initialize reviews Swiper
            if (document.querySelector('.reviews-slider')) {
                new Swiper('.reviews-slider', {
                    slidesPerView: 1,
                    spaceBetween: 16,
                    navigation: {
                        nextEl: '.reviews-button-next',
                        prevEl: '.reviews-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        640: { slidesPerView: 2 },
                        1024: { slidesPerView: 3 },
                    }
                });
            }

            // Similar products Swiper
            if (document.querySelector('.similar-slider')) {
                new Swiper('.similar-slider', {
                    slidesPerView: 2,
                    spaceBetween: 12,
                    pagination: { el: '.similar-pagination', clickable: true },
                    navigation: { nextEl: '.similar-next', prevEl: '.similar-prev' },
                    breakpoints: {
                        480: { slidesPerView: 3 },
                        768: { slidesPerView: 4 },
                        1024: { slidesPerView: 5 },
                    }
                });
            }

            // Unit price switching
            const unitSelect = document.getElementById('unit-select');
            const currentPrice = document.getElementById('current-price');
            const currentUnit = document.getElementById('current-unit');
            const alternativePrices = document.getElementById('alternative-prices');
            const prices = <?= json_encode($product['units']) ?>;

            if (unitSelect && currentPrice && currentUnit && alternativePrices) {
                unitSelect.addEventListener('change', function () {
                    const selectedUnit = this.value;
                    const selectedPrice = prices[selectedUnit];
                    currentPrice.textContent = Number(selectedPrice).toLocaleString('ru-RU');
                    currentUnit.textContent = '₽ / ' + selectedUnit;

                    let altHtml = '';
                    for (const [unit, price] of Object.entries(prices)) {
                        if (unit !== selectedUnit) {
                            altHtml += '<span class="bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100"><strong class="text-red-600">' + Number(price).toLocaleString('ru-RU') + ' ₽</strong> / ' + unit + '</span>';
                        }
                    }
                    alternativePrices.innerHTML = altHtml;
                });
            }

            // Honeypot validation for review form
            const reviewForm = document.querySelector('form[action="/api/reviews"]');
            if (reviewForm) {
                reviewForm.addEventListener('submit', function (e) {
                    const website = this.querySelector('input[name="website"]').value;
                    if (website) {
                        e.preventDefault();
                        return false;
                    }
                });
            }
        });
    </script>

    <script>
    /* ===== QUANTITY PRESETS ===== */
    document.querySelectorAll('.qty-preset').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var inp = document.getElementById('cart-qty-input');
            if (inp) inp.value = this.getAttribute('data-qty');
        });
    });

    /* ===== FAVORITES ===== */
    (function() {
        var STORAGE_KEY = 'kavstal_favorites';
        function getFavs() { try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || []; } catch(e) { return []; } }
        function saveFavs(arr) { localStorage.setItem(STORAGE_KEY, JSON.stringify(arr)); }
        var favBtn = document.getElementById('product-fav-btn');
        if (!favBtn) return;
        var pid = favBtn.getAttribute('data-pid');
        function updateFavBtn() {
            var favs = getFavs();
            var isFav = favs.indexOf(pid) !== -1;
            var svgEmpty = '<svg width="16" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>';
            var svgFilled = '<svg width="16" height="14" viewBox="0 0 24 24" fill="#dc2626" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>';
            favBtn.innerHTML = isFav ? svgFilled : svgEmpty;
            if (isFav) { favBtn.classList.add('border-red-300', 'bg-red-50'); favBtn.classList.remove('border-zinc-200'); }
            else { favBtn.classList.remove('border-red-300', 'bg-red-50'); favBtn.classList.add('border-zinc-200'); }
            var badge = document.getElementById('favCountBadge');
            if (badge) { var c = getFavs().length; badge.textContent = c > 99 ? '99+' : c; badge.style.display = c > 0 ? 'flex' : 'none'; }
        }
        updateFavBtn();
        favBtn.addEventListener('click', function() {
            var favs = getFavs(), idx = favs.indexOf(pid);
            if (idx === -1) favs.push(pid); else favs.splice(idx, 1);
            saveFavs(favs);
            updateFavBtn();
        });
    })();

    /* ===== SHARE ===== */
    document.getElementById('product-share-btn').addEventListener('click', function() {
        if (navigator.share) {
            navigator.share({ title: document.title, url: window.location.href });
        } else if (navigator.clipboard) {
            navigator.clipboard.writeText(window.location.href);
            var tip = document.createElement('span');
            tip.textContent = 'Ссылка скопирована';
            tip.className = 'fixed bottom-4 left-1/2 -translate-x-1/2 bg-zinc-800 text-white text-xs px-3 py-1.5 rounded-lg z-50';
            document.body.appendChild(tip);
            setTimeout(function() { tip.remove(); }, 2000);
        }
    });

    /* ===== LIVE SEARCH ===== */
    (function() {
        var input = document.getElementById('searchInput'),
            dropdown = document.getElementById('searchDropdown'),
            wrap = document.getElementById('searchWrap'),
            timer = null,
            lastQuery = '',
            abortCtrl = null;
        if (!input || !dropdown) return;

        function highlight(text, q) {
            if (!q) return text;
            var esc = q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            return text.replace(new RegExp('(' + esc + ')', 'gi'), '<mark class="bg-yellow-100 text-yellow-800 rounded px-0.5">$1</mark>');
        }
        function showLoading(q) {
            dropdown.innerHTML = '<div class="flex items-center gap-3 px-4 py-3"><div class="w-5 h-5 border-2 border-red-300 border-t-red-600 rounded-full animate-spin"></div><span class="text-sm text-zinc-400">Поиск…</span></div>';
            showDD();
        }
        function renderResults(items, q) {
            if (!items.length) {
                dropdown.innerHTML = '<div class="px-4 py-6 text-center"><div class="text-sm text-zinc-400">Ничего не найдено</div></div>';
                showDD(); return;
            }
            var html = '<div class="max-h-[360px] overflow-y-auto">';
            items.forEach(function(p) {
                var img = p.image ? '<img src="' + p.image.replace(/"/g,'&quot;') + '" class="w-11 h-11 object-contain rounded-lg bg-zinc-50 border border-zinc-100 flex-shrink-0" loading="lazy">' : '<div class="w-11 h-11 rounded-lg bg-zinc-100 flex-shrink-0"></div>';
                var stock = p.in_stock ? '<span class="text-[10px] text-emerald-600">В наличии</span>' : '<span class="text-[10px] text-zinc-400">Под заказ</span>';
                html += '<a href="' + p.url + '" class="flex items-center gap-3 px-4 py-2.5 hover:bg-red-50/60 border-b border-zinc-50 last:border-0">' + img + '<div class="flex-1 min-w-0"><div class="text-[13px] text-zinc-800 truncate leading-snug">' + highlight(p.nameOrig.replace(/</g,'&lt;'), q) + '</div><div class="flex items-center gap-2 mt-0.5"><span class="text-sm font-bold text-zinc-900">' + p.price + ' ₽</span><span class="text-[10px] text-zinc-400">/ ' + p.unit + '</span>' + stock + '</div></div></a>';
            });
            html += '</div>';
            html += '<a href="/market?search=' + encodeURIComponent(q) + '" class="flex items-center justify-center gap-2 text-xs text-red-600 font-medium py-2.5 border-t border-zinc-100 hover:bg-red-50/50">Показать все результаты</a>';
            dropdown.innerHTML = html;
            showDD();
        }
        function showDD() { dropdown.classList.remove('hidden'); dropdown.style.maxHeight = '0'; dropdown.style.opacity = '0'; requestAnimationFrame(function() { dropdown.style.transition = 'max-height 0.25s ease, opacity 0.2s ease'; dropdown.style.maxHeight = '420px'; dropdown.style.opacity = '1'; }); }
        function hideDD() { dropdown.style.transition = 'max-height 0.15s ease, opacity 0.1s ease'; dropdown.style.maxHeight = '0'; dropdown.style.opacity = '0'; setTimeout(function() { dropdown.classList.add('hidden'); }, 160); }

        input.addEventListener('input', function() {
            var q = this.value.trim();
            clearTimeout(timer);
            if (q.length < 2) { hideDD(); lastQuery = ''; return; }
            if (q === lastQuery) return;
            lastQuery = q;
            if (abortCtrl) abortCtrl.abort();
            abortCtrl = new AbortController();
            showLoading(q);
            timer = setTimeout(function() {
                fetch('/api/search?q=' + encodeURIComponent(q) + '&limit=8', { signal: abortCtrl.signal })
                    .then(function(r) { return r.json(); })
                    .then(function(items) { renderResults(items, q); })
                    .catch(function(e) { if (e.name !== 'AbortError') hideDD(); });
            }, 180);
        });
        input.addEventListener('focus', function() { if (dropdown.innerHTML && dropdown.classList.contains('hidden')) showDD(); });
        document.addEventListener('click', function(e) { if (!wrap.contains(e.target)) hideDD(); });
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') { hideDD(); input.blur(); }
            if (e.key === 'ArrowDown') { var first = dropdown.querySelector('a[href]'); if (first) { e.preventDefault(); first.focus(); } }
        });
    })();

    function updateCartCount() {
        fetch('/api/cart/count').then(r => r.json()).then(d => {
            document.querySelectorAll('.cart-count-badge').forEach(el => {
                el.textContent = d.count > 99 ? '99+' : d.count;
                el.style.display = d.count > 0 ? 'flex' : 'none';
            });
        });
    }

    function addToCart(productId, quantity, unit) {
        const fd = new URLSearchParams();
        fd.append('product_id', productId);
        fd.append('quantity', quantity);
        fd.append('unit', unit);
        return fetch('/api/cart/add', { method: 'POST', body: fd }).then(r => r.json());
    }

    updateCartCount();
    (function() {
        var qtyInp = document.getElementById('cart-qty-input');
        var pid = qtyInp ? qtyInp.dataset.productId : '';
        if (!pid) return;
        fetch('/api/cart/products').then(r => r.json()).then(d => {
                if ((d.products || []).indexOf(pid) !== -1) {
                var btn = document.getElementById('add-to-cart-btn');
                if (btn) {
                    btn.innerHTML = '<i class="fas fa-plus"></i> В корзине';
                    btn.classList.add('bg-green-600', 'in-cart');
                }
            }
        });
    })();

    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('add-to-cart-btn');
        if (!addBtn) return;

        const qtyInput = document.getElementById('cart-qty-input');
        const unitSelect = document.getElementById('cart-unit-select');
        const feedback = document.getElementById('cart-feedback');

        document.querySelectorAll('.cart-qty-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                let val = parseInt(qtyInput.value) || 1;
                if (this.classList.contains('cart-qty-plus')) val += 1;
                else if (val > 1) val -= 1;
                qtyInput.value = val;
            });
        });

        addBtn.addEventListener('click', function() {
            const pid = qtyInput.dataset.productId;
            const qty = parseFloat(qtyInput.value) || 1;
            const unit = unitSelect.value;

            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Добавление...';

            addToCart(pid, qty, unit).then(r => {
                if (r.success) {
                    feedback.className = 'text-sm font-medium text-green-600';
                    feedback.textContent = '✓ Товар добавлен в корзину!';
                    this.classList.add('bg-green-600', 'in-cart');
                    this.innerHTML = '<i class="fas fa-plus"></i> В корзине';
                    updateCartCount();
                } else {
                    feedback.className = 'text-sm font-medium text-red-600';
                    feedback.textContent = 'Ошибка: ' + (r.error || 'повторите попытку');
                    this.innerHTML = '<i class="fas fa-shopping-cart"></i> В корзину';
                }
                this.disabled = false;
                setTimeout(() => { feedback.className = 'hidden'; }, 3000);
            }).catch(() => {
                feedback.className = 'text-sm font-medium text-red-600';
                feedback.textContent = 'Ошибка сети';
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-shopping-cart"></i> В корзину';
            });
        });
    });
    </script>

    <script>
    /* ===== IMAGE LIGHTBOX ===== */
    (function() {
        var lb = document.getElementById('imageLightbox');
        var lbImg = document.getElementById('lbImage');
        var lbCounter = document.getElementById('lbCounter');
        var lbPrev = document.getElementById('lbPrev');
        var lbNext = document.getElementById('lbNext');
        var closeBtn = document.getElementById('closeLightbox');
        var mainImg = document.getElementById('main-image');
        if (!lb) return;

        var images = <?= json_encode($product['images']) ?>;
        if (!images.length) return;
        var current = 0;

        function showLB(idx) {
            current = idx;
            lbImg.src = images[current];
            lbImg.alt = 'Фото ' + (current + 1) + ' из ' + images.length;
            lbCounter.textContent = (current + 1) + ' / ' + images.length;
            lb.classList.remove('hidden');
            lb.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function hideLB() {
            lb.classList.add('hidden');
            lb.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Desktop: click main image
        if (mainImg) {
            mainImg.style.cursor = 'zoom-in';
            mainImg.addEventListener('click', function() {
                var idx = images.indexOf(this.src);
                showLB(idx !== -1 ? idx : 0);
            });
        }

        // Desktop: double-click thumbnail to open lightbox
        document.querySelectorAll('.thumbnail-btn').forEach(function(btn) {
            btn.addEventListener('dblclick', function() {
                var idx = images.indexOf(this.dataset.src);
                showLB(idx !== -1 ? idx : 0);
            });
        });

        // Mobile: click gallery image
        document.querySelectorAll('.product-gallery-mobile .swiper-slide img').forEach(function(img) {
            img.style.cursor = 'zoom-in';
            img.addEventListener('click', function() {
                var idx = images.indexOf(this.src);
                showLB(idx !== -1 ? idx : 0);
            });
        });

        closeBtn.addEventListener('click', hideLB);
        lb.addEventListener('click', function(e) { if (e.target === lb) hideLB(); });
        document.addEventListener('keydown', function(e) {
            if (lb.classList.contains('hidden')) return;
            if (e.key === 'Escape') hideLB();
            if (e.key === 'ArrowLeft') showLB(current > 0 ? current - 1 : images.length - 1);
            if (e.key === 'ArrowRight') showLB(current < images.length - 1 ? current + 1 : 0);
        });
        lbPrev.addEventListener('click', function(e) { e.stopPropagation(); showLB(current > 0 ? current - 1 : images.length - 1); });
        lbNext.addEventListener('click', function(e) { e.stopPropagation(); showLB(current < images.length - 1 ? current + 1 : 0); });
    })();

    /* ===== MOBILE GALLERY SWIPER ===== */
    (function() {
        var gallery = document.querySelector('.product-gallery-mobile');
        if (!gallery) return;
        new Swiper(gallery, {
            slidesPerView: 1,
            spaceBetween: 0,
            pagination: { el: '.product-gallery-pagination', clickable: true },
        });
    })();

    /* ===== TABS ===== */
    document.querySelectorAll('.tab-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var tabId = this.getAttribute('data-tab');
            document.querySelectorAll('.tab-btn').forEach(function(b) {
                b.classList.remove('text-red-600', 'border-red-600');
                b.classList.add('text-gray-500', 'border-transparent');
                b.setAttribute('aria-selected', 'false');
            });
            this.classList.remove('text-gray-500', 'border-transparent');
            this.classList.add('text-red-600', 'border-red-600');
            this.setAttribute('aria-selected', 'true');
            document.querySelectorAll('.tab-content').forEach(function(c) {
                c.classList.add('hidden');
            });
            document.getElementById(tabId).classList.remove('hidden');
        });
    });

    /* ===== ACCORDION ===== */
    document.querySelectorAll('.accordion-header').forEach(function(header) {
        header.addEventListener('click', function() {
            var expanded = this.getAttribute('aria-expanded') === 'true';
            var body = this.nextElementSibling;
            this.setAttribute('aria-expanded', !expanded);
            if (expanded) {
                body.classList.remove('open');
                body.style.maxHeight = '0';
                body.style.paddingTop = '0';
                body.style.paddingBottom = '0';
            } else {
                body.classList.add('open');
                body.style.maxHeight = body.scrollHeight + 'px';
                body.style.paddingTop = '';
                body.style.paddingBottom = '';
                setTimeout(function() { body.style.maxHeight = 'none'; }, 300);
            }
        });
    });

    /* ===== BUY IN 1 CLICK MODAL ===== */
    (function() {
        var btn = document.getElementById('buy-one-click-btn');
        var modal = document.getElementById('buyOneClickModal');
        var closeBtn = document.getElementById('closeBuyModal');
        var form = document.getElementById('buyOneClickForm');
        if (!btn || !modal) return;
        function openModal() { modal.classList.add('active'); document.body.style.overflow = 'hidden'; }
        function closeModal() { modal.classList.remove('active'); document.body.style.overflow = ''; }
        btn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function(e) { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal(); });
        if (form) {
            form.addEventListener('submit', function(e) {
                if (this.querySelector('input[name="website"]').value) { e.preventDefault(); return; }
                var fd = new FormData(this);
                fetch('/api/orders/quick', { method: 'POST', body: fd })
                    .then(function(r) { return r.json(); })
                    .then(function(d) {
                        if (d.success) {
                            form.innerHTML = '<div class="text-center py-8"><div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"><svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div><p class="text-lg font-medium text-gray-900">Заявка отправлена!</p><p class="text-sm text-gray-500 mt-1">Перезвоним в течение 15 минут</p></div>';
                        } else {
                            alert('Ошибка: ' + (d.error || 'повторите попытку'));
                        }
                    })
                    .catch(function() { alert('Ошибка сети'); });
                e.preventDefault();
            });
        }
    })();

    /* ===== MOBILE STICKY CART SYNC ===== */
    (function() {
        var desktopBtn = document.getElementById('add-to-cart-btn');
        var mobileBtn = document.getElementById('mobile-add-to-cart-btn');
        var desktopQty = document.getElementById('cart-qty-input');
        var mobileQty = document.getElementById('mobile-qty-input');
        var unitSelect = document.getElementById('cart-unit-select');
        if (!desktopBtn || !mobileBtn) return;

        // Sync quantity inputs
        if (desktopQty && mobileQty) {
            mobileQty.addEventListener('input', function() { desktopQty.value = this.value; });
            desktopQty.addEventListener('input', function() { mobileQty.value = this.value; });
        }

        function syncMobileBtn() {
            if (desktopBtn.classList.contains('in-cart')) {
                mobileBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> В корзине';
                mobileBtn.classList.add('bg-green-600');
                mobileBtn.classList.remove('bg-red-600');
            } else {
                mobileBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg> В корзину';
                mobileBtn.classList.remove('bg-green-600');
                mobileBtn.classList.add('bg-red-600');
            }
        }
        mobileBtn.addEventListener('click', function() {
            // Sync qty before clicking desktop button
            if (mobileQty && desktopQty) desktopQty.value = mobileQty.value;
            desktopBtn.click();
            syncMobileBtn();
        });
        var observer = new MutationObserver(syncMobileBtn);
        observer.observe(desktopBtn, { attributes: true, attributeFilter: ['class'] });
        syncMobileBtn();
    })();

    /* ===== PROGRESSIVE IMAGE LOADING ===== */
    document.querySelectorAll('.product-gallery-img').forEach(function(img) {
        img.setAttribute('data-loaded', 'false');
        if (img.complete) { img.setAttribute('data-loaded', 'true'); return; }
        img.addEventListener('load', function() { this.setAttribute('data-loaded', 'true'); });
        img.addEventListener('error', function() { this.setAttribute('data-loaded', 'true'); });
    });

    /* ===== BREADCRUMBS: chevron separators ===== */
    document.querySelectorAll('nav .mx-2').forEach(function(sep) {
        sep.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>';
        sep.className = 'mx-1 text-gray-300';
    });
    </script>

</body>

</html>
