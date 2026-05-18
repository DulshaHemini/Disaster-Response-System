<?php
class AssignmentModel {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;  // ← $this->db everywhere
    }

    public function getAllAssignments() {
        $sql = "SELECT 
                    a.assignment_id AS id, 
                    DATE_FORMAT(a.assigned_date, '%Y-%m-%d %H:%i') AS date,
                    a.request_id AS req_id,
                    COALESCE(a.resource_id, '—') AS resource_id,
                    COALESCE(CONCAT(v.volunteer_id, ' · ', v.first_name), '—') AS volunteer_id,
                    a.affected_people_id,
                    a.description,
                    a.status
                FROM assignments a
                LEFT JOIN volunteer v ON v.volunteer_id = a.volunteer_id
                ORDER BY a.assignment_id DESC";

        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus($id, $status) {
        try {
            $stmt = $this->db->prepare("UPDATE assignments SET status = ? WHERE assignment_id = ?");
            $stmt->bind_param("si", $status, $id);
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}