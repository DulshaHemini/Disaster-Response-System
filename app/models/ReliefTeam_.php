<?php

function getPendingTasks($conn, $team_id) {
    $sql = "
        SELECT 
            a.assignment_id as id, 
            a.status, 
            a.assigned_date as createdAt,
            COALESCE(ir.req_name, lr.req_name) as title,
            COALESCE(a.description, lr.description, ir.req_name) as description,
            COALESCE(l1.district, l2.district, l1.city, l2.city, 'Unknown Location') as location
        FROM assignments a
        LEFT JOIN Instant_Request ir ON a.request_id = ir.req_id
        LEFT JOIN Location l1 ON ir.loc_id = l1.loc_id
        LEFT JOIN Logged_Request lr ON a.request_id = lr.req_id
        LEFT JOIN Location l2 ON lr.loc_id = l2.loc_id
        WHERE a.relief_team_id = ? AND a.status = 'Assigned' AND a.assignment_type = 'Relief_Team_Task'
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $team_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
    return $tasks;
}

function getActiveTasks($conn, $team_id) {
    $sql = "
        SELECT 
            a.assignment_id as id, 
            a.status, 
            a.assigned_date as acceptedAt,
            a.assigned_date as completedAt,
            COALESCE(ir.req_name, lr.req_name) as title,
            COALESCE(a.description, lr.description, ir.req_name) as description,
            COALESCE(l1.district, l2.district, l1.city, l2.city, 'Unknown Location') as location
        FROM assignments a
        LEFT JOIN Instant_Request ir ON a.request_id = ir.req_id
        LEFT JOIN Location l1 ON ir.loc_id = l1.loc_id
        LEFT JOIN Logged_Request lr ON a.request_id = lr.req_id
        LEFT JOIN Location l2 ON lr.loc_id = l2.loc_id
        WHERE a.relief_team_id = ? AND a.status IN ('Doing', 'Done') AND a.assignment_type = 'Relief_Team_Task'
        ORDER BY a.status DESC, a.assigned_date DESC
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $team_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        // Lowercase the status so it matches CSS classes (doing, done)
        $row['status'] = strtolower($row['status']);
        $tasks[] = $row;
    }
    return $tasks;
}

function acceptTask($conn, $assignment_id, $team_id) {
    // We also check team_id for security to ensure they own the task
    $sql = "UPDATE assignments SET status = 'Doing' WHERE assignment_id = ? AND relief_team_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $assignment_id, $team_id);
    return $stmt->execute();
}

function rejectTask($conn, $assignment_id, $team_id) {
    // Find the request_id first to reset its status
    $sql_find = "SELECT request_id FROM assignments WHERE assignment_id = ? AND relief_team_id = ?";
    $stmt_find = $conn->prepare($sql_find);
    $stmt_find->bind_param("ii", $assignment_id, $team_id);
    $stmt_find->execute();
    $result = $stmt_find->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $request_id = $row['request_id'];
        
        // Delete the assignment
        $sql_del = "DELETE FROM assignments WHERE assignment_id = ?";
        $stmt_del = $conn->prepare($sql_del);
        $stmt_del->bind_param("i", $assignment_id);
        $stmt_del->execute();
        
        // Reset the original request status back to Pending
        $conn->query("UPDATE Instant_Request SET status = 'Pending' WHERE req_id = $request_id");
        $conn->query("UPDATE Logged_Request SET status = 'Pending' WHERE req_id = $request_id");
        return true;
    }
    return false;
}

function markTaskDone($conn, $assignment_id, $team_id) {
    $sql = "UPDATE assignments SET status = 'Done' WHERE assignment_id = ? AND relief_team_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $assignment_id, $team_id);
    
    if ($stmt->execute()) {
        // Also update the original request status to Done
        $sql_find = "SELECT request_id FROM assignments WHERE assignment_id = ?";
        $stmt_find = $conn->prepare($sql_find);
        $stmt_find->bind_param("i", $assignment_id);
        $stmt_find->execute();
        $result = $stmt_find->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $request_id = $row['request_id'];
            $conn->query("UPDATE Instant_Request SET status = 'Done' WHERE req_id = $request_id");
            $conn->query("UPDATE Logged_Request SET status = 'Done' WHERE req_id = $request_id");
        }
        return true;
    }
    return false;
}

function getAffectedPeopleCount($conn) {
    $sql = "SELECT COUNT(*) as total FROM affected_people";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
        return (int)$row['total'];
    }
    return 0;
}

function getReliefTeamProfile($conn, $team_id) {
    $sql = "
        SELECT rt.*, l.district, l.city, l.street, l.home_no, l.latitude, l.longitude
        FROM relief_team rt
        LEFT JOIN Location l ON rt.relief_team_id = l.user_id
        WHERE rt.relief_team_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $team_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


?>
