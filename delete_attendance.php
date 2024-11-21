<?php
require 'db_connection.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die("Invalid ID.");
}

$stmt = $conn->prepare("DELETE FROM Attendance WHERE attendance_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute() === TRUE) {
    header("Location: manage_attendance.php?success=2");
    exit;
} else {
    echo "Error deleting record. Please try again later. <a href='manage_attendance.php'>Go back</a>";
}

$stmt->close();
$conn->close();
?>
