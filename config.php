<?php
// MongoDB connection config
require 'vendor/autoload.php'; // Composer autoload for MongoDB //tắt để test tạm giao diện

function getMongoDBConnection() {
    $client = new MongoDB\Client('mongodb://localhost:27017');
    return $client->selectDatabase('conference_scheduler');
}
