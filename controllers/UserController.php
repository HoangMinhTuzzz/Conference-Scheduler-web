<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
	private $userModel;

	public function __construct() {
		$this->userModel = new UserModel();
	}

	public function index() {
		// Hiển thị danh sách user (demo)
		$users = $this->userModel->getAllUsers();
		echo '<h2>Danh sách người dùng</h2>';
		echo '<ul>';
		foreach ($users as $user) {
			echo '<li>' . htmlspecialchars($user['email']) . '</li>';
		}
		echo '</ul>';
	}

	public function profile() {
		session_start();
		if (!isset($_SESSION['user'])) {
			header('Location: index.php?page=login');
			exit;
		}
		$user = $this->userModel->getUserByEmail($_SESSION['user']['email']);
		echo '<h2>Thông tin cá nhân</h2>';
		echo '<p>Email: ' . htmlspecialchars($user['email']) . '</p>';
		echo '<p>Username: ' . htmlspecialchars($user['username'] ?? '') . '</p>';
	}
}
