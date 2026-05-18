<?php

// Start session for state management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    header("Location: ../../public/signin.php");
    exit();
}

// Check if the logged-in user is a volunteer
if (strtolower($_SESSION['user_role']) !== 'volunteer') {
    header("Location: ../../public/signin.php");
    exit();
}

$volunteer_id = $_SESSION['user_id'];

// Database connection using global config
require_once __DIR__ . "/../../config/config.php";

// Require the model functions
require_once __DIR__ . "/../models/volunteerResource_.php";

$flashMessage = '';

// Handle incoming POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['actionType']) && $_POST['actionType'] === 'save_resource') {
        $resourceId = isset($_POST['resourceId']) ? (int)$_POST['resourceId'] : 0;
        $name = isset($_POST['resourceName']) ? trim($_POST['resourceName']) : '';
        $type = isset($_POST['resourceTypeId']) ? trim($_POST['resourceTypeId']) : '';
        $count = isset($_POST['resourceCount']) ? (int)$_POST['resourceCount'] : 0;
        $desc = isset($_POST['descriptionInput']) ? trim($_POST['descriptionInput']) : '';
        
        if (!empty($name) && !empty($type)) {
            if (saveResource($conn, $volunteer_id, $resourceId, $name, $type, $count, $desc)) {
                $_SESSION['flash_message'] = empty($resourceId) ? "Resource added successfully!" : "Resource updated successfully!";
            } else {
                $_SESSION['flash_message'] = "Error saving resource.";
            }
        } else {
            $_SESSION['flash_message'] = "Please fill all required fields.";
        }
    } elseif (isset($_POST['deleteResourceId'])) {
        $resourceId = (int)$_POST['deleteResourceId'];
        if ($resourceId > 0) {
            if (deleteResource($conn, $volunteer_id, $resourceId)) {
                $_SESSION['flash_message'] = "Resource deleted successfully!";
            } else {
                $_SESSION['flash_message'] = "Error deleting resource.";
            }
        }
    } elseif (isset($_POST['typeNameInput'])) {
        $_SESSION['flash_message'] = "Adding custom resource types is disabled (Database uses fixed ENUM).";
    } elseif (isset($_POST['deleteTypeId'])) {
        $_SESSION['flash_message'] = "Deleting default resource types is disabled.";
    }
    
    // Redirect to self to prevent form resubmission
    header("Location: volunteerResource.php");
    exit();
}

// Retrieve flash message if set
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

// Fetch resources and types
$resourcesList = getVolunteerResources($conn, $volunteer_id);
$resourceTypes = getResourceTypes();

// Load the View
require_once __DIR__ . "/../views/volunteerResource/_volunteerResource.php";

// Close connection after rendering
$conn->close();

?>
