<?php
require_once '../../config/config.php';
require_once '../views/auth/_signin.php';
require_once '../models/auth/signin_.php';
require '../../config/route.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['username']) ?? '';
    $password = trim($_POST['password']) ?? '';

    $result = userSignin($conn, $name, $password);

    if($result) {
        $user_id = $result['user_id'] ?? '';
        $user_role = $result['user_role'] ?? '';
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_role'] = $user_role;
        success();
        if ($user_role === 'relief_team') {
            header("Location: ReliefTeam.php"); // same folder, relative path
            exit();
        } elseif ($user_role === 'affected_people') {
            header("Location: affected_people.php");
            exit();
        } elseif ($user_role === 'volunteer') {
            header("Location: volunteer.php");
            exit();
        } elseif ($user_role === 'admin') {
            header("Location: admin.php");
            exit();
        } elseif ($user_role === 'guest') {
            header("Location: guest.php");
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

