<?php
require_once __DIR__ . '/../../../config/config.php';

?>

<div id="requestsTab" class="tab-content">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <style>

    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #eef2f7, #f8fbff);
        margin: 0;
        padding: 0;
    }

    #errid, #errname, #errloc, #errnum {
        color:red;

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
    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
    }
    .box {
        background: #f9fafc;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 10px;
        border: 1px solid #e6e6e6;
    }
    label {
        font-weight: 600;
        display: block;
        margin-top: 10px;
        color: #444;
    }
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
    .error {
        color: red;
        font-size: 13px;
    }
    #map, iframe {
        width: 100%;
        height: 350px;
        border-radius: 10px;
        margin-top: 10px;
        border: none;
    }
    table {
        width: 50%;
        margin-top: 10px;
    }
    td {
        padding: 5px;
    }
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

  <div class="section-header">
    <h2>Relief Teams</h2>
     <button class="tab-btn" data-tab="instantHelp"> + Add Teams</button>
  <div>
<div>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <div class="box">
        <form onsubmit="return validate()" method = "POST">
            <h2> New Relief Team</h2>
            <lable>Team ID: </lable>
            <input type="text" name="tid" id="tid">
            <p id="errid"></p><br>
            <lable>Team Name: </lable>
            <input type="text" name="tname" id="tname">
            <p id="errname"></p><br>
            <lable>Team Location: </lable>
            <input type="text" name="tloc" id="tloc">
            <p id="errloc"></p><br>
            <lable>Contact Number: </lable>
            <input type="text" name="tnumber" id="tnum">
            <p id="errnum"></p><br>
            <button type= "submit" >Add</button>
            <button type= "reset">Reset</button>

        </form>
    </div>
<script>
 

</script>

</body>
</html>

<?php 

$tid = $_POST['tid'];
$tname = $_POST['tname'];
$tloc = $_POST['tloc'];
$tnumber = $_POST['tnumber'];

$sql="
     INSERT INTO TABLE_NAMAE VALUES
    ('$tid','$tname','$tloc','$tnumber')";

$conn->query($sql);
if($conn->query($sql) == false){
    echo "Error Inserting Data";
}


?>

<?php 



?>