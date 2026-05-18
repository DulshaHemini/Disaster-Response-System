<?php

function insertData($conn, $row)
{
    $user_id = $row['user_id'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $district = $row['district'];
    $city = $row['city'];
    $street = $row['street'];
    $home_no = $row['home_no'];
    $req_name = $row['request_name'];
    $req_type = $row['request_type'];
    $resource_type = $row['resource_type'];
    $resource_count = $row['resource_count'];
    $no_of_affected_people = $row['affected_people'];
    $description = $row['description'];
    $contact_number = $row['contact_number'];
    $priority_level = $row['priority'];

    $sql_location = "UPDATE Location SET latitude = '$latitude', longitude = '$longitude', district = '$district', city = '$city', street = '$street', home_no = '$home_no' WHERE user_id = $user_id";

    if ($conn->query($sql_location) === true) {
        $get_location = "SELECT loc_id FROM Location WHERE user_id = $user_id";
        $result = $conn->query($get_location);
        $row = $result->fetch_assoc();
        $location_id = $row['loc_id'];
    } else {
        echo 'Error updating location: '.$conn->error;
    }

    $sql = "INSERT INTO requests(request_type) VALUES ('Logged_Request')";
    if ($conn->query($sql) === true) {
        $req_id = $conn->insert_id;
    } else {
        echo 'Error inserting request: '.$conn->error;
    }

    $sql = "INSERT INTO Logged_Request (
        req_id,
        affected_people_id,
        loc_id,
        user_id,
        req_name,
        req_type,
        resource_type,
        resource_count,
        no_of_affected_people,
        description,
        contact_number,
        priority_level
    ) VALUES (
        $req_id,
        $user_id,
        $location_id,
        $user_id,
        '$req_name',
        '$req_type',
        '$resource_type',
        '$resource_count',
        '$no_of_affected_people',
        '$description',
        '$contact_number',
        '$priority_level'
    )";

    if ($conn->query($sql) === TRUE) {
        return 'success';
    } else {
        echo "Error inserting logged request: " . $conn->error;
    }
  
}
