<?php
$site = Setting\route\function\Functions::site();
$cartCount = App\Models\Cart\Cart::getCount();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заказы | <?= htmlspecialchars($site['company']) ?></title>
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="<?= $site['baseUrl'] ?>/orders">
    <link rel="icon" type="image/png" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon.svg" />
    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>
    <style>
        .status-new { background: #fef3c7; color: #92400e; }
        .status-processing { background: #dbeafe; color: #1e40af; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <a href="/" class="flex items-center flex-shrink-0">
                    <img loading="lazy" class="h-8 lg:h-10" src="<?= $site['baseUrl'] ?>/public/assets/images/icons/logo/logo.svg" alt="<?= htmlspecialchars($site['company']) ?>">
                </a>
                <div class="hidden lg:flex items-center space-x-4">
                    <a href="/cart" class="relative p-2 text-gray-700 hover:text-red-600 transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="cart-count-badge absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1"><?= $cartCount ?></span>
                    </a>
                    <div class="text-right">
                        <a href="tel:+74959892420" class="text-lg font-bold text-gray-900 hover:text-red-600 transition whitespace-nowrap">+7 (495) 989-24-20</a>
                        <p class="text-xs text-gray-500">Пн-Пт 9:00-18:00</p>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Breadcrumbs -->
    <div class="max-w-7xl mx-auto px-4 py-3">
        <nav class="flex items-center text-xs text-gray-400">
            <a href="/" class="hover:text-red-600 transition">Главная</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700">Мои заказы</span>
        </nav>
    </div>

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-4 pb-16">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-6">Мои заказы</h1>

        <!-- Empty state -->
        <div id="orders-empty" class="hidden text-center py-20">
            <i class="fas fa-clipboard-list text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg mb-2">У вас пока нет заказов</p>
            <p class="text-gray-400 text-sm mb-6">Оформите заказ, добавив товары в корзину</p>
            <a href="/market" class="inline-block bg-red-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-red-700 transition">Перейти в каталог</a>
        </div>

        <!-- Loading -->
        <div id="orders-loading" class="text-center py-20">
            <div class="inline-block w-8 h-8 border-3 border-red-300 border-t-red-600 rounded-full animate-spin"></div>
            <p class="text-gray-400 text-sm mt-3">Загрузка заказов...</p>
        </div>

        <!-- Orders list -->
        <div id="orders-list" class="space-y-4"></div>
    </main>

    <script>
    function updateCartCount() {
        fetch('/api/cart/count').then(function(r) { return r.json(); }).then(function(d) {
            document.querySelectorAll('.cart-count-badge').forEach(function(el) {
                el.textContent = d.count > 99 ? '99+' : d.count;
                el.style.display = d.count > 0 ? 'flex' : 'none';
            });
        });
    }
    updateCartCount();

    (function() {
        var emptyEl = document.getElementById('orders-empty');
        var loadingEl = document.getElementById('orders-loading');
        var listEl = document.getElementById('orders-list');

        var statusLabels = { 'new': 'Новый', 'processing': 'В обработке', 'completed': 'Выполнен', 'cancelled': 'Отменён' };

        fetch('/api/orders/list').then(function(r) { return r.json(); }).then(function(d) {
            loadingEl.classList.add('hidden');
            var orders = d.orders || [];
            if (!orders.length) { emptyEl.classList.remove('hidden'); return; }

            orders.forEach(function(order) {
                var created = new Date(order.created_at);
                var dateStr = created.toLocaleDateString('ru-RU', { day: 'numeric', month: 'long', year: 'numeric' });
                var timeStr = created.toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' });
                var status = order.status || 'new';
                var statusLabel = statusLabels[status] || status;

                var card = document.createElement('div');
                card.className = 'bg-white rounded-xl border border-gray-200 overflow-hidden';
                card.innerHTML =
                    '<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 border-b border-gray-100">' +
                        '<div>' +
                            '<div class="flex items-center gap-2 mb-1">' +
                                '<span class="text-sm font-bold text-gray-900">Заказ #' + order.id + '</span>' +
                                '<span class="status-' + status + ' text-[11px] font-medium px-2 py-0.5 rounded-full">' + statusLabel + '</span>' +
                            '</div>' +
                            '<p class="text-xs text-gray-400">' + dateStr + ' в ' + timeStr + '</p>' +
                        '</div>' +
                        '<div class="text-right">' +
                            '<div class="text-lg font-bold text-red-600">' + parseFloat(order.total).toLocaleString('ru-RU') + ' ₽</div>' +
                            '<a href="/order/' + order.id + '/pdf" class="text-xs text-gray-400 hover:text-red-600 transition inline-flex items-center gap-1" target="_blank">' +
                                '<i class="fas fa-file-pdf"></i> Скачать счёт' +
                            '</a>' +
                        '</div>' +
                    '</div>' +
                    '<div class="p-4">' +
                        '<div class="flex items-center gap-4 text-xs text-gray-500">' +
                            '<span><i class="fas fa-user mr-1"></i>' + (order.customer_name || '—') + '</span>' +
                            '<span><i class="fas fa-phone mr-1"></i>' + (order.customer_phone || '—') + '</span>' +
                        '</div>' +
                        (order.comment ? '<p class="text-xs text-gray-400 mt-2"><i class="fas fa-comment mr-1"></i>' + order.comment + '</p>' : '') +
                    '</div>';
                listEl.appendChild(card);
            });
        }).catch(function() {
            loadingEl.classList.add('hidden');
            emptyEl.classList.remove('hidden');
        });
    })();
    </script>
</body>
</html>
