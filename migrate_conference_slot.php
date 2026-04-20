<?php
/**
 * Migration script to add 'slot' field to existing conferences
 * Run this once to ensure all existing conferences have a time slot assigned
 */

require_once __DIR__ . '/config.php';

$db = getMongoDBConnection();
$conferences = $db->conferences;

// Update all documents that don't have slot field
$result = $conferences->updateMany(
    ['slot' => ['$exists' => false]],
    ['$set' => ['slot' => 1]] // Default to slot 1 (9:00-10:00)
);

echo "Migration completed!\n";
echo "Matched: " . $result->getMatchedCount() . " documents\n";
echo "Modified: " . $result->getModifiedCount() . " documents\n";
echo "\nAll conferences now have a time slot assigned (default: Slot 1).\n";
?>
