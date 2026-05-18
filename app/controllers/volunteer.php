<?php

// Start session for state management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Temporary session mapping for development and automated testing sandboxes.
// If no session exists, it defaults to the volunteer test account (User ID 13).
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    $_SESSION['user_id'] = 13;
    $_SESSION['user_role'] = 'volunteer';
    $_SESSION['username'] = 'test_volunteer';
}

// Security Check: Verify if the logged-in user is a volunteer
if (strtolower($_SESSION['user_role']) !== 'volunteer') {
    header("Location: ../../public/signin.php");
    exit();
}

$volunteer_id = $_SESSION['user_id'];

// Database connection using global config
require_once __DIR__ . "/../../config/config.php";

// Require the model functions
require_once __DIR__ . "/../models/volunteer_.php";

// Handle incoming POST actions for task state modifications
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['task_id'])) {
    $action = $_POST['action'];
    $taskId = (int)$_POST['task_id'];

    if ($action === 'accept') {
        acceptTask($conn, $taskId, $volunteer_id);
    } elseif ($action === 'reject') {
        rejectTask($conn, $taskId, $volunteer_id);
    } elseif ($action === 'mark_done') {
        markTaskDone($conn, $taskId, $volunteer_id);
    }
    
    // Redirect to self to prevent form resubmission on page refresh
    header("Location: volunteer.php");
    exit();
}

// Fetch data from database via model functions
$pendingTasks = getPendingTasks($conn, $volunteer_id);
$activeTasks = getActiveTasks($conn, $volunteer_id);
$profile = getVolunteerProfile($conn, $volunteer_id);

// Calculate metrics for statistics dashboard
$affectedCount = getAffectedPeopleCount($conn);
$pendingAssignCount = count($pendingTasks);
$activeTaskCount = count(array_filter($activeTasks, function($t) { 
    return $t['status'] === 'doing' || $t['status'] === 'received'; 
}));
$completedCount = count(array_filter($activeTasks, function($t) { 
    return $t['status'] === 'done'; 
}));

// Load the Volunteer Task View
require_once __DIR__ . "/../views/volunteer/_volunteer.php";

// Close the DB connection
$conn->close();

?>
