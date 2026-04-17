<?php
// đảm bảo luôn là array
if (!is_array($conferences)) {
    $conferences = iterator_to_array($conferences);
}
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
</style>
</head>

<body>

<?php include __DIR__ . "/layout/header.php"; ?>

<div class="container">

    <div class="page-header">
        <h1>📅 Conferences</h1>
        <a href="index.php?page=conference_create" class="btn-create">+ Create</a>
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

                        <div class="actions">
                            <a href="index.php?page=conference_detail&id=<?php echo $id; ?>" class="btn view">View</a>
                            <a href="index.php?page=conference_edit&id=<?php echo $id; ?>" class="btn edit">Edit</a>
                            <a href="#" onclick="deleteConf('<?php echo $id; ?>')" class="btn delete">Delete</a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>

        <div class="empty">
            <h2>No conferences yet</h2>
            <p>Create your first one 🚀</p>
            <a href="index.php?page=conference_create" class="btn-create">Create now</a>
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