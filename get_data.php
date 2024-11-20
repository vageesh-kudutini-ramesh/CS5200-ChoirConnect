<?php
require 'db_connection.php';

// Handle parameters
$type = $_GET['type'] ?? 'attendance'; // Default to attendance
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = $page > 0 ? $page : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$search = $_GET['search'] ?? '';

// Determine the query based on the type
if ($type === 'attendance') {
    $sql = "SELECT * FROM attendance WHERE 1";
    if (!empty($search)) {
        $sql .= " AND (member_id LIKE '%$search%' OR attendance_date LIKE '%$search%')";
    }
} elseif ($type === 'dues') {
    $sql = "SELECT * FROM dues WHERE 1";
    if (!empty($search)) {
        $sql .= " AND (member_id LIKE '%$search%' OR amount LIKE '%$search%')";
    }
} else {
    echo json_encode(['error' => 'Invalid type']);
    exit;
}

// Add pagination to query
$sql .= " LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Count total records
$total_sql = str_replace("SELECT *", "SELECT COUNT(*) AS total", $sql);
$total_result = $conn->query($total_sql);
$total_records = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);

// Fetch and return data
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode(['data' => $data, 'total_pages' => $total_pages]);

$conn->close();
?>
