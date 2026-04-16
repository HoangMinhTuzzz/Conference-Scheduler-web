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
}
