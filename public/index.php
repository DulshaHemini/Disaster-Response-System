<?php
/**
 * DRCS – Front Controller
 * All requests route through here.
 */

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH',  BASE_PATH . '/app');

// Simple router: load the HomeController by default
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action     = isset($_GET['action'])     ? $_GET['action']     : 'index';

// Sanitise inputs
$controller = preg_replace('/[^a-zA-Z0-9_]/', '', $controller);
$action     = preg_replace('/[^a-zA-Z0-9_]/', '', $action);

$controllerFile  = APP_PATH . '/controllers/' . ucfirst($controller) . 'Controller.php';
$controllerClass = ucfirst($controller) . 'Controller';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $ctrl = new $controllerClass();
    if (method_exists($ctrl, $action)) {
        $ctrl->$action();
    } else {
        http_response_code(404);
        echo '404 – Action not found.';
    }
} else {
    http_response_code(404);
    echo '404 – Controller not found.';
}
