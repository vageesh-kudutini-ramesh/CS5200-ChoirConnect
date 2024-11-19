<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Entry</title>
    <!-- Link to the CSS file -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h2>Attendance and Dues Entry</h2>
    </header>

    <div class="form-container">
        <!-- Attendance Entry Form -->
        <form method="POST" action="data_process.php">
            <h3>Enter Attendance</h3>
            <label for="member_id_attendance">Member ID:</label>
            <input type="text" id="member_id_attendance" name="member_id" required>
            
            <label for="attendance_date">Attendance Date:</label>
            <input type="date" id="attendance_date" name="attendance_date" required>
            
            <button type="submit" name="submit_attendance">Submit Attendance</button>
        </form>
    </div>

    <div class="form-container">
        <!-- Dues Entry Form -->
        <form method="POST" action="data_process.php">
            <h3>Enter Dues</h3>
            <label for="member_id_dues">Member ID:</label>
            <input type="text" id="member_id_dues" name="member_id" required>
            
            <label for="dues_amount">Dues Amount:</label>
            <input type="number" id="dues_amount" name="dues_amount" required>
            
            <button type="submit" name="submit_dues">Submit Dues</button>
        </form>
    </div>

    <div class="form-container">
        <!-- Bulk Data Upload -->
        <form method="POST" action="data_process.php" enctype="multipart/form-data">
            <h3>Bulk Upload (CSV/Excel)</h3>
            <label for="file_upload">Upload CSV/Excel File:</label>
            <input type="file" id="file_upload" name="file_upload" accept=".csv, .xlsx" required>
            <button type="submit" name="upload_bulk">Upload File</button>
        </form>
    </div>
</body>
</html>

