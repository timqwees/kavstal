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
    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>
</head>
<body class="bg-gray-50">

    <?php include_once __DIR__ . '/../../components/header-shared.php'; ?>

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
