<!-- views/registration_list.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registrations</title>
    <link rel="stylesheet" href="views/styles.css">
</head>
<body>
    <h2>User Registrations</h2>
    <?php if (!empty($registrations)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Schedule</th>
                    <th>Registration Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registrations as $reg) : ?>
                    <tr>
                        <td><?= htmlspecialchars($reg['schedule_id']) ?></td>
                        <td><?= isset($reg['registration_time']) ? date('Y-m-d H:i:s', $reg['registration_time']->toDateTime()->getTimestamp()) : '' ?></td>
                        <td><?= htmlspecialchars($reg['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No registrations found.</p>
    <?php endif; ?>
</body>
</html>
