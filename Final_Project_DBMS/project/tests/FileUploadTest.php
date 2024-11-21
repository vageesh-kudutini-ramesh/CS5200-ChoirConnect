<?php

require_once __DIR__ . '/../utils/upload.php';  // Include the upload function

use PHPUnit\Framework\TestCase;

class FileUploadTest extends TestCase
{
    public function testFileUploadSuccess()
    {
        // Simulate a successful file upload
        $file = [
            'name' => 'test-file.txt',
            'type' => 'text/plain',
            'tmp_name' => '/path/to/temp/file',  // Change this to a valid temporary file location for testing
            'error' => UPLOAD_ERR_OK,
            'size' => 12345
        ];

        // Call the function and assert the result
        $result = uploadFile($file);
        $this->assertTrue($result);
    }

    public function testFileUploadFailure()
    {
        // Simulate a failed file upload (error in upload)
        $file = [
            'name' => 'invalid-file.txt',
            'type' => 'text/plain',
            'tmp_name' => '',  // Simulate missing temporary file
            'error' => UPLOAD_ERR_NO_FILE,  // Simulate no file uploaded
            'size' => 0
        ];

        // Call the function and assert the result
        $result = uploadFile($file);
        $this->assertFalse($result);
    }
}
?>
