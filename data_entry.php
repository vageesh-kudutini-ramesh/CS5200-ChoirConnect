<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Entry</title>
</head>
<body>
    <h2>Attendance and Dues Entry</h2>

    <!-- Attendance Entry Form -->
    <form method="POST" action="data_process.php">
        <h3>Enter Attendance</h3>
        <label>Member ID:</label><br>
        <input type="text" name="member_id" required><br>
        
        <label>Attendance Date:</label><br>
        <input type="date" name="attendance_date" required><br>
        
        <button type="submit" name="submit_attendance">Submit Attendance</button>
    </form>

    <!-- Dues Entry Form -->
    <form method="POST" action="data_process.php">
        <h3>Enter Dues</h3>
        <label>Member ID:</label><br>
        <input type="text" name="member_id" required><br>
        
        <label>Dues Amount:</label><br>
        <input type="number" name="dues_amount" required><br>
        
        <button type="submit" name="submit_dues">Submit Dues</button>
    </form>

    <!-- Bulk Data Upload -->
    <h3>Bulk Upload (CSV/Excel)</h3>
    <form method="POST" action="data_process.php" enctype="multipart/form-data">
        <label>Upload CSV/Excel File:</label><br>
        <input type="file" name="file_upload" accept=".csv, .xlsx" required><br>
        <button type="submit" name="upload_bulk">Upload File</button>
    </form>
</body>
</html>
