<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in']) && !isset($_SESSION['is_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$order_id = $_GET['id'] ?? 0;

try {
    // Get order items
    $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->execute([$order_id]);
    $items = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'items' => $items
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to load order details']);
}
?>