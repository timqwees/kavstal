<?php
$site = $site ?? Setting\route\function\Functions::site();
$cartCount = isset($cartCount) ? $cartCount : \App\Models\Cart\Cart::getCount();
?>
<!-- Top Bar -->
<div class="bg-gray-900 text-gray-300 text-xs hidden lg:block">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9">
        <div class="flex items-center space-x-4">
            <span><i class="far fa-clock mr-1"></i><?= htmlspecialchars($site['workingHours']) ?></span>
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
                <a href="/favorites" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                    <i class="far fa-heart"></i>
                </a>
                <a href="/contacts" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Контакты</a>
            </div>
            <div class="hidden lg:flex items-center space-x-4">
                <a href="/cart" class="relative p-2 text-gray-700 hover:text-red-600 transition" id="cart-header-icon">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1 cart-count-badge" id="cart-count-badge"><?= $cartCount ?></span>
                </a>
                <div class="text-right">
                    <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="text-lg font-bold text-gray-900 hover:text-red-600 transition whitespace-nowrap"><?= htmlspecialchars($site['phone']) ?></a>
                    <p class="text-xs text-gray-500"><?= htmlspecialchars($site['workingHours']) ?></p>
                </div>
                <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="bg-red-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-red-700 transition flex items-center gap-2">
                    <i class="fas fa-phone-alt"></i>
                    <span class="hidden xl:inline">Заказать звонок</span>
                </a>
            </div>
            <div class="lg:hidden flex items-center gap-3">
                <a href="/favorites" class="relative text-gray-700 p-2">
                    <i class="far fa-heart text-lg"></i>
                </a>
                <a href="/cart" class="relative text-gray-700 p-2">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span class="absolute -top-0.5 -right-0.5 bg-red-600 text-white text-[10px] font-bold rounded-full min-w-[16px] h-[16px] flex items-center justify-center px-0.5 cart-count-badge"><?= $cartCount ?></span>
                </a>
                <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="text-gray-700 p-2">
                    <i class="fas fa-phone-alt text-lg"></i>
                </a>
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
        <button class="mobile-menu-overlay-close text-gray-500 hover:text-gray-700 mb-6">
            <i class="fas fa-times text-xl"></i>
        </button>
        <nav class="space-y-2">
            <a href="/market" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Каталог</a>
            <a href="/services" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Услуги</a>
            <a href="/about" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">О компании</a>
            <a href="/delivery" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Доставка и оплата</a>
            <a href="/contacts" class="block py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">Контакты</a>
            <div class="border-t border-gray-200 my-4"></div>
            <a href="/favorites" class="flex items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">
                <i class="far fa-heart mr-3 text-red-600"></i>
                Избранное
            </a>
            <a href="/cart" class="flex items-center py-3 px-4 text-red-600 bg-red-50 rounded-lg font-medium">
                <i class="fas fa-shopping-cart mr-3"></i>
                Корзина <?= $cartCount > 0 ? '(' . $cartCount . ')' : '' ?>
            </a>
            <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="flex items-center py-3 px-4 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium">
                <i class="fas fa-phone-alt mr-3 text-red-600"></i>
                <?= htmlspecialchars($site['phone']) ?>
            </a>
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
