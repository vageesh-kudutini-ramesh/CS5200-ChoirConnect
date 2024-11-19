<?php
require_once '../utils/encrypt.php';
require_once '../utils/test_utils.php';

$key = 'testkey';
$data = 'sensitive_data';

$encrypted = encryptData($data, $key);
$decrypted = decryptData($encrypted, $key);

assertEqual($data, $decrypted, "Encryption/Decryption Test");
?>
