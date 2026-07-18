<?php
$site = Setting\route\function\Functions::site();
$articlesFile = __DIR__ . '/data/articles.json';
$articles = [];
if (file_exists($articlesFile)) {
    $articles = json_decode(file_get_contents($articlesFile), true) ?? [];
}
usort($articles, fn($a, $b) => strtotime($b['created_at'] ?? '0') <=> strtotime($a['created_at'] ?? '0'));

// Извлекаем уникальные категории
$categories = ['Все статьи'];
foreach ($articles as $a) {
    if (!empty($a['category']) && !in_array($a['category'], $categories)) {
        $categories[] = $a['category'];
    }
}

$featured = array_shift($articles); // Первая статья — featured

$pageTitle = 'Блог КАВ СТАЛЬ — экспертные статьи о металлопрокате, ГОСТ, расчетах и закупках';
$pageDescription = 'Полезные статьи для закупщиков и инженеров: виды арматуры, балки, трубы, листовой прокат, таблицы веса, ГОСТ, резка и доставка металла. Советы профи от металлобазы КАВ СТАЛЬ.';
$pageUrl = $site['baseUrl'] . '/blog';
$ogImage = $site['baseUrl'] . '/public/assets/images/bgpage/market.png';
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
    <link rel="alternate" type="application/rss+xml" title="Блог КАВ СТАЛЬ — RSS" href="<?= htmlspecialchars($site['baseUrl'] . '/rss.xml') ?>">
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
    
    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="stylesheet" href="/public/assets/styles/catalog.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <?php include_once __DIR__ . '/../components/seo-head.php'; ?>
    
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Onest', system-ui, -apple-system, sans-serif;
            background: var(--bg-page);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
        }
        img { max-width: 100%; display: block; }
        a { color: inherit; text-decoration: none; }

        .blog-layout { max-width: 1280px; margin: 0 auto; padding: 0 24px; }

        .page-header {
            padding: 48px 0 40px;
            border-bottom: 1px solid var(--border-default);
            background: var(--bg-white);
        }
        .page-header__label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--text-tertiary);
            margin-bottom: 12px;
        }
        .page-header__title {
            font-size: 36px;
            font-weight: 700;
            line-height: 1.15;
            color: var(--text-primary);
            margin: 0 0 12px;
        }
        @media (min-width: 640px) { .page-header__title { font-size: 48px; } }
        .page-header__desc {
            font-size: 15px;
            line-height: 1.6;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0;
        }

        .blog-main { padding: 32px 0 48px; }
        .blog-main__grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
        }
        @media (min-width: 1024px) { .blog-main__grid { grid-template-columns: 1fr 320px; } }
        .blog-content { min-width: 0; }

        .search-bar { position: relative; margin-bottom: 24px; }
        .search-bar input {
            width: 100%; height: 48px; padding: 0 16px 0 48px;
            border: 1px solid var(--border-default); border-radius: var(--radius-xs);
            background: var(--bg-input); font-size: 14px; font-family: 'Onest', sans-serif;
            color: var(--text-primary); outline: none;
            transition: background var(--transition-fast), border-color var(--transition-fast);
        }
        .search-bar input::placeholder { color: var(--text-tertiary); }
        .search-bar input:focus { background: var(--bg-white); border-color: var(--primary); }
        .search-bar__icon {
            position: absolute; left: 16px; top: 50%;
            transform: translateY(-50%); width: 18px; height: 18px;
            color: var(--text-tertiary); pointer-events: none;
        }

        .cat-filters { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 32px; }
        .cat-filters__btn {
            height: 36px; padding: 0 20px; border-radius: var(--radius-xs);
            font-size: 13px; font-weight: 500; font-family: 'Onest', sans-serif;
            border: 1px solid var(--border-default);
            background: var(--bg-white); color: var(--text-secondary); cursor: pointer;
            transition: all var(--transition-fast); white-space: nowrap;
        }
        .cat-filters__btn:hover { border-color: var(--primary); color: var(--primary); }
        .cat-filters__btn--active { background: var(--primary); color: #fff; border-color: var(--primary); }

        .featured-card {
            display: flex; flex-direction: column;
            margin-bottom: 40px; padding-bottom: 0;
            background: var(--bg-white); border-radius: var(--radius-s);
            box-shadow: var(--shadow-card); overflow: hidden;
            transition: box-shadow var(--transition-slow);
        }
        .featured-card:hover { box-shadow: var(--shadow-card-hover); }
        @media (min-width: 640px) { .featured-card { flex-direction: row; } }
        .featured-card__img {
            width: 100%; height: 240px; object-fit: cover;
            background: var(--bg-input);
        }
        @media (min-width: 640px) { .featured-card__img { width: 45%; height: auto; min-height: 280px; } }
        .featured-card__body { padding: 24px; }
        @media (min-width: 640px) { .featured-card__body { padding: 32px; display: flex; flex-direction: column; justify-content: center; } }
        .featured-card__cat {
            display: inline-block; padding: 4px 12px; border-radius: var(--radius-xs);
            background: var(--primary-bg); color: var(--primary); font-size: 11px;
            font-weight: 600; letter-spacing: 0.04em; width: fit-content;
        }
        .featured-card__title {
            font-size: 26px; font-weight: 700; line-height: 1.2; color: var(--text-primary);
            margin: 12px 0 12px;
        }
        @media (min-width: 640px) { .featured-card__title { font-size: 30px; } }
        .featured-card__excerpt { font-size: 15px; line-height: 1.6; color: var(--text-secondary); margin-bottom: 16px; }
        .featured-card__meta { display: flex; align-items: center; gap: 12px; font-size: 13px; color: var(--text-tertiary); }
        .featured-card__meta span { display: flex; align-items: center; gap: 6px; }

        .articles-grid { display: grid; grid-template-columns: 1fr; gap: 20px; }
        @media (min-width: 768px) { .articles-grid { grid-template-columns: repeat(2, 1fr); } }
        .article-card {
            display: flex; flex-direction: column;
            background: var(--bg-card); border-radius: var(--radius-s);
            box-shadow: var(--shadow-card); overflow: hidden;
            transition: box-shadow var(--transition-slow);
            border: 1px solid var(--border-default);
        }
        .article-card:hover { box-shadow: var(--shadow-card-hover); }
        .article-card__img { width: 100%; height: 200px; object-fit: cover; background: var(--bg-input); }
        .article-card__body { padding: 20px; display: flex; flex-direction: column; flex: 1; }
        .article-card__cat { display: inline-block; padding: 4px 12px; border-radius: var(--radius-xs); background: var(--primary-bg); color: var(--primary); font-size: 11px; font-weight: 600; letter-spacing: 0.04em; width: fit-content; margin-bottom: 10px; }
        .article-card__title { font-size: 18px; font-weight: 700; line-height: 1.3; color: var(--text-primary); margin: 0 0 8px; }
        .article-card__excerpt { font-size: 14px; line-height: 1.6; color: var(--text-secondary); flex: 1; margin-bottom: 16px; }
        .article-card__meta { display: flex; align-items: center; justify-content: space-between; font-size: 13px; color: var(--text-tertiary); }
        .article-card__link { font-weight: 600; color: var(--primary); }

        .pagination { display: flex; justify-content: center; gap: 6px; margin-top: 40px; }
        .pagination__btn {
            min-width: 40px; height: 40px; border-radius: var(--radius-xs);
            border: 1px solid var(--border-default); background: var(--bg-white); color: var(--text-secondary);
            font-size: 14px; font-weight: 500; font-family: 'Onest', sans-serif;
            cursor: pointer; transition: all var(--transition-fast);
            display: flex; align-items: center; justify-content: center;
        }
        .pagination__btn:hover { border-color: var(--primary); color: var(--primary); }
        .pagination__btn--active { background: var(--primary); color: #fff; border-color: var(--primary); }

        .blog-sidebar { display: flex; flex-direction: column; gap: 20px; }
        @media (min-width: 1024px) { .blog-sidebar { position: sticky; top: 112px; height: fit-content; } }
        .sidebar-widget {
            background: var(--bg-white); border-radius: var(--radius-s);
            box-shadow: var(--shadow-card); border: 1px solid var(--border-default);
            overflow: hidden;
        }
        .sidebar-widget__header {
            padding: 16px 20px 8px;
            font-size: 13px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.05em; color: var(--text-secondary);
        }
        .sidebar-widget__body { padding: 4px 20px 16px; }

        .popular-item { display: flex; gap: 12px; padding: 10px 0; text-decoration: none; border-bottom: 1px solid var(--border-light); }
        .popular-item:last-child { border-bottom: none; }
        .popular-item__img { width: 72px; height: 56px; object-fit: cover; border-radius: var(--radius-xs); background: var(--bg-input); flex-shrink: 0; }
        .popular-item__title { font-size: 13px; font-weight: 500; line-height: 1.4; color: var(--text-primary); margin-bottom: 4px; }
        .popular-item__meta { font-size: 11px; color: var(--text-tertiary); }

        .categories-list { list-style: none; margin: 0; padding: 0; }
        .categories-list li { margin-bottom: 6px; }
        .categories-list a { display: flex; justify-content: space-between; font-size: 13px; color: var(--text-secondary); padding: 6px 0; transition: color var(--transition-fast); }
        .categories-list a:hover { color: var(--primary); }
        .categories-list .count { color: var(--text-tertiary); font-size: 12px; }

        .tags-cloud { display: flex; flex-wrap: wrap; gap: 6px; }
        .tags-cloud a { padding: 4px 12px; border-radius: var(--radius-xs); background: var(--bg-input); color: var(--text-secondary); font-size: 11px; font-weight: 500; transition: all var(--transition-fast); }
        .tags-cloud a:hover { background: var(--primary-bg); color: var(--primary); }

        .sidebar-services-item { display: flex; align-items: center; gap: 10px; padding: 8px; border-radius: var(--radius-xs); text-decoration: none; transition: background var(--transition-fast); }
        .sidebar-services-item:hover { background: var(--bg-hover); }
        .sidebar-services-icon { width: 36px; height: 36px; min-width: 36px; border-radius: var(--radius-xs); background: var(--bg-input); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); }
        .sidebar-services-title { font-size: 13px; font-weight: 600; color: var(--text-primary); }
        .sidebar-services-desc { font-size: 11px; color: var(--text-secondary); }

        .cta-section { background: var(--bg-white); padding: 56px 0; margin-top: 40px; border-top: 1px solid var(--border-default); }
        .cta-section__title { font-size: 28px; font-weight: 700; color: var(--text-primary); margin: 0 0 12px; text-align: center; }
        @media (min-width: 640px) { .cta-section__title { font-size: 32px; } }
        .cta-section__desc { font-size: 15px; line-height: 1.6; color: var(--text-secondary); max-width: 560px; margin: 0 auto 24px; text-align: center; }
        .cta-section__actions { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }
        .cta-btn { display: inline-flex; align-items: center; justify-content: center; height: 48px; padding: 0 32px; border-radius: var(--radius-xs); font-size: 14px; font-weight: 600; font-family: 'Onest', sans-serif; transition: all var(--transition-fast); cursor: pointer; }
        .cta-btn--primary { background: var(--primary); color: #fff; border: none; }
        .cta-btn--primary:hover { background: var(--primary-dark); }
        .cta-btn--outline { background: transparent; color: var(--text-primary); border: 1px solid var(--border-default); }
        .cta-btn--outline:hover { border-color: var(--text-secondary); background: var(--bg-hover); }

        .hidden { display: none !important; }
        *:focus-visible { outline: 2px solid var(--primary); outline-offset: 2px; }
    </style>
</head>
<body>
<?php include __DIR__ . '/../components/header-shared.php'; ?>

<main class="w-full">
    <div class="page-header">
        <div class="blog-layout">
            <span class="page-header__label">Блог</span>
            <h1 class="page-header__title">Экспертиза металлопроката</h1>
            <p class="page-header__desc">Статьи для закупщиков, инженеров и стройконтроля: как выбрать арматуру, рассчитать вес балки, какой ГОСТ актуален в 2026 году и где сэкономить на закупке без потери качества.</p>
        </div>
    </div>

    <div class="blog-main">
        <div class="blog-layout">
            <div class="blog-main__grid">
                <div class="blog-content" id="blog-content">
                    <!-- Search -->
                    <div class="search-bar">
                        <svg class="search-bar__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        <input type="text" id="search-input" placeholder="Поиск по статьям..." autocomplete="off">
                    </div>

                    <!-- Category filters -->
                    <div class="cat-filters" id="cat-filters">
                        <?php foreach ($categories as $i => $cat): ?>
                            <button class="cat-filters__btn<?= $i === 0 ? ' cat-filters__btn--active' : '' ?>" data-filter="<?= htmlspecialchars($cat) ?>">
                                <?= htmlspecialchars($cat) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <!-- Featured article -->
                    <?php if ($featured): ?>
                        <?php
                        $fUrl = $site['baseUrl'] . '/blog/' . htmlspecialchars($featured['slug']);
                        $fImg = $featured['image'] ?? '/public/assets/images/bgpage/product.png';
                        $fImg = (str_starts_with($fImg, 'http')) ? $fImg : $site['baseUrl'] . $fImg;
                        $fDate = date('d.m.Y', strtotime($featured['created_at'] ?? 'now'));
                        $fExcerpt = mb_substr(strip_tags($featured['content'] ?? ''), 0, 140) . '...';
                        ?>
                        <a href="<?= $fUrl ?>" class="featured-card">
                            <img class="featured-card__img" src="<?= htmlspecialchars($fImg) ?>" alt="<?= htmlspecialchars($featured['title']) ?>" loading="eager">
                            <div class="featured-card__body">
                                <span class="featured-card__cat"><?= htmlspecialchars($featured['category'] ?? 'Статья') ?></span>
                                <h2 class="featured-card__title"><?= htmlspecialchars($featured['title']) ?></h2>
                                <p class="featured-card__excerpt"><?= htmlspecialchars($fExcerpt) ?></p>
                                <div class="featured-card__meta">
                                    <span><?= htmlspecialchars($fDate) ?></span>
                                    <span>·</span>
                                    <span><?= htmlspecialchars($featured['author'] ?? $site['company']) ?></span>
                                </div>
                            </div>
                        </a>
                    <?php endif; ?>

                    <!-- Articles grid -->
                    <div class="articles-grid" id="articles-container">
                        <?php foreach ($articles as $article): ?>
                            <?php
                            $aUrl = $site['baseUrl'] . '/blog/' . htmlspecialchars($article['slug']);
                            $aImg = $article['image'] ?? '/public/assets/images/bgpage/product.png';
                            $aImg = (str_starts_with($aImg, 'http')) ? $aImg : $site['baseUrl'] . $aImg;
                            $aDate = date('d.m.Y', strtotime($article['created_at'] ?? 'now'));
                            $aExcerpt = mb_substr(strip_tags($article['content'] ?? ''), 0, 100) . '...';
                            ?>
                            <a href="<?= $aUrl ?>" class="article-card" data-category="<?= htmlspecialchars($article['category'] ?? '') ?>">
                                <img class="article-card__img" src="<?= htmlspecialchars($aImg) ?>" alt="<?= htmlspecialchars($article['title']) ?>" loading="lazy">
                                <div class="article-card__body">
                                    <span class="article-card__cat"><?= htmlspecialchars($article['category'] ?? 'Статья') ?></span>
                                    <h3 class="article-card__title"><?= htmlspecialchars($article['title']) ?></h3>
                                    <p class="article-card__excerpt"><?= htmlspecialchars($aExcerpt) ?></p>
                                    <div class="article-card__meta">
                                        <span><?= htmlspecialchars($aDate) ?></span>
                                        <span class="article-card__link">Читать →</span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination (placeholder, JS will render) -->
                    <div class="pagination" id="pagination"></div>
                </div>

                <!-- Sidebar -->
                <aside class="blog-sidebar">
                    <!-- Popular articles -->
                    <div class="sidebar-widget">
                        <div class="sidebar-widget__header">Популярное</div>
                        <div class="sidebar-widget__body" id="popular-container">
                            <?php
                            $popular = array_slice($articles, 0, 4);
                            foreach ($popular as $p):
                                $pUrl = $site['baseUrl'] . '/blog/' . htmlspecialchars($p['slug']);
                                $pImg = $p['image'] ?? '/public/assets/images/bgpage/product.png';
                                $pImg = (str_starts_with($pImg, 'http')) ? $pImg : $site['baseUrl'] . $pImg;
                                $pDate = date('d.m.Y', strtotime($p['created_at'] ?? 'now'));
                            ?>
                                <a href="<?= $pUrl ?>" class="popular-item">
                                    <img class="popular-item__img" src="<?= htmlspecialchars($pImg) ?>" alt="<?= htmlspecialchars($p['title']) ?>" loading="lazy">
                                    <div>
                                        <div class="popular-item__title"><?= htmlspecialchars($p['title']) ?></div>
                                        <div class="popular-item__meta"><?= htmlspecialchars($pDate) ?></div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="sidebar-widget">
                        <div class="sidebar-widget__header">Категории</div>
                        <div class="sidebar-widget__body">
                            <ul class="categories-list">
                                <?php foreach (array_slice($categories, 1) as $cat): ?>
                                    <?php
                                    $count = 0;
                                    foreach ($articles as $a) { if (($a['category'] ?? '') === $cat) $count++; }
                                    if ($featured && ($featured['category'] ?? '') === $cat) $count++;
                                    ?>
                                    <li><a href="/blog?cat=<?= urlencode($cat) ?>"><?= htmlspecialchars($cat) ?> <span class="count">(<?= $count ?>)</span></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Tags cloud -->
                    <div class="sidebar-widget">
                        <div class="sidebar-widget__header">Теги</div>
                        <div class="sidebar-widget__body">
                            <div class="tags-cloud">
                                <?php
                                $allTags = [];
                                foreach (array_merge([$featured], $articles) as $a) {
                                    if (!empty($a['tags'])) {
                                        $tags = array_map('trim', explode(',', $a['tags']));
                                        foreach ($tags as $t) if ($t) $allTags[$t] = ($allTags[$t] ?? 0) + 1;
                                    }
                                }
                                arsort($allTags);
                                foreach (array_slice($allTags, 0, 15) as $tag => $cnt):
                                ?>
                                    <a href="/blog?tag=<?= urlencode($tag) ?>">#<?= htmlspecialchars($tag) ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Services widget (like atelier) -->
                    <div class="sidebar-widget">
                        <div class="sidebar-widget__header">Наши услуги</div>
                        <div class="sidebar-widget__body">
                            <a href="/delivery" class="sidebar-services-item">
                                <div class="sidebar-services-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V7a2 2 0 00-2-2H7a2 2 0 00-2 2v9a2 2 0 002 2h4a2 2 0 002-2v-2.5"/></svg>
                                </div>
                                <div>
                                    <div class="sidebar-services-title">Доставка по Москве и МО</div>
                                    <div class="sidebar-services-desc">Собственный автопарк, погрузка входит в стоимость</div>
                                </div>
                            </a>
                            <a href="/blog/rezka-metalla-v-razmer" class="sidebar-services-item">
                                <div class="sidebar-services-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.121 2.121"/></svg>
                                </div>
                                <div>
                                    <div class="sidebar-services-title">Резка металла в размер</div>
                                    <div class="sidebar-services-desc">Гильотина, ленточная пила, плазма — точность ±2 мм</div>
                                </div>
                            </a>
                            <a href="/contacts" class="sidebar-services-item">
                                <div class="sidebar-services-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <div class="sidebar-services-title">Консультация закупщика</div>
                                    <div class="sidebar-services-desc">Бесплатно подберем оптимальный сорт и размер</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section">
        <div class="blog-layout">
            <div class="cta-section__title">Нужна консультация по закупке металла?</div>
            <p class="cta-section__desc">Позвоните или напишите — подберем оптимальный сорт, рассчитаем вес и стоимость, организуем доставку в удобные сроки.</p>
            <div class="cta-section__actions">
                <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>" class="cta-btn cta-btn--primary">Позвонить: <?= htmlspecialchars($site['phone'] ?? '+7 (495) 989-24-20') ?></a>
                <a href="/contacts" class="cta-btn cta-btn--outline">Написать нам</a>
            </div>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/../components/footer.php'; ?>

<script>
// Данные статей для клиентского рендера (фильтрация/поиск/пагинация)
window.__BLOG_ARTICLES__ = <?= json_encode(array_merge([$featured], $articles), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

var allArticles = window.__BLOG_ARTICLES__ || [];
var currentFilter = 'all';
var currentTag = '';
var currentPage = 1;
var perPage = 6;
var searchQuery = '';

document.addEventListener('DOMContentLoaded', function () {
    renderAll();
    bindSearch();
});

function bindSearch() {
    var input = document.getElementById('search-input');
    if (!input) return;
    input.addEventListener('input', function() {
        searchQuery = this.value.trim().toLowerCase();
        currentPage = 1;
        renderArticles();
        var fc = document.querySelector('.featured-card');
        if (fc) fc.style.display = searchQuery ? 'none' : '';
    });
}

function renderAll() {
    renderFilters();
    renderPopular();
    renderArticles();
}

function renderFilters() {
    var container = document.getElementById('cat-filters');
    var cats = ['all', ...new Set(allArticles.map(a => a.category).filter(Boolean))];
    var html = '';
    cats.forEach(function(c, i) {
        var label = c === 'all' ? 'Все статьи' : c;
        html += '<button data-filter="' + c + '" class="cat-filters__btn' + (i === 0 ? ' cat-filters__btn--active' : '') + '">' + label + '</button>';
    });
    container.innerHTML = html;
    container.querySelectorAll('.cat-filters__btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            container.querySelectorAll('.cat-filters__btn').forEach(function(b) { b.classList.remove('cat-filters__btn--active'); });
            this.classList.add('cat-filters__btn--active');
            currentFilter = this.dataset.filter;
            currentPage = 1;
            renderArticles();
        });
    });
}

