<?php
require 'db_connection.php';

// Start output buffering
ob_start();

header('Content-Type: application/json'); // Ensure the response is JSON

try {
    if (!$conn) {
        http_response_code(500);
        echo json_encode(['error' => 'Database connection failed.']);
        exit;
    }

    $type = $_GET['type'] ?? 'attendance';
    if (!in_array($type, ['attendance', 'dues'], true)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid type parameter.']);
        exit;
    }

    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $search = $_GET['search'] ?? '';
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $table = ($type === 'dues') ? 'Dues' : 'Attendance';

    // Fetch records with filtering logic
    $sql = "SELECT * FROM $table WHERE 1";
    if (!empty($search)) {
        $sql .= " AND member_id = :search";
    }
    $sql .= " LIMIT :limit OFFSET :offset";

    $stmt = $conn->prepare($sql);
    if (!empty($search)) {
        $stmt->bindParam(':search', $search, PDO::PARAM_INT);
    }
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch total records for pagination
    $sql_total = "SELECT COUNT(*) AS total FROM $table WHERE 1";
    if (!empty($search)) {
        $sql_total .= " AND member_id = :search";
    }
    $stmt_total = $conn->prepare($sql_total);
    if (!empty($search)) {
        $stmt_total->bindParam(':search', $search, PDO::PARAM_INT);
    }
    $stmt_total->execute();
    $total_records = (int)$stmt_total->fetch(PDO::FETCH_ASSOC)['total'];
    $total_pages = max(1, ceil($total_records / $limit));

    // Clean buffer and return JSON
    ob_end_clean();
    echo json_encode([
        'data' => $data,
        'total_pages' => $total_pages,
    ]);

} catch (PDOException $e) {
    // Clean buffer and handle errors
    ob_end_clean();
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit;
}
