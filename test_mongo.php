<?php
require 'config.php';

echo "<pre>";
try {
    $db = getMongoDBConnection();
    $collections = $db->listCollections();
    echo "Kết nối MongoDB Atlas thành công!\n";
    echo "Danh sách collection trong database:\n";
    foreach ($collections as $col) {
        echo "- " . $col->getName() . "\n";
    }
} catch (Exception $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
}
echo "</pre>";
