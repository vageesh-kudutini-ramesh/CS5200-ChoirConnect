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
            $date = $_POST['attendance_date'] ?? null;
            $status = 1; // Default to "Present"
            $absence_reason = $_POST['absence_reason'] ?? "N/A"; // Accept reason or default to "N/A"

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
            $payment_date = $_POST['payment_date'] ?? null;
            $payment_method = $_POST['payment_method'] ?? null;
            $payment_frequency = $_POST['payment_frequency'] ?? null;

            // Validate required fields
            if (!$member_id || !$amount || !$payment_date || !$payment_method || !$payment_frequency) {
                throw new Exception("All fields are required for Dues Entry.");
            }

            // Validate payment method
            $valid_methods = ['Venmo', 'Check', 'Mail'];
            if (!in_array($payment_method, $valid_methods, true)) {
                throw new Exception("Invalid payment method. Allowed values: Venmo, Check, Mail.");
            }

            // Validate payment frequency
            $valid_frequencies = ['Monthly', 'Yearly'];
            if (!in_array($payment_frequency, $valid_frequencies, true)) {
                throw new Exception("Invalid payment frequency. Allowed values: Monthly, Yearly.");
            }

            $stmt = $conn->prepare("INSERT INTO Dues (member_id, amount, payment_date, payment_method, payment_frequency) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$member_id, $amount, $payment_date, $payment_method, $payment_frequency]);
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
        <link rel='stylesheet' href='styles.css'> <!-- Assuming you have a shared stylesheet -->
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-color: #f4f4f4;
            }
            .container {
                text-align: center;
                background-color: #ffffff;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .message {
                font-size: 18px;
                color: #333333;
                margin-bottom: 20px;
            }
            .redirect-message {
                font-size: 16px;
                color: #007bff;
            }
            .redirect-message a {
                color: #007bff;
                text-decoration: none;
            }
            .redirect-message a:hover {
                text-decoration: underline;
            }
        </style>
        <script>
            setTimeout(() => { window.location.href = 'data_entry.php'; }, 5000);
        </script>
    </head>
    <body>
        <div class='container'>
            <p class='message'>" . htmlspecialchars($response['success'] ?? $response['error'] ?? 'Unknown error.') . "</p>
            <p class='redirect-message'>You will be redirected back to the Data Entry page in 5 seconds.</p>
            <p class='redirect-message'><a href='data_entry.php'>Click here</a> if you are not redirected automatically.</p>
        </div>
    </body>
    </html>";
    exit;
} else {
    // Handle invalid request method
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method. Please use POST."]);
}
