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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="preload" href="/public/assets/styles/catalog.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="/public/assets/styles/catalog.css"></noscript>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body>
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-red-600 focus:text-white focus:px-4 focus:py-2 focus:rounded-lg">Перейти к основному содержанию</a>

    <!-- ===================== HEADER ===================== -->
    <header class="ozon-header">
        <!-- Row 1: Logo + Каталог + Search + Actions -->
        <div class="ozon-header-main">
            <div class="ozon-header-inner">
                <button class="ozon-burger mobile-menu-toggle" aria-label="Открыть меню">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <a href="/" class="ozon-logo">
                    <img loading="lazy" src="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg" alt="<?= htmlspecialchars($site['company']) ?>">
                </a>
                <button class="ozon-catalog-btn" id="ozonCatalogToggle">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 7.556C4 4.628 4.628 4 7.556 4s3.555.628 3.555 3.556-.627 3.555-3.555 3.555S4 10.484 4 7.556m0 8.888c0-2.928.628-3.555 3.556-3.555s3.555.627 3.555 3.555S10.484 20 7.556 20 4 19.372 4 16.444M16.444 4c-2.928 0-3.555.628-3.555 3.556s.627 3.555 3.555 3.555S20 10.484 20 7.556 19.372 4 16.444 4m-3.555 12.444c0-2.928.627-3.555 3.555-3.555S20 13.516 20 16.444 19.372 20 16.444 20s-3.555-.628-3.555-3.556"/></svg>
                    <span>Каталог</span>
                </button>
                <div class="ozon-search" id="searchWrap">
                    <form method="GET" action="/market" id="searchForm">
                        <input type="text" name="search" id="searchInput" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" placeholder="Искать в каталоге" autocomplete="off">
                        <button type="submit" aria-label="Поиск" class="ozon-search-btn">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.892 15.064a8 8 0 1 0-2.828 2.828l2.522 2.522a2 2 0 1 0 2.828-2.828zM11 16a5 5 0 1 1 0-10 5 5 0 0 1 0 10"/></svg>
                        </button>
                    </form>
                    <div id="searchDropdown" class="absolute left-0 right-0 top-full mt-1 bg-white border border-zinc-200 rounded-xl shadow-xl z-50 hidden overflow-hidden"></div>
                </div>
                <a href="/cart" class="ozon-header-action">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9.925 5.371a1 1 0 1 0-1.858-.742L6.317 9h-1.2c-1.076 0-1.614 0-1.913.346-.3.346-.222.878-.067 1.942l.271 1.864c.475 3.265.902 4.898 2.03 5.873s2.778.975 6.08.975h.96c3.302 0 4.953 0 6.08-.975 1.128-.975 1.559-2.608 2.034-5.873l.271-1.864c.155-1.064.233-1.596-.067-1.942S19.96 9 18.883 9h-1.205l-1.75-4.371a1 1 0 0 0-1.857.742L15.523 9h-7.05zM10.997 14v2a1 1 0 0 1-2 0v-2a1 1 0 0 1 2 0M14 13a1 1 0 0 1 1 1v2a1 1 0 0 1-2 0v-2a1 1 0 0 1 1-1"/></svg>
                    <span class="ozon-cart-badge cart-count-badge" style="display:none;">0</span>
                    <span>Корзина</span>
                </a>
                <a href="/favorites" class="ozon-header-action" id="headerFavBtn">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 10.163C3 7.262 5.13 5 8 5c1.929 0 3.244 1.102 4 2.066C12.756 6.102 14.071 5 16 5c2.87 0 5 2.264 5 5.163 0 4.561-4.568 7.856-8.243 9.66a1.71 1.71 0 0 1-1.514 0C7.568 18.02 3 14.724 3 10.163"/></svg>
                    <span class="ozon-cart-badge" id="favCountBadge" style="display:none;">0</span>
                    <span>Избранное</span>
                </a>
                <a href="/orders" class="ozon-header-action">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14.692 5.694c.368-.205.365-.469-.009-.664C13.367 4.343 12.708 4 12 4s-1.367.343-2.683 1.03l-2 1.044c-1.614.842-2.42 1.263-2.869 2.02C4 8.85 4 9.79 4 11.673v1.652c0 1.883 0 2.824.448 3.58s1.255 1.178 2.869 2.02l2 1.044C10.633 20.657 11.292 21 12 21s1.367-.343 2.683-1.03l2-1.044c1.614-.842 2.42-1.263 2.869-2.02.448-.756.448-1.697.448-3.58v-1.652c0-1.883 0-2.824-.448-3.58-.329-.556-.851-.93-1.744-1.423-.367-.203-.389-.204-.763.004L11 10c-.344.19-.739.394-.91.77-.09.197-.09.375-.09.73V14a1 1 0 0 1-2 0v-4a1 1 0 0 1 .514-.874z"/></svg>
                    <span>Заказы</span>
                </a>
            </div>
        </div>
        <!-- Row 2: Nav links + City -->
        <div class="ozon-header-nav">
            <div class="ozon-header-nav-inner">
                <div class="ozon-header-nav-links">
                    <a href="tel:+74959892420" class="ozon-nav-link ozon-nav-phone">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.36 11.36 0 003.58.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.57 3.58 1 1 0 01-.25 1.01l-2.2 2.2z"/></svg>
                        +7 (495) 989-24-20
                    </a>
                    <span class="ozon-nav-sep"></span>
                    <a href="/delivery" class="ozon-nav-link">Доставка</a>
                    <a href="/services" class="ozon-nav-link">Услуги</a>
                    <a href="/about" class="ozon-nav-link">О компании</a>
                    <a href="/contacts" class="ozon-nav-link">Контакты</a>
                </div>
                <div class="ozon-header-nav-right">
                    <span class="ozon-nav-text">Пн-Пт 9:00–18:00</span>
                    <span class="ozon-nav-dot">·</span>
                    <span class="ozon-nav-text">Москва и МО</span>
                </div>
            </div>
        </div>
        <!-- Mega Menu -->
        <div class="ozon-mega-menu" id="ozonMegaMenu">
            <div class="ozon-mega-menu-inner">
                <div class="ozon-mega-sidebar" id="ozonMegaSidebar">
                    <?php
                    $catList = []; $subList = [];
                    foreach ($products as $p) {
                        $b = $p['badge'] ?? '';
                        if ($b === 'Категория') { $catList[$p['id']] = $p; }
                        elseif ($b === 'Подкатегория') { $pid = $p['categories']['parent_id'] ?? null; if ($pid) $subList[$pid][] = $p; }
                    }
                    foreach ($catList as $cid => $cat):
                    ?>
                    <a href="<?= htmlspecialchars($cat['seo']['canonicalUrl'] ?? '#') ?>" class="ozon-mega-item" data-category-id="<?= htmlspecialchars($cid) ?>">
                        <span><?= htmlspecialchars($cat['title']) ?></span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                    <?php endforeach; ?>
                </div>
                <div class="ozon-mega-content" id="ozonMegaContent">
                    <?php $firstDone = false; foreach ($catList as $cid => $cat): $subcategories = $subList[$cid] ?? []; ?>
                    <div class="ozon-mega-content-panel" data-category-id="<?= htmlspecialchars($cid) ?>" <?= $firstDone ? 'style="display:none;"' : '' ?>>
                        <div class="ozon-mega-content-title"><?= htmlspecialchars($cat['title']) ?></div>
                        <?php if (!empty($subcategories)): ?>
                        <div class="ozon-mega-grid">
                            <?php foreach ($subcategories as $sub):
                                $subImages = $sub['images'] ?? [];
                                $subThumb = !empty($subImages) ? $subImages[0] : '';
                            ?>
                            <a href="<?= htmlspecialchars($sub['seo']['canonicalUrl'] ?? '#') ?>" class="ozon-mega-subcategory">
                                <?php if ($subThumb): ?>
                                <div class="w-12 h-12 rounded-lg overflow-hidden bg-zinc-100 flex-shrink-0">
                                    <img src="<?= htmlspecialchars($subThumb) ?>" alt="<?= htmlspecialchars($sub['title']) ?>" class="w-full h-full object-contain" loading="lazy">
                                </div>
                                <?php endif; ?>
                                <span><?= htmlspecialchars($sub['title']) ?></span>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <div class="ozon-mega-empty">Все товары этой категории</div>
                        <?php endif; ?>
                    </div>
                    <?php $firstDone = true; endforeach; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- ===================== MOBILE MENU ===================== -->
    <div class="mobile-menu-overlay fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden opacity-0 invisible transition-all duration-300"></div>
    <div class="mobile-menu fixed left-0 top-0 h-full w-80 bg-white shadow-xl z-50 lg:hidden transform -translate-x-full transition-transform duration-300">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <a href="/"><img loading="lazy" class="h-10" src="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg" alt="<?= htmlspecialchars($site['company']) ?>"></a>
                <button class="mobile-menu-close p-2" aria-label="Закрыть меню"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <nav class="space-y-1 mb-6">
                <?php
                $mCatList = []; $mSubList = [];
                foreach ($products as $p) { $b = $p['badge'] ?? ''; if ($b === 'Категория') { $mCatList[$p['id']] = $p; } elseif ($b === 'Подкатегория') { $pid = $p['categories']['parent_id'] ?? null; if ($pid) $mSubList[$pid][] = $p; } }
                foreach ($mCatList as $cid => $cat): $hasSub = !empty($mSubList[$cid]);
                ?>
                <div>
                    <a href="<?= htmlspecialchars($cat['seo']['canonicalUrl'] ?? '#') ?>" class="mobile-nav-link"><?= htmlspecialchars($cat['title']) ?><?php if ($hasSub): ?><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg><?php endif; ?></a>
                    <?php if ($hasSub): ?>
                    <div class="ml-3 pl-3 border-l-2 border-red-100 space-y-0.5">
                        <?php foreach ($mSubList[$cid] as $sub): ?>
                        <a href="<?= htmlspecialchars($sub['seo']['canonicalUrl'] ?? '#') ?>" class="mobile-sub-link"><?= htmlspecialchars($sub['title']) ?></a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <div class="border-t border-gray-100 pt-3 mt-3 space-y-1">
                    <a href="/services" class="mobile-nav-link"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg> Услуги</a>
                    <a href="/about" class="mobile-nav-link"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg> О компании</a>
                    <a href="/delivery" class="mobile-nav-link"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg> Доставка и оплата</a>
                    <a href="/contacts" class="mobile-nav-link"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg> Контакты</a>
                </div>
            </nav>
            <div class="border-t pt-4 text-center">
                <a href="tel:+74959892420" class="text-xl font-bold text-gray-800 block mb-1">+7 (495) 989-24-20</a>
                <p class="text-sm text-gray-500">Ежедневно 9:00–18:00</p>
            </div>
        </div>
    </div>

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
                                    <a href="/" class="inline-flex items-center text-sm font-medium text-zinc-500 hover:text-red-600 transition-colors" itemprop="item" itemscope itemtype="https://schema.org/Thing" itemid="<?php echo $site['baseUrl']; ?>/">
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
                            <button id="grid-view" class="flex items-center justify-center rounded-md bg-white text-red-600 p-2 shadow-sm transition-colors" title="Сетка">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z" />
                                </svg>
                            </button>
                            <button id="list-view" class="flex items-center justify-center rounded-md border border-zinc-200 bg-white p-2 text-zinc-600 hover:text-red-600 transition-colors" title="Список">
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
                ksort($filterCategories, SORT_NATURAL | SORT_FLAG_CASE); asort($filterMarkas); asort($filterGosts); ksort($filterSizes, SORT_NATURAL);
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
                                    <a href="<?= htmlspecialchars($url) ?>" class="flex items-center justify-between px-2 py-1.5 rounded-lg text-[13px] transition-colors <?= $isActive ? 'bg-red-50 text-red-700 font-semibold' : 'text-zinc-700 hover:bg-zinc-50' ?>">
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
                                    <button type="submit" class="mt-2 w-full text-[11px] font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg py-1.5 transition-colors">Применить</button>
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
                                    <a href="<?= htmlspecialchars($url) ?>" class="filter-item flex items-center justify-between px-2 py-1 rounded-lg text-xs transition-colors <?= $isActive ? 'bg-red-50 text-red-700 font-semibold' : 'text-zinc-600 hover:bg-zinc-50' ?>" data-text="<?= strtolower(htmlspecialchars($val)) ?>">
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
                                    <a href="<?= htmlspecialchars($url) ?>" class="filter-item flex items-center justify-between px-2 py-1 rounded-lg text-xs transition-colors <?= $isActive ? 'bg-red-50 text-red-700 font-semibold' : 'text-zinc-600 hover:bg-zinc-50' ?>" data-text="<?= strtolower(htmlspecialchars($val)) ?>">
                                        <span><?= htmlspecialchars($val) ?></span>
                                        <span class="text-zinc-400 text-[10px] ml-1 flex-shrink-0"><?= $count ?></span>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>



                            <!-- Сбросить -->
                            <?php if ($activeCategory || $activeMarka || $activeSize || $activePriceFrom !== '' || $activePriceTo !== '' || $searchTerm): ?>
                            <a href="/market" class="block text-center text-xs text-red-600 hover:text-red-700 font-medium py-1.5 rounded-lg hover:bg-red-50 transition-colors border border-red-100">Сбросить все фильтры</a>
                            <?php endif; ?>
                        </div>
                    </aside>

                    <!-- Products Area -->
                    <div class="flex-1 min-w-0">
                    <!-- Products Grid -->
                    <div id="products-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5" itemscope itemtype="https://schema.org/ItemList">
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
                                <a href="<?php echo htmlspecialchars($canonicalUrl); ?>" class="text-[13px] font-semibold text-neutral-800 hover:text-red-600 transition-colors line-clamp-2 leading-snug mb-2 block min-h-[36px]"><?php echo htmlspecialchars($product['name'] ?? $product['title'] ?? 'Товар'); ?></a>
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
                                                <button type="button" class="text-[9px] px-1.5 py-0.5 rounded font-medium transition-all <?= $unit === $firstUnit ? 'bg-red-100 text-red-800' : 'bg-neutral-100 text-neutral-500 hover:bg-red-50 hover:text-red-700' ?>" data-unit="<?php echo htmlspecialchars($unit); ?>" data-price="<?php echo htmlspecialchars($price); ?>" onclick="switchUnit(this)"><?php echo htmlspecialchars($unit); ?></button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <button type="button" class="add-to-cart-btn w-8 h-8 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center shrink-0 transition-colors" data-pid="<?= htmlspecialchars($product['id'] ?? '') ?>" data-unit="<?= htmlspecialchars($firstUnit ?? '') ?>" title="В корзину">
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
                            <a href="/market" class="mt-3 inline-flex items-center text-xs font-medium text-red-600 hover:text-red-700">
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
                        <a href="<?php echo htmlspecialchars($prevUrl); ?>" class="inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white px-2.5 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 hover:text-zinc-700 transition-colors">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/></svg>
                        </a>
                        <?php endif; $range = 2; $showPages = []; $showPages[] = 1; for ($i = max(2, $page - $range); $i <= min($totalPages - 1, $page + $range); $i++) { $showPages[] = $i; } if ($totalPages > 1) $showPages[] = $totalPages; $showPages = array_unique($showPages); sort($showPages); $prevPage = 0; foreach ($showPages as $i): if ($prevPage > 0 && $i > $prevPage + 1): ?>
                        <span class="px-1.5 text-sm text-zinc-400">...</span>
                        <?php endif; $prevPage = $i; $queryParams['page'] = $i; $pageUrl = '/market?' . http_build_query($queryParams); $active = $i === $page; ?>
                        <a href="<?php echo htmlspecialchars($pageUrl); ?>" class="<?= $active ? 'bg-red-600 text-white border-red-600 shadow-sm' : 'border border-zinc-200 bg-white text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900' ?> inline-flex items-center justify-center rounded-lg min-w-[36px] h-9 px-2 text-sm font-medium transition-colors"><?php echo $i; ?></a>
                        <?php endforeach; if ($page < $totalPages): $queryParams['page'] = $page + 1; $nextUrl = '/market?' . http_build_query($queryParams); ?>
                        <a href="<?php echo htmlspecialchars($nextUrl); ?>" class="inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white px-2.5 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 hover:text-zinc-700 transition-colors">
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

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="/public/assets/scripts/components/catalog.js"></script>
    <script>
    $(document).ready(function () { if (typeof window.catalogAPI !== 'undefined') { window.catalogAPI.init(); } });
    </script>
    <script>
    window.switchUnit = function(button) {
        var parent = button.parentElement;
        Array.from(parent.querySelectorAll('button')).forEach(function(b) {
            b.classList.remove('bg-red-100', 'text-red-800');
            b.classList.add('bg-neutral-100', 'text-neutral-500');
        });
        button.classList.remove('bg-neutral-100', 'text-neutral-500');
        button.classList.add('bg-red-100', 'text-red-800');
        var card = button.closest('[itemscope]');
        if (card) { var pd = card.querySelector('.price-display'); if (pd) pd.textContent = Math.round(parseFloat(button.getAttribute('data-price'))).toLocaleString('ru-RU') + ' ₽'; }
    };

    document.addEventListener('DOMContentLoaded', function() {
        var toggle = document.getElementById('ozonCatalogToggle');
        var menu = document.getElementById('ozonMegaMenu');
        var sidebar = document.getElementById('ozonMegaSidebar');
        var panels = document.querySelectorAll('.ozon-mega-content-panel');
        if (toggle && menu) {
            var isOpen = false;
            toggle.addEventListener('click', function(e) { e.stopPropagation(); isOpen = !isOpen; menu.style.display = isOpen ? 'block' : 'none'; });
            document.addEventListener('click', function(e) { if (!menu.contains(e.target) && e.target !== toggle && !toggle.contains(e.target)) { menu.style.display = 'none'; isOpen = false; } });
        }
        if (sidebar) {
            sidebar.querySelectorAll('.ozon-mega-item').forEach(function(item) {
                item.addEventListener('mouseenter', function() {
                    sidebar.querySelectorAll('.ozon-mega-item').forEach(function(i) { i.classList.remove('active'); });
                    this.classList.add('active');
                    var catId = this.getAttribute('data-category-id');
                    panels.forEach(function(p) { p.style.display = p.getAttribute('data-category-id') === catId ? 'block' : 'none'; });
                });
            });
        }

        var gv = document.getElementById('grid-view'), lv = document.getElementById('list-view'), pc = document.getElementById('products-container');
        if (gv && lv && pc) {
            function setActive(btn, other) {
                btn.classList.add('bg-red-600', 'text-white', 'border-red-600', 'shadow-sm');
                btn.classList.remove('border', 'border-zinc-200', 'bg-white', 'text-zinc-600');
                other.classList.remove('bg-red-600', 'text-white', 'border-red-600', 'shadow-sm');
                other.classList.add('border', 'border-zinc-200', 'bg-white', 'text-zinc-600');
            }
            gv.addEventListener('click', function() {
                pc.classList.remove('list-view');
                pc.className = 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5';
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

        var mt = document.querySelector('.mobile-menu-toggle'), mc = document.querySelector('.mobile-menu-close'), mm = document.querySelector('.mobile-menu'), mo = document.querySelector('.mobile-menu-overlay');
        function openM() { if (mm) mm.classList.remove('-translate-x-full'); if (mo) { mo.classList.remove('opacity-0', 'invisible'); mo.classList.add('opacity-100', 'visible'); } document.body.style.overflow = 'hidden'; }
        function closeM() { if (mm) mm.classList.add('-translate-x-full'); if (mo) { mo.classList.add('opacity-0', 'invisible'); mo.classList.remove('opacity-100', 'visible'); } document.body.style.overflow = ''; }
        if (mt) mt.addEventListener('click', openM); if (mc) mc.addEventListener('click', closeM); if (mo) mo.addEventListener('click', closeM);
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeM(); });

        document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var card = this.closest('[itemscope]'), pid = this.getAttribute('data-pid'), unit = this.getAttribute('data-unit'), row = card ? card.querySelector('.hidden-cart-row') : null, qtyInput = row ? row.querySelector('.cart-qty') : null, qty = parseFloat(qtyInput ? qtyInput.value : 1) || 1;
                var wasInCart = btn.classList.contains('in-cart');
                var originalSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>';
                this.disabled = true;
                this.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white animate-spin"><circle cx="12" cy="12" r="10" stroke-dasharray="31.4" stroke-dashoffset="10"/></svg>';
                addToCart(pid, qty, unit).then(function(r) {
                    if (r.success) {
                        btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-white"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
                        btn.classList.add('bg-red-600', 'in-cart');
                        setTimeout(function() { btn.disabled = false; btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>'; }, 1500);
                        updateCartCount();
                    } else {
                        btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-amber-500"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
                        setTimeout(function() { btn.disabled = false; btn.innerHTML = wasInCart ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>' : originalSvg; }, 1500);
                    }
                }).catch(function() {
                    btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-red-400"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
                    setTimeout(function() { btn.disabled = false; btn.innerHTML = wasInCart ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>' : originalSvg; }, 1500);
                });
            });
        });
    });

    function updateCartCount() {
        fetch('/api/cart/count').then(function(r) { return r.json(); }).then(function(d) {
            document.querySelectorAll('.cart-count-badge').forEach(function(el) { el.textContent = d.count > 99 ? '99+' : d.count; el.style.display = d.count > 0 ? 'flex' : 'none'; });
        });
    }
    function addToCart(pid, qty, unit) { var fd = new URLSearchParams(); fd.append('product_id', pid); fd.append('quantity', qty); fd.append('unit', unit); return fetch('/api/cart/add', { method: 'POST', body: fd }).then(function(r) { return r.json(); }); }

    /* Restore cart count + button states on page load */
    updateCartCount();
    fetch('/api/cart/products').then(function(r) { return r.json(); }).then(function(d) {
        var ids = d.products || [];
        if (!ids.length) return;
        document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
            var pid = btn.getAttribute('data-pid');
            if (ids.indexOf(pid) !== -1) {
                btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
                btn.classList.add('bg-red-600', 'in-cart');
            }
        });
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
            dropdown.innerHTML =
                '<div class="flex items-center gap-3 px-4 py-3">' +
                    '<div class="w-5 h-5 border-2 border-red-300 border-t-red-600 rounded-full animate-spin"></div>' +
                    '<span class="text-sm text-zinc-400">Поиск «' + q.replace(/</g,'&lt;') + '»…</span>' +
                '</div>';
            showDD();
        }

        function renderResults(items, q) {
            if (!items.length) {
                dropdown.innerHTML =
                    '<div class="px-4 py-6 text-center">' +
                        '<svg class="w-8 h-8 mx-auto text-zinc-300 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>' +
                        '<div class="text-sm text-zinc-400">Ничего не найдено</div>' +
                        '<div class="text-xs text-zinc-300 mt-1">Попробуйте другой запрос</div>' +
                    '</div>';
                showDD();
                return;
            }
            var html = '<div class="max-h-[360px] overflow-y-auto">';
            items.forEach(function(p, i) {
                var img = p.image
                    ? '<img src="' + p.image.replace(/"/g,'&quot;') + '" class="w-11 h-11 object-contain rounded-lg bg-zinc-50 border border-zinc-100 flex-shrink-0" loading="lazy">'
                    : '<div class="w-11 h-11 rounded-lg bg-zinc-100 flex-shrink-0 flex items-center justify-center"><svg class="w-5 h-5 text-zinc-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z"/></svg></div>';
                var stock = p.in_stock
                    ? '<span class="inline-flex items-center gap-0.5 text-[10px] text-emerald-600 font-medium"><span class="w-1 h-1 rounded-full bg-emerald-500"></span>В наличии</span>'
                    : '<span class="inline-flex items-center gap-0.5 text-[10px] text-zinc-400"><span class="w-1 h-1 rounded-full bg-zinc-300"></span>Под заказ</span>';
                var cat = p.cat ? '<span class="text-[10px] text-zinc-400">' + p.cat.replace(/</g,'&lt;') + '</span>' : '';
                html +=
                    '<a href="' + p.url + '" class="flex items-center gap-3 px-4 py-2.5 hover:bg-red-50/60 transition-all duration-150 group border-b border-zinc-50 last:border-0 search-item" style="animation: searchFadeIn ' + (0.03 * (i + 1)) + 's ease both">' +
                        img +
                        '<div class="flex-1 min-w-0">' +
                            '<div class="text-[13px] text-zinc-800 truncate group-hover:text-red-700 transition-colors leading-snug">' + highlight(p.nameOrig.replace(/</g,'&lt;'), q) + '</div>' +
                            '<div class="flex items-center gap-2 mt-0.5">' +
                                '<span class="text-sm font-bold text-zinc-900">' + p.price + ' ₽</span>' +
                                '<span class="text-[10px] text-zinc-400">/ ' + p.unit + '</span>' +
                                stock +
                            '</div>' +
                            cat +
                        '</div>' +
                        '<svg class="w-4 h-4 text-zinc-300 group-hover:text-red-400 transition-colors flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>' +
                    '</a>';
            });
            html += '</div>';
            html += '<a href="/market?search=' + encodeURIComponent(q) + '" class="flex items-center justify-center gap-2 text-xs text-red-600 hover:text-red-700 font-medium py-2.5 border-t border-zinc-100 hover:bg-red-50/50 transition-colors">' +
                '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6V5.25A2.25 2.25 0 0011.25 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 005.25 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>' +
                'Показать все результаты' +
            '</a>';
            dropdown.innerHTML = html;
            showDD();
        }

        function showDD() {
            dropdown.classList.remove('hidden');
            dropdown.style.maxHeight = '0';
            dropdown.style.opacity = '0';
            requestAnimationFrame(function() {
                dropdown.style.transition = 'max-height 0.25s ease, opacity 0.2s ease';
                dropdown.style.maxHeight = '420px';
                dropdown.style.opacity = '1';
            });
        }

        function hideDD() {
            dropdown.style.transition = 'max-height 0.15s ease, opacity 0.1s ease';
            dropdown.style.maxHeight = '0';
            dropdown.style.opacity = '0';
            setTimeout(function() { dropdown.classList.add('hidden'); }, 160);
        }

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

    /* ===== FAVORITES (localStorage) ===== */
    (function() {
        var STORAGE_KEY = 'kavstal_favorites';
        function getFavs() { try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || []; } catch(e) { return []; } }
        function saveFavs(arr) { localStorage.setItem(STORAGE_KEY, JSON.stringify(arr)); }
        function isFav(pid) { return getFavs().indexOf(pid) !== -1; }

        var favSVG = '<svg width="13" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>';
        var favSVGFilled = '<svg width="13" height="11" viewBox="0 0 24 24" fill="#dc2626" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>';

        function updateCardBtn(btn) {
            var pid = btn.getAttribute('data-pid');
            if (!pid) return;
            btn.innerHTML = isFav(pid) ? favSVGFilled : favSVG;
            if (isFav(pid)) { btn.classList.add('border-red-300', 'bg-red-50'); btn.classList.remove('border-zinc-200'); }
            else { btn.classList.remove('border-red-300', 'bg-red-50'); btn.classList.add('border-zinc-200'); }
        }

        document.querySelectorAll('.add-to-fav-btn').forEach(function(btn) {
            updateCardBtn(btn);
            btn.addEventListener('click', function() {
                var pid = this.getAttribute('data-pid'); if (!pid) return;
                var favs = getFavs(), idx = favs.indexOf(pid);
                if (idx === -1) favs.push(pid); else favs.splice(idx, 1);
                saveFavs(favs);
                updateCardBtn(this);
                updateHeaderFavCount();
            });
        });

        function updateHeaderFavCount() {
            var badge = document.getElementById('favCountBadge');
            if (!badge) return;
            var count = getFavs().length;
            badge.textContent = count > 99 ? '99+' : count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
        updateHeaderFavCount();
    })();
    </script>
    <style>
        @keyframes searchFadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes spin { to { transform: rotate(360deg); } }
        .animate-spin { animation: spin 0.8s linear infinite; }
        * { font-family: "Geist", sans-serif; }
        #searchDropdown { will-change: max-height, opacity; }
    </style>
</body>
</html>