<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Adjust your XAMPP password
$dbname = "membership_portal"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process single attendance entry
if (isset($_POST['submit_attendance'])) {
    $member_id = $_POST['member_id'];
    $attendance_date = $_POST['attendance_date'];

    // Insert into database
    $sql = "INSERT INTO attendance (member_id, attendance_date) VALUES ('$member_id', '$attendance_date')";
    if ($conn->query($sql) === TRUE) {
        echo "Attendance for Member ID $member_id on $attendance_date has been recorded.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Process single dues entry
if (isset($_POST['submit_dues'])) {
    $member_id = $_POST['member_id'];
    $dues_amount = $_POST['dues_amount'];

    // Insert into database
    $sql = "INSERT INTO dues (member_id, amount) VALUES ('$member_id', '$dues_amount')";
    if ($conn->query($sql) === TRUE) {
        echo "Dues of $dues_amount for Member ID $member_id have been recorded.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Process bulk file upload
if (isset($_FILES['file_upload'])) {
    $file = $_FILES['file_upload']['tmp_name'];
    $file_type = $_FILES['file_upload']['type'];

    // Check file type
    if ($file_type === 'text/csv' || $file_type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
        // Parse CSV/Excel file (you can use PhpSpreadsheet here for Excel files)
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Assuming the CSV has columns: Member ID, Date, Dues Amount
                $member_id = $data[0];
                $attendance_date = $data[1];
                $dues_amount = $data[2];

                // Insert into attendance table
                $sql = "INSERT INTO attendance (member_id, attendance_date) VALUES ('$member_id', '$attendance_date')";
                $conn->query($sql);

                // Insert into dues table
                $sql = "INSERT INTO dues (member_id, amount) VALUES ('$member_id', '$dues_amount')";
                $conn->query($sql);
            }
            fclose($handle);
            echo "Bulk upload successful.";
        } else {
            echo "Error opening file.";
        }
    } else {
        echo "Invalid file type. Only CSV or Excel files are allowed.";
    }
}

// Close connection
$conn->close();
?>
