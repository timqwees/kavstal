<?php
$site = Setting\route\function\Functions::site();
$cartItems = App\Models\Cart\Cart::getItems();
$cartTotal = App\Models\Cart\Cart::getTotal();
$cartCount = App\Models\Cart\Cart::getCount();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина | <?= htmlspecialchars($site['company']) ?></title>
    <meta name="description" content="Ваша корзина на металлобазе <?= htmlspecialchars($site['company']) ?>">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="<?= $site['baseUrl'] ?>/cart">
    <link rel="icon" type="image/png" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= $site['baseUrl'] ?>/public/assets/images/icons/favicon/favicon.svg" />
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="search" type="application/opensearchdescription+xml" title="КАВ СТАЛЬ" href="<?= $site['baseUrl'] ?>/opensearch.xml" />
    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>
  <?php include_once __DIR__ . "/../../components/seo-head.php"; ?>
</head>
<body class="bg-gray-50">
    <?php include_once __DIR__ . '/../../components/header-shared.php'; ?>

    <!-- Breadcrumbs -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="/" class="text-gray-600 hover:text-red-500" aria-label="Главная"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-900 font-medium">Корзина</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Корзина</h1>

        <?php if (empty($cartItems)): ?>
        <div class="bg-white rounded-2xl shadow-md p-12 text-center max-w-lg mx-auto">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-cart text-gray-400 text-4xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Корзина пуста</h2>
            <p class="text-gray-500 mb-8">Добавьте товары из каталога, чтобы оформить заказ</p>
            <a href="/market" class="inline-flex items-center px-6 py-3 bg-red-500 text-white rounded-lg font-medium hover:bg-red-500 transition">
                <i class="fas fa-arrow-left mr-2"></i> Перейти в каталог
            </a>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                <?php foreach ($cartItems as $item): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 cart-item" data-product-id="<?= htmlspecialchars($item['product_id']) ?>" data-unit="<?= htmlspecialchars($item['unit']) ?>">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <?php if (!empty($item['image']) && $item['image'] !== '/public/assets/images/no-image.svg'): ?>
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="max-w-full max-h-full object-contain">
                            <?php else: ?>
                            <i class="fas fa-cube text-gray-300 text-3xl"></i>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="<?= htmlspecialchars($item['product_url']) ?>" class="text-sm font-medium text-gray-900 hover:text-red-500 transition line-clamp-2"><?= htmlspecialchars($item['product_name']) ?></a>
                            <div class="flex flex-wrap gap-2 mt-1">
                                <?php foreach ($item['specs'] as $specName => $specValue): ?>
                                <span class="text-xs text-gray-500 bg-gray-50 px-2 py-0.5 rounded"><?= htmlspecialchars($specName) ?>: <?= htmlspecialchars($specValue) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <div class="text-right">
                                <div class="text-sm font-semibold text-gray-900"><?= number_format($item['price'], 2, ',', ' ') ?> ₽</div>
                                <div class="text-xs text-gray-500">за <?= htmlspecialchars($item['unit']) ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <button class="qty-btn qty-minus w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition text-sm" data-action="decrease">−</button>
                            <input type="number" class="qty-input w-16 h-8 text-center border border-gray-200 rounded-lg text-sm font-medium" value="<?= (int)$item['quantity'] ?>" min="0" step="1" data-product-id="<?= htmlspecialchars($item['product_id']) ?>" data-unit="<?= htmlspecialchars($item['unit']) ?>">
                            <button class="qty-btn qty-plus w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition text-sm" data-action="increase">+</button>
                            <span class="text-xs text-gray-400 ml-1"><?= htmlspecialchars($item['unit']) ?></span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-base font-bold text-gray-900 item-subtotal"><?= number_format($item['subtotal'], 2, ',', ' ') ?> ₽</span>
                            <button class="remove-item text-gray-400 hover:text-red-500 transition p-1" data-product-id="<?= htmlspecialchars($item['product_id']) ?>" data-unit="<?= htmlspecialchars($item['unit']) ?>">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Cart Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-28">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Ваш заказ</h2>
                    <div class="space-y-3 mb-4">
                        <?php foreach ($cartItems as $item): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 truncate max-w-[180px]"><?= htmlspecialchars($item['product_name']) ?></span>
                            <span class="text-gray-900 font-medium"><?= number_format($item['subtotal'], 2, ',', ' ') ?> ₽</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-bold text-gray-900">Итого:</span>
                            <span class="text-2xl font-bold text-red-500 cart-total"><?= number_format($cartTotal, 2, ',', ' ') ?> ₽</span>
                        </div>
                    </div>
                    <a href="/checkout" class="block w-full bg-red-500 text-white text-center py-3 rounded-lg font-medium hover:bg-red-500 transition">
                        <i class="fas fa-arrow-right mr-2"></i> Оформить заказ
                    </a>
                    <a href="/market" class="block w-full text-center py-3 mt-2 text-sm text-gray-600 hover:text-red-500 transition">
                        <i class="fas fa-arrow-left mr-1"></i> Продолжить покупки
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
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

    function updateCartItem(productId, unit, quantity) {
        const fd = new URLSearchParams();
        fd.append('product_id', productId);
        fd.append('quantity', quantity);
        fd.append('unit', unit);
        return fetch('/api/cart/update', { method: 'POST', body: fd }).then(r => r.json());
    }

    function removeCartItem(productId, unit) {
        const fd = new URLSearchParams();
        fd.append('product_id', productId);
        fd.append('unit', unit);
        return fetch('/api/cart/remove', { method: 'POST', body: fd }).then(r => r.json());
    }

    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const container = this.closest('.cart-item');
            const input = container.querySelector('.qty-input');
            let val = parseFloat(input.value) || 0;
            if (this.dataset.action === 'increase') val += 1;
            else if (this.dataset.action === 'decrease' && val > 1) val -= 1;
            else if (this.dataset.action === 'decrease' && val <= 1) {
                if (confirm('Удалить товар из корзины?')) {
                    const pid = input.dataset.productId;
                    const unit = input.dataset.unit;
                    removeCartItem(pid, unit).then(r => {
                        if (r.success) { location.reload(); }
                    });
                }
                return;
            }
            input.value = val;
            const pid = input.dataset.productId;
            const unit = input.dataset.unit;
            updateCartItem(pid, unit, val).then(() => { location.reload(); });
        });
    });

    document.querySelectorAll('.qty-input').forEach(input => {
        let debounce;
        input.addEventListener('input', function() {
            clearTimeout(debounce);
            debounce = setTimeout(() => {
                const val = parseFloat(this.value) || 0;
                const pid = this.dataset.productId;
                const unit = this.dataset.unit;
                if (val <= 0) {
                    removeCartItem(pid, unit).then(r => { if (r.success) location.reload(); });
                } else {
                    updateCartItem(pid, unit, val).then(() => { location.reload(); });
                }
            }, 500);
        });
    });

    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Удалить товар из корзины?')) return;
            const pid = this.dataset.productId;
            const unit = this.dataset.unit;
            removeCartItem(pid, unit).then(r => { if (r.success) location.reload(); });
        });
    });
    </script>
</body>
</html>
