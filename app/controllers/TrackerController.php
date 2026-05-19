<?php

// Start session for state management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection using config
require_once __DIR__ . '/../../config/config.php';

// Check if connection was successful
if (!isset($conn) || $conn->connect_error) {
    die("Database connection failed. Please check if MySQL is running.");
}

// Require the model
require_once __DIR__ . "/../models/TrackerModel.php";

// Initialize the model
$trackerModel = new TrackerModel($conn);

// Handle API requests for person data
if (isset($_GET['action']) && $_GET['action'] === 'getPersonData') {
    header('Content-Type: application/json');

    $person_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    if ($person_id <= 0) {
        http_response_code(400);
        echo json_encode(array(
            'success' => false,
            'message' => 'Invalid person ID',
        ));
        exit();
    }

    $person = $trackerModel->getPersonById($person_id);
    if (!$person) {
        http_response_code(404);
        echo json_encode(array(
            'success' => false,
            'message' => 'Person not found',
        ));
        exit();
    }

    $logs = $trackerModel->getLogsByPerson($person_id);
    echo json_encode(array(
        'success' => true,
        'person' => $person,
        'logs' => $logs,
        'logs_count' => count($logs),
    ));
    exit();
}

// Fetch data from database via model
$people = $trackerModel->getAllPeople();
$total_people = count($people);

// Load the Tracker View
require_once __DIR__ . "/../views/tracker/tracker.php";

// Close connection after rendering
$conn->close();

?>
