<?php
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
    
    public function index(): void
    {
        $people = $this->model->getAllPeople();
        $total_people = count($people);
        
        extract([
            'people'       => $people,
            'total_people' => $total_people,
        ]);
        
        require APP_PATH . '/views/tracker/tracker.php';
    }
    
    // Simple function to get person details
    public function getPerson($person_id)
    {
        return $this->model->getPersonById($person_id);
    }
    
    // Simple function to get logs for a person
    public function getPersonLogs($person_id)
    {
        return $this->model->getLogsByPerson($person_id);
    }
    
    // Simple function to add activity log
    public function addActivityLog($person_id, $log_type, $message, $created_by = 'System')
    {
        return $this->model->addActivityLog($person_id, $log_type, $message, $created_by);
    }
}
?>
