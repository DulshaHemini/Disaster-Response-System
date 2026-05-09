<?php

require_once '../../config/config.php';

$lat = "";
$lon = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lat = $_POST['lat'] ?? '';
    $lon = $_POST['lon'] ?? '';
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

    
    <div class="auth-card">
    <div class="logo-icon">
    </div>

<h1>Instant Help Request</h1>

<form method="POST" id="instantHelp">

    <label>Name:</label><br>
    <input type="text" name="username" placeholder="Enter Your Name" required><br><br>

    <label>Request Name:</label><br>
    <input type="text" name="req_type" placeholder="What is the issue"><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="5" cols="40" placeholder="Describe your issue clearly..."></textarea><br><br>

    <label>Number Of affected People:</label><br>
    <input type="number" name="affected_people" min="1"><br><br>

    <label>Resource Count:</label><br>
    <input type="number" name="resource_count" min="1"><br><br>

    <label>Resource Type:</label><br>
    <input type="text" name="resource_type" required><br><br>

    <label>Contact Number:</label><br>
    <input type="tel" name="contact_number" pattern="[0-9]{10}" placeholder="07XXXXXXXX" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" placeholder="example@email.com" required><br><br>

    <label>Priority:</label><br>
    <select name="priority_level" required>
        <option value="medium">Medium</option>
        <option value="low">Low</option>
        <option value="high">High</option>
    </select><br><br>

    <label>Location:</label><br>
    <button type="button" onclick="getLocation()">Get My Location</button><br><br>

    <!-- Hidden inputs for lat/lon -->
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

    // Set hidden inputs
    document.getElementById("lat").value = lat;
    document.getElementById("lon").value = lon;

    // Update map instantly
    document.getElementById("map").src =
        `https://www.google.com/maps?q=${lat},${lon}&output=embed&z=14`;
}

function showError(error) {
    alert("Error getting location: " + error.message);
}
</script>

</body>
</html>