<?php
// MongoDB connection config
require 'vendor/autoload.php'; // Composer autoload for MongoDB

function getMongoDBConnection() {
    $client = new MongoDB\Client(
        'mongodb+srv://minhmau:Minhmauday2468@cluster0.wudwer1.mongodb.net/conference_scheduler?retryWrites=true&w=majority&appName=Cluster0'
    );
    return $client->selectDatabase('conference_scheduler');
}
