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
        
        <form method="POST" id="instantHelp">

        <label>Name:</label><br>
        <input type="text" name="username" id="username" value="Dilmi" placeholder="Enter Your Name" required><br><br>
        
        <label>Request Type</label><br>
        <input type="text" name="req_type" placeholder="What is the issue"><br><br>
        
        <label>Select District</label> <br>
        <inputlist="districtlist" placeholder="Type or select province"></inputlist>
            <datalist id="districtlist">
                <option value=""></option>
            </datalist>
        <label>Description:</label><br>
        <textarea name="description" rows="5" cols="40" placeholder="Describe your issue clearly..."></textarea><br><br>

        <label>Number Of affected People: </label>
        <input type="text" name="affected_people" pattern="[0-9]+"><br><br>

        <label>Resource Count: </label>
        <input type="text" name="resource_count" required><br><br>

        <label>Resource Type: </label>
        <input type="text" name="Resource_type" required><br> <br>

        <label>Contact Number: </label><br>
        <input type="text" name="contact_number" id="contact_number" placeholder="Phone Number"><br><br>

        <label>E mail: </label><br>
        <input type="text" name="email" id="email" placeholder="email"><br><br>


        <label>Priority:</label><br>
        <select name="priority_level" required >
            <option value="medium">Medium</option>
            <option value="low">Low</option>
            <option value="high">High</option>
        </select><br><br>

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

        <button type="submit">Submit Request</button>
        </form>

        <script>
            document.getElementById("instantHelp").addEventListener("submit", function(event){
                    event.preventDefault();


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



