<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=res_q_meal", "root", "", [PDO::ATTR_TIMEOUT => 2]);
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables: " . implode(", ", $tables) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
