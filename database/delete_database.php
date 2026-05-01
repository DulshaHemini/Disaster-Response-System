<?php

require_once "../config/config.php";

$sql = "DROP DATABASE DRCS";

if ($conn->query($sql) === TRUE) {
    echo "Database DRCS deleted successfully";
} else {
    echo "Error deleting database: " . $conn->error;
}

$conn->close();
?>