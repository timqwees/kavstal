<?php
$site = Setting\route\function\Functions::site();
$slug = $slug ?? ($_GET['slug'] ?? '');
$articlesFile = __DIR__ . '/data/articles.json';
$articles = [];
if (file_exists($articlesFile)) {
    $articles = json_decode(file_get_contents($articlesFile), true) ?? [];
}
$article = null;
foreach ($articles as $a) {
    if (($a['slug'] ?? '') === $slug) { $article = $a; break; }
}
if (!$article) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

$pageUrl = $site['baseUrl'] . '/blog/' . htmlspecialchars($article['slug']);
$rawImg = $article['image'] ?? '/public/assets/images/bgpage/product.png';
$ogImg = (str_starts_with($rawImg, 'http://') || str_starts_with($rawImg, 'https://')) ? $rawImg : $site['baseUrl'] . $rawImg;
$datePublished = $article['created_at'] ?? '';
$dateModified = $article['updated_at'] ?? $datePublished;

// Рендер контента (markdown-like → HTML)
function renderContent(string $text): string {
    if (!$text) return '';
    $html = $text;
    // Escape HTML first
    $html = htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
    // h3
    $html = preg_replace('/^###\s+(.+)$/m', '<h3>$1</h3>', $html);
    // h2
    $html = preg_replace('/^##\s+(.+)$/m', '<h2>$1</h2>', $html);
    // h1
    $html = preg_replace('/^#\s+(.+)$/m', '<h1>$1</h1>', $html);
    // blockquote
    $html = preg_replace('/^>\s+(.+)$/m', '<blockquote><p>$1</p></blockquote>', $html);
    // bold/italic
    $html = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $html);
    $html = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $html);
    // lists
    $lines = explode("\n", $html);
    $inList = false;
    $result = [];
    foreach ($lines as $line) {
        if (preg_match('/^-\s+(.+)$/', $line, $m)) {
            if (!$inList) { $result[] = '<ul>'; $inList = 'ul'; }
            $result[] = '<li>' . $m[1] . '</li>';
        } elseif ($inList) {
            $result[] = '</' . $inList . '>';
            $inList = false;
            $result[] = $line;
        } else {
            $result[] = $line;
        }
    }
    if ($inList) $result[] = '</' . $inList . '>';
    $html = implode("\n", $result);
    // paragraphs
    $html = preg_replace('/\n\n+/', '</p><p>', $html);
    $html = preg_replace('/\n/', '<br>', $html);
    $html = '<p>' . $html . '</p>';
    // cleanup
    $html = preg_replace('/<p>\s*<(h[1-3]|ul|ol|li|blockquote)/', '<$1', $html);
    $html = preg_replace('/<\/(h[1-3]|ul|ol|li|blockquote)>\s*<\/p>/', '</$1>', $html);
    $html = preg_replace('/<p>\s*<\/p>/', '', $html);
    return $html;
}

$contentHtml = renderContent($article['content'] ?? '');

