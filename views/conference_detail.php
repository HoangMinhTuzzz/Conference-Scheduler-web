<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conference Details</title>

    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
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

        .badge-row {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.3);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.5);
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
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 20px;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            flex: 1;
            min-width: 120px;
        }

        .btn-edit {
            background: #10b981;
        }

        .btn-edit:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-delete {
            background: #ef4444;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-back {
            background: #6b7280;
        }

        .btn-back:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }

        .no-data {
            color: #999;
            font-style: italic;
        }

        .view-only-notice {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #0c4a6e;
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #0284c7;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .view-only-notice::before {
            content: "ℹ️";
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .container {
                margin: 15px auto;
            }

            .header {
                padding: 30px 20px;
            }

            .content {
                padding: 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                flex: none;
                width: 100%;
            }
        }
    </style>
</head>

<body>

<?php include __DIR__ . "/Layout/header.php"; ?>

<?php 
$isLoggedIn = isset($_SESSION['user']);
$userRole = $_SESSION['user']['role'] ?? 'user';
$userEmail = $_SESSION['user']['email'] ?? null;
$isCreator = $conference && (($conference['created_by'] ?? null) === $userEmail);
$canEdit = ($userRole === 'admin' || $isCreator) && $isLoggedIn;
?>

<div class="container">
    <?php if (!$isLoggedIn): ?>
        <div style="background: white; padding: 40px; border-radius: 12px; text-align: center;">
            <h2 style="color: #333; margin-top: 0;">Please Log In</h2>
            <p style="color: #888; font-size: 16px; margin-bottom: 20px;">You need to be logged in to view conference details.</p>
            <a href="index.php?page=login" style="display: inline-block; padding: 12px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.3s;">Login</a>
        </div>
    <?php elseif ($conference): ?>
        <div class="header">
            <h1><?php echo htmlspecialchars($conference['title'] ?? 'Conference'); ?></h1>
            <?php if (!$canEdit): ?>
                <div class="badge-row">
                    <span class="badge">👁️ View Only</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="content">
            <?php if (!$canEdit && $isLoggedIn): ?>
                <div class="view-only-notice">
                    This is a read-only view. Only the conference creator or administrators can edit or delete.
                </div>
            <?php endif; ?>

            <div class="detail-item">
                <div class="detail-label">📅 Date</div>
                <div class="detail-value"><?php echo htmlspecialchars($conference['date'] ?? 'N/A'); ?></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">📍 Location</div>
                <div class="detail-value"><?php echo htmlspecialchars($conference['location'] ?? 'N/A'); ?></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">⏰ Time Slot</div>
                <div class="detail-value">
                    <?php 
                    $slotMap = [
                        1 => 'Slot 1: 9:00 AM - 10:00 AM',
                        2 => 'Slot 2: 10:00 AM - 11:00 AM',
                        3 => 'Slot 3: 11:00 AM - 12:00 PM',
                        4 => 'Slot 4: 12:00 PM - 1:00 PM',
                        5 => 'Slot 5: 1:00 PM - 2:00 PM',
                        6 => 'Slot 6: 2:00 PM - 3:00 PM',
                        7 => 'Slot 7: 3:00 PM - 4:00 PM',
                    ];
                    $slot = $conference['slot'] ?? null;
                    echo $slot && isset($slotMap[$slot]) ? htmlspecialchars($slotMap[$slot]) : 'Not assigned';
                    ?>
                </div>
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

            <div class="detail-item">
                <div class="detail-label">👤 Created By</div>
                <div class="detail-value"><?php echo htmlspecialchars($conference['created_by'] ?? 'N/A'); ?></div>
            </div>

            <div class="actions">
                <?php if ($canEdit): ?>
                    <a href="index.php?page=conference_edit&id=<?php echo (string)($conference['_id'] ?? ''); ?>" class="btn btn-edit">✏️ Edit</a>
                    <a href="#" onclick="if(confirm('Delete this conference?')) window.location.href='index.php?page=conference_delete&id=<?php echo (string)($conference['_id'] ?? ''); ?>';" class="btn btn-delete">🗑️ Delete</a>
                <?php endif; ?>
                <a href="index.php?page=schedule" class="btn btn-back">← Back to Schedule</a>
            </div>
        </div>
    <?php else: ?>
        <div class="content">
            <p style="color: #666; font-size: 16px;">Conference not found.</p>
            <a href="index.php?page=schedule" class="btn btn-back">← Back to Schedule</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
