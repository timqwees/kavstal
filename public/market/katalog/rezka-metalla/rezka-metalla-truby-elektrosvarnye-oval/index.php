<?php
// =====================
// Универсальный шаблон подкатегории
// Получаем все товары и фильтруем по текущей подкатегории
$allProducts = Setting\route\function\Functions::listProducts();

// Фильтруем товары текущей подкатегории
$tableProducts = array_filter($allProducts, function ($p) use ($tableName) {
    $catId = $p['categories']['id'] ?? '';
    return $catId === $tableName && empty($p['badge']); // только товары (не категории/подкатегории)
});

// Сбрасываем ключи массива для корректного отображения
$tableProducts = array_values($tableProducts);

// Автогенерация страниц всех товаров подкатегории
foreach ($tableProducts as $productItem) {
    $productId = $productItem['id'] ?? null;
    $productCat = $productItem['categories'] ?? [];
    $parentCatId = $productCat['parent_id'] ?? $katalog ?? '';
    $subCatId = $productCat['id'] ?? $tableName;

    if ($productId && $subCatId) {
        $productPath = "./public/market/katalog/$parentCatId/$subCatId/$productId/index.php";
        if (!file_exists($productPath)) {
            Setting\route\function\Functions::autoGeneratePage(
                $productPath,
                [
                    'katalog' => $parentCatId,
                    'subcategory' => $subCatId,
                    'name' => $productId
                ]
            );
        }
    }
}

// Ищем информацию о подкатегории в виртуальных записях
$subcategoryInfo = null;
foreach ($allProducts as $p) {
    if (($p['badge'] ?? '') === 'Подкатегория' && ($p['id'] ?? '') === $tableName) {
        $subcategoryInfo = $p;
        break;
    }
}

// Берём информацию о подкатегории
$firstRow = $tableProducts[0] ?? [];
$INFO = [
    'id' => $tableName,
    'title' => $subcategoryInfo['title'] ?? $firstRow['categories']['subcategory_title'] ?? 'Категория',
    'name' => $subcategoryInfo['name'] ?? $firstRow['categories']['subcategory_title'] ?? 'Категория',
    'description' => $firstRow['description'] ?? '',
    'seo' => $subcategoryInfo['seo'] ?? $firstRow['seo'] ?? ['canonicalUrl' => '/market/katalog/' . ($katalog ?? '') . '/' . $tableName],
    'categories' => $subcategoryInfo['categories'] ?? $firstRow['categories'] ?? ['parent_id' => $katalog],
];

