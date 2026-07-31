<?php $site = Setting\route\function\Functions::site(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты | <?= htmlspecialchars($site['company']) ?> - Свяжитесь с нами</title>
    <meta name="description"
        content="Контакты компании <?= htmlspecialchars($site['company']) ?> в Москве. Телефон <?= htmlspecialchars($site['phone']) ?>, адрес: <?= htmlspecialchars($site['address']) ?>. Режим работы: <?= htmlspecialchars($site['workingHours']) ?>.">

    <meta property="og:title" content="Контакты | <?= htmlspecialchars($site['company']) ?>">
    <meta property="og:description" content="Контактная информация компании <?= htmlspecialchars($site['company']) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $site['baseUrl'] ?>/contacts">
    <meta property="og:image" content="<?= $site['baseUrl'] ?>/public/assets/images/bgpage/main.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company']) ?>">
    <meta property="og:locale" content="ru_RU">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Контакты | <?= htmlspecialchars($site['company']) ?>">
    <meta name="twitter:description" content="Контактная информация компании <?= htmlspecialchars($site['company']) ?>">
    <meta name="twitter:image" content="<?= $site['baseUrl'] ?>/public/assets/images/bgpage/main.jpg">

    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $site['baseUrl'] ?>/contacts">

    <link rel="icon" type="image/png"
        href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml"
        href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon.svg" />

    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="<?= $site['baseUrl'] ?>" crossorigin>

    <link rel="search" type="application/opensearchdescription+xml" title="<?= htmlspecialchars($site['company']) ?>"
        href="<?= $site['baseUrl'] ?>/opensearch.xml" />

    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    </noscript>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= htmlspecialchars($site['company']) ?>",
        "url": "<?= $site['baseUrl'] ?>",
        "logo": "<?= $site['baseUrl'] ?>/public/assets/images/icons/logo/logo.webp",
        "description": "Компания <?= htmlspecialchars($site['company']) ?> — поставщик металлопроката в Москве и Московской области",
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
                    <a href="/" class="text-gray-600 hover:text-red-500" itemprop="item" itemscope
                        itemtype="https://schema.org/Thing" itemid="<?= $site['baseUrl'] ?>/"><i
                            class="fas fa-home"></i> <span itemprop="name">Главная</span></a>
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
                    <h2 class="section-title mb-6">Свяжитесь с нами</h2>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
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
                            <div
                                class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
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
                            <div
                                class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-red-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Адрес</p>
                                <p class="text-lg font-medium text-gray-900"><?= htmlspecialchars($site['address']) ?>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
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
                        <a href="https://t.me/<?= htmlspecialchars(ltrim($site['telegram'] ?? 'kavstal_bot', '@')) ?>"
                            target="_blank"
                            class="w-12 h-12 bg-sky-500 rounded-lg flex items-center justify-center text-white hover:bg-sky-600 transition">
                            <i class="fab fa-telegram text-xl"></i>
                        </a>
                        <a href="https://wa.me/<?= htmlspecialchars(preg_replace('/[^0-9]/', '', $site['whatsapp'] ?? $site['phone_clean'] ?? '74959892420')) ?>"
                            target="_blank"
                            class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center text-white hover:bg-green-600 transition">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div>
                <!-- Spec Upload Form -->
                <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                    <h2 class="section-title mb-4">Загрузить спецификацию</h2>
                    <p class="text-gray-500 text-sm mb-6">Пришлите файл спецификации (Excel, PDF) — мы рассчитаем
                        стоимость и свяжемся с вами</p>
                    <form id="specForm" enctype="multipart/form-data" class="space-y-4">
                        <input type="text" name="name" placeholder="Ваше имя" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none">
                        <input type="tel" name="phone" placeholder="Телефон" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none">
                        <input type="email" name="email" placeholder="Email"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none">
                        <textarea name="comment" rows="3" placeholder="Комментарий к заявке (необязательно)"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm outline-none"></textarea>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Файл спецификации
                                (необязательно)</label>
                            <label class="spec-file-label">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                                <span id="contactsFileName">Прикрепить файл (xlsx, pdf, doc)</span>
                                <input type="file" name="spec_file" accept=".xlsx,.xls,.pdf,.csv,.doc,.docx">
                            </label>
                        </div>
                        <style>
                            .spec-file-label {
                                display: flex;
                                align-items: center;
                                gap: 8px;
                                padding: 10px 16px;
                                border: 1px dashed #d1d5db;
                                border-radius: 8px;
                                cursor: pointer;
                                font-size: 14px;
                                color: #6b7280;
                                transition: border-color 0.2s;
                            }

                            .spec-file-label:hover {
                                border-color: #ef4444;
                            }

                            .spec-file-label input {
                                display: none;
                            }
                        </style>
                        <button type="submit"
                            class="w-full bg-red-500 text-white py-3 rounded-lg font-semibold hover:bg-red-500 transition">
                            Отправить заявку
                        </button>
                    </form>
                    <div id="specFormStatus" class="mt-4 text-sm font-medium"></div>
                </div>

                <div class="bg-white rounded-2xl shadow-md overflow-hidden h-[550px]">
                    <iframe
                        src="https://yandex.ru/map-widget/v1/?um=constructor%3A26fac0f930c91c623aafe2f3757b7adc63f0e9f8625105edda0659e463840e3e&amp;source=constructor"
                        width="100%" height="100%" frameborder="0" allowfullscreen="true"
                        style="min-height: 350px; border: 0;" title="Карта проезда"></iframe>
                </div>
            </div>
        </div>

        <div class="mt-16 bg-gradient-to-r from-red-500 to-red-500 rounded-2xl p-8 md:p-12">
            <div class="max-w-2xl mx-auto text-center text-white">
                <h2 class="section-title mb-4" style="color:#fff;">Остались вопросы?</h2>
                <p class="text-lg mb-8 opacity-90">Позвоните нам или напишите — мы ответим в течение 15 минут в рабочее
                    время</p>
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
    <script>
        document.querySelector('#specForm input[type="file"]')?.addEventListener('change', function () {
            document.getElementById('contactsFileName').textContent = this.files[0] ? this.files[0].name : 'Прикрепить файл (xlsx, pdf, doc)';
        });
        document.getElementById('specForm')?.addEventListener('submit', async function (e) {
            e.preventDefault();
            const status = document.getElementById('specFormStatus');
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.textContent = 'Отправка...';
            const fd = new FormData(this);
            try {
                const res = await fetch('/send/email', { method: 'POST', body: fd });
                const data = await res.json();
                if (data.success) {
                    status.className = 'mt-4 text-sm font-medium text-green-600';
                    status.textContent = 'Заявка отправлена! Мы свяжемся с вами в ближайшее время.';
                    this.reset();
                    document.getElementById('contactsFileName').textContent = 'Прикрепить файл (xlsx, pdf, doc)';
                } else {
                    status.className = 'mt-4 text-sm font-medium text-red-600';
                    status.textContent = 'Ошибка: ' + (data.error || 'повторите попытку');
                }
            } catch {
                status.className = 'mt-4 text-sm font-medium text-red-600';
                status.textContent = 'Ошибка соединения. Попробуйте позже.';
            }
            btn.disabled = false;
            btn.textContent = 'Отправить заявку';
        });
    </script>
</body>

</html>