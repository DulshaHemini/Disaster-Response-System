
<?php

require_once '../../config/config.php';

$lat = "";
$lon = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lat = $_POST['lat'] ?? '';
    $lon = $_POST['lon'] ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $nic = $_POST['nic'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact_no = $_POST['contact_no'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $age = $_POST['age'] ?? '';
    $home_no = $_POST['home_no'] ?? '';
    $street = $_POST['street'] ?? '';
    $city = $_POST['city'] ?? '';
    $district = $_POST['district'] ?? '';
    $user_role = $_POST['user_role'] ?? '';
    $no_of_family_members = $_POST['no_of_family_members'] ?? '';
    $availability_status = $_POST['availability_status'] ?? '';
    $type = $_POST['type'] ?? '';
    $organization_name = $_POST['organization_name'] ?? '';
    $resource_name = $_POST['resource_name'] ?? '';
    $resource_type = $_POST['resource_type'] ?? '';
    $resource_count = $_POST['resource_count'] ?? '';
    $description = $_POST['description'] ?? '';

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
        background: linear-gradient(135deg, #eef2f7, #f8fbff);
        margin: 0;
        padding: 0;
    }

    /* Main container */
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

    /* Heading */
    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
    }

    /* Each section box */
    .box {
        background: #f9fafc;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 10px;
        border: 1px solid #e6e6e6;
    }

    /* Labels */
    label {
        font-weight: 600;
        display: block;
        margin-top: 10px;
        color: #444;
    }

    /* Inputs */
    input, select, textarea {
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

    /* Button */
    button {
        width: 100%;
        padding: 12px;
        background: #c3102e;
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

    /* Error text */
    .error {
        color: red;
        font-size: 13px;
    }

    /* Map styling */
    #map, iframe {
        width: 100%;
        height: 350px;
        border-radius: 10px;
        margin-top: 10px;
        border: none;
    }

    /* Radio + table alignment */
    table {
        width: 50%;
        margin-top: 10px;
    }

    td {
        padding: 5px;
    }

    /* Volunteer & affected boxes highlight */
    #affected_box {
        border-top: 3px solid #28a745;
        border-bottom: 3px solid #28a745;
    }

    #volunteer_box {
        border-top: 3px solid #007bff;
        border-bottom: 3px solid #007bff;
    }

    .back-home{
            align-self: flex-start;
            margin-bottom: 1rem;
            text-decoration: none;
            font-size: 16px;
        }
    
    .top-text {
            text-align: center;
            margin-bottom: 20px;
        }

    

</style>
</head>

<body>

