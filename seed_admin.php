<?php
require_once __DIR__ . '/config.php';

$db = getMongoDBConnection();
$users = $db->users;

$email = 'admin@gmail.com';
$password = '123456';
$role = 'admin';
$status = 'active';

// Kiểm tra nếu đã có admin
$exists = $users->findOne(['email' => $email]);
if ($exists) {
    echo "Admin đã tồn tại!\n";
    // Nếu thiếu status thì cập nhật luôn
    if (!isset($exists['status']) || $exists['status'] !== 'active') {
        $users->updateOne(['_id' => $exists['_id']], ['$set' => ['status' => 'active']]);
        echo "Đã cập nhật status thành 'active' cho admin.\n";
    }
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$users->insertOne([
    'email' => $email,
    'password' => $hash,
    'role' => $role,
    'status' => $status
]);
echo "Đã tạo admin: $email / $password\n";
