<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DRCS";

// Create connection
$conn = new mysqli($servername, $username, $password, "", 3307);

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
echo "Users People table created successfully!<br>";


//Create Admin table
$sql = "CREATE TABLE IF NOT EXISTS admin (
    user_id INT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    age INT,
    email VARCHAR(100),
    contact_no VARCHAR(15),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
    ON DELETE CASCADE
)";
$conn->query($sql);
echo "Admin table created successfully!<br>";


//Create Affected people table
$sql = "CREATE TABLE IF NOT EXISTS affected_people (
    user_id INT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL, 
    last_name VARCHAR(100) NOT NULL, 
    age INT,
    no_of_family_members INT,
    gender ENUM('Male', 'Female') NOT NULL,
    nic VARCHAR(20),
    contact_no VARCHAR(15),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
    ON DELETE CASCADE
)";
$conn->query($sql);
echo "Affected People table created successfully!<br>";


//Create Volunteers table
$sql = "CREATE TABLE IF NOT EXISTS volunteer (
    user_id INT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    nic VARCHAR(20),
    gender ENUM('Male', 'Female') NOT NULL,
    contact_no VARCHAR(15),
    age int(2),
    availability_status ENUM('available', 'busy') DEFAULT 'available',
    organization_name VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
    ON DELETE CASCADE
)";
$conn->query($sql);
echo "Volunteer table created successfully!<br>";


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
echo "Location table created successfully!<br>";


//Create all requests table
$sql = "CREATE TABLE IF NOT EXISTS requests(
    request_id INT PRIMARY KEY AUTO_INCREMENT,
    request_type ENUM('Instant_Request', 'Logged_Request') NOT NULL
)";
$conn->query($sql);
echo "Request table created successfully!<br>";

//Create Instant_Request table
$sql = "CREATE TABLE IF NOT EXISTS Instant_Request(
    req_id INT PRIMARY KEY,
    user_id INT,
    loc_id INT,
    full_name VARCHAR(100),
    req_name VARCHAR(255) NOT NULL,
    resource_type ENUM('Medicins', 'Foods', 'Shelters', 'Clothes', 'Money') NOT NULL,
    resource_count INT,
    description VARCHAR(255),
    contact_number VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (req_id) REFERENCES requests(request_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (loc_id) REFERENCES Location(loc_id) ON UPDATE CASCADE
)";
$conn->query($sql);
echo "Instant Request table created successfully!<br>";


//Create Logged_Request table
$sql = "CREATE TABLE IF NOT EXISTS Logged_Request(
    req_id INT PRIMARY KEY,
    affected_people_id INT,
    loc_id INT,
    user_id INT,
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
    FOREIGN KEY (req_id) REFERENCES requests(request_id) ON DELETE CASCADE,
    FOREIGN KEY (affected_people_id) REFERENCES affected_people(user_id) ON DELETE SET NULL,
    FOREIGN KEY (loc_id) REFERENCES Location(loc_id) ON UPDATE CASCADE
)";
$conn->query($sql);
echo "Logged Request table created successfully!<br>";


//Create resource table
$sql = "CREATE TABLE IF NOT EXISTS resource(
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
echo "Resource table created successfully!<br>";


//Create assignment table
$sql = "CREATE TABLE IF NOT EXISTS assignment(
    assignment_id INT PRIMARY KEY AUTO_INCREMENT,
    assigned_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    req_id INT NOT NULL,
    resource_id INT,
    volunteer_id INT,
    affected_people_id INT,
    description TEXT,
    status ENUM('Assigned', 'Allocated', 'Received') NOT NULL,
    FOREIGN KEY (req_id) REFERENCES requests(req_id) ON DELETE CASCADE,
    FOREIGN KEY (resource_id) REFERENCES resource(resource_id),
    FOREIGN KEY (volunteer_id) REFERENCES volunteer(user_id)
)";
$conn->query($sql);
echo "Assignment table created successfully!<br>";


echo "All tables created successfully!";

$conn->close();

?>
