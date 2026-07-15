<?php $site = Setting\route\function\Functions::site(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Купить Металлопрокат / Металлобаза в Москве по выгодным ценам</title>
    <meta name="description"
        content="КАВ СТАЛЬ - металлобаза в Москве. Продажа арматуры А500С, балки, труб, листового проката. Низкие цены за тонну. Доставка по Москве и области. Резка в размер. Сертификаты ГОСТ. Звоните: +7 (495) 989-24-20">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Купить металлопрокат в Москве | КАВ СТАЛЬ - Арматура с Доставкой">
    <meta property="og:description"
        content="Металлобаза КАВ СТАЛЬ в Москве. Продажа арматуры, балки, труб, листового проката по низким ценам. Доставка по Москве и области. Резка в размер. ГОСТ. ☎ +7 (495) 989-24-20">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $site['baseUrl']; ?>">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="КАВ СТАЛЬ">
    <meta property="og:locale" content="ru_RU">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="КАВ СТАЛЬ | Металлобаза - поставки металлопроката">
    <meta name="twitter:description"
        content="Поставки металлопроката по Москве и МО. Арматура, балка, круг, лист и другая продукция. Сертификаты качества ГОСТ.">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">

    <!-- Additional SEO Meta Tags -->
    <meta name="robots" content="index, follow">
    <meta name="author" content="ООО 'КАВ Сталь'">
    <meta name="keywords"
        content="купить арматуру, арматура цена за тонну, металлопрокат с доставкой, металлобаза москва, сортовой прокат, арматура а500с, купить балку, труба металлическая цена, лист стальной, нержавеющий прокат, доставка металлопроката, резка металла, швеллер цена, уголок металлический, круг стальной, полоса стальная, профнастил купить, металлопрокат оптом, цветной металлопрокат, проволока вр-1, КАВ СТАЛЬ">
    <link rel="canonical" href="<?php echo $site['baseUrl']; ?>/">

    <!-- Resource Hints для ускорения загрузки -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="<?php echo $site['baseUrl']; ?>" crossorigin>
    <link rel="dns-prefetch" href="https://yandex.ru">
    <link rel="dns-prefetch" href="https://code.jquery.com">

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
    <meta name="msapplication-TileColor" content="#dc2626" />
    <meta name="msapplication-config" content="<?php echo $site['baseUrl']; ?>/browserconfig.xml" />
    <meta name="theme-color" content="#dc2626" />

    <!-- OpenSearch -->
    <link rel="search" type="application/opensearchdescription+xml" title="КАВ СТАЛЬ"
        href="<?php echo $site['baseUrl']; ?>/opensearch.xml" />

    <!-- RSS -->
    <link rel="alternate" type="application/rss+xml" title="КАВ СТАЛЬ — Металлопрокат в Москве"
        href="<?php echo $site['baseUrl']; ?>/rss.xml" />

    <!-- Аналитика Connected -->

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KPHKLMXW');</script>
    <!-- End Google Tag Manager -->

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KPHKLMXW" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Google tag (gtag.js) GA4 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B3941GLKHC"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-B3941GLKHC');
    </script>


    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () { (m[i].a = m[i].a || []).push(arguments) };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) { if (document.scripts[j].src === r) { return; } }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })(window, document, 'script', 'https://mc.yandex.ru/metrika/tag.js?id=103554843', 'ym');

        ym(103554843, 'init', { ssr: true, webvisor: true, clickmap: true, ecommerce: "dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce: true, trackLinks: true });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/103554843" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

    <!-- Аналитика Connected -->

    <!-- Structured Data JSON-LD -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [{
          "@type": "LocalBusiness",
          "@id": <?php echo json_encode($site['baseUrl'] . '#contact', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
          "name": "КАВ СТАЛЬ",
          "description": "МЕТАЛЛОБАЗА - поставки металлопроката по Москве и МО",
          "url": <?php echo json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
          "telephone": "+7-495-989-24-20",
          "email": "zakaz@kavstal.ru",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Семёновская площадь, 7",
            "addressLocality": "Москва",
            "addressRegion": "Московская область",
            "postalCode": "115035",
            "addressCountry": "RU"
          },
          "geo": {
            "@type": "GeoCoordinates",
            "latitude": "55.7558",
            "longitude": "37.6173"
          },
          "openingHours": "Mo-Su 09:00-18:00",
          "priceRange": "$$",
          "image": <?php echo json_encode($site['baseUrl'] . '/public/assets/images/bgpage/main.jpg', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
          "logo": <?php echo json_encode($site['baseUrl'] . '/public/assets/images/icons/favicon/favicon.svg', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
        },
        {
          "@type": "Store",
          "@id": <?php echo json_encode($site['baseUrl'] . '/market', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
          "name": "КАВ СТАЛЬ - Металлобаза",
          "description": "Интернет-магазин металлопроката",
          "url": <?php echo json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
          "image": <?php echo json_encode($site['baseUrl'] . '/public/assets/images/bgpage/market.png', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
          "telephone": "+7-495-989-24-20",
          "email": "zakaz@kavstal.ru",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Семёновская площадь, 7",
            "addressLocality": "Москва",
            "addressRegion": "Московская область",
            "postalCode": "107023",
            "addressCountry": "RU"
          },
          "openingHours": "Mo-Su 09:00-18:00",
          "priceRange": "₽₽",
          "paymentAccepted": ["Cash", "Credit Card", "Bank Transfer"],
          "currenciesAccepted": "RUB"
        },
        {
          "@type": "WebSite",
          "@id": <?php echo json_encode($site['baseUrl'] . '#website', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
          "url": <?php echo json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
          "name": "КАВ СТАЛЬ",
          "description": "МЕТАЛЛОБАЗА - поставки металлопроката по Москве и МО",
          "potentialAction": {
            "@type": "SearchAction",
            "target": <?php echo json_encode($site['baseUrl'] . '/search?q={search_term_string}', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
            "query": "required name=search_term_string"
          }
        }
      ]
    }
  </script>

    <!-- Swiper - Preload Critical Resources - Предзагрузка критических ресурсов -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    </noscript>

    <!-- Font Awesome - Non-blocking CSS - Неблокирующие стили -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    </noscript>

    <!-- Tailwind/JQuery - Defer JavaScript - Отложенные скрипты -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <!-- Local Styles - Асинхронная загрузка основного файла стилей -->
    <link rel="preload" href="/public/assets/styles/main.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="/public/assets/styles/main.css">
    </noscript>
</head>

<body class="bg-white">
    <!-- Skip to content link for accessibility -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-red-600 focus:text-white focus:px-4 focus:py-2 focus:rounded-lg">
        Перейти к основному содержанию
    </a>

    <?php include_once './public/components/header-shared.php'; ?>

    <!-- Main Content -->
    <main id="main-content" class="py-20 flex flex-col">

        <!-- Breadcrumb Navigation -->
        <nav class="bg-gray-50 border-b" aria-label="Breadcrumb">
            <div class="container mx-auto px-4 py-3">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li>
                        <a href="/" class="hover:text-red-600 transition">
                            <i class="fas fa-home"></i>
                            <span class="sr-only">Главная</span>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-900">Металлобаза КАВ СТАЛЬ</span>
                    </li>
                </ol>
            </div>
        </nav>

        <!-- Breadcrumb Structured Data -->
        <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "Главная",
            "item": <?php echo json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
          },
          {
            "@type": "ListItem",
            "position": 2,
            "name": "Металлобаза КАВ СТАЛЬ",
            "item": <?php echo json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
          }
        ]
      }
    </script>

        <!-- Hero -->
        <section class="relative overflow-hidden bg-gradient-to-br from-gray-50 via-white to-red-50">
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-red-200/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-orange-200/20 rounded-full blur-3xl"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 py-12 lg:py-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8 reveal">
                        <div class="inline-flex items-center gap-2 bg-red-50 text-red-700 px-4 py-2 rounded-full text-sm font-medium border border-red-200/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Металлобаза в Москве
                        </div>
                        <h1 class="text-4xl md:text-6xl font-bold text-gray-900 leading-tight">
                            Поставки
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-orange-500">металлопроката</span>
                            по Москве и МО
                        </h1>
                        <p class="text-lg text-gray-600 leading-relaxed max-w-xl">
                            ООО «КАВ Сталь» — напрямую от производителей. Сертификаты ГОСТ. Собственный склад 10 000+ тонн. Резка в размер, доставка в день оплаты.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="/market"
                                class="group inline-flex items-center justify-center gap-2 bg-gradient-to-r from-red-600 to-orange-500 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:shadow-xl hover:shadow-red-500/25 transition-all duration-300 hover:-translate-y-0.5">
                                Перейти в каталог
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                            <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>"
                                class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 border-2 border-gray-200 px-8 py-4 rounded-xl text-lg font-semibold hover:border-red-200 hover:bg-red-50/50 transition-all duration-300">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                                <?= htmlspecialchars($site['phone']) ?>
                            </a>
                            <?php if (!empty($site['whatsapp'])): ?>
                            <a href="https://wa.me/<?= htmlspecialchars($site['whatsapp']) ?>"
                                target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center justify-center gap-2 bg-green-600 text-white px-6 py-4 rounded-xl text-lg font-semibold hover:bg-green-700 hover:shadow-lg hover:shadow-green-500/25 transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                WhatsApp
                            </a>
                            <?php endif; ?>
                        </div>
                        <div class="flex flex-wrap items-center gap-5 text-sm text-gray-500">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Работаем с НДС</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Сертификаты ГОСТ</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Доставка от 1 дня</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>Самовывоз</span>
                        </div>
                    </div>

                    <div class="reveal" style="transition-delay:0.2s">
                        <div class="bg-white rounded-2xl shadow-2xl shadow-gray-200/50 border border-gray-100 p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-red-500/20">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">Быстрый расчёт</h3>
                                    <p class="text-gray-500 text-sm">Узнайте стоимость за 30 секунд</p>
                                </div>
                            </div>

                            <?php
                            static $_cachedProducts = null;
                            if ($_cachedProducts === null) {
                                $_cachedProducts = Setting\route\function\Functions::listProducts();
                            }

                            $products = [];
                            $seenSubcategories = [];
                            foreach ($_cachedProducts as $product) {
                                if (!isset($product['units']) || empty($product['units'])) continue;
                                $badge = $product['badge'] ?? '';
                                if ($badge === 'Категория' || $badge === 'Подкатегория') continue;
                                $subcatKey = $product['categories']['id'] ?? 'other';
                                if (!isset($seenSubcategories[$subcatKey])) {
                                    $seenSubcategories[$subcatKey] = true;
                                    $products[] = $product;
                                }
                                if (count($products) >= 100) break;
                            }
                            if (count($products) < 10) {
                                $products = [];
                                foreach ($_cachedProducts as $product) {
                                    if (!isset($product['units']) || empty($product['units'])) continue;
                                    $badge = $product['badge'] ?? '';
                                    if ($badge === 'Категория' || $badge === 'Подкатегория') continue;
                                    $products[] = $product;
                                    if (count($products) >= 100) break;
                                }
                            }
                            ?>

                            <form action="/send/both" method="POST" class="space-y-4" id="calculator-form">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Тип металлопроката</label>
                                    <select name="тип_металлопроката" id="product-select"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50"
                                        onchange="updatePriceDisplay()">
                                        <option value="">Выберите тип</option>
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?php echo htmlspecialchars($product['id']); ?>"
                                                data-units='<?php echo json_encode($product['units']); ?>'
                                                data-title="<?php echo htmlspecialchars($product['name'] ?? $product['title']); ?>">
                                                <?php echo htmlspecialchars($product['name'] ?? $product['title']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Количество</label>
                                    <input name="количество" type="number" id="quantity-input"
                                        placeholder="Укажите количество"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50"
                                        oninput="updatePriceDisplay()">
                                </div>
                                <div id="price-display" class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-4 border border-gray-100 hidden">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Цена за единицу:</span>
                                        <span id="unit-price" class="text-lg font-bold text-red-600">0 ₽</span>
                                    </div>
                                    <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-200/50">
                                        <span class="text-sm text-gray-600">Итого:</span>
                                        <span id="total-price" class="text-xl font-bold text-gray-900">0 ₽</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ваш телефон</label>
                                    <input name="телефон" type="tel" placeholder="+7 (___) ___-__-__"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50">
                                </div>
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-red-600 to-orange-500 text-white py-3.5 rounded-xl font-semibold hover:shadow-lg hover:shadow-red-500/25 transition-all duration-300">
                                    Рассчитать стоимость
                                </button>
                                <p class="text-xs text-gray-400 text-center">
                                    Нажимая кнопку, вы соглашаетесь с политикой конфиденциальности
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Каталог -->
        <section id="catalog" class="py-16 lg:py-24 bg-white" itemscope itemtype="https://schema.org/CollectionPage">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-12 reveal">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4" itemprop="name">Каталог металлопроката</h2>
                    <p class="text-lg text-gray-600" itemprop="description">Арматура, балка, труба, лист, уголок, швеллер и более 12 000 наименований в наличии</p>
                </div>

                <script type="application/ld+json">
          {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "КАВ СТАЛЬ - Металлобаза",
            "description": "Интернет-магазин металлопроката с корзиной покупок",
            "url": <?php echo json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
            "mainEntity": {
              "@type": "Store",
              "@id": <?php echo json_encode($site['baseUrl'] . '/market', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
              "name": "КАВ СТАЛЬ",
              "url": <?php echo json_encode($site['baseUrl'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
              "image": <?php echo json_encode($site['baseUrl'] . '/public/assets/images/bgpage/market.png', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
              "telephone": "+7-495-989-24-20",
              "email": "zakaz@kavstal.ru",
              "address": {
                "@type": "PostalAddress",
                "streetAddress": "Семёновская площадь, 7",
                "addressLocality": "Москва",
                "addressRegion": "Московская область",
                "postalCode": "107023",
                "addressCountry": "RU"
              },
              "openingHours": "Mo-Su 09:00-18:00",
              "priceRange": "₽₽",
              "paymentAccepted": ["Cash", "Credit Card", "Bank Transfer"],
              "currenciesAccepted": "RUB",
              "hasOfferCatalog": {
                "@type": "OfferCatalog",
                "name": "Каталог металлопроката",
                "itemListElement": [{
                  "@type": "Offer",
                  "itemOffered": {
                    "@type": "Product",
                    "name": "Арматура",
                    "category": "Металлопрокат"
                  },
                  "price": "45000",
                  "priceCurrency": "RUB",
                  "availability": "https://schema.org/InStock",
                  "seller": {
                    "@type": "Organization",
                    "name": "КАВ СТАЛЬ"
                  }
                }]
              }
            },
            "potentialAction": [{
                "@type": "SearchAction",
                "target": <?php echo json_encode($site['baseUrl'] . '/search?q={search_term_string}', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "query": "required name=search_term_string"
              },
              {
                "@type": "BuyAction",
                "target": <?php echo json_encode($site['baseUrl'] . '/cart', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                "object": {
                  "@type": "Product",
                  "name": "Металлопрокат"
                }
              }
            ]
          }
        </script>

                <div class="swiper slider-type-0 pb-12 reveal">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                <?php
                                $slideCount = 0;
                                foreach (Setting\route\function\Functions::getRandomProducts(20) as $product):
                                    if ($slideCount >= 8) break;
                                    $slideCount++;
                                ?>
                                <a href="<?= htmlspecialchars($product['url']) ?>"
                                    class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-red-200 hover:shadow-lg hover:shadow-red-100/50 transition-all duration-300"
                                    itemscope itemtype="https://schema.org/Product">
                                    <div class="w-12 h-12 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center mb-4 group-hover:from-red-100 group-hover:to-orange-100 transition-all duration-300">
                                        <i class="fas <?= $product['icon'] ?> text-red-600 text-xl"></i>
                                    </div>
                                    <h3 class="font-semibold text-gray-900 mb-1.5 group-hover:text-red-600 transition-colors" itemprop="name"><?= htmlspecialchars($product['name']) ?></h3>
                                    <p class="text-xs text-gray-500 mb-4 line-clamp-2" itemprop="description"><?= htmlspecialchars($product['title']) ?></p>
                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                        <span class="text-sm font-bold text-red-600" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                            <meta itemprop="price" content="<?= $product['price'] ?>">
                                            <meta itemprop="priceCurrency" content="RUB">
                                            <meta itemprop="availability" content="<?= $product['availability'] ?>">
                                            <?= $product['priceDisplay'] ?>
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-xs <?= $product['inStock'] ? 'text-green-700 bg-green-50' : 'text-orange-700 bg-orange-50' ?> px-2 py-0.5 rounded-full font-medium"><?= $product['stockText'] ?></span>
                                    </div>
                                </a>
                                <?php if ($slideCount == 4): ?>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                <?php endif; endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <div class="text-center reveal">
                    <a href="/market"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-orange-500 text-white px-8 py-3.5 rounded-xl font-semibold hover:shadow-xl hover:shadow-red-500/25 transition-all duration-300 hover:-translate-y-0.5">
                        Смотреть весь ассортимент
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Преимущества -->
        <section class="py-16 lg:py-24 bg-gradient-to-b from-gray-50 to-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-12 reveal">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Почему выбирают КАВ СТАЛЬ</h2>
                    <p class="text-lg text-gray-600">12 000+ наименований, собственный склад, резка в размер и доставка в день оплаты</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-red-100 hover:shadow-xl hover:shadow-red-100/20 transition-all duration-300 reveal">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Менеджер 24/7</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Поможет решить любой вопрос вне зависимости от времени суток</p>
                    </div>
                    <div class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-red-100 hover:shadow-xl hover:shadow-red-100/20 transition-all duration-300 reveal" style="transition-delay:0.1s">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.16a15.53 15.53 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Фото перед отгрузкой</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Предоставляем фото и видео продукции для подтверждения качества</p>
                    </div>
                    <div class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-red-100 hover:shadow-xl hover:shadow-red-100/20 transition-all duration-300 reveal" style="transition-delay:0.2s">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Доставка в день оплаты</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Возможна доставка в день оплаты по договорённости с менеджером</p>
                    </div>
                    <div class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-red-100 hover:shadow-xl hover:shadow-red-100/20 transition-all duration-300 reveal" style="transition-delay:0.3s">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Счёт за 20 минут</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Выставим счёт до 15 позиций всего за 20 минут</p>
                    </div>
                    <div class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-red-100 hover:shadow-xl hover:shadow-red-100/20 transition-all duration-300 reveal" style="transition-delay:0.1s">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Сертификаты ГОСТ</h5>
                        <p class="text-sm text-gray-500 leading-relaxed">Вся продукция соответствует ГОСТ и ТУ. Проверка на заводе-изготовителе</p>
                    </div>
                    <div class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-red-100 hover:shadow-xl hover:shadow-red-100/20 transition-all duration-300 reveal" style="transition-delay:0.2s">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Комплексные поставки</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">12 000+ наименований. Закрываем потребности клиента комплексно</p>
                    </div>
                    <div class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-red-100 hover:shadow-xl hover:shadow-red-100/20 transition-all duration-300 reveal" style="transition-delay:0.3s">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Экономия</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Предложим дешёвую альтернативу без ущерба качеству</p>
                    </div>
                    <div class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-red-100 hover:shadow-xl hover:shadow-red-100/20 transition-all duration-300 reveal" style="transition-delay:0.4s">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.72 15.75a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v-.75A.75.75 0 019 14.25h.75a.75.75 0 01.75.75v.75zM12 15.75a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75v-.75a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75zM14.25 15.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75zM9.72 12.75a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75V12a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75zM12 12.75a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75V12a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75zM14.25 12.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75V12a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75zM9.72 9.75a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75V9a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75zM12 9.75a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75V9a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75zM14.25 9.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75V9a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75z"/></svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Резка в размер</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Отрежем нужную длину — не переплачивайте за остаток</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Калькулятор -->
        <section id="calculator" class="py-16 lg:py-24 bg-gradient-to-b from-gray-50 to-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-12 reveal">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Калькулятор металлопроката</h2>
                    <p class="text-lg text-gray-600">Рассчитайте стоимость заказа онлайн с учётом доставки и скидки</p>
                </div>

                <?php
                if (!isset($_cachedProducts) || $_cachedProducts === null) {
                    $_cachedProducts = Setting\route\function\Functions::listProducts();
                }

                $calcProducts = [];
                $seenSubcats = [];
                foreach ($_cachedProducts as $product) {
                    if (!isset($product['units']) || empty($product['units'])) continue;
                    $badge = $product['badge'] ?? '';
                    if ($badge === 'Категория' || $badge === 'Подкатегория') continue;
                    $subcatKey = $product['categories']['id'] ?? 'other';
                    if (!isset($seenSubcats[$subcatKey])) {
                        $seenSubcats[$subcatKey] = true;
                        $calcProducts[] = $product;
                    }
                    if (count($calcProducts) >= 100) break;
                }
                ?>

                <div class="max-w-4xl mx-auto reveal">
                    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 p-8">
                        <form method="POST" action="/send/both" id="metalCalculator" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Тип металлопроката</label>
                                    <div class="relative">
                                        <select name="тип_металлопроката" id="metalType"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50 appearance-none"
                                            onchange="updateCalculatorUnits()">
                                            <option value="">Выберите тип</option>
                                            <?php foreach ($calcProducts as $product): ?>
                                                <option value="<?php echo htmlspecialchars($product['id']); ?>"
                                                    data-units='<?php echo json_encode($product['units']); ?>'
                                                    data-title="<?php echo htmlspecialchars($product['name'] ?? $product['title']); ?>">
                                                    <?php echo htmlspecialchars($product['name'] ?? $product['title']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-red-500 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Единица измерения</label>
                                    <select name="единица_измерения" id="unitSelect"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50"
                                        onchange="calculateMetal()">
                                        <option value="">Сначала выберите тип</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Количество</label>
                                    <div class="relative">
                                        <input name="количество" type="number" id="quantity" min="0.1" step="0.1" placeholder="Укажите количество"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50"
                                            oninput="calculateMetal()">
                                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-red-500 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Доставка</label>
                                    <select name="доставка" id="delivery"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50"
                                        onchange="calculateMetal()">
                                        <option value="0">Самовывоз</option>
                                        <option value="5000">По Москве (в пределах МКАД)</option>
                                        <option value="8000">Московская область (до 50 км)</option>
                                        <option value="15000">Дальняя доставка (от 50 км)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Скидка (опт)</label>
                                    <select name="скидка" id="discount"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50"
                                        onchange="calculateMetal()">
                                        <option value="0">Нет скидки</option>
                                        <option value="3">От 10 тонн (3%)</option>
                                        <option value="5">От 50 тонн (5%)</option>
                                        <option value="7">От 100 тонн (7%)</option>
                                        <option value="10">От 500 тонн (10%)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ваш телефон</label>
                                    <div class="relative">
                                        <input name="телефон" type="tel" placeholder="+7 (___) ___-__-__"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50">
                                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-red-500 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 border border-gray-100">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Стоимость металла</p>
                                        <p class="text-2xl font-bold text-gray-900" id="metalCost">0 ₽</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Доставка</p>
                                        <p class="text-2xl font-bold text-gray-900" id="deliveryCost">0 ₽</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Итого со скидкой</p>
                                        <p class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-orange-500" id="totalCost">0 ₽</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4">
                                <button type="button" onclick="calculateMetal()"
                                    class="flex-1 bg-gradient-to-r from-red-600 to-orange-500 text-white py-3.5 rounded-xl font-semibold hover:shadow-xl hover:shadow-red-500/25 transition-all duration-300 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    Рассчитать
                                </button>
                                <button type="submit"
                                    class="flex-1 bg-gray-900 text-white py-3.5 rounded-xl font-semibold hover:bg-gray-800 transition-all duration-300 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Оформить заказ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Цены -->
        <section id="prices" class="py-16 lg:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-12 reveal">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Прайс-лист на металлопрокат</h2>
                    <p class="text-lg text-gray-600">Актуальные цены на популярные позиции. Цены за тонну с НДС.</p>
                </div>

                <div class="max-w-6xl mx-auto reveal">
                    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gradient-to-r from-red-600 to-orange-500 text-white">
                                        <th class="px-6 py-4 text-left font-semibold">Наименование</th>
                                        <th class="px-6 py-4 text-center font-semibold">Размеры</th>
                                        <th class="px-6 py-4 text-center font-semibold">ГОСТ</th>
                                        <th class="px-6 py-4 text-right font-semibold">Цена за тонну</th>
                                        <th class="px-6 py-4 text-center font-semibold">Наличие</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php
                                    $priceRows = [
                                        ['Арматура А500С', 'Ø10-Ø40 мм', '52544-2006', '45 000 ₽', true],
                                        ['Балка двутавровая', '№10-№30', '8239-89', '52 000 ₽', true],
                                        ['Швеллер', '№5-№30', '8240-97', '48 000 ₽', true],
                                        ['Уголок равнополочный', '25×25–200×200 мм', '8509-93', '46 000 ₽', false],
                                        ['Труба профильная', '20×20–400×200 мм', '30245-2003', '58 000 ₽', true],
                                        ['Лист горячекатаный', '1.5–20 мм', '19903-2015', '51 000 ₽', true],
                                        ['Сетка сварная', '50×50×4–200×200×6', '23279-85', '42 000 ₽', true],
                                        ['Проволока ВР-1', 'Ø3–Ø6 мм', '6727-80', '44 000 ₽', true],
                                    ];
                                    foreach ($priceRows as $row):
                                    ?>
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900"><?= $row[0] ?></td>
                                        <td class="px-6 py-4 text-center text-gray-600"><?= $row[1] ?></td>
                                        <td class="px-6 py-4 text-center text-gray-500 text-sm"><?= $row[2] ?></td>
                                        <td class="px-6 py-4 text-right font-bold text-red-600"><?= $row[3] ?></td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold <?= $row[4] ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700' ?>">
                                                <span class="w-1.5 h-1.5 rounded-full <?= $row[4] ? 'bg-green-500' : 'bg-yellow-500' ?>"></span>
                                                <?= $row[4] ? 'В наличии' : 'Под заказ' ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-100">
                            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                                <p class="text-sm text-gray-500">
                                    <svg class="inline w-4 h-4 mr-1 text-gray-400 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Цены действуют при заказе от 1 тонны. Возможна индивидуальная скидка.
                                </p>
                                <a href="/market" class="inline-flex items-center gap-2 bg-red-600 text-white px-6 py-2.5 rounded-xl hover:bg-red-700 transition text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h1.5l3 6.5L5 12.5l-1.5 3h15.75L21 10.5H6.75L9 6.5"/></svg>
                                    Все цены в каталоге
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- О компании -->
        <section id="about" class="py-16 lg:py-24 bg-gradient-to-b from-white to-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <div class="reveal">
                        <div class="inline-flex items-center gap-2 bg-red-50 text-red-700 px-4 py-2 rounded-full text-sm font-medium border border-red-200/50 mb-6">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            О компании
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">ООО «КАВ Сталь» — металлобаза в Москве</h2>
                        <div class="space-y-4 text-gray-600 leading-relaxed">
                            <p>ООО «КАВ Сталь» (ИНН 9719080724) — поставщик металлопроката по Москве и Московской области. Работаем напрямую с заводами-производителями, обеспечиваем сертификаты качества ГОСТ на всю продукцию.</p>
                            <p>Поставляем арматуру, балку, трубы, листовой прокат и сопутствующие товары. Резка металла в размер, доставка на объект в день оплаты. Работаем с юридическими и физическими лицами.</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-8">
                            <div class="flex items-center gap-3 bg-white rounded-xl p-4 border border-gray-100">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-50 to-orange-50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                </div>
                                <div><p class="font-semibold text-gray-900 text-sm">Прямые цены</p><p class="text-xs text-gray-500">от производителей</p></div>
                            </div>
                            <div class="flex items-center gap-3 bg-white rounded-xl p-4 border border-gray-100">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-50 to-orange-50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div><p class="font-semibold text-gray-900 text-sm">ГОСТ</p><p class="text-xs text-gray-500">сертификаты качества</p></div>
                            </div>
                            <div class="flex items-center gap-3 bg-white rounded-xl p-4 border border-gray-100">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-50 to-orange-50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                                </div>
                                <div><p class="font-semibold text-gray-900 text-sm">Доставка</p><p class="text-xs text-gray-500">в день оплаты</p></div>
                            </div>
                            <div class="flex items-center gap-3 bg-white rounded-xl p-4 border border-gray-100">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-50 to-orange-50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.72 15.75a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v-.75A.75.75 0 019 14.25h.75a.75.75 0 01.75.75v.75z"/></svg>
                                </div>
                                <div><p class="font-semibold text-gray-900 text-sm">Резка</p><p class="text-xs text-gray-500">в размер</p></div>
                            </div>
                        </div>
                    </div>
                    <div class="reveal" style="transition-delay:0.2s">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-gray-200/50 border border-gray-100">
                            <iframe loading="lazy" src="https://yandex.ru/map-widget/v1/?um=constructor%3A26fac0f930c91c623aafe2f3757b7adc63f0e9f8625105edda0659e463840e3e&source=constructor" width="100%" height="450" frameborder="0"></iframe>
                            <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-md text-gray-900 px-5 py-3 rounded-xl shadow-xl border border-white/20">
                                <p class="font-bold text-sm">Наш офис</p>
                                <p class="text-xs text-gray-600">г. Москва, Семёновская площадь, 7</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Услуги -->
        <section id="services" class="py-16 lg:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-12 reveal">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Услуги</h2>
                    <p class="text-lg text-gray-600">Доставка, резка, гибка и дополнительная обработка металлопроката</p>
                </div>

                <div class="swiper slider-type-1 reveal">
                    <div class="swiper-wrapper">
                        <?php
                        $services = [
                            ['Дорожная доставка', 'Доставка металлопроката автотранспортом', 'dostavka.MP4'],
                            ['Ж/Д доставка', 'Доставка железнодорожным транспортом по всей России', 'dostavkaKD.MP4'],
                            ['Гибка металла', 'Точная гибка листового металла до 12 мм', 'gibkametalla.MP4'],
                            ['Горячее цинкование', 'Защита металлоконструкций от коррозии до 50 лет', 'gorachiethinkirovanie.MP4'],
                            ['Изоляция труб', 'Тепловая и гидроизоляция труб для трубопроводов', 'izolatiatrub.MP4'],
                            ['Лазерная резка', 'Высокоточная резка металла до 25 мм', 'lazer.MP4'],
                            ['Ленточнопильный станок', 'Резка металлопроката с точностью до 0.5 мм', 'lentochnopilnik.MP4'],
                            ['Плазменная резка', 'Резка толстого металла до 150 мм', 'plazma.MP4'],
                            ['Ручная резка', 'Индивидуальная резка металла по размерам заказчика', 'ruchnairezka.MP4'],
                        ];
                        foreach ($services as $svc):
                        ?>
                        <div class="swiper-slide">
                            <div class="relative group rounded-2xl overflow-hidden">
                                <video loading="lazy" autoplay loop muted playsinline
                                    src="<?= $site['baseUrl'] ?>/public/assets/images/services/vides/<?= $svc[2] ?>"
                                    class="w-full h-80 object-cover"></video>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end">
                                    <div class="p-6 text-white">
                                        <h3 class="text-xl font-bold mb-1"><?= $svc[0] ?></h3>
                                        <p class="text-sm text-white/80 mb-4"><?= $svc[1] ?></p>
                                        <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>"
                                            class="inline-flex items-center gap-2 bg-red-600 text-white px-5 py-2 rounded-xl text-sm font-medium hover:bg-red-700 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                                            Позвонить
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <div class="text-center mt-10 reveal">
                    <a href="/services"
                        class="inline-flex items-center gap-2 bg-gray-900 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-gray-800 transition-all duration-300">
                        Все услуги
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Контакты -->
        <section id="contacts" class="py-16 lg:py-24 bg-gradient-to-b from-gray-50 to-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-12 reveal">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Контакты</h2>
                    <p class="text-lg text-gray-600">Свяжитесь с нами любым удобным способом</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    <div class="reveal">
                        <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 p-8 h-full">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Информация для связи</h3>
                            <div class="space-y-5">
                                <div class="flex items-start gap-4">
                                    <div class="w-11 h-11 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">Адрес</p>
                                        <p class="text-gray-600 text-sm"><?= htmlspecialchars($site['address'] ?? 'г. Москва, ул. Семёновская площадь, дом 7') ?></p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="w-11 h-11 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">Телефон</p>
                                        <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="text-gray-600 text-sm hover:text-red-600 transition font-medium"><?= htmlspecialchars($site['phone']) ?></a>
                                        <p class="text-xs text-gray-400"><?= htmlspecialchars($site['workingHours'] ?? 'Пн-Пт: 09:00-18:00') ?></p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="w-11 h-11 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">Email</p>
                                        <a href="mailto:<?= htmlspecialchars($site['email'] ?? 'zakaz@kavstal.ru') ?>" class="text-gray-600 text-sm hover:text-red-600 transition"><?= htmlspecialchars($site['email'] ?? 'zakaz@kavstal.ru') ?></a>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="w-11 h-11 bg-gradient-to-br from-red-50 to-orange-50 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">Режим работы</p>
                                        <p class="text-gray-600 text-sm">Отдел продаж: <?= htmlspecialchars($site['workingHours'] ?? 'Пн-Пт: 09:00-18:00') ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <div class="flex items-center gap-3">
                                    <?php if (!empty($site['whatsapp'])): ?>
                                    <a href="https://wa.me/<?= htmlspecialchars($site['whatsapp']) ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-green-500 hover:bg-green-600 rounded-xl flex items-center justify-center text-white transition-all" aria-label="WhatsApp">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (!empty($site['telegram'])): ?>
                                    <a href="https://t.me/<?= htmlspecialchars($site['telegram']) ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-blue-500 hover:bg-blue-600 rounded-xl flex items-center justify-center text-white transition-all" aria-label="Telegram">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.162c-.18 1.896-.955 6.497-1.35 8.618-.166.9-.495 1.202-.81 1.23-.69.063-1.213-.456-1.88-.894-1.056-.695-1.653-1.128-2.678-1.807-1.185-.786-.417-1.217.258-1.922.177-.185 3.242-2.973 3.302-3.227.008-.032.015-.152-.058-.215-.072-.063-.18-.042-.258-.025-.11.024-1.863 1.184-5.258 3.475-.498.342-.95.508-1.354.5-.446-.01-1.302-.252-1.94-.46-.78-.254-1.4-.39-1.346-.823.028-.227.342-.46.94-.698 3.688-1.607 6.147-2.665 7.378-3.174 3.514-1.458 4.244-1.71 4.72-1.718.105-.003.338.024.49.146.127.102.162.24.18.337.015.097.034.318.02.49z"/></svg>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (!empty($site['vk'])): ?>
                                    <a href="https://vk.com/<?= htmlspecialchars($site['vk']) ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-blue-700 hover:bg-blue-800 rounded-xl flex items-center justify-center text-white transition-all" aria-label="VK">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M15.684 0H8.316C2.778 0 0 2.778 0 8.316v7.368C0 21.222 2.778 24 8.316 24h7.368C21.222 24 24 21.222 24 15.684V8.316C24 2.778 21.222 0 15.684 0zm3.6 11.262h-2.064c-.276 0-.42.18-.474.408-.384 1.338-1.458 2.562-2.562 2.562-.6 0-.792-.384-.792-.924v-2.634h-2.4v2.868c0 .786.264 1.338 1.212 1.338 1.416 0 2.478-1.788 2.97-3.018.072-.192.048-.306-.162-.306h-1.104c-.252 0-.36.138-.48.408-.306.852-1.17 2.124-1.596 1.614-.426-.51-.102-1.446-.102-1.446V9.738h1.404c.3 0 .396.21.396.534v1.032c.78-1.032 1.332-1.506 2.04-1.506.606 0 .756.48.756 1.086 0 .414-.144.81-.498 1.392-.186.306-.54.456-.798.456-.336 0-.57-.18-.456-.42.084-.246.27-.528.27-.858 0-.522-.282-.756-.672-.756-.558 0-1.218.936-1.218 1.728 0 .456.198.762.678.852.114.018.228.03.348.03 1.044 0 2.082-1.002 2.472-1.8.468-.96.588-2.004.588-2.118 0-.012.012-.03.024-.03h3.228v.03c0 .264-.06.528-.564.528z"/></svg>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="reveal" style="transition-delay:0.2s">
                        <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 p-8 h-full">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Отправить заявку</h3>
                            <form action="/send/both" method="POST" id="contactForm" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ваше имя *</label>
                                        <input type="text" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Компания</label>
                                        <input type="text"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Телефон *</label>
                                    <input type="tel" required placeholder="+7 (___) ___-__-__"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" placeholder="email@example.com"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Сообщение</label>
                                    <textarea rows="4" placeholder="Опишите вашу потребность..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50/50"></textarea>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" id="agree" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <label for="agree" class="text-sm text-gray-500">Согласен с <a href="#" class="text-red-600 hover:underline">политикой конфиденциальности</a></label>
                                </div>
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-red-600 to-orange-500 text-white py-3.5 rounded-xl font-semibold hover:shadow-lg hover:shadow-red-500/25 transition-all duration-300 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Отправить заявку
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Отзывы / Яндекс -->
        <section class="py-16 lg:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <div class="reveal" style="transition-delay:0.2s">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-gray-200/50 border border-gray-100" itemscope itemtype="https://schema.org/LocalBusiness">
                            <meta itemprop="name" content="KavStal">
                            <meta itemprop="description" content="Поставщик металлопроката и арматуры в Москве">
                            <meta itemprop="telephone" content="+7-495-989-24-20">
                            <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                                <meta itemprop="streetAddress" content="Семёновская площадь, 7">
                                <meta itemprop="addressLocality" content="Москва">
                                <meta itemprop="addressRegion" content="Московская область">
                                <meta itemprop="postalCode" content="115035">
                                <meta itemprop="addressCountry" content="Россия">
                            </div>
                            <iframe loading="lazy" src="https://yandex.ru/maps-reviews-widget/77064597089?comments" width="100%" height="450" frameborder="0" title="Карта с отзывами компании KavStal"></iframe>
                            <div class="absolute bottom-4 left-4 bg-black/80 text-white px-4 py-3 rounded-xl shadow-2xl backdrop-blur-md border border-white/10">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-yellow-400">★★★★★</span>
                                    <span class="font-semibold text-sm">Присоединяйтесь к довольным клиентам</span>
                                </div>
                                <p class="text-white/80 text-xs">Ваш отзыв поможет другим выбрать надёжного поставщика</p>
                            </div>
                            <a href="https://yandex.com/maps/org/kav_stal/77064597089/" target="_blank" rel="noopener noreferrer"
                                class="absolute bottom-4 right-4 bg-white text-gray-900 px-4 py-3 rounded-xl shadow-xl hover:scale-105 transition-all duration-300 text-sm font-semibold border border-gray-200">
                                Смотреть все →
                            </a>
                        </div>
                    </div>
                    <div class="reveal">
                        <div class="inline-flex items-center gap-2 bg-red-50 text-red-700 px-4 py-2 rounded-full text-sm font-medium border border-red-200/50 mb-6">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            Отзывы
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Нас рекомендуют на Яндекс Картах</h2>
                        <p class="text-lg text-gray-600 mb-6">Присоединяйтесь к сотням довольных клиентов. Оставьте отзыв о нашей работе — это помогает нам становиться лучше.</p>
                        <a href="https://yandex.com/maps/org/kav_stal/77064597089/" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 bg-yellow-400 text-gray-900 px-6 py-3 rounded-xl font-semibold hover:bg-yellow-300 transition-all duration-300">
                            <span>★★★★★</span>
                            Оставить отзыв
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include_once './public/components/footer.php'; ?>

    <!-- Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <!-- Local Scripts -->
    <script src="/public/assets/scripts/components/swiper.js" defer></script>
    <script src="/public/assets/scripts/components/lazyIMG.js" defer></script>
    <script src="/public/assets/scripts/components/faq.js" defer></script>
    <script src="/public/assets/scripts/components/calculator.js" defer></script>

    <!-- Scroll Reveal + micro-interactions -->
    <script defer>
    document.addEventListener('DOMContentLoaded', function() {
        const revealElements = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const delay = entry.target.style.getPropertyValue('transition-delay') || '0s';
                    entry.target.style.setProperty('--tw-delay', delay);
                    entry.target.classList.add('reveal-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        revealElements.forEach(el => observer.observe(el));

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    });
    </script>

    <!-- Reveal CSS -->
    <style>
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .reveal.reveal-visible {
        opacity: 1;
        transform: translateY(0);
        transition-delay: var(--tw-delay, 0s);
    }
    html {
        scroll-behavior: smooth;
    }
    </style>

</body>

</html>