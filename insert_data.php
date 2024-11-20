<?php
// Include database connection file
require 'db_connection.php';

// Handle adding attendance
if (isset($_POST['add_attendance'])) {
    // Retrieve data from the POST request
    $member_id = $_POST['member_id'];
    $attendance_date = $_POST['attendance_date'];

    // SQL query to insert attendance record into the database
    $sql = "INSERT INTO attendance (member_id, attendance_date) VALUES ('$member_id', '$attendance_date')";

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        echo "Attendance record added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle editing attendance
if (isset($_POST['edit_attendance'])) {
    // Retrieve data from the POST request
    $attendance_id = $_POST['attendance_id'];
    $new_date = $_POST['new_date'];

    // SQL query to update the attendance record in the database
    $sql = "UPDATE attendance SET attendance_date='$new_date' WHERE id='$attendance_id'";

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        echo "Attendance record updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle deleting attendance
if (isset($_POST['delete_attendance'])) {
    // Retrieve the ID of the attendance record to delete
    $attendance_id = $_POST['attendance_id'];

    // SQL query to delete the attendance record from the database
    $sql = "DELETE FROM attendance WHERE id='$attendance_id'";

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        echo "Attendance record deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle exporting attendance data
if (isset($_POST['export_attendance'])) {
    // SQL query to retrieve all attendance data
    $sql = "SELECT * FROM attendance";

    // Execute the query and store the result
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output attendance data in CSV format
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="attendance.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, array('ID', 'Member ID', 'Attendance Date')); // Column headers

        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row); // Write each row to the CSV
        }
        fclose($output);
        exit;
    } else {
        echo "No attendance records found to export.";
    }
}

// Close the database connection
$conn->close();
?>

