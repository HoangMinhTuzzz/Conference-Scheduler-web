<?php


require_once "models/ConferenceModel.php";

class ConferenceController {

    private $model;

    public function __construct() {
        $this->model = new ConferenceModel();
    }

    public function index() {
        // Get user role from session
        $userRole = $_SESSION['user']['role'] ?? 'user';
        $userEmail = $_SESSION['user']['email'] ?? null;
        
        // Get conferences based on user role
        $conferences = $this->model->getAllConferences($userRole, $userEmail);

        include "views/conference_list.php";
    }

    public function detail() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Invalid ID";
            return;
        }

        $conference = $this->model->getConferenceById($id);

        include "views/conference_detail.php";
    }

    public function create() {
        // Only admin can create conferences
        $userRole = $_SESSION['user']['role'] ?? 'user';
        
        if ($userRole !== 'admin') {
            echo "Unauthorized: Only admins can create conferences";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            
            // Validate date is not in the past
            $conferenceDate = $data['date'] ?? null;
            $slot = (int)($data['slot'] ?? 0);
            
            if (!$conferenceDate) {
                echo "Error: Date is required";
                return;
            }
            
            $today = date('Y-m-d');
            $currentHour = (int)date('H');
            
            // Check if date is in the past
            if ($conferenceDate < $today) {
                echo "Error: Cannot create conferences in the past";
                return;
            }
            
            // Check if date is today and slot is before current time
            if ($conferenceDate === $today && $slot <= 6 && $currentHour >= 17) {
                echo "Error: Cannot create conferences for past times today. Only Slot 7 (8:00 PM - 9:00 PM) is available.";
                return;
            }
            
            // Convert slot to integer
            if (isset($data['slot'])) {
                $data['slot'] = (int)$data['slot'];
            }
            $this->model->createConference($data);
            header("Location: index.php?page=conference");
            exit;
        } else {
            include "views/conference_create.php";
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Invalid ID";
            return;
        }

        $userRole = $_SESSION['user']['role'] ?? 'user';
        $userEmail = $_SESSION['user']['email'] ?? null;

        if (!$this->model->canModify($id, $userRole, $userEmail)){
            echo "Unathourzied: Chi admin co the edit conferences";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = $_POST;
            
            // Validate date is not in the past
            $conferenceDate = $data['date'] ?? null;
            $slot = (int)($data['slot'] ?? 0);
            
            if (!$conferenceDate) {
                echo "Error: Date is required";
                return;
            }
            
            $today = date('Y-m-d');
            $currentHour = (int)date('H');
            
            // Check if date is in the past
            if ($conferenceDate < $today) {
                echo "Error: Cannot edit conference to a past date";
                return;
            }
            
            // Check if date is today and slot is before current time
            if ($conferenceDate === $today && $slot <= 6 && $currentHour >= 17) {
                echo "Error: Cannot edit conference for past times today. Only Slot 7 (8:00 PM - 9:00 PM) is available.";
                return;
            }

            if (isset($data['slot'])){
                $data['slot'] = (int)$data['slot'];
            }
            $this->model->updateConference($id, $data);
            header("Location: index.php?page=conferences");
            exit;
        }else{
            $conference = $this->model->getConferenceById($id);
            include "views/conference_edit.php";
        }
    }
        
    
    public function getDetailJson() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
            return;
        }

        $conference = $this->model->getConferenceById($id);

        if (!$conference) {
            echo json_encode(['success' => false, 'message' => 'Conference not found']);
            return;
        }

        echo json_encode([
            'success' => true,
            'conference' => [
                '_id' => (string)($conference['_id'] ?? ''),
                'title' => $conference['title'] ?? '',
                'date' => $conference['date'] ?? '',
                'location' => $conference['location'] ?? '',
                'slot' => $conference['slot'] ?? 0,
                'description' => $conference['description'] ?? '',
                'created_by' => $conference['created_by'] ?? ''
            ]
        ]);
    }

    public function delete() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Invalid ID";
            return;
        }

        // Check authorization
        $userRole = $_SESSION['user']['role'] ?? 'user';
        $userEmail = $_SESSION['user']['email'] ?? null;
        
        if (!$this->model->canModify($id, $userRole, $userEmail)) {
            echo "Unauthorized: Only the creator or admin can delete this conference";
            return;
        }

        $this->model->deleteConference($id);
        header("Location: index.php?page=conference");
        exit;
    }

    public function getAvailableSlots() {
        $date = $_GET['date'] ?? null;

        if (!$date) {
            echo json_encode(['success' => false, 'message' => 'Date is required']);
            return;
        }

        // Check if the selected date is today and it's already past 5 PM (17:00)
        $today = date('Y-m-d');
        $currentHour = (int)date('H');
        
        // Get all conferences for the given date
        $conferences = $this->model->getConferencesByDate($date);
        
        // Get all available slots (1-7)
        $allSlots = [1, 2, 3, 4, 5, 6, 7];
        
        // Get booked slots
        $bookedSlots = [];
        foreach ($conferences as $conference) {
            if (isset($conference['slot'])) {
                $bookedSlots[] = (int)$conference['slot'];
            }
        }
        
        // If it's today and after 5 PM, block slots 1-6 (before 5 PM)
        $unavailableSlots = [];
        if ($date === $today && $currentHour >= 17) {
            $unavailableSlots = [1, 2, 3, 4, 5, 6]; // Block all slots before 5 PM
        }
        
        // Combine booked and unavailable slots
        $allUnavailableSlots = array_unique(array_merge($bookedSlots, $unavailableSlots));
        
        // Get available slots
        $availableSlots = array_diff($allSlots, $allUnavailableSlots);
        
        echo json_encode([
            'success' => true,
            'date' => $date,
            'bookedSlots' => $bookedSlots,
            'unavailableSlots' => $unavailableSlots,
            'availableSlots' => array_values($availableSlots)
        ]);
    }
}