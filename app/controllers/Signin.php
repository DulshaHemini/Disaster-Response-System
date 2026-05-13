<?php
require_once '../../config/config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['username']);
    $password = trim($_POST['password']);

    // SQL Query
    $sql = "SELECT * FROM users WHERE username='$name'";
    $result = mysqli_query($conn, $sql);

    // Check if user exists
    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $row['password'])) {

            $message = "Login Successful!";

            // Redirect based on role
            if ($row['user_role'] === 'admin') {

                header("Location: adminpage.php");
                exit();

            } elseif ($row['user_role'] === 'affected_people') {

                header("Location: affected_people.php");
                exit();

            } elseif ($row['user_role'] === 'volunteer') {

                header("Location: volunteer.php");
                exit();

            } else {

                $message = "Invalid User Role!";
            }

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
    <link rel="stylesheet" href="" >

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 360px;
            min-height: 400px;
            background: var(--off);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-top: 3px solid #c3102e;
            border-bottom: 3px solid #c3102e;
        }

        .auth-card {
            border-radius: 12px;
            width: 100%;
            padding: 0;
            margin: 0; 
        }

        body {
        background: var(--off);
        font-family: var(--font-bd);
        color: var(--text);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        }

        .back-home{
            align-self: flex-start;
            margin-bottom: 1rem;
            text-decoration: none;
            font-size: 16px;
        }

        .signin-text{
            font-family: sans-serif;
            font-size: 35px;
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

        h1 {
        font-family: var(--font-hd);
        font-size: 1.9rem;
        margin-bottom: 0.5rem;
        line-height: 1.2;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="../" class="back-home" onclick="window.history.back();return false;">← BACK TO DRCS</a>
        <br>
        <h1 class="signin-text">Sign In</h1><br>
        <div class="auth-card">                     
            <h2>Welcome back</h2><br>
            <form id="userForm" method="POST">
                <input type="text" name="username" id="username" placeholder="Username">
                <input type="password" name="password" id="password" placeholder="Password">
                <input type="submit" value="Submit">
            </form>
            <p>No account? <a href='signup.php'>Sign Up</p>
            <p style="color:red;"><?php echo $message; ?></p>
        </div>
    </div>


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