<?php
// models/RegistrationModel.php

require_once __DIR__ . '/BaseModel.php';

class RegistrationModel extends BaseModel {
    public function __construct() {
        require_once __DIR__ . '/../config.php';
        $db = getMongoDBConnection();
        $this->collection = $db->registrations;
    }

    public function createRegistration($userId, $scheduleId, $status = 'pending') {
        $registration = [
            'user_id' => $userId,
            'schedule_id' => $scheduleId,
            'registration_time' => new MongoDB\BSON\UTCDateTime(),
            'status' => $status
        ];
        return $this->insertOne($registration);
    }

    public function getRegistrationsByUser($userId) {
        return $this->find(['user_id' => $userId]);
    }

    public function getRegistrationsBySchedule($scheduleId) {
        return $this->find(['schedule_id' => $scheduleId]);
    }

    public function updateRegistrationStatus($registrationId, $status) {
        return $this->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($registrationId)],
            ['$set' => ['status' => $status]]
        );
    }

    public function isUserRegistered($userId, $scheduleId) {
        return $this->findOne([
            'user_id' => $userId,
            'schedule_id' => $scheduleId
        ]) !== null;
    }
}
