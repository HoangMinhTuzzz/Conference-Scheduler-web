<?php
require_once __DIR__ . '/../models/ScheduleModel.php';

class ScheduleController {
	private $scheduleModel;

	public function __construct() {
		$this->scheduleModel = new ScheduleModel();
	}

	public function index() {
		// Hiển thị danh sách lịch trình (demo)
		$schedules = $this->scheduleModel->getSchedulesByUser('demo');
		echo '<h2>Danh sách lịch trình (demo)</h2>';
		echo '<ul>';
		foreach ($schedules as $schedule) {
			echo '<li>' . htmlspecialchars(json_encode($schedule)) . '</li>';
		}
		echo '</ul>';
	}
}
