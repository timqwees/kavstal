<?php
$site = Setting\route\function\Functions::site();
$products = Setting\route\function\Functions::listProducts();

// Собираем категории для сайдбара
$catList = [];
$subList = [];
foreach ($products as $product) {
    $badge = $product['badge'] ?? '';
    if ($badge === 'Категория') {
        $catList[$product['id']] = $product;
    } elseif ($badge === 'Подкатегория') {
        $parentId = $product['categories']['parent_id'] ?? null;
        if ($parentId) $subList[$parentId][] = $product;
    }
}

$services = [
    'cutting' => [
        'title' => 'Резка металла',
        'icon' => 'fa-cut',
        'color' => 'red',
        'price_from' => 'от 50 ₽/рез',
        'price_note' => 'Цена зависит от толщины и типа металла',
        'desc' => 'Резка металлопроката в размер по вашим чертежам. Ленточнопильные станки, плазменная резка, гильотина. Точность до 0.5 мм.',
        'specs' => [
            'Толщина резки' => 'до 150 мм',
            'Точность' => '±0.5 мм',
            'Методы' => 'Ленточная, плазменная, гильотина',
            'Материалы' => 'Черный/нержавеющий прокат, цветмет',
            'Срок' => 'от 1 часа',
        ],
        'features' => ['Минимальные отходы', 'Резка пакетами', 'Чертежи любых форматов', 'Бесплатный расчёт'],
    ],
    'bending' => [
        'title' => 'Гибка металла',
        'icon' => 'fa-compress-arrows-alt',
        'color' => 'blue',
        'price_from' => 'от 100 ₽/гиб',
        'price_note' => 'Цена от толщины и радиуса гиба',
        'desc' => 'Гибка листового металла, арматуры, труб профильных и круглых. Изготовление металлоконструкций любой сложности.',
        'specs' => [
            'Толщина листа' => 'до 12 мм',
            'Трубы' => 'до 100 мм',
            'Длина гиба' => 'до 6 м',
            'Углы' => 'любые до 180°',
            'Материалы' => 'Сталь, нержавейка, алюминий',
        ],
        'features' => ['Любые углы гибки', 'Гибка в размер', 'Без брака', 'Контроль качества'],
    ],
    'delivery' => [
        'title' => 'Доставка',
        'icon' => 'fa-truck',
        'color' => 'green',
        'price_from' => 'от 1 500 ₽',
        'price_note' => 'По Москве и Московской области',
        'desc' => 'Доставка металлопроката по Москве и Московской области. Собственный автопарк от Gazelle до фуры. Грузчики включены.',
        'specs' => [
            'Тип ТС' => 'Газель, Камаз, фура, манипулятор',
            'Грузоподъёмность' => 'до 20 тн',
            'Разгрузка' => 'Кран-борт / гидроборт',
            'Срок' => 'В день заказа / на завтра',
            'Зона' => 'Москва, МО, регионы РФ',
        ],
        'features' => ['Собственный автопарк', 'Грузчики в подарок', 'Отслеживание в пути', 'Наличный и безналичный расчёт'],
    ],
    'welding' => [
        'title' => 'Сварка металла',
        'icon' => 'fa-fire',
        'color' => 'orange',
        'price_from' => 'от 300 ₽/шов',
        'price_note' => 'Цена от сложности и типа сварки',
        'desc' => 'Сварочные работы любой сложности. Сварка арматуры, труб, листового металла. Полуавтомат, TIG, MMA.',
        'specs' => [
            'Методы' => 'MMA, MIG/MAG, TIG',
            'Толщина' => 'до 50 мм',
            'Материалы' => 'Чёрная сталь, нержавейка, алюминий',
            'Разряд сварщиков' => '3-4 разряд, аттестованные',
            'Контроль' => 'Визуальный, УЗК (по запросу)',
        ],
        'features' => ['Сварка на объекте и в цехе', 'Контроль качества', 'Сложные узлы', 'Работа по ГОСТ'],
    ],
    'painting' => [
        'title' => 'Порошковая покраска',
        'icon' => 'fa-spray-can',
        'color' => 'purple',
        'price_from' => 'от 200 ₽/м²',
        'price_note' => 'Цена от цвета и сложности профиля',
        'desc' => 'Покраска металлоконструкций порошковой краской. Долговечное защитное покрытие в любой цвет RAL.',
        'specs' => [
            'Камера' => '6 × 3 × 3 м',
            'Цвета' => 'более 200 RAL',
            'Толщина покрытия' => '60–120 мкм',
            'Подготовка' => 'Дробеструйная обработка',
            'Гарантия' => '5 лет',
        ],
        'features' => ['Любой цвет RAL', 'Антикоррозия', 'УФ-стойкость', 'Более 5 лет службы'],
    ],
    'consult' => [
        'title' => 'Бесплатная консультация',
        'icon' => 'fa-user-tie',
        'color' => 'teal',
        'price_from' => 'Бесплатно',
        'price_note' => '',
        'desc' => 'Помощь в подборе металлопроката, расчёт веса и стоимости, составление сметы. Опытные менеджеры.',
        'specs' => [
            'Время расчёта' => 'до 15 минут',
            'Форматы' => 'Телефон, email, мессенджеры',
            'Документы' => 'Счет, договор, спецификация',
            'Дополнительно' => 'Сертификаты, паспорта качества',
            'Работаем' => 'Пн–Вс 9:00–18:00',
        ],
        'features' => ['Бесплатно', 'Помощь с ГОСТ', 'Оптимизация заказа', 'Обратная связь 24/7'],
    ],
];
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Услуги металлообработки — цены, заказать в Москве | КАВ СТАЛЬ</title>
    <meta name="description" content="Закажите услуги металлообработки в КАВ СТАЛЬ: резка металла от 50₽, гибка от 100₽, сварка от 300₽, порошковая покраска от 200₽/м². Доставка по Москве и МО.">

    <meta property="og:title" content="Услуги металлообработки — цены, заказать в Москве | КАВ СТАЛЬ">
    <meta property="og:description" content="Резка металла от 50₽, гибка от 100₽, сварка от 300₽, порошковая покраска от 200₽/м². Доставка по Москве и МО.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $site['baseUrl']; ?>/services">
    <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/market.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="КАВ СТАЛЬ">
    <meta property="og:locale" content="ru_RU">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Услуги металлообработки — цены, заказать в Москве | КАВ СТАЛЬ">
    <meta name="twitter:description" content="Резка металла от 50₽, гибка от 100₽, сварка от 300₽, порошковая покраска от 200₽/м².">
    <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/market.png">

    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo $site['baseUrl']; ?>/services">

    <link rel="icon" type="image/png" href="/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/public/assets/images/icons/favicon/favicon.svg" />

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <link rel="search" type="application/opensearchdescription+xml" title="КАВ СТАЛЬ" href="/opensearch.xml" />

    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "name": "Услуги металлообработки",
        "description": "Услуги металлобазы КАВ СТАЛЬ: резка, гибка, сварка, покраска, доставка",
        "itemListElement": [
            {"@type":"ListItem","position":1,"name":"Резка металла","url":"<?= $site['baseUrl'] ?>/services#cutting"},
            {"@type":"ListItem","position":2,"name":"Гибка металла","url":"<?= $site['baseUrl'] ?>/services#bending"},
            {"@type":"ListItem","position":3,"name":"Доставка","url":"<?= $site['baseUrl'] ?>/services#delivery"},
            {"@type":"ListItem","position":4,"name":"Сварка металла","url":"<?= $site['baseUrl'] ?>/services#welding"},
            {"@type":"ListItem","position":5,"name":"Порошковая покраска","url":"<?= $site['baseUrl'] ?>/services#painting"},
            {"@type":"ListItem","position":6,"name":"Бесплатная консультация","url":"<?= $site['baseUrl'] ?>/services#consult"}
        ]
    }
    </script>
    <style>
        .services-swiper .swiper-slide { height: auto; }
        .price-tag { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .spec-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #f3f4f6; font-size: 13px; }
        .spec-row:last-child { border-bottom: none; }
        .spec-label { color: #6b7280; }
        .spec-value { font-weight: 500; color: #374151; }
        html { scroll-behavior: smooth; }
    </style>
  <?php include_once __DIR__ . "/../../components/seo-head.php"; ?>
</head>

<body class="bg-gray-50">

    <?php include_once __DIR__ . '/../../components/header-shared.php'; ?>

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <nav class="flex items-center space-x-2 text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" class="text-gray-600 hover:text-red-500" itemprop="item" itemid="<?= $site['baseUrl']; ?>/">
                        <i class="fas fa-home"></i> <span itemprop="name">Главная</span>
                    </a>
                    <meta itemprop="position" content="1">
                </span>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name" class="text-gray-900 font-medium">Услуги</span>
                    <meta itemprop="position" content="2">
                </span>
            </nav>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Sidebar -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="hidden lg:block bg-white rounded-lg shadow-sm border border-gray-200 sticky top-24">
                    <div class="p-4 border-b border-gray-100">
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Категории</h2>
                    </div>
                    <nav class="py-2">
                        <?php foreach ($catList as $catId => $cat):
                            $catUrl = $cat['seo']['canonicalUrl'] ?? '#';
                            $hasSub = !empty($subList[$catId]);
                        ?>
                        <div>
                            <a href="<?= htmlspecialchars($catUrl) ?>"
                                class="flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:text-red-500 hover:bg-red-50 transition-colors group">
                                <span class="font-medium"><?= htmlspecialchars($cat['title']) ?></span>
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <?php if ($hasSub): ?>
                            <div class="ml-4 border-l border-gray-100">
                                <?php foreach ($subList[$catId] as $sub): ?>
                                <a href="<?= htmlspecialchars($sub['seo']['canonicalUrl'] ?? '#') ?>"
                                    class="block px-4 py-1.5 text-xs text-gray-500 hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <?= htmlspecialchars($sub['title']) ?>
                                </a>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                        <div class="border-t border-gray-100 mt-2 pt-2">
                            <span class="flex items-center justify-between px-4 py-2.5 text-sm text-red-500 bg-red-50 font-medium rounded-none">
                                <span>Услуги</span>
                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </nav>
                </div>
            </aside>

            <!-- Content -->
            <div class="flex-1">

                <!-- Hero -->
                <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-8 md:p-12 mb-8 text-white">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div class="flex-1">
                            <span class="text-red-400 text-sm font-semibold tracking-wider uppercase">Услуги металлобазы</span>
                            <h1 class="text-3xl md:text-4xl font-bold mt-2 mb-4">Услуги металлообработки<br><span class="text-red-400">с гарантией качества</span></h1>
                            <p class="text-gray-300 text-lg mb-6">Резка, гибка, сварка, покраска и доставка металлопроката. Работаем с физическими и юридическими лицами.</p>
                            <div class="flex flex-wrap gap-4">
                                <a href="#services" class="bg-red-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-500 transition flex items-center gap-2">
                                    <i class="fas fa-arrow-down"></i> Смотреть услуги
                                </a>
                                <a href="tel:+74959892420" class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition flex items-center gap-2">
                                    <i class="fas fa-phone"></i> +7 (495) 989-24-20
                                </a>
                            </div>
                        </div>
                        <div class="hidden md:flex items-center justify-center w-48 h-48 bg-red-500 rounded-full opacity-20 absolute right-12"></div>
                        <div class="hidden md:flex items-center justify-center w-32 h-32 bg-red-500 rounded-full opacity-10 absolute right-32 bottom-8"></div>
                    </div>
                </div>

                <!-- Quick stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
                        <div class="text-2xl font-bold text-red-500">6+</div>
                        <div class="text-xs text-gray-500 mt-1">Видов услуг</div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
                        <div class="text-2xl font-bold text-red-500">14 000+</div>
                        <div class="text-xs text-gray-500 mt-1">Товаров на складе</div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
                        <div class="text-2xl font-bold text-red-500">24/7</div>
                        <div class="text-xs text-gray-500 mt-1">Приём заказов</div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
                        <div class="text-2xl font-bold text-red-500">5 лет</div>
                        <div class="text-xs text-gray-500 mt-1">Гарантия на работы</div>
                    </div>
                </div>

                <!-- Services Grid -->
                <div id="services" class="space-y-6 mb-12">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-2xl font-bold text-gray-900">Услуги</h2>
                        <span class="text-sm text-gray-500"><?= count($services) ?> услуги</span>
                    </div>

                    <?php foreach ($services as $key => $svc):
                        $colorMap = [
                            'red' => ['bg' => 'from-red-500 to-red-500', 'badge' => 'bg-red-100 text-red-500'],
                            'blue' => ['bg' => 'from-blue-500 to-blue-700', 'badge' => 'bg-blue-100 text-blue-700'],
                            'green' => ['bg' => 'from-green-500 to-green-700', 'badge' => 'bg-green-100 text-green-700'],
                            'orange' => ['bg' => 'from-orange-500 to-orange-700', 'badge' => 'bg-orange-100 text-orange-700'],
                            'purple' => ['bg' => 'from-purple-500 to-purple-700', 'badge' => 'bg-purple-100 text-purple-700'],
                            'teal' => ['bg' => 'from-teal-500 to-teal-700', 'badge' => 'bg-teal-100 text-teal-700'],
                        ];
                        $c = $colorMap[$svc['color']];
                    ?>
                    <div id="<?= $key ?>" class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="flex flex-col md:flex-row">
                            <!-- Icon block -->
                            <div class="md:w-48 bg-gradient-to-br <?= $c['bg'] ?> flex items-center justify-center p-8 md:p-0">
                                <i class="fas <?= $svc['icon'] ?> text-white text-5xl"></i>
                            </div>
                            <!-- Info -->
                            <div class="flex-1 p-6">
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-xl font-bold text-gray-900"><?= $svc['title'] ?></h3>
                                            <span class="text-xs font-semibold <?= $c['badge'] ?> px-3 py-1 rounded-full">от <?= $svc['price_from'] ?></span>
                                        </div>
                                        <p class="text-gray-600 text-sm mb-4"><?= $svc['desc'] ?></p>
                                        <div class="grid grid-cols-2 gap-x-8">
                                            <?php foreach ($svc['specs'] as $label => $val): ?>
                                            <div class="spec-row">
                                                <span class="spec-label"><?= $label ?></span>
                                                <span class="spec-value"><?= $val ?></span>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="flex flex-wrap gap-2 mt-4">
                                            <?php foreach ($svc['features'] as $f): ?>
                                            <span class="inline-flex items-center gap-1 text-xs text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                                                <i class="fas fa-check text-green-500 text-[10px]"></i> <?= $f ?>
                                            </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <!-- Price & CTA -->
                                    <div class="md:w-56 flex flex-col items-center md:items-end gap-3 md:border-l md:border-gray-100 md:pl-6">
                                        <div class="price-tag text-white text-center px-6 py-3 rounded-xl w-full">
                                            <div class="text-xs opacity-80">Цена</div>
                                            <div class="text-xl font-bold"><?= $svc['price_from'] ?></div>
                                        </div>
                                        <a href="tel:+74959892420" class="w-full bg-red-500 text-white py-2.5 rounded-lg font-semibold hover:bg-red-500 transition text-sm text-center flex items-center justify-center gap-2">
                                            <i class="fas fa-phone"></i> Заказать
                                        </a>
                                        <a href="mailto:zakaz@kavstal.ru?subject=Услуга: <?= urlencode($svc['title']) ?>" class="w-full text-gray-500 border border-gray-200 py-2 rounded-lg hover:bg-gray-50 transition text-xs text-center">
                                            <i class="fas fa-envelope mr-1"></i> zakaz@kavstal.ru
                                        </a>
                                        <?php if ($svc['price_note']): ?>
                                        <span class="text-[11px] text-gray-400 text-center"><?= $svc['price_note'] ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Calc CTA -->
                <div class="bg-gradient-to-r from-red-500 to-red-500 rounded-2xl p-8 md:p-10 mb-8 text-white text-center">
                    <h2 class="text-2xl md:text-3xl font-bold mb-3">Нужен точный расчёт стоимости?</h2>
                    <p class="text-lg opacity-90 mb-6">Пришлите спецификацию — мы рассчитаем за 15 минут</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4 max-w-xl mx-auto">
                        <a href="tel:+74959892420" class="bg-white text-red-500 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition flex items-center justify-center gap-2">
                            <i class="fas fa-phone"></i> Позвонить
                        </a>
                        <a href="mailto:zakaz@kavstal.ru" class="bg-red-500 text-white border-2 border-white px-8 py-3 rounded-lg font-bold hover:bg-red-900 transition flex items-center justify-center gap-2">
                            <i class="fas fa-envelope"></i> Оставить запрос
                        </a>
                        <a href="https://t.me/<?= htmlspecialchars(ltrim($site['telegram'] ?? 'kavstal_bot', '@')) ?>" target="_blank" rel="noopener" class="bg-sky-500 text-white px-8 py-3 rounded-lg font-bold hover:bg-sky-600 transition flex items-center justify-center gap-2">
                            <i class="fab fa-telegram-plane"></i> Telegram
                        </a>
                    </div>
                    <p class="text-sm opacity-75 mt-4">Принимаем заказы 7 дней в неделю с 9:00 до 18:00</p>
                </div>

                <!-- How It Works -->
                <div class="bg-white rounded-xl border border-gray-200 p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Как заказать услугу</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-red-500 font-bold text-lg">1</span>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Выбираете услугу</h4>
                            <p class="text-sm text-gray-500">Ознакомьтесь с услугами и ценами выше</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-red-500 font-bold text-lg">2</span>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Связываетесь с нами</h4>
                            <p class="text-sm text-gray-500">По телефону, email или Telegram</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-red-500 font-bold text-lg">3</span>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Согласовываете детали</h4>
                            <p class="text-sm text-gray-500">Сроки, объём, способ оплаты</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-red-500 font-bold text-lg">4</span>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Получаете результат</h4>
                            <p class="text-sm text-gray-500">Готовые изделия с гарантией качества</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ -->
                <div class="bg-white rounded-xl border border-gray-200 p-8" itemscope itemtype="https://schema.org/FAQPage">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Часто задаваемые вопросы</h2>
                    <div class="space-y-3" x-data="{ open: null }">
                        <?php
                        $faqs = [
                            ['q' => 'Какие способы оплаты вы принимаете?', 'a' => 'Наличные, безналичный расчёт с НДС и без НДС, оплата картой в офисе. Для юрлиц — счёт на оплату с закрывающими документами.'],
                            ['q' => 'Как быстро вы делаете резку металла?', 'a' => 'Стандартный срок — от 1 часа при наличии металла на складе. Сложные заказы — от 1 дня. Всегда уточняйте срок у менеджера.'],
                            ['q' => 'Есть ли доставка за МКАД?', 'a' => 'Да, доставляем по Московской области и в регионы РФ. Стоимость рассчитывается индивидуально. От 1 500 ₽ по Москве.'],
                            ['q' => 'Работаете с НДС?', 'a' => 'Да, мы работаем с НДС и без НДС. Предоставляем все закрывающие документы: счёт, договор, УПД, счёт-фактуру.'],
                            ['q' => 'Даёте гарантию на услуги?', 'a' => 'На порошковую покраску — 5 лет. На сварочные работы — от 1 года. На резку и гибку — гарантия соответствия размерам ±0.5 мм.'],
                            ['q' => 'Можно ли заказать услугу онлайн?', 'a' => 'Да, отправьте заявку на email zakaz@kavstal.ru или позвоните +7 (495) 989-24-20. Мы рассчитаем стоимость за 15 минут.'],
                        ];
                        foreach ($faqs as $i => $faq):
                        ?>
                        <div class="border border-gray-200 rounded-lg overflow-hidden" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <button onclick="this.nextElementSibling.classList.toggle('hidden');this.querySelector('.fa-chevron-down').classList.toggle('rotate-180')"
                                class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 transition-colors">
                                <span class="font-medium text-gray-900 text-sm" itemprop="name"><?= $faq['q'] ?></span>
                                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"></i>
                            </button>
                            <div class="hidden px-4 pb-4" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <p class="text-sm text-gray-600" itemprop="text"><?= $faq['a'] ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile menu
            const toggle = document.querySelector('.mobile-menu-toggle');
            // Simple mobile menu overlay
            if (toggle) {
                toggle.addEventListener('click', function () {
                    window.location.href = '/market';
                });
            }
        });
    </script>
    <script defer src="/public/assets/scripts/components/cart-favorites.min.js"></script>
</body>
</html>
