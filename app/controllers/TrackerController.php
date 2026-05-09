<?php
/**
 * TrackerController
 * Handles all tracker-related requests and logic
 */
require_once APP_PATH . '/models/TrackerModel.php';
require_once dirname(APP_PATH) . '/config/config.php';

class TrackerController
{
    private $model;
    
    public function __construct()
    {
        global $conn;
        $this->model = new TrackerModel($conn);
    }
    
    /**
     * Main tracker view - displays map and people list
     */
    public function index(): void
    {
        $people = $this->model->getAllPeople();
        $total_people = count($people);
        
        extract([
            'people'       => $people,
            'total_people' => $total_people,
        ]);
        
        ob_start();
        require APP_PATH . '/views/tracker/tracker.php';
        $content = ob_get_clean();
        
        require APP_PATH . '/views/layouts/main.php';
    }
    
    /**
     * Get person details via AJAX
     */
    public function getPerson(): void
    {
        if (!isset($_GET['id'])) {
            echo json_encode(['error' => 'Person ID not provided']);
            return;
        }
        
        $person_id = $_GET['id'];
        $person = $this->model->getPersonById($person_id);
        
        if (!$person) {
            echo json_encode(['error' => 'Person not found']);
            return;
        }
        
        $logs = $this->model->getLogsByPerson($person_id);
        
        echo json_encode([
            'person' => $person,
            'logs'   => $logs
        ]);
    }
    
    /**
     * Add activity log via AJAX
     */
    public function addLog(): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo json_encode(['error' => 'Invalid request method']);
            return;
        }
        
        $person_id = isset($_POST['person_id']) ? $_POST['person_id'] : '';
        $log_type = isset($_POST['log_type']) ? $_POST['log_type'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        $created_by = isset($_POST['created_by']) ? $_POST['created_by'] : 'System';
        
        if (empty($person_id) || empty($log_type) || empty($message)) {
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }
        
        $result = $this->model->addActivityLog($person_id, $log_type, $message, $created_by);
        
        if ($result) {
            echo json_encode(['success' => 'Log added successfully']);
        } else {
            echo json_encode(['error' => 'Failed to add log']);
        }
    }
}
?>
