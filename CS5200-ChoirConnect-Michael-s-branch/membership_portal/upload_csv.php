<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $uploadDir = "uploads/";
    $fileName = basename($_FILES['csv_file']['name']);
    $filePath = $uploadDir . $fileName;

    // Create the upload directory if it does not exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move the uploaded file to the "uploads" folder
    if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $filePath)) {
        try {
            // Log the file details in the database using PDO
            $stmt = $conn->prepare("INSERT INTO UploadedFiles (file_name, file_path, uploaded_at) VALUES (:file_name, :file_path, NOW())");
            $stmt->execute([
                ':file_name' => $fileName,
                ':file_path' => $filePath
            ]);

            // Display success message with a redirect
            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Upload Status</title>
                <link rel='stylesheet' href='styles.css'> <!-- Assuming you have a shared stylesheet -->
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                        background-color: #f4f4f4;
                    }
                    .container {
                        text-align: center;
                        background-color: #ffffff;
                        padding: 30px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    .message {
                        font-size: 18px;
                        color: #333333;
                        margin-bottom: 20px;
                    }
                    .redirect-message {
                        font-size: 16px;
                        color: #007bff;
                    }
                    .redirect-message a {
                        color: #007bff;
                        text-decoration: none;
                    }
                    .redirect-message a:hover {
                        text-decoration: underline;
                    }
                </style>
                <script>
                    setTimeout(() => { window.location.href = 'data_entry.php'; }, 5000);
                </script>
            </head>
            <body>
                <div class='container'>
                    <p class='message'>File uploaded and logged successfully!</p>
                    <p class='redirect-message'>You will be redirected back to the Data Entry page in 5 seconds.</p>
                    <p class='redirect-message'><a href='data_entry.php'>Click here</a> if you are not redirected automatically.</p>
                </div>
            </body>
            </html>";
        } catch (Exception $e) {
            echo "Error logging file: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Failed to upload file.";
    }
} else {
    echo "No file uploaded.";
}

