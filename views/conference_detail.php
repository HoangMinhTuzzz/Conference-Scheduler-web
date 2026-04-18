<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Conference Details</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 30px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 40px 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 32px;
        }

        .content {
            padding: 30px;
        }

        .detail-item {
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #667eea;
            margin-bottom: 8px;
        }

        .detail-value {
            color: #555;
            line-height: 1.6;
            font-size: 15px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            text-align: center;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-edit {
            background: #10b981;
        }

        .btn-edit:hover {
            background: #059669;
        }

        .btn-delete {
            background: #ef4444;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .btn-back {
            background: #6b7280;
        }

        .btn-back:hover {
            background: #4b5563;
        }

        .no-data {
            color: #999;
            font-style: italic;
        }
    </style>
</head>

<body>

<?php include __DIR__ . "/layout/header.php"; ?>

<div class="container">
    <?php if ($conference): ?>
        <div class="header">
            <h1><?php echo htmlspecialchars($conference['title'] ?? 'Conference'); ?></h1>
        </div>

        <div class="content">
            <div class="detail-item">
                <div class="detail-label">📅 Date</div>
                <div class="detail-value"><?php echo htmlspecialchars($conference['date'] ?? 'N/A'); ?></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">📍 Location</div>
                <div class="detail-value"><?php echo htmlspecialchars($conference['location'] ?? 'N/A'); ?></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">📝 Description</div>
                <div class="detail-value">
                    <?php 
                    $description = $conference['description'] ?? null;
                    if ($description) {
                        echo nl2br(htmlspecialchars($description));
                    } else {
                        echo '<span class="no-data">No description provided</span>';
                    }
                    ?>
                </div>
            </div>

            <div class="actions">
                <a href="index.php?page=conference_edit&id=<?php echo (string)($conference['_id'] ?? ''); ?>" class="btn btn-edit">✏️ Edit</a>
                <a href="#" onclick="if(confirm('Delete this conference?')) window.location.href='index.php?page=conference_delete&id=<?php echo (string)($conference['_id'] ?? ''); ?>';" class="btn btn-delete">🗑️ Delete</a>
                <a href="index.php?page=conference" class="btn btn-back">← Back</a>
            </div>
        </div>
    <?php else: ?>
        <div class="content">
            <p>Conference not found.</p>
            <a href="index.php?page=conference" class="btn btn-back">← Back to Conferences</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
