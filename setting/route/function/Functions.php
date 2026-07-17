<?php declare(strict_types=1);

namespace Setting\route\function;

use App\Models\Router\Routes;
use App\Models\Network\Network;
use App\Controllers\MailController;

class Functions
{
    private static $_template_product = '_template_product';
    private static $_template_category = '_template_category';
    private static $_template_subcategory = '_template_subcategory';

    // Кэш для списка продуктов (внутри процесса)
    private static ?array $_productsCache = null;
    private static ?array $_randomProductsCache = null;
    private static int $_productsCacheTime = 0;
    private static int $_cacheTtl = 300; // 5 минут

    // Файловый кэш (между запросами)
    private static string $_cacheDir = __DIR__ . '/../../../app/Storage/cache';

    // Иконки для категорий
    private static array $_categoryIcons = [
        'арматура' => 'fa-bars-staggered',
        'балка' => 'fa-building',
        'круг' => 'fa-circle',
        'лист' => 'fa-square',
        'полоса' => 'fa-minus',
        'проволока' => 'fa-circle',
        'профнастил' => 'fa-border-all',
        'свая' => 'fa-hexagon',
        'рельс' => 'fa-square',
        'сетка' => 'fa-border-all',
        'труба' => 'fa-minus',
        'уголок' => 'fa-angle-right',
        'швеллер' => 'fa-shield-alt',
        'метиз' => 'fa-bolt',
        'нержавеющий' => 'fa-th',
        'цветной' => 'fa-palette',
        'б/у' => 'fa-recycle',
    ];

    private static function getCacheDir(): string
    {
        if (!is_dir(self::$_cacheDir)) {
            mkdir(self::$_cacheDir, 0755, true);
        }
        return self::$_cacheDir;
    }

