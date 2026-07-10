<?php

require_once __DIR__ . '/../vendor/autoload.php';

use SupremoCRM\Agenda\Core\Router;

require_once __DIR__ . '/../routes/web.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

Router::dispatch($uri, $method);
