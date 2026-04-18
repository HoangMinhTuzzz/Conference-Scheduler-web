<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Conference Scheduler' ?></title>
    <link rel="stylesheet" href="/views/styles.css">
    <style>
        body { background: #e6f0fa; margin: 0; }
    </style>
</head>
<body>
    <?php include __DIR__ . '/header.php'; ?>
    <div style="max-width:1200px;margin:40px auto 0 auto;min-height:60vh;">
        <?php if (isset($content)) echo $content; ?>
    </div>
</body>
</html>
