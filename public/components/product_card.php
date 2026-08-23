<?php
/**
 * Единая карточка товара для всего сайта.
 * Ожидает переменные:
 *   $product - массив товара (id, name/title, images[], units[], specs[], in_stock, seo.canonicalUrl, badge)
 *   $idx     - индекс в цикле (для fetchpriority)
 *   $site    - массив сайта (baseUrl)
 * Опции (массив $cardOpts):
 *   filter  => true - добавить data-атрибуты для клиентской фильтрации (категории)
 *   qty     => true - показать степпер количества и select единиц
 *   swiper  => true - мультифото через swiper
 *   itemscope => true - schema.org разметка
 */
$cardCanonical = $product['seo']['canonicalUrl'] ?? '#';
$cardUnits = $product['units'] ?? [];
$idx = $idx ?? 0;
$cardFirstUnit = !empty($cardUnits) ? array_key_first($cardUnits) : '';
$cardFirstPrice = $cardFirstUnit !== '' && is_numeric($cardUnits[$cardFirstUnit] ?? null) ? number_format((float) $cardUnits[$cardFirstUnit], 0, '', ' ') : '0';
$cardFirstPriceRaw = $cardFirstUnit !== '' && is_numeric($cardUnits[$cardFirstUnit] ?? null) ? (float) $cardUnits[$cardFirstUnit] : 0;
$cardImages = $product['images'] ?? [];
if (empty($cardImages))
    $cardImages = [$site['baseUrl'] . '/public/assets/images/unknown/unknown.png'];
$cardInStock = $product['in_stock'] ?? false;
$cardName = htmlspecialchars($product['name'] ?? $product['title'] ?? 'Товар');
$cardPid = htmlspecialchars((string) ($product['id'] ?? ''));
$cardOpts = $cardOpts ?? [];
$cardFilter = !empty($cardOpts['filter']);
$cardQty = !empty($cardOpts['qty']);
$cardSwiper = !empty($cardOpts['swiper']) && count($cardImages) > 1;
$cardItemscope = array_key_exists('itemscope', $cardOpts) ? !empty($cardOpts['itemscope']) : true;

