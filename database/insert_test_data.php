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
    -- 
    ('kasun_volunteer', MD5('kasun123'), 'volunteer'),

    ('nimal_volunteer', MD5('nimal123'), 'volunteer'),
    ('sachini_volunteer', MD5('sachini123'), 'volunteer'),

    ('tharindu_volunteer', MD5('tharindu123'), 'volunteer'),

    ('dinithi_volunteer', MD5('dinithi123'), 'volunteer')";
$conn->query($sql);
echo "Users inserted successfully!<br>";


// (4, 'volunteer_sarah', MD5('sarah123'), 'volunteer'),
//     -- (5, 'volunteer_david', MD5('david123'), 'volunteer'),  removed to avoid duplicate entries when running the script multiple times












// ========== INSERT INTO admin TABLE (Multiple Insertion) ==========
$sql = "INSERT INTO admin (user_id, first_name, last_name, gender, age, email, contact_no) VALUES 
    (1, 'John', 'Smith', 'Male', 35, 'john.smith@drcs.org', '0771234567')";
$conn->query($sql);
echo "Admin inserted successfully!<br>";

// ========== INSERT INTO affected_people TABLE (Multiple Insertion) ==========
$sql = "INSERT INTO affected_people (user_id, first_name, last_name, age, no_of_family_members, gender, nic, contact_no) VALUES 
    (2, 'Mary', 'Johnson', 28, 4, 'Female', '198745632145', '0712345678'),
    (3, 'Ahmed', 'Rashid', 42, 6, 'Male', '197812345678', '0723456789')";
$conn->query($sql);
echo "Affected people inserted successfully!<br>";















// ========== INSERT INTO volunteer TABLE (Multiple Insertion) ==========
$sql = "INSERT INTO volunteer (user_id, first_name, last_name, nic, gender, contact_no, age, availability_status, organization_name) VALUES 

    (
    " . $user_ids['kasun_volunteer'] . ",
    'Kasun',
    'Perera',
    '199823456789',
    'Male',
    '0771234567',
    25,
    'available',
    'Sri Lanka Red Cross Society'
),

(
    " . $user_ids['nimal_volunteer'] . ",
    'Nimal',
    'Fernando',
    '199512345678',
    'Male',
    '0719876543',
    31,
    'busy',
    'Disaster Relief Services'
),

(
    " . $user_ids['sachini_volunteer'] . ",
    'Sachini',
    'Gunawardena',
    '199945678912',
    'Female',
    '0754567890',
    24,
    'available',
    'Sarvodaya'
),

(
    " . $user_ids['tharindu_volunteer'] . ",
    'Tharindu',
    'Silva',
    '199623451234',
    'Male',
    '0767891234',
    29,
    'available',
    'UNICEF Sri Lanka'
),

(
    " . $user_ids['dinithi_volunteer'] . ",
    'Dinithi',
    'Jayasinghe',
    '200012345678',
    'Female',
    '0786543210',
    22,
    'busy',
    'World Vision Lanka'
)

$conn->query($sql);
echo "Volunteers inserted successfully!<br>";















// ========== INSERT INTO Location TABLE (Multiple Insertion) ==========
$sql = "INSERT INTO Location (loc_id, user_id, latitude, longitude, district, city, street, home_no) VALUES 
    (1, 2, 6.9271000000000000, 79.8612000000000000, 'Colombo', 'Colombo', 'Galle Road', '45'),
    (2, 3, 7.2906000000000000, 80.6337000000000000, 'Kandy', 'Kandy', 'Peradeniya Road', '12'),
    (3, 4, 6.0328000000000000, 80.2168000000000000, 'Galle', 'Galle', 'Light House Street', '78')";
$conn->query($sql);
echo "Locations inserted successfully!<br>";

// ========== INSERT INTO requests TABLE (Multiple Insertion) ==========
$sql = "INSERT INTO requests (request_id, request_type) VALUES 
    (101, 'Instant_Request'),
    (102, 'Instant_Request'),
    (103, 'Logged_Request')";
$conn->query($sql);
echo "Requests inserted successfully!<br>";

// ========== INSERT INTO Instant_Request TABLE (Multiple Insertion) ==========
$sql = "INSERT INTO Instant_Request (req_id, user_id, loc_id, full_name, req_name, resource_type, resource_count, description, contact_number, status) VALUES 
    (101, 2, 1, 'Mary Johnson', 'Emergency Medicine Supply', 'Medicins', 50, 'Need immediate medicine for fever and flu', '0712345678', 'Pending'),
    (102, 3, 2, 'Ahmed Rashid', 'Food Packages for Flood Victims', 'Foods', 100, 'Need dry rations for 6 families', '0723456789', 'Pending')";
$conn->query($sql);
echo "Instant Requests inserted successfully!<br>";

// ========== INSERT INTO Logged_Request TABLE (Single Insertion) ==========
$sql = "INSERT INTO Logged_Request (req_id, affected_people_id, loc_id, user_id, req_name, req_type, resource_type, resource_count, no_of_affected_people, description, contact_number, priority_level, status) VALUES 
    (103, 2, 1, 2, 'Landslide Relief Support', 'landslides', 'Shelters', 20, 150, 'Emergency shelter materials needed for landslide affected families', '0712345678', 'high', 'Pending')";
$conn->query($sql);
echo "Logged Request inserted successfully!<br>";












// insert default resource types

$sql = "INSERT INTO resource_type
(resource_name, is_default)

VALUES

('FOODS', 1),
('MEDICALS', 1),
('SHELTERS', 1),
('CLOTHS', 1),
('MONEY', 1)";

