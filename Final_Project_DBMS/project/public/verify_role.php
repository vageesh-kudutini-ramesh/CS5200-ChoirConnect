<?php
require_once '../config/db.php';
require_once '../utils/logger.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $requiredRole = $_POST['role'];

    $stmt = $pdo->prepare("SELECT role FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $user['role'] === $requiredRole) {
        logMessage("Role verification successful for user: $username");
        echo json_encode(['status' => 'success']);
    } else {
        logMessage("Role verification failed for user: $username", 'ERROR');
        echo json_encode(['status' => 'failure']);
    }
}
?>
