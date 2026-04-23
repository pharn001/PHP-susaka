<?php

require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/core/Router.php';
require_once __DIR__ . '/routes/web.php';
require_once __DIR__ . '/routes/api.php';

$router->dispatch();
