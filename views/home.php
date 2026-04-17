<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Conference Scheduler</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #f4f6f9;
}

/* Hero */
.hero {
    text-align: center;
    padding: 100px 20px;
    background: linear-gradient(135deg, #4f6ef7, #6c63ff);
    color: white;
}

.hero h1 {
    font-size: 42px;
}

.hero p {
    font-size: 18px;
    margin: 20px 0;
}

.btn-group {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.btn {
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}

.btn-primary {
    background: white;
    color: #4f6ef7;
}

.btn-schedule {
    background: #4f6ef7;
    color: white;
}

/* Features */
.features {
    display: flex;
    justify-content: space-around;
    padding: 60px 20px;
    gap: 20px;
}

.card {
    background: white;
    padding: 30px;
    width: 30%;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    text-align: center;
}

footer {
    text-align: center;
    padding: 20px;
    background: #1e293b;
    color: white;
}
</style>
</head>

<body>

<?php include "views/layout/header.php"; ?>

<div class="hero">
    <h1>Manage Your Conferences Easily</h1>
    <p>Organize, schedule and track all your events in one place.</p>

    <div class="btn-group">
        <a href="index.php?page=conference" class="btn btn-primary">View Conferences</a>
        <a href="index.php?page=schedule" class="btn btn-schedule">Schedule</a>
    </div>
</div>

<div class="features">
    <div class="card">
        <h3>📅 Smart Scheduling</h3>
        <p>Create and manage conference schedules efficiently.</p>
    </div>

    <div class="card">
        <h3>👥 User Management</h3>
        <p>Manage attendees and organizers easily.</p>
    </div>

    <div class="card">
        <h3>⚡ Fast Performance</h3>
        <p>Simple and fast interface for better productivity.</p>
    </div>
</div>

<footer>
    <p>© 2026 Conference Scheduler</p>
</footer>

</body>
</html>