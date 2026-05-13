<?php

require_once __DIR__ . "/../../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = 7;
    
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

    $sql_location = "UPDATE Location SET
        latitude = $latitude,
        longitude = $longitude,
        district = '$district',
        city = '$city',
        street = '$street',
        home_no = '$home_no'
    WHERE user_id = $user_id";

    if ($conn->query($sql_location) === TRUE) {
            $get_location = "SELECT loc_id FROM Location WHERE user_id = $user_id";
            $result = $conn->query($get_location);
            $row = $result->fetch_assoc();
            $location_id = $row['loc_id'];
    } else {
            echo "Error updating location: " . $conn->error;
    }

    $sql = "INSERT INTO requests(request_type) VALUES ('Logged_Request')";
    if ($conn->query($sql) === TRUE) {
        $req_id = $conn->insert_id; //get the generated request_id
    } else {
        echo "Error inserting request: " . $conn->error;
    }

    $sql = "INSERT INTO Logged_Request(
        req_id,
        user_id,
        loc_id,
        affected_people_id,
        req_name,
        req_type,
        resource_type,
        resource_count,
        description,
        No_of_affected_people,
        contact_number,
        priority_level
       
        )
        VALUES (
        $req_id,
        $user_id,
        $location_id,
        $user_id,
        '$request_name',
        '$request_type',
        '$resource_type',
        '$resource_count',
        '$affected_people',
        '$description',
        '$contact_number',
        '$priority'
    )";

     if ($conn->query($sql) === TRUE) {
        header("Location: Affected_People_Dashboard.php");
        exit;
    } else {
        echo "Error inserting logged request: " . $conn->error;
    }

}
       
$name = "Dilshan Perera"; // Replace with actual user name from session or database

?>

