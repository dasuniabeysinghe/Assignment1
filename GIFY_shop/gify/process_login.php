<?php
session_start();
require_once 'config/database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if(empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password required!']);
    exit;
}

try {
    $sql = "SELECT id, full_name, email, password, is_admin FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['is_admin'] = $user['is_admin'];
        
        // Set admin session if user is admin
        if($user['is_admin'] == 1) {
            $_SESSION['admin_logged_in'] = true;
        }
        
        echo json_encode([
            'success' => true, 
            'message' => 'Login successful!',
            'is_admin' => $user['is_admin']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password!']);
    }
} catch(PDOException $e) {
    error_log("Login error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Login failed. Please try again.']);
}
?>