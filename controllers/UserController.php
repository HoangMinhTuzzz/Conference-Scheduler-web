<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
	private $userModel;

	public function __construct() {
		$this->userModel = new UserModel();
	}

	public function index() {
		// Đã có session_start() ở index.php, không cần gọi lại ở đây
		if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? 'user') !== 'admin') {
			header('Location: index.php?page=login');
			exit;
		}
		$userModel = $this->userModel;
		// Duyệt user nếu có approve
		if (isset($_GET['approve'])) {
			$id = $_GET['approve'];
			$userModel->approveUser($id);
			header('Location: index.php?page=users');
			exit;
		}
		// Hiển thị danh sách user
		$users = $userModel->getAllUsers();
		include __DIR__ . '/../views/user_list.php';
	}

	public function profile() {
		if (!isset($_SESSION['user'])) {
			header('Location: index.php?page=login');
			exit;
		}
		$user = $this->userModel->getUserByEmail($_SESSION['user']['email']);
		$error = '';
		$success = '';
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$old = $_POST['old_password'] ?? '';
			$new = $_POST['new_password'] ?? '';
			$confirm = $_POST['confirm_password'] ?? '';
			if (!password_verify($old, $user['password'])) {
				$error = 'Mật khẩu cũ không đúng.';
			} elseif (strlen($new) < 6) {
				$error = 'Mật khẩu mới phải từ 6 ký tự.';
			} elseif ($new !== $confirm) {
				$error = 'Mật khẩu nhập lại không khớp.';
			} else {
				$hash = password_hash($new, PASSWORD_DEFAULT);
				$this->userModel->updatePassword($user['_id'], $hash);
				$success = 'Đã cập nhật mật khẩu thành công!';
			}
		}
		include __DIR__ . '/../views/profile.php';
	}
}
