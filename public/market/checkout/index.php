<?php
$site = Setting\route\function\Functions::site();
$cartItems = App\Models\Cart\Cart::getItems();
$cartTotal = App\Models\Cart\Cart::getTotal();
$cartCount = App\Models\Cart\Cart::getCount();
if (empty($cartItems)) {
    header('Location: /cart');
    exit;
}
$deliveryMethods = [
    'pickup' => ['label' => 'Самовывоз', 'desc' => 'г. Москва, ул. Семёновская площадь, д. 7', 'price' => 0],
    'moscow' => ['label' => 'Доставка по Москве', 'desc' => 'В пределах МКАД', 'price' => 'от 2 000 ₽'],
    'oblast' => ['label' => 'Доставка по области', 'desc' => 'Московская область, до 50 км от МКАД', 'price' => 'от 3 500 ₽'],
    'russia' => ['label' => 'Доставка по России', 'desc' => 'Транспортными компаниями', 'price' => 'рассчитывается'],
];
$paymentMethods = [
    'cash' => ['label' => 'Наличные', 'desc' => 'Оплата при получении наличными', 'icon' => 'fa-money-bill-wave'],
    'card' => ['label' => 'Картой при получении', 'desc' => 'Терминал у водителя / в офисе', 'icon' => 'fa-credit-card'],
    'transfer' => ['label' => 'Безналичный расчёт', 'desc' => 'Счёт с НДС для юр. лиц и ИП', 'icon' => 'fa-building-columns'],
];
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@27.1.3/dist/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@suggestions/da-suggestions@2.0.6/dist/css/suggestions.css">
    <style>
        .iti__selected-dial-code { color: #000; }
        .iti { width: 100%; }
        .option-card { cursor: pointer; transition: all 0.2s; border: 2px solid #e5e7eb; border-radius: 12px; padding: 14px 16px; }
        .option-card:hover { border-color: #fecaca; }
        .option-card.selected { border-color: #ef4444; background: #ffffff; }
        .option-card input { display: none; }
        .option-card .check { display: none; }
        .option-card.selected .check { display: inline-flex; }
        .section-toggle { cursor: pointer; user-select: none; }
        .section-toggle .arrow { transition: transform 0.2s; }
        .section-toggle.collapsed .arrow { transform: rotate(-90deg); }
        .section-body { overflow: hidden; transition: max-height 0.3s ease; }
        .section-body.collapsed { max-height: 0 !important; padding-top: 0 !important; padding-bottom: 0 !important; margin-top: 0 !important; }
    </style>
    <script>
    window.__dadataToken = 'efc5d536293a5bcfc7c8f09119fdc7c8256245d5';
    window.__cityName = 'Москва';
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@suggestions/da-suggestions@2.0.6/dist/js/jquery.suggestions.min.js" defer></script>
  <?php include_once __DIR__ . "/../components/seo-head.php"; ?>
</head>
<body class="bg-gray-50">

    <?php include_once __DIR__ . '/../../components/header-shared.php'; ?>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex items-center gap-3 mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Оформление заказа</h1>
            <span class="text-sm text-gray-400 bg-gray-100 px-3 py-1 rounded-full"><?= $cartCount ?> <?= $cartCount === 1 ? 'товар' : ($cartCount > 1 && $cartCount < 5 ? 'товара' : 'товаров') ?></span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <div class="lg:col-span-3 space-y-6">
                <form id="checkout-form" action="/checkout" method="POST" class="flex flex-col gap-6" data-goal="checkout">
                    <!-- Контактные данные -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="section-toggle flex items-center justify-between p-5" onclick="toggleSection(this)">
                            <h2 class="text-lg font-bold text-gray-900"><i class="fas fa-user text-red-500 mr-2"></i>Контактные данные</h2>
                            <i class="fas fa-chevron-down text-gray-400 arrow"></i>
                        </div>
                        <div class="section-body px-5 pb-5 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ФИО *</label>
                                    <input type="text" name="name" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                        placeholder="Иванов Иван Иванович">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Телефон *</label>
                                    <input type="tel" name="phone" data-type-phone required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                        placeholder="(999) 123-45-67">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                    placeholder="email@example.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Комментарий</label>
                                <textarea name="comment" rows="2"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm resize-none"
                                    placeholder="Адрес доставки, время отгрузки, пожелания…"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Способ доставки -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="section-toggle flex items-center justify-between p-5" onclick="toggleSection(this)">
                            <h2 class="text-lg font-bold text-gray-900"><i class="fas fa-truck text-red-500 mr-2"></i>Способ доставки</h2>
                            <i class="fas fa-chevron-down text-gray-400 arrow"></i>
                        </div>
                        <div class="section-body px-5 pb-5 space-y-3">
                            <?php foreach ($deliveryMethods as $key => $dm): ?>
                            <label class="option-card flex items-center gap-4 <?= $key === 'pickup' ? 'selected' : '' ?>">
                                <input type="radio" name="delivery" value="<?= $key ?>" <?= $key === 'pickup' ? 'checked' : '' ?>>
                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 <?= $key === 'pickup' ? 'border-red-500' : 'border-gray-300' ?>">
                                    <div class="w-2.5 h-2.5 rounded-full <?= $key === 'pickup' ? 'bg-red-500' : '' ?>"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-sm text-gray-900"><?= $dm['label'] ?></div>
                                    <div class="text-xs text-gray-500"><?= $dm['desc'] ?></div>
                                </div>
                                <div class="text-sm font-semibold whitespace-nowrap <?= $dm['price'] === 0 ? 'text-green-600' : 'text-gray-900' ?>">
                                    <?= $dm['price'] === 0 ? 'Бесплатно' : $dm['price'] ?>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Адрес доставки -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100" id="address-section">
                        <div class="section-toggle flex items-center justify-between p-5" onclick="toggleSection(this)">
                            <h2 class="text-lg font-bold text-gray-900"><i class="fas fa-map-marker-alt text-red-500 mr-2"></i>Адрес доставки</h2>
                            <i class="fas fa-chevron-down text-gray-400 arrow"></i>
                        </div>
                        <div class="section-body px-5 pb-5 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Регион / Город *</label>
                                <input type="text" name="address" id="address-input" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                    placeholder="Введите город, улицу, дом">
                                <input type="hidden" name="address_region" id="address-region">
                                <input type="hidden" name="address_city" id="address-city">
                                <input type="hidden" name="address_street" id="address-street">
                                <input type="hidden" name="address_house" id="address-house">
                                <input type="hidden" name="address_kladr_id" id="address-kladr-id">
                                <input type="hidden" name="address_fias_id" id="address-fias-id">
                                <p class="mt-1 text-xs text-gray-400">Начните вводить адрес — подсказки от DaData</p>
                            </div>
                        </div>
                    </div>

                    <!-- Способ оплаты -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="section-toggle flex items-center justify-between p-5" onclick="toggleSection(this)">
                            <h2 class="text-lg font-bold text-gray-900"><i class="fas fa-wallet text-red-500 mr-2"></i>Способ оплаты</h2>
                            <i class="fas fa-chevron-down text-gray-400 arrow"></i>
                        </div>
                        <div class="section-body px-5 pb-5 space-y-3">
                            <?php foreach ($paymentMethods as $key => $pm): ?>
                            <label class="option-card flex items-center gap-4 <?= $key === 'transfer' ? 'selected' : '' ?>">
                                <input type="radio" name="payment" value="<?= $key ?>" <?= $key === 'transfer' ? 'checked' : '' ?>>
                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 <?= $key === 'transfer' ? 'border-red-500' : 'border-gray-300' ?>">
                                    <div class="w-2.5 h-2.5 rounded-full <?= $key === 'transfer' ? 'bg-red-500' : '' ?>"></div>
                                </div>
                                <div class="w-9 h-9 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas <?= $pm['icon'] ?> text-red-500"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-sm text-gray-900"><?= $pm['label'] ?></div>
                                    <div class="text-xs text-gray-500"><?= $pm['desc'] ?></div>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-600 border border-gray-100">
                        <p><i class="fas fa-info-circle text-red-500 mr-2"></i>Нажимая «Оформить заказ», вы соглашаетесь на <a href="#" class="text-red-500 underline">обработку персональных данных</a>.</p>
                    </div>

                    <button type="submit" id="submit-order"
                        class="w-full bg-gradient-to-r from-red-500 to-red-500 text-white py-4 rounded-xl font-bold text-base hover:from-red-500 hover:to-red-500 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3 shadow-lg shadow-red-200">
                        <i class="fas fa-check-circle text-lg"></i> Оформить заказ
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-28">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Состав заказа</h2>
                    <div class="space-y-3 max-h-[400px] overflow-y-auto pr-1">
                        <?php foreach ($cartItems as $item): ?>
                        <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0">
                            <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-cube text-gray-300 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($item['product_name']) ?></p>
                                <p class="text-xs text-gray-500"><?= number_format($item['quantity'], 2, ',', ' ') ?> <?= htmlspecialchars($item['unit']) ?></p>
                            </div>
                            <div class="text-sm font-semibold text-gray-900 whitespace-nowrap"><?= number_format($item['subtotal'], 2, ',', ' ') ?> ₽</div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="border-t border-gray-200 pt-4 mt-3 space-y-1">
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Сумма</span>
                            <span><?= number_format($cartTotal, 2, ',', ' ') ?> ₽</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Доставка</span>
                            <span class="text-green-600 font-medium">Бесплатно</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-gray-200 mt-2">
                            <span class="text-base font-bold text-gray-900">Итого</span>
                            <span class="text-2xl font-bold text-red-500"><?= number_format($cartTotal, 2, ',', ' ') ?> ₽</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>

    <script defer src="/public/assets/scripts/components/cart-favorites.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@27.1.3/dist/js/intlTelInputWithUtils.min.js" defer></script>
    <script>
    function toggleSection(header) {
        const body = header.nextElementSibling;
        header.classList.toggle('collapsed');
        body.classList.toggle('collapsed');
    }

    document.querySelectorAll('.option-card').forEach(function(card) {
        card.addEventListener('click', function() {
            const group = this.closest('.space-y-3') || this.parentElement;
            group.querySelectorAll('.option-card').forEach(function(c) {
                c.classList.remove('selected');
                c.querySelector('input').checked = false;
                const dot = c.querySelector('.w-2\\.5');
                if (dot) dot.classList.remove('bg-red-500');
                const border = c.querySelector('.w-5');
                if (border) border.classList.remove('border-red-500');
                if (border) border.classList.add('border-gray-300');
            });
            this.classList.add('selected');
            this.querySelector('input').checked = true;
            const dot = this.querySelector('.w-2\\.5');
            if (dot) dot.classList.add('bg-red-500');
            const border = this.querySelector('.w-5');
            if (border) border.classList.remove('border-gray-300');
            if (border) border.classList.add('border-red-500');
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const phoneInputs = document.querySelectorAll("[data-type-phone]");
        phoneInputs.forEach(function(input) {
            if (typeof intlTelInput !== 'undefined') {
                window.intlTelInput(input, { initialCountry: "ru", separateDialCode: true });
            }
            input.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('7') || value.startsWith('8')) value = value.substring(1);
                value = value.substring(0, 10);
                if (value.length > 0) {
                    let formatted = '';
                    if (value.length >= 1) formatted += '(' + value.substring(0, 3);
                    if (value.length >= 4) formatted += ') ' + value.substring(3, 6);
                    if (value.length >= 7) formatted += '-' + value.substring(6, 8);
                    if (value.length >= 9) formatted += '-' + value.substring(8, 10);
                    e.target.value = formatted;
                }
                e.target.setCustomValidity('');
            });
            input.addEventListener('blur', function () {
                const digits = this.value.replace(/\D/g, '');
                this.setCustomValidity(digits.length !== 10 ? 'Введите полный номер телефона' : '');
            });
        });

        var addressInput = document.getElementById('address-input');
        if (addressInput && typeof $.fn.suggestions !== 'undefined') {
            $('#address-input').suggestions({
                token: window.__dadataToken,
                type: 'ADDRESS',
                minChars: 3,
                onSelect: function(suggestion) {
                    var data = suggestion.data;
                    document.getElementById('address-region').value = data.region_with_type || '';
                    document.getElementById('address-city').value = data.city_with_type || data.settlement_with_type || '';
                    document.getElementById('address-street').value = data.street_with_type || '';
                    document.getElementById('address-house').value = data.house || '';
                    document.getElementById('address-kladr-id').value = data.kladr_id || '';
                    document.getElementById('address-fias-id').value = data.fias_id || '';
                }
            });
        }

        document.getElementById('checkout-form').addEventListener('submit', function(e){
            e.preventDefault();
            const phone = this.querySelector('[data-type-phone]');
            if (phone) {
                const digits = phone.value.replace(/\D/g, '');
                if (digits.length !== 10) {
                    phone.setCustomValidity('Введите полный корректный номер телефона');
                    phone.reportValidity();
                    phone.focus();
                    return;
                }
            }
            const btn = this.querySelector('#submit-order');
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin w-5 h-5" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="31.4" stroke-dashoffset="10"/></svg> Оформляем...';
            fetch(this.action, { method: 'POST', body: new URLSearchParams(new FormData(this)) })
                .then(function(r){ return r.json(); })
                .then(function(d){
                    if (d.success) {
                        window.location.href = '/order/' + d.order_id + '/success';
                    } else {
                        alert(d.error || 'Ошибка оформления заказа');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-check-circle"></i> Оформить заказ';
                    }
                })
                .catch(function(){
                    alert('Ошибка отправки. Попробуйте ещё раз.');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-check-circle"></i> Оформить заказ';
                });
        });
    });
    </script>
</body>
</html>
