<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: UserLogin.php");
    exit;
}

echo "<h2>Welcome, " . $_SESSION['role'] . " " . $_SESSION['username'] . "</h2>";
?>

<!-- Navigation Links -->
<nav>
    <a href="data_entry.php">Data Entry</a> | 
    <a href="report.php">Reports</a> | 
    <a href="logout.php">Logout</a>
</nav>

<hr>

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
