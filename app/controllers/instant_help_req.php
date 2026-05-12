<?php

require_once '../../config/config.php';

$lat = "";
$lon = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lat = $_POST['lat'] ?? '';
    $lon = $_POST['lon'] ?? '';

    $name = trim($_POST['name'] ?? '');
    $req_name = trim($_POST['req_name'] ?? '');
    $req_type = $_POST['req_type'] ?? '';
    $description = $_POST['description'] ?? '';
    $num_aff_pp = $_POST['aff_pp'] ?? '';
    $res_count = $_POST['resource_count'] ?? '';
    $res_type = $_POST['resource_type'] ?? '' ;
    $contact_number = $_POST['contact_number'] ?? '';
    $email = $_POST['email'] ?? '' ;
    $priority = $_POST['priority'] ?? '';



    $sql = "INSERT INTO users VALUES
        ($name,  )";
        
    $sql = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instant Help Request</title>

    <style>
        #map {
            width: 500px;
            height: 400px;
            border-radius: 8px;
            margin-top: 15px;
            border: none;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .auth-card {
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 28px;
            width: 100%;
            max-width: 460px;
            padding: 2.4rem 2rem 2.8rem 2rem;
            box-shadow: 0 20px 35px -12px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }

        .brand-icon {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.8rem;
        }

         body {
      background: var(--off);
      font-family: var(--font-bd);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    h1 {
      font-family: var(--font-hd);
      font-size: 1.9rem;
      margin-bottom: 0.5rem;
      line-height: 1.2;
    }

    </style>
</head>

<body>
    <a href="../" class="back-home" onclick="window.history.back();return false;">← BACK TO DRCS</a>

    <div class="auth-card"><div>
    <div class="logo-icon"></div>

<h1>Instant Help Request</h1>

<form method="POST" id="instantHelp">

    <label>Name:</label>*<br>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" required><br><br>

    <label>Request Name:</label>*<br>
    <input type="text" name="req_name" placeholder="What is the issue" required><br><br>

    <label>Request Type:</label>
    <select name="req_type" id="req_type">
        <option value="">Select Request Type</option>
        <option value="tornados">Tornados</option>
        <option value="tsunamis">Tsunamis</option>
        <option value="landslides">Landslides</option>
        <option value="avalanches">Avalanches</option>
        <option value="heat_waves">Heat Waves</option>
    </select> <br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="5" cols="40" placeholder="Describe your issue clearly..."></textarea><br><br>

    <label>Number Of affected People:</label>*<br>
    <input type="number" name="aff_pp" min="1"><br><br>

    <label>Resource Count:</label>*<br>
    <input type="number" name="resource_count" min="1"><br><br>

    <label>Resource Type:</label>*<br>
    <select name="resource_type" required>

    <option value="">Select Resource Type</option>
    <option value="food">Food</option>
    <option value="water">Water</option>
    <option value="medical">Medical Supplies</option>
    <option value="medicine">Medicine</option>
    <option value="shelter">Shelter</option>
    <option value="clothes">Clothes</option>
    <option value="transport">Transport</option>
    <option value="rescue">Rescue Team</option>
    <option value="electricity">Electricity Support</option>
    <option value="communication">Communication Support</option>
</select>

<br><br>

    <label>Contact Number:</label>*<br>
    <input type="tel" name="contact_number" id="contactnumber" pattern="^07[0-9]{8}$" placeholder="07XXXXXXXX" maxlength="10" required><br><br>
    <span id="phoneError" style="color:red; font-size:14px;"></span>    

    <label>Email:</label>*<br>
    <input type="email" name="email" placeholder="example@email.com" required><br><br>

    <label>Priority:</label><br>
    <select name="priority_level" required>
        <option value="medium">Medium</option>
        <option value="low">Low</option>
        <option value="high">High</option>
    </select><br><br>

    <label>Location:</label>*<br>
    <button type="button" onclick="getLocation()">Get My Location</button><br><br>

    
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

<script>
    document.getElementById("instanthelp").addEventListener("submit", function(event) {
        const name = document.getElementById("name").value.trim();

        if (name === "" && pwd === "") {
            alert("Username and Password cannot be empty!");
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
