<?php
require_once '../utils/upload.php'; // Include the upload function from utils folder
require_once '../utils/logger.php'; // Optional: for logging (if you have this)

if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Define the file upload destination directory
    $targetDir = __DIR__ . '/../uploads/';
    // Make sure the target directory exists, or create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Call the function from utils/upload.php to handle the file upload
    $_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name']; // Add file from $_FILES superglobal
    $_FILES['file']['name'] = $_FILES['file']['name'];

    // Pass $_FILES['file'] to the uploadFile function
    if (uploadFile($_FILES['file'])) { // Now passing the file data
        logMessage("File uploaded successfully: " . $_FILES['file']['name']);
        echo json_encode(['status' => 'success']);
    } else {
        logMessage("File upload failed: " . $_FILES['file']['name'], 'ERROR');
        echo json_encode(['status' => 'error']);
    }
} else {
    logMessage("File upload error: " . $_FILES['file']['error'], 'ERROR');
    echo json_encode(['status' => 'error']);
}
?>
