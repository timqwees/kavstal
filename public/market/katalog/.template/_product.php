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
    <title><?= htmlspecialchars($product['seo']['metaTitle'] ?? ($product['name'] . ' купить в Москве — цена за тонну, характеристики, ГОСТ | КАВ СТАЛЬ')) ?></title>
    <meta name="description" content="<?= htmlspecialchars($product['seo']['metaDescription'] ?? ($product['name'] . ' — купить в Москве по выгодной цене за тонну и за метр. Характеристики, марка стали, ГОСТ, резка в размер и доставка по Москве и МО от КАВ СТАЛЬ.')) ?>">
    <meta name="keywords"
        content="<?= htmlspecialchars($product['name'] ?? $product['title'] ?? 'Товар') ?>, <?= htmlspecialchars($product['title'] ?? '') ?>, купить <?= htmlspecialchars($product['categories']['title'] ?? 'металлопрокат') ?>, <?= htmlspecialchars($product['categories']['title'] ?? '') ?> цена за тонну, <?= htmlspecialchars($product['categories']['subcategory_title'] ?? '') ?>, металлопрокат москва, сортовой прокат, купить арматуру, доставка металлопроката">
    <link rel="canonical" href="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($product['seo']['canonicalUrl'] ?? '/') ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= htmlspecialchars($product['seo']['metaTitle'] ?? ($product['name'] . ' | Купить в Москве | КАВ СТАЛЬ')) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($product['seo']['metaDescription'] ?? '') ?>">
    <meta property="og:type" content="product">
    <meta property="og:url" content="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($product['seo']['canonicalUrl'] ?? '/') ?>">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($product['images'][0] ?? '/public/assets/images/bgpage/product.png') ?>">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company'] ?? 'КАВ СТАЛЬ') ?>">
    <meta property="og:locale" content="ru_RU">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($product['seo']['metaTitle'] ?? ($product['name'] . ' | Купить в Москве | КАВ СТАЛЬ')) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($product['seo']['metaDescription'] ?? '') ?>">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($product['images'][0] ?? '/public/assets/images/bgpage/product.png') ?>">

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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="<?= $site['baseUrl'] ?>" crossorigin>

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

    // Загружаем товары один раз для хлебных крошек и похожих товаров
    $allProducts = Setting\route\function\Functions::listProducts();

    if ($parentId && $categoryId) {
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
                    'name' => $subcategory['name'] ?? $subcategory['title'] ?? $categoryId,
                    'item' => $site['baseUrl'] . '/market/katalog/' . $parentCategory['id'] . '/' . $categoryId
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
            "sku": "<?= htmlspecialchars($product['id'] ?? $productID) ?>",
            "mpn": "<?= htmlspecialchars($product['id'] ?? $productID) ?>",
            "brand": {
                "@type": "Brand",
                "name": "<?= htmlspecialchars($site['company']) ?>"
            }<?php if ($reviewCount > 0): ?>,
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "<?= htmlspecialchars(number_format((float) $averageRating, 1, '.', '')) ?>",
                "reviewCount": "<?= (int) $reviewCount ?>",
                "bestRating": "5",
                "worstRating": "1"
            }
            <?php endif; ?>,
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
                },
                "hasMerchantReturnPolicy": {
                    "@type": "MerchantReturnPolicy",
                    "applicableCountry": "RU",
                    "returnPolicyCategory": "https://schema.org/MerchantReturnFiniteReturnWindow",
                    "merchantReturnDays": "14",
                    "returnMethod": "https://schema.org/ReturnByMail",
                    "returnFees": "https://schema.org/FreeReturn",
                    "refundType": "https://schema.org/FullRefund"
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
    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <script src="/public/assets/scripts/components/search.min.js" defer></script>
    <script src="/public/assets/scripts/components/cart-favorites.min.js" defer></script>

    <!-- Swiper Slider CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Intl Tel Input CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@27.1.3/dist/css/intlTelInput.css">

    <!-- Local Styles -->
    <link rel="preload" href="/public/assets/styles/catalog.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="/public/assets/styles/catalog.min.css">
    </noscript>

    <style>
        .swiper-pagination-bullet {
            width: 6px;
            height: 6px;
            background: #d1d5db;
            opacity: 0.7;
            transition: all 0.3s ease;
        }
        .swiper-pagination-bullet-active {
            width: 20px;
            border-radius: 3px;
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
        .product-gallery-pagination .swiper-pagination-bullet { background: #d1d5db; opacity: 0.7; width: 6px; height: 6px; transition: all 0.3s ease; }
        .product-gallery-pagination .swiper-pagination-bullet-active { background: #ef4444; opacity: 1; width: 20px; border-radius: 3px; }

        /* Image skeleton loader */
        .product-gallery-img { background: #f9fafb; }
        .product-gallery-img[data-loaded="false"] { opacity: 0; }
        .product-gallery-img[data-loaded="true"] { opacity: 1; transition: opacity 0.3s ease; }

        /* Accordion */
        .accordion-header { cursor: pointer; user-select: none; border-radius: 16px 16px 0 0; }
        .accordion-header:hover { background: #fafafa; }
        .accordion-header .accordion-icon { transition: transform 0.25s ease; }
        .accordion-header[aria-expanded="true"] .accordion-icon { transform: rotate(180deg); }
        .accordion-body { overflow: hidden; max-height: 0; transition: max-height 0.3s ease; }
        .accordion-body.open { max-height: 2000px; }

        /* Accordion first child radius */
        .accordion-header:first-child { border-radius: 16px 16px 0 0; }

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

        /* Modal */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 60; display: flex; align-items: flex-end; justify-content: center; opacity: 0; visibility: hidden; transition: opacity 0.2s ease, visibility 0.2s ease; }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        .modal-overlay.active .modal-sheet { transform: translateY(0); }
        .modal-sheet { background: white; border-radius: 16px 16px 0 0; width: 100%; max-width: 480px; max-height: 80vh; overflow-y: auto; transform: translateY(100%); transition: transform 0.3s ease; padding: 24px; }
        #buyOneClickModal .modal-sheet { overflow: visible; max-height: none; }
        @media (min-width: 640px) { .modal-sheet { border-radius: 16px; margin: auto; max-height: 70vh; } }

        /* Tabs */
        .tab-btn { position: relative; }
        .tab-btn::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0;
            height: 2px; background: #ef4444; border-radius: 1px 1px 0 0;
            transform: scaleX(0); transition: transform 0.25s ease;
        }
        .tab-btn.text-red-500::after { transform: scaleX(1); }

        /* Similar slider card */
        .similar-card:hover { transform: translateY(-2px); }

        /* Trust badge */
        .trust-badge { transition: transform 0.2s ease; }
        .trust-badge:hover { transform: translateY(-1px); }

        .iti__selected-dial-code { color: #000; }
        .iti { width: 100%; }
    </style>
  <?php include_once __DIR__ . "/../../../components/seo-head.php"; ?>
</head>

<body class="bg-zinc-50">
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-red-500 focus:text-white focus:px-4 focus:py-2 focus:rounded-lg">
        Перейти к основному содержанию
    </a>

    <?php include_once './public/components/header-shared.php'; ?>

    <main id="main-content" class="max-w-7xl mx-auto px-4 pt-4 pb-12 lg:pt-6">

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-1.5 text-sm mb-6" aria-label="Breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <a href="/" class="inline-flex items-center text-zinc-500 hover:text-red-500 transition-colors" itemprop="item" itemscope itemtype="https://schema.org/Thing" itemid="<?= $site['baseUrl'] ?>/">
                <svg class="me-1.5 h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/></svg>
                <span itemprop="name">Главная</span>
            </a>
            <meta itemprop="position" content="1">
            <svg class="h-4 w-4 text-zinc-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>

            <a href="/market" class="text-zinc-500 hover:text-red-500 transition-colors" itemprop="item" itemscope itemtype="https://schema.org/Thing" itemid="<?= $site['baseUrl'] ?>/market">
                <span itemprop="name">Каталог</span>
            </a>
            <meta itemprop="position" content="2">
            <svg class="h-4 w-4 text-zinc-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>

            <?php
            $allProducts = Setting\route\function\Functions::listProducts();
            $parentTitle = 'Каталог';
            $parentSlug = $katalog;
            foreach ($allProducts as $p) {
                if (($p['badge'] ?? '') === 'Категория' && ($p['id'] ?? '') === $katalog) {
                    $parentTitle = $p['title'] ?? $katalog;
                    break;
                }
            }

            $subcategoryTitle = null;
            $subcategorySlug = $subcategory ?? '';
            if (!empty($subcategorySlug)) {
                foreach ($allProducts as $p) {
                    if (($p['badge'] ?? '') === 'Подкатегория' && ($p['categories']['id'] ?? '') === $subcategorySlug) {
                        $subcategoryTitle = $p['name'] ?? $p['title'] ?? $subcategorySlug;
                        break;
                    }
                }
            }
            ?>
            <a href="/market/katalog/<?= htmlspecialchars($katalog) ?>" class="text-zinc-500 hover:text-red-500 transition-colors" itemprop="item" itemscope itemtype="https://schema.org/Thing" itemid="<?= $site['baseUrl'] ?>/market/katalog/<?= htmlspecialchars($katalog) ?>">
                <span itemprop="name"><?= htmlspecialchars($parentTitle) ?></span>
            </a>
            <meta itemprop="position" content="3">
            <svg class="h-4 w-4 text-zinc-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>

            <?php if ($subcategoryTitle): ?>
            <a href="/market/katalog/<?= htmlspecialchars($katalog) ?>/<?= htmlspecialchars($subcategorySlug) ?>" class="text-zinc-500 hover:text-red-500 transition-colors" itemprop="item" itemscope itemtype="https://schema.org/Thing" itemid="<?= $site['baseUrl'] ?>/market/katalog/<?= htmlspecialchars($katalog) ?>/<?= htmlspecialchars($subcategorySlug) ?>">
                <span itemprop="name"><?= htmlspecialchars($subcategoryTitle) ?></span>
            </a>
            <meta itemprop="position" content="4">
            <svg class="h-4 w-4 text-zinc-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
            <span class="text-zinc-900 font-medium" itemprop="name"><?= htmlspecialchars($product['name'] ?? $product['title'] ?? 'Товар') ?></span>
            <meta itemprop="position" content="5">
            <?php else: ?>
            <span class="text-zinc-900 font-medium" itemprop="name"><?= htmlspecialchars($product['name'] ?? $product['title'] ?? 'Товар') ?></span>
            <meta itemprop="position" content="4">
            <?php endif; ?>
        </nav>

        <!-- Two-Column Product Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

            <!-- Left Column: Gallery -->
            <div class="lg:col-span-5 lg:sticky lg:top-[120px] lg:self-start">
                <!-- Desktop -->
                <div class="hidden lg:block">
                    <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden mb-3 shadow-sm">
                        <div class="flex items-center justify-center p-6" style="aspect-ratio: 1;">
                            <img id="main-image"
                                src="<?= htmlspecialchars($product['images'][0] ?? $site['baseUrl'] . '/public/assets/images/unknown/unknown.png') ?>"
                                alt="<?= htmlspecialchars($product['name'] ?? $product['title']) ?>"
                                title="<?= htmlspecialchars($product['name'] ?? $product['title']) ?>"
                                width="800" height="800" fetchpriority="high" decoding="async"
                                class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                    <div class="flex gap-2 overflow-x-auto pb-1" id="thumbnail-list">
                        <?php foreach ($product['images'] as $index => $image): ?>
                        <button class="thumbnail-btn flex-shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden border-2 <?= $index === 0 ? 'active border-red-500' : 'border-zinc-200' ?> hover:border-red-300 transition-colors"
                            data-src="<?= htmlspecialchars($image) ?>"
                            data-alt="<?= htmlspecialchars($product['name'] ?? $product['title']) . ($index > 0 ? ' - фото ' . ($index + 1) : '') ?>">
                            <img src="<?= htmlspecialchars($image) ?>"
                                alt="<?= htmlspecialchars($product['name'] ?? $product['title']) ?>"
                                class="w-full h-full object-cover"
                                loading="lazy">
                        </button>
                        <?php endforeach; ?>
                    </div>
                    <p class="text-xs text-zinc-400 text-center mt-3">Наведите курсор на изображение для увеличения</p>
                </div>

                <!-- Mobile -->
                <div class="lg:hidden">
                    <div class="swiper product-gallery-mobile" style="border-radius: 12px; overflow: hidden;">
                        <div class="swiper-wrapper">
                            <?php foreach ($product['images'] as $index => $image): ?>
                            <div class="swiper-slide">
                                <div class="bg-white border border-zinc-200 overflow-hidden" style="aspect-ratio: 1;">
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
            <div class="lg:col-span-7 space-y-4">

                <!-- Title + Actions -->
                <div class="flex items-start justify-between gap-3">
                    <h1 class="text-2xl lg:text-3xl font-bold text-zinc-900 leading-tight flex-1">
                        <?= htmlspecialchars($product['name'] ?? $product['title']) ?>
                    </h1>
                    <div class="flex items-center gap-2 shrink-0">
                        <button type="button" id="product-fav-btn" class="w-9 h-9 rounded-xl border border-zinc-200 flex items-center justify-center hover:border-red-300 hover:bg-red-50 transition-colors" data-pid="<?= htmlspecialchars($productID) ?>" title="В избранное">
                            <svg width="16" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </button>
                        <button type="button" id="product-share-btn" class="w-9 h-9 rounded-xl border border-zinc-200 flex items-center justify-center hover:border-zinc-300 hover:bg-zinc-50 transition-colors" title="Поделиться">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Rating + Stock -->
                <div class="flex flex-wrap items-center gap-2">
                    <div class="flex items-center gap-1">
                        <?php if ($reviewCount > 0): ?>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star text-sm <?= $i <= floor((float) $averageRating) ? 'text-yellow-400' : 'text-zinc-200' ?>"></i>
                            <?php endfor; ?>
                            <span class="text-sm font-medium text-zinc-700 ml-1.5"><?= number_format((float) $averageRating, 1) ?></span>
                            <span class="text-sm text-zinc-400 ml-1">(<?= $reviewCount ?>)</span>
                        <?php else: ?>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star text-sm text-zinc-200"></i>
                            <?php endfor; ?>
                            <span class="text-sm text-zinc-400 ml-1.5">Нет отзывов</span>
                        <?php endif; ?>
                    </div>
                    <span class="text-zinc-300 mx-1">|</span>
                    <?php if ($product['in_stock']): ?>
                        <span class="text-green-600 text-sm font-medium">✔ В наличии</span>
                    <?php else: ?>
                        <span class="text-red-500 text-sm font-medium">Под заказ</span>
                    <?php endif; ?>
                </div>

                <!-- Price + Cart Card -->
                <div class="bg-white rounded-2xl border border-zinc-200 p-5 lg:p-6 shadow-sm">
                    <?php
                    $firstUnit = array_key_first($product['units'] ?? []);
                    $firstPrice = is_numeric($product['units'][$firstUnit] ?? null) ? (float) $product['units'][$firstUnit] : 0;
                    ?>
                    <div class="flex flex-col lg:flex-row justify-between gap-4">
                        <div class="min-w-0 lg:translate-y-1/3">
                            <div class="flex flex-wrap items-baseline gap-2">
                                <span class="text-3xl lg:text-4xl font-bold text-zinc-900" id="current-price">
                                    <?= $firstPrice > 0 ? number_format($firstPrice, 0, '', ' ') : 'Цена по запросу' ?>
                                </span>
                                <span class="text-lg text-zinc-500" id="current-unit"><?= $firstPrice > 0 ? '₽ / ' . $firstUnit : '' ?></span>
                            </div>
                            <div class="flex flex-wrap gap-2 mt-2 text-sm" id="alternative-prices">
                                <?php foreach (($product['units'] ?? []) as $unit => $price):
                                    if ($unit !== $firstUnit && is_numeric($price)): ?>
                                    <span class="bg-zinc-50 px-3 py-1 rounded-lg border border-zinc-200 hover:border-red-200 hover:bg-red-50 transition-colors">
                                        <strong class="text-red-500"><?= number_format((float) $price, 0, '', ' ') ?> ₽</strong> / <?= htmlspecialchars($unit) ?>
                                    </span>
                                <?php endif; endforeach; ?>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 shrink-0">
                            <div>
                                <div class="flex items-center gap-1.5 mb-1">
                                    <span class="text-xs font-medium text-zinc-500">Количество</span>
                                    <button type="button" class="qty-preset text-[10px] px-1.5 py-0.5 rounded text-zinc-400 hover:text-red-500 hover:bg-red-50 transition font-medium leading-none" data-qty="1">1</button>
                                    <button type="button" class="qty-preset text-[10px] px-1.5 py-0.5 rounded text-zinc-400 hover:text-red-500 hover:bg-red-50 transition font-medium leading-none" data-qty="5">5</button>
                                    <button type="button" class="qty-preset text-[10px] px-1.5 py-0.5 rounded text-zinc-400 hover:text-red-500 hover:bg-red-50 transition font-medium leading-none" data-qty="10">10</button>
                                    <button type="button" class="qty-preset text-[10px] px-1.5 py-0.5 rounded text-zinc-400 hover:text-red-500 hover:bg-red-50 transition font-medium leading-none" data-qty="20">20</button>
                                </div>
                                <div class="flex items-center border border-zinc-200 rounded-xl overflow-hidden">
                                    <button type="button" class="cart-qty-btn cart-qty-minus w-10 h-10 flex items-center justify-center text-zinc-500 hover:text-red-500 hover:bg-red-50 transition text-lg" data-product-id="<?= htmlspecialchars($productID) ?>" aria-label="Уменьшить количество">−</button>
                                    <input type="number" id="cart-qty-input" value="1" min="1"
                                        aria-label="Количество" inputmode="numeric"
                                        class="w-24 h-10 text-center border-x border-zinc-200 text-sm font-medium focus:outline-none"
                                        data-product-id="<?= htmlspecialchars($productID) ?>">
                                    <button type="button" class="cart-qty-btn cart-qty-plus w-10 h-10 flex items-center justify-center text-zinc-500 hover:text-red-500 hover:bg-red-50 transition text-lg" data-product-id="<?= htmlspecialchars($productID) ?>" aria-label="Увеличить количество">+</button>
                                </div>
                            </div>
                            <div>
                                <label for="cart-unit-select" class="block text-xs font-medium text-zinc-500 mb-1">Единица</label>
                                <select id="cart-unit-select"
                                    class="w-full h-10 px-3 border border-zinc-200 rounded-xl text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white min-w-[100px]">
                                    <?php foreach ($product['units'] as $unit => $price): ?>
                                        <option value="<?= htmlspecialchars($unit) ?>" data-price="<?= (float)$price ?>">
                                            <?= htmlspecialchars($unit) ?> — <?= number_format((float)$price, 0, '', ' ') ?> ₽
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-zinc-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <button type="button" id="add-to-cart-btn"
                                class="w-full bg-red-500 text-white py-3 px-6 rounded-xl hover:bg-red-500 transition-all font-medium shadow-sm flex items-center justify-center gap-2">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                В корзину
                            </button>
                            <button type="button" id="buy-one-click-btn"
                                class="w-full border-2 border-red-500 text-red-500 py-3 px-6 rounded-xl hover:bg-red-50 transition-all font-medium flex items-center justify-center gap-2">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                Купить в 1 клик
                            </button>
                        </div>
                        <div id="cart-feedback" class="hidden text-sm font-medium mt-2"></div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="trust-badge inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-green-50 text-green-700 border border-green-100"><i class="fas fa-check-circle text-green-500"></i> Официальный дилер</span>
                        <span class="trust-badge inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-red-500 border border-red-100"><i class="fas fa-shield-alt text-red-500"></i> Гарантия качества</span>
                        <span class="trust-badge inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100"><i class="fas fa-file-invoice text-blue-500"></i> Сертификаты</span>
                    </div>
                </div>

                <!-- Key Specs -->
                <?php if (!empty($product['specs']) && is_array($product['specs'])): ?>
                <div class="bg-white rounded-2xl border border-zinc-200 p-5">
                    <h3 class="text-xs font-semibold text-zinc-500 mb-3 uppercase tracking-wider">Характеристики</h3>
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
                            <div class="flex justify-between py-2 border-b border-zinc-50">
                                <span class="text-zinc-500"><?= htmlspecialchars($label) ?></span>
                                <span class="font-medium text-zinc-900 text-right ml-2"><?= htmlspecialchars($value) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($specEntries) > 8): ?>
                    <button onclick="document.querySelector('[data-section=specs]').scrollIntoView({behavior:'smooth'})" class="mt-3 text-sm text-red-500 hover:text-red-500 font-medium">
                        Все характеристики <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Delivery + Contact -->
                <div class="space-y-3">
                    <div class="bg-red-50 border border-red-100 rounded-2xl p-4 text-sm">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                            <div>
                                <p class="font-medium text-red-900">Доставка по Москве и всей России</p>
                                <p class="text-red-500">От 1 дня. Бесплатно от 100 000 ₽. Возможен самовывоз.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <a href="tel:<?= preg_replace('/[^0-9+]/', '', $site['phone']) ?>"
                            class="flex items-center justify-center gap-2 border border-zinc-200 text-zinc-700 py-3 px-4 rounded-xl hover:bg-zinc-50 transition font-medium text-sm">
                            <i class="fas fa-phone-alt text-red-500"></i> Заказать по звонку
                        </a>
                        <a href="mailto:<?= htmlspecialchars($site['email']) ?>?subject=Запрос: <?= rawurlencode($product['name'] ?? $product['title'] ?? 'Товар') ?>&body=Здравствуйте!%0A%0AМеня интересует: <?= rawurlencode($product['name'] ?? $product['title'] ?? 'Товар') ?>%0A%0AСсылка: <?= rawurlencode($site['baseUrl'] . ($product['seo']['canonicalUrl'] ?? '/')) ?>%0A%0A---%0AПожалуйста, свяжитесь со мной для уточнения деталей."
                            class="flex items-center justify-center gap-2 border border-zinc-200 text-zinc-700 py-3 px-4 rounded-xl hover:bg-zinc-50 transition font-medium text-sm">
                            <i class="fas fa-envelope text-red-500"></i> Отправить запрос
                        </a>
                        <a href="https://t.me/kavstal_bot" target="_blank"
                            class="flex items-center justify-center gap-2 bg-sky-500 text-white py-3 px-4 rounded-xl hover:bg-sky-600 transition font-medium text-sm">
                            <i class="fab fa-telegram-plane"></i> Telegram
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Below the Fold Sections -->
        <div class="mt-12 space-y-6">

            <!-- Tabs: Описание | Характеристики | Доставка и оплата -->
            <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden shadow-sm">
                <div class="border-b border-zinc-100">
                    <div class="flex overflow-x-auto" role="tablist">
                        <button class="tab-btn px-6 lg:px-8 py-4 text-sm font-medium whitespace-nowrap transition-colors text-red-500" data-tab="tab-desc" role="tab" aria-selected="true">Описание</button>
                        <button class="tab-btn px-6 lg:px-8 py-4 text-sm font-medium whitespace-nowrap transition-colors text-zinc-500 hover:text-zinc-700" data-tab="tab-specs" role="tab" aria-selected="false">Характеристики</button>
                        <button class="tab-btn px-6 lg:px-8 py-4 text-sm font-medium whitespace-nowrap transition-colors text-zinc-500 hover:text-zinc-700" data-tab="tab-delivery" role="tab" aria-selected="false">Доставка и оплата</button>
                    </div>
                </div>

                <!-- Tab: Описание -->
                <div id="tab-desc" class="tab-content px-6 lg:px-8 py-6 lg:py-8" role="tabpanel">
                    <?php if (!empty($product['description'])): ?>
                    <div class="text-zinc-600 leading-relaxed text-sm lg:text-base max-w-3xl">
                        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                    </div>
                    <?php else: ?>
                    <p class="text-sm text-zinc-400">Описание не указано</p>
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
                                <div class="flex justify-between py-3 border-b border-zinc-50">
                                    <span class="text-zinc-500 text-sm"><?= htmlspecialchars($label) ?></span>
                                    <span class="font-medium text-zinc-900 text-sm text-right ml-2"><?= htmlspecialchars($value) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-zinc-400">Характеристики не указаны</p>
                    <?php endif; ?>
                </div>

                <!-- Tab: Доставка и оплата -->
                <div id="tab-delivery" class="tab-content px-6 lg:px-8 py-6 lg:py-8 hidden" role="tabpanel">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="border border-zinc-100 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-zinc-900">Автотранспорт</h4>
                                    <span class="text-xs text-zinc-400 bg-zinc-50 px-2 py-0.5 rounded-full">1-3 дня</span>
                                </div>
                                <p class="text-zinc-600 text-sm mb-3">Доставка по Москве и Московской области</p>
                                <ul class="text-sm text-zinc-500 space-y-1">
                                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>Грузовики 5-20 тонн</li>
                                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>Разгрузка на объекте</li>
                                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>Страховка груза</li>
                                </ul>
                            </div>
                            <div class="border border-zinc-100 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-zinc-900">Ж/д транспорт</h4>
                                    <span class="text-xs text-zinc-400 bg-zinc-50 px-2 py-0.5 rounded-full">3-7 дней</span>
                                </div>
                                <p class="text-zinc-600 text-sm mb-3">Доставка в регионы России</p>
                                <ul class="text-sm text-zinc-500 space-y-1">
                                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>Вагоны и контейнеры</li>
                                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>До ж/д станции</li>
                                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>Трекинг груза</li>
                                </ul>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="border border-zinc-100 rounded-xl p-4">
                                <h4 class="font-medium text-zinc-900 mb-2">Безналичный расчет</h4>
                                <p class="text-zinc-600 text-sm mb-3">Для юридических лиц и ИП</p>
                                <ul class="text-sm text-zinc-500 space-y-1">
                                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>Счет с НДС</li>
                                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>Отсрочка платежа</li>
                                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>Договор поставки</li>
                                </ul>
                            </div>
                            <div class="border border-zinc-100 rounded-xl p-4">
                                <h4 class="font-medium text-zinc-900 mb-2">Наличный расчет</h4>
                                <p class="text-zinc-600 text-sm mb-3">Для физических лиц</p>
                                <ul class="text-sm text-zinc-500 space-y-1">
                                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>Оплата при получении</li>
                                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>Кассовые чеки</li>
                                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>Расписка о получении</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 bg-zinc-50 border border-zinc-100 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-zinc-400 mt-0.5"></i>
                            <div class="text-sm text-zinc-600 space-y-1">
                                <p>• Минимальная сумма заказа — 50 000 ₽</p>
                                <p>• Бесплатная доставка при заказе от 100 000 ₽ по Москве</p>
                                <p>• Возможен самовывоз со склада в Москве</p>
                                <p>• Сертификаты на всю продукцию</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Section — Accordion -->
            <div class="bg-white rounded-xl border border-zinc-200 overflow-hidden">
                <button class="accordion-header w-full flex items-center justify-between p-6 lg:p-8 text-left" aria-expanded="true" data-accordion="reviews">
                    <div class="flex items-center gap-3">
                        <h2 class="text-xl font-bold text-zinc-900">Отзывы</h2>
                        <?php if ($reviewCount > 0): ?>
                        <span class="bg-zinc-100 text-zinc-600 text-xs font-medium px-2 py-0.5 rounded-full"><?= $reviewCount ?></span>
                        <?php endif; ?>
                    </div>
                    <svg class="accordion-icon w-5 h-5 text-zinc-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
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
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <span class="text-red-500"><?= htmlspecialchars($errorMessage) ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Reviews Summary -->
                <div class="bg-white border border-zinc-200 rounded-2xl p-5 mb-8 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-0.5">
                                <?php if ($reviewCount > 0): ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?= $i <= floor($averageRating) ? 'text-yellow-400' : 'text-zinc-200' ?>"></i>
                                    <?php endfor; ?>
                                    <span class="text-xl font-bold text-zinc-900 ml-2"><?= number_format($averageRating, 1) ?></span>
                                <?php else: ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star text-zinc-200"></i>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </div>
                            <span class="text-zinc-300">|</span>
                            <span class="text-sm text-zinc-500"><?php
                                $cnt = count($reviews);
                                if ($cnt > 0) {
                                    $word = 'отзывов';
                                    if ($cnt % 100 < 11 || $cnt % 100 > 14) {
                                        if ($cnt % 10 == 1) $word = 'отзыв';
                                        elseif ($cnt % 10 >= 2 && $cnt % 10 <= 4) $word = 'отзыва';
                                    }
                                    echo $cnt . ' ' . $word;
                                } else {
                                    echo 'Нет отзывов';
                                }
                            ?></span>
                        </div>
                        <button onclick="document.getElementById('review-form').scrollIntoView({behavior:'smooth'})"
                            class="bg-red-500 text-white px-5 py-2.5 rounded-xl hover:bg-red-500 transition font-medium text-sm">
                            Написать отзыв
                        </button>
                    </div>
                </div>

                <?php if (isset($reviews) && !empty($reviews)): ?>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-zinc-900">Отзывы покупателей</h3>
                    <div class="flex items-center gap-2">
                        <button class="reviews-button-prev w-8 h-8 bg-white border border-zinc-200 rounded-full flex items-center justify-center hover:bg-zinc-50 transition">
                            <i class="fas fa-chevron-left text-xs text-zinc-600"></i>
                        </button>
                        <button class="reviews-button-next w-8 h-8 bg-white border border-zinc-200 rounded-full flex items-center justify-center hover:bg-zinc-50 transition">
                            <i class="fas fa-chevron-right text-xs text-zinc-600"></i>
                        </button>
                    </div>
                </div>
                <div class="swiper reviews-slider" style="padding-bottom: 40px;">
                    <div class="swiper-wrapper">
                        <?php foreach ($reviews as $review): ?>
                            <div class="swiper-slide" itemscope itemtype="https://schema.org/Review">
                                <div class="border border-zinc-100 rounded-lg p-5 h-full bg-white hover:shadow-md transition-shadow">
                                    <div class="flex items-start gap-3 mb-3">
                                        <div class="w-10 h-10 bg-zinc-100 rounded-full flex items-center justify-center shrink-0">
                                            <span class="text-sm font-medium text-zinc-600"><?= mb_substr(htmlspecialchars($review['name']), 0, 1) ?></span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-2">
                                                <span itemprop="author" class="font-medium text-zinc-900 truncate"><?= htmlspecialchars($review['name']) ?></span>
                                                <span class="text-xs text-zinc-500 whitespace-nowrap"><?= date('d.m.Y', strtotime($review['created_at'])) ?></span>
                                            </div>
                                            <div itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating" class="mt-1">
                                                <meta itemprop="ratingValue" content="<?= $review['rating'] ?>">
                                                <div class="flex items-center">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i class="fas fa-star text-xs <?= $i <= $review['rating'] ? 'text-yellow-400' : 'text-zinc-200' ?>"></i>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p itemprop="reviewBody" class="text-zinc-700 text-sm leading-relaxed">
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
                    <div class="w-14 h-14 bg-zinc-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-xl text-zinc-300"></i>
                    </div>
                    <p class="text-base font-medium text-zinc-700 mb-1">Пока нет отзывов</p>
                    <p class="text-sm text-zinc-400">Станьте первым, кто оставит отзыв об этом товаре</p>
                </div>
                <?php endif; ?>

                <!-- Review Form -->
                <div id="review-form" class="border-t border-zinc-100 pt-8 mt-8">
                    <h3 class="text-lg font-semibold text-zinc-900 mb-6">Оставить отзыв</h3>
                    <form action="/api/reviews" method="POST" class="space-y-5">
                        <input type="hidden" name="product_id" value="<?= strval($productID) ?>">
                        <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Ваше имя *</label>
                                <input type="text" name="name" required
                                    class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                    placeholder="Иван Иванов">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Email (не публикуется)</label>
                                <input type="email" name="email"
                                    class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                    placeholder="ivan@example.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-2">Оценка *</label>
                            <div class="flex items-center gap-3">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="<?= $i ?>" class="sr-only" required aria-label="Оценка <?= $i ?>" <?= $i === 5 ? 'checked' : '' ?>>
                                        <i class="far fa-star text-2xl text-zinc-300 hover:text-yellow-400 transition-colors" aria-hidden="true"></i>
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1">Ваш отзыв *</label>
                            <textarea name="review" rows="4" required
                                class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                placeholder="Расскажите о вашем опыте использования..."></textarea>
                        </div>

                        <div class="hidden">
                            <input type="text" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-xs text-zinc-500">* Email не публикуется.</p>
                            <button type="submit"
                                class="bg-red-500 text-white px-6 py-2.5 rounded-xl hover:bg-red-500 transition font-medium text-sm">
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
            <div class="bg-white rounded-2xl border border-zinc-200 p-5 lg:p-6 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold text-zinc-900">Похожие товары</h2>
                    <div class="flex items-center gap-2">
                        <button class="similar-prev w-8 h-8 bg-white border border-zinc-200 rounded-full flex items-center justify-center hover:bg-zinc-50 hover:border-red-200 transition disabled:opacity-30">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <button class="similar-next w-8 h-8 bg-white border border-zinc-200 rounded-full flex items-center justify-center hover:bg-zinc-50 hover:border-red-200 transition disabled:opacity-30">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                </div>
                <div class="swiper similar-slider" style="padding-bottom: 28px;">
                    <div class="swiper-wrapper">
                        <?php foreach ($similarProducts as $item):
                            $itemUnit = array_key_first($item['units'] ?? []);
                            $itemPrice = ($itemUnit !== null && is_numeric($item['units'][$itemUnit] ?? null)) ? (float) $item['units'][$itemUnit] : 0;
                            $itemSpecs = [];
                            if (!empty($item['specs']) && is_array($item['specs'])) {
                                $specCount = 0;
                                foreach ($item['specs'] as $sk => $sv) {
                                    if ($specCount >= 2) break;
                                    $label = is_array($sv) ? ($sv['label'] ?? $sk) : $sk;
                                    $value = is_array($sv) ? ($sv['value'] ?? $sv) : $sv;
                                    if (is_string($value) && $value !== '') {
                                        $itemSpecs[] = htmlspecialchars($value);
                                        $specCount++;
                                    }
                                }
                            }
                        ?>
                        <div class="swiper-slide">
                            <a href="<?= htmlspecialchars($item['seo']['canonicalUrl'] ?? '#') ?>"
                                class="group block border border-zinc-100 rounded-xl overflow-hidden hover:shadow-lg hover:border-zinc-200 transition-all duration-200 similar-card bg-white">
                                <div class="bg-zinc-50 overflow-hidden flex items-center justify-center p-4" style="aspect-ratio: 1;">
                                    <img src="<?= htmlspecialchars($item['images'][0] ?? $site['baseUrl'] . '/public/assets/images/unknown/unknown.png') ?>"
                                        alt="<?= htmlspecialchars($item['name'] ?? '') ?>"
                                        class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-300"
                                        loading="lazy">
                                </div>
                                <div class="p-3 border-t border-zinc-50">
                                    <p class="text-sm font-medium text-zinc-900 line-clamp-2 leading-tight min-h-[2.5em]"><?= htmlspecialchars($item['name'] ?? '') ?></p>
                                    <?php if (!empty($itemSpecs)): ?>
                                    <div class="flex flex-wrap gap-1 mt-1.5">
                                        <?php foreach ($itemSpecs as $sv): ?>
                                        <span class="text-[10px] px-1.5 py-0.5 bg-zinc-100 text-zinc-500 rounded"><?= $sv ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($itemPrice > 0): ?>
                                    <p class="text-sm font-bold text-red-500 mt-2">
                                        от <?= number_format($itemPrice, 0, '', ' ') ?> ₽
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination similar-pagination" style="bottom: 0;"></div>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <!-- FAQ: типовые вопросы по металлопрокату -->
        <section class="max-w-7xl mx-auto px-4 py-10" aria-labelledby="faq-title">
            <h2 id="faq-title" class="text-2xl font-bold text-zinc-900 mb-6">Частые вопросы</h2>
            <div class="space-y-4" itemscope itemtype="https://schema.org/FAQPage">
                <?php
                $faqItems = [
                    'Какой ГОСТ распространяется на ' . ($product['name'] ?? 'данную продукцию') . '?' =>
                        'Продукция реализуется в соответствии с действующими ГОСТ и ТУ. Конкретный стандарт указан в карточке товара (характеристика «ГОСТ») или уточняется у менеджера при заказе.',
                    'Осуществляете ли вы резку металлопроката в размер?' =>
                        'Да, КАВ СТАЛЬ выполняет резку металлопроката в размер по требованию заказчика. Детали и стоимость согласовываются с менеджером.',
                    'Какие условия доставки металлопроката по Москве и МО?' =>
                        'Доставка осуществляется по Москве и Московской области. Срок отгрузки — от 0 до 1 рабочего дня, срок транспортировки — до 3 дней. Подробности на странице доставки.',
                    'Какая форма оплаты доступна при заказе?' =>
                        'Оплата производится по безналичному расчёту для юридических и физических лиц. Возможна оплата по счёту с НДС. Детали уточняйте у менеджера.',
                    'Есть ли гарантия на металлопрокат?' =>
                        'На всю продукцию предоставляется гарантия соответствия заявленным характеристикам и ГОСТ. Условия возврата — в течение 14 дней при сохранении товарного вида.'
                ];
                foreach ($faqItems as $q => $a):
                ?>
                <div class="border border-zinc-200 rounded-lg p-4" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h3 class="font-semibold text-zinc-900" itemprop="name"><?= htmlspecialchars($q) ?></h3>
                    <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer">
                        <p class="mt-2 text-zinc-600" itemprop="text"><?= htmlspecialchars($a) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                <?php
                $faqJson = [];
                foreach ($faqItems as $q => $a) {
                    $faqJson[] = [
                        '@type' => 'Question',
                        'name' => $q,
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $a]
                    ];
                }
                echo json_encode($faqJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                ?>
            ]
        }
        </script>
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
                <h3 class="text-lg font-bold text-zinc-900">Купить в 1 клик</h3>
                <button id="closeBuyModal" class="w-8 h-8 rounded-full bg-zinc-100 flex items-center justify-center hover:bg-zinc-200 transition">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="flex items-center gap-3 mb-5 p-3 bg-zinc-50 rounded-xl">
                <img src="<?= htmlspecialchars($product['images'][0] ?? $site['baseUrl'] . '/public/assets/images/unknown/unknown.png') ?>"
                    alt="" class="w-14 h-14 rounded-xl object-contain bg-white border border-zinc-100">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-zinc-900 truncate"><?= htmlspecialchars($product['name'] ?? $product['title']) ?></p>
                    <?php if ($firstPrice > 0): ?>
                    <p class="text-sm font-bold text-red-500 mt-0.5"><?= number_format($firstPrice, 0, '', ' ') ?> ₽ / <?= htmlspecialchars($firstUnit) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <form id="buyOneClickForm" class="space-y-4">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($productID) ?>">
                <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 mb-1">Ваше имя *</label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" placeholder="Иван Иванов">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 mb-1">Телефон *</label>
                    <input type="tel" name="phone" data-type-phone required class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" placeholder="(___) ___-__-__">
                </div>
                <div class="hidden"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>
                <button type="submit" class="w-full bg-red-500 text-white py-3 rounded-xl hover:bg-red-500 transition font-medium text-sm">
                    Оставить запрос
                </button>
                <p class="text-xs text-zinc-400 text-center">Мы перезвоним в течение 15 минут</p>
            </form>
        </div>
    </div>

    <!-- Sticky Mobile Cart Bar -->
    <div class="mobile-sticky-cart lg:hidden" id="mobileStickyCart">
        <div class="flex items-center gap-2">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] text-zinc-400 truncate leading-tight"><?= htmlspecialchars($product['name'] ?? $product['title']) ?></p>
                <p class="text-lg font-bold text-zinc-900 leading-tight">
                    <?php if ($firstPrice > 0): ?>
                        <?= number_format($firstPrice, 0, '', ' ') ?> <span class="text-xs font-normal text-zinc-500">₽/<?= htmlspecialchars($firstUnit) ?></span>
                    <?php else: ?>
                        Цена по запросу
                    <?php endif; ?>
                </p>
            </div>
            <div class="flex items-center border border-zinc-200 rounded-xl overflow-hidden shrink-0">
                <button type="button" class="cart-qty-btn cart-qty-minus w-8 h-9 flex items-center justify-center text-zinc-500 hover:text-red-500 hover:bg-red-50 transition text-sm font-medium" data-product-id="<?= htmlspecialchars($productID) ?>">−</button>
                <input type="number" id="mobile-qty-input" value="1" min="1" aria-label="Количество"
                    class="w-9 h-9 text-center border-x border-zinc-200 text-xs font-medium focus:outline-none"
                    data-product-id="<?= htmlspecialchars($productID) ?>">
                <button type="button" class="cart-qty-btn cart-qty-plus w-8 h-9 flex items-center justify-center text-zinc-500 hover:text-red-500 hover:bg-red-50 transition text-sm font-medium" data-product-id="<?= htmlspecialchars($productID) ?>">+</button>
            </div>
            <button type="button" id="mobile-add-to-cart-btn"
                class="shrink-0 bg-red-500 text-white py-2.5 px-4 rounded-xl hover:bg-red-500 transition font-medium text-xs flex items-center gap-1.5">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                В корзину
            </button>
        </div>
    </div>

    <!-- Swiper Slider JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <script src="/public/assets/scripts/main/header.min.js" defer></script>
    <script src="/public/assets/scripts/components/toggleWindow.min.js" defer></script>
    <script src="/public/assets/scripts/components/share.min.js" defer></script>
    <script src="/public/assets/scripts/components/swiper.min.js" defer></script>

    <script>
    window.__productPrices = <?= json_encode($product['units']) ?>;
    window.__productImages = <?= json_encode($product['images']) ?>;
    </script>
    <script defer src="/public/assets/scripts/main/product.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@27.1.3/dist/js/intlTelInputWithUtils.min.js" defer></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll("[data-type-phone]").forEach(function(input) {
            window.intlTelInput(input, {
                initialCountry: "ru",
                separateDialCode: true,
            });
        });
        document.querySelectorAll('input[data-type-phone]').forEach(function (input) {
            input.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('7') || value.startsWith('8')) {
                    value = value.substring(1);
                }
                value = value.substring(0, 10);
                if (value.length > 0) {
                    let formatted = '';
                    if (value.length >= 1) formatted += '(' + value.substring(0, 3);
                    if (value.length >= 4) formatted += ') ' + value.substring(3, 6);
                    if (value.length >= 7) formatted += '-' + value.substring(6, 8);
                    if (value.length >= 9) formatted += '-' + value.substring(8, 10);
                    e.target.value = formatted;
                } else {
                    e.target.value = '';
                }
                e.target.setCustomValidity('');
            });
            input.addEventListener('blur', function () {
                const digits = this.value.replace(/\D/g, '');
                if (digits.length !== 10) {
                    this.setCustomValidity('Введите полный номер телефона');
                } else {
                    this.setCustomValidity('');
                }
            });
        });
        document.getElementById('buyOneClickForm').addEventListener('submit', function(e){
            const phone = this.querySelector('[data-type-phone]');
            if (phone) {
                const digits = phone.value.replace(/\D/g, '');
                if (digits.length !== 10) {
                    e.preventDefault();
                    phone.setCustomValidity('Введите полный номер телефона');
                    phone.reportValidity();
                    phone.focus();
                }
            }
        });
    });
    </script>

</body>

</html>