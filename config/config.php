<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$host = "localhost";
$username = "root";
$password = "";
$database = "DRCS";
$port = 3307;

try{
    $conn = new mysqli($host, $username, $password, $database, $port);
    $conn->set_charset("utf8");
}
catch(mysqli_sql_exception $e){
    echo "Connection failed: " . $e->getMessage();
}

?>