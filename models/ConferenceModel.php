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
        return $this->collection->insertOne($data);
    }

    public function getConferenceById($id) {
        return $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    }

    public function getAllConferences() {
        return $this->collection->find();
    }

    public function updateConference($id, $data) {
        return $this->collection->updateOne(['_id' => new MongoDB\BSON\ObjectId($id)], ['$set' => $data]);
    }

    public function deleteConference($id) {
        return $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    }
}