// Похожие статьи
$related = array_filter($articles, fn($a) => ($a['slug'] ?? '') !== $slug && ($a['category'] ?? '') === ($article['category'] ?? ''));
if (count($related) < 3) {
    foreach ($articles as $a) {
        if (($a['slug'] ?? '') !== $slug && count($related) < 3 && !in_array($a, $related, true)) $related[] = $a;
    }
}
$related = array_slice(array_values($related), 0, 3);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title'] . ' — Блог КАВ СТАЛЬ') ?></title>
    <meta name="description" content="<?= htmlspecialchars($article['metaDescription'] ?? $article['excerpt'] ?? '') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($article['tags'] ?? '') ?>">
    <link rel="canonical" href="<?= htmlspecialchars($pageUrl) ?>">
    <link rel="alternate" type="application/rss+xml" title="Блог КАВ СТАЛЬ — RSS" href="<?= htmlspecialchars($site['baseUrl'] . '/rss.xml') ?>">
    <meta property="og:title" content="<?= htmlspecialchars($article['title'] . ' — Блог КАВ СТАЛЬ') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($article['metaDescription'] ?? $article['excerpt'] ?? '') ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= htmlspecialchars($pageUrl) ?>">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="<?= htmlspecialchars($ogImg) ?>">
    <meta property="article:published_time" content="<?= htmlspecialchars($datePublished) ?>">
    <meta property="article:modified_time" content="<?= htmlspecialchars($dateModified) ?>">
    <?php if (!empty($article['category'])): ?><meta property="article:section" content="<?= htmlspecialchars($article['category']) ?>"><?php endif; ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($article['title'] . ' — Блог КАВ СТАЛЬ') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($article['metaDescription'] ?? $article['excerpt'] ?? '') ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImg) ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= htmlspecialchars($article['author'] ?? $site['company']) ?>">

    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="stylesheet" href="/public/assets/styles/catalog.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <?php include_once __DIR__ . '/../components/seo-head.php'; ?>
    
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { margin: 0; font-family: 'Onest', system-ui, -apple-system, sans-serif; background: var(--bg-page); color: var(--text-primary); -webkit-font-smoothing: antialiased; }
        img { max-width: 100%; display: block; }
        a { color: inherit; text-decoration: none; }

        .blog-layout { max-width: 1280px; margin: 0 auto; padding: 0 24px; }

        .article-back { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-tertiary); transition: color var(--transition-fast); margin-bottom: 24px; }
        .article-back:hover { color: var(--primary); }
        .article-back__icon { width: 14px; height: 14px; }

        .article-header { padding: 48px 0 0; }
        .article-header__meta { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
        .article-header__cat { display: inline-block; padding: 4px 12px; border-radius: var(--radius-xs); background: var(--primary-bg); color: var(--primary); font-size: 11px; font-weight: 600; letter-spacing: 0.04em; }
        .article-header__date { font-size: 12px; color: var(--text-tertiary); }
        .article-header__title { font-size: 32px; font-weight: 700; line-height: 1.2; color: var(--text-primary); margin: 0 0 16px; }
        @media (min-width: 640px) { .article-header__title { font-size: 36px; } }
        .article-header__author { display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--text-secondary); margin-bottom: 12px; }
        .article-header__avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--bg-input); color: var(--text-secondary); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; }
        .article-header__tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 32px; }
        .article-header__tag { display: inline-block; padding: 4px 12px; border-radius: var(--radius-xs); background: var(--bg-input); color: var(--text-secondary); font-size: 11px; font-weight: 500; }

        .article-hero { margin-bottom: 40px; }
        .article-hero__img { width: 100%; max-height: 340px; object-fit: cover; border-radius: var(--radius-s); background: var(--bg-input); }
        @media (min-width: 640px) { .article-hero__img { max-height: 400px; } }

        .article-body-wrap { padding-bottom: 48px; }
        .article-body__grid { display: grid; grid-template-columns: 1fr; gap: 40px; }
        @media (min-width: 1024px) { .article-body__grid { grid-template-columns: 1fr 280px; } }

        .article-content { font-size: 16px; line-height: 1.75; color: var(--text-primary); }
        .article-content h2 { font-size: 24px; font-weight: 700; margin-top: 2em; margin-bottom: 0.5em; color: var(--text-primary); padding-bottom: 0.3em; border-bottom: 1px solid var(--border-default); }
        .article-content h3 { font-size: 19px; font-weight: 600; margin-top: 1.5em; margin-bottom: 0.4em; color: var(--text-primary); }
        .article-content p { margin-bottom: 1.1em; }
        .article-content ul, .article-content ol { margin-bottom: 1.25em; padding-left: 1.2em; }
        .article-content li { margin-bottom: 0.35em; line-height: 1.6; }
        .article-content strong { font-weight: 600; color: var(--text-primary); }
        .article-content blockquote { padding: 1.25em 1.5em; margin: 1.5em 0; background: var(--bg-page); border-radius: var(--radius-xs); font-size: 0.95em; color: var(--text-secondary); border-left: 3px solid var(--border-default); }
        .article-content blockquote p { margin-bottom: 0; }
        .article-content img { width: 100%; border-radius: var(--radius-s); margin: 1.5em 0; box-shadow: var(--shadow-card); }
        .article-content a { color: var(--text-link); text-decoration: underline; text-decoration-color: var(--ozon-blue-light); text-underline-offset: 3px; transition: text-decoration-color var(--transition-fast); }
        .article-content a:hover { text-decoration-color: var(--ozon-blue); }

        .article-content .tip-box { background: var(--bg-page); border-radius: var(--radius-xs); padding: 1.25em 1.5em; margin: 1.5em 0; border-left: 3px solid var(--text-tertiary); }
        .article-content .tip-box strong:first-child { display: block; font-size: 0.85em; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-secondary); margin-bottom: 0.25em; }
        .article-content .info-box { background: var(--bg-page); border-radius: var(--radius-xs); padding: 1.25em 1.5em; margin: 1.5em 0; }

        .article-sidebar { display: flex; flex-direction: column; gap: 20px; }
        @media (min-width: 1024px) { .article-sidebar { position: sticky; top: 112px; height: fit-content; } }
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

        .toc-link { display: block; padding: 6px 10px; font-size: 13px; color: var(--text-secondary); border-radius: var(--radius-xs); transition: all var(--transition-fast); margin-bottom: 2px; }
        .toc-link:hover { color: var(--primary); background: var(--primary-bg); }

        .sidebar-services-item { display: flex; align-items: center; gap: 10px; padding: 8px; border-radius: var(--radius-xs); text-decoration: none; transition: background var(--transition-fast); }
        .sidebar-services-item:hover { background: var(--bg-hover); }
        .sidebar-services-icon { width: 36px; height: 36px; min-width: 36px; border-radius: var(--radius-xs); background: var(--bg-input); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); }
        .sidebar-services-title { font-size: 13px; font-weight: 600; color: var(--text-primary); }
        .sidebar-services-desc { font-size: 11px; color: var(--text-secondary); }

        .related-section { padding-top: 48px; border-top: 1px solid var(--border-default); }
        .related-section__title { font-size: 22px; font-weight: 700; margin: 0 0 24px; color: var(--text-primary); }
        .related-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        .related-card { display: block; background: var(--bg-white); border-radius: var(--radius-s); box-shadow: var(--shadow-card); overflow: hidden; transition: box-shadow var(--transition-slow); border: 1px solid var(--border-default); }
        .related-card:hover { box-shadow: var(--shadow-card-hover); }
        .related-card__img { width: 100%; height: 160px; object-fit: cover; background: var(--bg-input); }
        .related-card__body { padding: 16px; }
        .related-card__title { font-size: 17px; font-weight: 600; line-height: 1.3; margin: 0 0 8px; color: var(--text-primary); }
        .related-card__meta { font-size: 12px; color: var(--text-tertiary); }

        .cta-section { margin-top: 80px; padding: 48px 0; background: var(--bg-white); border-top: 1px solid var(--border-default); }
        .cta-section__title { font-size: 28px; font-weight: 700; margin: 0 0 12px; color: var(--text-primary); text-align: center; }
        .cta-section__desc { font-size: 15px; color: var(--text-secondary); max-width: 560px; margin: 0 auto 24px; text-align: center; }
        .cta-section__actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .cta-btn { display: inline-flex; align-items: center; justify-content: center; padding: 12px 24px; border-radius: var(--radius-xs); font-size: 14px; font-weight: 600; font-family: 'Onest', sans-serif; transition: all var(--transition-fast); cursor: pointer; }
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

