<!-- views/registration_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register for Session</title>
    <link rel="stylesheet" href="views/styles.css">
</head>
<body>
    <h2>Register for Session</h2>
    <form method="post" action="">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
        <label for="schedule_id">Session (Schedule):</label>
        <select name="schedule_id" id="schedule_id" required>
            <?php foreach ($schedules as $schedule) : ?>
                <option value="<?= htmlspecialchars($schedule['_id']) ?>">
                    <?= htmlspecialchars($schedule['title'] ?? $schedule['_id']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Register</button>
    </form>
    <?php if (!empty($message)) : ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
</body>
</html>
