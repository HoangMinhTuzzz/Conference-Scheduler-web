<?php
// Session check and user information
$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? ($_SESSION['user']['role'] ?? 'user') : null;
$userName = $isLoggedIn ? ($_SESSION['user']['email'] ?? 'User') : null;
$userInitial = $isLoggedIn ? strtoupper(substr($userName, 0, 1)) : '';
?>
<nav class="navbar">
    <div class="navbar-container">
        <!-- Brand -->
        <div class="navbar-brand">
            <a href="index.php" class="brand-link">
                <svg class="brand-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span class="brand-text">Conference Scheduler</span>
            </a>
        </div>

        <!-- Navigation Menu -->
        <ul class="navbar-menu">
            <li><a href="index.php" class="nav-link">Home</a></li>
            <li><a href="index.php?page=conference" class="nav-link">Conferences</a></li>
            <li><a href="index.php?page=schedule" class="nav-link">Schedule</a></li>
            <?php if ($isLoggedIn && $role === 'admin'): ?>
                <li><a href="index.php?page=users" class="nav-link nav-link-admin">Admin</a></li>
            <?php endif; ?>
        </ul>

        <!-- User Section -->
        <div class="navbar-user">
            <?php if ($isLoggedIn): ?>
                <div class="user-profile">
                    <div class="user-avatar"><?= htmlspecialchars($userInitial) ?></div>
                    <div class="user-info">
                        <span class="user-email"><?= htmlspecialchars(substr($userName, 0, 20)) ?></span>
                        <?php if ($role === 'admin'): ?>
                            <span class="user-role">Administrator</span>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="index.php?page=profile" class="nav-link">Profile</a>
                <a href="index.php?page=logout" class="nav-link nav-link-logout">Logout</a>
            <?php else: ?>
                <a href="index.php?page=login" class="nav-link">Login</a>
                <a href="index.php?page=register" class="nav-link nav-link-primary">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<style>
/* ============================================
   NAVIGATION BAR
   ============================================ */

.navbar {
    position: sticky;
    top: 0;
    z-index: 100;
    background: white;
    border-bottom: 1px solid var(--neutral-200);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.navbar-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 var(--spacing-lg);
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 70px;
}

/* Brand */
.navbar-brand {
    flex: 0 0 auto;
}

.brand-link {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    color: var(--neutral-900);
    text-decoration: none;
    font-weight: 800;
    font-size: 1.25rem;
    letter-spacing: -0.5px;
    transition: color var(--transition-fast);
}

.brand-link:hover {
    color: var(--primary);
}

.brand-icon {
    width: 28px;
    height: 28px;
    stroke: var(--primary);
}

.brand-text {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: none;
}

@media (min-width: 768px) {
    .brand-text {
        display: inline;
    }
}

/* Menu */
.navbar-menu {
    flex: 1 1 auto;
    display: none;
    list-style: none;
    gap: var(--spacing-lg);
    margin: 0 var(--spacing-xl);
    padding: 0;
}

@media (min-width: 768px) {
    .navbar-menu {
        display: flex;
    }
}

.navbar-menu li {
    margin: 0;
}

.nav-link {
    color: var(--neutral-600);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    padding: 8px 12px;
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
    display: inline-block;
    letter-spacing: 0.2px;
}

.nav-link:hover {
    color: var(--primary);
    background: rgba(37, 99, 235, 0.05);
}

.nav-link-admin {
    color: var(--danger);
    background: rgba(239, 68, 68, 0.08);
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.nav-link-admin:hover {
    background: rgba(239, 68, 68, 0.15);
    color: #dc2626;
}

/* User Section */
.navbar-user {
    flex: 0 0 auto;
    display: flex;
    align-items: center;
    gap: var(--spacing-lg);
}

.user-profile {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    padding-right: var(--spacing-lg);
    border-right: 1px solid var(--neutral-200);
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
}

.user-info {
    display: flex;
    flex-direction: column;
}

.user-email {
    color: var(--neutral-900);
    font-weight: 600;
    font-size: 0.875rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-role {
    color: var(--neutral-500);
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    font-weight: 500;
}

.nav-link-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    color: white;
    padding: 8px 16px;
    font-weight: 600;
    border-radius: var(--radius-md);
}

.nav-link-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
}

.nav-link-logout {
    color: var(--danger);
    font-weight: 600;
}

.nav-link-logout:hover {
    background: rgba(239, 68, 68, 0.08);
    color: #dc2626;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .navbar-container {
        padding: 0 var(--spacing-md);
        height: 60px;
    }

    .brand-link {
        font-size: 1rem;
    }

    .navbar-user {
        gap: var(--spacing-sm);
    }

    .user-profile {
        padding-right: var(--spacing-md);
    }

    .user-avatar {
        width: 36px;
        height: 36px;
    }

    .user-email {
        display: none;
    }

    .nav-link {
        padding: 6px 10px;
        font-size: 0.875rem;
    }

    .nav-link-primary {
        padding: 6px 12px;
        font-size: 0.875rem;
    }
}
</style>

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