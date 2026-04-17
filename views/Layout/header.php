<?php $id = "header123" ?>
<div class="navbar">
    <h2>Conference Scheduler</h2>
    <div>
        <a href="index.php">Home</a>
        <a href="index.php?page=conference">Conferences</a>
        <a href="index.php?page=schedule">Schedule</a>
        <a href="index.php?page=login">Login</a>
        <a href="index.php?page=register">Register</a>
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