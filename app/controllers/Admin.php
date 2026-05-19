<?php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Access control: enforce admin authorization
if (!isset($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'admin') {
    header("Location: Signin.php");
    exit();
}

// Load database configuration
require_once __DIR__ . '/../../config/config.php';

// Import Admin model
require_once __DIR__ . '/../models/Admin_.php';

// Handle POST/AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'delete_user':
            $userId = intval($_POST['user_id'] ?? 0);
            if ($userId > 0 && deleteUser($conn, $userId)) {
                echo json_encode(['ok' => true]);
            } else {
                echo json_encode(['ok' => false, 'error' => 'Failed to delete user']);
            }
            exit;

        case 'update_request_status':
            $reqId = intval($_POST['req_id'] ?? 0);
            $status = $_POST['status'] ?? '';
            if ($reqId > 0 && !empty($status) && updateRequestStatus($conn, $reqId, $status)) {
                echo json_encode(['ok' => true]);
            } else {
                echo json_encode(['ok' => false, 'error' => 'Failed to update request status']);
            }
            exit;

        case 'assign_volunteer':
            $reqId = intval($_POST['req_id'] ?? 0);
            $volunteerId = intval($_POST['volunteer_id'] ?? 0);
            if ($reqId > 0 && $volunteerId > 0 && assignVolunteer($conn, $reqId, $volunteerId)) {
                echo json_encode(['ok' => true]);
            } else {
                echo json_encode(['ok' => false, 'error' => 'Failed to assign volunteer']);
            }
            exit;

        default:
            echo json_encode(['ok' => false, 'error' => 'Unknown action']);
            exit;
    }
}

// Handle non-AJAX user deletion if requested via URL
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $filter = $_GET['filter'] ?? 'all';
    
    if (deleteUser($conn, $deleteId)) {
        echo "<script>alert('User deleted successfully'); window.location.href='Admin.php?filter=" . htmlspecialchars($filter, ENT_QUOTES) . "';</script>";
    } else {
        echo "<script>alert('Failed to delete user'); window.location.href='Admin.php?filter=" . htmlspecialchars($filter, ENT_QUOTES) . "';</script>";
    }
    exit;
}

// GET Data fetching for rendering the dashboard
$filter = $_GET['filter'] ?? 'all';
$validFilters = ['all', 'admin', 'volunteer', 'affected_people'];
if (!in_array($filter, $validFilters)) {
    $filter = 'all';
}

// Retrieve data using Model
$users = getUsers($conn, $filter);
$userCounts = getUserCounts($conn);
$allRequests = getAllRequests($conn);
$instantRequests = getInstantRequests($conn);
$volunteers = getVolunteers($conn);
$assignmentsMap = getAssignmentsMap($conn);
$openRequests = getOpenRequests($conn);
$resources = getResources($conn);
$locations = getLocations($conn);

// Load the View template
require_once __DIR__ . '/../views/admin/index.php';

// Close database connection
$conn->close();

?>