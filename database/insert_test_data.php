<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DRCS";

// Create connection
$conn = new mysqli($servername, $username, $password, "", 3306);

// Check connection
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);

// Select database
$conn->select_db($dbname);

// ========== 1. INSERT USERS (Base users table) ==========
$sql = "INSERT INTO users (username, password, user_role) VALUES
    ('admin1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
    ('admin2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
    ('volunteer1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'volunteer'),
    ('volunteer2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'volunteer'),
    ('volunteer3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'volunteer'),
    ('affected1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'affected_people'),
    ('affected2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'affected_people'),
    ('affected3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'affected_people'),
    ('affected4', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'affected_people'),
    ('affected5', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'affected_people')";
$conn->query($sql);
echo "Users inserted successfully!<br>";

// ========== 2. INSERT ADMIN TABLE ==========
$sql = "INSERT INTO admin (user_id, first_name, last_name, gender, age, email, contact_no) VALUES
    (1, 'John', 'Administrator', 'Male', 35, 'john.admin@drcs.org', '0712345678'),
    (2, 'Sarah', 'Coordinator', 'Female', 29, 'sarah.coord@drcs.org', '0723456789')";
$conn->query($sql);
echo "Admin data inserted successfully!<br>";

// ========== 3. INSERT VOLUNTEER TABLE ==========
$sql = "INSERT INTO volunteer (volunteer_id, first_name, last_name, nic, gender, contact_no, age, availability_status, organization_name) VALUES
    (3, 'Michael', 'Volunteer', '199012345678', 'Male', '0771234567', 34, 'available', 'Red Cross Sri Lanka'),
    (4, 'Emma', 'Rescue', '199112345678', 'Female', '0782345678', 32, 'available', 'World Vision'),
    (5, 'David', 'Helper', '199212345678', 'Male', '0763456789', 30, 'busy', 'Save the Children')";
$conn->query($sql);
echo "Volunteer data inserted successfully!<br>";

// ========== 4. INSERT AFFECTED PEOPLE TABLE ==========
$sql = "INSERT INTO affected_people (affected_people_id, first_name, last_name, age, no_of_family_members, gender, nic, contact_no) VALUES
    (6, 'Kasun', 'Perera', 32, 4, 'Male', '198912345678', '0711111111'),
    (7, 'Priyani', 'Silva', 28, 3, 'Female', '199312345678', '0722222222'),
    (8, 'Mohamed', 'Rizwan', 45, 6, 'Male', '198712345678', '0733333333'),
    (9, 'Shanthi', 'Kumar', 35, 2, 'Female', '199512345678', '0744444444'),
    (10, 'Nimal', 'Jayasinghe', 40, 5, 'Male', '199112345679', '0755555555')";
$conn->query($sql);
echo "Affected people data inserted successfully!<br>";

// ========== 5. INSERT LOCATIONS ==========
$sql = "INSERT INTO Location (user_id, latitude, longitude, district, city, street, home_no) VALUES
    (6, 7.8730540000000000, 80.7717970000000000, 'Kandy', 'Kandy', 'Peradeniya Road', '45'),
    (7, 6.9270790000000000, 79.8612430000000000, 'Colombo', 'Nugegoda', 'High Level Road', '123'),
    (8, 8.3500000000000000, 80.3833330000000000, 'Anuradhapura', 'Anuradhapura', 'Main Street', '78'),
    (9, 6.9344380000000000, 79.8436010000000000, 'Colombo', 'Bambalapitiya', 'Galle Road', '25/2'),
    (10, 7.2905720000000000, 80.6334270000000000, 'Kandy', 'Gampola', 'Colombo Road', '10'),
    (3, 6.9147200000000000, 79.9726900000000000, 'Colombo', 'Colombo', 'Union Place', '5'),
    (4, 7.8730540000000000, 80.7717970000000000, 'Kandy', 'Kandy', 'Hill Street', '12')";
$conn->query($sql);
echo "Location data inserted successfully!<br>";

// ========== 6. INSERT REQUESTS ==========
$sql = "INSERT INTO requests (request_id, request_type) VALUES
    (1, 'Instant_Request'),
    (2, 'Logged_Request'),
    (3, 'Instant_Request'),
    (4, 'Logged_Request'),
    (5, 'Instant_Request'),
    (6, 'Logged_Request'),
    (7, 'Logged_Request')";
$conn->query($sql);
echo "Request data inserted successfully!<br>";

// ========== 7. INSERT INSTANT REQUESTS ==========
$sql = "INSERT INTO Instant_Request (req_id, user_id, loc_id, full_name, req_name, resource_type, resource_count, contact_number, status) VALUES
    (1, 6, 1, 'Kasun Perera', 'Emergency Medical Supplies', 'medicine', 500, '0711111111', 'Pending'),
    (3, 8, 3, 'Mohamed Rizwan', 'Temporary Shelter Setup', 'shelter', 50, '0733333333', 'Assigned'),
    (5, 10, 5, 'Nimal Jayasinghe', 'Urgent Rescue Support', 'rescue', 1, '0755555555', 'In Progress')";
$conn->query($sql);
echo "Instant request data inserted successfully!<br>";

// ========== 8. INSERT LOGGED REQUESTS ==========
$sql = "INSERT INTO Logged_Request (req_id, affected_people_id, loc_id, user_id, req_name, req_type, resource_type, resource_count, no_of_affected_people, description, contact_number, priority_level, status) VALUES
    (2, 7, 2, 7, 'Food Distribution Request', 'tornadoes', 'food', 1000, 300, 'Rice, dhal, and essential food items required', '0722222222', 'high', 'Approved'),
    (4, 9, 4, 9, 'Clothing for Displaced Families', 'heat waves', 'clothes', 300, 120, 'Children and adult clothing needed urgently', '0744444444', 'medium', 'Pending'),
    (6, 6, 1, 6, 'Emergency Medicines', 'landslides', 'medicine', 200, 100, 'Antibiotics and first aid supplies', '0711111111', 'high', 'Pending'),
    (7, 7, 2, 7, 'Dry Food Packets', 'tornadoes', 'food', 500, 250, 'Ready to eat food packets needed', '0722222222', 'medium', 'Approved')";
$conn->query($sql);
echo "Logged request data inserted successfully!<br>";

// ========== 9. INSERT RESOURCES ==========
$sql = "INSERT INTO resource (volunteer_id, resource_name, resource_type, resource_count, description) VALUES
    (3, 'Medical First Aid Kits', 'medicine', 150, 'Complete first aid kits with bandages and antiseptics'),
    (3, 'Paracetamol Tablets', 'medicine', 1000, '500mg tablets for fever and pain relief'),
    (4, 'Rice Packets', 'food', 2000, '5kg rice packets'),
    (4, 'Emergency Tents', 'shelter', 30, 'Family size tents with rain cover'),
    (5, 'Blankets', 'clothes', 150, 'Warm blankets for cold nights'),
    (5, 'School Uniforms', 'clothes', 100, 'Children school uniforms assorted sizes'),
    (3, 'Water Purification Tablets', 'water', 500, 'For clean drinking water')";
$conn->query($sql);
echo "Resource data inserted successfully!<br>";

// ========== 10. INSERT ASSIGNMENTS ==========
$sql = "INSERT INTO assignments (assignment_type, volunteer_id, relief_team_id, request_id, resource_id, affected_people_id, assigned_date, description, status) VALUES
    ('Volunteer_Resource', 3, NULL, 1, 1, 6, NOW(), 'Medical supplies assigned to landslide victims', 'Assigned'),
    ('Volunteer_Resource', 4, NULL, 2, 3, 7, NOW(), 'Food supplies allocated for tornado affected', 'Allocated'),
    ('Volunteer_Resource', 4, NULL, 3, 4, 8, NOW(), 'Tents assigned for temporary shelter', 'Assigned'),
    ('Volunteer_Resource', 5, NULL, 4, 5, 9, DATE_SUB(NOW(), INTERVAL 2 DAY), 'Clothing received and distributed', 'Received'),
    ('Volunteer_Resource', NULL, NULL, 5, NULL, 10, NOW(), 'Awaiting resource allocation for rescue support', 'Assigned')";
$conn->query($sql);
echo "Assignment data inserted successfully!<br>";

// ========== 11. INSERT MASSIVE ACTIVITY LOG DATA FOR TRACKING PEOPLE ==========
echo "Inserting massive activity log dataset for tracking...<br>";

// Base activity log data
$activities = [
    // Admin activities
    ["user_id" => 1, "activity_type" => "login", "description" => "Admin login from dashboard", "ip_address" => "192.168.1.100", "status" => "success"],
    ["user_id" => 1, "activity_type" => "view_request", "entity_type" => "request", "entity_id" => 1, "description" => "Viewed instant request #1", "status" => "success"],
    ["user_id" => 1, "activity_type" => "update_status", "entity_type" => "request", "entity_id" => 2, "old_value" => "Pending", "new_value" => "Approved", "description" => "Approved logged request #2", "status" => "success"],
    ["user_id" => 1, "activity_type" => "assign_resource", "entity_type" => "assignment", "entity_id" => 1, "description" => "Assigned medical supplies to volunteer", "status" => "success"],
    ["user_id" => 1, "activity_type" => "report_generation", "entity_type" => "report", "entity_id" => 1, "description" => "Generated daily activity report", "status" => "success"],
    
    // Volunteer activities
    ["user_id" => 3, "activity_type" => "login", "description" => "Volunteer login from mobile app", "ip_address" => "192.168.1.101", "status" => "success"],
    ["user_id" => 3, "activity_type" => "view_request", "entity_type" => "request", "entity_id" => 1, "description" => "Viewed assigned request", "status" => "success"],
    ["user_id" => 3, "activity_type" => "update_status", "entity_type" => "assignment", "entity_id" => 1, "old_value" => "Assigned", "new_value" => "Doing", "description" => "Started assignment #1", "status" => "success"],
    ["user_id" => 3, "activity_type" => "resource_allocation", "entity_type" => "resource", "entity_id" => 1, "description" => "Allocated medical first aid kits", "status" => "success"],
    ["user_id" => 3, "activity_type" => "logout", "description" => "Volunteer logged out", "status" => "success"],
    
    // Affected people activities
    ["user_id" => 6, "activity_type" => "login", "description" => "Affected person login", "ip_address" => "192.168.1.102", "status" => "success"],
    ["user_id" => 6, "activity_type" => "create_request", "entity_type" => "request", "entity_id" => 1, "description" => "Created emergency medical request", "status" => "success"],
    ["user_id" => 6, "activity_type" => "view_request", "entity_type" => "request", "entity_id" => 1, "description" => "Viewed own request", "status" => "success"],
    ["user_id" => 6, "activity_type" => "view_location", "entity_type" => "location", "entity_id" => 1, "description" => "Viewed location details", "status" => "success"],
    ["user_id" => 6, "activity_type" => "logout", "description" => "Affected person logged out", "status" => "success"],
];

// Generate additional activity logs for system tracking (massive dataset)
$activity_types = ['login', 'logout', 'view_request', 'create_request', 'update_status', 'search', 'view_location', 'edit_profile'];
$entity_types = ['request', 'assignment', 'resource', 'location', 'user'];
$descriptions = [
    "User accessed system",
    "Viewed dashboard",
    "Updated resource allocation",
    "Searched for affected people",
    "Checked location coordinates",
    "Modified request status",
    "Viewed volunteer assignments",
    "Checked resource inventory",
    "Downloaded activity report",
    "Updated user profile",
    "Viewed team assignments",
    "Created new resource entry",
    "Updated location information",
    "Viewed historical data",
    "Performed system check"
];

// Generate 500+ activity log entries for massive dataset
for ($i = 0; $i < 500; $i++) {
    $user_id = rand(1, 10);
    $activity_type = $activity_types[array_rand($activity_types)];
    $entity_type = $entity_types[array_rand($entity_types)];
    $entity_id = rand(1, 10);
    $description = $descriptions[array_rand($descriptions)];
    $ip_address = "192.168." . rand(1, 255) . "." . rand(1, 255);
    $status = rand(0, 10) > 1 ? 'success' : 'failure';
    $timestamp = date('Y-m-d H:i:s', strtotime('-' . rand(1, 30) . ' days'));
    
    $activities[] = [
        "user_id" => $user_id,
        "activity_type" => $activity_type,
        "entity_type" => $entity_type,
        "entity_id" => $entity_id,
        "description" => $description,
        "ip_address" => $ip_address,
        "status" => $status
    ];
}

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

echo "<br><strong>All data inserted successfully!</strong>";

$conn->close();
?>