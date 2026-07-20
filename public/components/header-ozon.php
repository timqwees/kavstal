<?php
$site = $site ?? Setting\route\function\Functions::site();
$phone_clean = $site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone']);

// Load catalog data for mega-menu
$tree = \Setting\route\function\Functions::getCatalogTree();
$catalogCategories = $tree['categories'];
$catalogSubcategories = $tree['subcategories'];
?>
<link rel="stylesheet" href="/public/assets/styles/catalog-mega.min.css">
<!-- Top Bar -->
<div class="hidden lg:block bg-white border-b border-gray-200 text-xs text-gray-500">
  <div class="max-w-7xl mx-auto px-8 flex items-center justify-between h-9">
    <div class="flex items-center gap-6">
      <span class="flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        <?= htmlspecialchars($site['workingHours'] ?? 'Пн-Пт 9:00–18:00') ?>
      </span>
      <span class="flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
        Доставка по Москве и МО
      </span>
    </div>
    <div class="flex items-center gap-5">
      <a href="/blog" class="hover:text-red-500 transition-colors">Блоги</a>
      <a href="/delivery" class="hover:text-red-500 transition-colors">Доставка и оплата</a>
      <a href="/guarantees" class="hover:text-red-500 transition-colors">Гарантии</a>
      <a href="/contacts" class="hover:text-red-500 transition-colors">Контакты</a>
    </div>
  </div>
</div>
<!-- ===================== HEADER ===================== -->
<header class="ozon-header">
    <!-- Row 1: Logo + Search + Actions -->
    <div class="ozon-header-main">
        <div class="ozon-header-inner">
            <a href="/" class="ozon-logo">
                <img loading="lazy" src="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/logo/logo.webp" alt="<?= htmlspecialchars($site['company']) ?>">
            </a>
            <div class="ozon-search" id="searchWrap">
                <form method="GET" action="/market" id="searchForm">
                    <input type="text" name="search" id="searchInput" placeholder="Искать в каталоге" autocomplete="off">
                    <button type="submit" aria-label="Поиск" class="ozon-search-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.892 15.064a8 8 0 1 0-2.828 2.828l2.522 2.522a2 2 0 1 0 2.828-2.828zM11 16a5 5 0 1 1 0-10 5 5 0 0 1 0 10"/></svg>
                    </button>
                </form>
                <div id="searchDropdown" class="absolute left-0 right-0 top-full mt-1 bg-white border border-zinc-200 rounded-xl shadow-xl z-50 hidden overflow-y-auto max-h-[420px]"></div>
            </div>
            <button id="ozonCatalogToggle" class="ozon-catalog-btn" aria-label="Открыть каталог" aria-expanded="false">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 7.556C4 4.628 4.628 4 7.556 4s3.555.628 3.555 3.556-.627 3.555-3.555 3.555S4 10.484 4 7.556m0 8.888c0-2.928.628-3.555 3.556-3.555s3.555.627 3.555 3.555S10.484 20 7.556 20 4 19.372 4 16.444M16.444 4c-2.928 0-3.555.628-3.555 3.556s.627 3.555 3.555 3.555S20 10.484 20 7.556 19.372 4 16.444 4m-3.555 12.444c0-2.928.627-3.555 3.555-3.555S20 13.516 20 16.444 19.372 20 16.444 20s-3.555-.628-3.555-3.556"/></svg>
                <span>Каталог</span>
            </button>
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
                <a href="/blog" class="ozon-nav-link">Блог</a>
                <a href="/guarantees" class="ozon-nav-link">Гарантии</a>
            </div>

        </div>
    </div>
    <!-- Mega Menu -->
    <div class="ozon-mega-menu" id="ozonMegaMenu" style="display:none">
        <div class="ozon-mega-menu-inner">
            <div class="ozon-mega-sidebar" id="ozonMegaSidebar">
                <?php foreach ($catalogCategories as $i => $cat): ?>
                    <?php $catSlug = $cat['id'] ?? ''; ?>
                    <a href="/market/katalog/<?= htmlspecialchars($catSlug) ?>"
                       class="ozon-mega-item<?= $i === 0 ? ' active' : '' ?>"
                       data-category-id="<?= htmlspecialchars($catSlug) ?>"
                       data-href="/market/katalog/<?= htmlspecialchars($catSlug) ?>">
                        <span><?= htmlspecialchars($cat['name']) ?></span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="ozon-mega-content">
                <?php foreach ($catalogCategories as $i => $cat): ?>
                    <?php $catSlug = $cat['id'] ?? ''; ?>
                    <div class="ozon-mega-content-panel" data-category-id="<?= htmlspecialchars($catSlug) ?>" style="<?= $i === 0 ? 'display:block' : 'display:none' ?>">
                        <div class="ozon-mega-content-title"><?= htmlspecialchars($cat['name']) ?></div>
                        <div class="ozon-mega-grid">
                            <?php foreach ($catalogSubcategories[$catSlug] ?? [] as $sub): ?>
                                <?php $subSlug = $sub['categories']['id'] ?? ''; ?>
                                <?php $parentId = $sub['categories']['parent_id'] ?? ''; ?>
                                <?php $subImages = $sub['images'] ?? []; ?>
                                <?php $img = $subImages[0] ?? ''; ?>
                                <a href="/market/katalog/<?= htmlspecialchars($parentId) ?>/<?= htmlspecialchars($subSlug) ?>" class="ozon-mega-subcategory">
                                    <?php if ($img): ?>
                                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-zinc-100 flex-shrink-0">
                                            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($sub['name']) ?>" class="w-full h-full object-contain" loading="lazy">
                                        </div>
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($sub['name']) ?></span>
                                </a>
                                <?php endforeach; ?>
                            </div>
                            <a href="/market/katalog/<?= htmlspecialchars($catSlug) ?>" class="ozon-mega-all-link">Показать все в категории &rarr;</a>
                        </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Bottom Bar -->
