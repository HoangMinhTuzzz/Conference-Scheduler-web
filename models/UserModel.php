<?php
require_once 'BaseModel.php';

class UserModel extends BaseModel {
    protected $collection;

    public function __construct() {
        parent::__construct();
        $this->collection = $this->db->users;
    }

    public function createUser($data) {
        return $this->collection->insertOne($data);
    }

    public function getUserByEmail($email) {
        return $this->collection->findOne(['email' => $email]);
    }

    public function getAllUsers() {
        return $this->collection->find();
    }
}