<main class="max-w-7xl mx-auto px-4 py-8">
    <div class="blog-layout">
        <article id="article-content">
            <div class="article-header">
                <a href="<?= htmlspecialchars($site['baseUrl']) ?>/blog" class="article-back">
                    <svg class="article-back__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Все статьи
                </a>

                <div class="article-header__meta">
                    <span class="article-header__cat"><?= htmlspecialchars($article['category'] ?? 'Статья') ?></span>
                    <span class="article-header__date"><?= htmlspecialchars(date('d.m.Y', strtotime($datePublished))) ?></span>
                </div>

                <h1 class="article-header__title"><?= htmlspecialchars($article['title']) ?></h1>

                <div class="article-header__author">
                    <span class="article-header__avatar"><?= htmlspecialchars(mb_substr($article['author'] ?? $site['company'], 0, 1)) ?></span>
                    <span><?= htmlspecialchars($article['author'] ?? $site['company']) ?></span>
                </div>

                <?php if (!empty($article['tags'])): ?>
                <div class="article-header__tags">
                    <?php foreach (explode(',', $article['tags']) as $tag):
                        $tag = trim($tag); if ($tag): ?>
                        <span class="article-header__tag">#<?= htmlspecialchars($tag) ?></span>
                    <?php endif; endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <?php if ($rawImg): ?>
            <div class="article-hero">
                <img class="article-hero__img" src="<?= htmlspecialchars($ogImg) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
            </div>
            <?php endif; ?>

            <div class="article-body-wrap">
                <div class="article-body__grid">
                    <div>
                        <div class="article-content" id="article-body"><?= $contentHtml ?></div>
                    </div>
                    <aside class="article-sidebar">
                        <div id="toc-container" class="sidebar-widget hidden">
                            <div class="sidebar-widget__header">Содержание</div>
                            <div class="sidebar-widget__body" id="toc-body"></div>
                        </div>

                        <div class="sidebar-widget">
                            <div class="sidebar-widget__header">Наши услуги</div>
                            <div class="sidebar-widget__body">
                                <a href="/delivery" class="sidebar-services-item">
                                    <div class="sidebar-services-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V7a2 2 0 00-2-2H7a2 2 0 00-2 2v9a2 2 0 002 2h4a2 2 0 002-2v-2.5"/></svg></div>
                                    <div><div class="sidebar-services-title">Доставка по Москве и МО</div><div class="sidebar-services-desc">Собственный автопарк, погрузка входит в стоимость</div></div>
                                </a>
                                <a href="/blog/rezka-metalla-v-razmer" class="sidebar-services-item">
                                    <div class="sidebar-services-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.121 2.121"/></svg></div>
                                    <div><div class="sidebar-services-title">Резка металла в размер</div><div class="sidebar-services-desc">Гильотина, ленточная пила, плазма — точность ±2 мм</div></div>
                                </a>
                                <a href="/contacts" class="sidebar-services-item">
                                    <div class="sidebar-services-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                                    <div><div class="sidebar-services-title">Консультация закупщика</div><div class="sidebar-services-desc">Бесплатно подберем оптимальный сорт и размер</div></div>
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </article>

        <section class="related-section">
            <h3 class="related-section__title">Читайте также</h3>
            <div class="related-grid">
                <?php foreach ($related as $r):
                    $rImg = $r['image'] ?? '/public/assets/images/bgpage/product.png';
                    $rImg = (str_starts_with($rImg, 'http://') || str_starts_with($rImg, 'https://')) ? $rImg : $site['baseUrl'] . $rImg;
                    $rDate = date('d.m.Y', strtotime($r['created_at'] ?? 'now'));
                ?>
                <a href="<?= htmlspecialchars($site['baseUrl'] . '/blog/' . $r['slug']) ?>" class="related-card">
                    <img class="related-card__img" src="<?= htmlspecialchars($rImg) ?>" alt="<?= htmlspecialchars($r['title']) ?>" loading="lazy">
                    <div class="related-card__body">
                        <div class="related-card__title"><?= htmlspecialchars($r['title']) ?></div>
                        <div class="related-card__meta"><?= htmlspecialchars($rDate) ?></div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

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
document.addEventListener('DOMContentLoaded', function() {
    // TOC generation
    var articleBody = document.getElementById('article-body');
    var tocContainer = document.getElementById('toc-container');
    var tocBody = document.getElementById('toc-body');
    if (articleBody && tocContainer && tocBody) {
        var h2s = articleBody.querySelectorAll('h2');
        if (h2s.length >= 2) {
            tocContainer.classList.remove('hidden');
            h2s.forEach(function(h2, i) {
                var id = 'toc-' + i;
                h2.id = id;
                var link = document.createElement('a');
                link.href = '#' + id;
                link.className = 'toc-link';
                link.textContent = h2.textContent;
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    h2.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    history.pushState(null, '', '#' + id);
                });
                tocBody.appendChild(link);
            });
        }
    }
});
</script>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": <?= json_encode($article['title'], JSON_UNESCAPED_UNICODE) ?>,
    "description": <?= json_encode($article['metaDescription'] ?? $article['excerpt'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
    "image": <?= json_encode($ogImg, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
    "author": { "@type": "Organization", "name": <?= json_encode($article['author'] ?? $site['company'], JSON_UNESCAPED_UNICODE) ?> },
    "publisher": {
        "@type": "Organization",
        "name": <?= json_encode($site['company'], JSON_UNESCAPED_UNICODE) ?>,
        "logo": { "@type": "ImageObject", "url": <?= json_encode($site['baseUrl'] . '/public/assets/images/icons/favicon/favicon.svg', JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?> }
    },
    "datePublished": <?= json_encode($datePublished, JSON_UNESCAPED_UNICODE) ?>,
    "dateModified": <?= json_encode($dateModified, JSON_UNESCAPED_UNICODE) ?>,
    "url": <?= json_encode($pageUrl, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
}
</script>
</body>
</html>