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
    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>
</head>
<body class="bg-gray-50">

    <?php include_once __DIR__ . '/../../components/header-shared.php'; ?>

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

    <script defer src="/public/assets/scripts/components/cart-favorites.min.js"></script>
</body>
</html>
