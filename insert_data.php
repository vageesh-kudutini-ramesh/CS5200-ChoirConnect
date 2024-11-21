<?php
require 'db_connection.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_attendance'])) {
        // Handle Attendance Entry
        $member_id = $_POST['member_id'] ?? null;
        $date = $_POST['attendance_date'] ?? null; // Use 'attendance_date' to match the form
        $status = 1; // Default to "Present"
        $absence_reason = "N/A"; // Default reason

        if (!$member_id || !$date) {
            echo json_encode(["error" => "Member ID and Attendance Date are required."]);
            exit;
        }

        try {
            $stmt = $conn->prepare("INSERT INTO Attendance (member_id, date, status, absence_reason) VALUES (?, ?, ?, ?)");
            $stmt->execute([$member_id, $date, $status, $absence_reason]);
            echo json_encode(["success" => "Attendance record inserted successfully!"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    } elseif (isset($_POST['add_dues'])) {
        // Handle Dues Entry
        $member_id = $_POST['member_id'] ?? null;
        $amount = $_POST['dues_amount'] ?? null;

        if (!$member_id || !$amount) {
            echo json_encode(["error" => "Member ID and Dues Amount are required."]);
            exit;
        }

        try {
            $stmt = $conn->prepare("INSERT INTO Dues (member_id, amount) VALUES (?, ?)");
            $stmt->execute([$member_id, $amount]);
            echo json_encode(["success" => "Dues record inserted successfully!"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Invalid operation."]);
    }
} else {
    echo json_encode(["error" => "Invalid request method. Please use POST."]);
}
?>
