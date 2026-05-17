<?php
// Database connection
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

// Disable foreign key checks temporarily for bulk insert
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// 1. USERS
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
    [17, 'kandy_sarath', 'team123', 'relief_team']
];

foreach ($users as $user) {
    $stmt = $conn->prepare("INSERT INTO users (user_id, username, password, user_role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user[0], $user[1], $user[2], $user[3]);
    $stmt->execute();
}
echo "Users inserted successfully.\n";

// 2. ADMIN
$admin = [1, 'System', 'Admin', 'Male', 35, 'admin@drcs.lk', '0710000000'];
$stmt = $conn->prepare("INSERT INTO admin (user_id, first_name, last_name, gender, age, email, contact_no) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issisis", $admin[0], $admin[1], $admin[2], $admin[3], $admin[4], $admin[5], $admin[6]);
$stmt->execute();
echo "Admin inserted successfully.\n";

// 3. AFFECTED PEOPLE (10 people)
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

foreach ($affected_people as $person) {
    $stmt = $conn->prepare("INSERT INTO affected_people (affected_people_id, first_name, last_name, age, no_of_family_members, gender, nic, contact_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issiisss", $person[0], $person[1], $person[2], $person[3], $person[4], $person[5], $person[6], $person[7]);
    $stmt->execute();
}
echo "Affected people inserted successfully.\n";

// 4. VOLUNTEER (3 people)
$volunteers = [
    [3, 'Nimal', 'Silva', '901234567V', 'Male', '0779998887', 30, 'available', 'Red Cross'],
    [13, 'Lasitha', 'Fernando', '851234568V', 'Male', '0778887776', 35, 'available', 'Lions Club'],
    [14, 'Menaka', 'Senanayake', '881234569V', 'Female', '0777776665', 28, 'available', 'Rotary Club'],
    [15, 'Asanka', 'Herath', '931234570V', 'Male', '0776665554', 26, 'available', 'St. John Ambulance']
];

foreach ($volunteers as $volunteer) {
    $stmt = $conn->prepare("INSERT INTO volunteer (volunteer_id, first_name, last_name, nic, gender, contact_no, age, availability_status, organization_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssiss", $volunteer[0], $volunteer[1], $volunteer[2], $volunteer[3], $volunteer[4], $volunteer[5], $volunteer[6], $volunteer[7], $volunteer[8]);
    $stmt->execute();
}
echo "Volunteers inserted successfully.\n";

// 5. RELIEF TEAM (2 teams)
$relief_teams = [
    [10, 'Galle Navy Rescue', 'navy@drcs.lk', '0912223334', 'Flood Rescue', 15, 'Rescue Boat', 'NAVY-001', 'available'],
    [16, 'Colombo Rapid Response', 'rapid@drcs.lk', '0112345678', 'Multi-hazard Rescue', 20, 'Ambulance & Truck', 'CRR-002', 'available'],
    [17, 'Kandy Sarath Brigade', 'sarath@drcs.lk', '0812345678', 'Landslide Rescue', 12, '4x4 Vehicles', 'KSB-003', 'available']
];

foreach ($relief_teams as $team) {
    $stmt = $conn->prepare("INSERT INTO relief_team (relief_team_id, team_name, email, contact_no, specialization, no_of_members, vehicle_type, vehicle_number, availability_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssisss", $team[0], $team[1], $team[2], $team[3], $team[4], $team[5], $team[6], $team[7], $team[8]);
    $stmt->execute();
}
echo "Relief teams inserted successfully.\n";

// 6. LOCATION
$locations = [
    [101, 2, 6.0535, 80.2210, 'Galle', 'Galle South', 'Main St', '10A'],
    [102, 3, 6.9271, 79.8612, 'Colombo', 'Colombo 03', 'Galle Rd', '55'],
    [103, 10, 6.0333, 80.2167, 'Galle', 'Galle Fort', 'Navy Base', '1'],
    [104, 4, 6.0650, 80.2150, 'Galle', 'Galle North', 'Church St', '25'],
    [105, 5, 6.0800, 80.2100, 'Galle', 'Dadalla', 'Beach Rd', '8'],
    [106, 6, 6.0450, 80.2250, 'Galle', 'Wakwella', 'Temple Rd', '12'],
    [107, 7, 6.0700, 80.2300, 'Galle', 'Katugoda', 'Station Rd', '45A'],
    [108, 8, 6.0900, 80.2400, 'Galle', 'Boosa', 'Galle-Matara Rd', '33'],
    [109, 9, 6.0550, 80.2180, 'Galle', 'Galle Fort', 'Lighthouse St', '7'],
    [110, 10, 6.0600, 80.2220, 'Galle', 'Hikkaduwa', 'Galle Rd', '120'],
    [111, 11, 6.0400, 80.2080, 'Galle', 'Ahangama', 'Kataluwa Rd', '3'],
    [112, 12, 6.0750, 80.2350, 'Galle', 'Devinuwara', 'Main St', '67'],
    [113, 13, 6.0850, 80.2450, 'Galle', 'Koggala', 'Airport Rd', '22'],
    [114, 14, 7.2900, 80.6300, 'Kandy', 'Kandy Central', 'Hill St', '5'],
    [115, 15, 6.9500, 79.9500, 'Colombo', 'Colombo 05', 'Kirulapone', '18'],
    [116, 16, 6.9000, 79.8800, 'Colombo', 'Colombo 01', 'Fort', '2']
];

foreach ($locations as $location) {
    $stmt = $conn->prepare("INSERT INTO Location (loc_id, user_id, latitude, longitude, district, city, street, home_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiddssss", $location[0], $location[1], $location[2], $location[3], $location[4], $location[5], $location[6], $location[7]);
    $stmt->execute();
}
echo "Locations inserted successfully.\n";

// 7. REQUESTS PARENT TABLE
$requests = [
    [501, 'Instant_Request'],
    [502, 'Logged_Request'],
    [503, 'Instant_Request'],
    [504, 'Instant_Request'],
    [505, 'Logged_Request'],
    [506, 'Logged_Request'],
    [507, 'Instant_Request'],
    [508, 'Logged_Request'],
    [509, 'Instant_Request'],
    [510, 'Logged_Request'],
    [511, 'Instant_Request'],
    [512, 'Logged_Request']
];

foreach ($requests as $request) {
    $stmt = $conn->prepare("INSERT INTO requests (request_id, request_type) VALUES (?, ?)");
    $stmt->bind_param("is", $request[0], $request[1]);
    $stmt->execute();
}
echo "Requests inserted successfully.\n";

// 8. INSTANT REQUEST
$instant_requests = [
    [501, 2, 101, 'Kamal Perera', 'Trapped in flood', 'rescue', 4, '0771112223', 'Pending'],
    [503, 6, 106, 'Sunil Rathnayake', 'Medical emergency', 'medical', 1, '0774445556', 'Pending'],
    [504, 8, 108, 'Mahesh Gunasekara', 'Food shortage', 'food', 5, '0776667778', 'Assigned'],
    [507, 10, 110, 'Chamara Silva', 'Shelter needed', 'shelter', 5, '0778889990', 'Pending'],
    [509, 4, 104, 'Samantha Weerasinghe', 'Boat rescue needed', 'rescue', 5, '0772223334', 'Completed'],
    [511, 12, 112, 'Ruwan Mendis', 'Critical medical aid', 'medical', 4, '0770001112', 'Pending']
];

foreach ($instant_requests as $ir) {
    $stmt = $conn->prepare("INSERT INTO Instant_Request (req_id, user_id, loc_id, full_name, req_name, resource_type, resource_count, contact_number, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisssiss", $ir[0], $ir[1], $ir[2], $ir[3], $ir[4], $ir[5], $ir[6], $ir[7], $ir[8]);
    $stmt->execute();
}
echo "Instant requests inserted successfully.\n";

// 9. LOGGED REQUEST
$logged_requests = [
    [502, 2, 101, 2, 'Need drinking water', 'Flood', 'water', 20, 4, 'No drinking water for 2 days', '0771112223', 'high', 'Pending'],
    [505, 5, 105, 5, 'Food packages required', 'Flood', 'food', 30, 3, 'Lost all food supplies', '0773334445', 'urgent', 'Pending'],
    [506, 7, 107, 7, 'Clothing and blankets', 'Flood', 'clothing', 15, 6, 'Lost everything in flood', '0775556667', 'medium', 'Assigned'],
    [508, 9, 109, 9, 'Medical supplies', 'Flood', 'medical', 10, 3, 'Elderly need medication', '0777778889', 'high', 'Pending'],
    [510, 11, 111, 11, 'Rescue boat request', 'Flood', 'rescue', 2, 2, 'Stranded on roof', '0779990001', 'urgent', 'Assigned'],
    [512, 4, 104, 4, 'Sanitation kits', 'Flood', 'hygiene', 25, 5, 'No access to toilets', '0772223334', 'medium', 'Pending']
];

foreach ($logged_requests as $lr) {
    $stmt = $conn->prepare("INSERT INTO Logged_Request (req_id, affected_people_id, loc_id, user_id, req_name, req_type, resource_type, resource_count, no_of_affected_people, description, contact_number, priority_level, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiissiissss", $lr[0], $lr[1], $lr[2], $lr[3], $lr[4], $lr[5], $lr[6], $lr[7], $lr[8], $lr[9], $lr[10], $lr[11], $lr[12]);
    $stmt->execute();
}
echo "Logged requests inserted successfully.\n";

// 10. RESOURCE (Volunteer's supplies)
$resources = [
    [801, 3, 'Bottled Water', 'water', 100, '5L water bottles ready for distribution'],
    [802, 13, 'Rice Packets', 'food', 50, '5kg rice packets'],
    [803, 13, 'Dried Rations', 'food', 40, 'Emergency food packs'],
    [804, 14, 'Medical Kits', 'medical', 25, 'Basic first aid kits'],
    [805, 14, 'Blankets', 'clothing', 60, 'Warm blankets'],
    [806, 15, 'Water Purifiers', 'water', 30, 'Portable water filters'],
    [807, 15, 'Hygiene Kits', 'hygiene', 45, 'Soap, toothpaste, sanitary items'],
    [808, 3, 'Life Jackets', 'rescue', 20, 'Adult life jackets']
];

foreach ($resources as $resource) {
    $stmt = $conn->prepare("INSERT INTO resource (resource_id, volunteer_id, resource_name, resource_type, resource_count, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $resource[0], $resource[1], $resource[2], $resource[3], $resource[4], $resource[5]);
    $stmt->execute();
}
echo "Resources inserted successfully.\n";

// 11. ASSIGNMENTS
$assignments = [
    ['Relief_Team_Task', NULL, 10, 501, NULL, 2, 'Evacuate Kamal Perera family from flood zone', 'Assigned'],
    ['Volunteer_Resource', 3, NULL, 502, 801, 2, 'Deliver 20 water bottles to affected family', 'Allocated'],
    ['Relief_Team_Task', NULL, 16, 503, NULL, 6, 'Medical evacuation for injured person', 'Assigned'],
    ['Volunteer_Resource', 13, NULL, 505, 802, 5, 'Deliver rice packets to Priyani\'s family', 'Allocated'],
    ['Relief_Team_Task', NULL, 17, 506, NULL, 7, 'Distribute blankets and clothing', 'In_Progress'],
    ['Volunteer_Resource', 14, NULL, 508, 804, 9, 'Provide medical supplies', 'Allocated'],
    ['Relief_Team_Task', NULL, 10, 510, NULL, 11, 'Rescue stranded individuals', 'Assigned'],
    ['Volunteer_Resource', 15, NULL, 512, 807, 4, 'Hygiene kit distribution', 'Pending']
];

foreach ($assignments as $assignment) {
    $stmt = $conn->prepare("INSERT INTO assignments (assignment_type, volunteer_id, relief_team_id, request_id, resource_id, affected_people_id, description, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiisss", $assignment[0], $assignment[1], $assignment[2], $assignment[3], $assignment[4], $assignment[5], $assignment[6], $assignment[7]);
    $stmt->execute();
}
echo "Assignments inserted successfully.\n";

// ========== 12. INSERT TRACKER ACTIVITY LOGS ==========
echo "Inserting tracker activity logs for persons...<br>";

$sql = "INSERT INTO activity_logs (affected_people_id, log_type, message, created_by, created_at) VALUES
(6, 'incident_reported', 'Kasun Perera reported trapped in flooded area near Peradeniya Road', 'Emergency Hotline', DATE_SUB(NOW(), INTERVAL 5 HOUR)),
(6, 'alert', 'Heavy rainfall alert issued for Kandy district', 'Meteorological Service', DATE_SUB(NOW(), INTERVAL 285 MINUTE)),
(6, 'team_dispatched', 'Rescue team Alpha dispatched to location', 'Control Center', DATE_SUB(NOW(), INTERVAL 270 MINUTE)),
(6, 'team_arrived', 'Rescue team arrived at scene, assessment in progress', 'Team Lead Alpha', DATE_SUB(NOW(), INTERVAL 4 HOUR)),
(6, 'medical_aid', 'Medical team provided first aid treatment, minor injuries', 'Medical Officer Singh', DATE_SUB(NOW(), INTERVAL 225 MINUTE)),
(6, 'status_update', 'Person transported to Kandy General Hospital for observation', 'Ambulance Crew', DATE_SUB(NOW(), INTERVAL 210 MINUTE)),

(7, 'incident_reported', 'Priyani Silva reported landslide near property, family needs evacuation', 'Local Police Station', DATE_SUB(NOW(), INTERVAL 6 HOUR)),
(7, 'alert', 'Landslide hazard warning issued for Colombo slopes', 'Geological Survey', DATE_SUB(NOW(), INTERVAL 345 MINUTE)),
(7, 'team_dispatched', 'Evacuation team Beta dispatched with rescue vehicles', 'Emergency Operations', DATE_SUB(NOW(), INTERVAL 330 MINUTE)),
(7, 'team_arrived', 'Team arrived and began evacuating family to safe zone', 'Team Lead Beta', DATE_SUB(NOW(), INTERVAL 5 HOUR)),
(7, 'shelter', 'Family relocated to temporary shelter camp', 'Shelter Coordinator', DATE_SUB(NOW(), INTERVAL 270 MINUTE)),
(7, 'food_supply', 'Emergency food rations distributed to family', 'Supply Officer', DATE_SUB(NOW(), INTERVAL 4 HOUR)),
(7, 'status_update', 'Family safe, all members accounted for and sheltered', 'Camp Manager', DATE_SUB(NOW(), INTERVAL 210 MINUTE)),

(8, 'incident_reported', 'Mohamed Rizwan reported flooded house in Anuradhapura with family inside', 'Community Alert', DATE_SUB(NOW(), INTERVAL 7 HOUR)),
(8, 'team_dispatched', 'Aquatic rescue team Gamma dispatched with boats', 'Rescue Coordination', DATE_SUB(NOW(), INTERVAL 405 MINUTE)),
(8, 'team_arrived', 'Rescue boats reached location, extraction in progress', 'Boat Commander', DATE_SUB(NOW(), INTERVAL 375 MINUTE)),
(8, 'medical_aid', 'Family members checked for waterborne illness symptoms', 'Health Worker', DATE_SUB(NOW(), INTERVAL 345 MINUTE)),
(8, 'status_update', 'Family of 6 successfully rescued and transported to hospital', 'Rescue Coordinator', DATE_SUB(NOW(), INTERVAL 5 HOUR)),

(9, 'incident_reported', 'Shanthi Kumar reported heat wave related medical emergency', 'Health Clinic', DATE_SUB(NOW(), INTERVAL 3 HOUR)),
(9, 'alert', 'Heat wave alert with temperatures above 38°C', 'Meteorological Department', DATE_SUB(NOW(), INTERVAL 170 MINUTE)),
(9, 'medical_aid', 'Provided IV hydration and cooling therapy at clinic', 'Dr. Jayawardena', DATE_SUB(NOW(), INTERVAL 150 MINUTE)),
(9, 'status_update', 'Patient stabilized, discharged with heat safety guidelines', 'Medical Officer', DATE_SUB(NOW(), INTERVAL 2 HOUR)),

(10, 'incident_reported', 'Nimal Jayasinghe reported mixed disasters - flood and power outage', 'Emergency Report', DATE_SUB(NOW(), INTERVAL 8 HOUR)),
(10, 'alert', 'Power grid disruption in Gampola area, restoration ongoing', 'Utility Corporation', DATE_SUB(NOW(), INTERVAL 465 MINUTE)),
(10, 'team_dispatched', 'Combined rescue and utility repair teams despatched', 'Joint Command Center', DATE_SUB(NOW(), INTERVAL 450 MINUTE)),
(10, 'shelter', 'Temporary accommodation arranged at school building', 'Municipal Office', DATE_SUB(NOW(), INTERVAL 7 HOUR)),
(10, 'food_supply', 'Cooked meals provided for 5 family members by NGO partners', 'NGO Coordinator', DATE_SUB(NOW(), INTERVAL 390 MINUTE)),
(10, 'team_arrived', 'Power restoration team fixed electrical lines', 'Chief Engineer', DATE_SUB(NOW(), INTERVAL 6 HOUR)),
(10, 'status_update', 'Power restored, family can return home, minor repairs ongoing', 'Supervisor', DATE_SUB(NOW(), INTERVAL 315 MINUTE))";

$conn->query($sql);
echo "Tracker activity logs inserted successfully!<br>";

// Re-enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "\nAll data inserted successfully!\n";
echo "Admin Login: admin_main\n";
echo "Admin Password: admin123\n";
echo "User Password for all other accounts: user123 (or team123 for relief teams)\n";

$conn->close();
?>
