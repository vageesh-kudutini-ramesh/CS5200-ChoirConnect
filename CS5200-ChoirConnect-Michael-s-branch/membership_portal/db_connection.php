<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

$host = 'localhost';
$dbname = 'choir_management';
$username = 'root';
$password = 'Enigma@007';   

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable exceptions for mysqli errors


try {
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8"); // Set character set to avoid charset issues
} catch (mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
