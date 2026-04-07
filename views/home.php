<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conference Scheduler</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }

        /* Navbar */
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

        /* Hero */
        .hero {
            text-align: center;
            padding: 100px 20px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: white;
        }

        .hero h1 {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 25px;
        }

        .btn {
            padding: 12px 25px;
            background-color: white;
            color: #3b82f6;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        /* Features */
        .features {
            display: flex;
            justify-content: space-around;
            padding: 50px 20px;
        }

        .card {
            background-color: white;
            padding: 25px;
            width: 28%;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card h3 {
            margin-bottom: 10px;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #1e293b;
            color: white;
        }

    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2>Conference Scheduler</h2>
    <div>
        <a href="index.php">Home</a>
        <a href="index.php?page=conference">Conferences</a>
        <a href="index.php?page=login">Login</a>
        <a href="index.php?page=register">Register</a>
    </div>
</div>

<!-- Hero Section -->
<div class="hero">
    <h1>Manage Your Conferences Easily</h1>
    <p>Organize, schedule and track all your events in one place.</p>
    <a href="index.php?page=conference" class="btn">Get Started</a>
</div>

<!-- Features -->
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

<!-- Footer -->
<footer>
    <p>© 2026 Conference Scheduler. All rights reserved.</p>
</footer>

</body>
</html>