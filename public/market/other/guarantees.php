<?php $site = Setting\route\function\Functions::site(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гарантии | КАВ СТАЛЬ - Качество металлопроката</title>
    <meta name="description"
        content="Гарантии качества металлопроката от КАВ СТАЛЬ. Сертификаты ГОСТ, возврат брака, соответствие заявленным характеристикам. Честные цены и прозрачные условия.">

    <meta property="og:title" content="Гарантии | КАВ СТАЛЬ">
    <meta property="og:description" content="Гарантии качества металлопроката">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $site['baseUrl']; ?>/guarantees">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="КАВ СТАЛЬ">
    <meta property="og:locale" content="ru_RU">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Гарантии | КАВ СТАЛЬ">
    <meta name="twitter:description" content="Гарантии качества металлопроката">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">

    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo $site['baseUrl']; ?>/guarantees">

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

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>

    <!-- Schema.org Organization with Warranty -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "КАВ СТАЛЬ",
        "legalName": "ООО «КАВ Сталь»",
        "url": "<?php echo $site['baseUrl']; ?>/guarantees",
        "logo": "<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg",
        "description": "Гарантии качества металлопроката от КАВ СТАЛЬ. Сертификаты ГОСТ, возврат брака, соответствие заявленным характеристикам.",
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Гарантии и условия",
            "itemListElement": [
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "Сертификаты ГОСТ",
                        "description": "На всю продукцию предоставляем сертификаты качества и паспорта"
                    }
                },
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "Возврат брака",
                        "description": "Обмен или возврат некачественного товара в течение 14 дней"
                    }
                },
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "Точный вес",
                        "description": "Весы калибруются ежегодно. Вес соответствует документам"
                    }
                },
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "Фиксация цен",
                        "description": "Цены фиксируются на момент заказа, не меняем после отгрузки"
                    }
                }
            ]
        },
        "telephone": "+7 (495) 989-24-20",
        "email": "zakaz@kavstal.ru"
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
                    <span itemprop="name" class="text-gray-900 font-medium">Гарантии</span>
                    <meta itemprop="position" content="2">
                </span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4 text-center">Наши гарантии</h1>
        <p class="text-xl text-gray-600 text-center mb-12 max-w-3xl mx-auto">
            Мы дорожим репутацией и гарантируем качество продукции, соответствие ГОСТ и честные условия работы
        </p>

        <!-- Main Guarantees -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-certificate text-red-500 text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Сертификаты ГОСТ</h3>
                <p class="text-gray-600 text-sm">На всю продукцию предоставляем сертификаты качества и паспорта</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-undo text-red-500 text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Возврат брака</h3>
                <p class="text-gray-600 text-sm">Обмен или возврат некачественного товара в течение 14 дней</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-balance-scale text-red-500 text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Точный вес</h3>
                <p class="text-gray-600 text-sm">Весы калибруются ежегодно. Вес соответствует документам</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-red-500 text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Фиксация цен</h3>
                <p class="text-gray-600 text-sm">Цены фиксируются на момент заказа, не меняем после отгрузки</p>
            </div>
        </div>

        <!-- Quality Control -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-16">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Контроль качества</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl font-bold text-green-600">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Приемка на склад</h3>
                        <p class="text-gray-600">Каждая партия металла проверяется на соответствие ГОСТ, проводится
                            входной контроль качества</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl font-bold text-green-600">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Хранение</h3>
                        <p class="text-gray-600">Склад оборудован для правильного хранения металлопроката — защита от
                            коррозии и механических повреждений</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl font-bold text-green-600">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Отгрузка</h3>
                        <p class="text-gray-600">Перед отгрузкой каждая позиция проверяется менеджером на соответствие
                            заказу</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
            <div class="bg-white rounded-xl shadow-md p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-file-alt text-red-500 mr-3"></i>Документы на продукцию
                </h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <div>
                            <span class="font-medium text-gray-900">Сертификат качества ГОСТ</span>
                            <p class="text-sm text-gray-500">Подтверждает соответствие продукции государственным
                                стандартам</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <div>
                            <span class="font-medium text-gray-900">Паспорт на продукцию</span>
                            <p class="text-sm text-gray-500">Содержит технические характеристики, химический состав,
                                марку стали</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <div>
                            <span class="font-medium text-gray-900">Упаковочный лист</span>
                            <p class="text-sm text-gray-500">Перечень всех позиций с весом и количеством в отгрузке</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="bg-gradient-to-br from-red-500 to-red-500 rounded-xl p-8 text-white">
                <h3 class="text-2xl font-bold mb-6">
                    <i class="fas fa-shield-alt mr-3"></i>Гарантийные обязательства
                </h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-check text-red-200 mt-1 mr-3"></i>
                        <span>Гарантируем соответствие металла заявленным характеристикам и ГОСТ</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-red-200 mt-1 mr-3"></i>
                        <span>При обнаружении брака — бесплатная замена или возврат денег</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-red-200 mt-1 mr-3"></i>
                        <span>Соответствие заявленного веса фактическому — ±3% допустимое отклонение</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-red-200 mt-1 mr-3"></i>
                        <span>Срок рассмотрения рекламации — до 3 рабочих дней</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Return Policy -->
        <div class="bg-gray-100 rounded-2xl p-8 mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Условия возврата</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Возврат возможен если:</h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Обнаружен
                            заводской брак (трещины, расслоения, коррозия)</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Несоответствие
                            марки стали заявленной</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Неверные
                            геометрические размеры</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Ошибка в
                            комплектации заказа</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Порядок возврата:</h3>
                    <ol class="space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <span
                                class="bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-sm mr-3 flex-shrink-0">1</span>
                            <span>Свяжитесь с менеджером по телефону или почте</span>
                        </li>
                        <li class="flex items-start">
                            <span
                                class="bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-sm mr-3 flex-shrink-0">2</span>
                            <span>Предоставьте фото/видео подтверждающие дефект</span>
                        </li>
                        <li class="flex items-start">
                            <span
                                class="bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-sm mr-3 flex-shrink-0">3</span>
                            <span>Рассмотрение заявки в течение 3 дней</span>
                        </li>
                        <li class="flex items-start">
                            <span
                                class="bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-sm mr-3 flex-shrink-0">4</span>
                            <span>Замена товара или возврат денег</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center bg-gradient-to-r from-red-500 to-red-500 rounded-2xl p-8 md:p-12 text-white">
            <h2 class="text-3xl font-bold mb-4">Остались вопросы?</h2>
            <p class="text-lg mb-8 opacity-90">Наши специалисты ответят на все вопросы о качестве продукции и гарантиях
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="tel:+74959892420"
                    class="bg-white text-red-500 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
                    <i class="fas fa-phone mr-2"></i>+7 (495) 989-24-20
                </a>
                <a href="mailto:zakaz@kavstal.ru"
                    class="bg-red-500 text-white border-2 border-white px-8 py-3 rounded-lg font-bold hover:bg-red-500 transition">
                    <i class="fas fa-envelope mr-2"></i>Написать нам
                </a>
            </div>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>
    <script defer src="/public/assets/scripts/components/cart-favorites.min.js"></script>
</body>

</html>