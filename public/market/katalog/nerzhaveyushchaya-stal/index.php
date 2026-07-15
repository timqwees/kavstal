<?php
$categoryID = $katalog ?? basename(dirname(__FILE__));
// =====================
$allProducts = Setting\route\function\Functions::listProducts();
$category = null;
$productsInCategory = [];

foreach ($allProducts as $product) {
    if ($product['id'] === $categoryID) {
        $category = $product;
    }
    // Собираем товары этой категории (включая подкатегории и товары напрямую в категории)
    $productCategoryId = $product['categories']['id'] ?? null;
    if ($productCategoryId === $categoryID) {
        $productsInCategory[] = $product;
    }
    // Также собираем подкатегории этой категории
    if (($product['categories']['parent_id'] ?? null) === $categoryID && ($product['badge'] ?? '') === 'Подкатегория') {
        $productsInCategory[] = $product;
    }
}

// Перемешиваем товары для случайного порядка
shuffle($productsInCategory);

$site = Setting\route\function\Functions::site();
// =====================
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($category['title'] ?? 'Категория') ?> | Купить в Москве | КАВ СТАЛЬ</title>
    <meta name="description"
        content="<?= htmlspecialchars($category['description'] ?? $category['title'] . ' - купить в Москве по выгодной цене. Поставка металлопроката от КАВ СТАЛЬ.') ?>">
    <meta name="keywords"
        content="<?= htmlspecialchars($category['title']) ?>, <?= htmlspecialchars($category['name'] ?? $category['title']) ?>, купить <?= htmlspecialchars($category['title']) ?> в Москве, <?= htmlspecialchars($category['title']) ?> цена за тонну, металлопрокат москва, сортовой прокат, доставка металлопроката">
    <link rel="canonical"
        href="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($category['seo']['canonicalUrl'] ?? '/market') ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= htmlspecialchars($category['title'] ?? 'Категория') ?> | КАВ СТАЛЬ">
    <meta property="og:description" content="<?= htmlspecialchars($category['description'] ?? $category['title']) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url"
        content="<?php echo $site['baseUrl']; ?><?= htmlspecialchars($category['seo']['canonicalUrl'] ?? '/market') ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company']) ?>">
    <meta property="og:locale" content="ru_RU">

    <!-- Additional SEO Meta Tags -->
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= htmlspecialchars($site['company']) ?>">

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
            "name": "<?= htmlspecialchars($category['title'] ?? 'Категория') ?>",
            "description": "<?= htmlspecialchars($category['description'] ?? $category['title']) ?>",
            "url": <?= json_encode($site['baseUrl'] . ($category['seo']['canonicalUrl'] ?? '/market'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
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

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span itemprop="name"
                            class="text-gray-900 font-medium"><?= htmlspecialchars($category['title'] ?? 'Категория') ?></span>
                        <meta itemprop="position" content="3">
                    </span>
                </nav>
            </div>
        </div>

        <!-- Category Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <?= htmlspecialchars($category['title'] ?? 'Категория') ?> – купить в Москве по цене за тонну
            </h1>
            <?php if (!empty($category['description'])): ?>
                <p class="text-gray-600"><?= htmlspecialchars($category['description']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Subcategories and Products -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php if (!empty($productsInCategory)): ?>
                <?php foreach ($productsInCategory as $item): ?>
                    <?php if (($item['badge'] ?? '') === 'Подкатегория'): ?>
                        <!-- Subcategory Card -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                            <a href="<?= htmlspecialchars($item['seo']['canonicalUrl'] ?? '#') ?>" class="block">
                                <?php if (!empty($item['images'])): ?>
                                    <img loading="lazy" src="<?= htmlspecialchars($item['images'][0]) ?>"
                                        alt=" <?= htmlspecialchars($item['title']) ?>"
                                        title="<?= htmlspecialchars($item['title']) ?> - купить в Москве"
                                        class="w-full h-48 object-cover rounded mb-4">
                                <?php endif; ?>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?= htmlspecialchars($item['title']) ?></h3>
                                <p class="text-sm text-gray-500">Перейти к подкатегории</p>
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- Product Card -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                            <a href="<?= htmlspecialchars($item['seo']['canonicalUrl'] ?? '#') ?>" class="block">
                                <!-- Swiper для изображений товара -->
                                <div class="swiper product-swiper w-full h-48 mb-4"
                                    data-product-id="<?= htmlspecialchars($item['id'] ?? '') ?>">
                                    <div class="swiper-wrapper">
                                        <?php
                                        $productImages = $item['images'] ?? [];
                                        if (empty($productImages)) {
                                            $productImages = [$site['baseUrl'] . "/public/assets/images/unknown/unknown.png"];
                                        }
                                        foreach ($productImages as $imgIndex => $imgUrl):
                                            ?>
                                            <div class="swiper-slide flex justify-center items-center">
                                                <img loading="lazy" src="<?= htmlspecialchars($imgUrl) ?>"
                                                    alt="<?= htmlspecialchars($item['title']) ?> - фото <?= $imgIndex + 1 ?>"
                                                    title="<?= htmlspecialchars($item['title']) ?> - фото <?= $imgIndex + 1 ?>"
                                                    class="w-full h-48 object-cover rounded">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?= htmlspecialchars($item['title']) ?></h3>
                                <?php if (!empty($item['units'])): ?>
                                    <p class="text-red-600 font-bold">
                                        <?= number_format($item['units'][array_key_first($item['units'])], 0, '', ' ') ?>
                                        ₽/<?= array_key_first($item['units']) ?>
                                    </p>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 col-span-3">В этой категории пока нет товаров.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include_once './public/components/footer.php'; ?>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Product Swiper Init -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.product-swiper').forEach(function (swiperEl) {
                new Swiper(swiperEl, {
                    loop: false,
                    pagination: {
                        el: swiperEl.querySelector('.swiper-pagination'),
                        clickable: true
                    },
                    autoplay: false
                });
            });
        });
    </script>
</body>

</html>