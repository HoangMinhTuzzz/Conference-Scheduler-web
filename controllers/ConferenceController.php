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

        // Check authorization
        $userRole = $_SESSION['user']['role'] ?? 'user';
        $userEmail = $_SESSION['user']['email'] ?? null;
        
        if (!$this->model->canModify($id, $userRole, $userEmail)) {
            echo "Unauthorized: Only the creator or admin can edit this conference";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            // Convert slot to integer
            if (isset($data['slot'])) {
                $data['slot'] = (int)$data['slot'];
            }
            $this->model->updateConference($id, $data);
            header("Location: index.php?page=conference");
            exit;
        } else {
            $conference = $this->model->getConferenceById($id);
            include "views/conference_edit.php";
        }
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
}