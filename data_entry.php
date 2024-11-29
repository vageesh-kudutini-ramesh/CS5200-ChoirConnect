<?php
require 'db_connection.php';
session_start();

$role = $_SESSION['role'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance and Dues Entry</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            text-align: center;
        }
        h2 {
            color: #007bff;
            text-align: center;
        }
        form {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type=text], input[type=date], input[type=number], select, input[type=file] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button[type=submit], .button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 15px;
        }
        button[type=submit]:hover, .button:hover {
            background-color: #0056b3;
        }
        .button {
            text-align: center;
            display: block;
            width: fit-content;
            margin: 20px auto;
            text-decoration: none;
        }
        hr {
            border: 1px solid #ddd;
            margin: 40px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Attendance and Dues Entry</h1>
    </header>

    <!-- Attendance Entry Form -->
    <?php if ($role !== 'Treasurer' && $role !== 'Member'): ?>
        <h2>Enter Attendance</h2>
        <form method="POST" action="insert_data.php">
            <input type="hidden" name="add_attendance" value="true">
            <label for="member_id">Member ID:</label>
            <input type="text" id="member_id" name="member_id" required>
            <label for="attendance_date">Attendance Date:</label>
            <input type="date" id="attendance_date" name="attendance_date" required>
            <label for="absence_reason">Absence Reason:</label>
            <input type="text" id="absence_reason" name="absence_reason" placeholder="Enter reason for absence (if any)">
            <button type="submit"><i class="fas fa-paper-plane"></i> Submit Attendance</button>
        </form>
        <hr>
    <?php endif; ?>

    <!-- Dues Entry Form -->
    <?php if ($role !== 'Secretary' && $role !== 'Member'): ?>
        <h2>Enter Dues</h2>
        <form method="POST" action="insert_data.php">
            <input type="hidden" name="add_dues" value="true">
            <label for="member_id_dues">Member ID:</label>
            <input type="text" id="member_id_dues" name="member_id" required>
            <label for="dues_amount">Dues Amount:</label>
            <input type="number" step="0.01" id="dues_amount" name="dues_amount" required>
            <label for="payment_date">Payment Date:</label>
            <input type="date" id="payment_date" name="payment_date" required>
            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="" disabled selected>Select Payment Method</option>
                <option value="Venmo">Venmo</option>
                <option value="Check">Check</option>
                <option value="Mail">Mail</option>
            </select>
            <label for="payment_frequency">Payment Frequency:</label>
            <select id="payment_frequency" name="payment_frequency" required>
                <option value="Monthly">Monthly</option>
                <option value="Yearly">Yearly</option>
            </select>
            <button type="submit"><i class="fas fa-paper-plane"></i> Submit Dues</button>
        </form>
        <hr>
    <?php endif; ?>

    <!-- File Upload Form -->
    <?php if ($role !== 'Member'): ?>
        <h2>Upload CSV/Excel File</h2>
        <form method="POST" action="upload_csv.php" enctype="multipart/form-data">
            <label for="csv_file">Choose File:</label>
            <input type="file" id="csv_file" name="csv_file" required>
            <button type="submit"><i class="fas fa-upload"></i> Upload File</button>
        </form>
        <hr>
    <?php endif; ?>

    <!-- Back to Dashboard Button -->
    <a href="dashboard.php" class="button"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
</body>
</html>
