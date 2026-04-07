<?php
require_once "models/ConferenceModel.php";

class ConferenceController {

    public function index() {
        $conferences = ConferenceModel::getAll();
        include "views/conference_list.php";
    }

    public function detail() {
        $id = $_GET['id'];
        $conference = ConferenceModel::find($id);
        include "views/conference_detail.php";
    }

    public function create() {
        global $conn;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            ConferenceModel::create($_POST);
            header("Location: index.php?page=conference");
        } else {
            include "views/conference_create.php";
        }
    }

    public function edit() {
        include "views/conference_edit.php";
    }
}