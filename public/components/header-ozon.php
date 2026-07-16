<?php
$site = $site ?? Setting\route\function\Functions::site();
$phone_clean = $site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone']);
?>
<!-- ===================== HEADER ===================== -->
<header class="ozon-header">
    <!-- Row 1: Logo + Search + Actions -->
    <div class="ozon-header-main">
        <div class="ozon-header-inner">
            <button class="ozon-burger mobile-menu-toggle" aria-label="Открыть меню">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <a href="/" class="ozon-logo">
                <img loading="lazy" src="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.svg" alt="<?= htmlspecialchars($site['company']) ?>">
            </a>
            <a href="/market" class="ozon-catalog-btn">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 7.556C4 4.628 4.628 4 7.556 4s3.555.628 3.555 3.556-.627 3.555-3.555 3.555S4 10.484 4 7.556m0 8.888c0-2.928.628-3.555 3.556-3.555s3.555.627 3.555 3.555S10.484 20 7.556 20 4 19.372 4 16.444M16.444 4c-2.928 0-3.555.628-3.555 3.556s.627 3.555 3.555 3.555S20 10.484 20 7.556 19.372 4 16.444 4m-3.555 12.444c0-2.928.627-3.555 3.555-3.555S20 13.516 20 16.444 19.372 20 16.444 20s-3.555-.628-3.555-3.556"/></svg>
                <span>Каталог</span>
            </a>
            <div class="ozon-search" id="searchWrap">
                <form method="GET" action="/market" id="searchForm">
                    <input type="text" name="search" id="searchInput" placeholder="Искать в каталоге" autocomplete="off">
                    <button type="submit" aria-label="Поиск" class="ozon-search-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.892 15.064a8 8 0 1 0-2.828 2.828l2.522 2.522a2 2 0 1 0 2.828-2.828zM11 16a5 5 0 1 1 0-10 5 5 0 0 1 0 10"/></svg>
                    </button>
                </form>
                <div id="searchDropdown" class="absolute left-0 right-0 top-full mt-1 bg-white border border-zinc-200 rounded-xl shadow-xl z-50 hidden overflow-hidden"></div>
            </div>
            <a href="/cart" class="ozon-header-action">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9.925 5.371a1 1 0 1 0-1.858-.742L6.317 9h-1.2c-1.076 0-1.614 0-1.913.346-.3.346-.222.878-.067 1.942l.271 1.864c.475 3.265.902 4.898 2.03 5.873s2.778.975 6.08.975h.96c3.302 0 4.953 0 6.08-.975 1.128-.975 1.559-2.608 2.034-5.873l.271-1.864c.155-1.064.233-1.596-.067-1.942S19.96 9 18.883 9h-1.205l-1.75-4.371a1 1 0 0 0-1.857.742L15.523 9h-7.05zM10.997 14v2a1 1 0 0 1-2 0v-2a1 1 0 0 1 2 0M14 13a1 1 0 0 1 1 1v2a1 1 0 0 1-2 0v-2a1 1 0 0 1 1-1"/></svg>
                <span class="ozon-cart-badge cart-count-badge" style="display:none;">0</span>
                <span>Корзина</span>
            </a>
            <a href="/favorites" class="ozon-header-action" id="headerFavBtn">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 10.163C3 7.262 5.13 5 8 5c1.929 0 3.244 1.102 4 2.066C12.756 6.102 14.071 5 16 5c2.87 0 5 2.264 5 5.163 0 4.561-4.568 7.856-8.243 9.66a1.71 1.71 0 0 1-1.514 0C7.568 18.02 3 14.724 3 10.163"/></svg>
                <span class="ozon-cart-badge" id="favCountBadge" style="display:none;">0</span>
                <span>Избранное</span>
            </a>
            <a href="/orders" class="ozon-header-action">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14.692 5.694c.368-.205.365-.469-.009-.664C13.367 4.343 12.708 4 12 4s-1.367.343-2.683 1.03l-2 1.044c-1.614.842-2.42 1.263-2.869 2.02C4 8.85 4 9.79 4 11.673v1.652c0 1.883 0 2.824.448 3.58s1.255 1.178 2.869 2.02l2 1.044C10.633 20.657 11.292 21 12 21s1.367-.343 2.683-1.03l2-1.044c1.614-.842 2.42-1.263 2.869-2.02.448-.756.448-1.697.448-3.58v-1.652c0-1.883 0-2.824-.448-3.58-.329-.556-.851-.93-1.744-1.423-.367-.203-.389-.204-.763.004L11 10c-.344.19-.739.394-.91.77-.09.197-.09.375-.09.73V14a1 1 0 0 1-2 0v-4a1 1 0 0 1 .514-.874z"/></svg>
                <span>Заказы</span>
            </a>
        </div>
    </div>
    <!-- Row 2: Nav links -->
    <div class="ozon-header-nav">
        <div class="ozon-header-nav-inner">
            <div class="ozon-header-nav-links">
                <a href="tel:<?= $phone_clean ?>" class="ozon-nav-link ozon-nav-phone">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.36 11.36 0 003.58.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.57 3.58 1 1 0 01-.25 1.01l-2.2 2.2z"/></svg>
                    <?= htmlspecialchars($site['phone']) ?>
                </a>
                <span class="ozon-nav-sep"></span>
                <a href="/delivery" class="ozon-nav-link">Доставка</a>
                <a href="/contacts" class="ozon-nav-link">Контакты</a>
                <a href="/about" class="ozon-nav-link">О компании</a>
            </div>
            <div class="ozon-header-nav-right">
                <span class="ozon-nav-text"><?= htmlspecialchars($site['workingHours'] ?? 'Пн-Пт 9:00–18:00') ?></span>
                <span class="ozon-nav-dot">·</span>
                <span class="ozon-nav-text">Москва и МО</span>
            </div>
        </div>
    </div>
</header>
