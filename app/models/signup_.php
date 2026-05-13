<?php

    //insert into users table with user_id, username, password, user_role
    $sql = "INSERT INTO users (username, password, user_role) VALUES ('$username', '$password', '$user_role')";
    if ($conn->query($sql) === TRUE) {
        $user_id = $conn->insert_id; // Get the generated user_id

        // Insert into location table
        $sql = "INSERT INTO Location (user_id, latitude, longitude, district, city, street, home_no) VALUES ('$user_id', '$lat', '$lon', '$district', '$city', '$street', '$home_no')";
        $conn->query($sql);

        if ($user_role == 'affected_people') {
            // Insert into affected_people table
            $sql = "INSERT INTO affected_people (affected_people_id, first_name, last_name, age, no_of_family_members) VALUES ('$user_id', '$first_name', '$last_name', '$age', '$no_of_family_members')";
            $conn->query($sql);
        } elseif ($user_role == 'volunteer') {
            // Insert into volunteer table
            $sql = "INSERT INTO volunteer (volunteer_id, first_name, last_name, nic, gender, contact_no, age, availability_status, organization_name) VALUES ('$user_id', '$first_name', '$last_name', '$nic', '$gender', '$contact_no', '$age', '$availability_status', '$organization_name')";
            $conn->query($sql);
                // Insert into resource table if resource details are provided
            if (!empty($resource_name) && !empty($resource_type) && !empty($resource_count)) {
                $sql = "INSERT INTO resource (volunteer_id, resource_name, resource_type, resource_count, description) VALUES ('$user_id', '$resource_name', '$resource_type', '$resource_count', '$description')";
                $conn->query($sql);
            }
        } elseif ($user_role == 'admin') {
            // Insert into admin table
            $sql = "INSERT INTO admin (user_id, first_name, last_name, gender, age, email, contact_no) VALUES ('$user_id', '$first_name', '$last_name', '$gender', '$age', '$email', '$contact_no')";
            $conn->query($sql);
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    //redirect to home page after registration
    header("Location: ../../public/");

?>