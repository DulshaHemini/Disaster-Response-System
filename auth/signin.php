<?php
require_once '../config/config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['username'];
    $password = $_POST['password'];

    // Get user by username
    $sql = "SELECT * FROM user WHERE name='$name'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {

        // Verify hashed password
        if (password_verify($password, $row['password'])) {
            $message = "Login Successful!";
        } else {
            $message = "Invalid Password!";
        }

    } else {
        $message = "User Not Found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
</head>
<body>

<h1>Sign In</h1>

<form id="userForm" method="POST">
    <input type="text" name="username" id="username" placeholder="Username"><br><br>
    <input type="password" name="password" id="password" placeholder="Password"><br><br>
    <input type="submit" value="Submit">
</form>

<p style="color:red;"><?php echo $message; ?></p>

<script>
document.getElementById("userForm").addEventListener("submit", function(event) {
    const name = document.getElementById("username").value.trim();
    const pwd = document.getElementById("password").value.trim();

    if (name === "" && pwd === "") {
        alert("Username and Password cannot be empty!");
        event.preventDefault();
    } 
    else if (name === "") {
        alert("Username cannot be empty!");
        event.preventDefault();
    } 
    else if (pwd === "") {
        alert("Password cannot be empty!");
        event.preventDefault();
    }
});
</script>

</body>
</html>