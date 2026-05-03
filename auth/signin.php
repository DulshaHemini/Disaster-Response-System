<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign in</title>
    </head>
    <body>
        <h1>Sign In</h1>
        <form id="userForm" method="POST">
            <input type="text" name="username" id="username" placeholder="Username"><br><br>
            <input type="password" name="password" id="password" placeholder="Password"><br><br>
            <input type="submit" value="Submit">
        </form>

        <script>

            document.getElementById("userForm").addEventListener("submit", function(event) {
                event.preventDefault();

                const name = document.getElementById("username");
                const pwd = document.getElementById("password");  

                if (name.value === "" && pwd.value === "") {
                    alert("Username and Password cannot be empty!");
                } 
                else if (name.value === "") {
                    alert("Username cannot be empty!");  
                } 
                else if (pwd.value === "") {
                    alert("Password cannot be empty!");  
                }
                else {
                    this.submit();
                    <?php
                        require_once '../config/config.php'; 

                    if (isset($_POST['username'])  && isset($_POST['password'])){
                        $name =  $_POST['username'];
                        $password = $_POST['password'];
                    }
                    function submit($name, $password){
                        $sql = mysqli_query($conn,"SELECT * FROM user");
                        $row = mysqli_fetch_assoc($sql);
                        $hashedpassword = $row['password'];

                        foreach($row as $result){
                            if ($result['name'] === $name){
                                if(password_verify($password,$hashedpassword)){
                                    echo 'Login Successful!';
                                }else{
                                    echo 'Invalid Password!';
                                }
                            }else{
                                echo 'User Not Found!';
                            }
                        }
                        
                    }
                    ?>
                }
            });
        </script>
    </body>
    </html>
