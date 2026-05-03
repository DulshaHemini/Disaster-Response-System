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
)";
$conn->query($sql);

//Create location table
$sql = "CREATE TABLE IF NOT EXISTS Location(
    loc_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    latitude DECIMAL (20,16),
    longitude DECIMAL (20,16),
    district VARCHAR (50),
    city VARCHAR (50),
    street VARCHAR (50),
    home_no VARCHAR (50),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
    ON DELETE CASCADE
)";
$conn->query($sql);

//Create requests table
$sql = "CREATE TABLE IF NOT EXISTS Request(
    req_id INT PRIMARY KEY AUTO_INCREMENT,
    req_name VARCHAR(255) NOT NULL,
    req_type ENUM('tornadoes', 'tsunamis', 'landslides', 'avalanches', 'heat waves') NOT NULL,
    resource_type ENUM('Medicins', 'Foods', 'Shelters', 'Clothes', 'Money') NOT NULL,
    resource_count INT,
    no_of_affected_people INT,
    description VARCHAR(255),
    contact_number VARCHAR(20) NOT NULL,
    priority_level ENUM('low', 'medium', 'high'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'Pending',
    is_instant TINYINT(1) DEFAULT 0,
    loc_id INT,
    user_id INT DE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (loc_id) REFERENCES Location(loc_id) ON UPDATE CASCADE
)";
$conn->query($sql);


$sql = "CREATE TABLE IF NOT EXISTS resourc(
    resource_id INT PRIMARY KEY AUTO_INCREMENT,
    volunteer_id INT,
    resource_name VARCHAR (100),
    resource_type ENUM('Medicals', 'Foods', 'Shelters', 'Cloths', 'Money') NOT NULL,
    resource_count INT,
    description TEXT,
    FOREIGN KEY (volunteer_id) REFERENCES volunteer (user_id)
    ON DELETE CASCADE
)";
$conn->query($sql);


$sql = "CREATE TABLE IF NOT EXISTS assignment(
    assignment_id INT PRIMARY KEY AUTO_INCREMENT,
    assigned_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    req_id INT NOT NULL,
    resource_id INT,
    volunteer_id INT,
    description TEXT,
    status ENUM('Assigned', 'Allocated', 'Received') NOT NULL,
    FOREIGN KEY (req_id) REFERENCES Request(req_id) ON DELETE CASCADE,
    FOREIGN KEY (resource_id) REFERENCES resourc(resource_id),
    FOREIGN KEY (volunteer_id) REFERENCES volunteer(user_id)
)";
$conn->query($sql);


$sql = "CREATE TABLE IF NOT EXISTS money_allocation(
    allocation_id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT NOT NULL,
    req_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    note TEXT,
    allocated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admin(user_id),
    FOREIGN KEY (req_id) REFERENCES Request(req_id) ON DELETE CASCADE
)";
$conn->query($sql);


echo "All tables created successfully!";

$conn->close();

?>