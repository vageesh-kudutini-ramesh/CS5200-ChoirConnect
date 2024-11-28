<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: UserLogin.php");
    exit;
}

// Backend integration variables
$type = $_GET['type'] ?? 'attendance';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = $_GET['search'] ?? '';

// Construct API URL
$url = "http://localhost/CS5200FinalProject/membership_portal/get_data.php?type=$type&page=$page&search=" . urlencode($search);

function fetchApiData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$response) {
        return ['error' => 'Unable to fetch data from the API. HTTP Code: ' . $httpCode];
    }

    return json_decode($response, true);
}

$response = file_get_contents($url);

if ($response === false) {
    echo "<p style='color: red;'>Error: Unable to fetch data from the API. Please check if `get_data.php` is accessible.</p>";
    $data = ['error' => 'Failed to fetch data.'];
} else {
    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "<p style='color: red;'>Error: Invalid JSON response from API: " . json_last_error_msg() . "</p>";
        $data = ['error' => 'Invalid JSON response.'];
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
        <p style="color: red;">Error: <?php echo htmlspecialchars($data['error']); ?></p>
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

