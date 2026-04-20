<?php
/**
 * Migration script to add 'created_by' field to existing conferences
 * Run this once to ensure all existing conferences are marked as created by admin
 */

require_once __DIR__ . '/config.php';

$db = getMongoDBConnection();
$conferences = $db->conferences;

// Update all documents that don't have created_by field
$result = $conferences->updateMany(
    ['created_by' => ['$exists' => false]],
    ['$set' => ['created_by' => 'admin@gmail.com']]
);

echo "Migration completed!\n";
echo "Matched: " . $result->getMatchedCount() . " documents\n";
echo "Modified: " . $result->getModifiedCount() . " documents\n";
echo "\nAll conferences are now marked as created by admin.\n";
?>
