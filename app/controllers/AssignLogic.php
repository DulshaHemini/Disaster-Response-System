<?php

// ======================================
// DATABASE CONNECTION
// ======================================

$conn = new mysqli("localhost", "root", "", "DRCS", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ======================================
// HAVERSINE FUNCTION
// ======================================

function getDistance($lat1, $lon1, $lat2, $lon2)
{
    $earth_radius = 6371; // KM
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earth_radius * $c;
}

// ======================================
// FETCH PENDING REQUESTS
// ======================================
$request_sql = "
    SELECT 
        r.req_id, r.resource_type, r.resource_count, r.status, 
        l.latitude, l.longitude, 'Instant_Request' AS source_table
    FROM Instant_Request r
    JOIN Location l ON r.loc_id = l.loc_id
    WHERE r.status = 'Pending'

    UNION ALL

    SELECT 
        r.req_id, r.resource_type, r.resource_count, r.status, 
        l.latitude, l.longitude, 'Logged_Request' AS source_table
    FROM Logged_Request r
    JOIN Location l ON r.loc_id = l.loc_id
    WHERE r.status = 'Pending'
";

$request_result = $conn->query($request_sql);
$requests = [];
if ($request_result) {
    while ($row = $request_result->fetch_assoc()) {
        $requests[] = $row;
    }
}

// ======================================
// FETCH VOLUNTEERS
// ======================================
$volunteer_sql = "
    SELECT 
        r.resource_id, v.volunteer_id, r.resource_type, r.resource_count, 
        l.latitude, l.longitude
    FROM resource r
    JOIN volunteer v ON r.volunteer_id = v.volunteer_id
    JOIN Location l ON v.volunteer_id = l.user_id
    WHERE v.availability_status = 'available'
";
$volunteer_result = $conn->query($volunteer_sql);
$volunteers = [];
if ($volunteer_result) {
    while ($row = $volunteer_result->fetch_assoc()) {
        $volunteers[] = $row;
    }
}

// ======================================
// FETCH RELIEF TEAMS
// ======================================
$team_sql = "
    SELECT 
        rt.relief_team_id, rt.team_name, rt.specialization, rt.availability_status, 
        l.latitude, l.longitude
    FROM relief_team rt
    JOIN Location l ON rt.relief_team_id = l.user_id
    WHERE rt.availability_status = 'available'
";
$team_result = $conn->query($team_sql);
$reliefTeams = [];
if ($team_result) {
    while ($row = $team_result->fetch_assoc()) {
        $reliefTeams[] = $row;
    }
}

// ======================================
// MATCHING LOGIC & ALLOCATION
// ======================================

echo "<h2>Allocation Results</h2>";

foreach ($requests as $request) {
    echo "<hr>";
    $minimumDistance = PHP_FLOAT_MAX;

    // -----------------------------------
    // BRANCH A: RELIEF TEAM (RESCUE)
    // -----------------------------------
    if ($request['resource_type'] == 'rescue') {
        $bestTeam = null;

        foreach ($reliefTeams as $team) {
            $spec = strtolower($team['specialization']);
            if (strpos($spec, 'rescue') === false && strpos($spec, 'emergency') === false) {
                continue; // Not a rescue team
            }

            $distance = getDistance($request['latitude'], $request['longitude'], $team['latitude'], $team['longitude']);

            if ($distance < $minimumDistance) {
                $minimumDistance = $distance;
                $bestTeam = $team;
            }
        }

        if ($bestTeam != null) {
            echo "<b>Request ID :</b> {$request['req_id']} (Rescue)<br>";
            echo "<b>Allocated Relief Team ID :</b> {$bestTeam['relief_team_id']} ({$bestTeam['team_name']})<br>";
            echo "<b>Distance :</b> " . round($minimumDistance, 2) . " KM<br>";

            // EXECUTE INSERT
            $insert_sql = "INSERT INTO assignments (assignment_type, relief_team_id, request_id, description, status) 
                           VALUES ('Relief_Team_Task', {$bestTeam['relief_team_id']}, {$request['req_id']}, 'Auto-assigned by system based on proximity', 'Assigned')";
            
            if ($conn->query($insert_sql)) {
                echo "<span style='color:green;'>✓ Successfully inserted into assignments.</span><br>";
                
                // EXECUTE UPDATE
                $update_sql = "UPDATE {$request['source_table']} SET status = 'Assigned' WHERE req_id = {$request['req_id']}";
                if ($conn->query($update_sql)) {
                    echo "<span style='color:green;'>✓ Successfully updated {$request['source_table']} status.</span><br>";
                }
            } else {
                echo "<span style='color:red;'>✗ Database Error: " . $conn->error . "</span><br>";
            }

        } else {
            echo "No suitable Relief Team found for Request ID {$request['req_id']}<br>";
        }
    } 
    // -----------------------------------
    // BRANCH B: VOLUNTEER (RESOURCES)
    // -----------------------------------
    else {
        $bestVolunteer = null;

        foreach ($volunteers as $volunteer) {
            if ($request['resource_type'] != $volunteer['resource_type']) {
                continue;
            }
            if ($volunteer['resource_count'] < $request['resource_count']) {
                continue;
            }

            $distance = getDistance($request['latitude'], $request['longitude'], $volunteer['latitude'], $volunteer['longitude']);

            if ($distance < $minimumDistance) {
                $minimumDistance = $distance;
                $bestVolunteer = $volunteer;
            }
        }

        if ($bestVolunteer != null) {
            echo "<b>Request ID :</b> {$request['req_id']}<br>";
            echo "<b>Volunteer ID :</b> {$bestVolunteer['volunteer_id']}<br>";
            echo "<b>Resource Type :</b> {$request['resource_type']}<br>";
            echo "<b>Distance :</b> " . round($minimumDistance, 2) . " KM<br>";

            // EXECUTE INSERT
            $insert_sql = "INSERT INTO assignments (assignment_type, volunteer_id, request_id, resource_id, status) 
                           VALUES ('Volunteer_Resource', {$bestVolunteer['volunteer_id']}, {$request['req_id']}, {$bestVolunteer['resource_id']}, 'Assigned')";
            
            if ($conn->query($insert_sql)) {
                echo "<span style='color:green;'>✓ Successfully inserted into assignments.</span><br>";
                
                // EXECUTE UPDATE
                $update_sql = "UPDATE {$request['source_table']} SET status = 'Assigned' WHERE req_id = {$request['req_id']}";
                if ($conn->query($update_sql)) {
                    echo "<span style='color:green;'>✓ Successfully updated {$request['source_table']} status.</span><br>";
                }
            } else {
                echo "<span style='color:red;'>✗ Database Error: " . $conn->error . "</span><br>";
            }
        } else {
            echo "No suitable volunteer found for Request ID {$request['req_id']}<br>";
        }
    }
}

$conn->close();
?>
