<?php
$title = 'Tài khoản cá nhân';
ob_start();
?>
<div style="max-width:500px;margin:30px auto 0 auto;">
    <h2>Tài khoản cá nhân</h2>
    <form method="post" action="index.php?page=profile">
        <div style="margin-bottom:16px">
            <label>Email:</label><br>
            <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled style="width:100%;padding:8px" />
        </div>
        <div style="margin-bottom:16px">
            <label>Mật khẩu cũ:</label><br>
            <input type="password" name="old_password" style="width:100%;padding:8px" required />
        </div>
        <div style="margin-bottom:16px">
            <label>Mật khẩu mới:</label><br>
            <input type="password" name="new_password" style="width:100%;padding:8px" required />
        </div>
        <div style="margin-bottom:16px">
            <label>Nhập lại mật khẩu mới:</label><br>
            <input type="password" name="confirm_password" style="width:100%;padding:8px" required />
        </div>
        <button type="submit" style="padding:10px 24px;background:#232e7a;color:#fff;border:none;border-radius:4px">Cập nhật mật khẩu</button>
    </form>
    <?php if (!empty($success)): ?>
        <div style="color:green;margin-top:16px"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div style="color:red;margin-top:16px"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/Layout/layout.php';
