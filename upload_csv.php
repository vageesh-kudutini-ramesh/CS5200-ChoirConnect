<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $uploadDir = "uploads/";
    $fileName = basename($_FILES['csv_file']['name']);
    $filePath = $uploadDir . $fileName;

    // Create upload directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move uploaded file
    if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $filePath)) {
        try {
            // Log file details in the database
            $stmt = $conn->prepare("INSERT INTO UploadedFiles (file_name, file_path, uploaded_at) VALUES (?, ?, NOW())");
            $stmt->execute([$fileName, $filePath]);

            echo "File uploaded and logged successfully!";
        } catch (PDOException $e) {
            echo "Error logging file: " . $e->getMessage();
        }
    } else {
        echo "Failed to upload file.";
    }
} else {
    echo "No file uploaded.";
}
?>
