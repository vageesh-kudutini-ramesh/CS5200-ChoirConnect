<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: UserLogin.php");
    exit;
}

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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }
        nav {
            margin: 20px 0;
            text-align: center;
        }
        nav a {
            margin: 0 10px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        form input[type="text"] {
            padding: 10px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: #fff;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }
        .pagination a.active {
            background-color: #0056b3;
        }
        .pagination a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['role'] . " " . $_SESSION['username']); ?></h2>
    </header>

    <nav>
        <a href="data_entry.php">Data Entry</a>
        <a href="?type=attendance">Attendance</a>
        <a href="?type=dues">Dues</a>
        <a href="report.php">Reports</a>
        <a href="logout.php">Logout</a>
    </nav>

    <?php if (in_array($type, ['attendance', 'dues'])): ?>
        <form method="GET" action="">
            <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">
            <label for="search">Search:</label>
            <input type="text" name="search" id="search" placeholder="Enter Member ID or Date" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>

        <?php if (isset($data['error'])): ?>
            <p style="color: red; text-align: center;">Error: <?php echo htmlspecialchars($data['error']); ?></p>
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
