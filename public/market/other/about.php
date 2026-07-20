<?php $site = Setting\route\function\Functions::site(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О компании | КАВ СТАЛЬ - Поставщик металлопроката в Москве</title>
    <meta name="description"
        content="ООО КАВ СТАЛЬ — надежный поставщик металлопроката в Москве и Московской области с 2018 года. Сертификаты ГОСТ, доставка в день заказа, работаем с юр и физ лицами.">

    <meta property="og:title" content="О компании | КАВ СТАЛЬ">
    <meta property="og:description" content="Поставщик металлопроката в Москве и МО">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $site['baseUrl']; ?>/about">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="КАВ СТАЛЬ">
    <meta property="og:locale" content="ru_RU">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="О компании | КАВ СТАЛЬ">
    <meta name="twitter:description" content="Поставщик металлопроката в Москве и МО">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">

    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo $site['baseUrl']; ?>/about">

    <link rel="icon" type="image/png"
        href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml"
        href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon.svg" />

    <!-- Resource Hints -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="<?php echo $site['baseUrl']; ?>" crossorigin>

    <!-- OpenSearch -->
    <link rel="search" type="application/opensearchdescription+xml" title="КАВ СТАЛЬ"
        href="<?php echo $site['baseUrl']; ?>/opensearch.xml" />

    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>

    <!-- Schema.org Organization -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "КАВ СТАЛЬ",
        "legalName": "ООО «КАВ Сталь»",
        "url": "<?php echo $site['baseUrl']; ?>/about",
        "logo": "<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.webp",
        "description": "ООО КАВ СТАЛЬ — надежный поставщик металлопроката в Москве и Московской области с 2018 года",
        "foundingDate": "2018",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "ул. Семёновская площадь, д. 7, офис 412",
            "addressLocality": "Москва",
            "postalCode": "115035",
            "addressCountry": "RU"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+7-495-989-24-20",
            "contactType": "sales",
            "availableLanguage": ["Russian"],
            "areaServed": "RU",
            "hoursAvailable": {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                "opens": "09:00",
                "closes": "18:00"
            }
        },
        "email": "<?= $site['email'] ?>",
        "telephone": "+7 (495) 989-24-20",
        "sameAs": [],
        "areaServed": {
            "@type": "City",
            "name": "Москва и Московская область"
        }
    }
    </script>
  <?php include_once __DIR__ . "/../../components/seo-head.php"; ?>
</head>

<body class="bg-gray-50">

    <?php include_once __DIR__ . '/../../components/header-shared.php'; ?>

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <nav class="flex items-center space-x-2 text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" class="text-gray-600 hover:text-red-500" itemprop="item" itemscope
                        itemtype="https://schema.org/Thing" itemid="<?php echo $site['baseUrl']; ?>/"><i
                            class="fas fa-home"></i>
                        <span itemprop="name">Главная</span></a>
                    <meta itemprop="position" content="1">
                </span>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name" class="text-gray-900 font-medium">О компании</span>
                    <meta itemprop="position" content="2">
                </span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">О компании КАВ СТАЛЬ</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Ведущий поставщик металлопроката в Москве и Московской области.
                Работаем с 2018 года, обеспечиваем качественный сервис и надежные поставки.
            </p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
            <div class="bg-white rounded-xl p-6 text-center shadow-md">
                <div class="text-4xl font-bold text-red-500 mb-2">7+</div>
                <div class="text-gray-600">лет на рынке</div>
            </div>
            <div class="bg-white rounded-xl p-6 text-center shadow-md">
                <div class="text-4xl font-bold text-red-500 mb-2">5000+</div>
                <div class="text-gray-600">довольных клиентов</div>
            </div>
            <div class="bg-white rounded-xl p-6 text-center shadow-md">
                <div class="text-4xl font-bold text-red-500 mb-2">500+</div>
                <div class="text-gray-600">наименований металла</div>
            </div>
            <div class="bg-white rounded-xl p-6 text-center shadow-md">
                <div class="text-4xl font-bold text-red-500 mb-2">24ч</div>
                <div class="text-gray-600">доставка по МО</div>
            </div>
        </div>

        <!-- About Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Кто мы</h2>
                <div class="prose text-gray-600 space-y-4">
                    <p>
                        ООО «КАВ Сталь» — компания полного цикла в сфере металлоторговли.
                        Мы работаем напрямую с ведущими металлургическими заводами России,
                        что позволяет предлагать конкурентные цены на весь ассортимент продукции.
                    </p>
                    <p>
                        Наш склад расположен в Хованской промзоне Москвы, обеспечивая удобную
                        логистику для доставки по всей Московской области. Площадь склада
                        составляет более 5000 м², где постоянно поддерживается наличие
                        металлопроката всех типоразмеров.
                    </p>
                    <p>
                        Мы работаем как с юридическими, так и с физическими лицами.
                        Предоставляем полный пакет документов: сертификаты качества ГОСТ,
                        паспорта на продукцию, счета и акты выполненных работ.
                    </p>
                </div>
            </div>
            <div class="bg-gradient-to-br from-red-500 to-red-500 rounded-2xl p-8 text-white">
                <h3 class="text-2xl font-bold mb-6">Наши преимущества</h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-red-200 mt-1 mr-3"></i>
                        <span>Прямые поставки с заводов-производителей — низкие цены без посредников</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-red-200 mt-1 mr-3"></i>
                        <span>Собственный автопарк — доставка в день заказа по Москве и МО</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-red-200 mt-1 mr-3"></i>
                        <span>Полный комплекс услуг: резка, гибка, сварка, покраска металла</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-red-200 mt-1 mr-3"></i>
                        <span>Работаем с НДС и без НДС — удобная форма оплаты для всех клиентов</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-red-200 mt-1 mr-3"></i>
                        <span>Бесплатная консультация и помощь в расчете сметы</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Requisites -->
        <div class="bg-white rounded-2xl shadow-md p-8 mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Реквизиты компании</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <div>
                    <table class="w-full">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">Полное наименование</td>
                                <td class="py-3 text-gray-900">ООО «КАВ СТАЛЬ»</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">ИНН</td>
                                <td class="py-3 text-gray-900">9719080724</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">КПП</td>
                                <td class="py-3 text-gray-900">771901001</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">ОГРН</td>
                                <td class="py-3 text-gray-900">1257700303838</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">Генеральный директор</td>
                                <td class="py-3 text-gray-900">Кисаков Андрей Валерьевич</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="w-full">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">Расчетный счет</td>
                                <td class="py-3 text-gray-900">40702810610001935104</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">Банк</td>
                                <td class="py-3 text-gray-900">АО «ТБанк»</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">БИК</td>
                                <td class="py-3 text-gray-900">044525974</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">Корр. счет</td>
                                <td class="py-3 text-gray-900">30101810145250000974</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-center mt-6">
                <p class="text-gray-500">Юридический адрес: 105318, г. Москва, пл. Семёновская, д. 7, к. 17, пом. 2/2</p>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center bg-gray-900 rounded-2xl p-8 md:p-12 text-white">
            <h2 class="text-3xl font-bold mb-4">Станьте нашим партнером!</h2>
            <p class="text-lg mb-8 opacity-90">Индивидуальные условия для постоянных клиентов и строительных организаций
            </p>
            <a href="tel:+74959892420"
                class="inline-block bg-red-500 text-white px-8 py-3 rounded-lg font-bold hover:bg-red-500 transition">
                <i class="fas fa-phone mr-2"></i>Связаться с нами
            </a>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>
    <script defer src="/public/assets/scripts/components/cart-favorites.min.js"></script>
</body>

</html>