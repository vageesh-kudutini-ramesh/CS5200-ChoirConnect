<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance and Dues Entry</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { margin-bottom: 30px; }
        h1, h2 { color: #333; }
        label { margin-right: 10px; }
        input { margin-right: 10px; }
        button { padding: 5px 10px; }
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
        <button type="submit">Submit Attendance</button>
    </form>

    <!-- Dues Entry Form -->
    <h2>Enter Dues</h2>
    <form method="POST" action="insert_data.php">
        <input type="hidden" name="add_dues" value="true">
        <label for="member_id_dues">Member ID:</label>
        <input type="text" id="member_id_dues" name="member_id" required>
        <label for="dues_amount">Dues Amount:</label>
        <input type="number" step="0.01" id="dues_amount" name="dues_amount" required>
        <button type="submit">Submit Dues</button>
    </form>
</body>
</html>
