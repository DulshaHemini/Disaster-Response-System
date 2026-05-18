<?php

/**
 * Fetch pending tasks (Assigned / Allocated) for a specific volunteer.
 */
function getPendingTasks($conn, $volunteer_id) {
    $sql = "
        SELECT 
            a.assignment_id as id, 
            a.status, 
            a.assigned_date as createdAt,
            COALESCE(ir.req_name, lr.req_name, 'Resource Delivery') as title,
            COALESCE(a.description, lr.description, ir.req_name, 'No description provided') as description,
            COALESCE(l1.district, l2.district, l3.district, 'Unknown Location') as location
        FROM assignments a
        LEFT JOIN Instant_Request ir ON a.request_id = ir.req_id
        LEFT JOIN Logged_Request lr ON a.request_id = lr.req_id
        LEFT JOIN resource r ON a.resource_id = r.resource_id
        LEFT JOIN affected_people ap ON a.affected_people_id = ap.affected_people_id
        LEFT JOIN Location l1 ON ir.loc_id = l1.loc_id
        LEFT JOIN Location l2 ON lr.loc_id = l2.loc_id
        LEFT JOIN Location l3 ON ap.affected_people_id = l3.user_id
        WHERE a.volunteer_id = ? AND a.status IN ('Assigned', 'Allocated') AND a.assignment_type = 'Volunteer_Resource'
    ";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $volunteer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        $stmt->close();
        return $tasks;
    }
    return [];
}

/**
 * Fetch active or completed tasks (Doing / Received / Done) for a volunteer.
 */
function getActiveTasks($conn, $volunteer_id) {
    $sql = "
        SELECT 
            a.assignment_id as id, 
            a.status, 
            a.assigned_date as acceptedAt,
            a.assigned_date as completedAt,
            COALESCE(ir.req_name, lr.req_name, 'Resource Delivery') as title,
            COALESCE(a.description, lr.description, ir.req_name, 'No description provided') as description,
            COALESCE(l1.district, l2.district, l3.district, 'Unknown Location') as location
        FROM assignments a
        LEFT JOIN Instant_Request ir ON a.request_id = ir.req_id
        LEFT JOIN Logged_Request lr ON a.request_id = lr.req_id
        LEFT JOIN resource r ON a.resource_id = r.resource_id
        LEFT JOIN affected_people ap ON a.affected_people_id = ap.affected_people_id
        LEFT JOIN Location l1 ON ir.loc_id = l1.loc_id
        LEFT JOIN Location l2 ON lr.loc_id = l2.loc_id
        LEFT JOIN Location l3 ON ap.affected_people_id = l3.user_id
        WHERE a.volunteer_id = ? AND a.status IN ('Doing', 'Received', 'Done') AND a.assignment_type = 'Volunteer_Resource'
        ORDER BY a.status DESC, a.assigned_date DESC
    ";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $volunteer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $row['status'] = strtolower($row['status']);
            $tasks[] = $row;
        }
        $stmt->close();
        return $tasks;
    }
    return [];
}

/**
 * Accept a pending task (transition status to 'Doing').
 */
function acceptTask($conn, $assignment_id, $volunteer_id) {
    $sql = "UPDATE assignments SET status = 'Doing' WHERE assignment_id = ? AND volunteer_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $assignment_id, $volunteer_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
    return false;
}

/**
 * Reject a task (deletes assignment and resets request status to 'Pending').
 */
function rejectTask($conn, $assignment_id, $volunteer_id) {
    $sql_find = "SELECT request_id FROM assignments WHERE assignment_id = ? AND volunteer_id = ?";
    $stmt_find = $conn->prepare($sql_find);
    if ($stmt_find) {
        $stmt_find->bind_param("ii", $assignment_id, $volunteer_id);
        $stmt_find->execute();
        $result = $stmt_find->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $request_id = $row['request_id'];
            $stmt_find->close();
            
            // Delete the assignment
            $sql_del = "DELETE FROM assignments WHERE assignment_id = ?";
            $stmt_del = $conn->prepare($sql_del);
            if ($stmt_del) {
                $stmt_del->bind_param("i", $assignment_id);
                $stmt_del->execute();
                $stmt_del->close();
            }
            
            // Reset request status
            $conn->query("UPDATE Instant_Request SET status = 'Pending' WHERE req_id = $request_id");
            $conn->query("UPDATE Logged_Request SET status = 'Pending' WHERE req_id = $request_id");
            return true;
        }
        $stmt_find->close();
    }
    return false;
}

/**
 * Mark an active task as complete (Done).
 */
function markTaskDone($conn, $assignment_id, $volunteer_id) {
    $sql = "UPDATE assignments SET status = 'Done' WHERE assignment_id = ? AND volunteer_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $assignment_id, $volunteer_id);
        $success = $stmt->execute();
        $stmt->close();
        
        if ($success) {
            // Also update the original request status to Done
            $sql_find = "SELECT request_id FROM assignments WHERE assignment_id = ?";
            $stmt_find = $conn->prepare($sql_find);
            if ($stmt_find) {
                $stmt_find->bind_param("i", $assignment_id);
                $stmt_find->execute();
                $result = $stmt_find->get_result();
                
                if ($row = $result->fetch_assoc()) {
                    $request_id = $row['request_id'];
                    $conn->query("UPDATE Instant_Request SET status = 'Done' WHERE req_id = $request_id");
                    $conn->query("UPDATE Logged_Request SET status = 'Done' WHERE req_id = $request_id");
                }
                $stmt_find->close();
            }
            return true;
        }
    }
    return false;
}

/**
 * Count affected people in system.
 */
function getAffectedPeopleCount($conn) {
    $sql = "SELECT COUNT(*) as total FROM affected_people";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        return (int)$row['total'];
    }
    return 0;
}

/**
 * Fetch volunteer details & location for profile display.
 */
function getVolunteerProfile($conn, $volunteer_id) {
    $sql = "
        SELECT v.*, u.username, l.district, l.city, l.street, l.home_no, l.latitude, l.longitude
        FROM volunteer v
        INNER JOIN users u ON v.volunteer_id = u.user_id
        LEFT JOIN Location l ON v.volunteer_id = l.user_id
        WHERE v.volunteer_id = ?
    ";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $volunteer_id);
        $stmt->execute();
        $profile = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $profile;
    }
    return null;
}
