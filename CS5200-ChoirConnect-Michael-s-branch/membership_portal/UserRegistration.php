<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "Enigma@007";
$dbname = "choir_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $notes = $_POST['notes'];

    // Set the join_date to the current date
    $join_date = date('Y-m-d');

    $member_sql = "INSERT INTO Member (first_name, last_name, email, password, phone_number, address, join_date, notes)
                   VALUES ('$first_name', '$last_name', '$email', '$password', '$phone_number', '$address', '$join_date', '$notes')";

    if ($conn->query($member_sql) === TRUE) {
        $member_id = $conn->insert_id;

        $user_sql = "INSERT INTO User (username, password, role_id, member_id)
                     VALUES ('$email', '$password', 4, $member_id)";

        if ($conn->query($user_sql) === TRUE) {
            $_SESSION['registration_success'] = "Registration successful! Please login.";
            header("Location: UserLogin.php");
            exit;
        } else {
            $error = "Error: " . $conn->error;
        }
    } else {
        $error = "Error: " . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Registration - Sea Change Corral Choir Management System</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #495057;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .background-text {
            font-size: 36px;
            font-weight: bold;
            color: rgba(255, 255, 255, 0.85);
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            margin-bottom: 20px;
        }
        .registration-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"], textarea {
            width: calc(100% - 24px);
            padding: 12px;
            margin-bottom: 10px;
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
        .error-message, .success-message {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .error-message {
            color: #dc3545;
        }
        .success-message {
            color: #28a745;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Title Section -->
    <div class="background-text">Sea Change Corral Choir Management System</div>

    <!-- Registration Form Section -->
    <div class="registration-container">
        <h2>Member Registration</h2>

        <?php 
        if (!empty($success)) echo "<p class='success-message'>$success</p>"; 
        if (!empty($error)) echo "<p class='error-message'>$error</p>"; 
        ?>

        <form method="POST" action="">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="phone_number" placeholder="Phone Number">
            <textarea name="address" placeholder="Address"></textarea>
            <textarea name="notes" placeholder="Notes"></textarea>
            <button type="submit">Register</button>
        </form>


        <!-- Back to Login Link -->
        <p><a href="UserLogin.php">Back to Login</a></p>
    </div>
</body>
</html>

