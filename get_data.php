<?php
require 'db_connection.php';

header('Content-Type: application/json'); // Set content type to JSON for API response

try {
    // Default parameters
    $type = $_GET['type'] ?? 'attendance';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $search = $_GET['search'] ?? '';

    if ($page <= 0) $page = 1;

    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Determine the table based on the 'type' parameter
    $table = ($type === 'dues') ? 'Dues' : 'Attendance';

    // Construct the main query
    $sql = "SELECT * FROM $table WHERE 1";
    if (!empty($search)) {
        if ($table === 'Attendance') {
            $sql .= " AND (member_id LIKE :search OR date LIKE :search)";
        } elseif ($table === 'Dues') {
            $sql .= " AND member_id LIKE :search";
        }
    }
    $sql .= " LIMIT :limit OFFSET :offset";

    $stmt = $conn->prepare($sql);

    // Bind parameters for search and pagination
    if (!empty($search)) {
        $searchTerm = "%$search%";
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
    }
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Construct the count query for pagination
    $sql_total = "SELECT COUNT(*) AS total FROM $table WHERE 1";
    if (!empty($search)) {
        if ($table === 'Attendance') {
            $sql_total .= " AND (member_id LIKE :search OR date LIKE :search)";
        } elseif ($table === 'Dues') {
            $sql_total .= " AND member_id LIKE :search";
        }
    }

    $stmt_total = $conn->prepare($sql_total);
    if (!empty($search)) {
        $stmt_total->bindParam(':search', $searchTerm, PDO::PARAM_STR);
    }

    $stmt_total->execute();
    $total_records = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];
    $total_pages = ceil($total_records / $limit);

    // Respond with JSON
    echo json_encode([
        'data' => $data,
        'total_pages' => $total_pages,
    ]);
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['role'] . " " . $_SESSION['username']); ?></h2>
    </header>

    <nav>
        <a href="data_entry.php">Data Entry</a>
        <a href="report.php">Reports</a>
        <a href="?type=attendance">Attendance</a>
        <a href="?type=dues">Dues</a>
        <a href="logout.php">Logout</a>
    </nav>

    <form method="GET" action="">
        <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">
        <label for="search">Search:</label>
        <input type="text" name="search" id="search" placeholder="Enter Member ID or Date" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <?php if (isset($data['error'])): ?>
        <p>Error: <?php echo htmlspecialchars($data['error']); ?></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Member ID</th>
                    <?php if ($type === 'attendance'): ?>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Reason</th>
                    <?php elseif ($type === 'dues'): ?>
                        <th>Amount</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['data'] as $record): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['member_id']); ?></td>
                        <?php if ($type === 'attendance'): ?>
                            <td><?php echo htmlspecialchars($record['date']); ?></td>
                            <td><?php echo $record['status'] ? "Present" : "Absent"; ?></td>
                            <td><?php echo htmlspecialchars($record['absence_reason']); ?></td>
                        <?php elseif ($type === 'dues'): ?>
                            <td><?php echo htmlspecialchars($record['amount']); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php for ($i = 1; $i <= $data['total_pages']; $i++): ?>
                <a href="?type=<?php echo htmlspecialchars($type); ?>&page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"
                   class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</body>
</html>