$site = Setting\route\function\Functions::site();
// =====================
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($INFO['title'] ?? 'Категория') ?> | Купить в Москве | КАВ СТАЛЬ</title>
    <meta name="description"
        content="<?= htmlspecialchars($INFO['description'] ?? ($INFO['title'] ?? '') . ' - купить в Москве по выгодной цене. Поставка металлопроката от КАВ СТАЛЬ.') ?>">
    <meta name="keywords"
        content="<?= htmlspecialchars($INFO['title'] ?? '') ?>, <?= htmlspecialchars($INFO['name'] ?? $INFO['title'] ?? '') ?>, купить <?= htmlspecialchars($INFO['title'] ?? '') ?> в Москве, <?= htmlspecialchars($INFO['title'] ?? '') ?> цена за тонну, металлопрокат москва, сортовой прокат, доставка металлопроката, <?= htmlspecialchars($INFO['categories']['title'] ?? '') ?>">
    <link rel="canonical"
        href="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($INFO['seo']['canonicalUrl'] ?? '/market') ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= htmlspecialchars($INFO['title'] ?? 'Категория') ?> | КАВ СТАЛЬ">
    <meta property="og:description" content="<?= htmlspecialchars($INFO['description'] ?? ($INFO['title'] ?? '')) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url"
        content="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($INFO['seo']['canonicalUrl'] ?? '/market') ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company'] ?? 'КАВ СТАЛЬ') ?>">
    <meta property="og:locale" content="ru_RU">

    <!-- Additional SEO Meta Tags -->
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= htmlspecialchars($site['company'] ?? 'КАВ СТАЛЬ') ?>">

    <!-- favicon -->
    <link rel="icon" type="image/png"
        href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml"
        href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon.svg" />
    <link rel="shortcut icon" href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Металл" />
    <link rel="manifest" href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/site.webmanifest" />


    <!-- Structured Data JSON-LD -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "CollectionPage",
            "name": "<?= htmlspecialchars($INFO['title'] ?? 'Категория') ?>",
            "description": "<?= htmlspecialchars($INFO['description'] ?? ($INFO['title'] ?? '')) ?>",
            "url": <?= json_encode($site['baseUrl'] . ($INFO['seo']['canonicalUrl'] ?? '/market'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
        }
    </script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Local Styles -->
    <link rel="preload" href="/public/assets/styles/catalog.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="/public/assets/styles/main.css">
    </noscript>
</head>

<body class="bg-gray-50">
    <?php include_once './public/components/header-shared.php'; ?>

    <!-- Category Page -->
    <main class="max-w-7xl mx-auto px-4 py-[7vw]">
        <!-- Breadcrumb -->
        <div class="bg-white border-b border-gray-200 mb-6">
            <div class="max-w-7xl mx-auto px-4 py-2">
                <nav class="flex items-center space-x-2 text-sm" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="/" class="text-gray-600 hover:text-red-600 transition-colors" itemprop="item" itemscope
                            itemtype="https://schema.org/Thing" itemid="<?php echo $site['baseUrl']; ?>/">
                            <i class="fas fa-home"></i> <span itemprop="name">Главная</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </span>
                    <span class="text-gray-400">/</span>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="/market" class="text-gray-600 hover:text-red-600 transition-colors" itemprop="item"
                            itemscope itemtype="https://schema.org/Thing"
                            itemid="<?php echo $site['baseUrl']; ?>/market">
                            <span itemprop="name">Каталог</span>
                        </a>
                        <meta itemprop="position" content="2">
                    </span>
                    <span class="text-gray-400">/</span>
                    <?php
                    $parentId = $INFO['categories']['parent_id'] ?? $katalog ?? null;
                    $parentTitle = $INFO['categories']['title'] ?? $katalog ?? null;
                    if ($parentId && $parentTitle):
                        ?>
                        <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a href="/market/katalog/<?= htmlspecialchars($parentId) ?>"
                                class="text-gray-600 hover:text-red-600 transition-colors" itemprop="item" itemscope
                                itemtype="https://schema.org/Thing"
                                itemid="<?php echo $site['baseUrl']; ?>/market/katalog/<?= htmlspecialchars($parentId) ?>">
                                <span itemprop="name"><?= htmlspecialchars($parentTitle) ?></span>
                            </a>
                            <meta itemprop="position" content="3">
                        </span>
                        <span class="text-gray-400">/</span>
                    <?php endif; ?>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span itemprop="name"
                            class="text-gray-900 font-medium"><?= htmlspecialchars($INFO['title'] ?? 'Категория') ?></span>
                        <meta itemprop="position" content="<?= ($parentId && $parentTitle) ? '4' : '3' ?>">
                    </span>
                </nav>
            </div>
        </div>

        <!-- Category Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <?= htmlspecialchars($INFO['title'] ?? 'Категория') ?> – купить в Москве по цене за тонну
            </h1>
            <?php if (!empty($INFO['description'])): ?>
                <p class="text-gray-600"><?= htmlspecialchars($INFO['description']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <?php if (!empty($tableProducts)): ?>
                <table class="w-full">
                    <thead class="bg-red-600 text-white border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Наименование</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Размер</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Марка стали</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Цена</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-white">В наличии</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($tableProducts as $product):
                            $productName = $product['name'] ?? ''; // Название: "Арматура 6 А3"
                            $productBrand = $product['title'] ?? ''; // Марка стали: "A500C"
                            $diameter = $product['диаметр'] ?? '';
                            $inStock = $product['in_stock'] ?? false;
                            $productUrl = $product['seo']['canonicalUrl'] ?? '#';
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors cursor-pointer"
                                onclick="window.location.href='<?= htmlspecialchars($productUrl) ?>'">
                                <td class="px-6 py-4">
                                    <span class="text-red-400 font-bold hover:text-red-700">
                                        <?= htmlspecialchars($productName ?: 'Без названия') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-900"><?= htmlspecialchars($diameter) ?></td>
                                <td class="px-6 py-4 text-gray-900 font-medium"><?= htmlspecialchars($productBrand) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if (!empty($product['units'])): ?>
                                        <?php foreach ($product['units'] as $uName => $uPrice): ?>
                                            <div class="mb-1 last:mb-0">
                                                <span class="text-lg font-bold text-gray-900">
                                                    <?= number_format($uPrice, 0, '', ' ') ?> ₽
                                                </span>
                                                <span class="text-sm text-gray-500">/<?= htmlspecialchars($uName) ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="text-gray-400">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($inStock): ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i> Да
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times mr-1"></i> Нет
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="p-8 text-center">
                    <p class="text-gray-500">В этой категории пока нет товаров.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>
</body>

</html>