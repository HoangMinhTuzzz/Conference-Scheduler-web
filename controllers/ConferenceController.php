<?php
require_once "models/ConferenceModel.php";

class ConferenceController {

    private $model;

    public function __construct() {
        $this->model = new ConferenceModel();
    }

    public function index() {
        // Model đã trả về array rồi
        $conferences = $this->model->getAllConferences();

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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->createConference($_POST);
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->updateConference($id, $_POST);
            header("Location: index.php?page=conference");
            exit;
        } else {
            $conference = $this->model->getConferenceById($id);
            include "views/conference_edit.php";
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->model->deleteConference($id);
        }

        header("Location: index.php?page=conference");
        exit;
    }
}