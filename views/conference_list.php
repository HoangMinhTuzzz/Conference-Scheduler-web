<?php
// đảm bảo luôn là array
if (!is_array($conferences)) {
    $conferences = iterator_to_array($conferences);
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Conferences</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #f4f6f9;
}

/* Container */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 30px auto;
}

/* Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.page-header h1 {
    font-size: 30px;
    color: #1e293b;
}

/* Button */
.btn-create {
    padding: 10px 20px;
    background: #4f6ef7;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}

.btn-create:hover {
    background: #3b55d1;
}

/* Search */
.search-box {
    background: white;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.search-box input {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ddd;
}

/* Grid */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

/* Card */
.card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

/* Card header */
.card-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    padding: 20px;
    color: white;
}

.card-header h3 {
    margin: 0;
}

/* Card body */
.card-body {
    padding: 20px;
}

.info {
    margin-bottom: 10px;
    font-size: 14px;
    color: #555;
}

/* Buttons */
.actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.btn {
    flex: 1;
    padding: 8px;
    text-align: center;
    border-radius: 6px;
    text-decoration: none;
    color: white;
    font-size: 14px;
}

.view { background: #3b82f6; }
.edit { background: #10b981; }
.delete { background: #ef4444; }

/* Empty */
.empty {
    text-align: center;
    padding: 50px;
    background: white;
    border-radius: 10px;
}

/* Login Prompt */
.login-prompt {
    background: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.login-prompt h2 {
    color: #333;
    margin-top: 0;
}

.login-prompt p {
    color: #888;
    font-size: 16px;
    margin-bottom: 20px;
}

.btn-login {
    display: inline-block;
    padding: 12px 30px;
    background: #667eea;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-login:hover {
    background: #5568d3;
}
</style>
</head>

<body>

<?php include __DIR__ . "/layout/header.php"; ?>

<div class="container">

    <?php if ($isLoggedIn): ?>
        <div class="page-header">
            <h1>📅 Conferences</h1>
            <?php 
                $userRole = $_SESSION['user']['role'] ?? 'user';
                if ($userRole === 'admin'):
            ?>
                <a href="index.php?page=conference_create" class="btn-create">+ Create</a>
            <?php endif; ?>
        </div>

        <div class="search-box">
            <input type="text" id="search" placeholder="Search conferences..." onkeyup="searchConf()">
        </div>

        <?php if (count($conferences) > 0): ?>
            <div class="grid">
                <?php foreach ($conferences as $conf): 
                    $id = (string)($conf['_id'] ?? '');
                    $name = htmlspecialchars($conf['title'] ?? 'No title');
                    $date = htmlspecialchars($conf['date'] ?? 'N/A');
                    $location = htmlspecialchars($conf['location'] ?? 'N/A');
                ?>
                    <div class="card" data-name="<?php echo strtolower($name); ?>">
                        
                        <div class="card-header">
                            <h3><?php echo $name; ?></h3>
                        </div>

                        <div class="card-body">
                            <div class="info">📅 <?php echo $date; ?></div>
                            <div class="info">📍 <?php echo $location; ?></div>
                            <div class="info">⏰ 
                                <?php 
                                $slotMap = [
                                    1 => 'Slot 1: 9:00-10:00',
                                    2 => 'Slot 2: 10:00-11:00',
                                    3 => 'Slot 3: 11:00-12:00',
                                    4 => 'Slot 4: 12:00-13:00',
                                    5 => 'Slot 5: 13:00-14:00',
                                    6 => 'Slot 6: 14:00-15:00',
                                    7 => 'Slot 7: 15:00-21:00',
                                ];
                                $slot = $conf['slot'] ?? null;
                                echo $slot && isset($slotMap[$slot]) ? htmlspecialchars($slotMap[$slot]) : 'Not assigned';
                                ?>
                            </div>

                            <div class="actions">
                                <a href="index.php?page=conference_detail&id=<?php echo $id; ?>" class="btn view">View</a>
                                <?php 
                                    $userRole = $_SESSION['user']['role'] ?? 'user';
                                    if ($userRole === 'admin'):
                                ?>
                                    <a href="index.php?page=conference_edit&id=<?php echo $id; ?>" class="btn edit">Edit</a>
                                    <a href="#" onclick="deleteConf('<?php echo $id; ?>')" class="btn delete">Delete</a>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>

            <div class="empty">
                <h2>No conferences yet</h2>
                <?php 
                    $userRole = $_SESSION['user']['role'] ?? 'user';
                    if ($userRole === 'admin'):
                ?>
                    <p>Create your first one 🚀</p>
                    <a href="index.php?page=conference_create" class="btn-create">Create now</a>
                <?php else: ?>
                    <p>No conferences available to view.</p>
                <?php endif; ?>
            </div>

        <?php endif; ?>
    <?php else: ?>
        <div class="login-prompt">
            <h2>Please Log In</h2>
            <p>You need to be logged in to view conferences.</p>
            <a href="index.php?page=login" class="btn-login">Login</a>
        </div>
    <?php endif; ?>

</div>

<script>
function searchConf() {
    let input = document.getElementById("search").value.toLowerCase();
    let cards = document.querySelectorAll(".card");

    cards.forEach(card => {
        let name = card.getAttribute("data-name");
        card.style.display = name.includes(input) ? "" : "none";
    });
}

function deleteConf(id) {
    if(confirm("Delete this conference?")) {
        window.location.href = "index.php?page=conference_delete&id=" + id;
    }
}
</script>

</body>
</html>