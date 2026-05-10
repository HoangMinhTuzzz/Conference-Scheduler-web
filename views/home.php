<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conference Scheduler - Manage Your Events</title>
    <link rel="stylesheet" href="/views/styles.css">
    <style>
        /* ============================================
           HERO SECTION
           ============================================ */

        .hero-section {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.95) 0%, rgba(124, 58, 237, 0.95) 100%),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="1200" height="600" fill="url(%23grid)"/></svg>');
            background-size: cover;
            background-attachment: fixed;
            padding: 100px var(--spacing-lg);
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: var(--spacing-lg);
            color: white;
            letter-spacing: -1px;
            line-height: 1.1;
        }

        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: var(--spacing-2xl);
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: var(--spacing-lg);
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-hero {
            padding: var(--spacing-lg) var(--spacing-2xl);
            border-radius: var(--radius-xl);
            text-decoration: none;
            font-weight: 700;
            font-size: 1.05rem;
            border: 2px solid transparent;
            transition: all var(--transition-base);
            letter-spacing: 0.3px;
        }

        .btn-hero-primary {
            background: white;
            color: var(--primary);
            border-color: white;
        }

        .btn-hero-primary:hover {
            background: transparent;
            color: white;
            border-color: white;
            transform: translateY(-3px);
        }

        .btn-hero-secondary {
            background: transparent;
            color: white;
            border-color: white;
        }

        .btn-hero-secondary:hover {
            background: white;
            color: var(--primary);
            border-color: white;
            transform: translateY(-3px);
        }

        /* ============================================
           FEATURES SECTION
           ============================================ */

        .features-section {
            padding: 100px var(--spacing-lg);
            background: white;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .section-header h2 {
            color: var(--neutral-900);
            margin-bottom: var(--spacing-md);
        }

        .section-header p {
            font-size: 1.1rem;
            color: var(--neutral-600);
            line-height: 1.8;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: white;
            border-radius: var(--radius-xl);
            padding: 40px var(--spacing-xl);
            border: 2px solid var(--neutral-200);
            transition: all var(--transition-base);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform var(--transition-base);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
            transform: translateY(-8px);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto var(--spacing-lg);
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(124, 58, 237, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }

        .feature-card h3 {
            color: var(--neutral-900);
            margin-bottom: var(--spacing-md);
            font-size: 1.5rem;
        }

        .feature-card p {
            color: var(--neutral-600);
            margin: 0;
            line-height: 1.8;
        }

        /* ============================================
           CTA SECTION
           ============================================ */

        .cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            padding: 80px var(--spacing-lg);
            text-align: center;
            color: white;
            margin-top: 80px;
        }

        .cta-section h2 {
            color: white;
            margin-bottom: var(--spacing-lg);
            font-size: 2.25rem;
        }

        .cta-section p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: var(--spacing-2xl);
            font-size: 1.1rem;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */

        @media (max-width: 768px) {
            .hero-section {
                padding: 60px var(--spacing-md);
            }

            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 1rem;
                margin-bottom: var(--spacing-xl);
            }

            .hero-buttons {
                gap: var(--spacing-md);
            }

            .btn-hero {
                padding: var(--spacing-md) var(--spacing-lg);
                font-size: 0.95rem;
            }

            .features-section {
                padding: 60px var(--spacing-md);
            }

            .features-grid {
                gap: 20px;
            }

            .feature-card {
                padding: 30px var(--spacing-lg);
            }

            .section-header {
                margin-bottom: 40px;
            }

            .cta-section {
                padding: 60px var(--spacing-md);
            }

            .cta-section h2 {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 480px) {
            .hero-section h1 {
                font-size: 1.5rem;
            }

            .hero-section p {
                font-size: 0.95rem;
            }

            .btn-hero {
                width: 100%;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .feature-card h3 {
                font-size: 1.25rem;
            }

            .cta-section h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <?php include "views/Layout/header.php"; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Manage Your Conferences Effortlessly</h1>
            <p>Organize, schedule, and track all your events in one beautiful, intuitive platform.</p>
            
            <div class="hero-buttons">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="index.php?page=conference" class="btn-hero btn-hero-primary">View Conferences</a>
                    <a href="index.php?page=schedule" class="btn-hero btn-hero-secondary">View Schedule</a>
                <?php else: ?>
                    <a href="index.php?page=register" class="btn-hero btn-hero-primary">Get Started</a>
                    <a href="index.php?page=login" class="btn-hero btn-hero-secondary">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="section-header">
            <h2>Why Choose Our Platform?</h2>
            <p>Everything you need to manage conferences efficiently and professionally</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Smart Scheduling</h3>
                <p>Create and manage conference schedules with our intuitive scheduling tools. Never miss a time slot again.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>User Management</h3>
                <p>Easily manage attendees, organizers, and administrators all in one place with flexible role management.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Lightning Fast</h3>
                <p>Built for speed and efficiency. Our minimalist design ensures a smooth, responsive user experience.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3>Secure & Reliable</h3>
                <p>Your data is protected with industry-standard security practices. Trust us with your conference data.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Analytics Ready</h3>
                <p>Track attendance, monitor schedules, and get insights into your conference performance.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🌐</div>
                <h3>Always Available</h3>
                <p>Access your conferences anytime, anywhere. Works seamlessly on desktop and mobile devices.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Ready to Simplify Conference Management?</h2>
        <p>Join hundreds of event organizers who trust us with their conferences</p>
        <?php if (!isset($_SESSION['user'])): ?>
            <a href="index.php?page=register" class="btn btn-hero btn-hero-primary">Start Free Today</a>
        <?php else: ?>
            <a href="index.php?page=conference" class="btn btn-hero btn-hero-primary">Create Your First Conference</a>
        <?php endif; ?>
    </section>
</body>
</html>