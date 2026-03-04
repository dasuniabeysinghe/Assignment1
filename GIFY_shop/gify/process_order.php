<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to place order']);
    exit;
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid order data']);
    exit;
}

$userId = $_SESSION['user_id'];
$addressId = $data['addressId'] ?? 0;
$paymentMethod = $data['paymentMethod'] ?? '';
$faculty = $data['faculty'] ?? '';
$deliveryOption = $data['deliveryOption'] ?? 'standard';
$specialNotes = $data['specialNotes'] ?? '';
$cart = $data['cart'] ?? [];

if (empty($cart) || !$addressId || !$paymentMethod || !$faculty) {
    echo json_encode(['success' => false, 'message' => 'Missing order information']);
    exit;
}

try {
    $pdo->beginTransaction();
    
    // Get delivery address
    $stmt = $pdo->prepare("SELECT * FROM addresses WHERE id = ? AND user_id = ?");
    $stmt->execute([$addressId, $userId]);
    $address = $stmt->fetch();
    
    if (!$address) {
        throw new Exception('Invalid address');
    }
    
    $deliveryAddress = $address['building_name'] . ', ' . $address['address_line'];
    
    // Generate unique order number
    $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
    
    // Calculate total
    $totalAmount = 0;
    foreach ($cart as $item) {
        $totalAmount += $item['price'] * $item['quantity'];
    }
    
    // Create order with faculty and delivery option
    $stmt = $pdo->prepare("
        INSERT INTO orders (user_id, order_number, total_amount, payment_method, delivery_address, faculty, delivery_option, special_notes) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $userId, 
        $orderNumber, 
        $totalAmount, 
        $paymentMethod, 
        $deliveryAddress,
        $faculty,
        $deliveryOption,
        $specialNotes
    ]);
    $orderId = $pdo->lastInsertId();
    
    // Group cart items by product ID
    $groupedItems = [];
    foreach ($cart as $item) {
        $key = $item['id'];
        if (isset($groupedItems[$key])) {
            $groupedItems[$key]['quantity']++;
        } else {
            $groupedItems[$key] = [
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => 1
            ];
        }
    }
    
    // Insert order items
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)");
    foreach ($groupedItems as $item) {
        $stmt->execute([$orderId, $item['product_id'], $item['product_name'], $item['price'], $item['quantity']]);
    }
    
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Order placed successfully!',
        'order_number' => $orderNumber
    ]);
    
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Order error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Failed to place order: ' . $e->getMessage()]);
}
?>
