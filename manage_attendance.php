<?php
require 'db_connection.php';

// Display success messages
if (isset($_GET['success'])) {
    $messages = [
        1 => "Record added successfully!",
        2 => "Record deleted successfully!",
        3 => "Record updated successfully!"
    ];
    echo "<p>" . $messages[$_GET['success']] . "</p>";
}

// Query to fetch attendance records
$sql = "SELECT * FROM Attendance";
$result = $conn->query($sql);

echo "<h2>Manage Attendance Records</h2>";
echo '<form method="get" action="manage_attendance.php">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" placeholder="Enter Member ID or Date">
        <button type="submit">Search</button>
      </form>';

echo "<table border='1'>";
echo "<tr><th>Member ID</th><th>Date</th><th>Status</th><th>Reason</th><th>Actions</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["member_id"] . "</td>
                <td>" . $row["date"] . "</td>
                <td>" . ($row["status"] ? "Present" : "Absent") . "</td>
                <td>" . $row["absence_reason"] . "</td>
                <td>
                    <a href='edit_attendance.php?id=" . $row["attendance_id"] . "'>Edit</a> |
                    <a href='delete_attendance.php?id=" . $row["attendance_id"] . "'>Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No records found.</td></tr>";
}

echo "</table>";
$conn->close();
?>
