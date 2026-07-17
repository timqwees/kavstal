<?php
$site = $site ?? Setting\route\function\Functions::site();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Страница не найдена — КАВ СТАЛЬ</title>
    <meta name="robots" content="noindex, follow">
    <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
</head>
<body class="bg-zinc-50 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-5xl font-bold text-red-500 mb-3">404</h1>
        <p class="text-zinc-600 mb-6">Статья не найдена.</p>
        <a href="<?= htmlspecialchars($site['baseUrl']) ?>/blog" class="text-red-500 font-medium hover:underline">← Вернуться в блог</a>
    </div>
</body>
</html>
