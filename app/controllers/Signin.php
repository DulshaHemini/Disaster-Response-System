<?php
require_once '../../config/config.php';
require_once '../views/auth/_SignIn.php';
require_once '../models/auth/SignIn_.php';
require '../../config/route.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['username']) ?? '';
    $password = trim($_POST['password']) ?? '';

    $result = userSignin($conn, $name, $password);

    if($result) {
        $user_id = $result['user_id'] ?? '';
        $user_role = $result['user_role'] ?? '';
        success();
        session_start();
        $_SESSION['user_id'] = $user_id;
        if ($user_role === 'relief_team') {
            header("Location: relief_team.php");
            exit();
        } elseif ($user_role === 'affected_people') {
            header("Location: affected_people.php");
            exit();
        } elseif ($user_role === 'volunteer') {
            header("Location: volunteer.php");
            exit();
        } else {
            signin_fail();
        }
    }
    else {
        signin_fail();
    }
}

showSigninForm();

?>