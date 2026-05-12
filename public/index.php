<?php
// Simple Front Controller for Disaster Response System

// Define paths
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Get the controller and action from URL, default to 'home'
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Build the file path
$controllerFile = "../app/controllers/" . ucfirst($controller) . "Controller.php";
$controllerClass = ucfirst($controller) . "Controller";

// Load and run the controller
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $ctrl = new $controllerClass();
    $ctrl->$action();
} else {
    echo "404 - Page not found";
}
