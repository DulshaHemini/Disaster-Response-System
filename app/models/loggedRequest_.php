/*<?php

    require_once __DIR__ . "../../config/config.php";
//function insertData(){

 // global $conn;
  $user_id = 8;
    
    $request_name = $_POST['request_name'];
    $request_type = $_POST['req_type'];
    $description = $_POST['description'];
    $affected_people = $_POST['affected_people'];
    $resource_type = $_POST['resource_type'];
    $resource_count = $_POST['resource_count'];
    $contact_number = $_POST['contact_number'];

   
    $city = $_POST['city'];
    $street = $_POST['street'];
    $home_no = $_POST['home_number'];

    $priority = $_POST['priority_level'];
    $district = $_POST['district'];

    $latitude = $_POST['lat'];
    $longitude = $_POST['lon'];

  $sql_location = "UPDATE Location
      SET
          latitude = '$latitude',
          longitude = '$longitude',
          district = '$district',
          city = '$city',
          street = '$street',
          home_no = '$home_no'
      WHERE user_id = $user_id";

  if ($conn->query($sql_location) === TRUE) {
      echo "Location updated successfully."; 
  } else {
      echo "Error updating location: " . $conn->error;
  }


    $sql = "INSERT INTO logged_Request(
        loc_id,
        req_name,
        req_type,
        resource_type,
        resource_count,
        description,
        No_of_affected_people,
        contact_number,
        priority
       
        )
        VALUES (
        '$loc_id',
        '$request_name',
        '$request_type',
        '$resource_type',
        '$resource_count',
        '$affected_people',
        '$description',
        '$contact_number',
        '$priority'
    )";

  return mysqli_query($conn, $sql);
//}
  
?>