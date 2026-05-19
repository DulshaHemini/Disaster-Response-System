<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$host = "localhost";
$username = "root";
$password = "";
$database = "DRCS";
$port = 3306;

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>