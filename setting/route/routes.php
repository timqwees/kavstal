<?php declare(strict_types=1);

use App\Models\Router\Routes;
use App\Config\Database;
use App\Models\Network\Network;
use App\Models\Network\Message;
use Setting\route\function\Functions;
use Setting\route\function\Sitemap;
use Setting\route\function\UrlList;
use Setting\route\function\ProductFeed;
use App\Models\Cart\Cart;
use App\Models\Order\Order;
function splitQueryIntoWords(string $text): array
{
    $text = mb_strtolower($text);
    $text = preg_replace('/[^а-яёa-z0-9\\s]/u', ' ', $text) ?? '';
    $text = preg_replace('/\\s+/', ' ', trim($text)) ?? '';
    $res = preg_split('/\\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
    return $res !== false ? $res : [];
}

function russianToLatin(string $text): string
{
    static $map = [
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
        'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
        'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
        'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch',
        'ш' => 'sh', 'щ' => 'shch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
    ];
    return str_replace(array_keys($map), array_values($map), mb_strtolower($text));
}

function latinToRussian(string $text): string
{
    static $map = [
        'shch' => 'щ', 'sch' => 'щ', 'sh' => 'ш', 'ch' => 'ч',
        'zh' => 'ж', 'yu' => 'ю', 'ya' => 'я', 'kh' => 'х',
        'ts' => 'ц', 'ye' => 'е', 'yo' => 'ё',
        'ce' => 'це', 'ci' => 'ци',
    ];
    static $singleMap = [
        'a' => 'а', 'b' => 'б', 'c' => 'с', 'd' => 'д', 'e' => 'е',
        'f' => 'ф', 'g' => 'г', 'h' => 'х', 'i' => 'и', 'j' => 'й',
        'k' => 'к', 'l' => 'л', 'm' => 'м', 'n' => 'н', 'o' => 'о',
        'p' => 'п', 'q' => 'к', 'r' => 'р', 's' => 'с', 't' => 'т',
        'u' => 'у', 'v' => 'в', 'w' => 'в', 'x' => 'кс', 'y' => 'ы',
        'z' => 'з',
    ];
    $result = mb_strtolower($text);
    foreach ($map as $lat => $rus) {
        $result = str_replace((string)$lat, (string)$rus, $result);
    }
    $result = preg_replace('/[^а-яёa-z]/u', '', $result) ?? '';
    /** @var array<string,string> $singleMap */
    $result = str_replace(array_keys($singleMap), array_values($singleMap), $result);
    return $result;
}

function fuzzyMatchWeight(string $qw, string $tw): int
{
    if ($qw === $tw) return 100;
    $qwLen = mb_strlen($qw);
    $twLen = mb_strlen($tw);
    if ($qwLen < 3 || $twLen < 3) return 0;
    if (str_contains($tw, $qw) || str_contains($qw, $tw)) return 75;
    // Quick char pre-filter: <40% unique chars of shorter word present in longer? skip
    $pfShort = ($qwLen <= $twLen) ? $qw : $tw;
    $pfLong = ($qwLen <= $twLen) ? $tw : $qw;
    $pfLen = mb_strlen($pfShort);
    if ($pfLen >= 3) {
        $mc = 0; $uc = 0; $seen = [];
        for ($i = 0; $i < $pfLen; $i++) {
            $ch = mb_substr($pfShort, $i, 1);
            if (!isset($seen[$ch])) {
                $seen[$ch] = true; $uc++;
                if (str_contains($pfLong, $ch)) $mc++;
            }
        }
        if ($uc >= 3 && $mc < max(1, (int)($uc * 0.4))) return 0;
    }

    $lev = mb_levenshtein_limited($qw, $tw, 3);
    if ($lev !== false) {
        if ($lev <= 1) return 85;
        if ($lev <= 2) return 65;
        if ($lev <= 3) return 45;
    }
    // Common suffix match (поймать опечатки перестановки: "абсестоцемент"≈"асбестоцемент")
    $minLen = min($qwLen, $twLen);
    // Try full suffix match first (короткие общие окончания 4-5 символов дают ложные срабатывания, минимум 6)
    for ($len = $minLen; $len >= 6; $len--) {
        if (mb_substr($qw, -$len) === mb_substr($tw, -$len)) {
            return (int)(($len / $minLen) * 50);
        }
    }
    // Common substring match (same position, для опечаток перестановок внутри слова)
    $longer = ($qwLen >= $twLen) ? $qw : $tw;
    $shorter = ($qwLen >= $twLen) ? $tw : $qw;
    $shortLen = mb_strlen($shorter);
    $minMatch = max(6, (int)($shortLen * 0.5));
    for ($len = $shortLen; $len >= $minMatch; $len--) {
        $searchEnd = $shortLen - $len;
        for ($start = 0; $start <= $searchEnd; $start++) {
            $sub = mb_substr($shorter, $start, $len);
            $pos = mb_strpos($longer, $sub);
            if ($pos !== false && abs($pos - $start) <= 2) {
                return (int)(($len / $shortLen) * 50);
            }
        }
    }
    $prefix = 0;
    $maxLen = min($qwLen, $twLen);
    for ($i = 0; $i < $maxLen; $i++) {
        if (mb_substr($qw, $i, 1) === mb_substr($tw, $i, 1)) $prefix++;
        else break;
    }
    if ($prefix >= 3) return 30;
    return 0;
}

function mb_levenshtein_limited(string $a, string $b, int $maxDist = 3): int|false
{
    $la = mb_strlen($a);
    $lb = mb_strlen($b);
    if ($la === 0) return min($lb, $maxDist + 1);
    if ($lb === 0) return min($la, $maxDist + 1);
    if (abs($la - $lb) > $maxDist) return false;

    $aChars = [];
    for ($i = 0; $i < $la; $i++) $aChars[] = mb_substr($a, $i, 1);
    $bChars = [];
    for ($i = 0; $i < $lb; $i++) $bChars[] = mb_substr($b, $i, 1);

    if ($la > $lb) {
        [$aChars, $bChars] = [$bChars, $aChars];
        [$la, $lb] = [$lb, $la];
    }

    $prev = range(0, $la);
    for ($i = 1; $i <= $lb; $i++) {
        $curr = [$i];
        $rowMin = $i;
        $bi = $bChars[$i - 1];
        for ($j = 1; $j <= $la; $j++) {
            $cost = ($bi === $aChars[$j - 1]) ? 0 : 1;
            $v = $curr[$j - 1] + 1;
            $v2 = $prev[$j] + 1;
            if ($v2 < $v) $v = $v2;
            $v2 = $prev[$j - 1] + $cost;
            if ($v2 < $v) $v = $v2;
            $curr[$j] = $v;
            if ($v < $rowMin) $rowMin = $v;
        }
        if ($rowMin > $maxDist) return false;
        $prev = $curr;
    }
    return $prev[$la];
}

function mb_levenshtein(string $a, string $b): int
{
    $r = mb_levenshtein_limited($a, $b, 100);
    return $r === false ? 100 : $r;
}

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
//==================================================================================================//DELIVERY-MAP
Routes::get('/delivery-map', function ($path = '/delivery-map.php') {
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
function redirectOldKatalog(string $katalog, ?string $subcategory = null, ?string $name = null): ?string
{
    $catDefaults = [
        // Старые «сборные» категории: сортовой/листовой прокат и трубы теперь —
        // отдельные категории по видам (см. подкатегорийные переопределения ниже)
        'sortovoy-prokat' => null,
        'metizy' => 'krepezh-i-metizy',
        'kachestvennye-stali' => 'kachestvennye-i-spetsialnye-stali',
        'inzhenernye-sistemy' => null,
        'stroitelnye-materialy' => 'izdeliya-i-proektnye-pozitsii',
        // Категории, которых больше нет (каждая категория = вид товара)
        'chernyy-metalloprokat' => null,
        'krovelnye-i-fasadnye-materialy' => null,
    ];
    $defaultNew = $catDefaults[$katalog] ?? null;
    // Subcategory-level overrides for split categories
    if ($subcategory !== null) {
        $subOverrides = [
            // Сортовой прокат -> Цветные металлы
            'sortovoy-prokat-alyuminievyy-krug' => 'tsvetnye-metally',
            'sortovoy-prokat-alyuminievyy-ugolok' => 'tsvetnye-metally',
            'sortovoy-prokat-bronzovyy-krug' => 'tsvetnye-metally',
            'sortovoy-prokat-dyuralevyy-krug' => 'tsvetnye-metally',
            'sortovoy-prokat-dyuralevyy-shestigrannik' => 'tsvetnye-metally',
            'sortovoy-prokat-latunnyy-krug' => 'tsvetnye-metally',
            'sortovoy-prokat-latunnyy-shestigrannik' => 'tsvetnye-metally',
            'sortovoy-prokat-mednyy-krug' => 'tsvetnye-metally',
            // Сортовой прокат -> Качественные и специальные стали
            'sortovoy-prokat-pokovka' => 'kachestvennye-i-spetsialnye-stali',
            'sortovoy-prokat-stal-konstruktsionnaya-nikel-krug' => 'kachestvennye-i-spetsialnye-stali',
            'sortovoy-prokat-stal-konstruktsionnaya-nikel-kvadrat' => 'kachestvennye-i-spetsialnye-stali',
            'sortovoy-prokat-stal-sort-instrum-krug' => 'kachestvennye-i-spetsialnye-stali',
            'sortovoy-prokat-stal-sort-konstr-krug' => 'kachestvennye-i-spetsialnye-stali',
            'sortovoy-prokat-stal-sort-konstr-shestigrannik' => 'kachestvennye-i-spetsialnye-stali',
            'sortovoy-prokat-stal-sort-nerzh-zharopr-krug' => 'kachestvennye-i-spetsialnye-stali',
            'sortovoy-prokat-stal-sort-nerzh-zharopr-shestigrannik' => 'kachestvennye-i-spetsialnye-stali',
            'sortovoy-prokat-stal-sort-spets-sv-mi-krug' => 'kachestvennye-i-spetsialnye-stali',
            'sortovoy-prokat-stal-sort-kh-t-kalibrovka-krug' => 'kachestvennye-i-spetsialnye-stali',
            'sortovoy-prokat-stal-sort-kh-t-kalibrovka-shestigrannik' => 'kachestvennye-i-spetsialnye-stali',
            'sortovoy-prokat-stal-fason-profili-kvadrat' => 'kachestvennye-i-spetsialnye-stali',
            'sortovoy-prokat-stal-fason-profili-polosa' => 'kachestvennye-i-spetsialnye-stali',
            // Сортовой прокат -> Нержавеющая сталь
            'sortovoy-prokat-stal-sort-nerzh-nikel-krug' => 'nerzhaveyushchaya-stal',
            'sortovoy-prokat-stal-sort-nerzh-nikel-kvadrat' => 'nerzhaveyushchaya-stal',
            'sortovoy-prokat-stal-sort-nerzh-nikel-shestigrannik' => 'nerzhaveyushchaya-stal',
            // Сортовой прокат -> Арматура / Круг-квадрат-полоса / Уголок / Швеллер / Балки
            'sortovoy-prokat-armatura' => 'armatura',
            'sortovoy-prokat-katanka' => 'armatura',
            'sortovoy-prokat-krug-g-k' => 'krug-kvadrat-polosa',
            'sortovoy-prokat-kvadrat-g-k' => 'krug-kvadrat-polosa',
            'sortovoy-prokat-polosa-g-k' => 'krug-kvadrat-polosa',
            'sortovoy-prokat-ugolok' => 'ugolok',
            'sortovoy-prokat-ugolok-nizkolegir' => 'ugolok',
            'sortovoy-prokat-shveller' => 'shveller',
            'sortovoy-prokat-shveller-gnutyy' => 'shveller',
            'sortovoy-prokat-shveller-nizkolegir' => 'shveller',
            'sortovoy-prokat-balki-dvutavrovye' => 'balki',
            'sortovoy-prokat-balki-dvutavrovye-nizkoleg' => 'balki',
            // Листовой прокат -> Нержавеющая сталь
            'listovoy-prokat-list-nerzhaveyushchiy' => 'nerzhaveyushchaya-stal',
            'listovoy-prokat-stal-listovaya-nerzhav-bez-nikelya' => 'nerzhaveyushchaya-stal',
            'listovoy-prokat-stal-listovaya-nerzhav-nikelesod' => 'nerzhaveyushchaya-stal',
            // Листовой прокат -> Профнастил
            'listovoy-prokat-profnastil' => 'profnastil',
            'listovoy-prokat-profnastil-okrashennyy' => 'profnastil',
            'listovoy-prokat-profnastil-otsinkovannyy' => 'profnastil',
            // Метизы -> Качественные и специальные стали
            'metizy-lenta-iz-pretsiz-splavov' => 'kachestvennye-i-spetsialnye-stali',
            'metizy-lenta-nikhromovaya' => 'kachestvennye-i-spetsialnye-stali',
            'metizy-provoloka-nikhromovaya' => 'kachestvennye-i-spetsialnye-stali',
            'metizy-provoloka-kach-pruzhinnaya' => 'kachestvennye-i-spetsialnye-stali',
            'metizy-provoloka-kach-kh-v' => 'kachestvennye-i-spetsialnye-stali',
            'metizy-stal-serebryanka' => 'kachestvennye-i-spetsialnye-stali',
            'metizy-provoloka-armir-dlya-zhbk' => 'kachestvennye-i-spetsialnye-stali',
        ];
        $overrideKey = $katalog . '-' . $subcategory;
        if (isset($subOverrides[$overrideKey])) {
            $defaultNew = $subOverrides[$overrideKey];
        }
        // Переименование подкатегорий внутри той же категории (старый slug -> новый)
        $subRenames = [
            // Профнастил: марки (С8, С21, Н60...) -> виды (оцинкованный / окрашенный)
            'profnastil-profnastil-okrashennyy-n60' => 'profnastil-profnastil-okrashennyy',
            'profnastil-profnastil-okrashennyy-n75' => 'profnastil-profnastil-okrashennyy',
            'profnastil-profnastil-okrashennyy-ns35' => 'profnastil-profnastil-okrashennyy',
            'profnastil-profnastil-okrashennyy-ns44' => 'profnastil-profnastil-okrashennyy',
            'profnastil-profnastil-okrashennyy-s10' => 'profnastil-profnastil-okrashennyy',
            'profnastil-profnastil-okrashennyy-s20' => 'profnastil-profnastil-okrashennyy',
            'profnastil-profnastil-okrashennyy-s21' => 'profnastil-profnastil-okrashennyy',
            'profnastil-profnastil-okrashennyy-s8' => 'profnastil-profnastil-okrashennyy',
            'profnastil-profnastil-otsinkovannyy-n114' => 'profnastil-profnastil-otsinkovannyy',
            'profnastil-profnastil-otsinkovannyy-n57' => 'profnastil-profnastil-otsinkovannyy',
            'profnastil-profnastil-otsinkovannyy-n60' => 'profnastil-profnastil-otsinkovannyy',
            'profnastil-profnastil-otsinkovannyy-n75' => 'profnastil-profnastil-otsinkovannyy',
            'profnastil-profnastil-otsinkovannyy-ns35' => 'profnastil-profnastil-otsinkovannyy',
            'profnastil-profnastil-otsinkovannyy-ns44' => 'profnastil-profnastil-otsinkovannyy',
            'profnastil-profnastil-otsinkovannyy-s10' => 'profnastil-profnastil-otsinkovannyy',
            'profnastil-profnastil-otsinkovannyy-s20' => 'profnastil-profnastil-otsinkovannyy',
            'profnastil-profnastil-otsinkovannyy-s21' => 'profnastil-profnastil-otsinkovannyy',
            'profnastil-profnastil-otsinkovannyy-s8' => 'profnastil-profnastil-otsinkovannyy',
            'profnastil-profnastil-s8' => 'profnastil-profnastil-otsinkovannyy',
        ];
        if (isset($subRenames[$overrideKey])) {
            http_response_code(301);
            $newSub = preg_replace('/^' . preg_quote($katalog . '-', '/') . '/', '', $subRenames[$overrideKey], 1);
            $path = '/market/katalog/' . $katalog . '/' . $newSub;
            if ($name !== null) {
                $path .= '/' . $name;
            }
            header('Location: ' . $path);
            exit;
        }
    }
    if (!$defaultNew && !array_key_exists($katalog, $catDefaults)) {
        return null; // not an old slug — реальная страница
    }
    http_response_code(301);
    if ($defaultNew) {
        if ($subcategory !== null) {
            $newSubcategory = preg_replace('/^' . preg_quote($katalog, '/') . '-/', $defaultNew . '-', $subcategory, 1);
            $path = '/market/katalog/' . $defaultNew . '/' . $newSubcategory;
            if ($name !== null) {
                $path .= '/' . $name;
            }
            header('Location: ' . $path);
        } else {
            header('Location: /market/katalog/' . $defaultNew);
        }
    } else {
        header('Location: /market');
    }
    exit;
}
//==================================================================================================//PAGE KATEGORI
Routes::get('/market/katalog/{katalog}', function ($katalog) {
    redirectOldKatalog($katalog);
    $templatePath = dirname(__DIR__, 2) . "/public/market/katalog/.template/_template_category/index.php";
    Routes::auto_element($templatePath, get_defined_vars());
});
//==================================================================================================//PAGE PODKATEGORI
Routes::get('/market/katalog/{katalog}/{subcategory}', function ($katalog, $subcategory) {
    redirectOldKatalog($katalog, $subcategory);
    $templatePath = dirname(__DIR__, 2) . "/public/market/katalog/.template/_template_category/index.php";
    Routes::auto_element($templatePath, get_defined_vars());
});
//==================================================================================================//PAGE TOVARA
Routes::get('/market/katalog/{katalog}/{subcategory}/{name}', function ($katalog, $subcategory, $name) {
    redirectOldKatalog($katalog, $subcategory, $name);
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
//==================================================================================================//API SEARCH (Live поиск товаров с улучшенным алгоритмом совпадений)
Routes::get('/api/search', function () {
    $query = trim($_GET['q'] ?? '');
    $limit = min((int) ($_GET['limit'] ?? 8), 20);

    // Кеш продуктов в течении запроса
    static $cachedProducts = null;
    if ($cachedProducts === null) {
        $all = Setting\route\function\Functions::listProducts();
        $cachedProducts = [];
        foreach ($all as $p) {
            if (($p['badge'] ?? '') !== '')
                continue;
            $units = $p['units'] ?? [];
            $firstUnit = array_key_first($units);
            $images = $p['images'] ?? [];
            $keywords = $p['keywords'] ?? [];
            $name = mb_strtolower($p['name'] ?? $p['title'] ?? '');
            $cat = mb_strtolower($p['categories']['title'] ?? '');
            $subcat = mb_strtolower($p['categories']['subcategory_title'] ?? '');
            $cachedProducts[] = [
                'id' => $p['id'],
                'name' => $name,
                'nameOrig' => $p['name'] ?? $p['title'] ?? '',
                'url' => $p['seo']['canonicalUrl'] ?? '#',
                'price' => $firstUnit ? number_format($units[$firstUnit], 0, '', ' ') : '0',
                'unit' => $firstUnit ?? '',
                'image' => !empty($images) ? $images[0] : '',
                'cat' => $cat,
                'subcat' => $subcat,
                'in_stock' => $p['in_stock'] ?? false,
                'keywords' => !empty($keywords) ? implode(' ', $keywords) : '',
                'nameWords' => splitQueryIntoWords($name),
                'catWords' => array_unique(array_merge(
                    splitQueryIntoWords($cat),
                    splitQueryIntoWords($subcat)
                )),
                'keywordWords' => splitQueryIntoWords(!empty($keywords) ? implode(' ', $keywords) : ''),
            ];
        }
    }

    $allResults = [];
    $suggestions = [];
    if ($query !== '') {
        $q = mb_strtolower(trim($query));
        $words = splitQueryIntoWords($q);

        foreach ($cachedProducts as $p) {
            $score = 0;
            $nameWords = $p['nameWords'];
            $catWords = $p['catWords'];
            $keywordWords = $p['keywordWords'];

            // Exact name match (минимум 3 символа, иначе слишком много шума)
            if (mb_strlen($q) >= 3 && mb_strpos($p['name'], $q) !== false) {
                $score = (mb_strpos($p['name'], $q) === 0) ? 150 : 120;
            }
            // Exact category/subcategory match
            elseif (mb_strpos($p['cat'], $q) !== false || mb_strpos($p['subcat'], $q) !== false) {
                $score = 80;
            }
            // Word-by-word matching
            elseif (count($words) > 0) {
                $nameMatch = 0;
                $catMatch = 0;
                $kwMatch = 0;

                foreach ($words as $qw) {
                    $bestName = 0;
                    $bestCat = 0;
                    $bestKw = 0;

                    foreach ($nameWords as $nw) {
                        $w = fuzzyMatchWeight($qw, $nw);
                        if ($w > $bestName) $bestName = $w;
                        if ($bestName >= 75) break;
                    }
                    // Transliteration only if query has latin chars (lat→rus) or cyrillic chars (rus→lat)
                    if ($bestName < 30) {
                        if (preg_match('/[a-z]/', $qw)) {
                            $qwRus = latinToRussian($qw);
                            if ($qwRus !== '' && $qwRus !== $qw) {
                                foreach ($nameWords as $nw) {
                                    $w = fuzzyMatchWeight($qwRus, $nw);
                                    if ($w > $bestName) $bestName = $w;
                                    if ($bestName >= 75) break;
                                }
                            }
                        }
                        if (preg_match('/[а-яё]/', $qw)) {
                            $qwLat = russianToLatin($qw);
                            if ($qwLat !== '' && $qwLat !== $qw) {
                                foreach ($nameWords as $nw) {
                                    $w = fuzzyMatchWeight($qwLat, $nw);
                                    if ($w > $bestName) $bestName = $w;
                                    if ($bestName >= 75) break;
                                }
                            }
                        }
                    }

                    if ($bestName < 30) {
                        foreach ($catWords as $cw) {
                            $w = fuzzyMatchWeight($qw, $cw);
                            if ($w > $bestCat) $bestCat = $w;
                            if ($bestCat >= 75) break;
                        }
                        foreach ($keywordWords as $kw) {
                            $w = fuzzyMatchWeight($qw, $kw);
                            if ($w > $bestKw) $bestKw = $w;
                            if ($bestKw >= 75) break;
                        }
                    }

                    $nameMatch += $bestName;
                    $catMatch += $bestCat;
                    $kwMatch += $bestKw;
                }

                if ($nameMatch > 0) {
                    $avgName = $nameMatch / count($words);
                    $nameRatio = 0;
                    foreach ($words as $qw) {
                        $has = false;
                        foreach ($nameWords as $nw) {
                            if (fuzzyMatchWeight($qw, $nw) > 0) { $has = true; break; }
                            if (preg_match('/[a-z]/', $qw)) {
                                $r = latinToRussian($qw);
                                if ($r !== '' && $r !== $qw && fuzzyMatchWeight($r, $nw) > 0) { $has = true; break; }
                            }
                            if (preg_match('/[а-яё]/', $qw)) {
                                $r = russianToLatin($qw);
                                if ($r !== '' && $r !== $qw && fuzzyMatchWeight($r, $nw) > 0) { $has = true; break; }
                            }
                        }
                        if ($has) $nameRatio++;
                    }
                    $nameRatio /= count($words);
                    $score = (int) ($avgName * $nameRatio);
                    if ($nameRatio >= 1) $score = (int) ($score * 1.3);
                }

                if ($score < 20 && $catMatch > 0) {
                    $avgCat = $catMatch / count($words);
                    $score = (int) ($avgCat * 0.5);
                }

                if ($score < 20 && $kwMatch > 0) {
                    $avgKw = $kwMatch / count($words);
                    $keywordScore = (int) ($avgKw * 0.15);
                    if ($keywordScore > 0) $score = $keywordScore;
                }
            }

            if ($score > 0) {
                $p['score'] = $score;
                $allResults[] = $p;
                if ($score >= 40) $suggestions[] = $p;
            }
        }

        // Sort by score descending
        usort($allResults, function ($a, $b) {
            return $b['score'] - $a['score'];
        });

        // Limit results
        $allResults = array_slice($allResults, 0, $limit);

        // Suggestions (top items not already in results)
        $suggestions = array_slice(array_filter($suggestions, function ($s) use ($allResults) {
            return !in_array($s['name'], array_column($allResults, 'name'));
        }), 0, 5);

        // Add type flag
        foreach ($allResults as &$r) {
            $r['type'] = 'result';
        }
        foreach ($suggestions as &$s) {
            $s['type'] = 'suggestion';
        }

        $allResults = array_merge($allResults, $suggestions);
    }

    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: public, max-age=300');
    print json_encode($allResults, JSON_UNESCAPED_UNICODE);
});
//==================================================================================================//ROBOTS.TXT (SEO)
Routes::get('/robots.txt', function () {
    $baseUrl = Functions::site()['baseUrl'];
    $content = "User-agent: *\n";
    $content .= "Crawl-delay: 3\n";
    $content .= "Allow: /public/assets/\n";
    $content .= "Disallow: /api/\n";
    $content .= "Disallow: /send/\n";
    $content .= "Disallow: /cart\n";
    $content .= "Disallow: /checkout\n";
    $content .= "Disallow: /favorites\n";
    $content .= "Disallow: /orders\n";
    $content .= "Disallow: /order/\n";
    $content .= "Disallow: /file/\n";
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
    echo '<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/" xmlns:moz="http://www.mozilla.org/2006/browser/search/">' . "\n";
    echo '  <ShortName>КАВ СТАЛЬ</ShortName>' . "\n";
    echo '  <Description>Поиск металлопроката на сайте КАВ СТАЛЬ</Description>' . "\n";
    echo '  <InputEncoding>UTF-8</InputEncoding>' . "\n";
    echo '  <Image width="96" height="96" type="image/png">' . $baseUrl . '/public/assets/images/icons/favicon/favicon-96x96.png</Image>' . "\n";
    echo '  <Image width="16" height="16" type="image/vnd.microsoft.icon">' . $baseUrl . '/public/assets/images/icons/favicon/favicon.ico</Image>' . "\n";
    echo '  <Url type="text/html" method="get" template="' . $baseUrl . '/market?search={searchTerms}"/>' . "\n";
    echo '  <Url type="application/x-suggestions+json" method="get" template="' . $baseUrl . '/api/search?q={searchTerms}"/>' . "\n";
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
//==================================================================================================//301 REDIRECTS (старые страницы)
Routes::get('/pages/list/list.php', function () {
    http_response_code(301);
    header('Location: /market/katalog/listovoy-prokat');
    exit;
});
Routes::get('/pages/nerga_metal/nerga_metal.php', function () {
    http_response_code(301);
    header('Location: /market/katalog/nerzhaveyushchaya-stal');
    exit;
});
Routes::get('/pages/by/by.php', function () {
    http_response_code(301);
    header('Location: /market');
    exit;
});
Routes::get('/pages/{path:.*}', function () {
    http_response_code(301);
    header('Location: /market');
    exit;
});
//==================================================================================================//CART API
Routes::post('/api/cart/add', function () {
    $productId = $_POST['product_id'] ?? '';
    $quantity = (float) ($_POST['quantity'] ?? 1);
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
    $quantity = (float) ($_POST['quantity'] ?? 0);
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
    if (!is_array($ids))
        $ids = [];
    $products = Functions::listProducts();
    $map = [];
    foreach ($products as $p) {
        $map[$p['id']] = $p;
    }
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
    $orders = Order::getBySession();
    print json_encode(['orders' => $orders], JSON_UNESCAPED_UNICODE);
});
//==================================================================================================//SEND EMAIL (единый endpoint для всех форм)
Routes::post('/send/email', function () {
    ignore_user_abort(true);

    $json = json_encode(['success' => true, 'message' => 'Успешно отправлено!'], JSON_UNESCAPED_UNICODE);

    while (ob_get_level())
        ob_end_clean();
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Length: ' . strlen($json));
    header('Connection: close');
    print $json;
    flush();
    session_write_close();

    set_time_limit(60);

    // Вложения (спецификация и другие файлы форм) — прикрепляем из временного буфера, на диск не сохраняем
    $attachments = [];
    if (!empty($_FILES['spec_file'])) {
        $files = is_array($_FILES['spec_file']['name']) ? $_FILES['spec_file'] : ['name' => [$_FILES['spec_file']['name']], 'type' => [$_FILES['spec_file']['type']], 'tmp_name' => [$_FILES['spec_file']['tmp_name']], 'error' => [$_FILES['spec_file']['error']], 'size' => [$_FILES['spec_file']['size']]];
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK || empty($files['name'][$i])) continue;
            $data = @file_get_contents($files['tmp_name'][$i]);
            if ($data !== false) {
                $attachments[] = ['name' => basename($files['name'][$i]), 'data' => $data];
            }
        }
    }

    Functions::sendMail((object) $_POST, $attachments ?: null);
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
    $order = Order::getById((int) $id);
    if (!$order) {
        Routes::error_404('Заказ не найден');
        return;
    }
    Routes::auto_element(dirname(__DIR__, 2) . '/public/market/order/success.php', array_merge(get_defined_vars(), ['order' => $order]));
});
//==================================================================================================//ORDER PDF
Routes::get('/order/{id}/pdf', function ($id) {
    try {
        $html = Order::generatePdf((int) $id);
        $pdfPath = Order::savePdf((int) $id, $html);
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
//==================================================================================================//SITEMAP
Routes::get('/pages', [UrlList::class, 'output']);