<?php

function getMyRequests($conn, $affected_people_id) {
    $sql = "
        SELECT 
            lr.req_id,
            lr.req_name,
            lr.req_type,
            lr.resource_type,
            lr.resource_count,
            lr.no_of_affected_people,
            lr.description,
            lr.contact_number,
            lr.priority_level,
            lr.created_at,
            lr.status,
            COALESCE(l.district, l.city, 'Unknown Location') as location
        FROM Logged_Request lr
        LEFT JOIN Location l ON lr.loc_id = l.loc_id
        WHERE lr.affected_people_id = ?
        ORDER BY lr.created_at DESC
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $affected_people_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
    return $requests;
}

function getAssignedResources($conn, $affected_people_id) {
    $sql = "
        SELECT 
            a.assignment_id,
            a.status,
            a.assigned_date,
            a.description as assignment_desc,
            r.resource_name,
            r.resource_type,
            r.resource_count,
            r.description as resource_desc,
            CONCAT(v.first_name, ' ', v.last_name) as volunteer_name,
            v.contact_no as volunteer_contact
        FROM assignments a
        LEFT JOIN resource r ON a.resource_id = r.resource_id
        LEFT JOIN volunteer v ON a.volunteer_id = v.volunteer_id
        WHERE a.affected_people_id = ? AND a.assignment_type = 'Volunteer_Resource'
        ORDER BY a.assigned_date DESC
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $affected_people_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $resources = [];
    while ($row = $result->fetch_assoc()) {
        $resources[] = $row;
    }
    return $resources;
}

function getActivityLogs($conn, $affected_people_id) {
    $sql = "
        SELECT 
            log_id,
            log_type,
            message,
            created_by,
            created_at
        FROM activity_logs
        WHERE affected_people_id = ?
        ORDER BY created_at DESC
        LIMIT 20
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $affected_people_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $logs = [];
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
    return $logs;
}

function getAffectedPersonProfile($conn, $affected_people_id) {
    $sql = "
        SELECT 
            ap.*,
            u.username,
            l.district,
            l.city,
            l.street,
            l.home_no,
            l.latitude,
            l.longitude
        FROM affected_people ap
        LEFT JOIN users u ON ap.affected_people_id = u.user_id
        LEFT JOIN Location l ON ap.affected_people_id = l.user_id
        WHERE ap.affected_people_id = ?
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $affected_people_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

?>
