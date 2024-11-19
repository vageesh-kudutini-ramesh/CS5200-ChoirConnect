<?php
// Include database configuration and any necessary utility functions
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password']; // Plain text password

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Store the hashed password in the database
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashedPassword]);

    echo "User registered successfully!";
}
?>
