<?PHP

function showSigninForm(){
    
    echo '<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>

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
            max-width: 450px;
            min-height: 500px;
            background: var(--off);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            border-top: 3px solid #c3102e;
            border-bottom: 3px solid #c3102e;
        }

        .auth-card {
            border-radius: 12px;
            width: 90%;
            padding: 0;
            margin: 0; 
        }

        body {
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
            font-size: 18px;
        }

        .signin-text{
            font-family: sans-serif;
            font-size: 50px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            font-size: 17px;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .username-lable, .password-label {
            font-weight: bold;
            font-family: sans-serif;
        }

        .submit-button{
            background-color: #c3102e;
            color: white;
        }

        .submit-button:hover {
            background-color: #a00b1e;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="../" class="back-home" onclick="window.history.back();return false;">← BACK TO HOME</a>
        <br>
        <h1 class="signin-text">Sign In</h1><br><br>
        <div class="auth-card">                     
            <h1>Welcome back</h1><br>
            <form id="userForm" method="POST">
                <input type="text" name="username" id="username" placeholder="Username">
                <input type="password" name="password" id="password" placeholder="Password">
                <p style="color:red; font-family: sans-serif; font-size: 14px;"><?php echo $message; ?></p>
                <input class="submit-button" type="submit" value="Submit">
            </form>
            <p style="font-family: sans-serif; font-size: 18px;">No account ? <a href="signup.php" style="text-decoration: none;">Sign Up</a></p>
        </div>
    </div>


<script>
document.getElementById("userForm").addEventListener("submit", function(event) {
    const name = document.getElementById("username").value.trim();
    const pwd = document.getElementById("password").value.trim();

    if (name === "" && pwd === "") {
        <p style="color:red; font-family: sans-serif; font-size: 14px;"><?php echo $message; ?></p>
        event.preventDefault();
    }
    else if (name === "") {
        event.preventDefault();
    } 
    else if (pwd === "") {
        event.preventDefault();
    }
});

</script>

</body>
</html>';
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
            Login Successfully!
        </h2>
        <p style='
            color: #555;
            margin-top: 10px;
            line-height: 1.5;
        '>
            You will be redirected to your dashboard shortly.
        </p>
    </div>
</div>
<script>
        setTimeout(function(){window.location.href='../';}, 5000);
</script>";

}

function signin_fail(){
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
            Signin Failed!
        </h2>

        <p style='
            color: #555;
            margin-top: 10px;
            line-height: 1.5;
        '>
            Invalid username or password. Please try again.
            If you don't have an account, please <a href='signup.php' style='color: #e53935; text-decoration: none;'>Sign Up</a>.
        </p>
    </div>
</div>
<script>
        setTimeout(function(){window.location.href='../../public/';}, 5000);
</script>";
}

?>