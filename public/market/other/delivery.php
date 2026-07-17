<?php $site = Setting\route\function\Functions::site(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доставка и оплата | КАВ СТАЛЬ - Условия доставки металлопроката</title>
    <meta name="description"
        content="Доставка металлопроката по Москве и Московской области. Собственный автопарк, доставка в день заказа. Оплата наличными, картой, безналичный расчет с НДС.">

    <meta property="og:title" content="Доставка и оплата | КАВ СТАЛЬ">
    <meta property="og:description" content="Условия доставки и способы оплаты металлопроката">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $site['baseUrl']; ?>/delivery">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="КАВ СТАЛЬ">
    <meta property="og:locale" content="ru_RU">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Доставка и оплата | КАВ СТАЛЬ">
    <meta name="twitter:description" content="Условия доставки и способы оплаты металлопроката">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">

    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo $site['baseUrl']; ?>/delivery">

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

    <!-- Schema.org Delivery Charges -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Offer",
        "name": "Доставка металлопроката",
        "description": "Доставка металлопроката по Москве и Московской области. Собственный автопарк, доставка в день заказа.",
        "url": "<?php echo $site['baseUrl']; ?>/delivery",
        "provider": {
            "@type": "Organization",
            "name": "КАВ СТАЛЬ",
            "telephone": "+7 (495) 989-24-20"
        },
        "areaServed": {
            "@type": "City",
            "name": "Москва и Московская область"
        },
        "eligibleRegion": {
            "@type": "Country",
            "name": "RU"
        },
        "priceSpecification": [
            {
                "@type": "PriceSpecification",
                "name": "Газель (до 1.5т) — Москва (МКАД)",
                "price": "1500",
                "priceCurrency": "RUB"
            },
            {
                "@type": "PriceSpecification",
                "name": "Бортовой (до 5т) — Москва (МКАД)",
                "price": "3500",
                "priceCurrency": "RUB"
            },
            {
                "@type": "PriceSpecification",
                "name": "Манипулятор (до 10т) — Москва (МКАД)",
                "price": "8000",
                "priceCurrency": "RUB"
            }
        ],
        "availableChannel": {
            "@type": "ServiceChannel",
            "serviceType": "Доставка металлопроката"
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
                    <a href="/" class="text-gray-600 hover:text-red-500" itemprop="item" itemscope
                        itemtype="https://schema.org/Thing" itemid="<?php echo $site['baseUrl']; ?>/"><i
                            class="fas fa-home"></i>
                        <span itemprop="name">Главная</span></a>
                    <meta itemprop="position" content="1">
                </span>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name" class="text-gray-900 font-medium">Доставка и оплата</span>
                    <meta itemprop="position" content="2">
                </span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-12 text-center">Доставка и оплата</h1>

        <!-- Delivery Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Условия доставки</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-red-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Доставка в день заказа</h3>
                    <p class="text-gray-600">При заказе до 14:00 доставка выполняется в тот же день по Москве и ближнему
                        Подмосковью</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marked-alt text-red-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">По всей Московской области</h3>
                    <p class="text-gray-600">Доставляем металлопрокат в любую точку Московской области — от 1 часа до 24
                        часов</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-weight-hanging text-red-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Любой объем</h3>
                    <p class="text-gray-600">От нескольких арматурин до 20 тонн — у нас есть техника для любых задач</p>
                </div>
            </div>

            <!-- Transport Types -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-12">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900">Наш автопарк</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <i class="fas fa-truck-pickup text-red-500 text-3xl mb-3"></i>
                            <h4 class="font-bold text-gray-900 mb-2">Газель</h4>
                            <p class="text-sm text-gray-600 mb-2">До 1.5 тонн, 3-4 м длина</p>
                            <p class="text-lg font-bold text-red-500">от 1 500 ₽</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <i class="fas fa-truck text-red-500 text-3xl mb-3"></i>
                            <h4 class="font-bold text-gray-900 mb-2">Бортовой</h4>
                            <p class="text-sm text-gray-600 mb-2">До 5 тонн, 6 м длина</p>
                            <p class="text-lg font-bold text-red-500">от 3 500 ₽</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <i class="fas fa-truck-moving text-red-500 text-3xl mb-3"></i>
                            <h4 class="font-bold text-gray-900 mb-2">Манипулятор</h4>
                            <p class="text-sm text-gray-600 mb-2">До 10 тонн, разгрузка</p>
                            <p class="text-lg font-bold text-red-500">от 8 000 ₽</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <i class="fas fa-shipping-fast text-red-500 text-3xl mb-3"></i>
                            <h4 class="font-bold text-gray-900 mb-2">Фура</h4>
                            <p class="text-sm text-gray-600 mb-2">До 20 тонн, 13.6 м</p>
                            <p class="text-lg font-bold text-red-500">от 15 000 ₽</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Prices -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Стоимость доставки</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-red-200">
                                <th class="text-left py-3 px-4 font-bold text-gray-900">Зона</th>
                                <th class="text-left py-3 px-4 font-bold text-gray-900">Газель (до 1.5т)</th>
                                <th class="text-left py-3 px-4 font-bold text-gray-900">Бортовой (до 5т)</th>
                                <th class="text-left py-3 px-4 font-bold text-gray-900">Манипулятор (до 10т)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="py-3 px-4 text-gray-700">Москва (в пределах МКАД)</td>
                                <td class="py-3 px-4 text-gray-900 font-medium">1 500 ₽</td>
                                <td class="py-3 px-4 text-gray-900 font-medium">3 500 ₽</td>
                                <td class="py-3 px-4 text-gray-900 font-medium">8 000 ₽</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">До 10 км от МКАД</td>
                                <td class="py-3 px-4 text-gray-900 font-medium">2 000 ₽</td>
                                <td class="py-3 px-4 text-gray-900 font-medium">4 500 ₽</td>
                                <td class="py-3 px-4 text-gray-900 font-medium">10 000 ₽</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">10-30 км от МКАД</td>
                                <td class="py-3 px-4 text-gray-900 font-medium">2 500 ₽</td>
                                <td class="py-3 px-4 text-gray-900 font-medium">5 500 ₽</td>
                                <td class="py-3 px-4 text-gray-900 font-medium">12 000 ₽</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 text-gray-700">30-50 км от МКАД</td>
                                <td class="py-3 px-4 text-gray-900 font-medium">3 000 ₽</td>
                                <td class="py-3 px-4 text-gray-900 font-medium">6 500 ₽</td>
                                <td class="py-3 px-4 text-gray-900 font-medium">15 000 ₽</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-sm text-gray-500 mt-4">* Точная стоимость рассчитывается индивидуально в зависимости от
                    адреса и объема</p>
            </div>
        </div>

        <!-- Payment Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Способы оплаты</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Наличные</h3>
                    <p class="text-gray-600">Оплата наличными при получении товара на складе или водителю при доставке.
                        Выдаем все необходимые документы.</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-credit-card text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Банковская карта</h3>
                    <p class="text-gray-600">Оплата картой Visa, Mastercard, МИР на складе или через терминал у водителя
                        при доставке.</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-file-invoice text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Безналичный расчет</h3>
                    <p class="text-gray-600">Оплата по счету для юридических лиц. Работаем с НДС и без НДС. Отсрочка
                        платежа для постоянных клиентов.</p>
                </div>
            </div>
        </div>

        <!-- Self Pickup -->
        <div class="bg-white rounded-2xl shadow-md p-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-6 md:mb-0 md:mr-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Самовывоз со склада</h3>
                    <p class="text-gray-600 mb-4">Заберите заказ самостоятельно со склада в Хованской промзоне.
                        Бесплатно, без очередей.</p>
                    <ul class="space-y-2 text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Адрес: Москва, Хованская промзона, вл. 20
                        </li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Часы работы: Пн-Пт 9:00-18:00, Сб 9:00-15:00
                        </li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Погрузка краном или вилочным погрузчиком
                        </li>
                    </ul>
                </div>
                <a href="/contacts"
                    class="bg-red-500 text-white px-8 py-3 rounded-lg font-bold hover:bg-red-500 transition whitespace-nowrap">
                    Схема проезда
                </a>
            </div>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>
    <script defer src="/public/assets/scripts/components/cart-favorites.min.js"></script>
</body>

</html>