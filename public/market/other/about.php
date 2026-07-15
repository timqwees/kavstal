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

    <!-- Schema.org Organization -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "КАВ СТАЛЬ",
        "legalName": "ООО «КАВ Сталь»",
        "url": "<?php echo $site['baseUrl']; ?>/about",
        "logo": "<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg",
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
        "email": "zakaz@kavstal.ru",
        "telephone": "+7 (495) 989-24-20",
        "sameAs": [],
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
                    <a href="/about" class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg transition">О компании</a>
                    <a href="/delivery" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Доставка и оплата</a>
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
                <a href="/about" class="block py-3 px-4 text-red-600 bg-red-50 rounded-lg font-medium">О компании</a>
                <a href="/delivery" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Доставка и оплата</a>
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
                <div class="text-4xl font-bold text-red-600 mb-2">7+</div>
                <div class="text-gray-600">лет на рынке</div>
            </div>
            <div class="bg-white rounded-xl p-6 text-center shadow-md">
                <div class="text-4xl font-bold text-red-600 mb-2">5000+</div>
                <div class="text-gray-600">довольных клиентов</div>
            </div>
            <div class="bg-white rounded-xl p-6 text-center shadow-md">
                <div class="text-4xl font-bold text-red-600 mb-2">500+</div>
                <div class="text-gray-600">наименований металла</div>
            </div>
            <div class="bg-white rounded-xl p-6 text-center shadow-md">
                <div class="text-4xl font-bold text-red-600 mb-2">24ч</div>
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
            <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-2xl p-8 text-white">
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
                                <td class="py-3 text-gray-900">ООО «КАВ Сталь»</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">ИНН</td>
                                <td class="py-3 text-gray-900">9719080724</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">КПП</td>
                                <td class="py-3 text-gray-900">770501001</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">ОГРН</td>
                                <td class="py-3 text-gray-900">1257700303838</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="w-full">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">Расчетный счет</td>
                                <td class="py-3 text-gray-900">40702810500000000000</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">Банк</td>
                                <td class="py-3 text-gray-900">ПАО СБЕРБАНК РОССИИ</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">БИК</td>
                                <td class="py-3 text-gray-900">044525225</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 text-gray-500 font-medium">Корр. счет</td>
                                <td class="py-3 text-gray-900">30101810400000000225</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-center mt-6">
                <p class="text-gray-500">Юридический адрес: 115035, г. Москва, ул. Семёновская площадь, д. 7</p>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center bg-gray-900 rounded-2xl p-8 md:p-12 text-white">
            <h2 class="text-3xl font-bold mb-4">Станьте нашим партнером!</h2>
            <p class="text-lg mb-8 opacity-90">Индивидуальные условия для постоянных клиентов и строительных организаций
            </p>
            <a href="tel:+74959892420"
                class="inline-block bg-red-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-red-700 transition">
                <i class="fas fa-phone mr-2"></i>Связаться с нами
            </a>
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