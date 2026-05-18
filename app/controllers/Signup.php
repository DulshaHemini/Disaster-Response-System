<?php

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../models/auth/signup_.php"; 
require_once __DIR__ . "/../views/auth/_signup.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $row = [];
    
    // Common Data
    $row['first_name'] = $_POST['first_name'] ?? '';
    $row['last_name'] = $_POST['last_name'] ?? '';
    $row['nic'] = $_POST['nic'] ?? '';
    $row['email'] = $_POST['email'] ?? '';
    $row['contact_no'] = $_POST['contact_no'] ?? '';
    $row['username'] = $_POST['username'] ?? '';
    $row['password'] = $_POST['password'] ?? '';
    $row['gender'] = $_POST['gender'] ?? '';
    $row['age'] = $_POST['age'] ?? '';
    $row['home_no'] = $_POST['home_no'] ?? '';
    $row['street'] = $_POST['street'] ?? '';
    $row['city'] = $_POST['city'] ?? '';
    $row['district'] = $_POST['district'] ?? '';
    $row['latitude'] = $_POST['lat'] ?? '';
    $row['longitude'] = $_POST['lon'] ?? '';
    $row['user_role'] = $_POST['user_role'] ?? '';

    // Affected People
    $row['no_of_family_members'] = $_POST['no_of_family_members'] ?? '';

    // Volunteer
    $row['availability_status'] = $_POST['availability_status'] ?? '';
    $row['type'] = $_POST['type'] ?? ''; // Person or Organization
    $row['organization_name'] = $_POST['organization_name'] ?? '';
    $row['resource_name'] = $_POST['resource_name'] ?? '';
    $row['resource_type'] = $_POST['resource_type'] ?? '';
    $row['resource_count'] = $_POST['resource_count'] ?? '';
    $row['description'] = $_POST['description'] ?? '';

    // Relief Team
    $row['team_name'] = $_POST['team_name'] ?? '';
    $row['team_email'] = $_POST['team_email'] ?? '';
    $row['team_contact'] = $_POST['team_contact'] ?? '';
    $row['specialization'] = $_POST['specialization'] ?? '';
    $row['no_of_members'] = $_POST['no_of_members'] ?? '';
    $row['vehicle_type'] = $_POST['vehicle_type'] ?? '';
    $row['vehicle_number'] = $_POST['vehicle_number'] ?? '';

    $result = insertData($conn, $row);

    //if result == success do the success(); else fail();
    if($result == 'success'){
        success();
    }else{
        reg_fail();
    }
}  

signupview()

?>
