<?php include "../app/views/layout/header.php"; ?>

<style>
/* ===== GLOBAL ===== */
body {
    font-family: 'Segoe UI', sans-serif;
    background: #f5f7fb;
    margin: 0;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: auto;
}

.btn {
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    display: inline-block;
}

.btn-primary {
    background: #4f46e5;
    color: white;
}

.btn-secondary {
    background: #e0e7ff;
    color: #4f46e5;
}

/* ===== HERO ===== */
.hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 60px 0;
}

.hero-text {
    max-width: 500px;
}

.hero h1 {
    font-size: 36px;
    margin-bottom: 20px;
}

.hero p {
    color: #555;
    margin-bottom: 20px;
}

.hero img {
    width: 500px;
}

/* ===== STATS ===== */
.stats {
    display: flex;
    gap: 20px;
    margin: 40px 0;
}

.stat-card {
    flex: 1;
    background: white;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
}

.stat-card h2 {
    color: #4f46e5;
}

/* ===== FEATURES ===== */
.features {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.feature-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
}

.feature-card h3 {
    margin-bottom: 10px;
}

/* ===== PREVIEW ===== */
.preview {
    margin: 60px 0;
    display: flex;
    gap: 30px;
}

.preview-box {
    flex: 1;
    background: white;
    padding: 20px;
    border-radius: 12px;
}

/* ===== CTA ===== */
.cta {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: white;
    text-align: center;
    padding: 50px;
    border-radius: 12px;
    margin: 60px 0;
}
</style>

<div class="container">

    <!-- HERO -->
    <section class="hero">
        <div class="hero-text">
            <h1>Plan and Manage Your Conferences Easily</h1>
            <p>All-in-one platform to organize events, manage sessions, and track schedules.</p>
            
            <a href="index.php?page=conference" class="btn btn-primary">Get Started</a>
            <a href="index.php?page=conference" class="btn btn-secondary">Browse Conferences</a>
        </div>

        <img src="https://cdn-icons-png.flaticon.com/512/9068/9068753.png" alt="dashboard">
    </section>

    <!-- STATS -->
    <section class="stats">
        <div class="stat-card">
            <h2>100+</h2>
            <p>Conferences</p>
        </div>
        <div class="stat-card">
            <h2>5000+</h2>
            <p>Users</p>
        </div>
        <div class="stat-card">
            <h2>12000+</h2>
            <p>Sessions</p>
        </div>
        <div class="stat-card">
            <h2>98%</h2>
            <p>Satisfaction</p>
        </div>
    </section>

    <!-- FEATURES -->
    <section>
        <h2>Features</h2>
        <div class="features">
            <div class="feature-card">
                <h3>📅 Smart Scheduling</h3>
                <p>Plan sessions efficiently with an intuitive schedule system.</p>
            </div>

            <div class="feature-card">
                <h3>👥 User Management</h3>
                <p>Manage attendees and organizers easily.</p>
            </div>

            <div class="feature-card">
                <h3>🏢 Room Management</h3>
                <p>Organize sessions across multiple rooms.</p>
            </div>

            <div class="feature-card">
                <h3>🔔 Notifications</h3>
                <p>Stay updated with reminders and alerts.</p>
            </div>
        </div>
    </section>

    <!-- DASHBOARD PREVIEW -->
    <section class="preview">
        <div class="preview-box">
            <h3>Conference List</h3>
            <ul>
                <li>AI Conference 2026</li>
                <li>Web Dev Summit</li>
                <li>Tech Future Expo</li>
            </ul>
        </div>

        <div class="preview-box">
            <h3>Your Schedule</h3>
            <ul>
                <li>10:00 - Opening</li>
                <li>11:00 - AI Talk</li>
                <li>14:00 - Workshop</li>
            </ul>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section>
        <h2>How It Works</h2>
        <ol>
            <li>Register an account</li>
            <li>Create or join conferences</li>
            <li>Manage your personal schedule</li>
        </ol>
    </section>

    <!-- CTA -->
    <section class="cta">
        <h2>Start organizing your conference today</h2>
        <a href="index.php?page=register" class="btn btn-secondary">Get Started Now</a>
    </section>

</div>

<?php include "../app/views/layout/footer.php"; ?>