<?php
$curPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$bnmActive = function($paths) use ($curPath) {
    $paths = (array)$paths;
    foreach ($paths as $p) {
        if ($p === '/') { if ($curPath === '/' || $curPath === '') return true; }
        elseif ($p !== '/' && $curPath === $p) return true;
        elseif ($p !== '/' && $curPath !== '/' && strpos($curPath, $p . '/') === 0) return true;
    }
    return false;
};
$bnmCls = function($paths) use ($bnmActive) {
    return $bnmActive($paths) ? 'text-red-500 bg-red-50 rounded-[10px]' : 'text-gray-400 hover:text-red-500';
};
?>
<div class="lg:hidden fixed bottom-0 left-0 right-0 z-[99] bg-white border-t border-gray-200 flex justify-around py-1.5">
    <a href="/" class="flex flex-col items-center gap-0.5 no-underline text-[10px] font-medium py-1 px-3 <?= $bnmCls('/') ?>">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        Главная
    </a>
    <a href="/market" class="flex flex-col items-center gap-0.5 no-underline text-[10px] font-medium py-1 px-3 <?= $bnmCls(['/market']) ?>">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="15" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        Маркет
    </a>
    <a href="/favorites" class="flex flex-col items-center gap-0.5 no-underline text-[10px] font-medium py-1 px-3 <?= $bnmCls(['/favorites']) ?>">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        Избранное
    </a>
    <a href="/cart" class="relative flex flex-col items-center gap-0.5 no-underline text-[10px] font-medium py-1 px-3 <?= $bnmCls(['/cart']) ?>">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        <span class="cart-count-badge absolute -top-0.5 right-0 bg-red-500 text-white text-[9px] font-bold rounded-full min-w-[14px] h-3.5 items-center justify-center px-0.5 hidden"></span>
        Корзина
    </a>
    <a href="/orders" class="flex flex-col items-center gap-0.5 no-underline text-[10px] font-medium py-1 px-3 <?= $bnmCls(['/orders']) ?>">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.692 5.694c.368-.205.365-.469-.009-.664C13.367 4.343 12.708 4 12 4s-1.367.343-2.683 1.03l-2 1.044c-1.614.842-2.42 1.263-2.869 2.02C4 8.85 4 9.79 4 11.673v1.652c0 1.883 0 2.824.448 3.58s1.255 1.178 2.869 2.02l2 1.044C10.633 20.657 11.292 21 12 21s1.367-.343 2.683-1.03l2-1.044c1.614-.842 2.42-1.263 2.869-2.02.448-.756.448-1.697.448-3.58v-1.652c0-1.883 0-2.824-.448-3.58-.329-.556-.851-.93-1.744-1.423-.367-.203-.389-.204-.763.004L11 10c-.344.19-.739.394-.91.77-.09.197-.09.375-.09.73V14a1 1 0 0 1-2 0v-4a1 1 0 0 1 .514-.874z"/></svg>
        Заказы
    </a>
</div>

<script src="/public/assets/scripts/components/catalog-mega.min.js" defer></script>
