<?php
require 'db_connection.php';

// Start output buffering
ob_start();

header('Content-Type: application/json'); // Ensure the response is JSON

try {
    // Check if the connection is established
    if (!$conn) {
        http_response_code(500);
        echo json_encode(['error' => 'Database connection failed.']);
        exit;
    }

    // Get and validate type parameter
    $type = $_GET['type'] ?? 'attendance';
    if (!in_array($type, ['attendance', 'dues'], true)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid type parameter.']);
        exit;
    }

    // Get page and search parameters
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $search = $_GET['search'] ?? '';
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Determine the table based on the type parameter
    $table = ($type === 'dues') ? 'Dues' : 'Attendance';

    // Build the SQL query with filtering logic
    $sql = "SELECT * FROM $table WHERE 1";
    if (!empty($search)) {
        $sql .= " AND member_id = ?";
    }
    $sql .= " LIMIT ? OFFSET ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    if (!empty($search)) {
        // Bind the search parameter (member_id)
        $stmt->bind_param("iii", $search, $limit, $offset); // "iii" represents integer parameters
    } else {
        // If no search, just bind limit and offset
        $stmt->bind_param("ii", $limit, $offset);
    }

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all records
    $data = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch total records for pagination
    $sql_total = "SELECT COUNT(*) AS total FROM $table WHERE 1";
    if (!empty($search)) {
        $sql_total .= " AND member_id = ?";
    }
    $stmt_total = $conn->prepare($sql_total);
    if (!empty($search)) {
        // Bind the search parameter for total count query
        $stmt_total->bind_param("i", $search);
    }
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $total_records = (int)$result_total->fetch_assoc()['total'];
    $total_pages = max(1, ceil($total_records / $limit));

    // Clean buffer and return JSON response
    ob_end_clean();
    echo json_encode([
        'data' => $data,
        'total_pages' => $total_pages,
    ]);
} catch (Exception $e) {
    // Clean buffer and handle errors
    ob_end_clean();
    http_response_code(500);
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    exit;
}
?>
