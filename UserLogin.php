<?php
session_start();
$users = [
    'admin' => ['password' => 'admin123', 'role' => 'Admin'],
    'treasurer' => ['password' => 'treasurer123', 'role' => 'Treasurer'],
    'secretary' => ['password' => 'secretary123', 'role' => 'Secretary'],
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (isset($users[$username]) && $users[$username]['password'] == $password) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $users[$username]['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Linking the CSS -->
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <!-- Display logout success message if redirected from logout.php -->
        <?php
        if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
            echo "<p class='logout-message'>You have been logged out successfully.</p>";
        }
        ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <!-- Display error message if login fails -->
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    </div>
</body>
</html>
