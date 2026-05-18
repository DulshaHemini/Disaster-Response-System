<?php

/**
 * Fetch all resources for a specific volunteer.
 * Maps database columns to the fields expected by the frontend JS.
 */
function getVolunteerResources($conn, $volunteer_id) {
    $resources = [];
    $stmt = $conn->prepare("SELECT resource_id, resource_name, resource_type, resource_count, description FROM resource WHERE volunteer_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $volunteer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $resources[] = [
                'id' => $row['resource_id'],
                'name' => $row['resource_name'],
                'type_id' => $row['resource_type'],
                'type_name' => ucfirst($row['resource_type']),
                'qty' => (int)$row['resource_count'],
                'unit' => 'Units',
                'max' => 0, // 0 max means it will show "Stocked" as long as qty > 0
                'updated' => date('Y-m-d H:i'),
                'notes' => $row['description']
            ];
        }
        $stmt->close();
    }
    return $resources;
}

/**
 * Save a resource (insert if ID is empty, update if ID is provided).
 */
function saveResource($conn, $volunteer_id, $resource_id, $name, $type, $count, $desc) {
    if (empty($resource_id)) {
        // Insert new resource
        $stmt = $conn->prepare("INSERT INTO resource (volunteer_id, resource_name, resource_type, resource_count, description) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("issss", $volunteer_id, $name, $type, $count, $desc);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
    } else {
        // Update existing resource (ensuring it belongs to this volunteer)
        $stmt = $conn->prepare("UPDATE resource SET resource_name = ?, resource_type = ?, resource_count = ?, description = ? WHERE resource_id = ? AND volunteer_id = ?");
        if ($stmt) {
            $stmt->bind_param("sssiii", $name, $type, $count, $desc, $resource_id, $volunteer_id);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
    }
    return false;
}

/**
 * Delete a resource belonging to the volunteer.
 */
function deleteResource($conn, $volunteer_id, $resource_id) {
    $stmt = $conn->prepare("DELETE FROM resource WHERE resource_id = ? AND volunteer_id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $resource_id, $volunteer_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
    return false;
}

/**
 * Get available ENUM resource types mapped to structure expected by JS.
 */
function getResourceTypes() {
    $enum_types = ['food', 'water', 'medicine', 'shelter', 'clothes', 'rescue', 'electricity', 'communication'];
    $types = [];
    foreach ($enum_types as $type) {
        $types[] = [
            'id' => $type,
            'name' => ucfirst($type),
            'default' => 1 // mark as default so front-end hides delete option
        ];
    }
    return $types;
}
