<?php

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
</script>

</body>
</html>