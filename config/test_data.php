<?php

// Users
$conn->query("INSERT INTO users (username, password, user_role) VALUES
('admin1', 'hashed_pass1', 'admin'),
('affected1', 'hashed_pass2', 'affected_people'),
('affected2', 'hashed_pass3', 'affected_people'),
('volunteer1', 'hashed_pass4', 'volunteer'),
('volunteer2', 'hashed_pass5', 'volunteer')
");

// Admin
$conn->query("INSERT INTO admin (user_id, full_name, email, contact_no) VALUES
(1, 'Nimal Perera', 'nimal@gmail.com', '0711111111')
");

// Affected People
$conn->query("INSERT INTO affected_people (user_id, full_name, nic, contact_no, no_of_family_members, priority_level) VALUES
(2, 'Sunil Fernando', '901234567V', '0722222222', 5, 'high'),
(3, 'Kamal Silva', '880123456V', '0733333333', 3, 'medium')
");

// Volunteers
$conn->query("INSERT INTO volunteer (user_id, full_name, nic, contact_no, availability_status, organization_name) VALUES
(4, 'Ruwan Jayasuriya', '850987654V', '0744444444', 'available', 'Red Cross'),
(5, 'Saman Kumara', '920112233V', '0755555555', 'available', 'Local NGO')
");

// Locations
$conn->query("INSERT INTO Location (user_id, latitude, longitude, province, district, street) VALUES
(2, 6.927079, 79.861244, 'Western', 'Colombo', 'Main Street'),
(3, 7.290572, 80.633728, 'Central', 'Kandy', 'Temple Road'),
(4, 6.914722, 79.973333, 'Western', 'Gampaha', 'Negombo Road'),
(5, 6.053519, 80.221008, 'Southern', 'Galle', 'Beach Road')
");

// Requests
$conn->query("INSERT INTO Request (req_name, req_type, description, contact_number, priority_level, status, loc_id, user_id) VALUES
('Need Food Supplies', 'food', 'Family needs urgent food', '0722222222', 'high', 'Pending', 1, 2),
('Medical Help Required', 'medical', 'Injury due to landslide', '0733333333', 'high', 'Pending', 2, 3)
");

echo "Test data inserted successfully!";

?>