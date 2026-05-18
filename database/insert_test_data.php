<?php

// ================= DATABASE CONNECTION =================
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drcs";
$port = 3307;

// Create connection
$conn = new mysqli($servername, $username, $password, "", 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Disable foreign key checks temporarily
$conn->query("SET FOREIGN_KEY_CHECKS = 0");


// ================= 1. USERS =================
$users = [
    [1, 'admin_main', 'admin123', 'admin'],
    [2, 'kamal_p', 'user123', 'affected_people'],
    [3, 'nimal_v', 'user123', 'volunteer'],
    [4, 'samantha_w', 'user123', 'affected_people'],
    [5, 'priyani_j', 'user123', 'affected_people'],
    [6, 'sunil_r', 'user123', 'affected_people'],
    [7, 'kusum_d', 'user123', 'affected_people'],
    [8, 'mahesh_g', 'user123', 'affected_people'],
    [9, 'rani_p', 'user123', 'affected_people'],
    [10, 'chamara_s', 'user123', 'affected_people'],
    [11, 'deepani_l', 'user123', 'affected_people'],
    [12, 'ruwan_m', 'user123', 'affected_people'],
    [13, 'lasitha_f', 'user123', 'volunteer'],
    [14, 'menaka_s', 'user123', 'volunteer'],
    [15, 'asanka_h', 'user123', 'volunteer'],
    [16, 'colombo_rapid', 'team123', 'relief_team'],
    [17, 'kandy_sarath', 'team123', 'relief_team'],
    [18, 'galle_navy', 'team123', 'relief_team']
];

$stmt = $conn->prepare("INSERT INTO users (user_id, username, password, user_role) VALUES (?, ?, ?, ?)");

foreach ($users as $user) {
    $stmt->bind_param("isss", $user[0], $user[1], $user[2], $user[3]);
    $stmt->execute();
}

echo "Users inserted successfully.<br>";


// ================= 2. ADMIN =================
$admin = [1, 'System', 'Admin', 'Male', 35, 'admin@drcs.lk', '0710000000'];

$stmt = $conn->prepare("
    INSERT INTO admin
    (user_id, first_name, last_name, gender, age, email, contact_no)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "isssiss",
    $admin[0],
    $admin[1],
    $admin[2],
    $admin[3],
    $admin[4],
    $admin[5],
    $admin[6]
);

$stmt->execute();

echo "Admin inserted successfully.<br>";


// ================= 3. AFFECTED PEOPLE =================
$affected_people = [
    [2, 'Kamal', 'Perera', 45, 4, 'Male', '801234567V', '0771112223'],
    [4, 'Samantha', 'Weerasinghe', 38, 5, 'Male', '831456789V', '0772223334'],
    [5, 'Priyani', 'Jayawardena', 52, 3, 'Female', '751234568V', '0773334445'],
    [6, 'Sunil', 'Rathnayake', 29, 2, 'Male', '921234569V', '0774445556'],
    [7, 'Kusum', 'Dissanayake', 61, 6, 'Female', '621234560V', '0775556667'],
    [8, 'Mahesh', 'Gunasekara', 34, 4, 'Male', '881234561V', '0776667778'],
    [9, 'Rani', 'Perera', 47, 3, 'Female', '761234562V', '0777778889'],
    [10, 'Chamara', 'Silva', 41, 5, 'Male', '821234563V', '0778889990'],
    [11, 'Deepani', 'Liyanage', 33, 2, 'Female', '901234564V', '0779990001'],
    [12, 'Ruwan', 'Mendis', 55, 4, 'Male', '681234565V', '0770001112']
];

$stmt = $conn->prepare("
    INSERT INTO affected_people
    (affected_people_id, first_name, last_name, age,
    no_of_family_members, gender, nic, contact_no)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

foreach ($affected_people as $person) {
    $stmt->bind_param(
        "issiisss",
        $person[0],
        $person[1],
        $person[2],
        $person[3],
        $person[4],
        $person[5],
        $person[6],
        $person[7]
    );

    $stmt->execute();
}

echo "Affected people inserted successfully.<br>";


// ================= 4. VOLUNTEERS =================
$volunteers = [
    [3, 'Nimal', 'Silva', '901234567V', 'Male', '0779998887', 30, 'available', 'Red Cross'],
    [13, 'Lasitha', 'Fernando', '851234568V', 'Male', '0778887776', 35, 'available', 'Lions Club'],
    [14, 'Menaka', 'Senanayake', '881234569V', 'Female', '0777776665', 28, 'available', 'Rotary Club'],
    [15, 'Asanka', 'Herath', '931234570V', 'Male', '0776665554', 26, 'available', 'St. John Ambulance']
];

$stmt = $conn->prepare("
    INSERT INTO volunteer
    (volunteer_id, first_name, last_name, nic,
    gender, contact_no, age, availability_status, organization_name)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

foreach ($volunteers as $volunteer) {

    $stmt->bind_param(
        "isssssiss",
        $volunteer[0],
        $volunteer[1],
        $volunteer[2],
        $volunteer[3],
        $volunteer[4],
        $volunteer[5],
        $volunteer[6],
        $volunteer[7],
        $volunteer[8]
    );

    $stmt->execute();
}

echo "Volunteers inserted successfully.<br>";


// ================= 5. RELIEF TEAMS =================
$relief_teams = [
    [18, 'Galle Navy Rescue', 'navy@drcs.lk', '0912223334', 'Flood Rescue', 15, 'Rescue Boat', 'NAVY-001', 'available'],
    [16, 'Colombo Rapid Response', 'rapid@drcs.lk', '0112345678', 'Emergency Response', 20, 'Ambulance & Truck', 'CRR-002', 'available'],
    [17, 'Kandy Sarath Brigade', 'sarath@drcs.lk', '0812345678', 'Emergency Response', 12, '4x4 Vehicles', 'KSB-003', 'available']
];

$stmt = $conn->prepare("
    INSERT INTO relief_team
    (relief_team_id, team_name, email, contact_no,
    specialization, no_of_members, vehicle_type,
    vehicle_number, availability_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

foreach ($relief_teams as $team) {

    $stmt->bind_param(
        "issssisss",
        $team[0],
        $team[1],
        $team[2],
        $team[3],
        $team[4],
        $team[5],
        $team[6],
        $team[7],
        $team[8]
    );

    $stmt->execute();
}

echo "Relief teams inserted successfully.<br>";


// ================= 6. LOCATIONS =================
$locations = [
    [101, 2, 6.0535, 80.2210, 'Galle', 'Galle South', 'Main St', '10A'],
    [102, 3, 6.9271, 79.8612, 'Colombo', 'Colombo 03', 'Galle Rd', '55'],
    [103, 18, 6.0333, 80.2167, 'Galle', 'Galle Fort', 'Navy Base', '1']
];

$stmt = $conn->prepare("
    INSERT INTO location
    (loc_id, user_id, latitude, longitude,
    district, city, street, home_no)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

foreach ($locations as $location) {

    $stmt->bind_param(
        "iiddssss",
        $location[0],
        $location[1],
        $location[2],
        $location[3],
        $location[4],
        $location[5],
        $location[6],
        $location[7]
    );

    $stmt->execute();
}

echo "Locations inserted successfully.<br>";


// ================= 7. REQUESTS =================
$requests = [
    [501, 'Instant_Request'],
    [502, 'Logged_Request']
];

$stmt = $conn->prepare("
    INSERT INTO requests
    (request_id, request_type)
    VALUES (?, ?)
");

foreach ($requests as $request) {

    $stmt->bind_param(
        "is",
        $request[0],
        $request[1]
    );

    $stmt->execute();
}

echo "Requests inserted successfully.<br>";


// ================= 8. INSTANT REQUEST =================
$instant_requests = [
    [501, 2, 101, 'Kamal Perera', 'Trapped in flood', 'rescue', 4, '0771112223', 'Pending']
];

$stmt = $conn->prepare("
    INSERT INTO instant_request
    (req_id, user_id, loc_id, full_name,
    req_name, resource_type, resource_count,
    contact_number, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

foreach ($instant_requests as $ir) {

    $stmt->bind_param(
        "iiisssiss",
        $ir[0],
        $ir[1],
        $ir[2],
        $ir[3],
        $ir[4],
        $ir[5],
        $ir[6],
        $ir[7],
        $ir[8]
    );

    $stmt->execute();
}

echo "Instant requests inserted successfully.<br>";


// ================= 9. LOGGED REQUEST =================
$logged_requests = [
    [502, 2, 101, 2, 'Need drinking water', 'flood', 'water', 20, 4, 'No drinking water for 2 days', '0771112223', 'high', 'Pending']
];

$stmt = $conn->prepare("
    INSERT INTO logged_request
    (req_id, affected_people_id, loc_id, user_id,
    req_name, req_type, resource_type,
    resource_count, no_of_affected_people,
    description, contact_number,
    priority_level, status)

    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

foreach ($logged_requests as $lr) {

    $stmt->bind_param(
        "iiiisssiissss",
        $lr[0],
        $lr[1],
        $lr[2],
        $lr[3],
        $lr[4],
        $lr[5],
        $lr[6],
        $lr[7],
        $lr[8],
        $lr[9],
        $lr[10],
        $lr[11],
        $lr[12]
    );

    $stmt->execute();
}

echo "Logged requests inserted successfully.<br>";


// ================= 10. RESOURCES =================
$resources = [
    [801, 3, 'Bottled Water', 'water', 100, '5L water bottles ready for distribution'],
    [802, 13, 'Rice Packets', 'food', 50, '5kg rice packets'],
    [803, 14, 'Medical Kits', 'medicine', 25, 'Basic first aid kits'],
    [804, 15, 'Life Jackets', 'rescue', 20, 'Adult life jackets']
];

$stmt = $conn->prepare("
    INSERT INTO resource
    (resource_id, volunteer_id, resource_name,
    resource_type, resource_count, description)
    VALUES (?, ?, ?, ?, ?, ?)
");

foreach ($resources as $resource) {

    $stmt->bind_param(
        "iissis",
        $resource[0],
        $resource[1],
        $resource[2],
        $resource[3],
        $resource[4],
        $resource[5]
    );

    $stmt->execute();
}

echo "Resources inserted successfully.<br>";


// ================= 11. ASSIGNMENTS =================
$assignments = [
    ['Relief_Team_Task', null, 18, 501, null, 2, 'Evacuate family from flood zone', 'Assigned'],
    ['Volunteer_Resource', 3, null, 502, 801, 2, 'Deliver water bottles', 'Allocated']
];

$stmt = $conn->prepare("
    INSERT INTO assignments
    (assignment_type, volunteer_id, relief_team_id,
    request_id, resource_id, affected_people_id,
    description, status)

    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

foreach ($assignments as $assignment) {

    $stmt->bind_param(
        "siiiisss",
        $assignment[0],
        $assignment[1],
        $assignment[2],
        $assignment[3],
        $assignment[4],
        $assignment[5],
        $assignment[6],
        $assignment[7]
    );

    $stmt->execute();
}

echo "Assignments inserted successfully.<br>";


// ================= ENABLE FOREIGN KEYS =================
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "<br><b>All data inserted successfully!</b><br>";
echo "Admin Login: admin_main<br>";
echo "Admin Password: admin123<br>";

$conn->close();

?>