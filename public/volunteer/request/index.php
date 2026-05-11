<?php
// Define paths
define('BASE_PATH', dirname(__DIR__, 3));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');

// Include database connection
require_once CONFIG_PATH . '/config.php';

// Include the view
require_once APP_PATH . '/views/request/request.php';
