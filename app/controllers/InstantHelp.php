<?php

require_once '../../config/config.php';
require_once '../views/InstantHelp/_InstantHelp.php';
require_once '../models/InstantHelp_.php';

$lat = "";
$lon = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $lat = $_POST['lat'] ?? '';
    $lon = $_POST['lon'] ?? '';

    $name = trim($_POST['name'] ?? '');
    $req_name = trim($_POST['req_name'] ?? '');
    $req_type = $_POST['req_type'] ?? '';
    $affected_people = $_POST['aff_pp'] ?? '';
    $res_type = $_POST['resource_type'] ?? '';
    $res_count = $_POST['resource_count'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $email = $_POST['email'] ?? '';
    $priority = $_POST['priority_level'] ?? '';

    /*
    echo "Latitude: " . $lat . "<br>";
    echo "Longitude: " . $lon . "<br>";
    echo "Name: " . $name . "<br>";
    echo "Request Name: " . $req_name . "<br>";
    echo "Request Type: " . $req_type . "<br>";
    echo "Affected People: " . $affected_people . "<br>";
    echo "Resource Type: " . $res_type . "<br>";
    echo "Resource Count: " . $res_count . "<br>";
    echo "Contact Number: " . $contact_number . "<br>";
    echo "Email: " . $email . "<br>";
    echo "Priority: " . $priority . "<br><br><br>";
    */

    $data['lat'] = $lat;
    $data['lon'] = $lon;
    $data['name'] = $name;
    $data['req_name'] = $req_name;
    $data['req_type'] = $req_type;
    $data['affected_people'] = $affected_people;
    $data['res_type'] = $res_type;
    $data['res_count'] = $res_count;
    $data['contact_number'] = $contact_number;
    $data['email'] = $email;
    $data['priority'] = $priority;

    $result = storeInstantHelp($conn, $data);

    if($result == 'success'){
        include_once __DIR__ . '/AssignLogic.php'; 
        success();
    }else{
        reg_fail();
    }
}

instantHelpForm();

?>
