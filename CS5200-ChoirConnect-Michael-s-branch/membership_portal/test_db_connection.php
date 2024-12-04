<?php
require 'db_connection.php';

try {
    // Test a query
    $query = $conn->query("SHOW TABLES");
    $tables = $query->fetchAll(PDO::FETCH_ASSOC);
    echo "Connection successful. Tables in the database:<br>";
    foreach ($tables as $table) {
        echo $table['Tables_in_choir_management'] . "<br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