    private static function cacheGet(string $key, int $ttl = 300): mixed
    {
        $file = self::getCacheDir() . '/' . $key . '.json';
        if (!file_exists($file)) return null;
        if ((time() - filemtime($file)) > $ttl) {
            unlink($file);
            return null;
        }
        $json = @file_get_contents($file);
        if ($json === false || $json === '') {
            @unlink($file);
            return null;
        }
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            @unlink($file);
            return null;
        }
        return is_array($data) ? $data : null;
    }

    private static function cacheSet(string $key, mixed $data): void
    {
        $file = self::getCacheDir() . '/' . $key . '.json';
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        file_put_contents($file, $json, LOCK_EX);
    }

    public static function cacheClear(): void
    {
        $dir = self::getCacheDir();
        if (is_dir($dir)) {
            foreach (glob($dir . '/*.json') as $file) {
                unlink($file);
            }
        }
        self::$_productsCache = null;
        self::$_randomProductsCache = null;
    }

    //======СПИСОК ФУНКЦИЙ / LIST FUNCTIONS===========//

    # Главная страница || Main page (В маршрутных функциях писать, только маршрут в path болье ничего не нужно)
    public function on_Main($path = '/public/index.php')
    {
        Routes::auto_element(dirname(__DIR__, 3) . $path, get_defined_vars());
    }

    /**
     * @param string $productID ID продукта
     * @return array
     */
    public static function showProduct(string $productID, ?string $table = null): array
    {
        // Используем кэш списка продуктов для быстрого поиска
        $allProducts = self::listProducts();
        foreach ($allProducts as $product) {
            if (($product['id'] ?? '') === $productID) {
                return $product;
            }
        }

        // Fallback: прямое чтение CSV если не найден в кэше
        $csvDir = self::getCsvDir();
        $product = null;

        if (is_dir($csvDir)) {
            $tables = [];
            if ($table) {
                $tables = [$table];
            } else {
                $tables = self::listCsvTables($csvDir);
            }

            foreach ($tables as $tableName) {
                $rows = self::readCsvTable($csvDir . '/' . $tableName . '.csv');
                foreach ($rows as $row) {
                    $rowName = $row['название'] ?? $row['марка'] ?? '';
                    $rowId = self::slugify($rowName);
                    if ($rowId === $productID || ($row['id'] ?? null) === $productID) {
                        $product = self::normalizeProductRow($row);
                        break 2;
                    }
                }
            }
        }

        if (!$product && file_exists('./setting/config/product.json')) {
            $productsData = json_decode(file_get_contents('./setting/config/product.json'), true);
            foreach (($productsData['products'] ?? []) as $data) {
                if (($data['id'] ?? null) === $productID) {
                    $product = $data;
                    break;
                }
            }
        }

        // undefined product return
        if (!$product) {
            $product = [
                'title' => 'Uknown',
                'name' => 'Uknown',
                'description' => 'Uknown',
                'units' => ['Uknown' => 0],
                'in_stock' => false,
                'rating' => 0,
                'reviews' => 0,
                'badge' => 'Uknown',
                'image' => 'Uknown',
                'specs' => [],
                'seo' => [
                    'metaTitle' => 'Uknown',
                    'metaDescription' => 'Uknown',
                    'keywords' => ['Uknown'],
                    'canonicalUrl' => 'Uknown'
                ]
            ];
        }

        return (array) $product;
    }

    /**
     * @return array
     */
    public static function site(): array
    {
        $cached = self::cacheGet('site_data', self::$_cacheTtl);
        // baseUrl/canonical зависят от окружения (Host) — не берём из кэша, чтобы при смене
        // хоста (прокси/кэш от другого окружения) не отдавать неверный домен.
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? 'www.kavstal.ru';
        $host = preg_replace('/^https?:\/\//i', '', $host);
        $isDev = preg_match('/^(localhost|127\.0\.0\.1)(:|$)/i', $host) || preg_match('/\.local$/i', $host);
        // Локальная разработка — оставляем как есть (http://localhost:8000)
        if ($isDev) {
            $baseUrl = 'http://' . $host;
        } else {
            // Прод/прокси: всегда https + www.kavstal.ru (игнорируем неверный backend-хост www.localhost:8000)
            $baseUrl = 'https://www.kavstal.ru';
        }
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $canonical = $baseUrl . $requestUri;

        if ($cached !== null) {
            // Остальные данные из кэша, но baseUrl/logo/canonical — свежие
            $cached['baseUrl'] = $baseUrl;
            $cached['canonical'] = $canonical;
            $cached['logo'] = $baseUrl . '/public/assets/images/icons/logo/favicon.svg';
            return $cached;
        }


        $data = [
            'canonical' => $canonical,
            'baseUrl' => $baseUrl,
            'company' => 'КАВ СТАЛЬ',
            'logo' => $baseUrl . '/public/assets/images/icons/logo/favicon.svg',
            'phone' => '+7 (495) 989-24-20',
            'phone_clean' => '74959892420',
            'email' => 'zakaz@kavstal.ru',
            'address' => 'г. Москва, ул. Семёновская площадь, дом 7',
            'kartaAdress' => 'г. Москва, ул. Семёновская площадь, дом 7',
            'workingHours' => 'Пн-Пт: 9:00-18:00, Сб: 9:00-15:00',
            'deliveryAreas' => ['Москва', 'Московская область', 'Россия'],
            'whatsapp' => '+74959892420',
            'telegram' => '@kavstal_bot',
            'vk' => 'kavstal',
            'instagram' => '',
            'max' => ''
        ];

        $csvPath = self::getCsvDir() . '/siteinfo.csv';
        if (file_exists($csvPath)) {
            $rows = self::readCsvTable($csvPath);
            if (!empty($rows)) {
                $row = $rows[0];
                if (!empty($row['телефон'])) $data['phone'] = $row['телефон'];
                if (!empty($row['phone_clean'])) $data['phone_clean'] = $row['phone_clean'];
                if (!empty($row['почта'])) $data['email'] = $row['почта'];
                if (!empty($row['адрес'])) $data['address'] = $row['адрес'];
                if (!empty($row['режим_работы'])) $data['workingHours'] = $row['режим_работы'];
                if (!empty($row['зоны_доставки'])) $data['deliveryAreas'] = array_map('trim', explode(';', $row['зоны_доставки']));
                if (!empty($row['компания'])) $data['company'] = $row['компания'];
                if (!empty($row['whatsapp'])) $data['whatsapp'] = $row['whatsapp'];
                if (!empty($row['telegram'])) $data['telegram'] = $row['telegram'];
                if (!empty($row['vk'])) $data['vk'] = $row['vk'];
                if (!empty($row['instagram'])) $data['instagram'] = $row['instagram'];
            }
        }

        self::cacheSet('site_data', $data);
        return $data;
    }

    public static function listProducts(?string $table = null): array
    {
        // Внутрипроцессный кэш (без файлового кэша — 15K+ товаров слишком grandes для unserialize/json_decode в 128MB)
        if ($table === null && self::$_productsCache !== null && (time() - self::$_productsCacheTime) < self::$_cacheTtl) {
            return self::$_productsCache;
        }

        $csvDir = self::getCsvDir();
        $products = [];

        if (is_dir($csvDir)) {
            $tables = $table ? [$table] : self::listCsvTables($csvDir);
            $categoriesSeen = [];
            $subcategoriesSeen = [];
            $categoryImages = [];
            $subcategoryImages = [];

            foreach ($tables as $tableName) {
                $rows = self::readCsvTable($csvDir . '/' . $tableName . '.csv');
                foreach ($rows as $rowIdx => $row) {
                    $product = self::normalizeProductRow($row, $tableName, $rowIdx + 1);
                    $product['_table'] = $tableName;
                    $products[] = $product;

                    // Собираем уникальные категории из русских колонок
                    $catTitle = trim($row['категория'] ?? $row['category_title'] ?? '');
                    if ($catTitle && !isset($categoriesSeen[$catTitle])) {
                        $categoriesSeen[$catTitle] = self::slugify($catTitle);
                    }

                    // Собираем уникальные подкатегории (уникальные в рамках категории)
                    $subTitle = trim($row['подкатегория'] ?? $row['subcategory_title'] ?? '');
                    $subKey = $catTitle . '::' . $subTitle; // уникальный ключ
                    if ($subTitle && !isset($subcategoriesSeen[$subKey])) {
                        $subcategoriesSeen[$subKey] = [
                            'slug' => self::slugify($subTitle),
                            'parent_title' => $catTitle,
                            'table' => $tableName,
                            'title' => $subTitle,
                        ];
                    }

                    // Собираем первое фото для каждой категории и подкатегории
                    $pImages = $product['images'] ?? [];
                    $firstImg = null;
                    foreach ($pImages as $img) {
                        if ($img && strpos($img, 'unknown.png') === false) { $firstImg = $img; break; }
                    }
                    if ($firstImg) {
                        if ($catTitle && empty($categoryImages[$catTitle])) { $categoryImages[$catTitle] = $firstImg; }
                        if ($subTitle && empty($subcategoryImages[$subKey])) { $subcategoryImages[$subKey] = $firstImg; }
                    }
                }
            }

            // Добавляем виртуальные записи категорий (badge = 'Категория')
            foreach ($categoriesSeen as $catTitle => $catSlug) {
                array_unshift($products, [
                    'id' => $catSlug,
                    'title' => $catTitle,
                    'name' => $catTitle,
                    'description' => '',
                    'units' => [],
                    'in_stock' => false,
                    'rating' => 0,
                    'reviews' => 0,
                    'badge' => 'Категория',
                    'images' => [$categoryImages[$catTitle] ?? self::site()['baseUrl'] . '/public/assets/images/unknown/unknown.png'],
                    'specs' => [],
                    'seo' => [
                        'metaTitle' => $catTitle . ' | Купить в Москве | КАВ СТАЛЬ',
                        'metaDescription' => $catTitle . ' - купить в Москве по выгодной цене.',
                        'keywords' => [],
                        'canonicalUrl' => '/market/katalog/' . $catSlug,
                    ],
                    'categories' => [],
                    '_table' => null,
                ]);
            }

            // Добавляем виртуальные записи подкатегорий (badge = 'Подкатегория')
            foreach ($subcategoriesSeen as $subKey => $subData) {
                $parentSlug = $categoriesSeen[$subData['parent_title']] ?? '';
                // Уникальный slug включает родительскую категорию
                $uniqueSlug = $parentSlug . '-' . $subData['slug'];
                array_unshift($products, [
                    'id' => $uniqueSlug,
                    'title' => $subData['title'],
                    'name' => $subData['title'],
                    'description' => '',
                    'units' => [],
                    'in_stock' => false,
                    'rating' => 0,
                    'reviews' => 0,
                    'badge' => 'Подкатегория',
                    'images' => [$subcategoryImages[$subKey] ?? self::site()['baseUrl'] . '/public/assets/images/unknown/unknown.png'],
                    'specs' => [],
                    'seo' => [
                        'metaTitle' => $subData['title'] . ' | Купить в Москве | КАВ СТАЛЬ',
                        'metaDescription' => $subData['title'] . ' - купить в Москве по выгодной цене.',
                        'keywords' => [],
                        'canonicalUrl' => '/market/katalog/' . $parentSlug . '/' . $uniqueSlug,
                    ],
                    'categories' => [
                        'id' => $uniqueSlug,
                        'parent_id' => $parentSlug,
                    ],
                    '_table' => $subData['table'],
                ]);
            }

            // Гарантируем уникальность id (товары с одинаковым названием иначе
            // конфликтуют в корзине и поиске по прямой ссылке). Добавляем счётчик к дублям.
            $seenIds = [];
            foreach ($products as &$prod) {
                $origId = $prod['id'] ?? '';
                if ($origId === '') {
                    $origId = self::slugify($prod['name'] ?? $prod['title'] ?? 'item');
                }
                if (isset($seenIds[$origId])) {
                    $seenIds[$origId]++;
                    $prod['id'] = $origId . '-' . $seenIds[$origId];
                } else {
                    $seenIds[$origId] = 1;
                    $prod['id'] = $origId;
                }
                // Синхронизируем canonicalUrl с уникальным id (последний сегмент)
                if (!empty($prod['seo']['canonicalUrl'])) {
                    $parts = explode('/', $prod['seo']['canonicalUrl']);
                    $parts[count($parts) - 1] = $prod['id'];
                    $prod['seo']['canonicalUrl'] = implode('/', $parts);
                }
            }
            unset($prod);

            // Сохраняем в кэш если нет фильтра
            if ($table === null) {
                self::$_productsCache = $products;
                self::$_productsCacheTime = time();
            }
            return $products;
        }

        if (file_exists('./setting/config/product.json')) {
            $productsData = json_decode(file_get_contents('./setting/config/product.json'), true);
            return (array) ($productsData['products'] ?? []);
        }

        return [];
    }

    /**
     * Лёгкие карточки каталога для главной страницы (без полной нормализации 16K товаров).
     * Парсит CSV один раз, собирает категории/подкатегории + по товару-представителю с ценой и фото.
     * Результат кэшируется в файл (компактный, ~сотни КБ) — не съедает 128MB, как listProducts().
     * @return array
     */
    public static function getCatalogCards(): array
    {
        $cached = self::cacheGet('catalog_cards', self::$_cacheTtl);
        if ($cached !== null) {
            return $cached;
        }

        $csvDir = self::getCsvDir();
        $cards = [];
        if (!is_dir($csvDir)) {
            return $cards;
        }

        $tables = self::listCsvTables($csvDir);
        $cats = ['Сортовой прокат', 'Трубы', 'Листовой прокат', 'Нержавеющая сталь', 'Цветные металлы', 'Метизы', 'Качественные стали', 'Инженерные системы'];

        foreach ($tables as $tableName) {
            $rows = self::readCsvTable($csvDir . '/' . $tableName . '.csv');
            if (empty($rows)) {
                continue;
            }
            $hdr = array_keys($rows[0]);
            if (!in_array('категория', $hdr, true)) {
                continue;
            }
            for ($i = 0; $i < count($rows); $i++) {
                $row = $rows[$i];
                $catTitle = trim((string)($row['категория'] ?? ''));
                if (!in_array($catTitle, $cats, true)) {
                    continue;
                }
                $subTitle = trim((string)($row['подкатегория'] ?? ''));
                $photo = trim((string)($row['фото'] ?? ''));
                if (preg_match('#^https?://[^/]+(/.*)$#u', $photo, $m)) {
                    $photo = $m[1];
                }
                if ($photo === '' || strpos($photo, 'unknown.png') !== false) {
                    continue;
                }
                // только первый товар-представитель каждой подкатегории
                if (isset($cards[$catTitle][$subTitle])) {
                    continue;
                }
                $priceRaw = trim((string)($row['цена'] ?? ''));
                $unitRaw = trim((string)($row['единица'] ?? ''));
                $prices = array_map('trim', explode(';', $priceRaw));
                $unitsList = array_map('trim', explode(';', $unitRaw));
                $units = [];
                foreach ($unitsList as $ui => $u) {
                    if ($u !== '' && isset($prices[$ui]) && $prices[$ui] !== '') {
                        $units[$u] = (float) str_replace(' ', '', $prices[$ui]);
                    }
                }
                if (empty($units)) {
                    continue;
                }
                $firstUnit = array_key_first($units);
                $name = trim((string)($row['название'] ?? ''));
                $inStock = (trim((string)($row['в_наличии'] ?? '0')) === '1');
                $slug = self::slugify($subTitle);
                $catSlug = self::slugify($catTitle);
                $cards[$catTitle][$subTitle] = [
                    'id' => $catSlug . '-' . $slug,
                    'name' => $name,
                    'title' => $subTitle,
                    'url' => '/market/katalog/' . $catSlug . '/' . $catSlug . '-' . $slug,
                    'badge' => 'Подкатегория',
                    'image' => $photo,
                    'specs' => [],
                    'units' => $units,
                    'firstUnit' => $firstUnit,
                    'firstPrice' => number_format($units[$firstUnit], 0, '', ' '),
                    'inStock' => $inStock,
                    'cat' => $catTitle,
                ];
            }
        }

        $all = [];
        foreach ($cats as $c) {
            if (!empty($cards[$c])) {
                $all = array_merge($all, array_values($cards[$c]));
            }
        }

        $result = ['list' => $cats, 'all' => $all];
        self::cacheSet('catalog_cards', $result);
        return $result;
    }

    /**
     * Дерево каталога (категории + подкатегории) для мега-меню в шапке.
     * Лёгкий аналог listProducts() — парсит CSV, НЕ грузит 16K товаров целиком.
     * Кэшируется в файл (~десятки КБ). Возвращает:
     *   ['categories' => [['id'=>slug,'name'=>title,'badge'=>'Категория','categories'=>[],'images'=>[...]]],
     *    'subcategories' => [catSlug => [['id'=>uniqueSlug,'name'=>...,'categories'=>['id'=>uniqueSlug,'parent_id'=>catSlug],'images'=>[...]]]]]
     * @return array
     */
    public static function getCatalogTree(): array
    {
        $cached = self::cacheGet('catalog_tree', self::$_cacheTtl);
        if ($cached !== null) {
            return $cached;
        }

        $csvDir = self::getCsvDir();
        $categories = [];
        $subcategories = [];
        $catSlugs = [];
        $baseUrl = self::site()['baseUrl'];

        if (is_dir($csvDir)) {
            $tables = self::listCsvTables($csvDir);
            foreach ($tables as $tableName) {
                $rows = self::readCsvTable($csvDir . '/' . $tableName . '.csv');
                if (empty($rows)) {
                    continue;
                }
                foreach ($rows as $row) {
                    $catTitle = trim((string)($row['категория'] ?? ''));
                    $subTitle = trim((string)($row['подкатегория'] ?? ''));
                    if ($catTitle === '' || $subTitle === '') {
                        continue;
                    }
                    if (!isset($catSlugs[$catTitle])) {
                        $catSlugs[$catTitle] = self::slugify($catTitle);
                        $categories[] = [
                            'id' => $catSlugs[$catTitle],
                            'name' => $catTitle,
                            'badge' => 'Категория',
                            'categories' => [],
                            'images' => [],
                        ];
                    }
                    $catSlug = $catSlugs[$catTitle];
                    $subSlug = $catSlug . '-' . self::slugify($subTitle);
                    if (isset($subcategories[$catSlug][$subSlug])) {
                        continue;
                    }
                    $photo = trim((string)($row['фото'] ?? ''));
                    if (preg_match('#^https?://[^/]+(/.*)$#u', $photo, $m)) {
                        $photo = $m[1];
                    }
                    $img = ($photo !== '' && strpos($photo, 'unknown.png') === false)
                        ? $photo
                        : $baseUrl . '/public/assets/images/unknown/unknown.png';
                    $subcategories[$catSlug][$subSlug] = [
                        'id' => $subSlug,
                        'name' => $subTitle,
                        'badge' => 'Подкатегория',
                        'categories' => ['id' => $subSlug, 'parent_id' => $catSlug],
                        'images' => [$img],
                    ];
                }
            }
        }

        $subFlat = [];
        foreach ($subcategories as $catSlug => $subs) {
            $subFlat[$catSlug] = array_values($subs);
        }

        $result = ['categories' => $categories, 'subcategories' => $subFlat];
        self::cacheSet('catalog_tree', $result);
        return $result;
    }

    /**
     * Лёгкая версия всех товаров для маркета (без описания, с файловым кэшем).
     * ~17MB вместо 39MB, декод ~0.06с. Экономит память и TTFB на странице маркета.
     * Возвращает те же ключи, что нужны шаблону: id, name, title, badge,
     * categories, specs, units, images, seo.canonicalUrl.
     * @return array
     */
    public static function getMarketProducts(): array
    {
        $cached = self::cacheGet('market_products', self::$_cacheTtl);
        if ($cached !== null) {
            return $cached;
        }

        $full = self::listProducts();
        $light = [];
        foreach ($full as $item) {
            if (($item['badge'] ?? '') === 'Категория' || ($item['badge'] ?? '') === 'Подкатегория') {
                $light[] = $item; // виртуальные записи категорий нужны для фильтров
                continue;
            }
            $light[] = [
                'id' => $item['id'] ?? '',
                'name' => $item['name'] ?? '',
                'title' => $item['title'] ?? '',
                'badge' => $item['badge'] ?? '',
                'categories' => $item['categories'] ?? [],
                'specs' => $item['specs'] ?? [],
                'units' => $item['units'] ?? [],
                'images' => $item['images'] ?? [],
                'description' => $item['description'] ?? '',
                'in_stock' => $item['in_stock'] ?? false,
                'seo' => ['canonicalUrl' => $item['seo']['canonicalUrl'] ?? ''],
                '_table' => $item['_table'] ?? null,
            ];
        }

        self::cacheSet('market_products', $light);
        return $light;
    }

    /**
     * Получить все товары из конкретной таблицы (подкатегории)
     * @param string $tableName Имя таблицы (например 'armatura')
     * @return array
     */
    public static function showTable(string $tableName): array
    {
        $csvDir = self::getCsvDir();
        $path = $csvDir . '/' . $tableName . '.csv';

        if (!file_exists($path)) {
            return [];
        }

        $rows = self::readCsvTable($path);
        $products = [];
        foreach ($rows as $row) {
            $product = self::normalizeProductRow($row);
            $product['_table'] = $tableName;
            $products[] = $product;
        }

        return $products;
    }

    /**
     * @param object $data Данные письма
     * @return void
     */
    public static function sendMail(object $data, ?string $attachmentPath = null): void
    {
        // Серверная валидация телефона
        $phone = $data->телефн ?? $data->телефон ?? $data->теефон ?? $data->phone ?? '';
        $phone = trim(preg_replace('/[^0-9+]/', '', $phone));
        if ($phone === '') {
            Network::onRedirect('/');
            return;
        }

        $message = "<strong>Информация:</strong>";
        foreach ($data as $key => $value) {
            $val = is_array($value) ? implode(', ', $value) : (string) $value;
            $message .= "<hr>" . ucfirst($key) . ': ' . $val;
        }
        try {
            (new MailController())->onMail($_ENV['EMAIL_TO'] ?? 'zakaz@kavstal.ru', 'Заявление с сайта', $message, $attachmentPath);
        } catch (\Throwable $e) {
            error_log('Mail Error: ' . $e->getMessage());
        }

        self::sendToBitrix24($data, $attachmentPath);

        if (!isset($data->both)) {
            Network::onRedirect('/');
        }
    }

    /**
     * Отправка сделки в Bitrix24 через CRM REST API
     */
    private static function sendToBitrix24(object $data): void
    {
        $name = $data->имя ?? $data->name ?? '';
        $phone = $data->телефн ?? $data->телефон ?? $data->теефон ?? $data->phone ?? '';
        $email = $data->почта ?? $data->email ?? '';
        $comment = $data->сообщение ?? $data->message ?? '';

        $info = "Имя: {$name}\nТелефон: {$phone}";
        if ($email) $info .= "\nEmail: {$email}";

        $extra = [];
        foreach ($data as $key => $value) {
            if (!in_array($key, ['имя', 'name', 'телефн', 'телефон', 'phone', 'почта', 'email', 'сообщение', 'message', 'both'])) {
                if (is_string($value) && $value !== '') {
                    $extra[] = "{$key}: {$value}";
                }
            }
        }
        if ($extra) $info .= "\n\n" . implode("\n", $extra);
        if ($comment) $info .= "\n\n{$comment}";

        $webhookUrl = 'https://b24-rpu7xy.bitrix24.ru/rest/1/q9npq8wqxwhwlhi0/crm.deal.add.json';

        if (!function_exists('curl_init')) {
            error_log('Bitrix24: curl extension not available');
            return;
        }

        $postData = http_build_query(['fields' => [
            'TITLE' => 'Заявка с сайта ' . ($_SERVER['SERVER_NAME'] ?? ''),
            'CATEGORY_ID' => 1,
            'STAGE_ID' => 0,
            'COMMENTS' => $info,
        ]]);

        try {
            $ch = curl_init($webhookUrl);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_CONNECTTIMEOUT => 5,
            ]);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                error_log("Bitrix24 curl error: {$curlError}");
            } elseif ($httpCode !== 200) {
                error_log("Bitrix24 HTTP {$httpCode}: " . mb_substr($response, 0, 500));
            } else {
                $result = json_decode($response, true);
                if (!empty($result['error'])) {
                    error_log("Bitrix24 API error: {$result['error']} — {$result['error_description']}");
                }
            }
        } catch (\Throwable $e) {
            error_log('Bitrix24 exception: ' . $e->getMessage());
        }
    }

    /**
     * @param object $data
     * @return void
     */
    public static function sendBoth(object $data): void
    {
        $data = (array) $data;
        $data['both'] = true;
        try {
            self::sendMail((object) $data);
        } catch (\Exception $e) {
            error_log('ошибка' . $e->getMessage());
        }
        Network::onRedirect('/');
        exit(1);
    }

    private static function getCsvDir(): string
    {
        return './setting/config/excel';
    }

    private static function listCsvTables(string $csvDir): array
    {
        $files = @scandir($csvDir);
        if (!is_array($files)) {
            return [];
        }

        $tables = [];
        foreach ($files as $file) {
            if (!is_string($file)) {
                continue;
            }
            if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) !== 'csv') {
                continue;
            }
            $name = pathinfo($file, PATHINFO_FILENAME);
            if ($name === 'siteinfo') {
                continue;
            }
            $tables[] = $name;
        }
        return $tables;
    }

    public static function readCsvTable(string $path): array
    {
        if (!file_exists($path)) {
            return [];
        }

        $handle = fopen($path, 'r');
        if ($handle === false) {
            return [];
        }

        $headers = null;
        $rows = [];
        while (($data = fgetcsv($handle, 0, ',', '"', "")) !== false) {
            if ($headers === null) {
                // Remove BOM from first header if present
                $headers = array_map(function ($h) {
                    $h = (string) $h;
                    // Remove UTF-8 BOM if present
                    if (substr($h, 0, 3) === "\xEF\xBB\xBF") {
                        $h = substr($h, 3);
                    }
                    return trim($h);
                }, $data);
                continue;
            }
            if ($headers === []) {
                continue;
            }
            $row = [];
            foreach ($headers as $i => $key) {
                if ($key === '') {
                    continue;
                }
                $value = isset($data[$i]) ? (string) $data[$i] : '';
                // Remove UTF-8 BOM if present
                if (substr($value, 0, 3) === "\xEF\xBB\xBF") {
                    $value = substr($value, 3);
                }
                // Remove surrounding quotes
                $value = trim($value, '"');
                $row[$key] = trim($value);
            }
            $rows[] = $row;
        }

        fclose($handle);
        return $rows;
    }

    public static function normalizeProductRow(array $row, string $table = '', int $index = 0): array
    {
        // Маппинг русских колонок → внутренние ключи
        $марка = $row['марка'] ?? $row['title'] ?? '';  // Марка стали (ст3, С255, А500С)
        $название = $row['название'] ?? $row['name'] ?? '';  // Полное название товара
        $описание = $row['описание'] ?? $row['description'] ?? '';
        $диаметр = $row['диаметр'] ?? '';
        $цена = $row['цена'] ?? '';
        $единица = $row['единица'] ?? 'тн';
        $в_наличии = $row['в_наличии'] ?? $row['in_stock'] ?? '0';
        $рейтинг = $row['рейтинг'] ?? $row['rating'] ?? '0';
        $отзывы = $row['отзывы'] ?? $row['reviews'] ?? '0';
        $фото = $row['фото'] ?? $row['images'] ?? '';
        $ключевые = $row['ключевые_слова'] ?? $row['keywords'] ?? '';
        $категория = $row['категория'] ?? '';
        $подкатегория = $row['подкатегория'] ?? '';

        // Авто-ID из названия (slugify)
        $baseId = $row['id'] ?? self::slugify($название);
        $id = $baseId;

        // Авто-units из цена + единица (поддержка множественных через ;)
        $units = [];
        if ($цена !== '' && $единица !== '') {
            $prices = array_map('trim', explode(';', $цена));
            $units_list = array_map('trim', explode(';', $единица));
            foreach ($units_list as $i => $unit) {
                if ($unit !== '' && isset($prices[$i]) && $prices[$i] !== '') {
                    $units[$unit] = (float) str_replace(' ', '', $prices[$i]);
                }
            }
        } elseif (isset($row['units'])) {
            $decoded = json_decode((string) $row['units'], true);
            $units = is_array($decoded) ? $decoded : [];
        }

        // Авто-images
        $images = [];
        if ($фото !== '') {
            $images = array_values(array_filter(array_map('trim', explode(';', (string) $фото))));
        }
        // Fallback: если локальный файл изображения отсутствует — подставляем заглушку
        $root = dirname(__DIR__, 3);
        $baseUrl = self::site()['baseUrl'];
        $unknownImg = $baseUrl . '/public/assets/images/unknown/unknown.png';
        foreach ($images as &$img) {
            $local = $img;
            // нормализуем к локальному пути от корня сайта (срезаем любой домен)
            if (preg_match('#^https?://[^/]+(/.*)$#u', $local, $m)) {
                $local = $m[1];
            }
            // подставляем актуальный BASE_URL (без хардкода домена из CSV)
            $img = $baseUrl . $local;
            if ($local !== '' && $local[0] === '/' && !file_exists($root . $local)) {
                $img = $unknownImg;
            }
        }
        unset($img);
        if (empty($images)) {
            $images = [$unknownImg];
        }

        // Авто-keywords
        $keywords = [];
        if ($ключевые !== '') {
            $keywords = array_values(array_filter(array_map('trim', explode(';', (string) $ключевые))));
        }

        // Авто-categories из категория/подкатегория
        $categorySlug = $категория ? self::slugify($категория) : null;
        $subcategorySlug = $подкатегория ? self::slugify($подкатегория) : null;
        $categories = [];
        if ($подкатегория || $категория) {
            // Уникальный ID подкатегории включает категорию
            $uniqueSubSlug = ($categorySlug && $subcategorySlug) ? $categorySlug . '-' . $subcategorySlug : $subcategorySlug;
            $categories = [
                'id' => $uniqueSubSlug ?? $categorySlug,
                'parent_id' => $подкатегория ? $categorySlug : null,
                'title' => $категория,
                'subcategory_title' => $подкатегория,
            ];
        }
        // Fallback на старые колонки categories_id / categories_parent_id
        if (empty($categories) && (isset($row['categories_id']) || isset($row['category_id']))) {
            $catId = $row['subcategory_id'] ?? $row['categories_id'] ?? $row['category_id'] ?? null;
            $parentId = $row['categories_parent_id'] ?? ($row['subcategory_id'] ? ($row['category_id'] ?? null) : null);
            $categories = ['id' => $catId, 'parent_id' => $parentId];
        }

        // specs - из JSON колонки specs или из spec_* колонок CSV
        $specs = [];
        if (isset($row['specs'])) {
            $decoded = json_decode((string) $row['specs'], true);
            $specs = is_array($decoded) ? $decoded : [];
        }

        // Собираем specs из колонок вида spec_Название
        foreach ($row as $key => $value) {
            if (str_starts_with($key, 'spec_') && $value !== '' && $value !== null) {
                $specName = substr($key, 5); // Убираем префикс "spec_"
                if (!isset($specs[$specName])) {
                    $specs[$specName] = $value;
                }
            }
        }

        // Авто-SEO
        $specsPart = '';
        if (!empty($specs)) {
            $specLabels = ['ГОСТ', 'Марка стали', 'диаметр', 'стенка', 'ширина', 'длина', 'толщина'];
            $parts = [];
            foreach ($specLabels as $label) {
                if (!empty($specs[$label])) {
                    $parts[] = $specs[$label];
                }
            }
            if (!empty($parts)) {
                $specsPart = ' (' . implode(', ', $parts) . ')';
            }
        }
        $metaDesc = $описание;
        if (empty($metaDesc)) {
            $metaDesc = $название . $specsPart . ' – продажа с доставкой по Москве и МО. Цена от ' . ($цена ?: 'уточняйте') . ' ₽/тн, наличие на складе.';
        }
        $seo = [
            'metaTitle' => $название . $specsPart . ' – цена за тонну, характеристики, купить в Москве | КАВ СТАЛЬ',
            'metaDescription' => $metaDesc,
            'keywords' => $keywords,
            'canonicalUrl' => '',
        ];
        // Авто-canonicalUrl из категория/подкатегория/марка
        if ($категория || $подкатегория) {
            $parts = array_filter([$categorySlug, $subcategorySlug, $id]);
            $seo['canonicalUrl'] = '/market/katalog/' . implode('/', $parts);
        }
        // Fallback на старые SEO-колонки
        if (isset($row['seo_metaTitle']))
            $seo['metaTitle'] = $row['seo_metaTitle'];
        if (isset($row['seo_metaDescription']))
            $seo['metaDescription'] = $row['seo_metaDescription'];
        if (isset($row['seo_canonicalUrl']))
            $seo['canonicalUrl'] = $row['seo_canonicalUrl'];

        // in_stock
        $inStock = in_array(strtolower((string) $в_наличии), ['1', 'true', 'yes', 'y'], true);

        return [
            'id' => $id,
            'title' => $марка, // Марка стали для отображения в таблице
            'name' => $название,
            'description' => $описание,
            'диаметр' => $диаметр,
            'units' => $units,
            'in_stock' => $inStock,
            'rating' => (float) $рейтинг,
            'reviews' => (int) $отзывы,
            'images' => $images,
            'specs' => $specs,
            'keywords' => $keywords,
            'seo' => $seo,
            'categories' => $categories,
        ];
    }

    /**
     * Генерация страниц товаров по шаблону
     * @param string $templatePath Путь к шаблону
     * @param string $outputBasePath Базовый путь для создания страниц
     * @param array $products Список товаров для генерации
     * @return array Результат генерации
     */
    public static function generateProductPages(string $templatePath, string $outputBasePath, array $products): array
    {
        $result = ['created' => [], 'errors' => []];

        if (!is_dir($templatePath)) {
            $result['errors'][] = "Template not found: $templatePath";
            return $result;
        }

        foreach ($products as $product) {
            $productId = $product['id'] ?? null;
            if (!$productId) {
                continue;
            }

            $categoryId = $product['categories']['id'] ?? 'uncategorized';
            $parentId = $product['categories']['parent_id'] ?? null;

            // Формируем путь: base/parent/category/product или base/category/product
            if ($parentId) {
                $productPath = "$outputBasePath/$parentId/$categoryId/$productId";
            } else {
                $productPath = "$outputBasePath/$categoryId/$productId";
            }

            // Создаём директории
            if (!is_dir($productPath)) {
                if (!mkdir($productPath, 0755, true)) {
                    $result['errors'][] = "Failed to create directory: $productPath";
                    continue;
                }
            }

            // Копируем шаблон товара
            $templateIndex = "$templatePath/" . self::$_template_product . "/index.php";
            $targetIndex = "$productPath/index.php";

            if (!file_exists($templateIndex)) {
                $result['errors'][] = "Template index not found: $templateIndex";
                continue;
            }

            $content = file_get_contents($templateIndex);
            // Заменяем productID в шаблоне
            $content = preg_replace("/\\\$productID\s*=\s*['\"][^'\"]*['\"];/", "\$productID = '$productId';", $content);

            if (file_put_contents($targetIndex, $content) === false) {
                $result['errors'][] = "Failed to write: $targetIndex";
                continue;
            }

            $result['created'][] = $productPath;
        }

        return $result;
    }

    public static function slugify(string $text, string $separator = '-'): string
    {
        $map = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'kh',
            'ц' => 'ts',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shch',
            'ы' => 'y',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'ь' => '',
            'ъ' => '',
        ];

        $text = mb_strtolower($text);
        $result = '';

        $chars = mb_str_split($text);
        foreach ($chars as $char) {
            if (isset($map[$char])) {
                $result .= $map[$char];
                continue;
            }
            if (preg_match('/[a-z0-9]/', $char) === 1) {
                $result .= $char;
                continue;
            }
            $result .= $separator;
        }

        $result = preg_replace('/' . preg_quote($separator, '/') . '+/', $separator, $result) ?? $result;
        $result = trim($result, $separator);
        return $result;
    }

    /**
     * Автоматическая генерация страницы если она не существует
     * @param string $targetPath Путь к целевой странице (например ./public/market/katalog/sortovoy-prokat/ugolok/index.php)
     * @param array $routeParams Параметры роута (katalog, name, subcategory и т.д.)
     * @return bool Успешно ли создана страница
     */
    public static function autoGeneratePage(string $targetPath, array $routeParams = []): bool
    {
        // Если файл уже существует — ничего не делаем
        if (file_exists($targetPath)) {
            return true;
        }

        $baseDir = dirname(__DIR__, 3); // Корень проекта
        $relativePath = str_replace($baseDir, '', $targetPath);
        $parts = explode('/', trim($relativePath, '/'));

        // Определяем тип страницы по структуре пути (без index.php)
        // public/market/katalog/{katalog}/index.php — категория (5 частей с index.php, 4 без)
        // public/market/katalog/{katalog}/{name}/index.php — подкатегория (6 частей с index.php, 5 без)
        // public/market/katalog/{katalog}/{subcategory}/{name}/index.php — товар (7 частей с index.php, 6 без)

        // Убираем 'index.php' из подсчёта
        $partsWithoutIndex = array_filter($parts, fn($p) => $p !== 'index.php');
        $count = count($partsWithoutIndex);

        $isCategory = $count === 4 && $parts[0] === 'public' && $parts[1] === 'market' && $parts[2] === 'katalog';
        $isSubcategory = $count === 5 && $parts[0] === 'public' && $parts[1] === 'market' && $parts[2] === 'katalog';
        $isProduct = $count === 6 && $parts[0] === 'public' && $parts[1] === 'market' && $parts[2] === 'katalog';

        $templateBase = './public/market/katalog/.template';
        $outputDir = dirname($targetPath);

        // Создаём директории
        if (!is_dir($outputDir)) {
            if (!mkdir($outputDir, 0755, true)) {
                error_log("Failed to create directory: $outputDir");
                return false;
            }
        }

        // Выбираем шаблон в зависимости от типа
        if ($isCategory) {
            $templatePath = "$templateBase/" . self::$_template_category . "/index.php";
        } elseif ($isSubcategory) {
            $templatePath = "$templateBase/" . self::$_template_subcategory . "/index.php";
        } elseif ($isProduct) {
            $templatePath = "$templateBase/" . self::$_template_product . "/index.php";
        } else {
            error_log("Unknown page type for path: $relativePath");
            return false;
        }

        if (!file_exists($templatePath)) {
            error_log("Template not found: $templatePath");
            return false;
        }

        // Копируем шаблон как есть — QweesCore сам подставит переменные при вызове
        if (!copy($templatePath, $targetPath)) {
            error_log("Failed to copy template to: $targetPath");
            return false;
        }

        return true;
    }

    /**
     * Получение топ-N товаров для главной страницы (оптимизировано)
     * @param int $limit Количество товаров (по умолчанию 10)
     * @return array Товары с иконками, ценами и наличием
     */
    public static function getTopProducts(int $limit = 10): array
    {
        $csvDir = self::getCsvDir();
        $result = [];
        $found = 0;

        $categoryIcons = self::$_categoryIcons;

        if (!is_dir($csvDir)) {
            return [];
        }

        $files = glob($csvDir . '/*.csv');

        foreach ($files as $file) {
            if ($found >= $limit)
                break;

            $rows = self::readCsvTable($file);
            $tableName = basename($file, '.csv');

            foreach ($rows as $row) {
                if ($found >= $limit)
                    break;

                $product = self::normalizeProductRow($row);
                if (empty($product['name']))
                    continue;

                // Получаем цену
                $price = 0;
                if (!empty($product['units'])) {
                    $price = $product['units'][array_key_first($product['units'])] ?? 0;
                }

                // Определяем иконку по категории
                $icon = 'fa-box';
                $categoryTitle = mb_strtolower($product['categories']['title'] ?? '');
                foreach ($categoryIcons as $keyword => $faIcon) {
                    if (mb_stripos($categoryTitle, $keyword) !== false) {
                        $icon = $faIcon;
                        break;
                    }
                }

                $result[] = [
                    'name' => $product['name'],
                    'title' => $product['title'] ?? '',
                    'price' => $price,
                    'priceDisplay' => $price > 0 ? number_format($price, 0, '', ' ') . ' ₽/т' : 'Цена по запросу',
                    'inStock' => $product['in_stock'] ?? false,
                    'stockText' => ($product['in_stock'] ?? false) ? 'В наличии' : 'Под заказ',
                    'availability' => ($product['in_stock'] ?? false) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                    'url' => $product['seo']['canonicalUrl'] ?? '/market',
                    'icon' => $icon,
                ];

                $found++;
            }
        }

        return $result;
    }

    /**
     * Получение случайных товаров (оптимизировано)
     * @param int $limit Количество товаров (по умолчанию 10)
     * @return array Случайные товары с иконками, ценами и наличием
     */
    public static function getRandomProducts(int $limit = 10): array
    {
        // Используем кэш
        if (self::$_randomProductsCache !== null && (time() - self::$_productsCacheTime) < self::$_cacheTtl) {
            return array_slice(self::$_randomProductsCache, 0, $limit);
        }

        $csvDir = self::getCsvDir();
        $allProducts = [];
        $targetCount = $limit * 3; // Собираем в 3 раза больше для случайности

        $categoryIcons = self::$_categoryIcons;

        if (!is_dir($csvDir)) {
            return [];
        }

        $files = glob($csvDir . '/*.csv');
        shuffle($files); // Перемешиваем файлы для случайности

        foreach ($files as $file) {
            // Ранний выход если уже достаточно товаров
            if (count($allProducts) >= $targetCount) {
                break;
            }

            $rows = self::readCsvTable($file);
            shuffle($rows); // Перемешиваем строки внутри файла

            foreach ($rows as $row) {
                // Ранний выход если уже достаточно товаров
                if (count($allProducts) >= $targetCount) {
                    break 2;
                }

                $product = self::normalizeProductRow($row);
                if (empty($product['name']))
                    continue;

                // Получаем цену
                $price = 0;
                if (!empty($product['units'])) {
                    $price = $product['units'][array_key_first($product['units'])] ?? 0;
                }

                // Определяем иконку по категории
                $icon = 'fa-box';
                $categoryTitle = mb_strtolower($product['categories']['title'] ?? '');
                foreach ($categoryIcons as $keyword => $faIcon) {
                    if (mb_stripos($categoryTitle, $keyword) !== false) {
                        $icon = $faIcon;
                        break;
                    }
                }

                $allProducts[] = [
                    'name' => $product['name'],
                    'title' => $product['title'] ?? '',
                    'price' => $price,
                    'priceDisplay' => $price > 0 ? number_format($price, 0, '', ' ') . ' ₽/т' : 'Цена по запросу',
                    'inStock' => $product['in_stock'] ?? false,
                    'stockText' => ($product['in_stock'] ?? false) ? 'В наличии' : 'Под заказ',
                    'availability' => ($product['in_stock'] ?? false) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                    'url' => $product['seo']['canonicalUrl'] ?? '/market',
                    'icon' => $icon,
                ];
            }
        }

        // Перемешиваем и сохраняем в кэш
        shuffle($allProducts);
        self::$_randomProductsCache = $allProducts;
        self::$_productsCacheTime = time();

        // Возвращаем только нужное количество
        return array_slice($allProducts, 0, $limit);
    }

    /**
     * Отдача файла по прямому пути
     */
    public static function getFile(string $path): void
    {
        $file = __DIR__ . '/../../../' . $path;

        if (!file_exists($file) || is_dir($file)) {
            http_response_code(404);
            echo 'File not found';
            return;
        }

        $mime = mime_content_type($file) ?: 'application/octet-stream';
        header('Content-Type: ' . $mime);
        readfile($file);
        exit;
    }
}
