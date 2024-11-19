<?php
require 'utils/upload.php';

$_FILES['file'] = [
    'name' => 'test.csv',
    'type' => 'text/csv',
    'tmp_name' => 'C:/xampp/htdocs/Final_Project_DBMS/project/tests/test.csv',
    'error' => UPLOAD_ERR_OK,
    'size' => filesize('C:/xampp/htdocs/Final_Project_DBMS/project/tests/test.csv'),
];

uploadFile();
?>
