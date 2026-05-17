<?php
/**
 * TrackerModel
 * Handles all tracker-related data operations
 */
class TrackerModel
{
    private const DEFAULT_TRACKER_STATUS = 'needs_aid';
    private const REQUEST_TABLE_CANDIDATES = array(
        'logged_request',
        'request',
        'requests',
    );
    private const REQUEST_STATUS_MAP = array(
        'Pending' => 'needs_aid',
        'Approved' => 'team_sent',
        'Assigned' => 'arrived',
        'In Progress' => 'arrived',
        'Received' => 'rescued',
    );

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
        // Try new tracker activity_logs table first
        if ($this->tableExists('activity_logs')) {
            return $this->getLogsFromNewActivityLog($person_id);
        }
        // Try both table names (tracker_activity_log or activity_log)
        if ($this->tableExists('activity_log')) {
            return $this->getLogsFromActivityLog($person_id);
        } elseif ($this->tableExists('tracker_activity_log')) {
            return $this->getLogsFromTrackerActivityLog($person_id);
        }
        return array();
    }
    
    /**
     * Add a new activity log
     */
    public function addActivityLog($person_id, $log_type, $message, $created_by): bool
    {
        // Try new activity_logs table first
        if ($this->tableExists('activity_logs')) {
            return $this->addActivityToNewActivityLog($person_id, $log_type, $message, $created_by);
        }
        // Try activity_log table first, then tracker_activity_log
        if ($this->tableExists('activity_log')) {
            return $this->addActivityToActivityLog($person_id, $log_type, $message, $created_by);
        } elseif ($this->tableExists('tracker_activity_log')) {
            return $this->addActivityToTrackerActivityLog($person_id, $log_type, $message, $created_by);
        }
        return false;
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
        $affectedPeopleIdColumn = $this->resolveAffectedPeopleIdColumn();
        if ($affectedPeopleIdColumn === null) {
            return array();
        }

        list($requestSelectSql, $requestJoinSql) = $this->getRequestSqlParts($affectedPeopleIdColumn);

        $sql = "SELECT
                    ap." . $affectedPeopleIdColumn . " AS id,
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
                INNER JOIN users u ON u.user_id = ap." . $affectedPeopleIdColumn . "
                LEFT JOIN (
                    SELECT l1.*
                    FROM Location l1
                    INNER JOIN (
                        SELECT user_id, MAX(loc_id) AS latest_loc_id
                        FROM Location
                        GROUP BY user_id
                    ) latest_location ON latest_location.latest_loc_id = l1.loc_id
                ) l ON l.user_id = ap." . $affectedPeopleIdColumn . "
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
        $affectedPeopleIdColumn = $this->resolveAffectedPeopleIdColumn();
        if ($affectedPeopleIdColumn === null) {
            return null;
        }

        list($requestSelectSql, $requestJoinSql) = $this->getRequestSqlParts($affectedPeopleIdColumn);

        $sql = "SELECT
                    ap." . $affectedPeopleIdColumn . " AS id,
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
                INNER JOIN users u ON u.user_id = ap." . $affectedPeopleIdColumn . "
                LEFT JOIN (
                    SELECT l1.*
                    FROM Location l1
                    INNER JOIN (
                        SELECT user_id, MAX(loc_id) AS latest_loc_id
                        FROM Location
                        GROUP BY user_id
                    ) latest_location ON latest_location.latest_loc_id = l1.loc_id
                ) l ON l.user_id = ap." . $affectedPeopleIdColumn . "
                " . $requestJoinSql . "
                WHERE u.user_role = 'affected_people' AND ap." . $affectedPeopleIdColumn . " = ?
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

    private function resolveAffectedPeopleIdColumn()
    {
        $sql = "SELECT column_name
                FROM information_schema.columns
                WHERE table_schema = DATABASE()
                    AND table_name = 'affected_people'
                    AND LOWER(column_name) IN ('affected_people_id', 'user_id')
                ORDER BY CASE LOWER(column_name)
                    WHEN 'affected_people_id' THEN 1
                    WHEN 'user_id' THEN 2
                    ELSE 3
                END
                LIMIT 1";

        $result = $this->conn->query($sql);
        if (!$result) {
            return null;
        }

        $row = $result->fetch_assoc();
        if (!$row || !isset($row['column_name'])) {
            return null;
        }

        return $this->quoteIdentifier($row['column_name']);
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

    private function getRequestSqlParts($affectedPeopleIdColumn): array
    {
        $requestJoinSql = '';
        $requestSelectSql = "'other' AS disaster_type,
                    '" . self::DEFAULT_TRACKER_STATUS . "' AS status,
                    NOW() AS created_at";

        $requestTableDefinition = $this->resolveRequestTableDefinition();
        if ($requestTableDefinition !== null) {
            $requestTable = $requestTableDefinition['table'];
            $requestIdColumn = $requestTableDefinition['id_column'];
            $requestPersonColumn = $requestTableDefinition['person_column'];
            $requestTypeColumn = $requestTableDefinition['type_column'];
            $requestStatusColumn = $requestTableDefinition['status_column'];
            $requestCreatedAtColumn = $requestTableDefinition['created_at_column'];

            $requestSelectSql = "COALESCE(r." . $requestTypeColumn . ", 'other') AS disaster_type,
                    " . $this->buildRequestStatusCaseSql('r.' . $requestStatusColumn) . " AS status,
                    COALESCE(r." . $requestCreatedAtColumn . ", NOW()) AS created_at";
            $requestJoinSql = "LEFT JOIN (
                    SELECT r1.*
                    FROM " . $requestTable . " r1
                    INNER JOIN (
                        SELECT " . $requestPersonColumn . ", MAX(" . $requestIdColumn . ") AS latest_req_id
                        FROM " . $requestTable . "
                        GROUP BY " . $requestPersonColumn . "
                    ) latest_request ON latest_request.latest_req_id = r1." . $requestIdColumn . "
                ) r ON r." . $requestPersonColumn . " = ap." . $affectedPeopleIdColumn;
        }

        return array($requestSelectSql, $requestJoinSql);
    }

    private function buildRequestStatusCaseSql($requestStatusColumn): string
    {
        $parts = array('CASE');
        foreach (self::REQUEST_STATUS_MAP as $requestStatus => $trackerStatus) {
            $parts[] = "WHEN " . $requestStatusColumn . " = '" . $this->escapeSqlLiteral($requestStatus) . "' THEN '" . $this->escapeSqlLiteral($trackerStatus) . "'";
        }
        $parts[] = "ELSE '" . $this->escapeSqlLiteral(self::DEFAULT_TRACKER_STATUS) . "'";
        $parts[] = 'END';

        return implode("\n                        ", $parts);
    }

    private function escapeSqlLiteral($value): string
    {
        return str_replace("'", "''", $value);
    }

    private function resolveRequestTableDefinition()
    {
        foreach (self::REQUEST_TABLE_CANDIDATES as $tableName) {
            $resolvedTableName = $this->resolveTableNameCaseInsensitive($tableName);
            if ($resolvedTableName === null) {
                continue;
            }

            $requestIdColumn = $this->resolveTableColumn($resolvedTableName, array('req_id', 'request_id'));
            $requestPersonColumn = $this->resolveTableColumn($resolvedTableName, array('affected_people_id', 'user_id'));
            $requestTypeColumn = $this->resolveTableColumn($resolvedTableName, array('req_type', 'disaster_type'));
            $requestStatusColumn = $this->resolveTableColumn($resolvedTableName, array('status'));
            $requestCreatedAtColumn = $this->resolveTableColumn($resolvedTableName, array('created_at'));

            if ($requestIdColumn === null || $requestPersonColumn === null || $requestTypeColumn === null || $requestStatusColumn === null || $requestCreatedAtColumn === null) {
                continue;
            }

            return array(
                'table' => $this->quoteIdentifier($resolvedTableName),
                'id_column' => $requestIdColumn,
                'person_column' => $requestPersonColumn,
                'type_column' => $requestTypeColumn,
                'status_column' => $requestStatusColumn,
                'created_at_column' => $requestCreatedAtColumn,
            );
        }

        return null;
    }

    private function resolveTableNameCaseInsensitive($tableName)
    {
        $sql = "SELECT table_name
                FROM information_schema.tables
                WHERE table_schema = DATABASE()
                    AND LOWER(table_name) = LOWER(?)
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('s', $tableName);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;
        $stmt->close();

        if (!$row || !isset($row['table_name'])) {
            return null;
        }

        return $row['table_name'];
    }

    private function resolveTableColumn($tableName, $candidateColumns)
    {
        $placeholders = implode(', ', array_fill(0, count($candidateColumns), '?'));
        $sql = "SELECT column_name
                FROM information_schema.columns
                WHERE table_schema = DATABASE()
                    AND table_name = ?
                    AND LOWER(column_name) IN (" . $placeholders . ")
                ORDER BY FIELD(LOWER(column_name), " . $placeholders . ")
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return null;
        }

        $lowerCaseCandidates = array_map('strtolower', $candidateColumns);
        $bindValues = array_merge(array($tableName), $lowerCaseCandidates, $lowerCaseCandidates);
        $types = str_repeat('s', count($bindValues));
        $bindArgs = array($types);
        foreach ($bindValues as $index => $value) {
            $bindArgs[] = &$bindValues[$index];
        }

        call_user_func_array(array($stmt, 'bind_param'), $bindArgs);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;
        $stmt->close();

        if (!$row || !isset($row['column_name'])) {
            return null;
        }

        return $this->quoteIdentifier($row['column_name']);
    }

    private function quoteIdentifier($identifier): string
    {
        return "`" . str_replace("`", "``", $identifier) . "`";
    }

    /**
     * Get logs from activity_log table (tracker updates)
     */
    private function getLogsFromActivityLog($person_id): array
    {
        // This table tracks person-specific updates
        // We'll query activity_log but filter for person-related activities
        $sql = "SELECT id, user_id, activity_type, description, created_at
                FROM activity_log
                WHERE entity_type = 'person' AND entity_id = ?
                ORDER BY created_at DESC
                LIMIT 50";
        
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
                // Convert to expected format
                $logs[] = array(
                    'id' => (int) $row['id'],
                    'person_id' => $person_id,
                    'log_type' => $row['activity_type'],
                    'message' => $row['description'] ?? 'No description',
                    'created_by' => 'System',
                    'created_at' => $row['created_at']
                );
            }
        }
        $stmt->close();
        
        return $logs;
    }
    
    /**
     * Get logs from new activity_logs table (tracker-specific)
     */
    private function getLogsFromNewActivityLog($person_id): array
    {
        $sql = "SELECT log_id as id, affected_people_id as person_id, log_type, message, created_by, created_at
                FROM activity_logs
                WHERE affected_people_id = ?
                ORDER BY created_at DESC, log_id DESC
                LIMIT 100";

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
    
    /**
     * Get logs from tracker_activity_log table
     */
    private function getLogsFromTrackerActivityLog($person_id): array
    {
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
    
    /**
     * Add activity to new activity_logs table
     */
    private function addActivityToNewActivityLog($person_id, $log_type, $message, $created_by): bool
    {
        $sql = "INSERT INTO activity_logs (affected_people_id, log_type, message, created_by)
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

    /**
     * Add activity to activity_log table
     */
    private function addActivityToActivityLog($person_id, $log_type, $message, $created_by): bool
    {
        $sql = "INSERT INTO activity_log (user_id, activity_type, entity_type, entity_id, description, status)
                VALUES (?, ?, 'person', ?, ?, 'success')";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        
        $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
        $stmt->bind_param("isis", $user_id, $log_type, $person_id, $message);
        $ok = $stmt->execute();
        $stmt->close();
        
        return $ok;
    }
    
    /**
     * Add activity to tracker_activity_log table
     */
    private function addActivityToTrackerActivityLog($person_id, $log_type, $message, $created_by): bool
    {
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
}
?>
