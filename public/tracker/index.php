<?php
// Define paths for tracker
define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');

$controller = 'tracker';
$controllerFile = APP_PATH . "/controllers/" . $controller . "Controller.php";
$controllerClass = $controller . "Controller";
$action = 'index';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $ctrl = new $controllerClass();
    $ctrl->$action();
} else {
    echo "404 - Page not found";
}
