<?php $site = Setting\route\function\Functions::site(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты | КАВ СТАЛЬ - Свяжитесь с нами</title>
    <meta name="description"
        content="Контакты металлобазы КАВ СТАЛЬ в Москве. Телефон +7 (495) 989-24-20, адрес в Хованской промзоне. Режим работы: Пн-Пт 9:00-18:00, Сб 9:00-15:00.">

    <meta property="og:title" content="Контакты | КАВ СТАЛЬ">
    <meta property="og:description" content="Контактная информация металлобазы КАВ СТАЛЬ">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $site['baseUrl']; ?>/contacts">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="КАВ СТАЛЬ">
    <meta property="og:locale" content="ru_RU">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Контакты | КАВ СТАЛЬ">
    <meta name="twitter:description" content="Контактная информация металлобазы КАВ СТАЛЬ">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">

    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo $site['baseUrl']; ?>/contacts">

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

    <!-- Schema.org Organization with ContactPoints -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "КАВ СТАЛЬ",
        "legalName": "ООО «КАВ Сталь»",
        "url": "<?php echo $site['baseUrl']; ?>",
        "logo": "<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg",
        "description": "Металлобаза КАВ СТАЛЬ — поставщик металлопроката в Москве и Московской области",
        "address": [
            {
                "@type": "PostalAddress",
                "name": "Офис",
                "streetAddress": "ул. Семёновская площадь, д. 7, офис 412",
                "addressLocality": "Москва",
                "postalCode": "115035",
                "addressCountry": "RU"
            },
            {
                "@type": "PostalAddress",
                "name": "Склад",
                "streetAddress": "Хованская промзона, вл. 20",
                "addressLocality": "Москва",
                "addressCountry": "RU"
            }
        ],
        "contactPoint": [
            {
                "@type": "ContactPoint",
                "telephone": "+7-495-989-24-20",
                "contactType": "sales",
                "contactOption": "TollFree",
                "areaServed": "RU",
                "availableLanguage": ["Russian"]
            },
            {
                "@type": "ContactPoint",
                "telephone": "+7-495-989-24-20",
                "contactType": "customer service",
                "areaServed": "RU",
                "availableLanguage": ["Russian"]
            }
        ],
        "email": "zakaz@kavstal.ru",
        "telephone": "+7 (495) 989-24-20",
        "openingHours": ["Mo-Fr 09:00-18:00", "Sa 09:00-15:00"],
        "areaServed": {
            "@type": "City",
            "name": "Москва и Московская область"
        }
    }
    </script>
</head>

