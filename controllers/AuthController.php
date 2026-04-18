<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                if (($user['status'] ?? 'pending') !== 'active') {
                    $error = 'Tài khoản của bạn đang chờ duyệt.';
                } else {
                    $_SESSION['user'] = [
                        'email' => $user['email'],
                        '_id' => (string)($user['_id'] ?? ''),
                        'role' => $user['role'] ?? 'user'
                    ];
                    header('Location: index.php');
                    exit;
                }
            } else {
                $error = 'Email hoặc mật khẩu không đúng.';
            }
        }
        include __DIR__ . '/../views/login.php';
    }

    public function register() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            if ($password !== $confirm) {
                $error = 'Mật khẩu không khớp.';
            } else {
                $userModel = new UserModel();
                if ($userModel->getUserByEmail($email)) {
                    $error = 'Email đã tồn tại.';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $userModel->createUser([
                        'email' => $email,
                        'password' => $hash,
                        'role' => 'user',
                        'status' => 'pending'
                    ]);
                    header('Location: index.php?page=login&pending=1');
                    exit;
                }
            }
        }
        include __DIR__ . '/../views/register.php';
    }
}