$cardSpecs = $product['specs'] ?? [];
$cardDiameter = $cardSpecs['диаметр'] ?? '';
$cardBrand = $cardSpecs['Марка'] ?? $cardSpecs['марка'] ?? '';
$cardGost = $cardSpecs['ГОСТ'] ?? $cardSpecs['гост'] ?? '';
$cardRazmer = $cardSpecs['Размер'] ?? '';
$cardRal = '';
if (preg_match('/\bRAL\s*(\d{4})\b/i', (string) $cardBrand, $mRal1)) {
    $cardRal = 'RAL ' . $mRal1[1];
} elseif (preg_match('/\bRAL\s*(\d{4})\b/i', (string) ($product['name'] ?? $product['title'] ?? ''), $mRal2)) {
    $cardRal = 'RAL ' . $mRal2[1];
}
?>
<div class="product-card bg-white rounded-xl border border-zinc-200 hover:border-zinc-300 transition-all duration-200 flex flex-col w-full p-3"
    <?= $cardFilter ? 'data-diameter="' . htmlspecialchars($cardDiameter) . '" data-brand="' . htmlspecialchars($cardBrand) . '" data-gost="' . htmlspecialchars($cardGost) . '" data-ral="' . htmlspecialchars($cardRal) . '"' : '' ?>
    <?= $cardItemscope ? 'itemscope itemtype="https://schema.org/Product"' : '' ?>
    data-pid="<?= $cardPid ?>">

    <meta itemprop="category" content="Строительные материалы">
    <meta itemprop="productID" content="<?= $cardPid ?>">

    <!-- Header: Badge + Fav -->
    <div class="flex items-start justify-between gap-2 mb-2">
        <span class="bg-red-500 text-white text-[11px] px-2 py-0.5 rounded-md font-semibold flex-shrink-0 leading-relaxed">
            <?= !empty($product['badge']) ? htmlspecialchars($product['badge']) : ($cardInStock ? 'Уточняйте наличие' : 'Под заказ') ?>
        </span>
        <button type="button" class="add-to-fav-btn min-h-[44px] min-w-[44px] w-7 h-7 rounded-md border border-zinc-200 flex items-center justify-center shrink-0 hover:border-zinc-400 hover:bg-zinc-50 transition-colors" data-pid="<?= $cardPid ?>" title="В избранное">
            <svg width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.5 10.01l-5.657 3.14a.584.584 0 0 1-.779-.205.54.54 0 0 1-.076-.277V3.61c0-.295.12-.577.335-.786A1.16 1.16 0 0 1 1.843 2.5c.922 0 1.823.435 2.657 1.268a.88.88 0 0 1 .082 1.067c-.47.722-1.285 1.333-2.018 1.626a.88.88 0 0 1-1.134 0L6.5 1.01V10.01z" stroke="#a1a1aa" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>

    <!-- Image -->
    <a href="<?= htmlspecialchars($cardCanonical) ?>"
        class="product-card-image card-image flex items-center justify-center mb-3 rounded-lg overflow-hidden bg-zinc-50">
        <?php if ($cardSwiper): ?>
            <div class="swiper product-swiper w-full h-full" data-product-id="<?= $cardPid ?>">
                <div class="swiper-wrapper">
                    <?php foreach ($cardImages as $imgIdx => $imgUrl): ?>
                        <div class="swiper-slide flex justify-center items-center">
                            <img <?= $idx === 0 && $imgIdx === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>
                                src="<?= htmlspecialchars($imgUrl) ?>"
                                alt="<?= $cardName ?> - фото <?= $imgIdx + 1 ?>" width="120" height="120"
                                class="max-h-full max-w-full object-contain p-2" style="width: 100%;">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <img <?= $idx === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>
                src="<?= htmlspecialchars($cardImages[0]) ?>" alt="<?= $cardName ?>" width="120" height="120"
                class="max-h-full max-w-full object-contain p-2" style="width: 100%;">
        <?php endif; ?>
    </a>

    <!-- Info -->
    <div class="card-body flex-1 flex flex-col min-w-0">
        <a href="<?= htmlspecialchars($cardCanonical) ?>">
            <h3 class="text-[13px] font-semibold text-zinc-800 hover:text-red-500 transition-colors line-clamp-2 leading-snug mb-2 block min-h-[36px]"><?= $cardName ?></h3>
        </a>

        <!-- Specs -->
        <div class="flex flex-wrap gap-1 mb-2">
            <?php if ($cardBrand): ?>
                <span class="text-[10px] text-zinc-500 bg-zinc-50 border border-zinc-100 px-1.5 py-0.5 rounded-md font-medium">Марка: <strong class="text-zinc-700"><?= htmlspecialchars($cardBrand) ?></strong></span>
            <?php endif; ?>
            <?php if ($cardRazmer): ?>
                <span class="text-[10px] text-zinc-500 bg-zinc-50 border border-zinc-100 px-1.5 py-0.5 rounded-md font-medium">Размер: <strong class="text-zinc-700"><?= htmlspecialchars($cardRazmer) ?></strong></span>
            <?php endif; ?>
            <?php if ($cardGost): ?>
                <span class="text-[10px] text-zinc-500 bg-zinc-50 border border-zinc-100 px-1.5 py-0.5 rounded-md font-medium">ГОСТ: <strong class="text-zinc-700"><?= htmlspecialchars($cardGost) ?></strong></span>
            <?php endif; ?>
            <?php if ($cardDiameter): ?>
                <span class="text-[10px] text-zinc-500 bg-zinc-50 border border-zinc-100 px-1.5 py-0.5 rounded-md font-medium">Ø: <strong class="text-zinc-700"><?= htmlspecialchars($cardDiameter) ?></strong></span>
            <?php endif; ?>
        </div>

        <!-- Price & Cart -->
        <div class="mt-auto">
            <div class="flex items-center gap-1.5 mb-2">
                <span class="inline-block w-1.5 h-1.5 rounded-full <?= $cardInStock ? 'bg-emerald-500' : 'bg-zinc-300' ?>"></span>
                <span class="text-[11px] font-medium <?= $cardInStock ? 'text-amber-600' : 'text-zinc-400' ?>"><?= $cardInStock ? 'Уточняйте наличие' : 'Под заказ' ?></span>
            </div>
            <?php if (!empty($cardUnits)): ?>
                <div itemprop="offers" itemscope itemtype="https://schema.org/Offer" class="mb-2">
                    <meta itemprop="priceCurrency" content="RUB">
                    <meta itemprop="availability" content="<?= $cardInStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' ?>">
                    <div itemprop="price" content="<?= $cardFirstPriceRaw ?>" class="price-display text-[15px] font-bold text-zinc-900 leading-tight"><?= $cardFirstPrice ?> <span class="text-[11px] font-normal text-zinc-400">₽<?= $cardFirstUnit !== '' ? '/<span class="unit-label bg-red-100 text-red-500 text-[10px] font-medium px-1.5 py-0.5 rounded align-middle">' . htmlspecialchars($cardFirstUnit) . '</span>' : '' ?></span></div>
                </div>
            <?php else: ?>
                <div class="text-[13px] text-zinc-400 mb-2">Цена по запросу</div>
            <?php endif; ?>

            <!-- Add to Cart -->
            <div class="flex items-center gap-2">
                <?php if ($cardQty): ?>
                    <div class="flex items-center border border-zinc-200 rounded-lg overflow-hidden">
                        <button type="button" class="qty-btn w-6 h-7 flex items-center justify-center text-zinc-400 hover:text-zinc-700 hover:bg-zinc-50 transition border-r border-zinc-200 bg-transparent cursor-pointer" data-dir="minus">
                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12" /></svg>
                        </button>
                        <input type="number" value="1" min="1" class="cart-qty w-9 h-7 text-center text-[11px] border-0 focus:outline-none focus:ring-0" data-pid="<?= $cardPid ?>">
                        <button type="button" class="qty-btn w-6 h-7 flex items-center justify-center text-zinc-400 hover:text-zinc-700 hover:bg-zinc-50 transition border-l border-zinc-200 bg-transparent cursor-pointer" data-dir="plus">
                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                        </button>
                    </div>
                    <?php if (count($cardUnits) > 1): ?>
                        <select class="cart-unit h-7 px-1.5 border border-zinc-200 rounded-lg text-[10px] bg-white focus:outline-none focus:border-red-400" data-pid="<?= $cardPid ?>">
                            <?php foreach ($cardUnits as $u => $p): ?>
                                <option value="<?= htmlspecialchars($u) ?>" <?= $u === $cardFirstUnit ? 'selected' : '' ?>><?= htmlspecialchars($u) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <span class="text-[10px] text-zinc-400 w-7 shrink-0 text-center"></span>
                    <?php endif; ?>
                <?php endif; ?>
                <button type="button" class="add-to-cart-btn ml-auto w-8 h-8 rounded-full bg-red-500 hover:bg-red-500 active:bg-red-500 text-white flex items-center justify-center shrink-0 transition-colors" data-pid="<?= $cardPid ?>" data-unit="<?= htmlspecialchars($cardFirstUnit) ?>" title="В заявку">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
