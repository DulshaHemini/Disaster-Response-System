<?php

// Prevent direct script access
if (!defined('DB_SERVER')) {
    require_once __DIR__ . '/../../config/config.php';
}

/**
 * Remove a user from the system
 */
function deleteUser($conn, $user_id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

/**
 * Update request status (Logged or Instant)
 */
function updateRequestStatus($conn, $req_id, $status) {
    // Attempt updating in both tables since they share the same base request ID
    $success = false;

    // 1. Logged Request
    $stmt1 = $conn->prepare("UPDATE Logged_Request SET status = ? WHERE req_id = ?");
    $stmt1->bind_param("si", $status, $req_id);
    if ($stmt1->execute() && $stmt1->affected_rows > 0) {
        $success = true;
    }
    $stmt1->close();

    // 2. Instant Request
    $stmt2 = $conn->prepare("UPDATE Instant_Request SET status = ? WHERE req_id = ?");
    $stmt2->bind_param("si", $status, $req_id);
    if ($stmt2->execute() && $stmt2->affected_rows > 0) {
        $success = true;
    }
    $stmt2->close();

    return $success;
}

/**
 * Assign a volunteer to a request
 */
function assignVolunteer($conn, $req_id, $volunteer_id) {
    // 1. Check if assignment already exists
    $stmt = $conn->prepare("SELECT assignment_id FROM assignments WHERE request_id = ?");
    $stmt->bind_param("i", $req_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $existing = $res->fetch_assoc();
    $stmt->close();

    if ($existing) {
        // Update existing assignment
        $stmt_up = $conn->prepare("UPDATE assignments SET volunteer_id = ?, status = 'Assigned' WHERE request_id = ?");
        $stmt_up->bind_param("ii", $volunteer_id, $req_id);
        $success = $stmt_up->execute();
        $stmt_up->close();
    } else {
        // Create new assignment
        $stmt_in = $conn->prepare("INSERT INTO assignments (request_id, volunteer_id, status, assignment_type) VALUES (?, ?, 'Assigned', 'Volunteer_Task')");
        $stmt_in->bind_param("ii", $req_id, $volunteer_id);
        $success = $stmt_in->execute();
        $stmt_in->close();
    }

    // Update status to In Progress in respective tables
    $conn->query("UPDATE Logged_Request SET status = 'In Progress' WHERE req_id = $req_id");
    $conn->query("UPDATE Instant_Request SET status = 'In Progress' WHERE req_id = $req_id");

    return $success;
}

/**
 * Retrieve users list based on role filter
 */
function getUsers($conn, $filter = 'all') {
    if ($filter === 'all') {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
    } else {
        $sql = "SELECT * FROM users WHERE user_role = ? ORDER BY created_at DESC";
    }
    
    $stmt = $conn->prepare($sql);
    if ($filter !== 'all') {
        $stmt->bind_param("s", $filter);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $stmt->close();
    return $rows;
}

/**
 * Retrieve summary counts of each user role
 */
function getUserCounts($conn) {
    $sql = "SELECT user_role, COUNT(*) as count FROM users GROUP BY user_role";
    $result = $conn->query($sql);
    
    $counts = [
        'admin' => 0,
        'volunteer' => 0,
        'affected_people' => 0
    ];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $role = strtolower($row['user_role']);
            if (isset($counts[$role])) {
                $counts[$role] = (int)$row['count'];
            }
        }
    }
    return $counts;
}

/**
 * Retrieve a unified list of all requests
 */
function getAllRequests($conn) {
    $sql = "
        SELECT
            lr.req_id,
            lr.affected_people_id,
            lr.loc_id,
            lr.req_name,
            lr.resource_type,
            lr.req_type,
            lr.resource_count,
            lr.no_of_affected_people,
            lr.description,
            lr.contact_number,
            lr.priority_level,
            lr.created_at,
            lr.status,
            'No' AS is_instant
        FROM Logged_Request lr

        UNION ALL

        SELECT
            ir.req_id,
            ir.user_id          AS affected_people_id,
            ir.loc_id,
            ir.req_name,
            ir.resource_type,
            NULL                AS req_type,
            ir.resource_count,
            NULL                AS no_of_affected_people,
            NULL                AS description,
            ir.contact_number,
            NULL                AS priority_level,
            ir.created_at,
            ir.status,
            'Yes'               AS is_instant
        FROM Instant_Request ir

        ORDER BY req_id DESC
    ";
    
    $result = $conn->query($sql);
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * Retrieve instant help requests with locations
 */
function getInstantRequests($conn) {
    $sql = "
        SELECT 
            ir.req_id,
            ir.user_id,
            ir.loc_id,
            ir.full_name,
            ir.req_name,
            ir.resource_type,
            ir.resource_count,
            NULL                AS description,
            ir.contact_number,
            ir.created_at,
            ir.status,
            l.district,
            l.city,
            l.street,
            l.latitude,
            l.longitude
        FROM Instant_Request ir
        LEFT JOIN Location l ON ir.loc_id = l.loc_id
        ORDER BY ir.created_at DESC
    ";
    
    $result = $conn->query($sql);
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * Fetch volunteers
 */
function getVolunteers($conn) {
    $sql = "
        SELECT v.volunteer_id, u.username, v.first_name, v.last_name,
               v.nic, v.gender, v.contact_no, v.age,
               v.availability_status, v.organization_name
        FROM volunteer v
        JOIN users u ON v.volunteer_id = u.user_id
        ORDER BY v.volunteer_id ASC
    ";
    
    $result = $conn->query($sql);
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * Fetch current assignments mapping
 */
function getAssignmentsMap($conn) {
    $result = $conn->query("SELECT request_id, volunteer_id FROM assignments");
    $assignments  = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $assignments[$row['request_id']] = $row['volunteer_id'];
        }
    }
    return $assignments;
}

/**
 * Fetch open requests (not resolved)
 */
function getOpenRequests($conn) {
    $sql = "
        SELECT req_id, req_type, resource_type, loc_id, status FROM Logged_Request
        WHERE LOWER(TRIM(status)) != 'resolved'
        UNION ALL
        SELECT req_id, NULL AS req_type, resource_type, loc_id, status FROM Instant_Request
        WHERE LOWER(TRIM(status)) != 'resolved'
        ORDER BY req_id DESC
    ";
    
    $result = $conn->query($sql);
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * Fetch resources list
 */
function getResources($conn) {
    $result = $conn->query("SELECT * FROM resource");
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * Fetch relief team details
 */
function getReliefTeams($conn) {
    $sql = "
        SELECT *
        FROM relief_team
    ";
    
    $result = $conn->query($sql);
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}