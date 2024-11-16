<?php
require 'db_connection.php';

// Handle pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page <= 0) {
    $page = 1;
}

$limit = 10; // Number of records per page
$offset = ($page - 1) * $limit;

// Handle search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query to fetch paginated and filtered results
$sql = "SELECT * FROM Attendance WHERE 1";
if (!empty($search)) {
    $sql .= " AND (member_id LIKE '%$search%' OR date LIKE '%$search%')";
}
$sql .= " LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Query to count total records for pagination
$sql_total = "SELECT COUNT(*) AS total FROM Attendance WHERE 1";
if (!empty($search)) {
    $sql_total .= " AND (member_id LIKE '%$search%' OR date LIKE '%$search%')";
}
$result_total = $conn->query($sql_total);
$total_records = $result_total->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Records</title>
    <style>
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .pagination a:hover {
            background-color: #f0f0f0;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], button {
            padding: 5px 10px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h2>Attendance Records</h2>

    <!-- Search form -->
    <form method="get" action="get_data.php">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" placeholder="Enter Member ID or Date" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Export button -->
    <form method="get" action="export_data.php">
        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Export to CSV</button>
    </form>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Member ID: " . $row["member_id"] .
                " - Date: " . $row["date"] .
                " - Status: " . ($row["status"] ? "Present" : "Absent") .
                " - Reason: " . $row["absence_reason"] . "<br>";
        }
    } else {
        echo "No attendance records found.";
    }
    ?>

    <!-- Pagination links -->
    <div class="pagination">
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<a href='get_data.php?page=$i&search=$search' class='active'>$i</a>";
            } else {
                echo "<a href='get_data.php?page=$i&search=$search'>$i</a>";
            }
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
