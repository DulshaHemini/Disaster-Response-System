<?PHP

function storeInstantHelp($conn, $data) {

    $lat = $data['lat'];
    $lon = $data['lon'];
    $name = $data['name'];
    $req_name = $data['req_name'];
    $req_type = $data['req_type'];
    $affected_people = $data['affected_people'];
    $res_type = $data['res_type'];
    $res_count = $data['res_count'];
    $contact_number = $data['contact_number'];
    $email = $data['email'];
    $priority = $data['priority'];

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
    echo "Priority: " . $priority . "<br>";
    */

    function generateInstantHelpCredentials($conn){
        do {
            $username = "guest_" . random_int(1000, 9999);
            $check = $conn->query(
                "SELECT user_id FROM users WHERE username = '$username'"
            );
        } while($check->num_rows > 0);
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for($i = 0; $i < 8; $i++){
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return [
            'username' => $username,
            'password' => $password
        ];
    }

    $credentials = generateInstantHelpCredentials($conn);

    $user_sql = "INSERT INTO users (username, password, user_role)
                VALUES ('{$credentials['username']}', '{$credentials['password']}', 'guest')";

    if ($conn->query($user_sql)) {
        $user_id = $conn->insert_id;
    } else {
        echo "Error inserting user: " . $conn->error;
        return;
    }

    $loc_sql = "INSERT INTO Location(user_id, latitude, longitude)
                VALUES ($user_id, '$lat', '$lon')";

    if ($conn->query($loc_sql)) {
        $loc_id = $conn->insert_id;

        $req_sql = "INSERT INTO requests(request_type) VALUES ('Instant_Request')";

        if ($conn->query($req_sql)) {
            $req_id = $conn->insert_id;

            $instant_sql = "INSERT INTO Instant_Request
            (req_id, user_id, loc_id, full_name, req_name, resource_type, resource_count, contact_number)
            VALUES($req_id, $user_id, $loc_id, '$name', '$req_name', '$res_type', '$res_count', '$contact_number')";

            if ($conn->query($instant_sql)) {
                return 'success';
            } else {
                echo "Error inserting request: " . $conn->error;
            }
        } else {
            echo "Error inserting request type: " . $conn->error;
        }
    } else {
        echo "Error inserting location: " . $conn->error;
    }
}

?>