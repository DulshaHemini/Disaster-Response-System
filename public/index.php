<?php
/**
 * Disaster Response System - Main Entry Point
 */

// 1. Define paths
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');

// 2. Load Core Files
require_once CONFIG_PATH . '/config.php';

// Simple routing based on URL parameters
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Route to appropriate controller
switch ($page) {
    case 'home':
        require_once APP_PATH . '/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
    
    case 'tracker':
        require_once APP_PATH . '/controllers/TrackerController.php';
        $controller = new TrackerController();
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            $controller->index();
        }
        break;
    
    case 'user':
        require_once APP_PATH . '/controllers/UserController.php';
        $controller = new UserController();
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            $controller->index();
        }
        break;
    
    default:
        require_once APP_PATH . '/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
}

