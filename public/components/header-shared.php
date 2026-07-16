<?php
$site = $site ?? Setting\route\function\Functions::site();
$cartCount = isset($cartCount) ? $cartCount : \App\Models\Cart\Cart::getCount();
$phone_clean = $site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone']);

// Load catalog data for mega-menu
$allProducts = \Setting\route\function\Functions::listProducts();
$catalogCategories = [];
$catalogSubcategories = [];
foreach ($allProducts as $p) {
    if (($p['badge'] ?? '') === 'Категория') {
        $catalogCategories[] = $p;
    }
    if (($p['badge'] ?? '') === 'Подкатегория') {
        $parentId = $p['categories']['parent_id'] ?? '';
        $catalogSubcategories[$parentId][] = $p;
    }
}
?>
<!-- Top Bar -->
<div class="hidden lg:block bg-white border-b border-gray-200 text-xs text-gray-500">
  <div class="max-w-7xl mx-auto px-8 flex items-center justify-between h-9">
    <div class="flex items-center gap-6">
      <span class="flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <?= htmlspecialchars($site['workingHours'] ?? 'Пн-Пт 09:00-18:00') ?>
      </span>
      <span class="flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        Доставка по Москве и МО
      </span>
    </div>
    <div class="flex items-center gap-5">
      <a href="/delivery" class="hover:text-red-600 transition-colors">Доставка и оплата</a>
      <a href="/guarantees" class="hover:text-red-600 transition-colors">Гарантии</a>
      <a href="/contacts" class="hover:text-red-600 transition-colors">Контакты</a>
    </div>
  </div>
</div>

