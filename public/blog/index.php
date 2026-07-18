<?php
$site = Setting\route\function\Functions::site();
$articlesFile = __DIR__ . '/data/articles.json';
$articles = [];
if (file_exists($articlesFile)) {
    $articles = json_decode(file_get_contents($articlesFile), true) ?? [];
}
usort($articles, fn($a, $b) => strtotime($b['created_at'] ?? '0') <=> strtotime($a['created_at'] ?? '0'));

$categories = ['Все статьи'];
foreach ($articles as $a) {
    if (!empty($a['category']) && !in_array($a['category'], $categories)) {
        $categories[] = $a['category'];
    }
}

$pageTitle = 'Блог КАВ СТАЛЬ — экспертные статьи о металлопрокате, ГОСТ, расчетах и закупках';
$pageDescription = 'Полезные статьи для закупщиков и инженеров: виды арматуры, балки, трубы, листовой прокат, таблицы веса, ГОСТ, резка и доставка металла. Советы профи от металлобазы КАВ СТАЛЬ.';
$pageUrl = $site['baseUrl'] . '/blog';
$ogImage = $site['baseUrl'] . '/public/assets/images/bgpage/market.png';

function ozDate(string $dateStr): string {
    $ts = strtotime($dateStr);
    $months = ['янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек'];
    return date('d', $ts) . ' ' . $months[(int)date('m', $ts) - 1] . ' ' . date('Y', $ts);
}

