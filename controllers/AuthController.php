<?php
require_once __DIR__ . '/../models/UserModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AuthController {
    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'email' => $user['email'],
                    '_id' => (string)($user['_id'] ?? '')
                ];
                header('Location: index.php');
                exit;
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
                        'password' => $hash
                    ]);
                    header('Location: index.php?page=login');
                    exit;
                }
            }
        }
        include __DIR__ . '/../views/register.php';
    }
}

