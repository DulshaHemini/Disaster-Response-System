<?php
/**
 * Disaster Response System - Main Entry Point
 * Routes all requests through the custom router
 */

// Define paths
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');

// Load configuration
require_once CONFIG_PATH . '/config.php';

// Load and use router
require_once CONFIG_PATH . '/routes.php';

// Dispatch the current request
$router->dispatch();
