<?php
require 'utils/upload.php';

// Manually populate the $_FILES array to simulate a file upload
$_FILES['file'] = [
    'name' => 'test.csv',  // Name of the file being uploaded
    'type' => 'text/csv',   // MIME type of the file
    'tmp_name' => 'C:/xampp/htdocs/Final_Project_DBMS/project/tests/test.csv', // Path to the test file
    'error' => UPLOAD_ERR_OK,  // No error during file upload
    'size' => filesize('C:/xampp/htdocs/Final_Project_DBMS/project/tests/test.csv'),  // Size of the file
];

// Call the upload function
uploadFile();
?>
