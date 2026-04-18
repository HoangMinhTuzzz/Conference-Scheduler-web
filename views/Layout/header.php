<?php
// Đã có session_start() ở index.php, không cần gọi lại ở đây
$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? ($_SESSION['user']['role'] ?? 'user') : null;
?>
<div class="navbar">
    <h2>Conference Scheduler</h2>
    <div>
        <a href="index.php">Home</a>
        <a href="index.php?page=conference">Conferences</a>
        <a href="index.php?page=schedule">Schedule</a>
        <?php if ($isLoggedIn && $role === 'admin'): ?>
            <a href="index.php?page=users">Quản trị</a>
        <?php endif; ?>
        <?php if ($isLoggedIn): ?>
            <a href="index.php?page=profile">Tài khoản</a>
            <a href="index.php?page=logout">Logout</a>
        <?php else: ?>
            <a href="index.php?page=login">Login</a>
            <a href="index.php?page=register">Register</a>
        <?php endif; ?>
    </div>
</div>

<style>
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background-color: #1e293b;
    color: white;
}

.navbar a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
}

.navbar a:hover {
    text-decoration: underline;
}
</style>