<?php
require_once 'config/database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validate email domain
if (!strpos($email, '@') === false) {
    $domain = explode('@', $email)[1];
    if ($domain !== 'students.nsbm.ac.lk' && $domain !== 'nsbm.ac.lk') {
        echo json_encode(['success' => false, 'message' => 'Please use your NSBM email address!']);
        exit;
    }
}

if(empty($fullname) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required!']);
    exit;
}

if(strlen($password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters!']);
    exit;
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    // Check if email already exists
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    
    if($check->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Email already exists!']);
        exit;
    }
    
    // Insert new user
    $sql = "INSERT INTO users (full_name, email, password, is_admin) VALUES (?, ?, ?, 0)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fullname, $email, $hashed_password]);
    
    echo json_encode(['success' => true, 'message' => 'Registration successful! Please login.']);
    
} catch(PDOException $e) {
    error_log("Signup error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Registration failed. Please try again.']);
}
?>