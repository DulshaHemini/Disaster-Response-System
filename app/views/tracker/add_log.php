<?php
// Add activity log
define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH);

require_once APP_PATH . '/controllers/TrackerController.php';
require_once dirname(BASE_PATH) . '/config/config.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo '<script>alert("Invalid request"); window.history.back();</script>';
    exit;
}

// Initialize controller
$controller = new TrackerController();

// Get form data
$person_id = '';
$log_type = '';
$message = '';
$created_by = 'System';

if (isset($_POST['person_id'])) {
    $person_id = $_POST['person_id'];
}

if (isset($_POST['log_type'])) {
    $log_type = $_POST['log_type'];
}

if (isset($_POST['message'])) {
    $message = $_POST['message'];
}

if (isset($_POST['created_by']) && !empty($_POST['created_by'])) {
    $created_by = $_POST['created_by'];
}

// Check required fields
if (empty($person_id) || empty($log_type) || empty($message)) {
    echo '<script>alert("Missing required fields"); window.history.back();</script>';
    exit;
}

// Add log to database using simple function call
$result = $controller->addActivityLog($person_id, $log_type, $message, $created_by);

if (!$result) {
    echo '<script>alert("Error adding log"); window.history.back();</script>';
    exit;
}

// Success
echo '<script>alert("Update added successfully!"); window.location.href = "tracker.php";</script>';
exit;
?>
