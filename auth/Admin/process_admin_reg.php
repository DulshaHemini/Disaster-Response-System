<?php
/**
 * Admin Registration Processing
 * Handles admin registration form submission and database insertion
 */

header('Content-Type: application/json');

// Include database configuration
require_once '../../config/config.php';

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}

// Get JSON data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validate JSON
if ($data === null) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid JSON format'
    ]);
    exit;
}

// ═══════════════════════════════════════════════════════════════════════════
// VALIDATION
// ═══════════════════════════════════════════════════════════════════════════

$errors = [];

// Validate First Name
if (empty($data['fname']) || strlen($data['fname']) < 2) {
    $errors['fname'] = 'First name must be at least 2 characters';
}

// Validate Last Name
if (empty($data['lname']) || strlen($data['lname']) < 2) {
    $errors['lname'] = 'Last name must be at least 2 characters';
}

// Validate Username
if (empty($data['username']) || strlen($data['username']) < 3) {
    $errors['username'] = 'Username must be at least 3 characters';
} elseif (strlen($data['username']) > 20) {
    $errors['username'] = 'Username must not exceed 20 characters';
} elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $data['username'])) {
    $errors['username'] = 'Username can only contain letters, numbers, and underscore';
}

// Validate Gender
if (empty($data['gender']) || !in_array($data['gender'], ['Male', 'Female'])) {
    $errors['gender'] = 'Invalid gender selection';
}

// Validate Age
$age = intval($data['age']);
if ($age < 18 || $age > 120) {
    $errors['age'] = 'Age must be between 18 and 120';
}

// Validate Email
if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Invalid email address';
}

// Validate Contact Number
if (empty($data['cnumber']) || !preg_match('/^[0-9\-\+\(\)\s]{10,}$/', str_replace(' ', '', $data['cnumber']))) {
    $errors['cnumber'] = 'Invalid contact number (minimum 10 digits)';
}

// Validate Password
if (empty($data['password'])) {
    $errors['password'] = 'Password is required';
}

// If validation errors exist, return them
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Validation failed',
        'errors' => $errors
    ]);
    exit;
}

// ═══════════════════════════════════════════════════════════════════════════
// SANITIZE DATA
// ═══════════════════════════════════════════════════════════════════════════

$fname = $conn->real_escape_string(trim($data['fname']));
$lname = $conn->real_escape_string(trim($data['lname']));
$username = $conn->real_escape_string(trim($data['username']));
$gender = $conn->real_escape_string($data['gender']);
$age = intval($data['age']);
$email = $conn->real_escape_string(trim($data['email']));
$cnumber = $conn->real_escape_string(trim($data['cnumber']));
$password = $data['password']; // Don't escape - will be hashed

// ═══════════════════════════════════════════════════════════════════════════
// CHECK IF EMAIL ALREADY EXISTS
// ═══════════════════════════════════════════════════════════════════════════

$checkEmail = "SELECT email FROM admin WHERE email = '$email'";
$result = $conn->query($checkEmail);

if ($result && $result->num_rows > 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Email address already registered'
    ]);
    exit;
}

// ═══════════════════════════════════════════════════════════════════════════
// CHECK IF USERNAME ALREADY EXISTS
// ═══════════════════════════════════════════════════════════════════════════

$checkUsername = "SELECT username FROM users WHERE username = '$username'";
$result = $conn->query($checkUsername);

if ($result && $result->num_rows > 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Username already taken'
    ]);
    exit;
}

// ═══════════════════════════════════════════════════════════════════════════
// START TRANSACTION
// ═══════════════════════════════════════════════════════════════════════════

$conn->begin_transaction();

try {
    // Hash the provided password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // ═══════════════════════════════════════════════════════════════════════════
    // INSERT INTO USERS TABLE
    // ═══════════════════════════════════════════════════════════════════════════
    
    $insertUserSQL = "INSERT INTO users (username, password, user_role) 
                      VALUES ('$username', '$hashedPassword', 'admin')";
    
    if (!$conn->query($insertUserSQL)) {
        throw new Exception("Error creating user account: " . $conn->error);
    }
    
    // Get the inserted user_id
    $user_id = $conn->insert_id;
    
    // ═══════════════════════════════════════════════════════════════════════════
    // INSERT INTO ADMIN TABLE
    // ═══════════════════════════════════════════════════════════════════════════
    
    $insertAdminSQL = "INSERT INTO admin (user_id, first_name, last_name, gender, age, email, contact_no) 
                       VALUES ($user_id, '$fname', '$lname', '$gender', $age, '$email', '$cnumber')";
    
    if (!$conn->query($insertAdminSQL)) {
        throw new Exception("Error creating admin record: " . $conn->error);
    }
    
    // Commit transaction
    $conn->commit();
    
    // ═══════════════════════════════════════════════════════════════════════════
    // RESPONSE
    // ═══════════════════════════════════════════════════════════════════════════
    
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Admin registered successfully! Redirecting...',
        'data' => [
            'user_id' => $user_id,
            'username' => $username,
            'email' => $email
        ]
    ]);
    
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Registration failed: ' . $e->getMessage()
    ]);
}

$conn->close();
?>
