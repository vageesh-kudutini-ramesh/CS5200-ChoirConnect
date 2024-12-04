<?php
session_start();
$users = [
    'admin' => ['password' => 'admin123', 'role' => 'Admin'],
    'treasurer' => ['password' => 'treasurer123', 'role' => 'Treasurer'],
    'secretary' => ['password' => 'secretary123', 'role' => 'Secretary'],
    'member' => ['password' => 'member123', 'role' => 'Member'],
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
    <title>Attendance and Dues Entry - Sea Change Corral Choir Management System</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #495057;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }
        .background-text {
            position: absolute;
            top: 15%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 56px;
            font-weight: bold;
            color: rgba(255, 255, 255, 0.85);
            text-align: center;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
        }
        header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .login-container {
            width: 350px;
            max-width: 100%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            box-sizing: border-box;
        }
        input[type="text"], input[type="password"] {
            width: calc(100% - 24px);
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .button {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0056b3;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: inline-block;
            width: 150px;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="number"], input[type="date"], select {
            padding: 10px;
            width: calc(100% - 170px);
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="background-text">Sea Change Corral Choir Management System</div>
    <div class="login-container">
        <h2>Login</h2>
        
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        
        <!-- Display error message if login fails -->
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>

        <!-- Add hyperlink for registration -->
        <p>Don't have an account? <a href="UserRegistration.php">Register here</a></p>
    </div>
</body>
</html>
