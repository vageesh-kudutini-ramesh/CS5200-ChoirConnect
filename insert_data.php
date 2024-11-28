<?php
require 'db_connection.php';

// Start output buffering
ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [];
    try {
        if (isset($_POST['add_attendance'])) {
            // Handle Attendance Entry
            $member_id = $_POST['member_id'] ?? null;
            $date = $_POST['attendance_date'] ?? null; // Use 'attendance_date' to match the form
            $status = 1; // Default to "Present"
            $absence_reason = "N/A"; // Default reason

            if (!$member_id || !$date) {
                throw new Exception("Member ID and Attendance Date are required.");
            }

            $stmt = $conn->prepare("INSERT INTO Attendance (member_id, date, status, absence_reason) VALUES (?, ?, ?, ?)");
            $stmt->execute([$member_id, $date, $status, $absence_reason]);
            $response['success'] = "Attendance record inserted successfully!";
        } elseif (isset($_POST['add_dues'])) {
            // Handle Dues Entry
            $member_id = $_POST['member_id'] ?? null;
            $amount = $_POST['dues_amount'] ?? null;

            if (!$member_id || !$amount) {
                throw new Exception("Member ID and Dues Amount are required.");
            }

            $stmt = $conn->prepare("INSERT INTO Dues (member_id, amount) VALUES (?, ?)");
            $stmt->execute([$member_id, $amount]);
            $response['success'] = "Dues record inserted successfully!";
        } else {
            throw new Exception("Invalid operation.");
        }
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }

    // Display feedback to the user with a redirect
    ob_end_clean();
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Submission Status</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
            .message { font-size: 18px; margin-bottom: 20px; }
        </style>
        <script>
            setTimeout(() => { window.location.href = 'data_entry.php'; }, 5000);
        </script>
    </head>
    <body>
        <p class='message'>" . htmlspecialchars($response['success'] ?? $response['error'] ?? 'Unknown error.') . "</p>
        <p>You will be redirected back to the Data Entry page in 5 seconds.</p>
        <p><a href='data_entry.php'>Click here</a> if you are not redirected automatically.</p>
    </body>
    </html>";
    exit;
} else {
    // Handle invalid request method
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method. Please use POST."]);
}