<div class="container">
    <a href="../" class="back-home" onclick="window.history.back();return false;">← BACK TO HOME</a>
    <h1 class="top-text">User Registration</h1>

    <form method="POST" onsubmit="return validateForm()">

    <!--Common Data-->

    <div class="box">

        <label id="first_name_label">First Name</label>
        <input type="text" name="first_name" required>

        <label id="last_name_label">Last Name</label>
        <input type="text" name="last_name" required>

        <label id="nic_label">NIC</label>
        <input type="text" name="nic" id="nic" required>

        <label id="email_label">Email</label>
        <input type="email" name="email" id="email" placeholder="example@gmail.com">

        <label id="contact_no_label">Contact No</label>
        <input type="text" name="contact_no" id="contact_no" placeholder="0712345678" required>

        <label id="username_label">Username</label>
        <input type="text" name="username" id="username" required>

        <label id="password_label">Password</label>
        <input type="password" name="password" id="password" required>

        <label>Gender</label>
        <select name="gender">
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label id="age_label">Age</label>
        <input type="number" name="age" id="age" min="1" max="99">

        <label id="home_no_label">Home No</label>
        <input type="text" name="home_no" id="home_no">

        <label id="street_label">Street</label>
        <input type="text" name="street" id="street" required>

        <label id="city_label">City</label>
        <input type="text" name="city" id="city" required>

        <label>District</label>
        <select name="district" id="district" required>
            <option value="">Select District</option>
            <option value="Ampara">Ampara</option>
            <option value="Anuradhapura">Anuradhapura</option>
            <option value="Badulla">Badulla</option>
            <option value="Batticaloa">Batticaloa</option>
            <option value="Colombo">Colombo</option>
            <option value="Galle">Galle</option>
            <option value="Gampaha">Gampaha</option>
            <option value="Hambantota">Hambantota</option>
            <option value="Jaffna">Jaffna</option>
            <option value="Kalutara">Kalutara</option>
            <option value="Kandy">Kandy</option>
            <option value="Kegalle">Kegalle</option>
            <option value="Kilinochchi">Kilinochchi</option>
            <option value="Kurunegala">Kurunegala</option>
            <option value="Mannar">Mannar</option>
            <option value="Matale">Matale</option>
            <option value="Matara">Matara</option>
            <option value="Monaragala">Monaragala</option>
            <option value="Mullaitivu">Mullaitivu</option>
            <option value="Nuwara Eliya">Nuwara Eliya</option>
            <option value="Polonnaruwa">Polonnaruwa</option>
            <option value="Puttalam">Puttalam</option>
            <option value="Ratnapura">Ratnapura</option>
            <option value="Trincomalee">Trincomalee</option>
            <option value="Vavuniya">Vavuniya</option>
        </select>


        <label>User Role</label>
        <select name="user_role" id="user_role" onchange="showRoleFields()" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="affected_people">Affected People</option>
            <option value="volunteer">Volunteer</option>
        </select>        
    </div>

    <!-- Affected People Fields -->
    <div class="box" id="affected_box" style="display:none;">
        <label>No. of Family Members</label>
        <input type="number" name="no_of_family_members">

        <!-- Hidden Latitude & Longitude -->
        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="lon" id="lon">

        <!-- Location Preview Button -->
        <button type="button" onclick="previewLocation()">
            Show My Location
        </button>

        <br><br>

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
    </div>

    <!-- Volunteer Fields -->
    <div class="box" id="volunteer_box" style="display:none;">
        <label>Availability Status</label>
        <select name="availability_status">
            <option value="available" selected>Available</option>
            <option value="busy">Busy</option>
        </select>

        <table>
            <tr>
                <td colspan="2">
                    <p>Are you an organization or a person?</p>
                </td>
            </tr>

            <tr>
                <td>
                    <label for="person">Person</label>
                </td>
                <td>
                    <input type="radio" id="person" name="type" value="Person" onclick="showOrganizationField()">
                </td>
            </tr>

            <tr>
                <td>
                    <label for="organization">Organization</label>
                </td>
                <td>
                    <input type="radio" id="organization" name="type" value="Organization" onclick="showOrganizationField()">
                </td>
            </tr>

            <tr id="organization_name_div" style="display:none;">
                <td>
                    <label for="organization_name" id="organization_name_label">Organization Name</label>
                </td>
                <td>
                    <input type="text" id="organization_name" name="organization_name">
                </td>
            </tr>
        </table>

        <label for="resource_name" id="resource_name_label">Resource Name</label><br>
        <input type="text" id="resource_name" name="resource_name"><br><br>

        <label for="resource_type">Resource Type</label><br>

        <select id="resource_type" name="resource_type">
            <option value="">-- Select Resource Type --</option>
            <option value="food">Food</option>
            <option value="water">Water</option>
            <option value="medicine">Medicine</option>
            <option value="shelter">Shelter</option>
            <option value="clothes">Clothes</option>
            <option value="rescue">Rescue</option>
            <option value="electricity">Electricity</option>
            <option value="communication">Communication</option>
        </select><br><br>

        <label for="resource_count">Resource Count</label><br>
        <input type="number" id="resource_count" name="resource_count"><br><br>

        <label for="description" id="description_label">Description</label><br>
        <textarea id="description" name="description" rows="4" cols="30"></textarea><br><br>

        <!-- Hidden Latitude & Longitude -->
        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="lon" id="lon">

        <!-- Location Preview Button -->
        <button type="button" onclick="previewLocation()">
            Show My Location
        </button>

        <br><br>

        <!-- Google Map -->
        <iframe
            id="volunteer_map"
            width="500"
            height="300"
            style="border:0; border-radius:10px;"
            loading="lazy"
            allowfullscreen
            src="https://www.google.com/maps?q=7.8731,80.7718&output=embed&z=7">
        </iframe>
    </div>

    <button type="submit">Register</button>

    </form>
