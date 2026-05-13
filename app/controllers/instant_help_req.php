<?php

require_once '../../config/config.php';

$lat = "";
$lon = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // GET LOCATION
    $lat = $_POST['lat'] ?? '';
    $lon = $_POST['lon'] ?? '';

    // GET FORM DATA
    $name = trim($_POST['name'] ?? '');
    $req_name = trim($_POST['req_name'] ?? '');
    $res_type = $_POST['resource_type'] ?? '';
    $res_count = $_POST['resource_count'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';

    // VALIDATION

    if (!preg_match('/^07[0-9]{8}$/', $contact_number)) {
        die("Invalid Sri Lankan mobile number");
    }

    $loc_sql = "INSERT INTO Location(latitude, longitude)
                VALUES ('$lat', '$lon')";

    if ($conn->query($loc_sql)) {

        $loc_id = $conn->insert_id;

        $req_sql = "INSERT INTO requests(request_type)
                    VALUES('Instant_Request')";

        if ($conn->query($req_sql)) {

            $req_id = $conn->insert_id;

            $instant_sql = "INSERT INTO Instant_Request
            (req_id, loc_id, full_name, req_name,
            resource_type, resource_count,
            contact_number)
            VALUES('$req_id', '$loc_id', '$name','$req_name', '$res_type','$res_count', '$contact_number')";

            if ($conn->query($instant_sql)) {
                echo "<script>alert('Request Submitted Successfully');</script>";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚨 Instant Help Request</title>

    <style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #eef2f7, #f8fbff);
        margin: 0;
        padding: 0;
        }
    
    .container {
        width: 600px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        border-top: 3px solid #c8102e;
        border-bottom: 3px solid #c8102e;
        }

    .box {
        background: #f9fafc;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 10px;
        border: 1px solid #e6e6e6;
    }

    .back-home{
            align-self: flex-start;
            margin-bottom: 1rem;
            text-decoration: none;
            font-size: 16px;
        }

    .data-form{
            width: 90%;
            padding: 0;
            margin: 0 ;
        }

    .top-text {
            text-align: center;
            margin-bottom: 20px;
        }

    label {
            font-weight: bold;
        }

    input, select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        outline: none;
        transition: 0.2s;
        box-sizing: border-box;
        }

    input:focus, select:focus, textarea:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0,123,255,0.2);
    }

    button {
        width: 100%;
        padding: 12px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 15px;
        margin-top: 10px;
        transition: 0.2s;
        }

    button:hover {
            background: #0056b3;
        }

    .error {
            color: red;
            font-size: 14px;
        }

    #map, iframe {
        width: 100%;
        height: 350px;
        border-radius: 10px;
        margin-top: 10px;
        border: none;
    }
</style>
</head>

<body>
    <div class="container">
        <a href="../" class="back-home" onclick="window.history.back();return false;">← BACK TO HOME</a>

        <h1 class="top-text">🚨 Instant Help Request</h1>

        <div class="box">
            <form method="POST" id="instantHelp">

                <label id="nameLabel">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter Your Name" required>

                <label>Request Name</label>
                <input type="text" name="req_name" placeholder="What is the issue" required>

                <label>Request Type</label>
                <select name="req_type" id="req_type" required>

                <option value="">Select Request Type</option>

                <option value="tornadoes">Tornadoes</option>
                <option value="tsunamis">Tsunamis</option>
                <option value="landslides">Landslides</option>
                <option value="Flood">Flood</option>
                <option value="heat waves">Heat Waves</option>
                <option value="Droughts">Droughts</option>
                <option value="Strong Winds and Cyclones">Strong Winds and Cyclones</option>

                </select>
                    <label>Number Of affected People</label>
                    <input type="number" name="aff_pp" min="1" value="1">

                    <label>Resource Type</label>
                    <select name="resource_type" required>

                    <option value="">Select Resource Type</option>
                    <option value="food">Food</option>
                    <option value="water">Water</option>
                    <option value="medicine">Medicine</option>
                    <option value="shelter">Shelter</option>
                    <option value="clothes">Clothes</option>
                    <option value="rescue">Rescue Team</option>
                    <option value="electricity">Electricity Support</option>
                    <option value="communication">Communication Support</option>
                </select>

                <label>Resource Count</label>
                <input type="number" name="resource_count" min="1" value="1">

                <label>Contact Number</label>
                <input type="tel" name="contact_number" id="contactnumber" pattern="^07[0-9]{8}$" placeholder="07XXXXXXXX" maxlength="10" required>
                <span id="phoneError" style="color:red; font-size:14px;"></span>  <br>  

                <label>Email</label>
                <input type="email" name="email" placeholder="example@email.com" >

                <label>Priority</label>
                <select name="priority_level" required>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                    <option value="high">High</option>
                </select><br><br>

                <label>Location</label>
                <button type="button" onclick="getLocation()">Get My Location</button>

                
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lon" id="lon">

                <iframe
                    id="map"
                    loading="lazy"
                    allowfullscreen
                    src="<?php
                        if ($lat && $lon) {
                            echo "https://www.google.com/maps?q=$lat,$lon&output=embed&z=14";
                        } else {
                            echo "https://www.google.com/maps?q=7.8731,80.7718&output=embed&z=7";
                        }
                    ?>">
                </iframe>

                <br><br>
                <button type="submit">Submit Request</button>

            </form>
        </div>
    </div>

<script>

    document.getElementById("instantHelp").addEventListener("submit", function(event) {
    const name = document.getElementById("name").value.trim();
    if (name === "") {
        //alert("Name cannot be empty");
        document.getElementById("nameLabel").innerHTML = "<span style='color:red;'>Name cannot be empty</span>";
        event.preventDefault();
    }
});

    document.getElementById("contactnumber").addEventListener("input",function(){
        const phone = this.value;
        const error = document.getElementById("phoneError");

        this.value = this.value.replace(/\D/g, '');
        if (phone.length === 0) {
            error.textContent = "";
        }
        else if (!/^07[0-9]{8}$/.test(phone)) {
            error.textContent = "Enter valid Sri Lankan mobile number";
        }
        else {
            error.textContent = "";
        }
    });

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(setLocation, showError);
    } else {
        alert("Geolocation is not supported by your browser.");
    }
}

function setLocation(position) {
    const lat = position.coords.latitude;
    const lon = position.coords.longitude;

    document.getElementById("lat").value = lat;
    document.getElementById("lon").value = lon;

    document.getElementById("map").src =
        `https://www.google.com/maps?q=${lat},${lon}&output=embed&z=14`;
}

function showError(error) {
    alert("Error getting location: " + error.message);
}
</script>

</body>
</html>
