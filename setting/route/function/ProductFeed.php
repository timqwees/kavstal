<?php declare(strict_types=1);

namespace Setting\route\function;

/**
 * Генератор YML фида для Яндекс Маркета
 */
class ProductFeed
{
    private static $imageBaseUrl;

    public function __construct()
    {
        self::$imageBaseUrl = \Setting\route\function\Functions::site()['baseUrl'] . '/public/assets/images/products';
    }

    private array $categoryMap = [];
    private int $categoryIdCounter = 1;

    /**
     * Безопасное экранирование XML с очисткой от недопустимых символов
     */
    private function escapeXml(string $text): string
    {
        // Удаляем управляющие символы (кроме \t, \n, \r)
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $text);

        // Проверяем валидность UTF-8
        if (!mb_check_encoding($text, 'UTF-8')) {
            $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        }

        // Экранируем XML спецсимволы
        return htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    /**
     * Генерация yml-фида
     */
    public static function generate(): string
    {
        $instance = new self();
        return $instance->buildYml();
    }

    /**
     * Отдача YML с gzip сжатием
     * @param bool $createFile создать файл если его нет
     */
    public static function outputCompressed(bool $createFile = false): void
    {
        $filePath = dirname(__DIR__, 3) . '/file/feed.yml';

        // Регенерируем, если файла нет или он старше 1 часа
        $needsRegenerate = true;
        if (file_exists($filePath)) {
            $fileAge = time() - filemtime($filePath);
            if ($fileAge < 3600) {
                $needsRegenerate = false;
                $etag = md5_file($filePath);
                if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] === $etag) {
                    http_response_code(304);
                    return;
                }
                header('Content-Type: text/xml; charset=utf-8');
                header('ETag: ' . $etag);
                header('Cache-Control: public, max-age=3600');
                readfile($filePath);
                return;
            }
        }

        $yml = self::generate();

        if ($createFile) {
            self::saveToFile($filePath, $yml);
        }

        header('Content-Type: text/xml; charset=utf-8');
        header('Content-Length: ' . strlen($yml));
        echo $yml;
    }

    /**
     * Сохранение фида в файл
     */
    public static function saveToFile(string $path, string $content): bool
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return file_put_contents($path, $content) !== false;
    }

    /**
     * Построение YML
     */
    private function buildYml(): string
    {
        $products = $this->collectProducts();
        $categories = $this->extractCategories($products);
        $date = date('Y-m-d H:i');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<yml_catalog date="' . $date . '">' . "\n";
        $xml .= '  <shop>' . "\n";
        $xml .= '    <name>КАВ СТАЛЬ</name>' . "\n";
        $xml .= '    <company>ООО КАВ СТАЛЬ</company>' . "\n";
        $xml .= '    <url>' . \Setting\route\function\Functions::site()['baseUrl'] . '</url>' . "\n";
        $xml .= '    <currencies>' . "\n";
        $xml .= '      <currency id="RUB" rate="1"/>' . "\n";
        $xml .= '    </currencies>' . "\n";
        $xml .= $this->buildCategoriesXml($categories);
        $xml .= '    <offers>' . "\n";

        foreach ($products as $product) {
            $offerXml = $this->buildOfferEntry($product);
            if ($offerXml !== '') {
                $xml .= $offerXml;
            }
        }

        $xml .= '    </offers>' . "\n";
        $xml .= '  </shop>' . "\n";
        $xml .= '</yml_catalog>' . "\n";

        return $xml;
    }

    /**
     * Сбор всех товаров (только реальные товары, без категорий)
     */
    private function collectProducts(): array
    {
        $allProducts = Functions::listProducts();
        $products = [];

        foreach ($allProducts as $product) {
            // Пропускаем виртуальные записи категорий и подкатегорий
            $badge = $product['badge'] ?? null;
            if ($badge === 'Категория' || $badge === 'Подкатегория') {
                continue;
            }

            $canonicalUrl = $product['seo']['canonicalUrl'] ?? null;
            if (!$canonicalUrl) {
                continue;
            }

            $products[] = $product;
        }

        return $products;
    }

    /**
     * Извлечение уникальных категорий из товаров
     */
    private function extractCategories(array $products): array
    {
        $categories = [];
        foreach ($products as $product) {
            $categoryName = $this->resolveCategory($product);
            if ($categoryName && !isset($this->categoryMap[$categoryName])) {
                $this->categoryMap[$categoryName] = $this->categoryIdCounter++;
                $categories[] = [
                    'id' => $this->categoryMap[$categoryName],
                    'name' => $categoryName
                ];
            }
        }
        return $categories;
    }

    /**
     * Построение блока категорий
     */
    private function buildCategoriesXml(array $categories): string
    {
        $xml = '    <categories>' . "\n";
        foreach ($categories as $cat) {
            $xml .= '      <category id="' . $cat['id'] . '">';
            $xml .= $this->escapeXml($cat['name']);
            $xml .= '</category>' . "\n";
        }
        $xml .= '    </categories>' . "\n";
        return $xml;
    }

    private int $offerCounter = 0;

    /**
     * Построение записи офера (offer)
     */
    private function buildOfferEntry(array $product): string
    {
        $name = $product['name'] ?? ($product['title'] ?? '');
        $description = $product['description'] ?? '';
        $canonicalUrl = $product['seo']['canonicalUrl'] ?? '';

        // Уникальный ID оффера - комбинируем canonicalUrl + id + table + счетчик для гарантированной уникальности
        $baseId = $product['id'] ?? '';
        $table = $product['_table'] ?? 'unknown';
        $uniqueSeed = $canonicalUrl . '|' . $baseId . '|' . $table . '|' . $this->offerCounter++;
        $id = substr(md5($uniqueSeed), 0, 16);

        // Цена - берем первую доступную цену из units (должна быть > 0)
        $price = '';
        $units = $product['units'] ?? [];
        if (!empty($units)) {
            $firstPrice = reset($units);
            $priceValue = is_numeric($firstPrice) ? (float) $firstPrice : 0;
            if ($priceValue > 0) {
                $price = number_format($priceValue, 2, '.', '');
            }
        }

        // URL
        $url = $canonicalUrl ? \Setting\route\function\Functions::site()['baseUrl'] . $canonicalUrl : '';

        // Изображения (до 5)
        $images = $product['images'] ?? [];
        $pictures = [];
        foreach (array_slice($images, 0, 5) as $img) {
            $pictures[] = $this->resolveImageUrl($img);
        }

        // Наличие
        $inStock = $product['in_stock'] ?? false;
        $available = $inStock ? 'true' : 'false';

        // Категория
        $categoryName = $this->resolveCategory($product);
        $categoryId = $categoryName ? ($this->categoryMap[$categoryName] ?? '') : '';

        // Бренд/производитель
        $vendor = 'КАВ СТАЛЬ';

        // Параметры из specs
        $params = $product['specs'] ?? [];

        // Пропускаем офферы без цены или с нулевой ценой
        if ($price === '') {
            return '';
        }

        $xml = '      <offer id="' . $this->escapeXml((string) $id) . '" available="' . $available . '">' . "\n";
        $xml .= '        <name>' . $this->escapeXml($name) . '</name>' . "\n";
        $xml .= '        <price>' . $price . '</price>' . "\n";
        $xml .= '        <currencyId>RUB</currencyId>' . "\n";
        if ($categoryId) {
            $xml .= '        <categoryId>' . $categoryId . '</categoryId>' . "\n";
        }
        if ($url) {
            $xml .= '        <url>' . $this->escapeXml($url) . '</url>' . "\n";
        }
        foreach ($pictures as $pic) {
            $xml .= '        <picture>' . $this->escapeXml($pic) . '</picture>' . "\n";
        }
        if ($description) {
            $xml .= '        <description>' . $this->escapeXml($description) . '</description>' . "\n";
        }
        $xml .= '        <vendor>' . $this->escapeXml($vendor) . '</vendor>' . "\n";

        // Дополнительные параметры
        foreach ($params as $paramName => $paramValue) {
            $xml .= '        <param name="' . $this->escapeXml($paramName) . '">';
            $xml .= $this->escapeXml((string) $paramValue);
            $xml .= '</param>' . "\n";
        }

        $xml .= '      </offer>' . "\n";

        return $xml;
    }

    /**
     * Разрешение URL изображения
     */
    private function resolveImageUrl(string $image): string
    {
        // Если уже полный URL
        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        // Если относительный путь
        if (str_starts_with($image, '/')) {
            return \Setting\route\function\Functions::site()['baseUrl'] . $image;
        }

        // Иначе считаем, что это имя файла в папке products
        return self::$imageBaseUrl . '/' . $image;
    }

    /**
     * Определение категории товара
     */
    private function resolveCategory(array $product): string
    {
        $categories = $product['categories'] ?? [];

        if (is_array($categories)) {
            // Пробуем получить из категорий
            if (isset($categories['subcategory_title']) && $categories['subcategory_title']) {
                return $categories['subcategory_title'];
            }
            if (isset($categories['title']) && $categories['title']) {
                return $categories['title'];
            }
        }

        // Fallback: из таблицы
        $table = $product['_table'] ?? '';
        if ($table) {
            return $this->tableToCategoryName($table);
        }

        return '';
    }

    /**
     * Конвертация имени таблицы в название категории
     */
    private function tableToCategoryName(string $table): string
    {
        $mapping = [
            'truby' => 'Трубы стальные',
            'listy' => 'Листовой прокат',
            'ugolki' => 'Фасонный прокат',
            'armatura' => 'Арматура',
            'shvellery' => 'Швеллеры',
            'dvutavry' => 'Двутавры',
            'kvadraty' => 'Квадраты',
            'krugi' => 'Круги',
            'shestigranniki' => 'Шестигранники',
            'polosa' => 'Полоса',
        ];

        return $mapping[$table] ?? 'Металлопрокат';
    }
}
