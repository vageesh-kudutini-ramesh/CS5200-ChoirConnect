<?php

use PHPUnit\Framework\TestCase;

class FileUploadTest extends TestCase
{
    public function testFileUploadSuccess()
{
    $_FILES['file'] = [
        'name' => 'test.csv',
        'type' => 'text/csv',
        'tmp_name' => 'C:/xampp/htdocs/Final_Project_DBMS/project/tests/test.csv', // Replace with correct path
        'error' => UPLOAD_ERR_OK,
        'size' => filesize('C:/xampp/htdocs/Final_Project_DBMS/project/tests/test.csv'),
    ];

    $this->assertTrue(uploadFile());
    $this->assertFileExists('C:/xampp/htdocs/Final_Project_DBMS/project/uploads/test.csv');
}

    public function testFileUploadFailure()
    {
        $testFile = __DIR__ . '/tests/test.txt';

        // Print for debugging
        echo "Testing invalid file upload for: $testFile\n";

        // Mock the $_FILES superglobal with an invalid file type
        $_FILES['file'] = [
            'name' => 'test.txt',
            'type' => 'text/plain',
            'tmp_name' => $testFile,
            'error' => UPLOAD_ERR_OK,
            'size' => filesize($testFile),
        ];

        // Run the upload function and assert that it returns false due to invalid extension
        $this->assertFalse(uploadFile()); 
    }
}
?>
