<?php declare(strict_types=1);

use App\Models\Router\Routes;
use App\Config\Database;
use App\Models\Network\Network;
use App\Models\Network\Message;
use Setting\route\function\Functions;
use Setting\route\function\Reviews;
use Setting\route\function\Sitemap;
use Setting\route\function\UrlList;
use Setting\route\function\ProductFeed;
use App\Models\Cart\Cart;
use App\Models\Order\Order;
use App\Models\YCP\YCP;

//==================================================================================================//MAIN
Routes::get('/', function ($path = '/index.php') {
    Routes::auto_element(dirname(__DIR__, 2) . '/public' . $path, get_defined_vars());
});
//==================================================================================================//MARKET
Routes::get('/market', function ($path = '/market/index.php') {
    Routes::auto_element(dirname(__DIR__, 2) . '/public' . $path, get_defined_vars());
});
//==================================================================================================//SERVICES
Routes::get('/services', function ($path = '/services.php') {
    Routes::auto_element(dirname(__DIR__, 2) . '/public/market/other' . $path, get_defined_vars());
});
//==================================================================================================//ABOUT
Routes::get('/about', function ($path = '/about.php') {
    Routes::auto_element(dirname(__DIR__, 2) . '/public/market/other' . $path, get_defined_vars());
});
//==================================================================================================//DELIVERY
Routes::get('/delivery', function ($path = '/delivery.php') {
    Routes::auto_element(dirname(__DIR__, 2) . '/public/market/other' . $path, get_defined_vars());
});
//==================================================================================================//GUARANTEES
Routes::get('/guarantees', function ($path = '/guarantees.php') {
    Routes::auto_element(dirname(__DIR__, 2) . '/public/market/other' . $path, get_defined_vars());
});
//==================================================================================================//CONTACTS
Routes::get('/contacts', function ($path = '/contacts.php') {
    Routes::auto_element(dirname(__DIR__, 2) . '/public/market/other' . $path, get_defined_vars());
});
//==================================================================================================//PAGE KATEGORI
Routes::get('/market/katalog/{katalog}', function ($katalog) {
    $templatePath = dirname(__DIR__, 2) . "/public/market/katalog/.template/_template_category/index.php";
    Routes::auto_element($templatePath, get_defined_vars());
});
//==================================================================================================//PAGE PODKATEGORI
Routes::get('/market/katalog/{katalog}/{subcategory}', function ($katalog, $subcategory) {
    $templatePath = dirname(__DIR__, 2) . "/public/market/katalog/.template/_template_category/index.php";
    Routes::auto_element($templatePath, get_defined_vars());
});
//==================================================================================================//PAGE TOVARA
Routes::get('/market/katalog/{katalog}/{subcategory}/{name}', function ($katalog, $subcategory, $name) {
    $templatePath = dirname(__DIR__, 2) . "/public/market/katalog/.template/_product.php";
    Routes::auto_element($templatePath, get_defined_vars());
});
//==================================================================================================//API
Routes::get('/api/market/products/list', function () {
    $result = [
        'siteInfo' => Setting\route\function\Functions::site(),
        'products' => Setting\route\function\Functions::listProducts(),
    ];
    header('Content-Type: application/json; charset=utf-8');
    print json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
});
//==================================================================================================//API SEARCH (Live поиск товаров)
Routes::get('/api/search', function () {
    $query = trim($_GET['q'] ?? '');
    $limit = min((int)($_GET['limit'] ?? 8), 20);

    // Кеш продуктов в течении запроса
    static $cachedProducts = null;
    if ($cachedProducts === null) {
        $all = Setting\route\function\Functions::listProducts();
        $cachedProducts = [];
        foreach ($all as $p) {
            if (($p['badge'] ?? '') !== '') continue;
            $units = $p['units'] ?? [];
            $firstUnit = array_key_first($units);
            $images = $p['images'] ?? [];
            $cachedProducts[] = [
                'id'       => $p['id'],
                'name'     => mb_strtolower($p['name'] ?? $p['title'] ?? ''),
                'nameOrig' => $p['name'] ?? $p['title'] ?? '',
                'url'      => $p['seo']['canonicalUrl'] ?? '#',
                'price'    => $firstUnit ? number_format($units[$firstUnit], 0, '', ' ') : '0',
                'unit'     => $firstUnit ?? '',
                'image'    => !empty($images) ? $images[0] : '',
                'cat'      => $p['categories']['title'] ?? '',
                'subcat'   => $p['categories']['subcategory_title'] ?? '',
                'in_stock' => $p['in_stock'] ?? false,
            ];
        }
    }

    $results = [];
    if ($query !== '') {
        $q = mb_strtolower($query);
        $qlen = mb_strlen($q);
        foreach ($cachedProducts as $p) {
            $score = 0;
            if (mb_strpos($p['name'], $q) !== false) {
                $score = (mb_strpos($p['name'], $q) === 0) ? 3 : 2;
            } elseif (mb_strpos($p['cat'], $q) !== false || mb_strpos($p['subcat'], $q) !== false) {
                $score = 1;
            }
            if ($score > 0) {
                $p['score'] = $score;
                $results[] = $p;
                if (count($results) >= $limit * 2) break;
            }
        }
        usort($results, function($a, $b) { return $b['score'] - $a['score']; });
        $results = array_slice($results, 0, $limit);
        foreach ($results as &$r) unset($r['score'], $r['name']);
    }

    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: public, max-age=300');
    print json_encode($results, JSON_UNESCAPED_UNICODE);
});
//==================================================================================================//REVIEWS API (Отправка отзыва)
Routes::post('/api/reviews', function () {
    if (empty($_POST)) {
        Message::set('error', 'Нет данных для отправки отзыва');
        Network::onRedirect($_SERVER['HTTP_REFERER'] ?? '/');
        return;
    }
    Reviews::addReview($_POST);
    Network::onRedirect($_POST['redirect_url'] ?? $_SERVER['HTTP_REFERER'] ?? '/');
});
//==================================================================================================//ROBOTS.TXT (SEO)
Routes::get('/robots.txt', function () {
    $baseUrl = Functions::site()['baseUrl'];
    $content = "User-agent: *\n";
    $content .= "Crawl-delay: 3\n";
    $content .= "Disallow: /api/\n";
    $content .= "Disallow: /send/\n";
    $content .= "Disallow: /*?route=*\n";
    $content .= "Disallow: /*?search=*\n";
    $content .= "Disallow: /public/\n";
    $content .= "Allow: /\n";
    $content .= "\n";
    $content .= "Clean-param: route\n";
    $content .= "Clean-param: search\n";
    $content .= "\n";
    $content .= "Sitemap: " . $baseUrl . "/sitemap.xml\n";
    $content .= "Sitemap: " . $baseUrl . "/sitemap-index.xml\n";
    $content .= "\n";
    $content .= "Host: " . $baseUrl . "\n";

    header('Content-Type: text/plain; charset=utf-8');
    echo $content;
});
//==================================================================================================//SITEMAP.XML (SEO)
Routes::get('/ysitemap.xml', function () {
    Sitemap::outputCompressed('yandex', true);
});
//==================================================================================================//SITEMAP.XML (SEO)
Routes::get('/sitemap.xml', function () {
    Sitemap::outputCompressed('google', true);
});
//==================================================================================================//BLOG
Routes::get('/blog', function ($path = '/blog/index.php') {
    Routes::auto_element(dirname(__DIR__, 2) . '/public' . $path, get_defined_vars());
});
Routes::get('/rss.xml', function () {
    \Setting\route\function\BlogRssFeed::output();
});
Routes::get('/blog/{slug}', function ($slug, $path = '/blog/article.php') {
    Routes::auto_element(dirname(__DIR__, 2) . '/public' . $path, get_defined_vars());
});
//==================================================================================================//PRODUCT FEED (Товарный фид YML)
Routes::get('/feed.yml', function () {
    ProductFeed::outputCompressed(true);
});
//==================================================================================================//PRODUCT FEED XML ALIAS
Routes::get('/feed.xml', function () {
    ProductFeed::outputCompressed(true);
});
//==================================================================================================//SITEMAP INDEX
Routes::get('/sitemap-index.xml', function () {
    $baseUrl = Functions::site()['baseUrl'];
    header('Content-Type: application/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    echo '  <sitemap><loc>' . $baseUrl . '/sitemap.xml</loc><lastmod>' . date('Y-m-d') . '</lastmod></sitemap>' . "\n";
    echo '  <sitemap><loc>' . $baseUrl . '/ysitemap.xml</loc><lastmod>' . date('Y-m-d') . '</lastmod></sitemap>' . "\n";
    echo '  <sitemap><loc>' . $baseUrl . '/rss.xml</loc><lastmod>' . date('Y-m-d') . '</lastmod></sitemap>' . "\n";
    echo '  <sitemap><loc>' . $baseUrl . '/feed.yml</loc><lastmod>' . date('Y-m-d') . '</lastmod></sitemap>' . "\n";
    echo '</sitemapindex>' . "\n";
});
//==================================================================================================//OPENSEARCH XML
Routes::get('/opensearch.xml', function () {
    $baseUrl = Functions::site()['baseUrl'];
    header('Content-Type: application/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">' . "\n";
    echo '  <ShortName>КАВ СТАЛЬ</ShortName>' . "\n";
    echo '  <Description>Поиск металлопроката на сайте КАВ СТАЛЬ</Description>' . "\n";
    echo '  <InputEncoding>UTF-8</InputEncoding>' . "\n";
    echo '  <Image width="96" height="96" type="image/png">' . $baseUrl . '/public/assets/images/icons/favicon/favicon-96x96.png</Image>' . "\n";
    echo '  <Url type="text/html" method="get" template="' . $baseUrl . '/market?search={searchTerms}"/>' . "\n";
    echo '  <moz:SearchForm>' . $baseUrl . '/market</moz:SearchForm>' . "\n";
    echo '</OpenSearchDescription>' . "\n";
});
//==================================================================================================//PWA MANIFEST
Routes::get('/manifest.json', function () {
    $path = dirname(__DIR__, 2) . '/public/manifest.json';
    if (file_exists($path)) {
        header('Content-Type: application/manifest+json; charset=utf-8');
        header('Cache-Control: public, max-age=86400');
        readfile($path);
    } else {
        Routes::error_404('Manifest not found');
    }
});
//==================================================================================================//BROWSERCONFIG (MS Tile)
Routes::get('/browserconfig.xml', function () {
    $path = dirname(__DIR__, 2) . '/public/browserconfig.xml';
    if (file_exists($path)) {
        header('Content-Type: application/xml; charset=utf-8');
        header('Cache-Control: public, max-age=86400');
        readfile($path);
    } else {
        Routes::error_404('Browserconfig not found');
    }
});
//==================================================================================================//LLMS.TXT
Routes::get('/llms.txt', function () {
    $filePath = dirname(__DIR__, 2) . '/public/llms.txt';
    if (file_exists($filePath)) {
        header('Content-Type: text/plain; charset=utf-8');
        header('Cache-Control: public, max-age=86400');
        readfile($filePath);
    }
});
//==================================================================================================//LLMS-FULL.TXT
Routes::get('/llms-full.txt', function () {
    $filePath = dirname(__DIR__, 2) . '/public/llms-full.txt';
    if (file_exists($filePath)) {
        header('Content-Type: text/plain; charset=utf-8');
        header('Cache-Control: public, max-age=86400');
        readfile($filePath);
    }
});
//==================================================================================================//FILE SERVING (Отдача файлов)
Routes::file('/file/{path:.*}');
//==================================================================================================//CART API
Routes::post('/api/cart/add', function () {
    $productId = $_POST['product_id'] ?? '';
    $quantity = (float)($_POST['quantity'] ?? 1);
    $unit = $_POST['unit'] ?? '';
    header('Content-Type: application/json; charset=utf-8');
    $result = Cart::add($productId, $quantity, $unit);
    print json_encode($result, JSON_UNESCAPED_UNICODE);
});
//==================================================================================================//CART REMOVE API
Routes::post('/api/cart/remove', function () {
    $productId = $_POST['product_id'] ?? '';
    $unit = $_POST['unit'] ?? '';
    header('Content-Type: application/json; charset=utf-8');
    $result = Cart::remove($productId, $unit);
    print json_encode($result, JSON_UNESCAPED_UNICODE);
});
//==================================================================================================//CART UPDATE API
Routes::post('/api/cart/update', function () {
    $productId = $_POST['product_id'] ?? '';
    $quantity = (float)($_POST['quantity'] ?? 0);
    $unit = $_POST['unit'] ?? '';
    header('Content-Type: application/json; charset=utf-8');
    $result = Cart::update($productId, $quantity, $unit);
    print json_encode($result, JSON_UNESCAPED_UNICODE);
});
//==================================================================================================//CART COUNT API
Routes::get('/api/cart/count', function () {
    header('Content-Type: application/json; charset=utf-8');
    print json_encode(['count' => Cart::getCount()]);
});
//==================================================================================================//CART PRODUCTS API
Routes::get('/api/cart/products', function () {
    header('Content-Type: application/json; charset=utf-8');
    print json_encode(['products' => Cart::getProductIds()]);
});
//==================================================================================================//PRODUCTS BY IDS API (for favorites)
Routes::post('/api/products/by-ids', function () {
    header('Content-Type: application/json; charset=utf-8');
    $ids = $_POST['ids'] ?? [];
    if (!is_array($ids)) $ids = [];
    $products = Functions::listProducts();
    $map = [];
    foreach ($products as $p) { $map[$p['id']] = $p; }
    $result = [];
    foreach ($ids as $id) {
        if (isset($map[$id])) {
            $p = $map[$id];
            $firstUnit = array_key_first($p['units'] ?? []);
            $firstPrice = $firstUnit ? ($p['units'][$firstUnit] ?? 0) : 0;
            $result[] = [
                'id' => $p['id'],
                'title' => $p['title'] ?? $p['name'] ?? '',
                'image' => ($p['images'][0] ?? ''),
                'price' => $firstPrice,
                'unit' => $firstUnit,
                'units' => $p['units'] ?? [],
                'in_stock' => $p['in_stock'] ?? false,
                'specs' => $p['specs'] ?? [],
                'url' => $p['seo']['canonicalUrl'] ?? '#',
            ];
        }
    }
    print json_encode(['products' => $result], JSON_UNESCAPED_UNICODE);
});
//==================================================================================================//ORDERS LIST API
Routes::get('/api/orders/list', function () {
    header('Content-Type: application/json; charset=utf-8');
    $orders = \App\Models\Order\Order::getBySession();
    print json_encode(['orders' => $orders], JSON_UNESCAPED_UNICODE);
});
Routes::post('/api/orders/quick', function () {
    header('Content-Type: application/json; charset=utf-8');
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $productId = trim($_POST['product_id'] ?? '');
    if (empty($name) || empty($phone)) {
        print json_encode(['success' => false, 'error' => 'Укажите имя и телефон'], JSON_UNESCAPED_UNICODE);
        return;
    }
    try {
        $orderId = \App\Models\Order\Order::quickCreate($name, $phone, $productId);
        $data = (object)[
            'name' => $name,
            'phone' => $phone,
            'product_id' => $productId,
            'both' => true,
        ];
        \Setting\route\function\Functions::sendMail($data);
        print json_encode(['success' => true, 'order_id' => (int)$orderId], JSON_UNESCAPED_UNICODE);
    } catch (\Exception $e) {
        error_log('Quick order error: ' . $e->getMessage());
        print json_encode(['success' => false, 'error' => 'Ошибка оформления'], JSON_UNESCAPED_UNICODE);
    }
});
//==================================================================================================//YCP (Yandex Commerce Protocol)
Routes::post('/api/v1/checkout/basket/check', function () {
    \App\Models\YCP\YCP::authenticate();
    YCP::handleBasketCheck();
});
Routes::post('/api/v1/checkout/session/create', function () {
    \App\Models\YCP\YCP::authenticate();
    YCP::handleCreateSession();
});
Routes::post('/api/v1/checkout/session/{sessionId}/submit', function ($sessionId) {
    \App\Models\YCP\YCP::authenticate();
    YCP::handleSubmitOrder($sessionId);
});
Routes::post('/api/v1/checkout/session/{sessionId}/cancel', function ($sessionId) {
    \App\Models\YCP\YCP::authenticate();
    YCP::handleCancelSession($sessionId);
});
Routes::post('/api/v1/order/{orderId}/cancel', function ($orderId) {
    \App\Models\YCP\YCP::authenticate();
    YCP::handleCancelOrder((int)$orderId);
});
Routes::get('/api/v1/warehouses', function () {
    \App\Models\YCP\YCP::authenticate();
    YCP::handleWarehouses();
});
Routes::get('/api/v1/healthcheck', function () {
    YCP::handleHealthCheck();
});
//==================================================================================================//FAVORITES PAGE
Routes::get('/favorites', function () {
    Routes::auto_element(dirname(__DIR__, 2) . '/public/market/favorites/index.php', get_defined_vars());
});
//==================================================================================================//ORDERS PAGE
Routes::get('/orders', function () {
    Routes::auto_element(dirname(__DIR__, 2) . '/public/market/orders/index.php', get_defined_vars());
});
//==================================================================================================//CART PAGE
Routes::get('/cart', function () {
    Routes::auto_element(dirname(__DIR__, 2) . '/public/market/cart/index.php', get_defined_vars());
});
//==================================================================================================//CHECKOUT PAGE
Routes::get('/checkout', function () {
    Routes::auto_element(dirname(__DIR__, 2) . '/public/market/checkout/index.php', get_defined_vars());
});
//==================================================================================================//CHECKOUT SUBMIT
Routes::post('/checkout', function () {
    $result = Order::create($_POST);
    header('Content-Type: application/json; charset=utf-8');
    if ($result['success']) {
        print json_encode(['success' => true, 'order_id' => $result['order_id']], JSON_UNESCAPED_UNICODE);
    } else {
        print json_encode(['success' => false, 'error' => $result['error'] ?? 'Ошибка оформления'], JSON_UNESCAPED_UNICODE);
    }
});
//==================================================================================================//ORDER SUCCESS
Routes::get('/order/{id}/success', function ($id) {
    $order = Order::getById((int)$id);
    if (!$order) {
        Routes::error_404('Заказ не найден');
        return;
    }
    Routes::auto_element(dirname(__DIR__, 2) . '/public/market/order/success.php', array_merge(get_defined_vars(), ['order' => $order]));
});
//==================================================================================================//ORDER PDF
Routes::get('/order/{id}/pdf', function ($id) {
    try {
        $html = Order::generatePdf((int)$id);
        $pdfPath = Order::savePdf((int)$id, $html);
        if ($pdfPath) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="order-' . $id . '.pdf"');
            readfile($pdfPath);
            exit;
        }
    } catch (\Exception $e) {
        error_log("PDF generation error: " . $e->getMessage());
    }
    Routes::error_404('Счёт не найден');
});
//==================================================================================================//CALLBACK
Routes::post('/api/callback', function () {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    header('Content-Type: application/json; charset=utf-8');
    if (empty($name) || empty($phone)) {
        print json_encode(['success' => false, 'error' => 'Заполните все поля'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    try {
        \Setting\route\function\Functions::sendMail((object)[
            'имя' => $name,
            'телефон' => $phone,
            'both' => true,
        ]);
        print json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
    } catch (\Throwable $e) {
        print json_encode(['success' => false, 'error' => 'Ошибка отправки'], JSON_UNESCAPED_UNICODE);
    }
    exit;
});
//==================================================================================================//SEND EMAIL
Routes::post('/send/email', [Functions::class, 'sendMail']);
//==================================================================================================//Отправка телеграм
//==================================================================================================//Отправка обоих
Routes::post('/send/both', [Functions::class, 'sendBoth']);
//==================================================================================================//Отправка обоих
Routes::get('/pages', [UrlList::class, 'output']);