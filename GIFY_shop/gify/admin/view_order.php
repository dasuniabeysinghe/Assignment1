<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$order_id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("
    SELECT o.*, u.full_name, u.email 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    WHERE o.id = ?
");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: index.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Details #<?php echo $order['order_number']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .order-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .info-label {
            width: 150px;
            font-weight: 600;
            color: #666;
        }
        .info-value {
            flex: 1;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #333;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .total {
            font-size: 18px;
            font-weight: 700;
            color: var(--pink);
            text-align: right;
            margin-top: 20px;
        }
        .back-btn {
            background: #667eea;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .back-btn:hover {
            background: #5a67d8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-shopping-bag"></i> Order Details #<?php echo $order['order_number']; ?></h1>
        
        <div class="order-info">
            <div class="info-row">
                <span class="info-label">Customer:</span>
                <span class="info-value"><?php echo htmlspecialchars($order['full_name']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value"><?php echo htmlspecialchars($order['email']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Method:</span>
                <span class="info-value">
                    <?php if($order['payment_method'] == 'card'): ?>
                        <i class="fas fa-credit-card"></i> Credit Card
                    <?php else: ?>
                        <i class="fas fa-money-bill-wave"></i> Cash on Delivery
                    <?php endif; ?>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Delivery Address:</span>
                <span class="info-value"><?php echo htmlspecialchars($order['delivery_address']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Faculty/Department:</span>
                <span class="info-value"><i class="fas fa-building"></i> <?php echo htmlspecialchars($order['faculty']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Delivery Option:</span>
                <span class="info-value">
                    <?php
                        $deliveryOptions = [
                            'standard' => 'Standard Delivery (2-3 working days)',
                            'express' => 'Express Delivery (Same day / Next day)',
                            'scheduled' => 'Scheduled Delivery (Choose your date & time)'
                        ];
                        echo isset($deliveryOptions[$order['delivery_option']]) ? $deliveryOptions[$order['delivery_option']] : htmlspecialchars($order['delivery_option']);
                    ?>
                </span>
            </div>
            <?php if(!empty($order['special_notes'])): ?>
            <div class="info-row">
                <span class="info-label">Special Notes:</span>
                <span class="info-value"><?php echo htmlspecialchars($order['special_notes']); ?></span>
            </div>
            <?php endif; ?>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value"><?php echo ucfirst($order['status']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Order Date:</span>
                <span class="info-value"><?php echo date('F j, Y, g:i a', strtotime($order['created_at'])); ?></span>
            </div>
        </div>
        
        <h2>Order Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td>Rs. <?php echo number_format($item['price']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>Rs. <?php echo number_format($item['price'] * $item['quantity']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="total">
            Total Amount: Rs. <?php echo number_format($order['total_amount']); ?>
        </div>
        
        <a href="index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</body>
</html>