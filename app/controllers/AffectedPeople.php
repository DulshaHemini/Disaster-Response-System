<?php

// Start session for state management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in (session must have user_id and user_role)
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    header("Location: Signin.php");
    exit();
}

// Check if the logged-in user is an affected person
if ($_SESSION['user_role'] !== 'affected_people') {
    header("Location: Signin.php");
    exit();
}

// Use the actual logged-in affected person's user_id
$affected_people_id = $_SESSION['user_id'];

// Database connection using config
require_once __DIR__ . '/../../config/config.php';

// Check if connection was successful
if (!isset($conn) || $conn->connect_error) {
    die("Database connection failed. Please check if MySQL is running on port 3307.");
}

// Require the model functions
require_once __DIR__ . "/../models/AffectedPeople_.php";

// Fetch data from live Database via Model functions
$myRequests = getMyRequests($conn, $affected_people_id);
$assignedResources = getAssignedResources($conn, $affected_people_id);
$activityLogs = getActivityLogs($conn, $affected_people_id);
$profile = getAffectedPersonProfile($conn, $affected_people_id);

// Calculate simple stats based on live data
$totalRequests = count($myRequests);
$pendingRequests = count(array_filter($myRequests, function($r) { return $r['status'] == 'Pending'; }));
$completedRequests = count(array_filter($myRequests, function($r) { return $r['status'] == 'Done'; }));
$totalResources = count($assignedResources);

// Load the View
require_once __DIR__ . "/../views/AffectedPeople/_AffectedPeople.php";

// Close connection after rendering
$conn->close();

?>
