<?PHP

function loggedRequestForm(){
    
    echo "<html>
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

h1 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
    font-size: 32px;
}

label {
    font-weight: 600;
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
    color: #444;
}

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

input:focus,
select:focus,
textarea:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0,123,255,0.2);
}

textarea {
    resize: vertical;
}

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

#map,
iframe {
    width: 100%;
    height: 350px;
    border-radius: 10px;
    margin-top: 10px;
    border: none;
}

#otherResourceDiv {
    background: #f9fafc;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #e6e6e6;
    margin-bottom: 15px;
}

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
    
    <div class='container'>
    <h1>Request Submission Form</h1>
        <div class='box'>
            <form method='POST' id='helpNeeder'>

            <label id='request_name_label' for='request_name_field'>Request Name</label>
            <input id='request_name_field' type='text' name='request_name'>

            <label id='request_type_label' for='req_type'>Request Type:</label>
            <select name='req_type' id='req_type'>

                <option value='select'>Select Request Type</option>

                <option value='tornadoes'>Tornadoes</option>
                <option value='tsunamis'>Tsunamis</option>
                <option value='landslides'>Landslides</option>
                <option value='Flood'>Flood</option>
                <option value='heat_waves'>Heat Waves</option>
                <option value='Droughts'>Droughts</option>
                <option value='Strong_Winds_and_Cyclones'>Strong Winds and Cyclones</option>

            </select>

                <label id='description_label' for='description_field'>Description:</label>
                <textarea id='description_field' name='description'  rows='5'  cols='40'  placeholder='Describe your issue clearly...'></textarea>

                <label id='affected_people_label' for='affected_people_field'>Number Of Affected People:</label>
                <input  type='text'  id='affected_people_field' name='affected_people'  pattern='[0-9]+'>

                <label id='resource_type_label' for='resource_type'>Resource Type:</label>

                <select  name='resource_type'  id='resource_type'  onchange='showOtherField()'>
                    <option value='select'>Select Resource Type</option>
                    <option value='medicine'>Medicine</option>
                    <option value='foods'>Foods</option>
                    <option value='shelters'>Shelters</option>
                    <option value='clothes'>Clothes</option>
                    <option value='water'>Water</option>
                    <option value='rescue'>Rescue Team</option>
                    <option value='electricity'>Electricity Support</option>
                    <option value='communication'>Communication Support</option>
                    <option value='other'>Other</option>
                </select>

                <div id='otherResourceDiv' style='display:none;'>
                    <label id='other_resource_label' for='other_resource_field'>Enter Resource Type:</label>
                    <input type='text' id='other_resource_field' name='other_resource_type' placeholder='Type resource type'>
                </div>

                <script>
                    function showOtherField() {
                        const resourceType = document.getElementById('resource_type').value;
                        const otherDiv = document.getElementById('otherResourceDiv');
                        if (resourceType === 'other') {
                            otherDiv.style.display = 'block';
                        } 
                        else {
                            otherDiv.style.display = 'none';
                        }
                    }
                </script>

                <label id='resource_count_label' for='resource_count_field'>Resource Count:</label>
                <input type='text' id='resource_count_field' name='resource_count'>
                
                <label id='priority_label' for='priority_level'>Priority:</label>

                <select name='priority_level' id='priority_level'>
                    <option value='medium'>Medium</option>
                    <option value='low'>Low</option>
                    <option value='high'>High</option>
                </select>

                <label id='contact_number_label' for='contact_number'>Contact Number:</label>
                <input type='text' name='contact_number' id='contact_number' placeholder='Phone Number'>

                <label id='email_label' for='email'>E mail:</label>
                <input type='text' name='email' id='email' placeholder='email'>
                
                <label id='home_number_label' for='home_number'>Home Number:</label>
                <input type='text' name='home_number' id='home_number' placeholder='Home number'>
                
                <label id='street_label' for='street'>Street:</label>
                <input type='text' name='street' id='street' placeholder='street'>

                <label id='city_label' for='city'>City:</label>
                <input type='text' name='city' id='city' placeholder='city'>

                <label id='district_label' for='district'>Select District</label>
                <input type='text' name='district' id='district' list='districtlist' placeholder='Type or select district'>

                <datalist id='districtlist'>
                    <option value='Ampara'>
                    <option value='Anuradhapura'>
                    <option value='Badulla'>
                    <option value='Batticaloa'>
                    <option value='Colombo'>
                    <option value='Galle'>
                    <option value='Gampaha'>
                    <option value='Hambantota'>
                    <option value='Jaffna'>
                    <option value='Kalutara'>
                    <option value='Kandy'>
                    <option value='Kegalle'>
                    <option value='Kilinochchi'>
                    <option value='Kurunegala'>
                    <option value='Mannar'>
                    <option value='Matale'>
                    <option value='Matara'>
                    <option value='Monaragala'>
                    <option value='Mullaitivu'>
                    <option value='Nuwara Eliya'>
                    <option value='Polonnaruwa'>
                    <option value='Puttalam'>
                    <option value='Ratnapura'>
                    <option value='Trincomalee'>
                    <option value='Vavuniya'>
                </datalist>

                <label id='location_label'>Location:</label>

                <input type='hidden' name='lat' id='lat'>
                <input type='hidden' name='lon' id='lon'>

                <button class='location-but' id='show_location_btn' type='button' onclick='previewLocation()'>Show My Location</button>

                <iframe
                    title='Affected Area Map'
                    id='affected_map'
                    width='500'
                    height='300'
                    style='border:0; border-radius:10px;'
                    loading='lazy'
                    allowfullscreen
                    src='https://www.google.com/maps?q=7.8731,80.7718&output=embed&z=7'>
                </iframe>

                <button id='submit_request_btn' type='submit'>Submit Request</button>
            </form>
        </div>
    </div>

