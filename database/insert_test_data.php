<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DRCS";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);

// Select database
$conn->select_db($dbname);


// ======================================================
// 1. INSERT USERS
// ======================================================

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


// ======================================================
// 2. INSERT ADMINS
// ======================================================

$sql = "INSERT INTO admin 
(user_id, first_name, last_name, gender, age, email, contact_no) 
VALUES

(1, 'John', 'Administrator', 'Male', 35, 'john.admin@drcs.org', '0712345678'),

(2, 'Sarah', 'Coordinator', 'Female', 29, 'sarah.coord@drcs.org', '0723456789')";

$conn->query($sql);

echo "Admin data inserted successfully!<br>";


// ======================================================
// 3. INSERT VOLUNTEERS
// ======================================================

$sql = "INSERT INTO volunteer 
(volunteer_id, first_name, last_name, nic, gender, contact_no, age, availability_status, organization_name) 
VALUES

(3, 'Michael', 'Volunteer', '199012345678', 'Male', '0771234567', 30, 'available', 'Red Cross Sri Lanka'),

(4, 'Emma', 'Rescue', '199112345678', 'Female', '0782345678', 28, 'available', 'World Vision'),

(5, 'David', 'Helper', '199212345678', 'Male', '0763456789', 31, 'busy', 'Save the Children')";

$conn->query($sql);

echo "Volunteer data inserted successfully!<br>";


// ======================================================
// 4. INSERT AFFECTED PEOPLE
// ======================================================

$sql = "INSERT INTO affected_people 
(affected_people_id, first_name, last_name, age, no_of_family_members, gender, nic, contact_no) 
VALUES

(6, 'Kasun', 'Perera', 32, 4, 'Male', '198912345678', '0711111111'),

(7, 'Priyani', 'Silva', 28, 3, 'Female', '199312345678', '0722222222'),

(8, 'Mohamed', 'Rizwan', 45, 6, 'Male', '198712345678', '0733333333'),

(9, 'Shanthi', 'Kumar', 35, 2, 'Female', '199512345678', '0744444444'),

(10, 'Nimal', 'Jayasinghe', 40, 5, 'Male', '199112345679', '0755555555')";

$conn->query($sql);

echo "Affected people data inserted successfully!<br>";


// ======================================================
// 5. INSERT LOCATIONS
// ======================================================

$sql = "INSERT INTO Location 
(user_id, latitude, longitude, district, city, street, home_no) 
VALUES

(6, 7.8730540000000000, 80.7717970000000000, 'Kandy', 'Kandy', 'Peradeniya Road', '45'),

(7, 6.9270790000000000, 79.8612430000000000, 'Colombo', 'Nugegoda', 'High Level Road', '123'),

(8, 8.3500000000000000, 80.3833330000000000, 'Anuradhapura', 'Anuradhapura', 'Main Street', '78'),

(9, 6.9344380000000000, 79.8436010000000000, 'Colombo', 'Bambalapitiya', 'Galle Road', '25/2'),

(10, 7.2905720000000000, 80.6334270000000000, 'Kandy', 'Gampola', 'Colombo Road', '10'),

(3, 6.9147200000000000, 79.9726900000000000, 'Colombo', 'Colombo', 'Union Place', '5'),

(4, 7.8730540000000000, 80.7717970000000000, 'Kandy', 'Kandy', 'Hill Street', '12')";

$conn->query($sql);

echo "Location data inserted successfully!<br>";


// ======================================================
// 6. INSERT REQUEST TYPES
// ======================================================

$sql = "INSERT INTO requests (request_type) VALUES
('Instant_Request'),
('Logged_Request'),
('Instant_Request'),
('Logged_Request'),
('Instant_Request')";

$conn->query($sql);

echo "Requests inserted successfully!<br>";


// ======================================================
// 7. INSERT INSTANT REQUESTS
// ======================================================

$sql = "INSERT INTO Instant_Request
(req_id, user_id, loc_id, full_name, req_name, resource_type, resource_count, contact_number, status)
VALUES

(1, 6, 1, 'Kasun Perera', 'Emergency Medicines', 'medicine', 500, '0711111111', 'Pending'),

(3, 8, 3, 'Mohamed Rizwan', 'Temporary Shelters', 'shelter', 50,'0733333333', 'Pending'),

(5, 10, 5, 'Nimal Jayasinghe', 'Financial Aid', 'communication', 0, '0755555555', 'Pending')";

$conn->query($sql);

echo "Instant requests inserted successfully!<br>";


// ======================================================
// 8. INSERT LOGGED REQUESTS
// ======================================================

$sql = "INSERT INTO Logged_Request
(req_id, affected_people_id, loc_id, user_id, req_name, req_type, resource_type,
resource_count, no_of_affected_people, description, contact_number,
priority_level, status)

VALUES

(2, 7, 2, 7, 'Food Distribution', 'tornadoes', 'food',
1000, 300, 'Food items required urgently',
'0722222222', 'high', 'Pending'),

(4, 9, 4, 9, 'Clothing Support', 'heat waves', 'clothes',
300, 120, 'Clothes needed for families',
'0744444444', 'medium', 'Pending')";

$conn->query($sql);

echo "Logged requests inserted successfully!<br>";


// ======================================================
// 9. INSERT RESOURCES
// ======================================================

$sql = "INSERT INTO resource
(volunteer_id, resource_name, resource_type, resource_count, description)

VALUES

(3, 'Medical First Aid Kits', 'Medicals', 150,
'First aid kits'),

(3, 'Paracetamol Tablets', 'Medicals', 1000,
'Medicine supplies'),

(4, 'Rice Packets', 'Foods', 2000,
'5kg rice packets'),

(4, 'Emergency Tents', 'Shelters', 30,
'Family tents'),

(5, 'Blankets', 'Cloths', 150,
'Warm blankets'),

(5, 'School Uniforms', 'Cloths', 100,
'Uniforms for children')";

$conn->query($sql);

echo "Resources inserted successfully!<br>";


// ======================================================
// 10. INSERT ASSIGNMENTS
// ======================================================

$sql = "INSERT INTO assignments
(volunteer_id, request_id, resource_id, affected_people_id, description, status)

VALUES

(3, 1, 1, 6,
'Medical supplies assigned', 'Assigned'),

(4, 2, 3, 7,
'Food supplies allocated', 'Allocated'),

(4, 3, 4, 8,
'Tents assigned', 'Assigned'),

(5, 4, 5, 9,
'Clothes delivered', 'Received')";

$conn->query($sql);

echo "Assignments inserted successfully!<br>";

echo "<br><strong>All test data inserted successfully!</strong>";

$conn->close();

?>