<?php
// Đã có session_start() ở index.php, không cần gọi lại ở đây
$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? ($_SESSION['user']['role'] ?? 'user') : null;
$userName = $isLoggedIn ? ($_SESSION['user']['email'] ?? 'User') : null;
?>
<nav class="navbar">
    <div class="navbar-brand">
        <h1 class="brand-title">📋 Conference Scheduler</h1>
    </div>
    <div class="navbar-menu">
        <a href="index.php" class="nav-link">🏠 Home</a>
        <a href="index.php?page=conference" class="nav-link">📊 Conferences</a>
        <a href="index.php?page=schedule" class="nav-link">📅 Schedule</a>
        <?php if ($isLoggedIn && $role === 'admin'): ?>
            <a href="index.php?page=users" class="nav-link admin-link">⚙️ Admin Panel</a>
        <?php endif; ?>
    </div>
    <div class="navbar-user">
        <?php if ($isLoggedIn): ?>
            <span class="user-info">
                <?php if ($role === 'admin'): ?>
                    <span class="admin-badge">👤 Admin</span>
                <?php endif; ?>
                <span class="user-email"><?= htmlspecialchars(substr($userName, 0, 20)) ?></span>
            </span>
            <a href="index.php?page=profile" class="nav-link">Account</a>
            <a href="index.php?page=logout" class="nav-link logout-link">Logout</a>
        <?php else: ?>
            <a href="index.php?page=login" class="nav-link">Login</a>
            <a href="index.php?page=register" class="nav-link">Register</a>
        <?php endif; ?>
    </div>
</nav>

<style>
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 40px;
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    position: sticky;
    top: 0;
    z-index: 100;
    height: 70px;
}

.navbar-brand {
    flex: 0 0 auto;
}

.brand-title {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 700;
    background: linear-gradient(135deg, #60a5fa, #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: 0.5px;
}

.navbar-menu {
    display: flex;
    gap: 30px;
    flex: 1 1 auto;
    margin: 0 40px;
}

.navbar-user {
    display: flex;
    align-items: center;
    gap: 20px;
    flex: 0 0 auto;
}

.nav-link {
    color: #e0e7ff;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    padding: 8px 12px;
    border-radius: 6px;
    transition: all 0.3s ease;
    display: inline-block;
}

.nav-link:hover {
    background-color: rgba(96, 165, 250, 0.2);
    color: #60a5fa;
}

.admin-link {
    background-color: rgba(239, 68, 68, 0.2);
    color: #fca5a5;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.admin-link:hover {
    background-color: rgba(239, 68, 68, 0.3);
    color: #fecaca;
}

.logout-link {
    background-color: rgba(239, 68, 68, 0.15);
    color: #fca5a5;
}

.logout-link:hover {
    background-color: rgba(239, 68, 68, 0.25);
    color: #fecaca;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
}

.admin-badge {
    background-color: rgba(239, 68, 68, 0.3);
    color: #fecaca;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
    border: 1px solid rgba(239, 68, 68, 0.4);
}

.user-email {
    color: #cbd5e1;
    font-size: 0.9rem;
}

@media (max-width: 1024px) {
    .navbar {
        padding: 0 20px;
        flex-wrap: wrap;
        height: auto;
    }
    
    .navbar-menu {
        margin: 0 20px;
        gap: 15px;
    }
    
    .nav-link {
        font-size: 0.85rem;
        padding: 6px 10px;
    }
}

@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        gap: 10px;
        padding: 12px 15px;
    }
    
    .navbar-menu {
        margin: 10px 0;
        gap: 10px;
        width: 100%;
        justify-content: center;
    }
    
    .navbar-user {
        gap: 10px;
        width: 100%;
        justify-content: center;
    }
    
    .brand-title {
        font-size: 1.4rem;
    }
}
</style>