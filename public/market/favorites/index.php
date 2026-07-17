<?php
$site = Setting\route\function\Functions::site();
$cartCount = App\Models\Cart\Cart::getCount();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Избранное | <?= htmlspecialchars($site['company']) ?></title>
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="<?= $site['baseUrl'] ?>/favorites">
    <link rel="icon" type="image/png" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon.svg" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>
</head>
<body class="bg-gray-50">
    <?php include_once __DIR__ . '/../../components/header-shared.php'; ?>

    <!-- Breadcrumbs -->
    <div class="max-w-7xl mx-auto px-4 py-3">
        <nav class="flex items-center text-xs text-gray-400">
            <a href="/" class="hover:text-red-500 transition">Главная</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700">Избранное</span>
        </nav>
    </div>

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-4 pb-16">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-6">Избранное</h1>

        <!-- Empty state -->
        <div id="fav-empty" class="hidden text-center py-20">
            <i class="far fa-heart text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg mb-2">Список избранного пуст</p>
            <p class="text-gray-400 text-sm mb-6">Добавляйте товары в избранное, нажимая на сердечко</p>
            <a href="/market" class="inline-block bg-red-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-red-500 transition">Перейти в каталог</a>
        </div>

        <!-- Products grid -->
        <div id="fav-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5"></div>
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
    function addToCart(pid, qty, unit) {
        var fd = new URLSearchParams();
        fd.append('product_id', pid);
        fd.append('quantity', qty);
        fd.append('unit', unit);
        return fetch('/api/cart/add', { method: 'POST', body: fd }).then(function(r) { return r.json(); });
    }
    updateCartCount();

    (function() {
        var STORAGE_KEY = 'kavstal_favorites';
        function getFavs() { try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || []; } catch(e) { return []; } }
        function saveFavs(arr) { localStorage.setItem(STORAGE_KEY, JSON.stringify(arr)); }

        var favs = getFavs();
        var emptyEl = document.getElementById('fav-empty');
        var gridEl = document.getElementById('fav-grid');

        if (!favs.length) { emptyEl.classList.remove('hidden'); return; }

        var fd = new URLSearchParams();
        favs.forEach(function(id) { fd.append('ids[]', id); });

        fetch('/api/products/by-ids', { method: 'POST', body: fd }).then(function(r) { return r.json(); }).then(function(d) {
            var products = d.products || [];
            if (!products.length) { emptyEl.classList.remove('hidden'); return; }

            products.forEach(function(p) {
                var unitsHtml = '';
                var firstUnit = p.unit;
                var firstPrice = p.price;
                if (p.units) {
                    Object.keys(p.units).forEach(function(u) {
                        unitsHtml += '<button type="button" class="text-[9px] px-1.5 py-0.5 rounded font-medium transition-all ' + (u === firstUnit ? 'bg-red-100 text-red-500' : 'bg-neutral-100 text-neutral-500 hover:bg-red-50 hover:text-red-500') + '" data-unit="' + u + '" data-price="' + p.units[u] + '" onclick="switchUnit(this)">' + u + '</button>';
                    });
                }
                var stock = p.in_stock
                    ? '<span class="inline-flex items-center gap-0.5 text-[11px] font-medium text-emerald-600"><span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500"></span>В наличии</span>'
                    : '<span class="inline-flex items-center gap-0.5 text-[11px] font-medium text-zinc-400"><span class="inline-block w-1.5 h-1.5 rounded-full bg-zinc-300"></span>Под заказ</span>';

                var specsHtml = '';
                if (p.specs) {
                    Object.keys(p.specs).forEach(function(k) {
                        if (p.specs[k]) specsHtml += '<span class="text-[10px] text-neutral-500 bg-neutral-50 border border-neutral-100 px-1.5 py-0.5 rounded-md font-medium">' + k + ': <strong class="text-neutral-700">' + p.specs[k] + '</strong></span>';
                    });
                }

                var card = document.createElement('div');
                card.className = 'border border-zinc-200 hover:border-zinc-300 transition-all duration-200 rounded-xl p-3 flex flex-col w-full';
                card.innerHTML =
                    '<div class="flex items-center justify-between mb-2">' +
                        '<span class="bg-red-500 text-white text-[11px] px-2 py-0.5 rounded-md font-semibold leading-relaxed">В избранном</span>' +
                        '<button class="remove-fav-btn w-7 h-7 rounded-md border border-red-300 bg-red-50 flex items-center justify-center transition-colors" data-pid="' + p.id + '" title="Убрать из избранного">' +
                            '<svg width="13" height="11" viewBox="0 0 24 24" fill="#ef4444" stroke="#ef4444" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>' +
                        '</button>' +
                    '</div>' +
                    '<a href="' + p.url + '" class="h-[120px] mb-3 rounded-lg overflow-hidden bg-zinc-50 flex items-center justify-center">' +
                        (p.image ? '<img src="' + p.image.replace(/"/g, '&quot;') + '" alt="' + p.title.replace(/"/g, '&quot;') + '" class="w-full h-full object-contain" loading="lazy">' : '<i class="fas fa-image text-zinc-300 text-3xl"></i>') +
                    '</a>' +
                    '<a href="' + p.url + '" class="text-[13px] font-semibold text-neutral-800 hover:text-red-500 line-clamp-2 min-h-[36px] mb-1">' + p.title + '</a>' +
                    (specsHtml ? '<div class="flex flex-wrap gap-1 mb-2">' + specsHtml + '</div>' : '') +
                    '<div class="mt-auto">' +
                        '<div class="flex items-center gap-1.5 mb-2">' + stock + '</div>' +
                        '<div class="flex items-end justify-between gap-2">' +
                            '<div class="min-w-0">' +
                                '<div class="price-display text-[15px] font-bold text-neutral-900 leading-tight">' + Math.round(firstPrice).toLocaleString('ru-RU') + ' ₽</div>' +
                                '<div class="flex gap-0.5 mt-1">' + unitsHtml + '</div>' +
                            '</div>' +
                            '<button type="button" class="add-to-cart-btn w-8 h-8 rounded-full bg-red-500 hover:bg-red-500 text-white flex items-center justify-center shrink-0 transition-colors" data-pid="' + p.id + '" data-unit="' + firstUnit + '" title="В корзину">' +
                                '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>' +
                            '</button>' +
                        '</div>' +
                    '</div>';
                gridEl.appendChild(card);
            });

            // Remove from favorites
            document.querySelectorAll('.remove-fav-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var pid = this.getAttribute('data-pid');
                    var favs = getFavs();
                    favs = favs.filter(function(id) { return id !== pid; });
                    saveFavs(favs);
                    this.closest('.border').remove();
                    if (!favs.length) { emptyEl.classList.remove('hidden'); }
                    var badge = document.getElementById('favCountBadge');
                    if (badge) {
                        var c = favs.length;
                        badge.textContent = c > 99 ? '99+' : c;
                        badge.style.display = c > 0 ? 'flex' : 'none';
                    }
                });
            });

            // Add to cart
            document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var card = this.closest('.flex.flex-col');
                    var pid = this.getAttribute('data-pid');
                    var unit = this.getAttribute('data-unit');
                    var qtyInput = card ? card.querySelector('.cart-qty') : null;
                    var qty = parseFloat(qtyInput ? qtyInput.value : 1) || 1;
                    var originalSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>';
                    this.disabled = true;
                    addToCart(pid, qty, unit).then(function(r) {
                        if (r.success) {
                            btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-white"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
                            btn.classList.add('bg-red-500', 'in-cart');
                            setTimeout(function() { btn.disabled = false; btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>'; }, 1500);
                            updateCartCount();
                        } else {
                            btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-amber-500"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
                            setTimeout(function() { btn.disabled = false; btn.innerHTML = originalSvg; }, 1500);
                        }
                    }).catch(function() {
                        btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-red-400"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
                        setTimeout(function() { btn.disabled = false; btn.innerHTML = originalSvg; }, 1500);
                    });
                });
            });

            // Restore cart state for buttons
            fetch('/api/cart/products').then(function(r) { return r.json(); }).then(function(d) {
                var ids = d.products || [];
                if (!ids.length) return;
                document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
                    var pid = btn.getAttribute('data-pid');
                    if (ids.indexOf(pid) !== -1) {
                        btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
                        btn.classList.add('bg-red-500', 'in-cart');
                    }
                });
            });
        });
    })();

    function switchUnit(button) {
        var parent = button.parentElement;
        Array.from(parent.querySelectorAll('button')).forEach(function(b) {
            b.classList.remove('bg-red-100', 'text-red-500');
            b.classList.add('bg-neutral-100', 'text-neutral-500');
        });
        button.classList.remove('bg-neutral-100', 'text-neutral-500');
        button.classList.add('bg-red-100', 'text-red-500');
        var card = button.closest('.flex.flex-col');
        if (card) {
            var pd = card.querySelector('.price-display');
            if (pd) pd.textContent = Math.round(parseFloat(button.getAttribute('data-price'))).toLocaleString('ru-RU') + ' ₽';
            var cartBtn = card.querySelector('.add-to-cart-btn');
            if (cartBtn) cartBtn.setAttribute('data-unit', button.getAttribute('data-unit'));
        }
    }
    </script>
    <?php include_once __DIR__ . '/../../components/widget-chatwoot.php'; ?>
</body>
</html>
