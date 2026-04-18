<?php
require_once __DIR__ . '/BaseModel.php';

class UserModel extends BaseModel {
    protected $collection;

    public function __construct() {
        require_once __DIR__ . '/../config.php';
        $db = getMongoDBConnection();
        $this->collection = $db->users;
    }

    public function createUser($data) {
        // $data gồm: email, password
        return $this->collection->insertOne($data);
    }

    public function getUserByEmail($email) {
        return $this->collection->findOne(['email' => $email]);
    }

    public function getAllUsers() {
        return $this->collection->find();
    }

    public function approveUser($id) {
        return $this->collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => ['status' => 'active']]
        );
    }

    public function updatePassword($id, $hash) {
        return $this->collection->updateOne(
            ['_id' => $id instanceof \MongoDB\BSON\ObjectId ? $id : new \MongoDB\BSON\ObjectId($id)],
            ['$set' => ['password' => $hash]]
        );
    }
}
