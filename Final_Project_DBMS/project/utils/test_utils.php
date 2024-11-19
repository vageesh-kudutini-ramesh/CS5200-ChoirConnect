<?php
function assertEqual($expected, $actual, $message) {
    if ($expected === $actual) {
        echo "[PASS] $message" . PHP_EOL;
    } else {
        echo "[FAIL] $message" . PHP_EOL;
    }
}
?>
