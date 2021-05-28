<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

use app\core\Router;
spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        include_once $path;
    }
});

$router = new Router();
$router->start();