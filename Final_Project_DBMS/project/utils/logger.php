<?php
function logMessage($message, $level = 'INFO') {
    $logFile = __DIR__ . '/../logs/app.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp][$level]: $message" . PHP_EOL, FILE_APPEND);
}
?>