<!-- Header -->
<header class="sticky top-0 z-50 bg-white border-b border-gray-200">
  <div class="max-w-7xl mx-auto px-4 lg:px-8 flex items-center h-16 lg:h-16">
    <a href="/" class="flex-shrink-0 mr-6 lg:mr-8">
      <img class="h-9 lg:h-10 block" src="<?= $site['baseUrl'] ?>/public/assets/images/icons/logo/logo.svg" alt="<?= htmlspecialchars($site['company']) ?>">
    </a>

    <!-- Search (like market) -->
    <div class="hidden lg:flex flex-1 max-w-xl relative mr-4" id="searchWrap">
      <form method="GET" action="/market" class="flex items-center w-full">
        <input type="text" name="search" id="searchInput" placeholder="Искать в каталоге" autocomplete="off" class="w-full h-11 px-4 pr-12 bg-gray-100 border border-transparent rounded-xl text-sm outline-none focus:border-red-500 focus:bg-white transition-colors">
        <button type="submit" aria-label="Поиск" class="absolute right-0 top-0 bottom-0 w-12 flex items-center justify-center bg-transparent border-none text-gray-400 hover:text-red-500 cursor-pointer border-l border-gray-200 transition-colors">
          <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="currentColor"><path d="M17.892 15.064a8 8 0 1 0-2.828 2.828l2.522 2.522a2 2 0 1 0 2.828-2.828zM11 16a5 5 0 1 1 0-10 5 5 0 0 1 0 10"/></svg>
        </button>
      </form>
      <div id="searchDropdown" class="absolute left-0 right-0 top-full mt-1 bg-white border border-zinc-200 rounded-xl shadow-xl z-50 hidden overflow-hidden"></div>
    </div>

    <!-- Nav -->
    <nav class="hidden lg:flex items-center gap-1 mr-auto">
      <a href="/market" class="px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-red-50 transition-colors">Маркет</a>

      <!-- Ещё dropdown -->
      <div class="relative group">
        <button class="px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-red-50 transition-colors inline-flex items-center gap-1 cursor-pointer bg-transparent border-none">
          Ещё
          <svg class="w-3 h-3 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div class="absolute left-0 top-full pt-1 hidden group-hover:block z-50">
          <div class="bg-white rounded-xl shadow-lg border border-gray-100 py-2 min-w-[200px]">
            <a href="/contacts" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">Контакты</a>
            <a href="/delivery" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">Доставка и оплата</a>
            <a href="/about" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">О компании</a>
            <a href="/guarantees" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">Гарантии</a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Right -->
    <div class="flex items-center gap-1 ml-auto">
      <a href="tel:<?= htmlspecialchars($phone_clean) ?>" class="hidden lg:block text-sm font-bold text-gray-900 hover:text-red-600 whitespace-nowrap mr-3"><?= htmlspecialchars($site['phone']) ?></a>

      <a href="/favorites" class="relative w-10 h-10 flex items-center justify-center rounded-lg text-gray-600 hover:text-red-600 transition-colors" aria-label="Избранное">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        <span id="favCountBadge" class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[10px] font-bold rounded-full min-w-[16px] h-4 items-center justify-center px-1" style="display:none"></span>
      </a>

      <a href="/cart" class="relative w-10 h-10 flex items-center justify-center rounded-lg text-gray-600 hover:text-red-600 transition-colors" aria-label="Корзина">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        <span class="cart-count-badge absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[10px] font-bold rounded-full min-w-[16px] h-4 items-center justify-center px-1" style="display:none"><?= $cartCount ?></span>
      </a>

      <a href="/orders" class="hidden lg:flex w-10 h-10 items-center justify-center rounded-lg text-gray-600 hover:text-red-600 transition-colors" aria-label="Заказы">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.692 5.694c.368-.205.365-.469-.009-.664C13.367 4.343 12.708 4 12 4s-1.367.343-2.683 1.03l-2 1.044c-1.614.842-2.42 1.263-2.869 2.02C4 8.85 4 9.79 4 11.673v1.652c0 1.883 0 2.824.448 3.58s1.255 1.178 2.869 2.02l2 1.044C10.633 20.657 11.292 21 12 21s1.367-.343 2.683-1.03l2-1.044c1.614-.842 2.42-1.263 2.869-2.02.448-.756.448-1.697.448-3.58v-1.652c0-1.883 0-2.824-.448-3.58-.329-.556-.851-.93-1.744-1.423-.367-.203-.389-.204-.763.004L11 10c-.344.19-.739.394-.91.77-.09.197-.09.375-.09.73V14a1 1 0 0 1-2 0v-4a1 1 0 0 1 .514-.874z"/></svg>
      </a>

      <a href="tel:<?= htmlspecialchars($phone_clean) ?>" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg text-gray-600" aria-label="Позвонить">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      </a>

      <button class="lg:hidden relative w-10 h-10 flex flex-col items-center justify-center gap-1 bg-transparent border-none cursor-pointer" aria-label="Меню">
        <span class="block w-5 h-0.5 bg-gray-800 rounded"></span>
        <span class="block w-5 h-0.5 bg-gray-800 rounded"></span>
        <span class="block w-5 h-0.5 bg-gray-800 rounded"></span>
      </button>
    </div>
  </div>
</header>

