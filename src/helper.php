<?php

function errorHandling(string $message): void {
    $logDir  = __DIR__ . '/logs';
    $logFile = $logDir . '/error-' . date('Y-m-d') . '.log';

    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $entry = sprintf(
        "[%s] [%s:%s] %s%s",
        date('Y-m-d H:i:s'), // เวลา
        __FILE__,             // ไฟล์
        __LINE__,             // บรรทัด
        $message,
        PHP_EOL
    );

    file_put_contents($logFile, $entry, FILE_APPEND);
}


function logs(string $message): void {
    $logDir  = __DIR__ . '/logs';
    $logFile = $logDir . '/log-' . date('Y-m-d') . '.log'; 

    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true); 
    }

    $entry = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
    file_put_contents($logFile, $entry, FILE_APPEND);
}