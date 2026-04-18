<?php
require_once __DIR__ . '/config.php';

$db = getMongoDBConnection();
$users = $db->users;

$email = 'admin@gmail.com';
$password = '123456';
$role = 'admin';

// Kiểm tra nếu đã có admin
$exists = $users->findOne(['email' => $email]);
if ($exists) {
    echo "Admin đã tồn tại!\n";
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$users->insertOne([
    'email' => $email,
    'password' => $hash,
    'role' => $role
]);
echo "Đã tạo admin: $email / $password\n";