</div>


<script>

    // SHOW BOXES BASED ON ROLE
    function showRoleFields() {
        var role = document.getElementById("user_role").value;

        var affectedBox = document.getElementById("affected_box");
        var volunteerBox = document.getElementById("volunteer_box");

        affectedBox.style.display = "none";
        volunteerBox.style.display = "none";

        if (role === "affected_people") {
            affectedBox.style.display = "block";
        }

        if (role === "volunteer") {
            volunteerBox.style.display = "block";
        }
    }

    // SHOW ORGANIZATION FIELD
    function showOrganizationField() {
            var organizationField = document.getElementById("organization_name_div");
            var organizationRadio = document.getElementById("organization");

            if (organizationRadio.checked) {
                organizationField.style.display = "block";
            } else {
                organizationField.style.display = "none";
            }
        }

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
                        document.getElementById("volunteer_map").src =
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

    function validateForm() {
        let firstName = document.querySelector("input[name='first_name']");
        let lastName = document.querySelector("input[name='last_name']");
        var nic = document.getElementById("nic").value;
        var contactNo = document.getElementById("contact_no").value;
        var email = document.getElementById("email").value;
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var age = document.getElementById("age").value;

        //first name and last name validation (only letters allowed)
        var namePattern = /^[A-Za-z]+$/;
        if (!namePattern.test(firstName.value)) {
            //alert("First name can only contain letters.");
            document.getElementById("first_name").style.borderColor = "red";
            document.getElementById("first_name").focus();
            document.getElementById('first_name_label').innerHTML = "First name can only contain letters.";
            document.getElementById('first_name_label').style.color = "red";
            document.getElementById('first_name_label').style.fontSize = "12px";
            return false;
        }

        if (!namePattern.test(lastName.value)) {
            //alert("Last name can only contain letters.");
            document.getElementById("last_name").style.borderColor = "red";
            document.getElementById("last_name").focus();
            document.getElementById('last_name_label').innerHTML = "Last name can only contain letters.";
            document.getElementById('last_name_label').style.color = "red";
            document.getElementById('last_name_label').style.fontSize = "12px";
            return false;
        }

        // NIC validation (10 or 12 characters, digits + optional 'V' at the end)
        var nicPattern = /^(\d{9}[Vv]|\d{12})$/;
        if (!nicPattern.test(nic)) {
            //alert("Invalid NIC format. It should be 10 or 12 characters long.");
            document.getElementById("nic").style.borderColor = "red";
            document.getElementById("nic").focus();
            document.getElementById('nic_label').innerHTML = "Invalid NIC format. It should be 10 or 12 characters long.";
            document.getElementById('nic_label').style.color = "red";
            document.getElementById('nic_label').style.fontSize = "12px";
            return false;
        }

        // Email validation
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email && !emailPattern.test(email)) {
            //alert("Invalid email format.");
            document.getElementById("email").style.borderColor = "red";
            document.getElementById("email").focus();
            document.getElementById('email_label').innerHTML = "Invalid email format.";
            document.getElementById('email_label').style.color = "red";
            document.getElementById('email_label').style.fontSize = "12px";
            return false;
        }

        // Contact number validation (starts with 0 followed by 9 digits)
        var contactPattern = /^0\d{9}$/;
        if (!contactPattern.test(contactNo)) {
            //alert("Invalid contact number format. It should start with 0 followed by 9 digits.");
            document.getElementById("contact_no").style.borderColor = "red";
            document.getElementById("contact_no").focus();
            document.getElementById('contact_no_label').innerHTML = "Invalid contact number format. It should start with 0 followed by 9 digits.";
            document.getElementById('contact_no_label').style.color = "red";
            document.getElementById('contact_no_label').style.fontSize = "12px";
            return false;
        }

        // Username validation (at least 4 characters)
        if (username.length < 4) {
            //alert("Username must be at least 4 characters long.");
            document.getElementById("username").style.borderColor = "red";
            document.getElementById("username").focus();
            document.getElementById('username_label').innerHTML = "Username must be at least 4 characters long.";
            document.getElementById('username_label').style.color = "red";
            document.getElementById('username_label').style.fontSize = "12px";
            return false;
        }

        // Password validation(at least 6 characters with at least one symbole and one number)
        var passwordPattern = /^(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{6,}$/;
        if (!passwordPattern.test(password)) {
            //alert("Password must be at least 6 characters long and include at least one number and one special character.");
            document.getElementById("password").style.borderColor = "red";
            document.getElementById("password").focus();
            document.getElementById('password_label').innerHTML = "Password must contain at least 6 characters, including one number and one special character.";
            document.getElementById('password_label').style.color = "red";
            document.getElementById('password_label').style.fontSize = "12px";
            return false;
        }   

        // Age validation (between 1 and 99)
        if (age && (age < 1 || age > 99)) {
            //alert("Age must be between 1 and 99.");
            document.getElementById("age").style.borderColor = "red";
            document.getElementById("age").focus();
            document.getElementById('age_label').innerHTML = "Age must be between 1 and 99.";
            document.getElementById('age_label').style.color = "red";
            document.getElementById('age_label').style.fontSize = "12px";
            return false;
        }

        //home no validation(, or / allowed)
        var homeNoPattern = /^[\w\s\/,]+$/;
        var homeNo = document.getElementById("home_no").value;
        if (homeNo && !homeNoPattern.test(homeNo)) {
            //alert("Home No can only contain letters, numbers, commas, and slashes.");
            document.getElementById("home_no").style.borderColor = "red";
            document.getElementById("home_no").focus();
            document.getElementById('home_no_label').innerHTML = "Home No can only contain letters, numbers, commas, and slashes.";
            document.getElementById('home_no_label').style.color = "red";
            document.getElementById('home_no_label').style.fontSize = "12px";
            return false;
        }

        // Street validation (only letters, numbers and spaces allowed)
        var streetPattern = /^[A-Za-z0-9\s]+$/;
        var street = document.getElementById("street").value;
        if (street && !streetPattern.test(street)) {
            //alert("Street can only contain letters, numbers, and spaces.");
            document.getElementById("street").style.borderColor = "red";
            document.getElementById("street").focus();
            document.getElementById('street_label').innerHTML = "Street can only contain letters, numbers, and spaces.";
            document.getElementById('street_label').style.color = "red";
            document.getElementById('street_label').style.fontSize = "12px";
            return false;
        }

        // City validation (only letters and spaces allowed)
        var cityPattern = /^[A-Za-z\s]+$/;
        var city = document.getElementById("city").value;
        if (city && !cityPattern.test(city)) {
            //alert("City can only contain letters and spaces.");
            document.getElementById("city").style.borderColor = "red";
            document.getElementById("city").focus();
            document.getElementById('city_label').innerHTML = "City can only contain letters and spaces.";
            document.getElementById('city_label').style.color = "red";
            document.getElementById('city_label').style.fontSize = "12px";
            return false;
        }

        //resource name validation (only letters, numbers and spaces allowed)
        var resourceNamePattern = /^[A-Za-z0-9\s]+$/;
        var resourceName = document.getElementById("resource_name").value;
        if (resourceName && !resourceNamePattern.test(resourceName)) {
            //alert("Resource Name can only contain letters, numbers, and spaces.");
            document.getElementById("resource_name").style.borderColor = "red";
            document.getElementById("resource_name").focus();
            document.getElementById('resource_name_label').innerHTML = "Resource Name can only contain letters, numbers, and spaces.";
            document.getElementById('resource_name_label').style.color = "red";
            document.getElementById('resource_name_label').style.fontSize = "12px";
            return false;
        }

        // Description validation (only letters, numbers, spaces and basic punctuation allowed)
        var descriptionPattern = /^[A-Za-z0-9\s.,!?'"()-]+$/;
        var description = document.getElementById("description").value;
        if (description && !descriptionPattern.test(description)) {
            //alert("Description can only contain letters, numbers, spaces, and basic punctuation.");
            document.getElementById("description").style.borderColor = "red";
            document.getElementById("description").focus();
            document.getElementById('description_label').innerHTML = "Description can only contain letters, numbers, spaces, and basic punctuation.";
            document.getElementById('description_label').style.color = "red";
            document.getElementById('description_label').style.fontSize = "12px";
            return false;
        }

        // If all validations pass, allow form submission
        return true;
    }
</script>

</body>
</html>