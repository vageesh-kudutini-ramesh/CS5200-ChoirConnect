<?php
require_once '../config/db.php';
require_once '../utils/logger.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        logMessage("Login successful for user: $username");
        echo json_encode(['status' => 'success']);
    } else {
        logMessage("Login failed for user: $username", 'ERROR');
        echo json_encode(['status' => 'failure']);
    }
}
?>
