<?php
$title = 'Danh sách người dùng';
ob_start();
?>
<style>
.user-table {
    border-collapse: collapse;
    width: 90%;
    max-width: 700px;
    margin: 30px auto;
    background: #fff;
    box-shadow: 0 2px 8px #e0e7ef;
}
.user-table th, .user-table td {
    border: 1px solid #cbd5e1;
    padding: 10px 16px;
    text-align: left;
}
.user-table th {
    background: #232e7a;
    color: #fff;
}
.user-table tr:nth-child(even) {
    background: #f8fafc;
}
.approve-link {
    color: #16a34a;
    font-weight: bold;
    text-decoration: underline;
    cursor: pointer;
}
</style>
<div style="max-width:900px;margin:30px auto 0 auto;">
    <h2>Danh sách người dùng</h2>
    <table class="user-table">
        <tr>
            <th>Email</th>
            <th>Role</th>
            <th>Trạng thái</th>
            <th>Duyệt</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role'] ?? 'user') ?></td>
                <td><?= htmlspecialchars($user['status'] ?? 'active') ?></td>
                <td>
                    <?php if (($user['status'] ?? 'active') === 'pending'): ?>
                        <a class="approve-link" href="index.php?page=users&approve=<?= $user['_id'] ?>">Duyệt</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/Layout/layout.php';
