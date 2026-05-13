<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DRCS";

// Create connection
$conn = new mysqli($servername, $username, $password, "", 3307);

// Check connection
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// Select database
$conn->select_db($dbname);

// ========== INSERT INTO users TABLE (Multiple Insertion) ==========
$sql = "INSERT INTO users (user_id, username, password, user_role) VALUES 
    (1, 'admin_john', MD5('admin123'), 'admin'),
    (2, 'affected_mary', MD5('mary123'), 'affected_people'),
    (3, 'affected_ahmed', MD5('ahmed123'), 'affected_people'),
    (4, 'volunteer_sarah', MD5('sarah123'), 'volunteer'),
    (5, 'volunteer_david', MD5('david123'), 'volunteer')";
$conn->query($sql);
echo "Users inserted successfully!<br>";

// ========== INSERT INTO admin TABLE ==========
$sql = "INSERT INTO admin (user_id, first_name, last_name, gender, age, email, contact_no) VALUES 
    (1, 'John', 'Smith', 'Male', 35, 'john.smith@drcs.org', '0771234567')";
$conn->query($sql);
echo "Admin inserted successfully!<br>";

// ========== INSERT INTO affected_people TABLE (Note: affected_people_id = user_id) ==========
$sql = "INSERT INTO affected_people (affected_people_id, first_name, last_name, age, no_of_family_members, gender, nic, contact_no) VALUES 
    (2, 'Mary', 'Johnson', 28, 4, 'Female', '198745632145', '0712345678'),
    (3, 'Ahmed', 'Rashid', 42, 6, 'Male', '197812345678', '0723456789')";
$conn->query($sql);
echo "Affected people inserted successfully!<br>";

// ========== INSERT INTO volunteer TABLE (Note: volunteer_id = user_id) ==========
$sql = "INSERT INTO volunteer (volunteer_id, first_name, last_name, nic, gender, contact_no, age, availability_status, organization_name) VALUES 
    (4, 'Sarah', 'Williams', '199034567890', 'Female', '0781234567', 26, 'available', 'Red Cross Society'),
    (5, 'David', 'Brown', '198956789012', 'Male', '0792345678', 31, 'busy', 'UNICEF')";
$conn->query($sql);
echo "Volunteers inserted successfully!<br>";

// ========== INSERT INTO Location TABLE ==========
$sql = "INSERT INTO Location (loc_id, user_id, latitude, longitude, district, city, street, home_no) VALUES 
    (1, 2, 6.9271000000000000, 79.8612000000000000, 'Colombo', 'Colombo', 'Galle Road', '45'),
    (2, 3, 7.2906000000000000, 80.6337000000000000, 'Kandy', 'Kandy', 'Peradeniya Road', '12'),
    (3, 4, 6.0328000000000000, 80.2168000000000000, 'Galle', 'Galle', 'Light House Street', '78')";
$conn->query($sql);
echo "Locations inserted successfully!<br>";

// ========== INSERT INTO requests TABLE ==========
$sql = "INSERT INTO requests (request_id, request_type) VALUES 
    (101, 'Instant_Request'),
    (102, 'Instant_Request'),
    (103, 'Logged_Request')";
$conn->query($sql);
echo "Requests inserted successfully!<br>";

// ========== INSERT INTO Instant_Request TABLE ==========
$sql = "INSERT INTO Instant_Request (req_id, user_id, loc_id, full_name, req_name, resource_type, resource_count,contact_number, status) VALUES 
    (101, 2, 1, 'Mary Johnson', 'Emergency Medicine Supply', 'Medicins', 50, '0712345678', 'Pending'),
    (102, 3, 2, 'Ahmed Rashid', 'Food Packages for Flood Victims', 'Foods', 100, '0723456789', 'Pending')";
$conn->query($sql);
echo "Instant Requests inserted successfully!<br>";

// ========== INSERT INTO Logged_Request TABLE ==========
$sql = "INSERT INTO Logged_Request (req_id, affected_people_id, loc_id, user_id, req_name, req_type, resource_type, resource_count, no_of_affected_people, description, contact_number, priority_level, status) VALUES 
    (103, 2, 1, 2, 'Landslide Relief Support', 'landslides', 'Shelters', 20, 150, 'Emergency shelter materials needed for landslide affected families', '0712345678', 'high', 'Pending')";
$conn->query($sql);
echo "Logged Request inserted successfully!<br>";

// ========== INSERT INTO resource TABLE ==========
$sql = "INSERT INTO resource (resource_id, volunteer_id, resource_name, resource_type, resource_count, description) VALUES 
    (501, 4, 'Paracetamol Tablets', 'Medicals', 500, '500mg paracetamol tablets for fever relief'),
    (502, 4, 'Rice Packets', 'Foods', 200, '5kg rice packets for distribution'),
    (503, 5, 'Tents', 'Shelters', 50, 'Family size emergency tents'),
    (504, 5, 'Blankets', 'Cloths', 150, 'Warm blankets for winter relief')";
$conn->query($sql);
echo "Resources inserted successfully!<br>";

// ========== INSERT INTO assignments TABLE (Note: table name is 'assignments') ==========
$sql = "INSERT INTO assignments (assignment_id, volunteer_id, assigned_date, request_id, resource_id, affected_people_id, description, status) VALUES 
    (1001, 4, CURRENT_TIMESTAMP, 101, 501, 2, 'Medicine supply assignment for Mary Johnson', 'Assigned'),
    (1002, 4, CURRENT_TIMESTAMP, 102, 502, 3, 'Food supply assignment for Ahmed Rashid', 'Allocated'),
    (1003, 5, CURRENT_TIMESTAMP, 103, 503, 2, 'Shelter materials assignment', 'Received')";
$conn->query($sql);
echo "Assignments inserted successfully!<br>";

echo "<br>All test data inserted successfully!";

$conn->close();
?>