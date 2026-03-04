<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY category, created_at DESC");
    $products = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'products' => $products
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to fetch products'
    ]);
}
?>
