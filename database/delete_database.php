<?php

$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DROP DATABASE DRCS";

if ($conn->query($sql) === TRUE) {
    echo "Database DRCS deleted successfully";
} else {
    echo "Error deleting database: " . $conn->error;
}

$conn->close();
?>