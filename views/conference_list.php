<?php
// views/conference_list.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh sách hội nghị</title>
</head>
<body>
    <h2>Danh sách hội nghị</h2>
    <ul>
        <?php foreach ($conferences as $conf): ?>
            <li>
                <?php echo htmlspecialchars($conf['name'] ?? (string)($conf['_id'] ?? '')); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php">Về trang chủ</a>
</body>
</html>