<html>
    <head>
        <title>Logged Request</title>
       <style>

    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #eef2f7, #f8fbff);
        margin: 0;
        padding: 20px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Main Form Container */
    .container {
        width: 100%;
        max-width: 700px;
        margin: 30px auto;
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

    /* Heading */
    h1 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
        font-size: 32px;
    }

    /* Labels */
    label {
        font-weight: 600;
        display: block;
        margin-top: 10px;
        margin-bottom: 5px;
        color: #444;
    }

    /* Inputs */
    input,
    select,
    textarea {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        outline: none;
        transition: 0.2s;
        margin-bottom: 15px;
        font-size: 14px;
    }

    /* Focus Effect */
    input:focus,
    select:focus,
    textarea:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0,123,255,0.2);
    }

    /* Textarea */
    textarea {
        resize: vertical;
    }

    /* Buttons */
    button {
        width: 100%;
        padding: 12px;
        background: #c8102e;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 15px;
        margin-top: 10px;
        transition: 0.2s;
    }

    button:hover {
        background: #a00b1e;
    }

    /* Map Styling */
    #map,
    iframe {
        width: 100%;
        height: 350px;
        border-radius: 10px;
        margin-top: 10px;
        border: none;
    }

    /* Other Resource Box */
    #otherResourceDiv {
        background: #f9fafc;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #e6e6e6;
        margin-bottom: 15px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        form {
            padding: 20px;
        }

        h1 {
            font-size: 26px;
        }
    }

    </style>
    </head>

    <body>
        
        <div class="container">
        <h1>Request Submission Form</h1>
            <div class="box">
                <form method="POST" id="helpNeeder">

                <label>Name:</label>
                <input type="text" name="username" id="username" value="<?= $name ?>" placeholder="Enter Your Name" required>

                <label>Request Name</label>
                <input type="text" name="request_name" reqiured>
                
                <label>Request Type:</label>
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
            

                <label>Description:</label>
                <textarea name="description" rows="5" cols="40" placeholder="Describe your issue clearly..."></textarea>

                <label>Number Of affected People: </label>
                <input type="text" name="affected_people" pattern="[0-9]+">

                <label>Resource Type:</label>

                <select name="resource_type" id="resource_type" onchange="showOtherField()" required>
                    <option value="">Select Resource Type</option>
                    <option value="medicine">Medicine</option>
                    <option value="foods">Foods</option>
                    <option value="shelters">Shelters</option>
                    <option value="clothes">Clothes</option>
                    <option value="money">Water</option>
                    <option value="rescue">Rescue Team</option>
                    <option value="electricity">Electricity Support</option>
                    <option value="communication">Communication Suport</option>
                    <option value="other">Other</option>
                </select>

                <div id="otherResourceDiv" style="display:none;">
                    <label>Enter Resource Type:</label>
                    <input type="text" name="other_resource_type" placeholder="Type resource type">
                </div>

                <script>
                    function showOtherField() {
                        const resourceType = document.getElementById("resource_type").value;
                        const otherDiv = document.getElementById("otherResourceDiv");

                        if (resourceType === "other") {
                            otherDiv.style.display = "block";
                        } else {
                            otherDiv.style.display = "none";
                        }
                }
                </script>

                <label>Resource Count: </label>
                <input type="text" name="resource_count" required>

                <label>Contact Number: </label>
                <input type="text" name="contact_number" id="contact_number" placeholder="Phone Number" required>

                <label>E mail: </label>
                <input type="text" name="email" id="email" placeholder="email">

                <label>City:</label>
                <input type="text" name="city" id="city" placeholder="city">

                <label>Street:</label>
                <input type="text" name="street" id="street" placeholder="street">

                <label>Home Number: </label>
                <input type="text" name="home_number" id="home_number" placeholder="Home number">

                <label>Priority:</label>
                <select name="priority_level" required >
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                    <option value="high">High</option>
                </select>

                <label>Select District</label>

                <input type="text" name="district" list="districtlist" placeholder="Type or select district" required>

                <datalist id="districtlist">
                    <option value="Ampara">
                    <option value="Anuradhapura">
                    <option value="Badulla">
                    <option value="Batticaloa">
                    <option value="Colombo">
                    <option value="Galle">
                    <option value="Gampaha">
                    <option value="Hambantota">
                    <option value="Jaffna">
                    <option value="Kalutara">
                    <option value="Kandy">
                    <option value="Kegalle">
                    <option value="Kilinochchi">
                    <option value="Kurunegala">
                    <option value="Mannar">
                    <option value="Matale">
                    <option value="Matara">
                    <option value="Monaragala">
                    <option value="Mullaitivu">
                    <option value="Nuwara Eliya">
                    <option value="Polonnaruwa">
                    <option value="Puttalam">
                    <option value="Ratnapura">
                    <option value="Trincomalee">
                    <option value="Vavuniya">
                </datalist>

                <label>Location:</label>
                

                <!-- Hidden Latitude & Longitude -->
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lon" id="lon">

                <!-- Location Preview Button -->
                <button class="location-but" type="button" onclick="previewLocation()">
                    Show My Location
                </button>

                

                <!-- Google Map -->
                <iframe
                    id="affected_map"
                    width="500"
                    height="300"
                    style="border:0; border-radius:10px;"
                    loading="lazy"
                    allowfullscreen
                    src="https://www.google.com/maps?q=7.8731,80.7718&output=embed&z=7">
                </iframe>
                

                <button type="submit">Submit Request</button>
                </form>
            </div>
        </div>

        <script>

        document.getElementById("helpNeeder").addEventListener("submit", function(event){

            let reqType = document.querySelector("input[name='req_type']").value.trim();
            let district = document.querySelector("input[name='district']").value.trim();
            let description = document.querySelector("textarea[name='description']").value.trim();
            let affectedPeople = document.querySelector("input[name='affected_people']").value;
            let resourceType = document.getElementById("resource_type").value;
            let resourceCount = document.querySelector("input[name='resource_count']").value;
            let contact = document.getElementById("contact_number").value.trim();
            let email = document.getElementById("email").value.trim();
            let city = document.getElementById("city").value.trim();
            let street = document.getElementById("street").value.trim();
            let otherResource = document.querySelector("input[name='other_resource_type']").value.trim();

            if(reqType === ""){
                alert("Please enter request type");
                event.preventDefault();
                return;
            }

            if(district === ""){
                alert("Please select district");
                event.preventDefault();
                return;
            }

            if(description === ""){
                alert("Please enter description");
                event.preventDefault();
                return;
            }

            if(affectedPeople <= 0 || affectedPeople === ""){
                alert("Enter valid affected people count");
                event.preventDefault();
                return;
            }

            if(resourceType === ""){
                alert("Please select resource type");
                event.preventDefault();
                return;
            }

            if(resourceType === "other" && otherResource === ""){
                alert("Please specify other resource type");
                event.preventDefault();
                return;
            }

            if(resourceCount <= 0 || resourceCount === ""){
                alert("Enter valid resource count");
                event.preventDefault();
                return;
            }

            if(!/^07[0-9]{8}$/.test(contact)){
                alert("Enter valid Sri Lankan contact number");
                event.preventDefault();
                return;
            }

            if(email !== "" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){
                alert("Enter valid email address");
                event.preventDefault();
                return;
            }

            if(city === ""){
                alert("Please enter city");
                event.preventDefault();
                return;
            }

            if(street === ""){
                alert("Please enter street");
                event.preventDefault();
                return;
            }

            this.reset();

        });

        //GET LOCATION
    function previewLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        // Save into hidden inputs
                        document.getElementById("lat").value = lat;
                        document.getElementById("lon").value = lon;
                        // Update Google Map
                        document.getElementById("affected_map").src =
                            `https://www.google.com/maps?q=${lat},${lon}&output=embed&z=14`;
                    },
                    function(error) {
                        alert(error.message);
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
            }
            document.getElementById("affectedForm").addEventListener("submit", function(event) {
            // Prevent immediate submit
            event.preventDefault();
            // If location already fetched
            if (
                document.getElementById("lat").value !== "" &&
                document.getElementById("lon").value !== ""
            ) {
                this.submit();
                return;
            }
            // Otherwise get location first
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        // Store values
                        document.getElementById("lat").value = lat;
                        document.getElementById("lon").value = lon;
                        // Update map
                        document.getElementById("affected_map").src =
                            `https://www.google.com/maps?q=${lat},${lon}&output=embed&z=14`;
                        // Submit form AFTER getting location
                        document.getElementById("affectedForm").submit();
                    },
                    function(error) {
                        alert(error.message);
                    }
                );
            } else {
                alert("Geolocation not supported.");
            }
        });

        </script>

    </body>
</html>