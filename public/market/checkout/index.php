<?php
$site = Setting\route\function\Functions::site();
$cartItems = App\Models\Cart\Cart::getItems();
$cartTotal = App\Models\Cart\Cart::getTotal();
$cartCount = App\Models\Cart\Cart::getCount();
if (empty($cartItems)) {
    header('Location: /cart');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа | <?= htmlspecialchars($site['company']) ?></title>
    <meta name="description" content="Оформление заказа на металлобазе <?= htmlspecialchars($site['company']) ?>">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="<?= $site['baseUrl'] ?>/checkout">
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
                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1"><?= $cartCount ?></span>
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
                    <a href="/cart" class="relative text-gray-700 p-2">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span class="absolute -top-0.5 -right-0.5 bg-red-600 text-white text-[10px] font-bold rounded-full min-w-[16px] h-[16px] flex items-center justify-center px-0.5"><?= $cartCount ?></span>
                    </a>
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
                <a href="/cart" class="flex items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium"><i class="fas fa-shopping-cart mr-3"></i>Корзина <?= $cartCount > 0 ? '(' . $cartCount . ')' : '' ?></a>
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

    <!-- Breadcrumbs -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="/" class="text-gray-600 hover:text-red-600"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <a href="/cart" class="text-gray-600 hover:text-red-600">Корзина</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-900 font-medium">Оформление заказа</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Оформление заказа</h1>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <!-- Order Form -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Контактные данные</h2>
                    <form id="checkout-form" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ФИО *</label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                placeholder="Иванов Иван Иванович">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Телефон *</label>
                            <input type="tel" name="phone" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                placeholder="+7 (999) 123-45-67">
                            <p class="text-xs text-gray-400 mt-1">Мы перезвоним для подтверждения заказа</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                placeholder="email@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Комментарий к заказу</label>
                            <textarea name="comment" rows="3"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                placeholder="Уточните способ доставки, время отгрузки или другие пожелания"></textarea>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-600">
                            <p><i class="fas fa-info-circle text-red-600 mr-2"></i>Нажимая «Оформить заказ», вы соглашаетесь на обработку персональных данных.</p>
                            <p class="mt-2 text-gray-400 text-xs"><i class="fas fa-file-invoice mr-1"></i>После оформления вы сможете скачать PDF-счёт для оплаты.</p>
                        </div>
                        <button type="submit" id="submit-order"
                            class="w-full bg-red-600 text-white py-3.5 rounded-lg font-medium hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i> Оформить заказ
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-28">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Состав заказа</h2>
                    <div class="space-y-3 max-h-[400px] overflow-y-auto">
                        <?php foreach ($cartItems as $item): ?>
                        <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0">
                            <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-cube text-gray-300"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($item['product_name']) ?></p>
                                <p class="text-xs text-gray-500">
                                    <?= number_format($item['quantity'], 2, ',', ' ') ?> <?= htmlspecialchars($item['unit']) ?> × <?= number_format($item['price'], 2, ',', ' ') ?> ₽
                                </p>
                            </div>
                            <div class="text-sm font-semibold text-gray-900 whitespace-nowrap"><?= number_format($item['subtotal'], 2, ',', ' ') ?> ₽</div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-bold text-gray-900">Итого:</span>
                            <span class="text-2xl font-bold text-red-600"><?= number_format($cartTotal, 2, ',', ' ') ?> ₽</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 text-right">Без учёта стоимости доставки</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>

    <script>
    document.getElementById('checkout-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('submit-order');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Оформляем...';

        const fd = new URLSearchParams(new FormData(this));
        fetch('/checkout', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(d => {
                if (d.success) {
                    window.location.href = '/order/' + d.order_id + '/success';
                } else {
                    alert(d.error || 'Ошибка оформления заказа');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-check-circle"></i> Оформить заказ';
                }
            })
            .catch(() => {
                alert('Ошибка сети. Попробуйте ещё раз.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-circle"></i> Оформить заказ';
            });
    });
    </script>
</body>
</html>
