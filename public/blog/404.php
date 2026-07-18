<?php
$site = $site ?? Setting\route\function\Functions::site();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница не найдена — КАВ СТАЛЬ</title>
    <meta name="robots" content="noindex, follow">
    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
    <link rel="stylesheet" href="/public/assets/styles/catalog.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Onest', system-ui, -apple-system, sans-serif;
            background: var(--bg-page, #f5f5f5);
            color: var(--text-primary, #111);
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }

        .error-wrap {
            display: flex; align-items: center; justify-content: center;
            min-height: 80vh; padding: 24px;
        }
        .error-card {
            background: var(--bg-white, #fff);
            border: 1px solid var(--border-default, #e5e7eb);
            border-radius: var(--radius-m, 16px);
            padding: 48px 40px; text-align: center;
            max-width: 440px; width: 100%;
        }
        .error-code {
            font-size: 72px; font-weight: 800;
            color: var(--primary, #dc2626); line-height: 1; margin-bottom: 8px;
        }
        .error-title {
            font-size: 20px; font-weight: 600;
            color: var(--text-primary, #111); margin-bottom: 8px;
        }
        .error-desc {
            font-size: 14px; color: var(--text-secondary, #6b7280); margin-bottom: 24px;
        }
        .error-link {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 28px; border-radius: 999px;
            background: var(--primary, #dc2626); color: #fff;
            font-size: 14px; font-weight: 600; text-decoration: none;
            transition: background var(--transition-fast, 0.15s);
        }
        .error-link:hover { background: var(--primary-dark, #b91c1c); }
        *:focus-visible { outline: 2px solid var(--ozon-blue, #005bff); outline-offset: 2px; }
    </style>
</head>
<body>
<?php include __DIR__ . '/../components/header-shared.php'; ?>
<div class="error-wrap">
    <div class="error-card">
        <div class="error-code">404</div>
        <div class="error-title">Страница не найдена</div>
        <div class="error-desc">Статья не найдена или была удалена.</div>
        <a href="<?= htmlspecialchars($site['baseUrl']) ?>/blog" class="error-link">← Вернуться в блог</a>
    </div>
</div>
<?php include_once __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
