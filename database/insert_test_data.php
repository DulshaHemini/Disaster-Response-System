<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DRCS";

// Create connection
$conn = new mysqli($servername, $username, $password);

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
$sql = "INSERT INTO volunteer (user_id, first_name, last_name, nic, gender, contact_no, availability_status, organization_name) VALUES
    (3, 'Michael', 'Volunteer', '199012345678', 'Male', '0771234567', 'available', 'Red Cross Sri Lanka'),
    (4, 'Emma', 'Rescue', '199112345678', 'Female', '0782345678', 'available', 'World Vision'),
    (5, 'David', 'Helper', '199212345678', 'Male', '0763456789', 'busy', 'Save the Children')";
$conn->query($sql);
echo "Volunteer data inserted successfully!<br>";

// ========== 4. INSERT AFFECTED PEOPLE TABLE ==========
$sql = "INSERT INTO affected_people (user_id, first_name, last_name, age, no_of_family_members, gender, priority_level, nic, contact_no) VALUES
    (6, 'Kasun', 'Perera', 32, 4, 'Male', 'high', '198912345678', '0711111111'),
    (7, 'Priyani', 'Silva', 28, 3, 'Female', 'medium', '199312345678', '0722222222'),
    (8, 'Mohamed', 'Rizwan', 45, 6, 'Male', 'high', '198712345678', '0733333333'),
    (9, 'Shanthi', 'Kumar', 35, 2, 'Female', 'low', '199512345678', '0744444444'),
    (10, 'Nimal', 'Jayasinghe', 40, 5, 'Male', 'medium', '199112345679', '0755555555')";
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
$sql = "INSERT INTO Request (affected_people_id, loc_id, req_name, req_type, resource_type, resource_count, no_of_affected_people, description, contact_number, priority_level, status, is_instant) VALUES
    (6, 1, 'Emergency Medical Supplies', 'landslides', 'Medicins', 500, 150, 'Immediate medical supplies needed for landslide victims', '0711111111', 'high', 'Pending', 1),
    (7, 2, 'Food Distribution Request', 'tornadoes', 'Foods', 1000, 300, 'Rice, dhal, and essential food items required', '0722222222', 'high', 'Approved', 0),
    (8, 3, 'Temporary Shelter Setup', 'tsunamis', 'Shelters', 50, 200, 'Tents and emergency shelter materials needed', '0733333333', 'medium', 'Assigned', 1),
    (9, 4, 'Clothing for Displaced Families', 'heat waves', 'Clothes', 300, 120, 'Children and adult clothing needed urgently', '0744444444', 'medium', 'Pending', 0),
    (10, 5, 'Financial Aid Request', 'avalanches', 'Money', 0, 80, 'Monetary assistance for rebuilding homes', '0755555555', 'high', 'In Progress', 1),
    (6, 1, 'Emergency Medicines', 'landslides', 'Medicins', 200, 100, 'Antibiotics and first aid supplies', '0711111111', 'high', 'Pending', 1),
    (7, 2, 'Dry Food Packets', 'tornadoes', 'Foods', 500, 250, 'Ready to eat food packets needed', '0722222222', 'medium', 'Approved', 0)";
$conn->query($sql);
echo "Request data inserted successfully!<br>";

// ========== 7. INSERT RESOURCES ==========
$sql = "INSERT INTO resources (volunteer_id, resource_name, resource_type, resource_count, description) VALUES
    (3, 'Medical First Aid Kits', 'Medicals', 150, 'Complete first aid kits with bandages and antiseptics'),
    (3, 'Paracetamol Tablets', 'Medicals', 1000, '500mg tablets for fever and pain relief'),
    (4, 'Rice Packets', 'Foods', 2000, '5kg rice packets'),
    (4, 'Emergency Tents', 'Shelters', 30, 'Family size tents with rain cover'),
    (5, 'Blankets', 'Cloths', 150, 'Warm blankets for cold nights'),
    (5, 'School Uniforms', 'Cloths', 100, 'Children school uniforms assorted sizes'),
    (3, 'Water Purification Tablets', 'Medicals', 500, 'For clean drinking water')";
$conn->query($sql);
echo "Resource data inserted successfully!<br>";

// ========== 8. INSERT ASSIGNMENTS ==========
$sql = "INSERT INTO assignment (assigned_date, req_id, resource_id, volunteer_id, description, status) VALUES
    (NOW(), 1, 1, 3, 'Medical supplies assigned to landslide victims', 'Assigned'),
    (NOW(), 2, 3, 4, 'Food supplies allocated for tornado affected', 'Allocated'),
    (NOW(), 3, 4, 4, 'Tents assigned for temporary shelter', 'Assigned'),
    (DATE_SUB(NOW(), INTERVAL 2 DAY), 4, 5, 5, 'Clothing received and distributed', 'Received'),
    (NOW(), 5, NULL, NULL, 'Awaiting resource allocation for financial aid', 'Assigned')";
$conn->query($sql);
echo "Assignment data inserted successfully!<br>";

echo "<br><strong>All data inserted successfully!</strong>";

$conn->close();
?>