<?php
require_once __DIR__ . '/../models/ScheduleModel.php';

class ScheduleController {
	public function index() {
		$schedules = [];
		$availableSchedules = [];
		$todayConferences = [];
		$weekConferences = [];
		$allDayConferences = [];
		$isLoggedIn = isset($_SESSION['user']);
		
		if ($isLoggedIn) {
			$userId = $_SESSION['user']['_id'];
			$userRole = $_SESSION['user']['role'] ?? 'user';
			$model = new ScheduleModel();
			$cursor = $model->getSchedulesByUser($userId);
			foreach ($cursor as $item) {
				$schedules[] = $item;
			}

			// Lấy các lịch mà user chưa tham gia
			require_once __DIR__ . '/../models/ConferenceModel.php';
			$confModel = new ConferenceModel();
			$allConfs = $confModel->getAllConferences($userRole);
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

			// Get conferences scheduled for today and this week
			$todayConferences = $confModel->getTodayConferences($userRole);
			$weekConferences = $confModel->getThisWeekConferences($userRole);
			
			// Add conferences to schedules for table display
			foreach ($weekConferences as $conf) {
				$slot = $conf['slot'] ?? 0; // Default to 0 if no slot assigned
				$allDayConferences[] = [
					'_id' => $conf['_id'],
					'type' => 'conference',
					'date' => $conf['date'],
					'slot' => $slot,
					'title' => $conf['title'],
					'location' => $conf['location'],
					'description' => $conf['description'],
					'created_by' => $conf['created_by'] ?? null
				];
			}
		}
		include __DIR__ . '/../views/schedule.php';
	}
}
