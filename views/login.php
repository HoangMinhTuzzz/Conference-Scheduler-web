<?php
// views/login.php
// Form đăng nhập
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - MYPROJECT</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="project-title">LOGIN TO YOUR ACCOUNT</div>
    <div class="form-container">
        <h2>Đăng nhập</h2>
        <form action="/controllers/AuthController.php?action=login" method="post">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Đăng nhập</button>
        </form>
        <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
    </div>
</body>
</html>
