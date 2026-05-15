<?php

require_once "../config/config.php";

$conn->select_db("DRCS1");

/* =========================================
   DISABLE FOREIGN KEY CHECKS
========================================= */

$conn->query("SET FOREIGN_KEY_CHECKS = 0");

/* =========================================
   DELETE TABLE DATA
========================================= */

/*
    Delete order matters because
    tables are connected using
    foreign keys.
*/

$conn->query("TRUNCATE TABLE resource");

$conn->query("TRUNCATE TABLE resource_type");

$conn->query("TRUNCATE TABLE volunteer");

$conn->query("TRUNCATE TABLE users");

/* =========================================
   ENABLE FOREIGN KEY CHECKS
========================================= */

$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "All table data deleted successfully!";

$conn->close();

?>