<?php

require_once "../config/config.php";

// Disable foreign key checks first
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// TRUNCATE all tables
$conn->query("TRUNCATE TABLE Request");
$conn->query("TRUNCATE TABLE Location");
$conn->query("TRUNCATE TABLE volunteer");
$conn->query("TRUNCATE TABLE affected_people");
$conn->query("TRUNCATE TABLE admin");
$conn->query("TRUNCATE TABLE users");

// Re-enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "All table data deleted successfully!";

$conn->close();

?>