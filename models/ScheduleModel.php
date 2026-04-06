<?php
require_once 'BaseModel.php';

class ScheduleModel extends BaseModel {
    protected $collection;

    public function __construct() {
        parent::__construct();
        $this->collection = $this->db->schedules;
    }

    public function addSchedule($data) {
        return $this->collection->insertOne($data);
    }

    public function getSchedulesByUser($userId) {
        return $this->collection->find(['user_id' => $userId]);
    }

    public function getSchedulesByConference($confId) {
        return $this->collection->find(['conference_id' => $confId]);
    }
}
