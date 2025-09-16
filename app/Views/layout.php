<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="/assets/css/layout.css" rel="stylesheet">
    <link href="/assets/css/toast.css" rel="stylesheet">
    <?php foreach ($customCSS as $css): ?>
        <?= $css ?>
    <?php endforeach; ?>
</head>
<body>
    <div class="app-container">
        <?php include __DIR__ . '/partials/navigation.php'; ?>
        <?php include __DIR__ . '/partials/toast.php'; ?>
        <main class="main-content">
            <?= $content ?>
        </main>
    </div>
    <?php foreach ($customJS as $js): ?>
        <?= $js ?>
    <?php endforeach; ?>
    <script>
    (function(){
        const params = new URLSearchParams(window.location.search);
        const success = params.get('success');
        const error = params.get('error');
        if (success) document.dispatchEvent(new CustomEvent('toast:success', { detail: success }));
        if (error) document.dispatchEvent(new CustomEvent('toast:error', { detail: error }));
    })();
    </script>
</body>
</html>
