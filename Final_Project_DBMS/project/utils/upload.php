<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

echo "Script is running<br>";  // Debug message to confirm script execution

function uploadFile()
{
    $uploadDirectory = 'C:/xampp/htdocs/Final_Project_DBMS/uploads/';

    // Check if the upload directory exists
    if (!is_dir($uploadDirectory)) {
        echo "Upload directory does not exist. Creating it...\n";
        mkdir($uploadDirectory, 0777, true);
    }

    // Ensure the file is uploaded and no errors occurred
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];

        // Debugging: Check if the temporary file exists
        if (!file_exists($fileTmpPath)) {
            echo "Temporary file does not exist: " . $fileTmpPath . "\n";
            return false;
        }

        $destination = $uploadDirectory . $fileName;

        // Debugging: Destination path
        echo "Destination: " . $destination . "<br>";

        if (move_uploaded_file($fileTmpPath, $destination)) {
            echo "File uploaded successfully to $destination\n";
            return true;
        } else {
            echo "Failed to move file to $destination\n";
            print_r(error_get_last());
            return false;
        }
    } else {
        echo "No file uploaded or an error occurred during upload: " . $_FILES['file']['error'] . "\n";
        return false;
    }
}

// Call the function to process the upload
uploadFile();
?>