<?php if (empty($GLOBALS['__card_scripts_rendered'])): $GLOBALS['__card_scripts_rendered'] = true; ?>
<script>
document.addEventListener('click', function(e) {
    var btn = e.target.closest('.unit-btn');
    if (!btn) return;
    var parent = btn.parentElement;
    if (parent) {
        parent.querySelectorAll('.unit-btn').forEach(function(b) {
            b.classList.remove('bg-red-100', 'text-red-500');
            b.classList.add('bg-zinc-100', 'text-zinc-500');
        });
        btn.classList.remove('bg-zinc-100', 'text-zinc-500');
        btn.classList.add('bg-red-100', 'text-red-500');
    }
    var card = btn.closest('.product-card');
    if (card) {
        var pd = card.querySelector('.price-display');
        if (pd) pd.innerHTML = Math.round(parseFloat(btn.dataset.price)).toLocaleString('ru-RU') + ' <span class="text-sm font-normal text-zinc-500">₽/<span class="unit-label bg-red-100 text-red-500 text-[10px] font-medium px-1.5 py-0.5 rounded align-middle">' + btn.dataset.unit + '</span></span>';
        var unitSelect = card.querySelector('.cart-unit');
        if (unitSelect) unitSelect.value = btn.dataset.unit;
        var cartBtn = card.querySelector('.add-to-cart-btn');
        if (cartBtn) cartBtn.dataset.unit = btn.dataset.unit;
    }
});
</script>
<?php endif; ?>
