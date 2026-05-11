<?php
function insertData(){
    require_once __DIR__ . "../../config/config.php";

    $username = $_POST['username'];
    $request_name = $_POST['request_name'];
    $request_type = $_POST['req_type'];
    $description = $_POST['description'];
    $affected_people = $_POST['affected_people'];
    $resource_type = $_POST['resource_type'];
    $resource_count = $_POST['resource_count'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $home_no = $_POST['home_nummber'];
    $priority = $_POST['priority_level'];
    $district = $_POST['district'];
    $location = $_POST['location'];

    $sql = "INSERT INTO logged_Request(
        username,
        request_type,
        description,
        affected_people,
        resource_type,
        resource_count,
        contact_number,
        email,
        city,
        street,
        home_no,
        priority,
        district,
        location

        )VALUES ('$username',
        '$request_name',
        '$request_type',
        '$description',
        '$affected_people',
        '$resource_type',
        '$resource_count',
        '$contact_number',
        '$email',
        '$city',
        '$street',
        '$home_no',
        '$priority',
        '$district',
        '$location')
    )";

  return mysqli_query($conn, $sql);
    
  // i want to update location table with the new location data
  $sql_location = "INSERT INTO Location(
    latitude,
    longitude,
    district,
    city,
    street,
    home_no) VALUES ('$latitude', '$longitude', '$district', '$city', '$street', '$home_no')";
  return mysqli_query($conn, $sql_location);
  
}

?>