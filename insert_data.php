<?php
// Database connection information
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "choir_management";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set example data
$member_id = 1; // Assume the previously inserted member ID is 1
$date = "2024-11-15";
$status = true;
$absence_reason = "N/A";

// Insert data into Attendance table
$sql = "INSERT INTO Attendance (member_id, date, status, absence_reason)
        VALUES ('$member_id', '$date', '$status', '$absence_reason')";

if ($conn->query($sql) === TRUE) {
    echo "Attendance record inserted successfully!";
} else {
    echo "Error inserting data: " . $conn->error;
}

// Close the connection
$conn->close();
?>
