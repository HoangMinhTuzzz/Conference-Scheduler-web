<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="views/styles.css">
</head>
<body>
    <h2>Đăng nhập</h2>
    <?php if (!empty($error)): ?>
        <div class="error"> <?php echo htmlspecialchars($error); ?> </div>
    <?php endif; ?>
    <form method="post" action="index.php?page=login">
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Mật khẩu:</label><br>
        <input type="password" name="password" required><br>
        <button type="submit">Đăng nhập</button>
    </form>
    <p>Chưa có tài khoản? <a href="index.php?page=register">Đăng ký</a></p>
</body>
</html>
