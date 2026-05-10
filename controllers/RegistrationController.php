<?php
// controllers/RegistrationController.php

require_once __DIR__ . '/../models/RegistrationModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ScheduleModel.php';

class RegistrationController {
    private $registrationModel;
    private $userModel;
    private $scheduleModel;

    public function __construct() {
        $this->registrationModel = new RegistrationModel();
        $this->userModel = new UserModel();
        $this->scheduleModel = new ScheduleModel();
    }

    // Register a user for a schedule
    public function register($userId, $scheduleId) {
        if ($this->registrationModel->isUserRegistered($userId, $scheduleId)) {
            return ['success' => false, 'message' => 'User already registered for this session.'];
        }
        $result = $this->registrationModel->createRegistration($userId, $scheduleId);
        return ['success' => true, 'message' => 'Registration successful.', 'registration_id' => $result->getInsertedId()];
    }

    // List registrations for a user
    public function listUserRegistrations($userId) {
        return $this->registrationModel->getRegistrationsByUser($userId);
    }

    // List registrations for a schedule
    public function listScheduleRegistrations($scheduleId) {
        return $this->registrationModel->getRegistrationsBySchedule($scheduleId);
    }

    // Update registration status
    public function updateStatus($registrationId, $status) {
        return $this->registrationModel->updateRegistrationStatus($registrationId, $status);
    }
}