<!-- Mobile Overlay -->
<div class="mobile-overlay fixed inset-0 z-[200] bg-black/40 hidden">
  <div class="absolute right-0 top-0 bottom-0 w-72 bg-white p-5 overflow-y-auto">
    <button class="mobile-close w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 border-none cursor-pointer mb-5" aria-label="Закрыть">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
    </button>
    <nav class="flex flex-col gap-1">
      <a href="/market" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="15" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        Маркет
      </a>
      <a href="/contacts" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
        Контакты
      </a>
      <a href="/about" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">О компании</a>
      <a href="/delivery" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">Доставка и оплата</a>
      <a href="/guarantees" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">Гарантии</a>
      <div class="border-t border-gray-100 my-2"></div>
      <a href="/favorites" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        Избранное
      </a>
      <a href="/cart" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 bg-red-50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        Корзина <span class="cart-count-badge ml-1 text-[11px]" style="display:none"></span>
      </a>
      <a href="/orders" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.692 5.694c.368-.205.365-.469-.009-.664C13.367 4.343 12.708 4 12 4s-1.367.343-2.683 1.03l-2 1.044c-1.614.842-2.42 1.263-2.869 2.02C4 8.85 4 9.79 4 11.673v1.652c0 1.883 0 2.824.448 3.58s1.255 1.178 2.869 2.02l2 1.044C10.633 20.657 11.292 21 12 21s1.367-.343 2.683-1.03l2-1.044c1.614-.842 2.42-1.263 2.869-2.02.448-.756.448-1.697.448-3.58v-1.652c0-1.883 0-2.824-.448-3.58-.329-.556-.851-.93-1.744-1.423-.367-.203-.389-.204-.763.004L11 10c-.344.19-.739.394-.91.77-.09.197-.09.375-.09.73V14a1 1 0 0 1-2 0v-4a1 1 0 0 1 .514-.874z"/></svg>
        Заказы
      </a>
      <a href="tel:<?= htmlspecialchars($phone_clean) ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-bold text-red-600 mt-2 border border-red-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        <?= htmlspecialchars($site['phone']) ?>
      </a>
    </nav>
  </div>
</div>

<!-- Mobile Bottom Bar -->
<div class="lg:hidden fixed bottom-0 left-0 right-0 z-[99] bg-white border-t border-gray-200 flex justify-around py-1.5">
  <a href="/" class="flex flex-col items-center gap-0.5 text-red-500 no-underline text-[10px] font-medium py-1 px-3">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
    Главная
  </a>
  <a href="/market" class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-red-500 no-underline text-[10px] font-medium py-1 px-3">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="15" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
    Маркет
  </a>
  <a href="/favorites" class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-red-500 no-underline text-[10px] font-medium py-1 px-3">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
    Избранное
  </a>
  <a href="/cart" class="relative flex flex-col items-center gap-0.5 text-gray-400 hover:text-red-500 no-underline text-[10px] font-medium py-1 px-3">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
    <span class="cart-count-badge absolute -top-0.5 right-0 bg-red-500 text-white text-[9px] font-bold rounded-full min-w-[14px] h-3.5 items-center justify-center px-0.5 hidden" style="display:none"></span>
    Корзина
  </a>
  <a href="/orders" class="flex flex-col items-center gap-0.5 text-gray-400 hover:text-red-500 no-underline text-[10px] font-medium py-1 px-3">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.692 5.694c.368-.205.365-.469-.009-.664C13.367 4.343 12.708 4 12 4s-1.367.343-2.683 1.03l-2 1.044c-1.614.842-2.42 1.263-2.869 2.02C4 8.85 4 9.79 4 11.673v1.652c0 1.883 0 2.824.448 3.58s1.255 1.178 2.869 2.02l2 1.044C10.633 20.657 11.292 21 12 21s1.367-.343 2.683-1.03l2-1.044c1.614-.842 2.42-1.263 2.869-2.02.448-.756.448-1.697.448-3.58v-1.652c0-1.883 0-2.824-.448-3.58-.329-.556-.851-.93-1.744-1.423-.367-.203-.389-.204-.763.004L11 10c-.344.19-.739.394-.91.77-.09.197-.09.375-.09.73V14a1 1 0 0 1-2 0v-4a1 1 0 0 1 .514-.874z"/></svg>
    Заказы
  </a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var overlay = document.querySelector('.mobile-overlay');
  var opens = document.querySelectorAll('.burger-btn, .burger');
  var close = document.querySelector('.mobile-close');
  opens.forEach(function(b){ b.addEventListener('click', function(){ overlay.classList.remove('hidden'); document.body.classList.add('overflow-hidden'); }); });
  close.addEventListener('click', function(){ overlay.classList.add('hidden'); document.body.classList.remove('overflow-hidden'); });
  overlay.addEventListener('click', function(e){ if(e.target===overlay){ overlay.classList.add('hidden'); document.body.classList.remove('overflow-hidden'); } });
});
</script>
