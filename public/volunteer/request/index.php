<?php
// Define paths based on your sidebar structure in image_3869b2.jpg
define('BASE_PATH', dirname(__DIR__, 3)); // Goes up from request -> volunteer -> public to Root
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config'); // Config is at the root level


require_once CONFIG_PATH . '/config.php';

// 2. Include the Model and Controller
require_once APP_PATH . '/models/AssignmentModel.php';
require_once APP_PATH . '/controllers/assignmentController.php';

$controller = new assignmentController(); 
$controller->index($conn); // $db should be defined inside your config.php