<?PHP

function signupview(){

    echo '
    <html lang="en">

<head>
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
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border-top: 3px solid #c8102e;
            border-bottom: 3px solid #c8102e;
        }

        /* Heading */
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        #affected_box,
        #volunteer_box,
        #relief_team_box {
            border-top: 2px solid #c8102e;
            border-bottom: 2px solid #c8102e;
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
        input,
        select,
        textarea {
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

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
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
        #map,
        iframe {
            width: 100%;
            height: 350px;
            border-radius: 10px;
            margin-top: 10px;
            border: none;
        }

        table {
            width: 100%;
            margin-top: 10px;
        }

        td {
            padding: 5px;
            width: 100%;
        }

        th {
            width: 30%;
        }

        .back-home {
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

        <form method="POST" id="regForm">
            <!--Common Data-->
            <div class="box">

                <label id="first_name_label">First Name</label>
                <input type="text" name="first_name" id="first_name">

                <label id="last_name_label">Last Name</label>
                <input type="text" name="last_name" id="last_name">

                <label id="nic_label">NIC</label>
                <input type="text" name="nic" id="nic">

                <label id="email_label">Email</label>
                <input type="email" name="email" id="email" placeholder="example@gmail.com">

                <label id="contact_no_label">Contact No</label>
                <input type="text" name="contact_no" id="contact_no" placeholder="0712345678">

                <label id="username_label">Username</label>
                <input type="text" name="username" id="username">

                <label id="password_label">Password</label>
                <input type="password" name="password" id="password">

                <label id="gender_label">Gender</label>
                <select name="gender" id="gender">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

                <label id="age_label">Age</label>
                <input type="number" name="age" id="age" min="1" max="99">

                <label id="home_no_label">Home No</label>
                <input type="text" name="home_no" id="home_no">

                <label id="street_label">Street</label>
                <input type="text" name="street" id="street">

                <label id="city_label">City</label>
                <input type="text" name="city" id="city">

                <label id="district_label">District</label>
                <select name="district" id="district">
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

                <label id="location_label">Location</label>

                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lon" id="lon">

                <button class="location-but" id="show_location_btn" type="button" onclick="previewLocation()">Show My
                    Location</button>

                <iframe title="Affected Area Map" id="affected_map" width="500" height="300"
                    style="border:0; border-radius:10px;" loading="lazy" allowfullscreen
                    src="https://www.google.com/maps?q=7.8731,80.7718&output=embed&z=7">
                </iframe>

                <label id="user_role_label">User Role</label>
                <select name="user_role" id="user_role" onchange="showRoleFields()">
                    <option value="">Select Role</option>
                    <option value="affected_people">Affected People</option>
                    <option value="volunteer">Volunteer</option>
                    <option value="relief_team">Relief Team</option>
                </select>
            </div>

            <!-- Affected People Fields -->
            <div class="box" id="affected_box" style="display:none;">
                <label id="noofaffected_label">No. of Family Members</label>
                <input id="noofaffected" type="number" name="no_of_family_members">
            </div>

            <!-- Volunteer Fields -->
            <div class="box" id="volunteer_box" style="display:none;">
                <label id="availability_label">Availability Status</label>
                <select name="availability_status" id="availability_status">
                    <option value="available" selected>Available</option>
                    <option value="busy">Busy</option>
                </select>

                <label id="org_person_label">Are you an organization or a person?</label>
                <table>
                    <tr>
                        <td colspan="2">
                            <label for="person">Person</label>
                        </td>
                        <td>
                            <input type="radio" id="person" name="type" value="Person"
                                onclick="showOrganizationField()">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <label for="organization">Organization</label>
                        </td>
                        <td>
                            <input type="radio" id="organization" name="type" value="Organization"
                                onclick="showOrganizationField()">
                        </td>
                    </tr>

                    <tr id="organization_name_div" style="display:none;">
                        <th>
                            <label for="organization_name" id="organization_name_label">Organization Name</label>
                        </th>
                        <th>
                            <input type="text" id="organization_name" name="organization_name">
                        </th>
                    </tr>
                </table>

                <label for="resource_name" id="resource_name_label">Resource Name</label><br>
                <input type="text" id="resource_name" name="resource_name"><br>

                <label for="resource_type" id="resource_type_label">Resource Type</label><br>

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
                </select><br>

                <label for="resource_count" id="resource_count_label">Resource Count</label><br>
                <input type="number" id="resource_count" name="resource_count"><br>

                <label for="description" id="description_label">Description</label><br>
                <textarea id="description" name="description" rows="4" cols="30"></textarea><br>
            </div>

            <!-- Relief Team Fields -->
            <div class="box" id="relief_team_box" style="display:none;">

                <label id="team_name_label">Team Name</label>
                <input type="text" name="team_name" id="team_name">

                <label id="specialization_label">Specialization</label>
                <select name="specialization" id="specialization">
                    <option value="">Select Type</option>
                    <option value="Medical">Medical</option>
                    <option value="Flood Rescue">Flood Rescue</option>
                    <option value="Food Distribution">Food Distribution</option>
                    <option value="Transport">Transport</option>
                    <option value="Animal Rescue">Animal Rescue</option>
                    <option value="Emergency Response">Emergency Response</option>
                </select>
                <label id="no_of_members_label">No of Members</label>
                <input type="number" name="no_of_members" id="no_of_members">

                <label id="vehicle_type_label">Vehicle Type</label>
                <input type="text" name="vehicle_type" id="vehicle_type">

                <label id="vehicle_number_label">Vehicle Number</label>
                <input type="text" name="vehicle_number" id="vehicle_number">
            </div>

            <button type="submit">Register</button>

        </form>
    </div>

    <script>

        function showRoleFields() {
            const role = document.getElementById("user_role").value;

            document.getElementById("affected_box").style.display = "none";
            document.getElementById("volunteer_box").style.display = "none";
            document.getElementById("relief_team_box").style.display = "none";

            if (role === "affected_people") {
                document.getElementById("affected_box").style.display = "block";
            }

            if (role === "volunteer") {
                document.getElementById("volunteer_box").style.display = "block";
            }

            if (role === "relief_team") {
                document.getElementById("relief_team_box").style.display = "block";
            }
        }

        function showOrganizationField() {

            const orgDiv = document.getElementById("organization_name_div");
            const orgRadio = document.getElementById("organization");

            if (orgRadio.checked) {
                orgDiv.style.display = "table-row";
            }
            else {
                orgDiv.style.display = "none";
            }
        }


        // GET LOCATION
        function previewLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        document.getElementById("lat").value = lat;
                        document.getElementById("lon").value = lon;
                        document.getElementById("affected_map").src =
                            `https://www.google.com/maps?q=${lat},${lon}&output=embed&z=14`;
                    }, function (error) {
                        fail("show_location_btn", "affected_map", "Location is required *", "show_location_btn");
                    }
                );
            } else {
                alert("Geolocation is not supported.");
            }
        }


        document.getElementById("regForm").addEventListener("submit", function (event) {

            // RESET STYLES
            const allInputs = document.querySelectorAll("input, select, textarea");
            allInputs.forEach(el => el.style.border = "1px solid #ccc");

            const allLabels = document.querySelectorAll("label");
            allLabels.forEach(label => label.style.color = "#444");

            // GET VALUES
            const firstName = document.getElementById("first_name").value.trim();
            const lastName = document.getElementById("last_name").value.trim();
            const nic = document.getElementById("nic").value.trim();
            const email = document.getElementById("email").value.trim();
            const contact = document.getElementById("contact_no").value.trim();
            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();
            const gender = document.getElementById("gender").value.trim();
            const age = document.getElementById("age").value;
            const home = document.getElementById("home_no").value.trim();
            const street = document.getElementById("street").value.trim();
            const city = document.getElementById("city").value.trim();
            const district = document.getElementById("district").value;
            const role = document.getElementById("user_role").value;

            const noofaffected = document.getElementById("noofaffected").value;

            const availability = document.getElementById("availability_status")?.value;
            const personRadio = document.getElementById("person");
            const orgRadio = document.getElementById("organization");
            const orgName = document.getElementById("organization_name")?.value.trim();
            const resourceName = document.getElementById("resource_name")?.value.trim();
            const resourceType = document.getElementById("resource_type")?.value;
            const resourceCount = document.getElementById("resource_count")?.value;
            const description = document.getElementById("description")?.value.trim();

            const teamName = document.getElementById("team_name")?.value.trim();
            const specialization = document.getElementById("specialization")?.value;
            const members = document.getElementById("no_of_members")?.value;
            const vehicleType = document.getElementById("vehicle_type")?.value.trim();
            const vehicleNumber = document.getElementById("vehicle_number")?.value.trim();

            const lat = document.getElementById("lat").value;
            const lon = document.getElementById("lon").value;

            // FAIL FUNCTION
            function fail(id, labelId, msg) {

                event.preventDefault();

                const el = document.getElementById(id);
                if (el) {
                    el.style.border = "2px solid red";
                    el.focus({ preventScroll: true });
                    el.scrollIntoView({ behavior: "smooth", block: "center" });
                }

                const label = document.getElementById(labelId);
                if (label) {
                    label.innerHTML = msg;
                    label.style.color = "red";
                }

                return false;
            }

            // PATTERNS
            const patterns = {
                name: /^[A-Za-z]+$/,
                nic: /^(\d{9}[Vv]|\d{12})$/,
                email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                contact: /^07[0-9]{8}$/,
                street: /^[A-Za-z0-9\s\/,.-]+$/,
                city: /^[A-Za-z\s]+$/,
                description: /^[A-Za-z0-9\s.,!?()""-]+$/
            };

            // COMMON VALIDATION
            if (firstName === "" || !patterns.name.test(firstName))
                return fail("first_name", "first_name_label", "Invalid first name *");

            if (lastName === "" || !patterns.name.test(lastName))
                return fail("last_name", "last_name_label", "Invalid last name *");

            if (!patterns.nic.test(nic))
                return fail("nic", "nic_label", "Invalid NIC *");

            if (email === "" || !patterns.email.test(email))
                return fail("email", "email_label", "Invalid email address *");

            if (!patterns.contact.test(contact))
                return fail("contact_no", "contact_no_label", "Invalid contact number *");

            if (username.length < 4)
                return fail("username", "username_label", "Username must be at least 4 characters *");

            if (!/^(?=.*[0-9])(?=.*[!@#$%^&*]).{6,}$/.test(password))
                return fail("password", "password_label", "Weak password *");

            if (gender === "")
                return fail("gender", "gender_label", "Select gender *");

            if (age === "" || age < 1 || age > 99)
                return fail("age", "age_label", "Invalid age *");

            if (home === "")
                return fail("home_no", "home_no_label", "Home number required *");

            if (street === "" || !patterns.street.test(street))
                return fail("street", "street_label", "Invalid street *");

            if (city === "" || !patterns.city.test(city))
                return fail("city", "city_label", "Invalid city *");

            if (district === "")
                return fail("district", "district_label", "District required *");

            if (lat === "" || lon === "")
                return fail("show_location_btn", "location_label", "Please select location *");

            if (role === "")
                return fail("user_role", "user_role_label", "Select role *");

            // AFFECTED PEOPLE
            if (role === "affected_people") {
                if (noofaffected === "")
                    return fail("noofaffected", "noofaffected_label", "No. of Family Members required *");
            }

            // VOLUNTEER
            if (role === "volunteer") {

                if (availability === "")
                    return fail("availability_status", "availability_label", "Availability status required *");

                if (!personRadio.checked && !orgRadio.checked)
                    return fail("person", "org_person_label", "Please select Person or Organization *");

                if (orgRadio.checked && orgName === "")
                    return fail("organization_name", "organization_name_label", "Organization name required *");

                if (resourceName === "")
                    return fail("resource_name", "resource_name_label", "Resource required *");

                if (resourceType === "")
                    return fail("resource_type", "resource_type_label", "Resource type required *");

                if (resourceCount === "" || resourceCount < 1)
                    return fail("resource_count", "resource_count_label", "Invalid resource count *");

                if (description === "" || !patterns.description.test(description))
                    return fail("description", "description_label", "Invalid description *");
            }

            // RELIEF TEAM (NEW)
            if (role === "relief_team") {

                if (teamName === "")
                    return fail("team_name", "team_name_label", "Team name required *");

                if (specialization === "")
                    return fail("specialization", "specialization_label", "Select specialization *");

                if (members === "" || members < 1)
                    return fail("no_of_members", "no_of_members_label", "Invalid members count *");

                if (vehicleType === "")
                    return fail("vehicle_type", "vehicle_type_label", "Vehicle type required *");

                if (vehicleNumber === "")
                    return fail("vehicle_number", "vehicle_number_label", "Vehicle number required *");
            }
        });

    </script>

</body>

</html>
    ';

}


function success(){
    echo "<div style='
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: #c8102e33;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: Arial, sans-serif;
'>

    <div style='
        background: white;
        padding: 40px;
        width: 350px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        animation: popup 0.4s ease;
    '>
        <div style='
            width: 80px;
            height: 80px;
            margin: auto;
            background: #4caf50;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 40px;
            color: white;
        '>
            ✓
        </div>

        <h2 style='
            margin-top: 20px;
            color: #333;
        '>
            Registration Success!
        </h2>

        <p style='
            color: #555;
            margin-top: 10px;
            line-height: 1.5;
        '>
            Your account has been created successfully.
        </p>
    </div>
</div>
<script>
        setTimeout(function(){window.location.href='signin.php';
        }, 3000);
</script>";
}

function reg_fail(){
    echo "<div style='
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: #c8102e33;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: Arial, sans-serif;
'>

    <div style='
        background: white;
        padding: 40px;
        width: 350px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        animation: popup 0.4s ease;
    '>
        <div style='
            width: 80px;
            height: 80px;
            margin: auto;
            background: #e53935;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 40px;
            color: white;
        '>
            ✕
        </div>

        <h2 style='
            margin-top: 20px;
            color: #e53935;
        '>
            Registration Failed!
        </h2>

        <p style='
            color: #555;
            margin-top: 10px;
            line-height: 1.5;
        '>
            Something went wrong while creating your account.
            Please try again.
        </p>
    </div>
</div>
<script>
        setTimeout(function(){window.location.href='../../public/';
        }, 3000);
</script>";
}