<script>
function showOtherField() {
    const resourceType = document.getElementById('resource_type').value;
    document.getElementById('otherResourceDiv').style.display =
        resourceType === 'other' ? 'block' : 'none';
}

document.getElementById('helpNeeder').addEventListener('submit', function(event){
    const fields = document.querySelectorAll('input, select, textarea, label');
    fields.forEach(el => {
        el.style.border = '';
        el.style.color = '';
    });

    const reqName = document.getElementById('request_name_field').value.trim();
    const reqType = document.getElementById('req_type').value;
    const description = document.getElementById('description_field').value.trim();
    const affectedPeople = document.getElementById('affected_people_field').value.trim();
    const resourceType = document.getElementById('resource_type').value;
    const otherResource = document.getElementById('other_resource_field').value.trim();
    const resourceCount = document.getElementById('resource_count_field').value.trim();
    const contact = document.getElementById('contact_number').value.trim();
    const email = document.getElementById('email').value.trim();
    const home = document.getElementById('home_number').value.trim();
    const street = document.getElementById('street').value.trim();
    const city = document.getElementById('city').value.trim();
    const district = document.getElementById('district').value.trim();
    const validDistricts = [
    'Ampara', 'Anuradhapura', 'Badulla', 'Batticaloa', 'Colombo',
    'Galle', 'Gampaha', 'Hambantota', 'Jaffna', 'Kalutara',
    'Kandy', 'Kegalle', 'Kilinochchi', 'Kurunegala', 'Mannar',
    'Matale', 'Matara', 'Monaragala', 'Mullaitivu', 'Nuwara Eliya',
    'Polonnaruwa', 'Puttalam', 'Ratnapura', 'Trincomalee', 'Vavuniya'
];

    function fail(id, labelId, msg, scrollTarget){
        event.preventDefault();
        document.getElementById(id).style.border = '2px solid red';
        document.getElementById(labelId).innerHTML = msg;
        document.getElementById(labelId).style.color = 'red';
        document.getElementById(scrollTarget).scrollIntoView({behavior: 'smooth', block: 'center'});
    }

    if (reqName === '' || !/^[A-Za-z\s]+$/.test(reqName)) {
    return fail('request_name_field', 'request_name_label', 'Request Name must contain only letters *', 'request_name_field'
    );
}

    if(reqType === 'select'){
        return fail('req_type','request_type_label','Request Type is required *','req_type');
    }

    if(description === ''){
        return fail('description_field','description_label','Description is required *','description_field');
    }

    if(affectedPeople === '' || isNaN(affectedPeople) || Number(affectedPeople) <= 0){
        return fail('affected_people_field','affected_people_label','Enter valid affected people count *','affected_people_field');
    }

    if(resourceType === 'select'){
        return fail('resource_type','resource_type_label','Resource Type is required *','resource_type');
    }

    if(resourceType === 'other' && otherResource === ''){
        return fail('other_resource_field','other_resource_label','Enter other resource type *','other_resource_field');
    }

    if(resourceCount === '' || isNaN(resourceCount) || Number(resourceCount) <= 0){
        return fail('resource_count_field','resource_count_label','Enter valid resource count *','resource_count_field');
    }

    if(contact === '' || !/^07[0-9]{8}$/.test(contact)){
        return fail('contact_number','contact_number_label','Enter valid Sri Lankan contact number *','contact_number');
    }

    if(email != '' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){
        return fail('email','email_label','Enter valid email address *','email');
    }
    
    if (home === '' || !/^[A-Za-z0-9\/,]+$/.test(home)) {
    return fail('home_number', 'home_number_label', 'Only letters, numbers, / and , are allowed *', 'home_number'
    );
}

    if(street === '' || !/^[A-Za-z0-9]+$/.test(street)){
        return fail('street','street_label','Street is required *','street');
    }

    if(city === '' || !/^[A-Za-z]+$/.test(city)){
        return fail('city','city_label','City is required *','city');
    }

    

    if (district === '' || !validDistricts.includes(district)) {
        return fail('district', 'district_label', 'Please select a valid district *', 'district'
        );
    }

    if(document.getElementById('lat').value === '' || document.getElementById('lon').value === ''){
        return fail('show_location_btn','location_label','Location is required *','show_location_btn');
    }

});
// GET LOCATION
function previewLocation() {
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(
            function(position){
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                document.getElementById('lat').value = lat;
                document.getElementById('lon').value = lon;
                document.getElementById('affected_map').src =
                    `https://www.google.com/maps?q=\${lat},\${lon}&output=embed&z=14`;
            },function(error){
                fail('show_location_btn','location_label','Location is required *','show_location_btn');
            }
        );
    }else{
        alert('Geolocation is not supported.');
    }
}
</script>
</body>
</html>";

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
            Request Sent Successfully!
        </h2>

        <p style='
            color: #555;
            margin-top: 10px;
            line-height: 1.5;
        '>
            The System will do the needful.
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
            Request sent Failed!
        </h2>

        <p style='
            color: #555;
            margin-top: 10px;
            line-height: 1.5;
        '>
            Something went wrong while creating your request.
            Please try again.
        </p>
    </div>
</div>
<script>
        setTimeout(function(){window.location.href='../../public/';
        }, 3000);
</script>";
}

?>
