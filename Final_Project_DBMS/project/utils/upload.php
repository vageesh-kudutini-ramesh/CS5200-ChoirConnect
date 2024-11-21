<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

echo "Script is running<br>";  // Debug message to confirm script execution

function uploadFile()
{
    // Update the upload directory to the new location inside the project folder
      $uploadDirectory = '../../uploads/';
 
    // Check if the upload directory exists
    if (!is_dir($uploadDirectory)) {
        echo "Upload directory does not exist. Creating it...\n";
        mkdir($uploadDirectory, 0755, true);
    }

    if (!is_writable($uploadDirectory)) {
        echo "Upload directory is not writable. Please check permissions.\n";
        return false;
    }

    // Debugging: Print the $_FILES array to check if it's set correctly
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";

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
            print_r(error_get_last()); // Debugging: Output any errors that occurred
            return false;
        }
    } else {
        // Output the error message for debugging if the file is not uploaded or there's an error
        if (isset($_FILES['file'])) {
            echo "File upload error: " . $_FILES['file']['error'] . "\n";
        } else {
            echo "No file uploaded or an error occurred during upload.\n";
        }
        return false;
    }
}

// Call the function to process the upload
uploadFile();
?>
