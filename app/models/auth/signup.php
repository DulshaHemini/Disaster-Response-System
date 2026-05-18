<?php

function insertData($conn, $data) {

    // Common User Details
    $username = $data['username'];
    $password = $data['password'];
    $user_role = $data['user_role'];
    
    // Location Details
    $lat = $data['latitude'];
    $lon = $data['longitude'];
    $district = $data['district'];
    $city = $data['city'];
    $street = $data['street'];
    $home_no = $data['home_no'];

    // Common Profile Details
    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $nic = $data['nic'];
    $email = $data['email'];
    $contact_no = $data['contact_no'];
    $gender = $data['gender'];
    $age = empty($data['age']) ? 0 : $data['age'];

    // Affected People Details
    $no_of_family_members = empty($data['no_of_family_members']) ? 0 : $data['no_of_family_members'];

    // Volunteer Details
    $availability_status = empty($data['availability_status']) ? 'available' : $data['availability_status'];
    $organization_name = $data['organization_name'];
    $resource_name = $data['resource_name'];
    $resource_type = $data['resource_type'];
    $resource_count = empty($data['resource_count']) ? 0 : $data['resource_count'];
    $description = $data['description'];

    // Relief Team Details
    $team_name = $data['team_name'];
    $team_email = $data['team_email'];
    $team_contact = $data['team_contact'];
    $specialization = $data['specialization'];
    $no_of_members = empty($data['no_of_members']) ? 1 : $data['no_of_members'];
    $vehicle_type = $data['vehicle_type'];
    $vehicle_number = $data['vehicle_number'];


    // 1. Insert into users table
    $user_sql = "INSERT INTO users (username, password, user_role) 
                 VALUES ('$username', '$password', '$user_role')";

    if ($conn->query($user_sql)) {
        $user_id = $conn->insert_id;

        // 3. Store location data in location table
        $loc_sql = "INSERT INTO Location(user_id, latitude, longitude, district, city, street, home_no) 
                    VALUES ($user_id, '$lat', '$lon', '$district', '$city', '$street', '$home_no')";

        if ($conn->query($loc_sql)) {
            
            // 2. Store other user data in suitable table with user_id
            if ($user_role == 'affected_people') {
                
                $ap_sql = "INSERT INTO affected_people (affected_people_id, first_name, last_name, age, no_of_family_members, gender, nic, contact_no) 
                           VALUES ($user_id, '$first_name', '$last_name', $age, $no_of_family_members, '$gender', '$nic', '$contact_no')";
                if ($conn->query($ap_sql)) {
                    return 'success';
                } else {
                    echo "Error inserting affected_people: " . $conn->error;
                }

            } elseif ($user_role == 'volunteer') {
                $vol_sql = "INSERT INTO volunteer (volunteer_id, first_name, last_name, nic, gender, contact_no, age, availability_status, organization_name) 
                            VALUES ($user_id, '$first_name', '$last_name', '$nic', '$gender', '$contact_no', $age, '$availability_status', '$organization_name')";
                
                if ($conn->query($vol_sql)) {
                    if ($resource_name != '' && $resource_type != '') {
                        $res_sql = "INSERT INTO resource (volunteer_id, resource_name, resource_type, resource_count, description) 
                                    VALUES ($user_id, '$resource_name', '$resource_type', $resource_count, '$description')"; 
                        if ($conn->query($res_sql)) {
                            return 'success';
                        } else {
                            echo "Error inserting resource: " . $conn->error;
                        }
                    } else {
                        return 'success';
                    }
                } else {
                    echo "Error inserting volunteer: " . $conn->error;
                }

            } elseif ($user_role == 'relief_team') {
                $rt_sql = "INSERT INTO relief_team (relief_team_id, team_name, email, contact_no, specialization, no_of_members, vehicle_type, vehicle_number) 
                           VALUES ($user_id, '$team_name', '$email', '$contact_no', '$specialization', $no_of_members, '$vehicle_type', '$vehicle_number')";
                if ($conn->query($rt_sql)) {
                    return 'success';
                } else {
                    echo "Error inserting relief team: " . $conn->error;
                }

            } else {
                return 'success';
            }

        } else {
            echo "Error inserting location: " . $conn->error;
        }
        
    } else {
        echo "Error inserting user: " . $conn->error;
    }
}

?>