<?PHP

function instantHelpForm(){
    echo "<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>🚨 Instant Help Request</title>

    <style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #eef2f7, #f8fbff);
        margin: 0;
        padding: 0;
        }
    
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

    .box {
        background: #f9fafc;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 10px;
        border: 1px solid #e6e6e6;
    }

    .back-home{
            align-self: flex-start;
            margin-bottom: 1rem;
            text-decoration: none;
            font-size: 16px;
        }

    .data-form{
            width: 90%;
            padding: 0;
            margin: 0 ;
        }

    .top-text {
            text-align: center;
            margin-bottom: 20px;
        }

    label {
            font-weight: bold;
        }

    input, select {
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

    .error {
            color: red;
            font-size: 14px;
        }

    #map, iframe {
        width: 100%;
        height: 350px;
        border-radius: 10px;
        margin-top: 10px;
        border: none;
    }
</style>
</head>

<body>
    <div class='container'>
        <a href='../' class='back-home' onclick='window.history.back();return false;'>← BACK TO HOME</a>

        <h1 class='top-text'>🚨 Instant Help Request</h1>

        <div class='box'>
            <form method='POST' id='instantHelp'>

                <label id='name_label' for='name'>Name</label>
                <input type='text' name='name' id='name' placeholder='Enter Your Name'>

                <label id='req_name_label' for='req_name'>Request Name</label>
                <input type='text' name='req_name' id='req_name' placeholder='What is the issue'>

                <label id='req_type_label' for='req_type'>Request Type</label>
                <select name='req_type' id='req_type'>
                    <option value=''>Select Request Type</option>
                    <option value='tornadoes'>Tornadoes</option>
                    <option value='tsunamis'>Tsunamis</option>
                    <option value='landslides'>Landslides</option>
                    <option value='Flood'>Flood</option>
                    <option value='heat waves'>Heat Waves</option>
                    <option value='Droughts'>Droughts</option>
                    <option value='Strong Winds and Cyclones'>Strong Winds and Cyclones</option>
                </select>

                <label id='aff_pp_label' for='aff_pp'>Number Of affected People</label>
                <input type='number' name='aff_pp' id='aff_pp' min='1' value='1'>

                <label id='resource_type_label' for='resource_type'>Resource Type</label>
                <select name='resource_type' id='resource_type'>
                    <option value=''>Select Resource Type</option>
                    <option value='food'>Food</option>
                    <option value='water'>Water</option>
                    <option value='medicine'>Medicine</option>
                    <option value='shelter'>Shelter</option>
                    <option value='clothes'>Clothes</option>
                    <option value='rescue'>Rescue Team</option>
                    <option value='electricity'>Electricity Support</option>
                    <option value='communication'>Communication Support</option>
                </select>

                <label id='resource_count_label' for='resource_count'>Resource Count</label>
                <input type='number' name='resource_count' id='resource_count' min='1' value='1'>

                <label id='contact_number_label' for='contactnumber'>Contact Number</label>
                <input type='tel' name='contact_number' id='contactnumber' maxlength='11'>

                <span id='phoneError' style='color:red; font-size:14px;'></span><br>

                <label id='email_label' for='email'>Email</label>
                <input type='email' name='email' id='email' placeholder='example@email.com'>

                <label id='priority_level_label' for='priority_level'>Priority</label>
                <select name='priority_level' id='priority_level'>
                    <option value='medium'>Medium</option>
                    <option value='low'>Low</option>
                    <option value='high'>High</option>
                </select>

                <label id='location_label' for='get_location_btn' >Location</label>

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

                <br><br>
                <button type='submit'>Submit Request</button>

            </form>
        </div>
    </div>

<script>

    document.getElementById('instantHelp').addEventListener('submit', function(event){
        const get = id => document.getElementById(id);

        function fail(id, labelId, msg, scrollTarget){
            event.preventDefault();
            get(id).style.border = '2px solid red';
            get(labelId).innerHTML = msg;
            get(labelId).style.color = 'red';
            get(scrollTarget).scrollIntoView({behavior: 'smooth',block: 'center'});
            return false;
        }
            
        document.querySelectorAll('input, select').forEach(el => {el.style.border = '';});
        document.querySelectorAll('label').forEach(el => {el.style.color = '';});

        const name = get('name').value.trim();
        const reqName = get('req_name').value.trim();
        const reqType = get('req_type').value;
        const affPeople = get('aff_pp').value.trim();
        const resourceType = get('resource_type').value;
        const resourceCount = get('resource_count').value.trim();
        const contact = get('contactnumber').value.trim();
        const email = get('email').value.trim();
        const priority = get('priority_level').value;
        const lat = get('lat').value;
        const lon = get('lon').value;

        const namePattern = /^[A-Za-z\s]+$/;
        const phonePattern = /^07[0-9]{8}$/;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if(name === '' || !namePattern.test(name)){
            return fail('name', 'name_label', 'Enter valid name *', 'name');
        }
        if(reqName === ''){
            return fail( 'req_name', 'req_name_label', 'Request name required *', 'req_name');
        }
        if(reqType === ''){
            return fail('req_type', 'req_type_label', 'Select request type *', 'req_type');
        }
        if(affPeople === '' || isNaN(affPeople) || Number(affPeople) <= 0){
            return fail('aff_pp','aff_pp_label','Enter valid people count *','aff_pp');
        }
        if(resourceType === ''){
            return fail('resource_type', 'resource_type_label', 'Select resource type *', 'resource_type');
        }
        if(resourceCount === '' || isNaN(resourceCount) || Number(resourceCount) <= 0){
            return fail('resource_count','resource_count_label','Enter valid resource count *','resource_count');
        }
        if(!phonePattern.test(contact)){
            return fail('contactnumber', 'contact_number_label', 'Invalid contact number *', 'contactnumber');
        }
        if(email != '' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){
            return fail('email', 'email_label', 'Invalid email address *', 'email');
        }
        if(priority === ''){
            return fail('priority_level','priority_level_label','Select priority level *', 'priority_level');
        }
        if(lat === '' || lon === ''){
            return fail('get_location_btn', 'location_label', 'Location required *', 'get_location_btn' );
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
        setTimeout(function(){window.location.href='../../public/';
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
        setTimeout(function(){window.location.href='../public/';
        }, 3000);
</script>";
}

?>