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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
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
    </style>

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
                <a href="/" class="flex items-center flex-shrink-0">
                    <img loading="lazy" class="h-10 lg:h-12"
                        src="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg"
                        alt="<?= htmlspecialchars($site['company']) ?>">
                </a>
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="/market" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Каталог</a>
                    <a href="/services" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Услуги</a>
                    <a href="/about" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">О компании</a>
                    <a href="/delivery" class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg transition">Доставка и оплата</a>
                    <a href="/guarantees" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Гарантии</a>
                    <a href="/contacts" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Контакты</a>
                </div>
                <div class="hidden lg:flex items-center space-x-4">
                    <a href="/cart" class="relative p-2 text-gray-700 hover:text-red-600 transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="cart-count-badge absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1">0</span>
                    </a>
                    <div class="text-right">
                        <a href="tel:+74959892420"
                            class="text-lg font-bold text-gray-900 hover:text-red-600 transition whitespace-nowrap">
                            +7 (495) 989-24-20
                        </a>
                        <p class="text-xs text-gray-500">Пн-Пт 9:00-18:00</p>
                    </div>
                    <a href="tel:+74959892420"
                        class="bg-red-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-red-700 transition flex items-center gap-2">
                        <i class="fas fa-phone-alt"></i>
                        <span class="hidden xl:inline">Заказать звонок</span>
                    </a>
                </div>
                <div class="lg:hidden flex items-center gap-3">
                    <a href="/cart" class="relative text-gray-700 p-2">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span class="cart-count-badge absolute -top-0.5 -right-0.5 bg-red-600 text-white text-[10px] font-bold rounded-full min-w-[16px] h-[16px] flex items-center justify-center px-0.5">0</span>
                    </a>
                    <a href="tel:+74959892420" class="text-gray-700 p-2">
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
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay fixed inset-0 bg-black/50 z-40 lg:hidden">
        <div class="absolute right-0 top-0 h-full w-72 bg-white shadow-xl p-6">
            <button class="mobile-menu-overlay-close text-gray-500 hover:text-gray-700 mb-6">
                <i class="fas fa-times text-xl"></i>
            </button>
            <nav class="space-y-2">
                <a href="/market" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Каталог</a>
                <a href="/services" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Услуги</a>
                <a href="/about" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">О компании</a>
                <a href="/delivery" class="block py-3 px-4 text-red-600 bg-red-50 rounded-lg font-medium">Доставка и оплата</a>
                <a href="/guarantees" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Гарантии</a>
                <a href="/contacts" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Контакты</a>
                <div class="border-t border-gray-200 my-4"></div>
                <a href="tel:+74959892420" class="flex items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">
                    <i class="fas fa-phone-alt mr-3 text-red-600"></i>
                    +7 (495) 989-24-20
                </a>
            </nav>
        </div>
    </div>
    <script>
    document.querySelector('.mobile-menu-toggle')?.addEventListener('click', function() {
        document.querySelector('.mobile-menu-overlay')?.classList.toggle('active');
    });
    document.querySelector('.mobile-menu-overlay-close')?.addEventListener('click', function() {
        document.querySelector('.mobile-menu-overlay')?.classList.remove('active');
    });
    document.querySelector('.mobile-menu-overlay')?.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
        }
    });
    </script>

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
                        <i class="fas fa-truck text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Доставка в день заказа</h3>
                    <p class="text-gray-600">При заказе до 14:00 доставка выполняется в тот же день по Москве и ближнему
                        Подмосковью</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marked-alt text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">По всей Московской области</h3>
                    <p class="text-gray-600">Доставляем металлопрокат в любую точку Московской области — от 1 часа до 24
                        часов</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-weight-hanging text-red-600 text-2xl"></i>
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
                            <i class="fas fa-truck-pickup text-red-600 text-3xl mb-3"></i>
                            <h4 class="font-bold text-gray-900 mb-2">Газель</h4>
                            <p class="text-sm text-gray-600 mb-2">До 1.5 тонн, 3-4 м длина</p>
                            <p class="text-lg font-bold text-red-600">от 1 500 ₽</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <i class="fas fa-truck text-red-600 text-3xl mb-3"></i>
                            <h4 class="font-bold text-gray-900 mb-2">Бортовой</h4>
                            <p class="text-sm text-gray-600 mb-2">До 5 тонн, 6 м длина</p>
                            <p class="text-lg font-bold text-red-600">от 3 500 ₽</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <i class="fas fa-truck-moving text-red-600 text-3xl mb-3"></i>
                            <h4 class="font-bold text-gray-900 mb-2">Манипулятор</h4>
                            <p class="text-sm text-gray-600 mb-2">До 10 тонн, разгрузка</p>
                            <p class="text-lg font-bold text-red-600">от 8 000 ₽</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <i class="fas fa-shipping-fast text-red-600 text-3xl mb-3"></i>
                            <h4 class="font-bold text-gray-900 mb-2">Фура</h4>
                            <p class="text-sm text-gray-600 mb-2">До 20 тонн, 13.6 м</p>
                            <p class="text-lg font-bold text-red-600">от 15 000 ₽</p>
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
                    class="bg-red-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-red-700 transition whitespace-nowrap">
                    Схема проезда
                </a>
            </div>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>
    <script>
    function updateCartCount() {
        fetch('/api/cart/count').then(r => r.json()).then(d => {
            document.querySelectorAll('.cart-count-badge').forEach(el => {
                el.textContent = d.count > 99 ? '99+' : d.count;
                el.style.display = d.count > 0 ? 'flex' : 'none';
            });
        });
    }
    document.addEventListener('DOMContentLoaded', updateCartCount);
    </script>
</body>

</html>