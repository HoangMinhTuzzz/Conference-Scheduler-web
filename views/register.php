<?php
// views/register.php
// Form đăng ký
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - MYPROJECT</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="project-title">REGISTER FOR AN ACCOUNT</div>
    <div class="form-container">
        <h2>Đăng ký</h2>
        <form action="/controllers/AuthController.php?action=register" method="post">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Đăng ký</button>
        </form>
        <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
    </div>
</body>
</html>
