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


// 3. Load MVC Components
require_once APP_PATH . '/models/AssignmentModel.php';
require_once APP_PATH . '/controllers/AssignmentController.php';

// 4. Handle Logic (Controller)
$controller = new AssignmentController();

// Check if we are performing an action (POST) or just viewing (GET)

    // This will load the view via AssignmentController->index()
    $controller->index($conn);
