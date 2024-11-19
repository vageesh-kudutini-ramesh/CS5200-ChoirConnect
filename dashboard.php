<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: UserLogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Link the CSS file -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Header Section with Logo and Welcome Message -->
    <header class="site-header">
        <img src="css/community_logo.png" alt="Community Logo" class="logo">
        <div class="site-title">
            <h1>Choir Membership Portal</h1>
            <h2>Welcome, <?php echo $_SESSION['role'] . " " . $_SESSION['username']; ?></h2>
        </div>
    </header>

    <!-- Navigation Links -->
    <nav class="navbar">
        <a href="data_entry.php">Data Entry</a>
        <a href="report.php">Reports</a>
        <a href="logout.php">Logout</a>
    </nav>

    <hr>

    <!-- Role-Based Content -->
    <div class="dashboard-container">
        <?php
        // Role-based content
        if ($_SESSION['role'] === 'Admin') {
            echo "<p>Admin-specific content: Manage users, access all data, etc.</p>";
        } elseif ($_SESSION['role'] === 'Treasurer') {
            echo "<p>Treasurer-specific content: View and manage dues and donations.</p>";
        } elseif ($_SESSION['role'] === 'Secretary') {
            echo "<p>Secretary-specific content: Manage attendance records.</p>";
        }
        ?>
    </div>

</body>
</html>
