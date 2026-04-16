<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DRCS";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

//Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);

// Select database
$conn->select_db($dbname);

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_role ENUM('admin', 'affected_people', 'volunteer') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

//Create Admin table
$sql = "CREATE TABLE IF NOT EXISTS admin (
    user_id INT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    contact_no VARCHAR(15),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)";
$conn->query($sql);

//Create Affected people table
$sql = "CREATE TABLE IF NOT EXISTS affected_people (
    user_id INT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    nic VARCHAR(20),
    contact_no VARCHAR(15),
    no_of_family_members INT,
    priority_level ENUM('low', 'medium', 'high'),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)";
$conn->query($sql);

//Create Volunteers table
$sql = "CREATE TABLE IF NOT EXISTS volunteer (
    user_id INT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    nic VARCHAR(20),
    contact_no VARCHAR(15),
    availability_status ENUM('available', 'busy') DEFAULT 'available',
    organization_name VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)";
$conn->query($sql);

//Create location table
$sql = "CREATE TABLE IF NOT EXISTS Location(
    loc_id INT AUTO_INCREMENT PRIMARY KEY,
    latitude DECIMAL (20,16),
    longitude DECIMAL (20,16),
    province VARCHAR (50) NOT NULL,
    district VARCHAR (50) NOT NULL,
    street VARCHAR (50) NOT NULL

)";
$conn->query($sql);

//Create requests table
$sql = "CREATE TABLE IF NOT EXISTS Request(
    req_id INT PRIMARY KEY AUTO_INCREMENT,
    req_name VARCHAR(255) NOT NULL,
    req_type VARCHAR(50) NOT NULL,
    description VARCHAR(256) ,
    contact_number VARCHAR(20) NOT NULL,
    priority VARCHAR(50) ,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'Pending',
    loc_id INT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    ON UPDATE CASCADE
    FOREIGN KEY (loc_id) REFERENCES Location(loc_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)";
$conn->query($sql);


echo "All tables created successfully!";

$conn->close();

?>