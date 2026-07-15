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
                    <a href="/delivery" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Доставка и оплата</a>
                    <a href="/guarantees" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Гарантии</a>
                    <a href="/contacts" class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg transition">Контакты</a>
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
                <a href="/delivery" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Доставка и оплата</a>
                <a href="/guarantees" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Гарантии</a>
                <a href="/contacts" class="block py-3 px-4 text-red-600 bg-red-50 rounded-lg font-medium">Контакты</a>
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