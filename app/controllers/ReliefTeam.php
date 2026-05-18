<?php

// Start session for state management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in (session must have user_id and user_role)
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // Not logged in → redirect to login page
    header("Location: ../../public/signin.php");
    exit();
}

// Check if the logged-in user is a relief_team
if ($_SESSION['user_role'] !== 'relief_team') {
    // Wrong role → redirect to login page
    header("Location: ../../public/signin.php");
    exit();
}

// Use the actual logged-in relief team's user_id
$team_id = $_SESSION['user_id'];

// Database connection
$conn = new mysqli("localhost", "root", "", "DRCS", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Require the model functions
require_once __DIR__ . "/../models/ReliefTeam_.php";

// Handle incoming POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['task_id'])) {
    $action = $_POST['action'];
    $taskId = $_POST['task_id'];

    if ($action === 'accept') {
        acceptTask($conn, $taskId, $team_id);
    } elseif ($action === 'reject') {
        rejectTask($conn, $taskId, $team_id);
    } elseif ($action === 'mark_done') {
        markTaskDone($conn, $taskId, $team_id);
    }
    
    // Redirect to self to prevent form resubmission on refresh
    header("Location: ReliefTeam.php");
    exit();
}

// Fetch data from live Database via Model functions
$pendingTasks = getPendingTasks($conn, $team_id);
$activeTasks = getActiveTasks($conn, $team_id);
$profile = getReliefTeamProfile($conn, $team_id);

// Calculate simple stats based on live data
$affectedCount = getAffectedPeopleCount($conn);
$pendingAssignCount = count($pendingTasks);
$activeTaskCount = count(array_filter($activeTasks, function($t) { return $t['status'] == 'doing'; }));
$completedCount = count(array_filter($activeTasks, function($t) { return $t['status'] == 'done'; }));

// Load the View
require_once __DIR__ . "/../views/ReliefTeam/_ReliefTeam.php";

// Close connection after rendering
$conn->close();

?>
