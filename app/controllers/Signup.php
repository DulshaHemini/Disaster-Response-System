
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
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }
    
    .container {
            width: 500px;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

    h2 {
            text-align: center;
            margin-bottom: 20px;
        }

    label {
            font-weight: bold;
        }

    input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

    button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

    button:hover {
            background: #0056b3;
        }

    .error {
            color: red;
            font-size: 14px;
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
    <h2>User Registration</h2>

    <form action="submit.php" method="POST" onsubmit="return validateForm()">

        <label>Full Name:</label>
        <input type="text" name="full_name" required>

        <label>Email:</label>
        <input type="email" name="email" id="email" placeholder="example@gmail.com">

        <label>Username:</label>
        <input type="text" name="username" id="username" required>

        <label>Password:</label>
        <input type="password" name="password" id="password" required>

        <label>User Role:</label>
        <select name="user_role" id="user_role" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="affected_people">Affected People</option>
            <option value="volunteer">Volunteer</option>
        </select>

        

        

        <label>Contact No:</label>
        <input type="text" name="contact_no" id="contact_no" placeholder="+94 712345678">

        <label>Age:</label>
        <input type="number" name="age" id="age" min="1" max="99">

        <label>Gender:</label>
        <select name="gender">
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label>NIC:</label>
        <input type="text" name="nic" id="nic">

        <label>No. of Family Members:</label>
        <input type="number" name="no_of_family_members">

        <label>Priority Level:</label>
        <select name="priority_level">
            <option value="">Select Priority</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>

        <label>Availability Status:</label>
        <select name="availability_status">
            <option value="available" selected>Available</option>
            <option value="busy">Busy</option>
        </select>

        <label>Organization Name:</label>
        <input type="text" name="organization_name">

        <div id="errorMsg" class="error"></div>

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

    </form>
</div>


<script>

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
        
function validateForm() {
    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value.trim();
    let email = document.getElementById("email").value.trim();
    let contact = document.getElementById("contact_no").value.trim();
    let age = document.getElementById("age").value.trim();
    let nic = document.getElementById("nic").value.trim();
    let role = document.getElementById("user_role").value;

    let errorMsg = "";

    // Username validation
    if (username.length < 4) {
        errorMsg += "Username must be at least 4 characters long.<br>";
    }

    // Password validation
    if (password.length < 6) {
        errorMsg += "Password must be at least 6 characters long.<br>";
    }

    // Role validation
    if (role === "") {
        errorMsg += "Please select a user role.<br>";
    }

    // Email validation
    let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (email !== "" && !email.match(emailPattern)) {
        errorMsg += "Invalid email format.<br>";
    }

    // Contact number validation (Sri Lanka format)
    let phonePattern = /^(\+94|0)[0-9]{9}$/;
    if (contact !== "" && !contact.match(phonePattern)) {
        errorMsg += "Invalid contact number (use +947XXXXXXXX or 07XXXXXXXX).<br>";
    }

    // Age validation
    if (age !== "" && (age < 1 || age > 99)) {
        errorMsg += "Age must be between 1 and 99.<br>";
    }

    // NIC validation (old + new)
    let nicPattern = /^([0-9]{9}[vVxX]|[0-9]{12})$/;
    if (nic !== "" && !nic.match(nicPattern)) {
        errorMsg += "Invalid NIC format.<br>";
    }

    // Show errors
    if (errorMsg !== "") {
        document.getElementById("errorMsg").innerHTML = errorMsg;
        return false;
    }

    return true;
}

</script>

</body>
</html>