<body class="bg-gray-50">

    <?php include_once __DIR__ . '/../../components/header-shared.php'; ?>

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <nav class="flex items-center space-x-2 text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" class="text-gray-600 hover:text-red-600" itemprop="item" itemscope
                        itemtype="https://schema.org/Thing" itemid="<?php echo $site['baseUrl']; ?>/"><i
                            class="fas fa-home"></i>
                        <span itemprop="name">Главная</span></a>
                    <meta itemprop="position" content="1">
                </span>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name" class="text-gray-900 font-medium">Контакты</span>
                    <meta itemprop="position" content="2">
                </span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-12 text-center">Контакты</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div>
                <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Свяжитесь с нами</h2>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-phone-alt text-red-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Телефон</p>
                                <a href="tel:+74959892420"
                                    class="text-xl font-bold text-gray-900 hover:text-red-600 transition">+7 (495)
                                    989-24-20</a>
                                <p class="text-sm text-gray-500 mt-1">Звоните ежедневно с 9:00 до 18:00</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-envelope text-red-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Email</p>
                                <a href="mailto:zakaz@kavstal.ru"
                                    class="text-lg font-medium text-gray-900 hover:text-red-600 transition">zakaz@kavstal.ru</a>
                                <p class="text-sm text-gray-500 mt-1">Для заказов и коммерческих предложений</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-red-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Адрес офиса</p>
                                <p class="text-lg font-medium text-gray-900">г. Москва, ул. Семёновская площадь, д. 7
                                </p>
                                <p class="text-sm text-gray-500 mt-1">БЦ "Семёновский плаза", офис 412</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-warehouse text-red-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Адрес склада</p>
                                <p class="text-lg font-medium text-gray-900">г. Москва, Хованская промзона, вл. 20</p>
                                <p class="text-sm text-gray-500 mt-1">Въезд по пропуску (закажите заранее)</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-clock text-red-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Режим работы</p>
                                <p class="text-lg font-medium text-gray-900">Пн-Пт: 9:00 - 18:00</p>
                                <p class="text-lg font-medium text-gray-900">Сб: 9:00 - 15:00</p>
                                <p class="text-sm text-gray-500 mt-1">Вс: выходной</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="bg-white rounded-2xl shadow-md p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Мы в социальных сетях</h3>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white hover:bg-blue-700 transition">
                            <i class="fab fa-vk text-xl"></i>
                        </a>
                        <a href="#"
                            class="w-12 h-12 bg-blue-400 rounded-lg flex items-center justify-center text-white hover:bg-blue-500 transition">
                            <i class="fab fa-telegram text-xl"></i>
                        </a>
                        <a href="#"
                            class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center text-white hover:bg-green-600 transition">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                        <a href="#"
                            class="w-12 h-12 bg-pink-600 rounded-lg flex items-center justify-center text-white hover:bg-pink-700 transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Map -->
            <div>
                <div class="bg-white rounded-2xl shadow-md overflow-hidden h-full min-h-[500px]">
                    <iframe
                        src="https://yandex.ru/map-widget/v1/?ll=37.6173%2C55.7558&z=15&pt=37.6173%2C55.7558%2Cpm2rdl1"
                        width="100%" height="100%" frameborder="0" allowfullscreen="true"
                        style="min-height: 500px; border: 0;">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Отделы компании</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-shopping-cart text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Отдел продаж</h3>
                    <p class="text-gray-600 mb-4">Прием заказов, расчет стоимости, консультации по ассортименту</p>
                    <a href="tel:+74959892420" class="text-red-600 font-medium hover:underline">+7 (495) 989-24-20 доб.
                        101</a>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-truck text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Отдел логистики</h3>
                    <p class="text-gray-600 mb-4">Доставка, отгрузка, координация транспорта</p>
                    <a href="tel:+74959892420" class="text-red-600 font-medium hover:underline">+7 (495) 989-24-20 доб.
                        102</a>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-calculator text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Бухгалтерия</h3>
                    <p class="text-gray-600 mb-4">Документы, счета, акты, закрывающие документы</p>
                    <a href="tel:+74959892420" class="text-red-600 font-medium hover:underline">+7 (495) 989-24-20 доб.
                        103</a>
                </div>
            </div>
        </div>

        <!-- Feedback Form -->
        <div class="mt-16 bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-8 md:p-12">
            <div class="max-w-2xl mx-auto text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Остались вопросы?</h2>
                <p class="text-lg mb-8 opacity-90">Позвоните нам или напишите — мы ответим в течение 15 минут в рабочее
                    время</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="tel:+74959892420"
                        class="bg-white text-red-600 px-8 py-4 rounded-lg font-bold hover:bg-gray-100 transition flex items-center justify-center">
                        <i class="fas fa-phone mr-3"></i>Позвонить сейчас
                    </a>
                    <a href="mailto:zakaz@kavstal.ru"
                        class="bg-red-700 text-white border-2 border-white px-8 py-4 rounded-lg font-bold hover:bg-red-800 transition flex items-center justify-center">
                        <i class="fas fa-envelope mr-3"></i>Написать письмо
                    </a>
                </div>
            </div>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>
    <script defer src="/public/assets/scripts/components/cart-favorites.min.js"></script>
</body>

</html>