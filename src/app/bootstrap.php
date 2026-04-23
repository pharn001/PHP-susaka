<?php

require_once __DIR__ . '/../db.php';

spl_autoload_register(static function (string $class): void {
    $directories = [
        __DIR__ . '/core/',
        __DIR__ . '/Controllers/',
        __DIR__ . '/Models/',
        __DIR__ . '/Services/',
        __DIR__ . '/../helper/',
    ];

    foreach ($directories as $directory) {
        $path = $directory . $class . '.php';
        if (is_file($path)) {
            require_once $path;
            return;
        }
    }
});

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
