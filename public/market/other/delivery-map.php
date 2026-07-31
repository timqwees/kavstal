<?php $site = Setting\route\function\Functions::site(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Карта отгрузок металлопроката по всей России | КАВ СТАЛЬ</title>
    <meta name="description"
        content="Карта отгрузок металлопроката КАВ СТАЛЬ: доставка по Москве, Санкт-Петербургу, Казани, Екатеринбургу, Новосибирску и во все города России — более 100 городов. Сроки и стоимость рассчитываются индивидуально.">

    <meta property="og:title" content="Карта отгрузок металлопроката по всей России | КАВ СТАЛЬ">
    <meta property="og:description"
        content="Доставляем металлопрокат в более чем 100 городов России: от Москвы до Владивостока.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $site['baseUrl']; ?>/delivery-map">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="КАВ СТАЛЬ">
    <meta property="og:locale" content="ru_RU">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Карта отгрузок металлопроката по всей России | КАВ СТАЛЬ">
    <meta name="twitter:description"
        content="Доставляем металлопрокат в более чем 100 городов России: от Москвы до Владивостока.">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">

    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo $site['baseUrl']; ?>/delivery-map">

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
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    </noscript>

    <style>
        .mb-10 { margin-bottom: 2.5rem; }
        .mb-14 { margin-bottom: 3.5rem; }
        .p-10 { padding: 2.5rem; }
        .gap-2\.5 { gap: 0.625rem; }
        .mr-1\.5 { margin-right: 0.375rem; }
        .space-y-10 > * + * { margin-top: 2.5rem; }
        .text-red-100 { color: #fee2e2; }
        .border-white\/70 { border-color: rgba(255, 255, 255, 0.7); }
        .hover\:bg-white\/10:hover { background-color: rgba(255, 255, 255, 0.1); }
        @media (min-width: 640px) {
            .sm\:flex-row { flex-direction: row; }
        }
        @media (min-width: 768px) {
            .md\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .md\:p-8 { padding: 2rem; }
            .md\:text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
            .md\:text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
        }
    </style>

    <?php
    $districts = [
        'Центральный федеральный округ' => [
            'Москва', 'Калуга', 'Тула', 'Рязань', 'Тверь', 'Ярославль', 'Владимир', 'Иваново',
            'Кострома', 'Смоленск', 'Брянск', 'Орёл', 'Курск', 'Белгород', 'Воронеж', 'Липецк', 'Тамбов'
        ],
        'Северо-Западный федеральный округ' => [
            'Санкт-Петербург', 'Мурманск', 'Архангельск', 'Северодвинск', 'Петрозаводск',
            'Вологда', 'Череповец', 'Псков', 'Великий Новгород', 'Калининград'
        ],
        'Южный федеральный округ' => [
            'Волгоград', 'Астрахань', 'Ростов-на-Дону', 'Краснодар', 'Сочи', 'Симферополь', 'Севастополь'
        ],
        'Северо-Кавказский федеральный округ' => [
            'Ставрополь', 'Пятигорск', 'Махачкала', 'Владикавказ', 'Грозный', 'Нальчик', 'Черкесск'
        ],
        'Приволжский федеральный округ' => [
            'Пенза', 'Саранск', 'Нижний Новгород', 'Киров', 'Чебоксары', 'Йошкар-Ола', 'Казань',
            'Ульяновск', 'Самара', 'Тольятти', 'Саратов', 'Энгельс', 'Уфа', 'Стерлитамак',
            'Оренбург', 'Пермь', 'Ижевск'
        ],
        'Уральский федеральный округ' => [
            'Екатеринбург', 'Нижний Тагил', 'Челябинск', 'Магнитогорск', 'Курган', 'Тюмень',
            'Сургут', 'Нижневартовск', 'Ханты-Мансийск', 'Салехард'
        ],
        'Сибирский федеральный округ' => [
            'Омск', 'Новосибирск', 'Барнаул', 'Бийск', 'Томск', 'Кемерово', 'Новокузнецк',
            'Красноярск', 'Абакан', 'Кызыл', 'Иркутск', 'Ангарск', 'Братск', 'Улан-Удэ', 'Чита'
        ],
        'Дальневосточный федеральный округ' => [
            'Якутск', 'Благовещенск', 'Биробиджан', 'Хабаровск', 'Комсомольск-на-Амуре',
            'Владивосток', 'Находка', 'Южно-Сахалинск', 'Петропавловск-Камчатский', 'Магадан'
        ],
        'Новые регионы' => [
            'Донецк', 'Луганск', 'Мариуполь', 'Мелитополь', 'Бердянск', 'Геническ', 'Скадовск'
        ],
    ];
    $allCities = [];
    foreach ($districts as $district => $cities) {
        foreach ($cities as $city) {
            $allCities[] = $city;
        }
    }
    $cityCount = count($allCities);
    ?>

    <!-- Schema.org Service + areaServed -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Service",
        "name": "Доставка металлопроката по всей России",
        "serviceType": "Доставка металлопроката",
        "description": "Отгрузка металлопроката в более чем <?= $cityCount ?> городов России: арматура, балка, швеллер, уголок, труба, лист и другие виды проката.",
        "url": "<?php echo $site['baseUrl']; ?>/delivery-map",
        "provider": {
            "@type": "Organization",
            "name": "КАВ СТАЛЬ",
            "telephone": "+7 (495) 989-24-20",
            "url": "<?php echo $site['baseUrl']; ?>"
        },
        "areaServed": [
            <?php
            $cityJson = [];
            foreach ($allCities as $city) {
                $cityJson[] = '{"@type":"City","name":"' . htmlspecialchars($city, ENT_XML1, 'UTF-8') . '"}';
            }
            echo implode(",\n            ", $cityJson);
            ?>
        ]
    }
    </script>

    <!-- FAQ schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            {
                "@type": "Question",
                "name": "В какие города России вы отгружаете металлопрокат?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Мы отгружаем металлопрокат более чем в 100 городов России, включая Москву, Санкт-Петербург, Казань, Екатеринбург, Новосибирск, Краснодар, Владивосток и все региональные центры страны."
                }
            },
            {
                "@type": "Question",
                "name": "Как рассчитывается стоимость доставки металлопроката в регионы?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Стоимость доставки рассчитывается индивидуально: зависит от веса и габаритов груза, города назначения и выбранного транспорта. Точную стоимость менеджер подтверждает после оформления заказа."
                }
            },
            {
                "@type": "Question",
                "name": "Есть ли доставка металлопроката в день заказа?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Да, по Москве и Московской области возможна срочная доставка в день заказа при заказе в первой половине дня. В другие города срок доставки уточняет менеджер."
                }
            }
        ]
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
                    <a href="/delivery" class="text-gray-600 hover:text-red-500" itemprop="item" itemscope
                        itemtype="https://schema.org/Thing" itemid="<?php echo $site['baseUrl']; ?>/delivery"><span
                            itemprop="name">Доставка и оплата</span></a>
                    <meta itemprop="position" content="2">
                </span>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name" class="text-gray-900 font-medium">Карта отгрузок</span>
                    <meta itemprop="position" content="3">
                </span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="inline-block bg-red-50 text-red-500 text-xs font-semibold px-3 py-1 rounded-full mb-3">География
                поставок</span>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Карта отгрузок металлопроката по всей России
            </h1>
            <p class="text-gray-600 text-lg">Отгружаем металлопрокат в <strong><?= $cityCount ?></strong> городов
                России — от Калининграда до Владивостока. Доставка организуется собственным и партнёрским транспортом
                под характеристики каждого заказа.</p>
        </div>

        <!-- Map -->
        <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm mb-14" style="height:480px;">
            <iframe
                src="https://yandex.ru/map-widget/v1/?um=constructor%3A5d7f9c69d82be5cfae8e60fc3a09dca546e89e06c8c576248c668b43aba603ae&amp;source=constructor"
                width="100%" height="680" frameborder="0" loading="lazy"></iframe>
        </div>

        <!-- Geo clusters: cities by federal district -->
        <div class="mb-16">
            <h2 class="section-title mb-3 text-center">Доставка металлопроката в города
                России</h2>
            <p class="text-gray-600 text-center max-w-3xl mx-auto mb-10">Выберите ваш город — рассчитаем доставку
                арматуры, балки, швеллера, уголка, трубы и листа в течение нескольких минут. Отгружаем в
                <?= $cityCount ?> городов по всей стране.</p>

            <div class="space-y-10">
                <?php foreach ($districts as $district => $cities): ?>
                    <section class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">
                        <h3 class="section-title mb-5 flex items-center gap-2" style="font-size:24px;line-height:30px;"><i
                                class="fas fa-map-marked-alt text-red-500"></i>Доставка металлопроката — <?= htmlspecialchars($district) ?>
                        </h3>
                        <div class="flex flex-wrap gap-2.5">
                            <?php foreach ($cities as $city): ?>
                                <a href="/delivery" title="Доставка металлопроката в <?= htmlspecialchars($city) ?>"
                                    class="inline-flex items-center px-4 py-2 rounded-full border border-gray-200 bg-gray-50 text-sm text-gray-700 hover:border-red-300 hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <i class="fas fa-location-dot text-red-400 text-xs mr-1.5"></i><?= htmlspecialchars($city) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- How delivery works -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-14">
            <div class="p-6 border-b border-gray-200">
                <h2 class="section-title">Как организована отгрузка в регионы</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clipboard-list text-red-500 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Оформление заказа</h3>
                    <p class="text-gray-600 text-sm">Оставьте заявку с указанием города — менеджер подтвердит наличие
                        позиций и рассчитает точную стоимость отгрузки.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-red-500 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Подбор транспорта</h3>
                    <p class="text-gray-600 text-sm">Газель, борт, длинномер или манипулятор — транспорт подбирается под
                        вес, длину и способ погрузки.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-box-open text-red-500 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Отгрузка и получение</h3>
                    <p class="text-gray-600 text-sm">Отгружаем со склада, передаём документы и обеспечиваем выгрузку в
                        вашем городе — с машиной и краном при необходимости.</p>
                </div>
            </div>
        </div>

        <!-- FAQ -->
        <div class="mb-14">
            <h2 class="section-title mb-8 text-center">Частые вопросы о доставке в регионы</h2>
            <div class="max-w-3xl mx-auto space-y-4">
                <details class="bg-white rounded-xl border border-gray-200 p-5">
                    <summary class="font-semibold text-gray-900 cursor-pointer">В какие города России вы отгружаете
                        металлопрокат?</summary>
                    <p class="text-gray-600 mt-3 text-sm">Мы отгружаем металлопрокат более чем в
                        <?= $cityCount ?> городов России, включая Москву, Санкт-Петербург, Казань, Екатеринбург,
                        Новосибирск, Краснодар, Владивосток и все региональные центры страны.</p>
                </details>
                <details class="bg-white rounded-xl border border-gray-200 p-5">
                    <summary class="font-semibold text-gray-900 cursor-pointer">Как рассчитывается стоимость доставки в
                        регионы?</summary>
                    <p class="text-gray-600 mt-3 text-sm">Стоимость доставки рассчитывается индивидуально: зависит от
                        веса и габаритов груза, города назначения и выбранного транспорта. Точную стоимость менеджер
                        подтверждает после оформления заказа.</p>
                </details>
                <details class="bg-white rounded-xl border border-gray-200 p-5">
                    <summary class="font-semibold text-gray-900 cursor-pointer">Есть ли доставка металлопроката в день
                        заказа?</summary>
                    <p class="text-gray-600 mt-3 text-sm">Да, по Москве и Московской области возможна срочная доставка в
                        день заказа при заказе в первой половине дня. В другие города срок доставки уточняет менеджер.
                    </p>
                </details>
                <details class="bg-white rounded-xl border border-gray-200 p-5">
                    <summary class="font-semibold text-gray-900 cursor-pointer">Работаете ли вы с юридическими лицами в
                        регионах?</summary>
                    <p class="text-gray-600 mt-3 text-sm">Да, работаем с юридическими лицами по всей России: безналичный
                        расчёт с НДС и без НДС, полный пакет документов, отсрочка платежа для постоянных клиентов.</p>
                </details>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-gradient-to-r from-red-600 to-red-500 rounded-2xl p-10 text-center text-white">
            <h2 class="section-title mb-3" style="color:#fff;">Рассчитаем доставку в ваш город</h2>
            <p class="text-red-100 mb-8 max-w-xl mx-auto">Оставьте заявку — менеджер ответит в течение 15 минут,
                подтвердит наличие металлопроката и рассчитает точную стоимость отгрузки в ваш город.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/contacts"
                    class="bg-white text-red-600 px-8 py-3 rounded-lg font-bold hover:bg-red-50 transition">Связаться с
                    нами</a>
                <a href="/delivery"
                    class="border-2 border-white/70 text-white px-8 py-3 rounded-lg font-bold hover:bg-white/10 transition">Условия
                    доставки</a>
            </div>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>
    <script defer src="/public/assets/scripts/components/cart-favorites.min.js"></script>
</body>

</html>