function estimateReadTime(string $content): int {
    $text = strip_tags($content ?? '');
    return max(1, (int)ceil(mb_strlen($text) / 1500));
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords" content="металлопрокат, блог, арматура, балка, труба, ГОСТ, вес металла, статьи, закупки">
    <link rel="canonical" href="<?= htmlspecialchars($pageUrl) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($pageUrl) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($site['company']) ?>">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImage) ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= htmlspecialchars($site['company']) ?>">
    
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="<?= $site['baseUrl'] ?>">
    <link rel="dns-prefetch" href="https://yandex.ru">

    <link rel="alternate" type="application/rss+xml" title="Блог КАВ СТАЛЬ — RSS" href="<?= htmlspecialchars($site['baseUrl'] . '/rss.xml') ?>">

    <!-- Structured Data -->
    <script type="application/ld+json">{"@context":"https://schema.org","@graph":[{"@type":"LocalBusiness","@id":"<?= $site['baseUrl'] ?>#contact","name":"КАВ СТАЛЬ","url":"<?= $site['baseUrl'] ?>","telephone":"+7-495-989-24-20","email":"<?= $site['email'] ?>","address":{"@type":"PostalAddress","streetAddress":"Семёновская площадь, 7","addressLocality":"Москва","addressRegion":"Московская область","postalCode":"115035","addressCountry":"RU"},"openingHours":"Mo-Su 09:00-18:00"},{"@type":"Store","@id":"<?= $site['baseUrl'] ?>/market","name":"КАВ СТАЛЬ","url":"<?= $site['baseUrl'] ?>","telephone":"+7-495-989-24-20","email":"<?= $site['email'] ?>","address":{"@type":"PostalAddress","streetAddress":"Семёновская площадь, 7","addressLocality":"Москва","postalCode":"107023","addressCountry":"RU"}},{"@type":"WebSite","@id":"<?= $site['baseUrl'] ?>#website","url":"<?= $site['baseUrl'] ?>","name":"КАВ СТАЛЬ","potentialAction":{"@type":"SearchAction","target":"<?= $site['baseUrl'] ?>/search?q={search_term_string}","query":"required name=search_term_string"}}]}</script>

    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="stylesheet" href="/public/assets/styles/catalog.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <link rel="preload" href="/public/assets/styles/main.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="/public/assets/styles/main.css"></noscript>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>
    <?php include_once __DIR__ . '/../components/seo-head.php'; ?>
    
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Onest', system-ui, -apple-system, sans-serif;
            background: #fff;
            color: #1a1a1a;
            -webkit-font-smoothing: antialiased;
        }
        img { max-width: 100%; display: block; }
        a { color: inherit; text-decoration: none; }

        .blog-container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .blog-py { padding-top: 24px; padding-bottom: 48px; }

        /* ── Breadcrumbs ──────────────────────────────────────── */
        .breadcrumbs {
            display: flex; flex-wrap: wrap; align-items: center;
            gap: 6px; font-size: 13px; color: #9ca3af;
            margin-bottom: 20px;
        }
        .breadcrumbs a { color: #6b7280; transition: color 0.2s; }
        .breadcrumbs a:hover { color: #dc2626; }
        .breadcrumbs__sep { color: #d1d5db; margin: 0 2px; }
        .breadcrumbs__current { color: #111; font-weight: 500; }

        /* ── Page Header ──────────────────────────────────────── */
        .blog-page-header {
            margin-bottom: 24px;
        }
        .blog-page-title {
            font-size: 28px; line-height: 1.2; font-weight: 800; color: #111;
            margin: 0 0 6px;
        }
        @media (min-width: 768px) { .blog-page-title { font-size: 32px; } }
        .blog-page-desc {
            font-size: 14px; line-height: 1.6; color: #6b7280;
            max-width: 600px; margin: 0;
        }

        /* ── Toolbar ─────────────────────────────────────────── */
        .blog-toolbar {
            display: flex; align-items: center; gap: 12px;
            flex-wrap: wrap; margin-bottom: 24px;
        }
        .blog-toolbar__count {
            font-size: 13px; font-weight: 500; color: #6b7280;
            white-space: nowrap;
        }
        .blog-toolbar__count strong { color: #111; font-weight: 700; }

        .blog-search {
            flex: 1; min-width: 200px; position: relative;
        }
        .blog-search input {
            width: 100%; height: 40px;
            padding: 0 14px 0 38px;
            border: 1px solid #e5e7eb; border-radius: 10px;
            background: #f5f5f5; font-size: 13px;
            font-family: 'Onest', sans-serif; color: #111;
            outline: none; transition: all 0.2s;
        }
        .blog-search input::placeholder { color: #9ca3af; }
        .blog-search input:focus {
            border-color: #dc2626; background: #fff;
            box-shadow: 0 0 0 3px rgba(220,38,38,0.08);
        }
        .blog-search__icon {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            width: 16px; height: 16px; color: #9ca3af; pointer-events: none;
        }

        .blog-toolbar__filters { display: flex; flex-wrap: wrap; gap: 6px; }

        .cat-pill {
            height: 34px; padding: 0 14px; border-radius: 10px;
            font-size: 12px; font-weight: 500; font-family: 'Onest', sans-serif;
            border: 1px solid #e5e7eb;
            background: #fff; color: #6b7280;
            cursor: pointer; transition: all 0.2s; white-space: nowrap;
        }
        .cat-pill:hover { border-color: #dc2626; color: #dc2626; }
        .cat-pill--active { background: #dc2626; color: #fff; border-color: #dc2626; }
        .cat-pill--active:hover { background: #b91c1c; border-color: #b91c1c; }

        @media (max-width: 768px) {
            .blog-toolbar { flex-direction: column; align-items: stretch; }
            .blog-toolbar__count { text-align: center; }
        }

        /* ── Articles Grid ───────────────────────────────────── */
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        @media (max-width: 960px) { .articles-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .articles-grid { grid-template-columns: 1fr; } }

        .article-card {
            display: flex; flex-direction: column;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s;
        }
        .article-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            border-color: #d1d5db;
        }

        .article-card__img-wrap {
            position: relative;
            aspect-ratio: 16/10;
            overflow: hidden;
            background: #f5f5f5;
        }
        .article-card__img-wrap img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.3s ease;
        }
        .article-card:hover .article-card__img-wrap img { transform: scale(1.04); }

        .article-card__date-badge {
            position: absolute; top: 10px; right: 10px;
            padding: 3px 8px; border-radius: 6px;
            background: rgba(255,255,255,0.92); backdrop-filter: blur(4px);
            font-size: 11px; font-weight: 500; color: #6b7280;
        }

        .article-card__readtime {
            position: absolute; bottom: 10px; left: 10px;
            padding: 3px 8px; border-radius: 6px;
            background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);
            font-size: 11px; font-weight: 600; color: #fff;
            display: flex; align-items: center; gap: 4px;
        }
        .article-card__readtime svg { width: 11px; height: 11px; }

        .article-card__body {
            padding: 14px 16px 16px;
            display: flex; flex-direction: column; flex: 1;
        }
        .article-card__cat {
            display: inline-block; align-self: flex-start;
            padding: 2px 8px; border-radius: 6px;
            background: #f5f5f5; color: #6b7280;
            font-size: 11px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.03em; margin-bottom: 8px;
        }
        .article-card__title {
            font-size: 15px; font-weight: 700; line-height: 1.35;
            color: #111; margin: 0 0 8px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
            transition: color 0.2s;
        }
        .article-card:hover .article-card__title { color: #dc2626; }
        .article-card__excerpt {
            font-size: 13px; line-height: 1.5; color: #9ca3af;
            flex: 1; margin: 0 0 12px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .article-card__tags {
            display: flex; flex-wrap: wrap; gap: 4px; margin-bottom: 12px;
        }
        .article-card__tag {
            padding: 2px 6px; border-radius: 4px;
            background: #f9fafb; color: #9ca3af;
            font-size: 11px; font-weight: 500;
        }
        .article-card__footer {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 10px; border-top: 1px solid #f0f0f0;
        }
        .article-card__author { display: flex; align-items: center; gap: 6px; }
        .article-card__avatar {
            width: 24px; height: 24px; border-radius: 50%;
            background: #dc2626; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 700; flex-shrink: 0;
        }
        .article-card__author-name { font-size: 12px; color: #6b7280; }
        .article-card__read {
            font-size: 12px; font-weight: 600; color: #dc2626;
            display: flex; align-items: center; gap: 3px;
            transition: gap 0.2s;
        }
        .article-card:hover .article-card__read { gap: 6px; }

        /* ── CTA ─────────────────────────────────────────────── */
        .cta-section {
            margin-top: 48px; padding: 40px;
            background: #f5f5f5; border: 1px solid #e5e7eb;
            border-radius: 16px; text-align: center;
        }
        .cta-section__title {
            font-size: 22px; font-weight: 800; color: #111; margin: 0 0 8px;
        }
        .cta-section__desc {
            font-size: 14px; line-height: 1.6; color: #6b7280;
            max-width: 480px; margin: 0 auto 24px;
        }
        .cta-section__actions { display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; }
        .cta-btn {
            display: inline-flex; align-items: center; justify-content: center;
            height: 44px; padding: 0 28px; border-radius: 10px;
            font-size: 13px; font-weight: 600; font-family: 'Onest', sans-serif;
            transition: all 0.2s; cursor: pointer;
        }
        .cta-btn--primary {
            background: #dc2626; color: #fff; border: none;
        }
        .cta-btn--primary:hover { background: #b91c1c; }
        .cta-btn--outline {
            background: #fff; color: #111;
            border: 1px solid #e5e7eb;
        }
        .cta-btn--outline:hover { background: #f9fafb; border-color: #d1d5db; }

        /* ── Animations ──────────────────────────────────────── */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .article-card { opacity: 0; animation: fadeIn 0.35s ease forwards; }
        .article-card:nth-child(1) { animation-delay: 0.03s; }
        .article-card:nth-child(2) { animation-delay: 0.06s; }
        .article-card:nth-child(3) { animation-delay: 0.09s; }
        .article-card:nth-child(4) { animation-delay: 0.12s; }
        .article-card:nth-child(5) { animation-delay: 0.15s; }
        .article-card:nth-child(6) { animation-delay: 0.18s; }
        .article-card:nth-child(7) { animation-delay: 0.21s; }
        .article-card:nth-child(8) { animation-delay: 0.24s; }
        .article-card:nth-child(9) { animation-delay: 0.27s; }
        .article-card:nth-child(10) { animation-delay: 0.3s; }

        *:focus-visible { outline: 2px solid #dc2626; outline-offset: 2px; border-radius: 4px; }
    </style>
</head>
<body>
<?php include_once './public/components/header-shared.php'; ?>


<main class="py-8 lg:py-20 mb-[5%]">
    <section class="blog-py">
        <div class="blog-container">

            <!-- Breadcrumbs -->
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?= htmlspecialchars($site['baseUrl']) ?>">Главная</a>
                <span class="breadcrumbs__sep">/</span>
                <span class="breadcrumbs__current">Блог</span>
            </nav>

            <!-- Page Header -->
            <div class="blog-page-header">
                <h1 class="blog-page-title">Блог КАВ СТАЛЬ</h1>
                <p class="blog-page-desc">Экспертные статьи о металлопрокате: ГОСТ, размеры, вес, расчёты, резка и доставка металла.</p>
            </div>

            <!-- Toolbar -->
            <div class="blog-toolbar">
                <div class="blog-toolbar__count">
                    <strong><?= count($articles) ?></strong> публикаций
                </div>
                <div class="blog-search">
                    <svg class="blog-search__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <input type="text" id="search-input" placeholder="Поиск по статьям..." autocomplete="off">
                </div>
                <div class="blog-toolbar__filters" id="cat-filters">
                    <?php foreach ($categories as $i => $cat): ?>
                        <button class="cat-pill<?= $i === 0 ? ' cat-pill--active' : '' ?>" data-filter="<?= htmlspecialchars($cat) ?>">
                            <?= htmlspecialchars($cat) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Articles Grid -->
            <div class="articles-grid" id="articles-grid">
                <?php foreach ($articles as $idx => $a):
                    $aUrl = $site['baseUrl'] . '/blog/' . htmlspecialchars($a['slug']);
                    $aImg = $a['image'] ?? '/public/assets/images/bgpage/product.png';
                    $aImg = (str_starts_with($aImg, 'http')) ? $aImg : $site['baseUrl'] . $aImg;
                    $authorInitial = mb_substr($a['author'] ?? $site['company'], 0, 1);
                    $aReadTime = estimateReadTime($a['content'] ?? '');
                    $aTags = array_slice(array_map('trim', explode(',', $a['tags'] ?? '')), 0, 3);
                ?>
                <a href="<?= $aUrl ?>" class="article-card" data-category="<?= htmlspecialchars($a['category'] ?? '') ?>">
                    <div class="article-card__img-wrap">
                        <img src="<?= htmlspecialchars($aImg) ?>" alt="<?= htmlspecialchars($a['title']) ?>" loading="lazy">
                        <span class="article-card__date-badge"><?= ozDate($a['created_at'] ?? 'now') ?></span>
                        <span class="article-card__readtime">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <?= $aReadTime ?> мин
                        </span>
                    </div>
                    <div class="article-card__body">
                        <span class="article-card__cat"><?= htmlspecialchars($a['category'] ?? 'Статья') ?></span>
                        <h2 class="article-card__title"><?= htmlspecialchars($a['title']) ?></h2>
                        <p class="article-card__excerpt"><?= htmlspecialchars(mb_substr(strip_tags($a['content'] ?? ''), 0, 100) . '...') ?></p>
                        <?php if (!empty($aTags)): ?>
                        <div class="article-card__tags">
                            <?php foreach ($aTags as $tag): ?>
                                <?php if ($tag): ?><span class="article-card__tag"><?= htmlspecialchars($tag) ?></span><?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <div class="article-card__footer">
                            <div class="article-card__author">
                                <span class="article-card__avatar"><?= htmlspecialchars($authorInitial) ?></span>
                                <span class="article-card__author-name"><?= htmlspecialchars($a['author'] ?? $site['company']) ?></span>
                            </div>
                            <span class="article-card__read">Читать →</span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- CTA -->
            <div class="cta-section">
                <div class="cta-section__title">Нужна консультация по закупке металла?</div>
                <p class="cta-section__desc">Позвоните или напишите — подберём оптимальный сорт, рассчитаем вес и стоимость, организуем доставку.</p>
                <div class="cta-section__actions">
                    <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="cta-btn cta-btn--primary">Позвонить: <?= htmlspecialchars($site['phone'] ?? '+7 (495) 989-24-20') ?></a>
                    <a href="/contacts" class="cta-btn cta-btn--outline">Написать нам</a>
                </div>
            </div>

        </div>
    </section>
</main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>

<script>
var currentFilter = 'all';
var searchQuery = '';

document.addEventListener('DOMContentLoaded', function () {
    bindSearch();
    bindFilters();
});

function bindSearch() {
    var input = document.getElementById('search-input');
    if (!input) return;
    input.addEventListener('input', function () {
        searchQuery = this.value.trim().toLowerCase();
        applyFilters();
    });
}

function bindFilters() {
    var container = document.getElementById('cat-filters');
    container.querySelectorAll('.cat-pill').forEach(function (btn) {
        btn.addEventListener('click', function () {
            container.querySelectorAll('.cat-pill').forEach(function (b) { b.classList.remove('cat-pill--active'); });
            this.classList.add('cat-pill--active');
            currentFilter = this.dataset.filter;
            applyFilters();
        });
    });
}

function applyFilters() {
    var cards = document.querySelectorAll('.article-card');
    var visible = 0;
    cards.forEach(function (card) {
        var cat = card.dataset.category || '';
        var title = (card.querySelector('.article-card__title') || {}).textContent || '';
        var catMatch = currentFilter === 'all' || currentFilter === 'Все статьи' || cat === currentFilter;
        var searchMatch = !searchQuery || title.toLowerCase().includes(searchQuery) || cat.toLowerCase().includes(searchQuery);
        var show = catMatch && searchMatch;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    var countEl = document.querySelector('.blog-toolbar__count');
    if (countEl) countEl.innerHTML = '<strong>' + visible + '</strong> публикаций';
}
</script>
</body>
</html>
