<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="views/styles.css">
</head>
<body>
    <h2>Đăng ký tài khoản</h2>
    <?php if (!empty($error)): ?>
        <div class="error"> <?php echo htmlspecialchars($error); ?> </div>
    <?php endif; ?>
    <?php if (isset($_GET['pending'])): ?>
        <div style="color:green;margin-bottom:16px">Đăng ký thành công! Vui lòng chờ admin duyệt tài khoản.</div>
    <?php endif; ?>
    <form method="post" action="index.php?page=register">
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Mật khẩu:</label><br>
        <input type="password" name="password" required><br>
        <label>Nhập lại mật khẩu:</label><br>
        <input type="password" name="confirm_password" required><br>
        <button type="submit">Đăng ký</button>
    </form>
    <p>Đã có tài khoản? <a href="index.php?page=login">Đăng nhập</a></p>
</body>
</html>
