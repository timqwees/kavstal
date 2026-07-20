<?php
$site = Setting\route\function\Functions::site();
$order = $order ?? [];
$orderItems = App\Models\Order\Order::getItems((int)($order['id'] ?? 0));
$deliveryLabel = App\Models\Order\Order::deliveryLabel($order['delivery_method'] ?? '');
$paymentLabel = App\Models\Order\Order::paymentLabel($order['payment_method'] ?? '');
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
    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>
  <?php include_once __DIR__ . '/../../components/seo-head.php'; ?>
</head>
<body class="bg-gray-50">

    <?php include_once __DIR__ . '/../../components/header-shared.php'; ?>

    <main class="max-w-3xl mx-auto px-4 py-12">
        <div class="bg-white rounded-2xl shadow-md p-8 md:p-12 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                <i class="fas fa-check-circle text-green-600 text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Заказ #<?= $order['id'] ?? '' ?> оформлен!</h1>
            <p class="text-gray-500 mb-8">Спасибо за заказ! Мы свяжемся с вами в ближайшее время для подтверждения.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left mb-8">
                <div class="bg-gray-50 rounded-xl p-5">
                    <h3 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2"><i class="fas fa-user text-red-500"></i>Данные покупателя</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">ФИО:</span><span class="font-medium"><?= htmlspecialchars($order['customer_name']) ?></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Телефон:</span><span class="font-medium"><?= htmlspecialchars($order['customer_phone']) ?></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Email:</span><span class="font-medium"><?= htmlspecialchars($order['customer_email'] ?: '—') ?></span></div>
                        <?php if (!empty($order['comment'])): ?>
                        <div class="flex justify-between"><span class="text-gray-500">Комментарий:</span><span class="font-medium" style="text-align:end;"><?= htmlspecialchars($order['comment']) ?></span></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-5">
                    <h3 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2"><i class="fas fa-shopping-cart text-red-500"></i>Детали заказа</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">Номер:</span><span class="font-medium">#<?= $order['id'] ?? '' ?></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Дата:</span><span class="font-medium"><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Доставка:</span><span class="font-medium"><?= htmlspecialchars($deliveryLabel) ?></span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Оплата:</span><span class="font-medium"><?= htmlspecialchars($paymentLabel) ?></span></div>
                    </div>
                </div>
            </div>

            <?php if (!empty($orderItems)): ?>
            <div class="bg-gray-50 rounded-xl p-5 text-left mb-8">
                <h3 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2"><i class="fas fa-box text-red-500"></i>Состав заказа</h3>
                <div class="space-y-2">
                    <?php foreach ($orderItems as $item): ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700"><?= htmlspecialchars($item['product_name']) ?> — <?= number_format((float)$item['quantity'], 2, ',', ' ') ?> <?= htmlspecialchars($item['unit']) ?></span>
                        <span class="font-medium"><?= number_format((float)$item['subtotal'], 2, ',', ' ') ?> ₽</span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="border-t border-gray-200 pt-3 mt-3 flex justify-between items-center">
                    <span class="text-gray-900 font-bold">Итого</span>
                    <span class="text-xl font-bold text-red-500"><?= number_format((float)$order['total'], 2, ',', ' ') ?> ₽</span>
                </div>
            </div>
            <?php endif; ?>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/order/<?= $order['id'] ?? 0 ?>/pdf" target="_blank"
                    class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-red-500 to-red-500 text-white rounded-xl font-bold text-base hover:from-red-500 hover:to-red-500 transition gap-3 shadow-lg shadow-red-200">
                    <i class="fas fa-file-pdf text-lg group-hover:scale-110 transition-transform"></i>
                    <span>Скачать PDF-счёт</span>
                    <span class="text-xs opacity-75">(<?= number_format((float)$order['total'], 0, ',', ' ') ?> ₽)</span>
                </a>
                <a href="/market"
                    class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 hover:border-gray-300 transition gap-2">
                    <i class="fas fa-arrow-left"></i> В каталог
                </a>
            </div>

        </div>

        <div class="mt-8 bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-8 text-center text-white">
            <h2 class="text-2xl font-bold mb-3">Нужна помощь?</h2>
            <p class="mb-6 opacity-80">Позвоните нам — уточним детали по заказу</p>
            <a href="tel:+74959892420" class="inline-flex items-center gap-2 bg-white text-gray-900 px-8 py-3 rounded-xl font-bold hover:bg-gray-100 transition shadow-lg">
                <i class="fas fa-phone"></i> +7 (495) 989-24-20
            </a>
        </div>
    </main>

    <script>
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({ ecommerce: null });
    dataLayer.push({
        event: 'purchase',
        ecommerce: {
            transaction_id: <?= json_encode((string)($order['id'] ?? '')) ?>,
            value: <?= json_encode((float)($order['total'] ?? 0)) ?>,
            currency: 'RUB',
            items: [
                <?php if (!empty($orderItems)): ?>
                <?php foreach ($orderItems as $item): ?>
                {
                    item_id: <?= json_encode((string)($item['product_id'] ?? '')) ?>,
                    item_name: <?= json_encode($item['product_name'] ?? '') ?>,
                    price: <?= json_encode((float)($item['price'] ?? 0)) ?>,
                    quantity: <?= json_encode((float)($item['quantity'] ?? 1)) ?>
                },
                <?php endforeach; ?>
                <?php endif; ?>
            ]
        }
    });
    </script>
    <?php include_once './public/components/footer.php'; ?>
</body>
</html>
