<?php

require_once "../config/config.php";

/* =========================================
   DELETE DATABASE
========================================= */

$sql = "DROP DATABASE IF EXISTS DRCS1";

if ($conn->query($sql) === TRUE) {

    echo "Database deleted successfully.";

} else {

    echo "Error deleting database: " . $conn->error;
}

$conn->close();

?>