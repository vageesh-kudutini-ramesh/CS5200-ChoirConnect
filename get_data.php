<?php
require 'db_connection.php';

// Suppress all unintended output
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

    // Fetch records
    $sql = "SELECT * FROM $table WHERE 1";
    if (!empty($search)) {
        $sql .= ($type === 'attendance') ? " AND (member_id LIKE :search OR date LIKE :search)" : " AND member_id LIKE :search";
    }
    $sql .= " LIMIT :limit OFFSET :offset";

    $stmt = $conn->prepare($sql);
    if (!empty($search)) {
        $searchTerm = "%$search%";
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
    }
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch total records for pagination
    $sql_total = "SELECT COUNT(*) AS total FROM $table WHERE 1";
    if (!empty($search)) {
        $sql_total .= ($type === 'attendance') ? " AND (member_id LIKE :search OR date LIKE :search)" : " AND member_id LIKE :search";
    }
    $stmt_total = $conn->prepare($sql_total);
    if (!empty($search)) {
        $stmt_total->bindParam(':search', $searchTerm, PDO::PARAM_STR);
    }
    $stmt_total->execute();
    $total_records = (int)$stmt_total->fetch(PDO::FETCH_ASSOC)['total'];
    $total_pages = max(1, ceil($total_records / $limit));

    // Discard unwanted output
    ob_end_clean();

    // Respond with JSON
    echo json_encode([
        'data' => $data,
        'total_pages' => $total_pages,
    ]);

} catch (PDOException $e) {
    ob_end_clean(); // Discard output if there's an error
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

exit;

