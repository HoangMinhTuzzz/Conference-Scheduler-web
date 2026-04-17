<?php
require_once __DIR__ . '/../models/ScheduleModel.php';
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

class ScheduleController {
	public function index() {
		$schedules = [];
		$isLoggedIn = isset($_SESSION['user']);
		if ($isLoggedIn) {
			$userId = $_SESSION['user']['_id'];
			$model = new ScheduleModel();
			$cursor = $model->getSchedulesByUser($userId);
			foreach ($cursor as $item) {
				$schedules[] = $item;
			}
		}
		include __DIR__ . '/../views/schedule.php';
	}
}
