<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "config.php";

// Load controllers
require_once "controllers/HomeController.php";
require_once "controllers/AuthController.php";
require_once "controllers/ConferenceController.php";
require_once "controllers/ScheduleController.php";
require_once "controllers/UserController.php";

// Router
$page = $_GET['page'] ?? 'home';

switch ($page) {

    case 'home':
        (new HomeController())->index();
        break;

    case 'login':
        (new AuthController())->login();
        break;

    case 'register':
        (new AuthController())->register();
        break;

    case 'conference':
        (new ConferenceController())->index();
        break;

    case 'conference_detail':
        (new ConferenceController())->detail();
        break;

    case 'conference_create':
        (new ConferenceController())->create();
        break;

    case 'conference_edit':
        (new ConferenceController())->edit();
        break;

    case 'conference_delete':
        (new ConferenceController())->delete();
        break;

    case 'api_conference_detail':
        header('Content-Type: application/json');
        (new ConferenceController())->getDetailJson();
        break;

    case 'schedule':
        (new ScheduleController())->index();
        break;


    case 'register_session':
        // Hiển thị form đăng ký session và xử lý đăng ký
        session_start();
        $userId = $_SESSION['user']['_id'] ?? null;
        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }
        require_once 'controllers/RegistrationController.php';
        require_once 'models/ScheduleModel.php';
        $controller = new RegistrationController();
        $scheduleModel = new ScheduleModel();
        $schedules = $scheduleModel->getAllSchedules();
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $scheduleId = $_POST['schedule_id'] ?? '';
            $result = $controller->register($userId, $scheduleId);
            $message = $result['message'];
        }
        $user_id = $userId;
        include 'views/registration_form.php';
        break;

    case 'registration_history':
        // Hiển thị danh sách session đã đăng ký của user
        session_start();
        $userId = $_SESSION['user']['_id'] ?? null;
        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }
        require_once 'controllers/RegistrationController.php';
        $controller = new RegistrationController();
        $registrations = $controller->listUserRegistrations($userId);
        include 'views/registration_list.php';
        break;

    case 'profile':
        (new UserController())->profile();
        break;

    case 'users':
        (new UserController())->index();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    default:
        echo "404 Not Found";
}