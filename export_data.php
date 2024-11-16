<?php
require 'db_connection.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM Attendance WHERE 1";
if (!empty($search)) {
    $sql .= " AND (member_id LIKE '%$search%' OR date LIKE '%$search%')";
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="attendance_data.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Member ID', 'Date', 'Status', 'Reason']);

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['member_id'],
            $row['date'],
            $row['status'] ? 'Present' : 'Absent',
            $row['absence_reason']
        ]);
    }
}

fclose($output);
$conn->close();
?>
