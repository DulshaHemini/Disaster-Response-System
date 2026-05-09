<?php
// Enable error reporting to diagnose issues immediately
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DRCS";

$conn = new mysqli($servername, $username, $password);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// 1. Users Table
$conn->query("CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_role ENUM('admin', 'affected_people', 'volunteer') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// 2. Admin Table (FIXED: Removed duplicate 'age' and 'gender' columns)
$conn->query("CREATE TABLE IF NOT EXISTS admin (
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

// 3. Affected People Table
$conn->query("CREATE TABLE IF NOT EXISTS affected_people (
    user_id INT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL, 
    last_name VARCHAR(100) NOT NULL, 
    age INT,
    no_of_family_members INT,
    gender ENUM('Male', 'Female') NOT NULL,
    priority_level ENUM('low', 'medium', 'high'),
    nic VARCHAR(20),
    contact_no VARCHAR(15),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
)");

// 4. Volunteers Table (FIXED: Removed duplicate 'age' and 'gender' columns)
$conn->query("CREATE TABLE IF NOT EXISTS volunteer (
    user_id INT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    nic VARCHAR(20),
    gender ENUM('Male', 'Female') NOT NULL,
    contact_no VARCHAR(15),
    age int(2),
    availability_status ENUM('available', 'busy') DEFAULT 'available',
    organization_name VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
)");

// 5. Location Table
$conn->query("CREATE TABLE IF NOT EXISTS Location(
    loc_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    latitude DECIMAL (20,16),
    longitude DECIMAL (20,16),
    district VARCHAR (50),
    city VARCHAR (50),
    street VARCHAR (50),
    home_no VARCHAR (50),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
)");
  
// 6. Request Table
$conn->query("CREATE TABLE IF NOT EXISTS Request(
    req_id INT PRIMARY KEY AUTO_INCREMENT,
    affected_people_id INT,
    loc_id INT,
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
    FOREIGN KEY (affected_people_id) REFERENCES affected_people(user_id) ON DELETE SET NULL,
    FOREIGN KEY (loc_id) REFERENCES Location(loc_id) ON UPDATE CASCADE
)");

// 7. Resource Table (FIXED: Renamed from 'resourc' to 'resource')
$conn->query("CREATE TABLE IF NOT EXISTS resource(
    resource_id INT PRIMARY KEY AUTO_INCREMENT,
    volunteer_id INT,
    resource_name VARCHAR (100),
    resource_type ENUM('Medicals', 'Foods', 'Shelters', 'Cloths', 'Money') NOT NULL,
    resource_count INT,
    description TEXT,
    FOREIGN KEY (volunteer_id) REFERENCES volunteer (user_id) ON DELETE CASCADE
)");

// 8. Assignment Table
$conn->query("CREATE TABLE IF NOT EXISTS assignment(
    assignment_id INT PRIMARY KEY AUTO_INCREMENT,
    assigned_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    req_id INT NOT NULL,
    resource_id INT,
    volunteer_id INT,
    description TEXT,
    status ENUM('Assigned', 'Allocated', 'Received') NOT NULL,
    FOREIGN KEY (req_id) REFERENCES Request(req_id) ON DELETE CASCADE,
    FOREIGN KEY (resource_id) REFERENCES resource(resource_id),
    FOREIGN KEY (volunteer_id) REFERENCES volunteer(user_id)
)");

// 9. Money Allocation Table
$conn->query("CREATE TABLE IF NOT EXISTS money_allocation(
    allocation_id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT NOT NULL,
    req_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    note TEXT,
    allocated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admin(user_id),
    FOREIGN KEY (req_id) REFERENCES Request(req_id) ON DELETE CASCADE
)");

echo "<h3>All tables created successfully!</h3>";
$conn->close();
?>