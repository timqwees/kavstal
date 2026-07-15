<?php
$site = Setting\route\function\Functions::site();
$order = $order ?? [];
$orderItems = App\Models\Order\Order::getItems((int)($order['id'] ?? 0));
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ #<?= $order['id'] ?? '' ?> оформлен | <?= htmlspecialchars($site['company']) ?></title>
    <meta name="description" content="Заказ успешно оформлен на металлобазе <?= htmlspecialchars($site['company']) ?>">
    <meta name="robots" content="noindex, follow">
    <link rel="icon" type="image/png" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon.svg" />
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .mobile-menu-overlay { opacity: 0; visibility: hidden; transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out; }
        .mobile-menu-overlay.active { opacity: 1; visibility: visible; }
        .mobile-menu-toggle span:nth-child(1) { transform-origin: top left; }
        .mobile-menu-toggle span:nth-child(3) { transform-origin: bottom left; }
    </style>
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
                    <img loading="lazy" class="h-10 lg:h-12" src="<?= $site['baseUrl'] ?>/public/assets/images/icons/logo/logo.svg" alt="<?= htmlspecialchars($site['company']) ?>">
                </a>
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="/market" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Каталог</a>
                    <a href="/services" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Услуги</a>
                    <a href="/about" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">О компании</a>
                    <a href="/delivery" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Доставка и оплата</a>
                    <a href="/contacts" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Контакты</a>
                </div>
                <div class="hidden lg:flex items-center space-x-4">
                    <a href="/cart" class="relative p-2 text-gray-700 hover:text-red-600 transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1" style="display:none">0</span>
                    </a>
                    <div class="text-right">
                        <a href="tel:+74959892420" class="text-lg font-bold text-gray-900 hover:text-red-600 transition whitespace-nowrap">+7 (495) 989-24-20</a>
                        <p class="text-xs text-gray-500">Пн-Пт 9:00-18:00</p>
                    </div>
                    <a href="tel:+74959892420" class="bg-red-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-red-700 transition flex items-center gap-2">
                        <i class="fas fa-phone-alt"></i>
                        <span class="hidden xl:inline">Заказать звонок</span>
                    </a>
                </div>
                <div class="lg:hidden flex items-center gap-3">
                    <a href="tel:+74959892420" class="text-gray-700 p-2"><i class="fas fa-phone-alt text-lg"></i></a>
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

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay fixed inset-0 bg-black/50 z-40 lg:hidden">
        <div class="absolute right-0 top-0 h-full w-72 bg-white shadow-xl p-6">
            <button class="mobile-menu-overlay-close text-gray-500 hover:text-gray-700 mb-6"><i class="fas fa-times text-xl"></i></button>
            <nav class="space-y-2">
                <a href="/market" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Каталог</a>
                <a href="/services" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Услуги</a>
                <a href="/about" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">О компании</a>
                <a href="/delivery" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Доставка и оплата</a>
                <a href="/contacts" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Контакты</a>
                <div class="border-t border-gray-200 my-4"></div>
                <a href="tel:+74959892420" class="flex items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium"><i class="fas fa-phone-alt mr-3 text-red-600"></i>+7 (495) 989-24-20</a>
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
        if (e.target === this) this.classList.remove('active');
    });
    </script>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 py-12">
        <div class="bg-white rounded-2xl shadow-md p-8 md:p-12 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check-circle text-green-600 text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Заказ #<?= $order['id'] ?? '' ?> оформлен!</h1>
            <p class="text-gray-500 mb-8">Спасибо за заказ! Мы свяжемся с вами в ближайшее время для подтверждения.</p>

            <div class="bg-gray-50 rounded-xl p-6 text-left mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Данные заказа</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Номер:</span><span class="font-medium">#<?= $order['id'] ?? '' ?></span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Дата:</span><span class="font-medium"><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></span></div>
                    <div class="flex justify-between"><span class="text-gray-500">ФИО:</span><span class="font-medium"><?= htmlspecialchars($order['customer_name']) ?></span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Телефон:</span><span class="font-medium"><?= htmlspecialchars($order['customer_phone']) ?></span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Email:</span><span class="font-medium"><?= htmlspecialchars($order['customer_email'] ?: '—') ?></span></div>
                    <?php if (!empty($order['comment'])): ?>
                    <div class="flex justify-between"><span class="text-gray-500">Комментарий:</span><span class="font-medium"><?= htmlspecialchars($order['comment']) ?></span></div>
                    <?php endif; ?>
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <div class="flex justify-between text-base"><span class="text-gray-900 font-bold">Итого:</span><span class="text-xl font-bold text-red-600"><?= number_format((float)$order['total'], 2, ',', ' ') ?> ₽</span></div>
                    </div>
                </div>
            </div>

            <?php if (!empty($orderItems)): ?>
            <div class="bg-gray-50 rounded-xl p-6 text-left mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Состав заказа</h2>
                <div class="space-y-2">
                    <?php foreach ($orderItems as $item): ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700"><?= htmlspecialchars($item['product_name']) ?> — <?= number_format((float)$item['quantity'], 2, ',', ' ') ?> <?= htmlspecialchars($item['unit']) ?></span>
                        <span class="font-medium"><?= number_format((float)$item['subtotal'], 2, ',', ' ') ?> ₽</span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/order/<?= $order['id'] ?>/pdf" target="_blank"
                    class="inline-flex items-center justify-center px-8 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition gap-2">
                    <i class="fas fa-file-pdf"></i> Скачать PDF-счёт
                </a>
                <a href="/market"
                    class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition gap-2">
                    <i class="fas fa-arrow-left"></i> Вернуться в каталог
                </a>
            </div>
        </div>

        <div class="mt-8 bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-8 text-center text-white">
            <h2 class="text-2xl font-bold mb-3">Нужна помощь?</h2>
            <p class="mb-6 opacity-90">Позвоните нам — мы поможем уточнить детали заказа</p>
            <a href="tel:+74959892420" class="inline-flex items-center gap-2 bg-white text-red-600 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
                <i class="fas fa-phone"></i> +7 (495) 989-24-20
            </a>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>
</body>
</html>
