<?php

require_once "../config/config.php";

$conn->select_db("DRCS1");

/* =========================================
   INSERT USERS
========================================= */

$sql = "INSERT INTO users
(username, password, user_role)

VALUES
('volunteer1', '12345', 'volunteer'),
('volunteer2', '12345', 'volunteer'),
('admin1', '12345', 'admin')";

if ($conn->query($sql) === TRUE) {
    echo "Users inserted successfully.<br>";
} else {
    echo "Users insert skipped or failed.<br>";
}

/* =========================================
   INSERT VOLUNTEERS
========================================= */

$sql = "INSERT INTO volunteer
(
    user_id,
    first_name,
    last_name,
    nic,
    gender,
    contact_no,
    age,
    availability_status,
    organization_name
)

VALUES

(
    1,
    'Kamal',
    'Perera',
    '991234567V',
    'Male',
    '0771234567',
    25,
    'Available',
    'Red Cross'
),

(
    2,
    'Nimal',
    'Silva',
    '981234567V',
    'Male',
    '0779876543',
    30,
    'Available',
    'Army'
)";

if ($conn->query($sql) === TRUE) {
    echo "Volunteers inserted successfully.<br>";
} else {
    echo "Volunteer insert skipped or failed.<br>";
}

/* =========================================
   INSERT DEFAULT RESOURCE TYPES
========================================= */

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

/* =========================================
   GET RESOURCE TYPE IDS
========================================= */

$type_ids = array();

$sql = "SELECT * FROM resource_type";

$result = $conn->query($sql);

if ($result) {

    while ($row = $result->fetch_assoc()) {

        $type_ids[$row['resource_name']] =
            $row['resource_type_id'];
    }
}

/* =========================================
   INSERT RESOURCES
========================================= */

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

(
    1,
    " . $type_ids['FOODS'] . ",
    'Rice Packets',
    500,
    'Packets',
    1000,
    'Emergency food supply'
),

(
    1,
    " . $type_ids['MEDICALS'] . ",
    'First Aid Kits',
    20,
    'Boxes',
    100,
    'Basic medical kits'
),

(
    1,
    " . $type_ids['SHELTERS'] . ",
    'Tents',
    0,
    'Units',
    50,
    'Temporary shelters'
),

(
    2,
    " . $type_ids['CLOTHS'] . ",
    'Blankets',
    150,
    'Pieces',
    300,
    'Winter blankets'
),

(
    2,
    " . $type_ids['MONEY'] . ",
    'Relief Funds',
    50000,
    'LKR',
    100000,
    'Donation funds'
)";

if ($conn->query($sql) === TRUE) {
    echo "Resources inserted successfully.<br>";
} else {
    echo "Resource insert failed: " . $conn->error;
}

$conn->close();

?>