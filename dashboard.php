<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: UserLogin.php");
    exit;
}

$role = $_SESSION['role'] ?? '';

// Backend integration variables
$type = $_GET['type'] ?? ''; // Default to empty string to avoid fetching data
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = $_GET['search'] ?? '';

// Only fetch data if type is 'attendance' or 'dues'
$data = ['error' => 'No data to display'];
if (in_array($type, ['attendance', 'dues'])) {
    $url = "http://localhost/CS5200FinalProject/membership_portal/get_data.php?type=$type&page=$page&search=" . urlencode($search);

    $response = file_get_contents($url);

    if ($response === false) {
        $data = ['error' => 'Failed to fetch data from the API.'];
    } else {
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $data = ['error' => 'Invalid JSON response.'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            text-align: center;
        }
        nav {
            background-color: #333;
            overflow: hidden;
        }
        nav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #ddd;
            color: black;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            color: black;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }
        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
        form {
            text-align: center;
            margin: 20px;
        }
        input[type=text] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button[type=submit] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button[type=submit]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['role'] . " " . $_SESSION['username']); ?></h2>
    </header>

    <nav>
        <?php if ($role !== 'Member'): ?>
            <a href="data_entry.php"><i class="fas fa-pencil-alt"></i> Data Entry</a>
        <?php endif; ?>
        <a href="?type=attendance"><i class="fas fa-calendar-check"></i> Attendance</a>
        <a href="?type=dues"><i class="fas fa-dollar-sign"></i> Dues</a>
        <a href="report.php"><i class="fas fa-file-alt"></i> Reports</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>

    <?php if (in_array($type, ['attendance', 'dues'])): ?>
        <form method="GET" action="">
            <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">
            <label for="search">Search:</label>
            <input type="text" name="search" id="search" placeholder="Enter Member ID or Date" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit"><i class="fas fa-search"></i> Search</button>
        </form>

        <?php if (isset($data['error'])): ?>
            <p class="error">Error: <?php echo htmlspecialchars($data['error']); ?></p>
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
                            <th>Payment Date</th>
                            <th>Payment Method</th>
                            <th>Payment Frequency</th>
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
                                <td><?php echo htmlspecialchars($record['payment_date']); ?></td>
                                <td><?php echo htmlspecialchars($record['payment_method']); ?></td>
                                <td><?php echo htmlspecialchars($record['payment_frequency']); ?></td>
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
    <?php else: ?>
        <p>Welcome to the Dashboard. Please select Attendance or Dues to view data.</p>
    <?php endif; ?>
</body>
</html>
