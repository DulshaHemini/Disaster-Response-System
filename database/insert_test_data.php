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

// ========== 9. INSERT TRACKER ACTIVITY LOGS ==========
$sql = "INSERT INTO tracker_activity_log (person_id, log_type, message, created_by) VALUES
    (6, 'incident_reported', 'Family requested urgent evacuation support due to landslide risk', 'Emergency Hotline'),
    (6, 'team_dispatched', 'Rescue team dispatched to Peradeniya Road location', 'Control Center'),
    (7, 'incident_reported', 'Flood water entered ground floor and food supplies are running low', 'Local Police'),
    (8, 'medical_aid', 'On-site medical team treated minor injuries and distributed medicine', 'Medical Team'),
    (9, 'status_update', 'Situation stabilized and person moved to a temporary shelter', 'Field Coordinator'),
    (10, 'team_arrived', 'Response team reached location and started assessment', 'Rescue Team')";
$conn->query($sql);
echo "Tracker activity logs inserted successfully!<br>";

// ========== 10. INSERT MASSIVE TRACKER ACTIVITY LOG DATA ==========
$sql = "INSERT INTO tracker_activity_log (person_id, log_type, message, created_by) VALUES
    (6, 'alert', 'Water level warning issued for low-lying area sector A1', 'Alert System'),
    (6, 'team_dispatched', 'Boat rescue unit assigned from station K-01', 'Control Center'),
    (6, 'team_arrived', 'First response team reached the reported location', 'Rescue Team Alpha'),
    (6, 'medical_aid', 'First aid administered for minor cuts and bruises', 'Medical Team'),
    (6, 'food_supply', 'Emergency dry ration packs delivered to household', 'Logistics Unit'),
    (6, 'status_update', 'Household transferred to safe shelter block 3', 'Field Coordinator'),
    (6, 'alert', 'Secondary rainfall warning sent to nearby families', 'Alert System'),
    (6, 'team_dispatched', 'Backup ambulance dispatched for standby support', 'Control Center'),
    (6, 'status_update', 'Communication restored with affected family members', 'Operations Desk'),
    (6, 'shelter', 'Temporary shelter allocation confirmed by local council', 'Relief Officer'),

    (7, 'alert', 'Strong wind advisory shared with residents in sector C2', 'Alert System'),
    (7, 'incident_reported', 'Family reported rising water inside the ground floor', 'Emergency Hotline'),
    (7, 'team_dispatched', 'Rescue pickup team dispatched from district base', 'Control Center'),
    (7, 'team_arrived', 'Response team arrived and began rapid assessment', 'Rescue Team Bravo'),
    (7, 'food_supply', 'Cooked meal packs distributed to displaced members', 'Relief Volunteers'),
    (7, 'medical_aid', 'Blood pressure and dehydration checks completed', 'Medical Team'),
    (7, 'status_update', 'Children moved to safer zone in community center', 'Field Coordinator'),
    (7, 'shelter', 'Family assigned to shelter room B-14', 'Relief Officer'),
    (7, 'status_update', 'Night monitoring plan shared with shelter warden', 'Operations Desk'),
    (7, 'food_supply', 'Additional clean drinking water cans delivered', 'Logistics Unit'),

    (8, 'incident_reported', 'Road access blocked due to debris accumulation', 'Local Police'),
    (8, 'alert', 'Landslide risk alert issued for hillside lane 5', 'Alert System'),
    (8, 'team_dispatched', 'Excavation support unit dispatched to clear route', 'Control Center'),
    (8, 'team_arrived', 'Field engineers reached the blocked access point', 'Response Engineering'),
    (8, 'status_update', 'Narrow pathway opened for emergency movement', 'Field Coordinator'),
    (8, 'medical_aid', 'Mobile clinic screened elderly family members', 'Medical Team'),
    (8, 'food_supply', 'Infant nutrition supplies handed over to guardian', 'Relief Volunteers'),
    (8, 'shelter', 'Temporary tent shelter installed near school ground', 'Relief Officer'),
    (8, 'status_update', 'Family condition stable and under periodic review', 'Operations Desk'),
    (8, 'alert', 'Aftershock advisory distributed via SMS broadcast', 'Alert System'),

    (9, 'incident_reported', 'Displaced family requested urgent clothing and blankets', 'Emergency Hotline'),
    (9, 'team_dispatched', 'Local volunteer unit assigned for relief support', 'Control Center'),
    (9, 'team_arrived', 'Volunteer team arrived and started distribution setup', 'Volunteer Team'),
    (9, 'food_supply', 'Meal packets delivered for two-day requirement', 'Logistics Unit'),
    (9, 'shelter', 'Community hall space prepared for overnight stay', 'Relief Officer'),
    (9, 'status_update', 'Family relocated to designated safe zone', 'Field Coordinator'),
    (9, 'medical_aid', 'Basic medical assessment completed without critical findings', 'Medical Team'),
    (9, 'alert', 'Heat stress warning issued for afternoon period', 'Alert System'),
    (9, 'status_update', 'Relief follow-up visit scheduled for tomorrow morning', 'Operations Desk'),
    (9, 'food_supply', 'High-energy biscuits and milk powder distributed', 'Relief Volunteers'),

    (10, 'incident_reported', 'Caller reported severe shortage of essential medicines', 'Emergency Hotline'),
    (10, 'alert', 'Heavy rain warning escalated to orange level', 'Alert System'),
    (10, 'team_dispatched', 'Medical response vehicle sent from base hospital', 'Control Center'),
    (10, 'team_arrived', 'Medical team reached location and triage initiated', 'Medical Response Unit'),
    (10, 'medical_aid', 'Medication issued for chronic health conditions', 'Medical Team'),
    (10, 'food_supply', 'Ready-to-eat packs issued for immediate consumption', 'Logistics Unit'),
    (10, 'shelter', 'Family moved to school shelter wing A', 'Relief Officer'),
    (10, 'status_update', 'Primary needs covered and condition improving', 'Field Coordinator'),
    (10, 'status_update', 'Family contact verified and reunification in progress', 'Operations Desk'),
    (10, 'alert', 'Night-time flood watch warning sent to all nearby homes', 'Alert System'),

    (6, 'incident_reported', 'Neighbor reported water entering rear section of house', 'Local Police'),
    (6, 'food_supply', 'Protein meal kits delivered for four family members', 'Relief Volunteers'),
    (6, 'status_update', 'Priority changed to monitored after rapid improvement', 'Field Coordinator'),
    (6, 'team_arrived', 'Secondary response team confirmed area safety', 'Rescue Team Alpha'),
    (6, 'medical_aid', 'Wound dressing changed and pain management provided', 'Medical Team'),
    (6, 'shelter', 'Additional bedding provided at temporary shelter', 'Relief Officer'),
    (6, 'alert', 'Localized rain cell warning sent for next 2 hours', 'Alert System'),
    (6, 'status_update', 'Case handed over to district welfare follow-up', 'Operations Desk'),

    (7, 'alert', 'Community siren test completed and acknowledged', 'Alert System'),
    (7, 'team_dispatched', 'Night patrol support team assigned for monitoring', 'Control Center'),
    (7, 'status_update', 'Family requested infant supplies and hygiene kits', 'Field Coordinator'),
    (7, 'food_supply', 'Infant formula and dry food supplies delivered', 'Logistics Unit'),
    (7, 'medical_aid', 'General physician consultation completed at shelter', 'Medical Team'),
    (7, 'status_update', 'All members accounted for and safe', 'Operations Desk'),
    (7, 'shelter', 'Shelter registration updated with extended stay details', 'Relief Officer'),
    (7, 'team_arrived', 'Volunteer support team arrived for shift handover', 'Volunteer Team'),

    (8, 'incident_reported', 'Request received for clean water purification support', 'Emergency Hotline'),
    (8, 'food_supply', 'Water containers and purification tablets delivered', 'Logistics Unit'),
    (8, 'status_update', 'Access road reopened for light vehicles', 'Field Coordinator'),
    (8, 'alert', 'Slope movement monitoring alert remains active', 'Alert System'),
    (8, 'team_dispatched', 'Geology inspection unit dispatched for reassessment', 'Control Center'),
    (8, 'team_arrived', 'Geology team completed hazard scan', 'Response Engineering'),
    (8, 'status_update', 'Risk reduced to moderate after field inspection', 'Operations Desk'),
    (8, 'shelter', 'Family retained in temporary shelter for precautionary stay', 'Relief Officer'),

    (9, 'alert', 'High temperature warning issued for noon interval', 'Alert System'),
    (9, 'team_dispatched', 'Mobile relief van dispatched to sector D4', 'Control Center'),
    (9, 'team_arrived', 'Relief van reached pickup point and unloaded supplies', 'Volunteer Team'),
    (9, 'status_update', 'Sanitation kit distribution completed successfully', 'Field Coordinator'),
    (9, 'food_supply', 'Fresh drinking water bottles distributed', 'Relief Volunteers'),
    (9, 'medical_aid', 'Follow-up check completed for elderly member', 'Medical Team'),
    (9, 'status_update', 'Family support request closed after confirmation call', 'Operations Desk'),
    (9, 'shelter', 'Alternative shelter option reserved as backup', 'Relief Officer'),

    (10, 'incident_reported', 'Request logged for baby food and essential hygiene items', 'Emergency Hotline'),
    (10, 'team_dispatched', 'Supply transport unit allocated to request', 'Control Center'),
    (10, 'team_arrived', 'Supply unit reached destination and verified recipients', 'Logistics Unit'),
    (10, 'food_supply', 'Nutrition packs issued for three-day use', 'Relief Volunteers'),
    (10, 'medical_aid', 'Nurse-led assessment completed for all members', 'Medical Team'),
    (10, 'status_update', 'Case downgraded from urgent to routine monitoring', 'Field Coordinator'),
    (10, 'alert', 'Rainfall advisory remains active for the district', 'Alert System'),
    (10, 'shelter', 'Temporary shelter stay extended by 24 hours', 'Relief Officer')";
$conn->query($sql);
echo "Massive tracker activity log data inserted successfully!<br>";

echo "<br><strong>All data inserted successfully!</strong>";

$conn->close();
?>