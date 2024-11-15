<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports</title>
</head>
<body>
    <h2>Donations and Dues Report</h2>
    <?php
    // Example data, replace with database fetch logic
    $reports = [
        ['member_id' => 1, 'donation' => 100, 'dues' => 50],
        ['member_id' => 2, 'donation' => 200, 'dues' => 60],
    ];

    echo "<table border='1'>
            <tr>
                <th>Member ID</th>
                <th>Donation</th>
                <th>Dues</th>
            </tr>";
    foreach ($reports as $report) {
        echo "<tr>
                <td>{$report['member_id']}</td>
                <td>{$report['donation']}</td>
                <td>{$report['dues']}</td>
              </tr>";
    }
    echo "</table>";
    ?>
</body>
</html>
