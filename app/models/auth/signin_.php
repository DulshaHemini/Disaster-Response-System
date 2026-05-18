<?php

function userSignin($conn, $username, $password) {

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($password == $row['password']) {
            return $row;
        } else {
            return 'failed';
        }
    } else {
        return 'failed';
    }
}

?>