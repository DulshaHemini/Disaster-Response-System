<?php


$conn = new mysqli(
    "localhost",
    "root",
    "",
    ""
);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
}




    // require_once "../config/config.php";

/* =========================================
   CREATE DATABASE
========================================= */

$sql = "CREATE DATABASE IF NOT EXISTS DRCS1";

if ($conn->query($sql) === TRUE) {
    echo "Database created successfully.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

$conn->select_db("DRCS1");

/* =========================================
   USERS TABLE
========================================= */

$sql = "CREATE TABLE IF NOT EXISTS users(

    user_id INT PRIMARY KEY AUTO_INCREMENT,

    username VARCHAR(50) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    user_role ENUM('admin', 'volunteer', 'affected_people') NOT NULL,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Users table created successfully.<br>";
} else {
    die("Error creating users table: " . $conn->error);
}

/* =========================================
   VOLUNTEER TABLE
========================================= */

$sql = "CREATE TABLE IF NOT EXISTS volunteer(

    user_id INT PRIMARY KEY,

    first_name VARCHAR(50) NOT NULL,

    last_name VARCHAR(50) NOT NULL,

    nic VARCHAR(20) UNIQUE,

    gender VARCHAR(10),

    contact_no VARCHAR(20),

    age INT,

    availability_status VARCHAR(30),

    organization_name VARCHAR(100),

    FOREIGN KEY (user_id)
    REFERENCES users(user_id)
    ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "Volunteer table created successfully.<br>";
} else {
    die("Error creating volunteer table: " . $conn->error);
}

/* =========================================
   RESOURCE TYPE TABLE
========================================= */

$sql = "CREATE TABLE IF NOT EXISTS resource_type(

    resource_type_id INT PRIMARY KEY AUTO_INCREMENT,

    resource_name VARCHAR(50) NOT NULL UNIQUE,

    is_default TINYINT(1) DEFAULT 0
)";

if ($conn->query($sql) === TRUE) {
    echo "Resource type table created successfully.<br>";
} else {
    die("Error creating resource_type table: " . $conn->error);
}

/* =========================================
   RESOURCE TABLE
========================================= */

$sql = "CREATE TABLE IF NOT EXISTS resource(

    resource_id INT PRIMARY KEY AUTO_INCREMENT,

    volunteer_id INT Not NULL,

    resource_type_id INT NOT NULL,

    resource_name VARCHAR(100) NOT NULL,

    resource_count INT DEFAULT 0,

    resource_unit VARCHAR(50) DEFAULT '',

    resource_max INT DEFAULT 0,

    description TEXT,

    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (volunteer_id)
    REFERENCES volunteer(user_id)
    ON DELETE CASCADE,

    FOREIGN KEY (resource_type_id)
    REFERENCES resource_type(resource_type_id)
    ON DELETE RESTRICT
)";

if ($conn->query($sql) === TRUE) {
    echo "Resource table created successfully.<br>";
} else {
    die("Error creating resource table: " . $conn->error);
}

$conn->close();

?>