if ($conn->query($sql) === TRUE) {
    echo "Resource types inserted successfully.<br>";
} else {
    echo "Resource type insert skipped or failed.<br>";
}




// get resource type ids for inserting resources

$type_ids = array();

$sql = "SELECT * FROM resource_type";

$result = $conn->query($sql);

if ($result) {

    while ($row = $result->fetch_assoc()) {

        $type_ids[$row['resource_name']] =
            $row['resource_type_id'];
    }
}








// ========== INSERT INTO resource TABLE (Multiple Insertion) ==========
$sql = "INSERT INTO resource
(
    volunteer_id,
    resource_type_id,
    resource_name,
    resource_count,
    resource_unit,
    resource_max,
    description
)

VALUES


//    KASUN - 2 RESOURCES


(
    " . $user_ids['kasun_volunteer'] . ",
    " . $type_ids['FOODS'] . ",
    'Rice Packets',
    250,
    'Packets',
    500,
    '5kg rice packets for flood victims'
),

(
    " . $user_ids['kasun_volunteer'] . ",
    " . $type_ids['MEDICALS'] . ",
    'First Aid Kits',
    30,
    'Boxes',
    100,
    'Basic emergency medical kits'
),


//    NIMAL - 4 RESOURCES


(
    " . $user_ids['nimal_volunteer'] . ",
    " . $type_ids['SHELTERS'] . ",
    'Emergency Tents',
    15,
    'Units',
    50,
    'Temporary family shelter tents'
),

(
    " . $user_ids['nimal_volunteer'] . ",
    " . $type_ids['CLOTHS'] . ",
    'Blankets',
    120,
    'Pieces',
    300,
    'Warm blankets for displaced families'
),

(
    " . $user_ids['nimal_volunteer'] . ",
    " . $type_ids['FOODS'] . ",
    'Dry Ration Packs',
    400,
    'Packets',
    600,
    'Dry food packs for emergency use'
),

(
    " . $user_ids['nimal_volunteer'] . ",
    " . $type_ids['MONEY'] . ",
    'Relief Donation Fund',
    85000,
    'LKR',
    150000,
    'Collected public donations'
),


//    SACHINI - 3 RESOURCES

(
    " . $user_ids['sachini_volunteer'] . ",
    " . $type_ids['MEDICALS'] . ",
    'Paracetamol Tablets',
    1000,
    'Tablets',
    2000,
    '500mg fever tablets'
),

(
    " . $user_ids['sachini_volunteer'] . ",
    " . $type_ids['CLOTHS'] . ",
    'School Uniforms',
    40,
    'Sets',
    100,
    'Uniform sets for affected children'
),

(
    " . $user_ids['sachini_volunteer'] . ",
    " . $type_ids['FOODS'] . ",
    'Milk Powder',
    80,
    'Tins',
    200,
    'Nutrition support for children'
),


//    THARINDU - 5 RESOURCES


(
    " . $user_ids['tharindu_volunteer'] . ",
    " . $type_ids['SHELTERS'] . ",
    'Sleeping Mats',
    60,
    'Pieces',
    100,
    'Temporary sleeping mats'
),

(
    " . $user_ids['tharindu_volunteer'] . ",
    " . $type_ids['FOODS'] . ",
    'Bottled Water',
    500,
    'Bottles',
    1000,
    'Clean drinking water'
),

(
    " . $user_ids['tharindu_volunteer'] . ",
    " . $type_ids['MEDICALS'] . ",
    'Sanitizer Bottles',
    75,
    'Bottles',
    150,
    'Hand sanitizers for camps'
),

(
    " . $user_ids['tharindu_volunteer'] . ",
    " . $type_ids['CLOTHS'] . ",
    'Rain Coats',
    25,
    'Pieces',
    80,
    'Rain protection for volunteers'
),

(
    " . $user_ids['tharindu_volunteer'] . ",
    " . $type_ids['MONEY'] . ",
    'Emergency Cash Support',
    120000,
    'LKR',
    200000,
    'Financial emergency assistance'
),


//    DINITHI - 2 RESOURCES

(
    " . $user_ids['dinithi_volunteer'] . ",
    " . $type_ids['FOODS'] . ",
    'Baby Food Packs',
    45,
    'Packets',
    100,
    'Food packs for infants'
),

(
    " . $user_ids['dinithi_volunteer'] . ",
    " . $type_ids['MEDICALS'] . ",
    'Water Purification Tablets',
    500,
    'Tablets',
    1000,
    'Safe drinking water treatment'
)
";
if ($conn->query($sql) === TRUE) {

    echo "Resources inserted successfully.<br>";

} else {

    echo "Resource insert failed: " . $conn->error;
}






















// ========== INSERT INTO assignment TABLE (Multiple Insertion) ==========
$sql = "INSERT INTO assignment (assignment_id, assigned_date, req_id, resource_id, volunteer_id, affected_people_id, description, status) VALUES 
    (1001, CURRENT_TIMESTAMP, 101, 501, 4, 2, 'Medicine supply assignment for Mary Johnson', 'Assigned'),
    (1002, CURRENT_TIMESTAMP, 102, 502, 4, 3, 'Food supply assignment for Ahmed Rashid', 'Allocated'),
    (1003, CURRENT_TIMESTAMP, 103, 503, 5, 2, 'Shelter materials assignment', 'Received')";
$conn->query($sql);
echo "Assignments inserted successfully!<br>";

echo "<br>All test data inserted successfully!";

$conn->close();
?>
