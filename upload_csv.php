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
            // Log the file details in the database
            $stmt = $conn->prepare("INSERT INTO UploadedFiles (file_name, file_path, uploaded_at) VALUES (?, ?, NOW())");
            $stmt->bind_param("ss", $fileName, $filePath);
            $stmt->execute();

            echo "File uploaded and logged successfully!";
        } catch (Exception $e) {
            echo "Error logging file: " . $e->getMessage();
        }
    } else {
        echo "Failed to upload file.";
    }
} else {
    echo "No file uploaded.";
}
?>
