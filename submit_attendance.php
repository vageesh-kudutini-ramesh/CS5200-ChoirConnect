<?php
require 'db_connection.php';

// Get form data
$member_id = isset($_POST['member_id']) ? $_POST['member_id'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$absence_reason = isset($_POST['absence_reason']) ? $_POST['absence_reason'] : '';

// Input validation
if (empty($member_id) || !is_numeric($member_id) || $member_id <= 0) {
    die("Invalid Member ID.");
}
if (empty($date) || !strtotime($date)) {
    die("Invalid date format.");
}
if (!isset($status) || ($status != "1" && $status != "0")) {
    die("Invalid status value.");
}

// Use prepared statement to insert data
$stmt = $conn->prepare("INSERT INTO Attendance (member_id, date, status, absence_reason) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isis", $member_id, $date, $status, $absence_reason);

if ($stmt->execute() === TRUE) {
    header("Location: manage_attendance.php?success=1");
    exit;
} else {
    echo "Error inserting data: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
