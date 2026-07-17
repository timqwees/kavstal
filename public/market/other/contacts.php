<?php $site = Setting\route\function\Functions::site(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты | <?= htmlspecialchars($site['company']) ?> - Свяжитесь с нами</title>
    <meta name="description"
        content="Контакты металлобазы <?= htmlspecialchars($site['company']) ?> в Москве. Телефон <?= htmlspecialchars($site['phone']) ?>, адрес: <?= htmlspecialchars($site['address']) ?>. Режим работы: <?= htmlspecialchars($site['workingHours']) ?>.">

    <meta property="og:title" content="Контакты | <?= htmlspecialchars($site['company']) ?>">
    <meta property="og:description" content="Контактная информация металлобазы <?= htmlspecialchars($site['company']) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $site['baseUrl'] ?>/contacts">
    <meta property="og:image" content="<?= $site['baseUrl'] ?>/public/assets/images/bgpage/main.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company']) ?>">
    <meta property="og:locale" content="ru_RU">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Контакты | <?= htmlspecialchars($site['company']) ?>">
    <meta name="twitter:description" content="Контактная информация металлобазы <?= htmlspecialchars($site['company']) ?>">
    <meta name="twitter:image" content="<?= $site['baseUrl'] ?>/public/assets/images/bgpage/main.jpg">

    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $site['baseUrl'] ?>/contacts">

    <link rel="icon" type="image/png" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon.svg" />

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="<?= $site['baseUrl'] ?>" crossorigin>

    <link rel="search" type="application/opensearchdescription+xml" title="<?= htmlspecialchars($site['company']) ?>"
        href="<?= $site['baseUrl'] ?>/opensearch.xml" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= htmlspecialchars($site['company']) ?>",
        "url": "<?= $site['baseUrl'] ?>",
        "logo": "<?= $site['baseUrl'] ?>/public/assets/images/icons/logo/logo.svg",
        "description": "Металлобаза <?= htmlspecialchars($site['company']) ?> — поставщик металлопроката в Москве и Московской области",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?= htmlspecialchars($site['address']) ?>",
            "addressLocality": "Москва",
            "addressCountry": "RU"
        },
        "contactPoint": [
            {
                "@type": "ContactPoint",
                "telephone": "<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>",
                "contactType": "sales",
                "areaServed": "RU",
                "availableLanguage": ["Russian"]
            },
            {
                "@type": "ContactPoint",
                "telephone": "<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>",
                "contactType": "customer service",
                "areaServed": "RU",
                "availableLanguage": ["Russian"]
            }
        ],
        "email": "<?= htmlspecialchars($site['email']) ?>",
        "telephone": "<?= htmlspecialchars($site['phone']) ?>"
    }
    </script>
  <?php include_once __DIR__ . "/../../components/seo-head.php"; ?>
</head>

<body class="bg-gray-50">

    <?php include_once __DIR__ . '/../../components/header-shared.php'; ?>

    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <nav class="flex items-center space-x-2 text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" class="text-gray-600 hover:text-red-500" itemprop="item" itemscope itemtype="https://schema.org/Thing" itemid="<?= $site['baseUrl'] ?>/"><i class="fas fa-home"></i> <span itemprop="name">Главная</span></a>
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

    <main class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-12 text-center">Контакты</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div>
                <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Свяжитесь с нами</h2>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-phone-alt text-red-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Телефон</p>
                                <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $site['phone'])) ?>"
                                    class="text-xl font-bold text-gray-900 hover:text-red-500 transition"><?= htmlspecialchars($site['phone']) ?></a>
                                <p class="text-sm text-gray-500 mt-1">Звоните ежедневно с 9:00 до 18:00</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-envelope text-red-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Email</p>
                                <a href="mailto:<?= htmlspecialchars($site['email']) ?>"
                                    class="text-lg font-medium text-gray-900 hover:text-red-500 transition"><?= htmlspecialchars($site['email']) ?></a>
                                <p class="text-sm text-gray-500 mt-1">Для заказов и коммерческих предложений</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-red-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Адрес</p>
                                <p class="text-lg font-medium text-gray-900"><?= htmlspecialchars($site['address']) ?></p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-clock text-red-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Режим работы</p>
                                <p class="text-lg font-medium text-gray-900">09:00 - 18:00</p>
                                <p class="text-sm text-gray-500 mt-1">Вс: выходной</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-md p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Мы в социальных сетях</h3>
                    <div class="flex space-x-4">
                        <a href="https://t.me/<?= htmlspecialchars(ltrim($site['telegram'] ?? 'kavstal_bot', '@')) ?>" target="_blank"
                            class="w-12 h-12 bg-sky-500 rounded-lg flex items-center justify-center text-white hover:bg-sky-600 transition">
                            <i class="fab fa-telegram text-xl"></i>
                        </a>
                        <a href="https://wa.me/<?= htmlspecialchars(preg_replace('/[^0-9]/', '', $site['whatsapp'] ?? $site['phone_clean'] ?? '74959892420')) ?>" target="_blank"
                            class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center text-white hover:bg-green-600 transition">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-2xl shadow-md overflow-hidden h-full min-h-[500px]">
                    <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A26fac0f930c91c623aafe2f3757b7adc63f0e9f8625105edda0659e463840e3e&amp;source=constructor" width="100%" height="100%" frameborder="0" allowfullscreen="true" style="min-height: 500px; border: 0;"></iframe>
                </div>
            </div>
        </div>

        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Отделы компании</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-shopping-cart text-red-500 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Отдел продаж</h3>
                    <p class="text-gray-600 mb-4">Прием заказов, расчет стоимости, консультации по ассортименту</p>
                    <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="text-red-500 font-medium hover:underline"><?= htmlspecialchars($site['phone']) ?> доб. 101</a>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-truck text-red-500 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Отдел логистики</h3>
                    <p class="text-gray-600 mb-4">Доставка, отгрузка, координация транспорта</p>
                    <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="text-red-500 font-medium hover:underline"><?= htmlspecialchars($site['phone']) ?> доб. 102</a>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-calculator text-red-500 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Бухгалтерия</h3>
                    <p class="text-gray-600 mb-4">Документы, счета, акты, закрывающие документы</p>
                    <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="text-red-500 font-medium hover:underline"><?= htmlspecialchars($site['phone']) ?> доб. 103</a>
                </div>
            </div>
        </div>

        <div class="mt-16 bg-gradient-to-r from-red-500 to-red-500 rounded-2xl p-8 md:p-12">
            <div class="max-w-2xl mx-auto text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Остались вопросы?</h2>
                <p class="text-lg mb-8 opacity-90">Позвоните нам или напишите — мы ответим в течение 15 минут в рабочее время</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $site['phone'])) ?>"
                        class="bg-white text-red-500 px-8 py-4 rounded-lg font-bold hover:bg-gray-100 transition flex items-center justify-center">
                        <i class="fas fa-phone mr-3"></i>Позвонить сейчас
                    </a>
                    <a href="mailto:<?= htmlspecialchars($site['email']) ?>"
                        class="bg-red-500 text-white border-2 border-white px-8 py-4 rounded-lg font-bold hover:bg-red-500 transition flex items-center justify-center">
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
