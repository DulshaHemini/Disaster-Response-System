<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$host = "localhost";
$username = "root";
$password = "";
$database = "DRCS";
<<<<<<< HEAD
$port = 3308;

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
=======
$port = 3306;

try{
    $conn = new mysqli($host, $username, $password, $database, $port);
    $conn->set_charset("utf8");
}
catch(mysqli_sql_exception $e){
    echo "Connection failed: " . $e->getMessage();
>>>>>>> 162015902fc7554dc63defaa6d648a7f2748ed0f
}

?>