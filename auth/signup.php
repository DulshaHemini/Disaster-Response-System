<?php
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
<title>Registration Form</title>

<style>
    body {
        font-family: Arial;
        background: #f4f4f4;
    }

    .container {
        width: 500px;
        margin: 40px auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
    }

    .step {
        display: none;
    }

    .active {
        display: block;
    }

    input, select {
        width: 100%;
        padding: 8px;
        margin: 8px 0;
    }

    button {
        padding: 10px;
        width: 100%;
        background: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        margin-top: 10px;
    }

    button:hover {
        background: #0056b3;
    }

    label {
        font-weight: bold;
        display: block;
        margin-top: 10px;
    }

    #map {
                width: 500px;
                height: 400px;
                border-radius: 8px;
                margin-top: 15px;
                border: none;
            }
</style>
</head>

<body>

<div class="container">

<form id="regForm" method="POST" action="Controller/RegisterController.php">

    <!-- STEP 1 -->
    <div class="step active" id="step1">
        <h3>User Registration</h3>

        <label>Username</label>
        <input type="text" name="username" placeholder="Enter username" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <label>User Role</label>
        <select name="user_role" id="role" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="affected_people">Affected People</option>
            <option value="volunteer">Volunteer</option>
        </select>

        <button type="button" onclick="nextStep()">Next</button>
    </div>

    <!-- ADMIN -->
    <div class="step" id="adminForm">
        <h3>Admin Details</h3>

        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="gamageparanavithana@gmail.com">

        <label>Contact Number</label>
        <input type="text" name="contact_no" placeholder="+94 xxxxxxxxx">

        <button type="submit">Register</button>
    </div>

    <!-- AFFECTED PEOPLE -->
    <div class="step" id="affectedForm">
        <h3>Affected People Details</h3>

        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>NIC</label>
        <input type="text" name="nic">

        <label>Contact Number</label>
        <input type="text" name="contact_no" placeholder="+94 xxxxxxxxx">

        <label>No of Family Members</label>
        <input type="number" name="no_of_family_members">

        <label>Priority Level</label>
        <select name="priority_level">
            <option value="">Select Priority Level</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>

        <button type="submit">Register</button>
    </div>

    <!-- VOLUNTEER -->
    <div class="step" id="volunteerForm">
        <h3>Volunteer Details</h3>

        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>NIC</label>
        <input type="text" name="nic">

        <label>Contact Number</label>
        <input type="text" name="contact_no" placeholder="+94 xxxxxxxxx">

        <label>Availability Status</label>
        <select name="availability_status">
            <option value="available" selected>Available</option>
            <option value="busy">Busy</option>
        </select>

        <label>Organization Name</label>
        <input type="text" name="organization_name">

        <button type="button" onclick="getLocation()">Get My Location</button><br><br>
        <iframe
            id="map"
            style="border:0; border-radius:8px;"
            loading="lazy"
            allowfullscreen
            src="<?php
                // Default = Sri Lanka, user location after POST
                if ($lat && $lon) {
                    echo "https://www.google.com/maps?q=$lat,$lon&output=embed&z=14";
                } else {
                    echo "https://www.google.com/maps?q=7.8731,80.7718&output=embed&z=7";
                }
            ?>">
        </iframe>

        <button type="submit">Register</button>
    </div>

</form>

</div>

<script>
function nextStep() {
    let role = document.getElementById("role").value;

    document.getElementById("step1").classList.remove("active");

    if (role === "admin") {
        document.getElementById("adminForm").classList.add("active");
    } 
    else if (role === "affected_people") {
        document.getElementById("affectedForm").classList.add("active");
    } 
    else if (role === "volunteer") {
        document.getElementById("volunteerForm").classList.add("active");
    } 
    else {
        alert("Please select a role");
        document.getElementById("step1").classList.add("active");
    }
}

function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(sendToPHP, showError);
            } else {
                alert("Geolocation is not supported by your browser.");
            }
            }

            function sendToPHP(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            // Submit coordinates to PHP
            const form = document.createElement("form");
            form.method = "POST";
            form.action = "";

            const latInput = document.createElement("input");
            latInput.type = "hidden";
            latInput.name = "lat";
            latInput.value = lat;

            const lonInput = document.createElement("input");
            lonInput.type = "hidden";
            lonInput.name = "lon";
            lonInput.value = lon;

            form.appendChild(latInput);
            form.appendChild(lonInput);
            document.body.appendChild(form);
            form.submit();
        }

        function showError(error) {
            alert("Error getting location: " + error.message);
        }
        
</script>

</body>
</html>