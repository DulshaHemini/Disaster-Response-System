<?php
$lat = "";
$lon = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lat = $_POST['lat'] ?? '';
    $lon = $_POST['lon'] ?? '';
}
?>
<html>
    <head>
        <title></title>
        <style>
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
        <h1>Request Submission Form</h1>
        
        <form method="POST" id="helpNeeder">

        <label>Name:</label><br>
        <input type="text" name="username" id="username" value="Dilmi" placeholder="Enter Your Name" required><br><br>

        <label>Request Name</label><br>
        <input type="text" name="request_name" reqiured><br><br>
        
        <label>Request Type</label><br>
        <input type="text" name="req_type" placeholder="What is the issue"><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="5" cols="40" placeholder="Describe your issue clearly..."></textarea><br><br>

        <label>Number Of affected People: </label>
        <input type="text" name="affected_people" pattern="[0-9]+"><br><br>

        <label>Resource Type:</label><br>

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
        </select><br><br>

        <div id="otherResourceDiv" style="display:none;">
            <label>Enter Resource Type:</label><br>
            <input type="text" name="other_resource_type" placeholder="Type resource type"><br><br>
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
        <input type="text" name="resource_count" required><br><br>

        <label>Contact Number: </label><br>
        <input type="text" name="contact_number" id="contact_number" placeholder="Phone Number" required><br><br>

        <label>E mail: </label><br>
        <input type="text" name="email" id="email" placeholder="email"><br><br>

        <label>City:</label>
        <input type="text" name="city" id="city" placeholder="city"><br><br>

        <label>Street:</label>
        <input type="text" name="street" id="street" placeholder="street"><br><br>

        <label>Home Number: </label>
        <input type="text" name="home_number" id="home_number" placeholder="Home number"><br><br>

        <label>Priority:</label><br>
        <select name="priority_level" required >
            <option value="medium">Medium</option>
            <option value="low">Low</option>
            <option value="high">High</option>
        </select><br><br>

        <label>Select District</label><br>

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
        </datalist><br><br>

        <label>Location:</label><br>
        

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
        <br><br>

        <button type="submit">Submit Request</button>
        </form>

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



