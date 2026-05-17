<?php

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../models/loggedRequest_.php";
require_once __DIR__ . "/../views/loggedRequest/_loggedRequest.php";

//startSession();

//$user_id = $_SESSION['user_id'] ?? null;

$user_id = 2; // replace later with session user id


//echo "User Name: " . $user_name; // Debugging line to check if the username is retrieved correctly


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    

    $row = [];
    
    $row['user_id'] = $user_id; // replace later with session user id

    $row['request_name'] = $_POST['request_name'] ?? '';
    $row['request_type'] = $_POST['req_type'] ?? '';
    $row['description'] = $_POST['description'] ?? '';
    $row['affected_people'] = $_POST['affected_people'] ?? '';
    $row['resource_type'] = $_POST['resource_type'] ?? '';
    $row['resource_count'] = $_POST['resource_count'] ?? '';
    $row['contact_number'] = $_POST['contact_number'] ?? '';
    $row['priority'] = $_POST['priority_level'] ?? '';

    $row['city'] = $_POST['city'] ?? '';
    $row['street'] = $_POST['street'] ?? '';
    $row['home_no'] = $_POST['home_number'] ?? '';
    $row['district'] = $_POST['district'] ?? '';

    $row['latitude'] = $_POST['lat'] ?? '';
    $row['longitude'] = $_POST['lon'] ?? '';

    $result = insertData($conn, $row);

    //if result == success do the success(); else fail();
    if($result == 'success'){
        include_once __DIR__ . '/AssignLogic.php'; 
        success();
    }else{
        reg_fail();
    }
}  

loggedRequestForm($name);



?>