<?php
function encryptData($data, $key) {
    $iv = random_bytes(openssl_cipher_iv_length('AES-256-CBC'));
    $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptData($encryptedData, $key) {
    $data = base64_decode($encryptedData);
    $iv = substr($data, 0, openssl_cipher_iv_length('AES-256-CBC'));
    $encrypted = substr($data, openssl_cipher_iv_length('AES-256-CBC'));
    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
}
?>
