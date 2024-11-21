<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: UserLogin.php");
    exit;
}

// Default values for backend integration
$type = isset($_GET['type']) ? $_GET['type'] : 'attendance'; // Default to 'attendance'
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Default to the first page

// Call get_data.php API for dynamic content
$url = "get_data.php?type=$type&page=$page";
$response = @file_get_contents($url);
$data = $response ? json_decode($response, true) : ['error' => 'Failed to fetch data'];
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
    <!-- Header Section -->
    <header>
        <h1>Dashboard</h1>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['role'] . " " . $_SESSION['username']); ?></h2>
    </header>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="data_entry.php">Data Entry</a>
        <a href="report.php">Reports</a>
        <a href="?type=attendance">Attendance</a>
        <a href="?type=dues">Dues</a>
        <a href="logout.php">Logout</a>
    </nav>

    <hr>

    <!-- Dynamic Content Section -->
    <?php if (isset($data['error'])): ?>
        <!-- Show error message if API call fails -->
        <p class="error">Error: <?php echo htmlspecialchars($data['error']); ?></p>
    <?php else: ?>
        <!-- Display data table -->
        <table>
            <thead>
                <tr>
                    <th>Member ID</th>
                    <?php if ($type === 'attendance'): ?>
                        <th>Attendance Date</th>
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
                            <td><?php echo htmlspecialchars($record['attendance_date']); ?></td>
                        <?php elseif ($type === 'dues'): ?>
                            <td><?php echo htmlspecialchars($record['amount']); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $data['total_pages']; $i++): ?>
                <a href="?type=<?php echo htmlspecialchars($type); ?>&page=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</body>
</html>
