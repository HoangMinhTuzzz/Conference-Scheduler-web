<?php
require_once '../config.php';
require_once '../models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        session_start();
        $email = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->userModel->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => (string)$user['_id'],
                'email' => $user['email'],
                'username' => $user['username'] ?? ''
            ];
            header('Location: ../index.php');
            exit;
        } else {
            $error = 'Sai thông tin đăng nhập!';
            include '../views/login.php';
        }
    }

    public function register() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        if ($this->userModel->getUserByEmail($email)) {
            $error = 'Email đã tồn tại!';
            include '../views/register.php';
            return;
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->userModel->createUser([
            'username' => $username,
            'email' => $email,
            'password' => $hash
        ]);
        header('Location: ../views/login.php');
        exit;
    }
}

// Router
$action = $_GET['action'] ?? '';
$auth = new AuthController();
if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->login();
} elseif ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->register();
}