function renderPopular() {
    var container = document.getElementById('popular-container');
    var popular = allArticles.slice(0, 4);
    var html = '';
    popular.forEach(function(p) {
        var img = p.image ? (p.image.startsWith('http') ? p.image : p.image) : '/public/assets/images/bgpage/product.png';
        var date = p.created_at ? new Date(p.created_at).toLocaleDateString('ru-RU', {day:'2-digit',month:'2-digit',year:'numeric'}) : '';
        html += '<a href="/blog/' + p.slug + '" class="popular-item"><img class="popular-item__img" src="' + img + '" alt="' + p.title + '" loading="lazy"><div><div class="popular-item__title">' + p.title + '</div><div class="popular-item__meta">' + date + '</div></div></a>';
    });
    container.innerHTML = html;
}

function renderArticles() {
    var container = document.getElementById('articles-container');
    var filtered = allArticles.filter(function(a) {
        var catMatch = currentFilter === 'all' || a.category === currentFilter;
        var searchMatch = !searchQuery || a.title.toLowerCase().includes(searchQuery) || (a.category && a.category.toLowerCase().includes(searchQuery)) || (a.tags && a.tags.toLowerCase().includes(searchQuery));
        var tagMatch = !currentTag || (a.tags && a.tags.toLowerCase().includes(currentTag));
        return catMatch && searchMatch && tagMatch;
    });

    if (filtered.length === 0) {
        container.innerHTML = searchQuery
            ? '<div style="text-align:center;padding:60px 20px;color:#6b7280"><div style="font-size:18px;font-weight:500;margin-bottom:8px">Ничего не найдено</div><div>Попробуйте изменить запрос</div></div>'
            : '<div style="text-align:center;padding:60px 20px;color:#6b7280"><div>Нет статей в этой категории</div></div>';
        document.getElementById('pagination').innerHTML = '';
        return;
    }

    var totalPages = Math.ceil(filtered.length / perPage);
    var start = (currentPage - 1) * perPage;
    var pageArticles = filtered.slice(start, start + perPage);

    var html = '';
    pageArticles.forEach(function(a) {
        var img = a.image ? (a.image.startsWith('http') ? a.image : a.image) : '/public/assets/images/bgpage/product.png';
        var date = a.created_at ? new Date(a.created_at).toLocaleDateString('ru-RU', {day:'2-digit',month:'2-digit',year:'numeric'}) : '';
        var excerpt = (a.content || '').replace(/<[^>]*>/g, '').substring(0, 100) + '...';
        html += '<a href="/blog/' + a.slug + '" class="article-card" data-category="' + (a.category || '') + '">' +
            '<img class="article-card__img" src="' + img + '" alt="' + a.title + '" loading="lazy">' +
            '<div class="article-card__body">' +
            '<span class="article-card__cat">' + (a.category || 'Статья') + '</span>' +
            '<h3 class="article-card__title">' + a.title + '</h3>' +
            '<p class="article-card__excerpt">' + excerpt + '</p>' +
            '<div class="article-card__meta"><span>' + date + '</span><span class="article-card__link">Читать →</span></div>' +
            '</div></a>';
    });
    container.innerHTML = html;
    renderPagination(filtered.length);
}

function renderPagination(total) {
    var container = document.getElementById('pagination');
    var totalPages = Math.ceil(total / perPage);
    if (totalPages <= 1) { container.innerHTML = ''; return; }
    var html = '';
    for (var i = 1; i <= totalPages; i++) {
        html += '<button class="pagination__btn' + (i === currentPage ? ' pagination__btn--active' : '') + '" data-page="' + i + '">' + i + '</button>';
    }
    container.innerHTML = html;
    container.querySelectorAll('.pagination__btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            currentPage = parseInt(this.dataset.page);
            renderArticles();
        });
    });
}
</script>
</body>
</html>