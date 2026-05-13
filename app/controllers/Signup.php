<?php

require_once '../../config/config.php';
require_once '../views/signup/_signup.php';

    $lat = "";
    $lon = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lat = $_POST['lat'] ?? '';
    $lon = $_POST['lon'] ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $nic = $_POST['nic'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact_no = $_POST['contact_no'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $age = $_POST['age'] ?? '';
    $home_no = $_POST['home_no'] ?? '';
    $street = $_POST['street'] ?? '';
    $city = $_POST['city'] ?? '';
    $district = $_POST['district'] ?? '';
    $user_role = $_POST['user_role'] ?? '';
    $no_of_family_members = $_POST['no_of_family_members'] ?? '';
    $availability_status = $_POST['availability_status'] ?? '';
    $type = $_POST['type'] ?? '';
    $organization_name = $_POST['organization_name'] ?? '';
    $resource_name = $_POST['resource_name'] ?? '';
    $resource_type = $_POST['resource_type'] ?? '';
    $resource_count = $_POST['resource_count'] ?? '';
    $description = $_POST['description'] ?? '';

    require_once '../models/signup_.php';

}

signupview();

?>