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
        $requestJoinSql = '';
        $requestSelectSql = "'other' AS disaster_type,
                    'needs_aid' AS status,
                    NOW() AS created_at";
        $requestTable = $this->resolveRequestTableName();
        if ($requestTable !== null) {
            $requestSelectSql = "COALESCE(r.req_type, 'other') AS disaster_type,
                    CASE
                        WHEN r.status = 'Pending' THEN 'needs_aid'
                        WHEN r.status = 'Approved' THEN 'team_sent'
                        WHEN r.status = 'Assigned' THEN 'arrived'
                        WHEN r.status = 'In Progress' THEN 'arrived'
                        WHEN r.status = 'Received' THEN 'rescued'
                        ELSE 'needs_aid'
                    END AS status,
                    COALESCE(r.created_at, NOW()) AS created_at";
            $requestJoinSql = "LEFT JOIN (
                    SELECT r1.*
                    FROM " . $requestTable . " r1
                    INNER JOIN (
                        SELECT affected_people_id, MAX(req_id) AS latest_req_id
                        FROM " . $requestTable . "
                        GROUP BY affected_people_id
                    ) latest_request ON latest_request.latest_req_id = r1.req_id
                ) r ON r.affected_people_id = ap.user_id";
        }

        $sql = "SELECT
                    ap.user_id AS id,
                    CONCAT(ap.first_name, ' ', ap.last_name) AS full_name,
                    ap.age,
                    LOWER(ap.gender) AS gender,
                    COALESCE(
                        NULLIF(CONCAT_WS(', ', NULLIF(TRIM(CONCAT(COALESCE(l.home_no, ''), ' ', COALESCE(l.street, ''))), ''), NULLIF(l.city, '')), ''),
                        'Location not specified'
                    ) AS location_name,
                    COALESCE(l.district, 'Unknown') AS district,
                    COALESCE(l.latitude, 0) AS latitude,
                    COALESCE(l.longitude, 0) AS longitude,
                    " . $requestSelectSql . ",
                    COALESCE(ap.no_of_family_members, 0) AS family_count,
                    COALESCE(ap.contact_no, 'Not available') AS contact,
                    'Not specified' AS injury_status
                FROM affected_people ap
                INNER JOIN users u ON u.user_id = ap.user_id
                LEFT JOIN (
                    SELECT l1.*
                    FROM Location l1
                    INNER JOIN (
                        SELECT user_id, MAX(loc_id) AS latest_loc_id
                        FROM Location
                        GROUP BY user_id
                    ) latest_location ON latest_location.latest_loc_id = l1.loc_id
                ) l ON l.user_id = ap.user_id
                " . $requestJoinSql . "
                WHERE u.user_role = 'affected_people'
                ORDER BY created_at DESC";

        $result = $this->conn->query($sql);
        if (!$result) {
            return array();
        }

        $people = array();
        while ($row = $result->fetch_assoc()) {
            $row['id'] = (int) $row['id'];
            $row['age'] = (int) $row['age'];
            $row['latitude'] = (float) $row['latitude'];
            $row['longitude'] = (float) $row['longitude'];
            $row['family_count'] = (int) $row['family_count'];
            $people[] = $row;
        }

        return $people;
    }
    
    private function getPersonByIdData($person_id)
    {
        $requestJoinSql = '';
        $requestSelectSql = "'other' AS disaster_type,
                    'needs_aid' AS status,
                    NOW() AS created_at";
        $requestTable = $this->resolveRequestTableName();
        if ($requestTable !== null) {
            $requestSelectSql = "COALESCE(r.req_type, 'other') AS disaster_type,
                    CASE
                        WHEN r.status = 'Pending' THEN 'needs_aid'
                        WHEN r.status = 'Approved' THEN 'team_sent'
                        WHEN r.status = 'Assigned' THEN 'arrived'
                        WHEN r.status = 'In Progress' THEN 'arrived'
                        WHEN r.status = 'Received' THEN 'rescued'
                        ELSE 'needs_aid'
                    END AS status,
                    COALESCE(r.created_at, NOW()) AS created_at";
            $requestJoinSql = "LEFT JOIN (
                    SELECT r1.*
                    FROM " . $requestTable . " r1
                    INNER JOIN (
                        SELECT affected_people_id, MAX(req_id) AS latest_req_id
                        FROM " . $requestTable . "
                        GROUP BY affected_people_id
                    ) latest_request ON latest_request.latest_req_id = r1.req_id
                ) r ON r.affected_people_id = ap.user_id";
        }

        $sql = "SELECT
                    ap.user_id AS id,
                    CONCAT(ap.first_name, ' ', ap.last_name) AS full_name,
                    ap.age,
                    LOWER(ap.gender) AS gender,
                    COALESCE(
                        NULLIF(CONCAT_WS(', ', NULLIF(TRIM(CONCAT(COALESCE(l.home_no, ''), ' ', COALESCE(l.street, ''))), ''), NULLIF(l.city, '')), ''),
                        'Location not specified'
                    ) AS location_name,
                    COALESCE(l.district, 'Unknown') AS district,
                    COALESCE(l.latitude, 0) AS latitude,
                    COALESCE(l.longitude, 0) AS longitude,
                    " . $requestSelectSql . ",
                    'Not specified' AS injury_status,
                    COALESCE(ap.no_of_family_members, 0) AS family_count,
                    COALESCE(ap.contact_no, 'Not available') AS contact
                FROM affected_people ap
                INNER JOIN users u ON u.user_id = ap.user_id
                LEFT JOIN (
                    SELECT l1.*
                    FROM Location l1
                    INNER JOIN (
                        SELECT user_id, MAX(loc_id) AS latest_loc_id
                        FROM Location
                        GROUP BY user_id
                    ) latest_location ON latest_location.latest_loc_id = l1.loc_id
                ) l ON l.user_id = ap.user_id
                " . $requestJoinSql . "
                WHERE u.user_role = 'affected_people' AND ap.user_id = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $person_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $person = $result ? $result->fetch_assoc() : null;
        $stmt->close();

        if ($person) {
            $person['id'] = (int) $person['id'];
            $person['age'] = (int) $person['age'];
            $person['latitude'] = (float) $person['latitude'];
            $person['longitude'] = (float) $person['longitude'];
            $person['family_count'] = (int) $person['family_count'];
        }
        
        return $person;
    }
    
    private function getLogsByPersonData($person_id): array
    {
        if (!$this->tableExists('tracker_activity_log')) {
            return array();
        }

        $sql = "SELECT id, person_id, log_type, message, created_by, created_at
                FROM tracker_activity_log
                WHERE person_id = ?
                ORDER BY created_at DESC, id DESC";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return array();
        }

        $stmt->bind_param("i", $person_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $logs = array();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $row['id'] = (int) $row['id'];
                $row['person_id'] = (int) $row['person_id'];
                $logs[] = $row;
            }
        }
        $stmt->close();

        return $logs;
    }
    
    private function addActivityLogData($person_id, $log_type, $message, $created_by): bool
    {
        if (!$this->tableExists('tracker_activity_log')) {
            return false;
        }

        $sql = "INSERT INTO tracker_activity_log (person_id, log_type, message, created_by)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("isss", $person_id, $log_type, $message, $created_by);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    private function resolveRequestTableName()
    {
        $sql = "SELECT table_name
                FROM information_schema.tables
                WHERE table_schema = DATABASE()
                    AND LOWER(table_name) IN ('request', 'requests')
                ORDER BY CASE LOWER(table_name)
                    WHEN 'request' THEN 1
                    WHEN 'requests' THEN 2
                    ELSE 3
                END
                LIMIT 1";

        $result = $this->conn->query($sql);
        if (!$result) {
            return null;
        }

        $row = $result->fetch_assoc();
        if (!$row || !isset($row['table_name'])) {
            return null;
        }

        return "`" . str_replace("`", "``", $row['table_name']) . "`";
    }

    private function tableExists($table_name): bool
    {
        $sql = "SELECT 1
                FROM information_schema.tables
                WHERE table_schema = DATABASE()
                    AND table_name = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $table_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result && $result->num_rows > 0;
        $stmt->close();

        return $exists;
    }
}
?>
