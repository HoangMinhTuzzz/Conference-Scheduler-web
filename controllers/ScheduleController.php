<?php
require_once __DIR__ . '/../models/ScheduleModel.php';
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

class ScheduleController {
	public function index() {
		$schedules = [];
		$availableSchedules = [];
		$isLoggedIn = isset($_SESSION['user']);
		if ($isLoggedIn) {
			$userId = $_SESSION['user']['_id'];
			$model = new ScheduleModel();
			$cursor = $model->getSchedulesByUser($userId);
			foreach ($cursor as $item) {
				$schedules[] = $item;
			}

			// Lấy các lịch mà user chưa tham gia
			require_once __DIR__ . '/../models/ConferenceModel.php';
			$confModel = new ConferenceModel();
			$allConfs = $confModel->getAllConferences();
			foreach ($allConfs as $conf) {
				// Nếu conference chưa có user này trong schedules
				$joined = false;
				foreach ($schedules as $sch) {
					if (($sch['conference_id'] ?? null) == (string)($conf['_id'])) {
						$joined = true;
						break;
					}
				}
				if (!$joined) {
					$availableSchedules[] = $conf;
				}
			}
		}
		include __DIR__ . '/../views/schedule.php';
	}
}
