<?php
require_once 'BaseModel.php';

class ConferenceModel extends BaseModel {
    protected $collection;

    public function __construct() {
        require_once __DIR__ . '/../config.php';
        $db = getMongoDBConnection();
        $this->collection = $db->conferences;
    }

    public function createConference($data) {
        // Add created_by field when creating conference
        $data['created_by'] = $_SESSION['user']['email'] ?? 'admin@gmail.com';
        return $this->collection->insertOne($data);
    }

    public function getConferenceById($id) {
        return $this->collection->findOne([
            '_id' => new MongoDB\BSON\ObjectId($id)
        ]);
    }

    // Get all conferences (for admin) or only admin-created ones (for users)
    public function getAllConferences($userRole = 'user', $userEmail = null) {
        // If admin, show all conferences
        if ($userRole === 'admin') {
            return $this->collection->find()->toArray();
        }
        
        // For regular users, only show conferences created by admin
        return $this->collection->find([
            'created_by' => 'admin@gmail.com'
        ])->toArray();
    }

    // Check if user is the creator of the conference
    public function isCreatedByUser($conferenceId, $userEmail) {
        $conference = $this->getConferenceById($conferenceId);
        return $conference && ($conference['created_by'] ?? null) === $userEmail;
    }

    // Check if user can edit/delete (only creator or admin)
    public function canModify($conferenceId, $userRole, $userEmail) {
        if ($userRole === 'admin') {
            return true;
        }
        return $this->isCreatedByUser($conferenceId, $userEmail);
    }

    // Get conferences scheduled for today
    public function getTodayConferences($userRole = 'user') {
        $today = date('Y-m-d');
        
        $filter = ['date' => $today];
        
        // If regular user, only show admin-created conferences
        if ($userRole !== 'admin') {
            $filter['created_by'] = 'admin@gmail.com';
        }
        
        return $this->collection->find($filter)->toArray();
    }

    // Get conferences scheduled for this week
    public function getThisWeekConferences($userRole = 'user') {
        $today = new \DateTime();
        $weekStart = clone $today;
        $weekStart->modify('Monday this week');
        $weekEnd = clone $weekStart;
        $weekEnd->modify('+6 days');
        
        $startStr = $weekStart->format('Y-m-d');
        $endStr = $weekEnd->format('Y-m-d');
        
        $filter = [
            'date' => [
                '$gte' => $startStr,
                '$lte' => $endStr
            ]
        ];
        
        // If regular user, only show admin-created conferences
        if ($userRole !== 'admin') {
            $filter['created_by'] = 'admin@gmail.com';
        }
        
        return $this->collection->find($filter)->toArray();
    }

    // Get conferences scheduled within a date range
    public function getConferencesByDateRange($startDate, $endDate, $userRole = 'user') {
        $filter = [
            'date' => [
                '$gte' => $startDate,
                '$lte' => $endDate
            ]
        ];
        
        // If regular user, only show admin-created conferences
        if ($userRole !== 'admin') {
            $filter['created_by'] = 'admin@gmail.com';
        }
        
        return $this->collection->find($filter)->toArray();
    }

    public function updateConference($id, $data) {
        return $this->collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => $data]
        );
    }

    public function deleteConference($id) {
        return $this->collection->deleteOne([
            '_id' => new MongoDB\BSON\ObjectId($id)
        ]);
    }
}