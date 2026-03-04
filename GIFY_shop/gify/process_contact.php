<?php
require_once 'config/database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if(empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Name, email and message are required!']);
    exit;
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format!']);
    exit;
}

try {
    $sql = "INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $phone, $subject, $message]);
    
    echo json_encode(['success' => true, 'message' => 'Message sent successfully!']);
    
} catch(PDOException $e) {
    error_log("Contact error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Failed to send message. Please try again.']);
}
?>