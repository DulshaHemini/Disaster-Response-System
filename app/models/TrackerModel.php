<?php
/**
 * TrackerModel
 * Handles all tracker-related data operations
 */
class TrackerModel
{
    private $conn;
    
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    /**
     * Get all affected people
     */
    public function getAllPeople(): array
    {
        return $this->getAllPeopleData();
    }
    
    /**
     * Get person details by ID
     */
    public function getPersonById($person_id)
    {
        return $this->getPersonByIdData($person_id);
    }
    
    /**
     * Get activity logs for a specific person
     */
    public function getLogsByPerson($person_id): array
    {
        return $this->getLogsByPersonData($person_id);
    }
    
    /**
     * Add a new activity log
     */
    public function addActivityLog($person_id, $log_type, $message, $created_by): bool
    {
        return $this->addActivityLogData($person_id, $log_type, $message, $created_by);
    }
    
    /**
     * Get person initials from full name
     */
    public function formatPersonInitials($full_name): string
    {
        $initials = '';
        $name_parts = explode(' ', $full_name);
        foreach ($name_parts as $part) {
            $initials .= strtoupper($part[0]);
        }
        return $initials;
    }
    
    /**
     * Private methods - Data retrieval logic
     */
    
    private function getAllPeopleData(): array
    {
        // Mock data - Replace with MySQL query
        $people = array(
            array(
                'id' => 1,
                'full_name' => 'Nimal Perera',
                'age' => 45,
                'gender' => 'male',
                'location_name' => 'Galle Road',
                'district' => 'Colombo',
                'latitude' => 6.9271,
                'longitude' => 79.8612,
                'disaster_type' => 'flood',
                'status' => 'needs_aid',
                'created_at' => '2024-01-15 10:30:00'
            ),
            array(
                'id' => 2,
                'full_name' => 'Kamala Silva',
                'age' => 32,
                'gender' => 'female',
                'location_name' => 'Main Street',
                'district' => 'Galle',
                'latitude' => 6.0535,
                'longitude' => 80.2210,
                'disaster_type' => 'landslide',
                'status' => 'team_sent',
                'created_at' => '2024-01-15 11:00:00'
            ),
            array(
                'id' => 3,
                'full_name' => 'Sunil Fernando',
                'age' => 28,
                'gender' => 'male',
                'location_name' => 'Temple Road',
                'district' => 'Kandy',
                'latitude' => 7.2906,
                'longitude' => 80.6337,
                'disaster_type' => 'flood',
                'status' => 'rescued',
                'created_at' => '2024-01-15 09:15:00'
            )
        );
        
        return $people;
    }
    
    private function getPersonByIdData($person_id)
    {
        // Mock data - Replace with MySQL query
        $all_people = array(
            1 => array(
                'id' => 1,
                'full_name' => 'Nimal Perera',
                'age' => 45,
                'gender' => 'male',
                'location_name' => 'Galle Road',
                'district' => 'Colombo',
                'latitude' => 6.9271,
                'longitude' => 79.8612,
                'disaster_type' => 'flood',
                'status' => 'needs_aid',
                'created_at' => '2024-01-15 10:30:00',
                'injury_status' => 'Minor injuries',
                'family_count' => 4,
                'contact' => '0771234567'
            ),
            2 => array(
                'id' => 2,
                'full_name' => 'Kamala Silva',
                'age' => 32,
                'gender' => 'female',
                'location_name' => 'Main Street',
                'district' => 'Galle',
                'latitude' => 6.0535,
                'longitude' => 80.2210,
                'disaster_type' => 'landslide',
                'status' => 'team_sent',
                'created_at' => '2024-01-15 11:00:00',
                'injury_status' => 'No injuries',
                'family_count' => 2,
                'contact' => '0779876543'
            ),
            3 => array(
                'id' => 3,
                'full_name' => 'Sunil Fernando',
                'age' => 28,
                'gender' => 'male',
                'location_name' => 'Temple Road',
                'district' => 'Kandy',
                'latitude' => 7.2906,
                'longitude' => 80.6337,
                'disaster_type' => 'flood',
                'status' => 'rescued',
                'created_at' => '2024-01-15 09:15:00',
                'injury_status' => 'Serious injuries',
                'family_count' => 3,
                'contact' => '0765551234'
            )
        );
        
        if (isset($all_people[$person_id])) {
            return $all_people[$person_id];
        }
        
        return null;
    }
    
    private function getLogsByPersonData($person_id): array
    {
        // Mock data - Replace with MySQL query
        $all_logs = array(
            1 => array(
                array(
                    'id' => 1,
                    'person_id' => 1,
                    'log_type' => 'incident_reported',
                    'message' => 'Person reported trapped in flooded area',
                    'created_by' => 'Emergency Hotline',
                    'created_at' => '2024-01-15 10:30:00'
                ),
                array(
                    'id' => 2,
                    'person_id' => 1,
                    'log_type' => 'team_dispatched',
                    'message' => 'Rescue team dispatched to location',
                    'created_by' => 'Control Center',
                    'created_at' => '2024-01-15 10:45:00'
                )
            ),
            2 => array(
                array(
                    'id' => 3,
                    'person_id' => 2,
                    'log_type' => 'incident_reported',
                    'message' => 'Landslide reported, family needs evacuation',
                    'created_by' => 'Local Police',
                    'created_at' => '2024-01-15 11:00:00'
                )
            ),
            3 => array(
                array(
                    'id' => 4,
                    'person_id' => 3,
                    'log_type' => 'incident_reported',
                    'message' => 'Person found in flood waters',
                    'created_by' => 'Rescue Team Alpha',
                    'created_at' => '2024-01-15 09:15:00'
                ),
                array(
                    'id' => 5,
                    'person_id' => 3,
                    'log_type' => 'medical_aid',
                    'message' => 'Medical aid provided on site',
                    'created_by' => 'Medical Team',
                    'created_at' => '2024-01-15 09:30:00'
                ),
                array(
                    'id' => 6,
                    'person_id' => 3,
                    'log_type' => 'status_update',
                    'message' => 'Person successfully rescued and transported to hospital',
                    'created_by' => 'Rescue Team Alpha',
                    'created_at' => '2024-01-15 10:00:00'
                )
            )
        );
        
        if (isset($all_logs[$person_id])) {
            return $all_logs[$person_id];
        }
        
        return array();
    }
    
    private function addActivityLogData($person_id, $log_type, $message, $created_by): bool
    {
        // Mock: Just return success - Replace with MySQL INSERT query
        return true;
    }
}
?>
