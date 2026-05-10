<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Conference Scheduler - Manage and schedule your conferences with ease">
    <meta name="theme-color" content="#2563eb">
    <title><?= htmlspecialchars($title ?? 'Conference Scheduler') ?></title>
    <link rel="stylesheet" href="/views/styles.css">
</head>
<body>
    <?php include __DIR__ . '/header.php'; ?>
    
    <main>
        <?php if (isset($content)) echo $content; ?>
    </main>

    <footer class="site-footer">
        <div class="footer-content">
            <p>&copy; 2026 Conference Scheduler. All rights reserved.</p>
            <p class="footer-links">
                <a href="index.php">Home</a> •
                <a href="index.php?page=conference">Conferences</a> •
                <a href="index.php?page=schedule">Schedule</a>
            </p>
        </div>
    </footer>
</body>

<style>
/* ============================================
   FOOTER
   ============================================ */

.site-footer {
    background: white;
    border-top: 1px solid var(--neutral-200);
    padding: var(--spacing-2xl) var(--spacing-lg);
    margin-top: auto;
    color: var(--neutral-600);
    font-size: 0.875rem;
}

.footer-content {
    max-width: 1400px;
    margin: 0 auto;
    text-align: center;
}

.footer-content p {
    margin: var(--spacing-sm) 0;
    color: var(--neutral-600);
}

.footer-links a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    transition: color var(--transition-fast);
}

.footer-links a:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

@media (max-width: 768px) {
    .site-footer {
        padding: var(--spacing-xl) var(--spacing-md);
    }

    .footer-content p {
        font-size: 0.8rem;
    }
}
</style>
</html>
