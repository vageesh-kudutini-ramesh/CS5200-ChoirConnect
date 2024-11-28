<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance and Dues Entry</title>
    <style>
        .button {
            display: inline-block;
            padding: 10px 15px;
            font-size: 16px;
            color: white;
            background-color: #007BFF;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Attendance and Dues Entry</h1>

    <!-- Attendance Entry Form -->
    <h2>Enter Attendance</h2>
    <form method="POST" action="insert_data.php">
        <input type="hidden" name="add_attendance" value="true">
        <label for="member_id">Member ID:</label>
        <input type="text" id="member_id" name="member_id" required>
        
        <label for="attendance_date">Attendance Date:</label>
        <input type="date" id="attendance_date" name="attendance_date" required>
        
        <label for="absence_reason">Absence Reason:</label>
        <input type="text" id="absence_reason" name="absence_reason" placeholder="Enter reason for absence (if any)">
        
        <button type="submit">Submit Attendance</button>
    </form>

    <hr>

    <!-- Dues Entry Form -->
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
        
        <button type="submit">Submit Dues</button>
    </form>

    <hr>

    <!-- File Upload Form -->
    <h2>Upload CSV/Excel File</h2>
    <form method="POST" action="upload_csv.php" enctype="multipart/form-data">
        <label for="csv_file">Choose File:</label>
        <input type="file" id="csv_file" name="csv_file" required>
        <button type="submit">Upload File</button>
    </form>

    <hr>

    <!-- Back to Dashboard Button -->
    <a href="dashboard.php" class="button">Back to Dashboard</a>
</body>
</html>
