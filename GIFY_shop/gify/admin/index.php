<?php
session_start();
require_once '../config/database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Handle product actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'add':
                $name = $_POST['name'];
                $category = $_POST['category'];
                $price = $_POST['price'];
                $old_price = !empty($_POST['old_price']) ? $_POST['old_price'] : null;
                $description = $_POST['description'];
                $image_url = $_POST['image_url'];
                
                $stmt = $pdo->prepare("INSERT INTO products (name, category, price, old_price, description, image_url) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $category, $price, $old_price, $description, $image_url]);
                $_SESSION['message'] = 'Product added successfully!';
                break;
                
            case 'edit':
                $id = $_POST['id'];
                $name = $_POST['name'];
                $category = $_POST['category'];
                $price = $_POST['price'];
                $old_price = !empty($_POST['old_price']) ? $_POST['old_price'] : null;
                $description = $_POST['description'];
                $image_url = $_POST['image_url'];
                
                $stmt = $pdo->prepare("UPDATE products SET name=?, category=?, price=?, old_price=?, description=?, image_url=? WHERE id=?");
                $stmt->execute([$name, $category, $price, $old_price, $description, $image_url, $id]);
                $_SESSION['message'] = 'Product updated successfully!';
                break;
                
            case 'delete':
                $id = $_POST['id'];
                $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
                $stmt->execute([$id]);
                $_SESSION['message'] = 'Product deleted successfully!';
                break;
        }
        header('Location: index.php');
        exit();
    }
}

// Get statistics
$users_count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$messages_count = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
$products_count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();

// Get all data
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
$products = $pdo->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - GIFY Flower Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #f4f4f4;
        }
        
        /* Admin Container */
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h2 {
            font-size: 32px;
            margin-bottom: 5px;
            font-weight: 700;
        }
        
        .sidebar-header h2 span {
            color: #ffe484;
        }
        
        .sidebar-header p {
            font-size: 14px;
            opacity: 0.8;
            letter-spacing: 1px;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 15px 25px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
            font-size: 15px;
        }
        
        .sidebar-menu a i {
            margin-right: 12px;
            width: 25px;
            font-size: 18px;
        }
        
        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.15);
            border-left-color: #ffe484;
            padding-left: 30px;
        }
        
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            border-left-color: #ffe484;
            font-weight: 600;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }
        
        /* Header */
        .header {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 26px;
            color: #333;
            display: flex;
            align-items: center;
        }
        
        .header h1 i {
            color: #667eea;
            margin-right: 15px;
            font-size: 32px;
        }
        
        .header h1 span {
            color: #e84393;
            font-weight: 700;
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        /* Message */
        .message {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .message i {
            font-size: 20px;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        }
        
        .stat-info h3 {
            font-size: 15px;
            color: #999;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .stat-info .number {
            font-size: 42px;
            font-weight: 700;
            color: #333;
            line-height: 1;
        }
        
        .stat-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
        }
        
        /* Tab Navigation */
        .tab-navigation {
            background: white;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .tab-btn {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f4f4f4;
            color: #666;
            flex: 1;
            justify-content: center;
        }
        
        .tab-btn i {
            font-size: 18px;
        }
        
        .tab-btn:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }
        
        .tab-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        /* Content Cards */
        .content-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            display: none;
        }
        
        .content-card.active {
            display: block;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card-header {
            padding: 20px 25px;
            border-bottom: 2px solid #f4f4f4;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-header h2 {
            font-size: 20px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card-header h2 i {
            color: #667eea;
            font-size: 24px;
        }
        
        .card-header .badge {
            background: #667eea;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        
        .add-btn {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        
        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
            padding: 0 25px 25px 25px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        th {
            text-align: left;
            padding: 15px 10px;
            background: #f8f9fa;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        
        td {
            padding: 15px 10px;
            border-bottom: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        
        tr:hover td {
            background: #f8f9fa;
        }
        
        /* Action Buttons */
        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            margin: 0 3px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .edit-btn {
            background: #007bff;
            color: white;
        }
        
        .edit-btn:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        
        .delete-btn {
            background: #dc3545;
            color: white;
        }
        
        .delete-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: white;
            width: 90%;
            max-width: 600px;
            border-radius: 15px;
            padding: 30px;
            position: relative;
            animation: modalSlideIn 0.3s ease;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 28px;
            cursor: pointer;
            color: #999;
            transition: all 0.3s;
        }
        
        .close:hover {
            color: #333;
            transform: rotate(90deg);
        }
        
        .modal h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .modal h2 i {
            color: #667eea;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        
        .form-group label i {
            color: #667eea;
            margin-right: 5px;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        /* Product image */
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 10px;
        }
        
        /* Category badge */
        .category-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        /* Message preview */
        .message-preview {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #999;
        }
        
        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px;
            color: #999;
        }
        
        .empty-state i {
            font-size: 60px;
            margin-bottom: 20px;
            color: #ddd;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
            }
            .sidebar-header h2 span, .sidebar-header p, .sidebar-menu a span {
                display: none;
            }
            .sidebar-menu a {
                text-align: center;
                padding: 20px 0;
            }
            .sidebar-menu a i {
                margin: 0;
                font-size: 24px;
            }
            .main-content {
                margin-left: 80px;
            }
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .tab-navigation {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>GIFY<span>.</span></h2>
                <p>ADMIN PANEL</p>
            </div>
            <div class="sidebar-menu">
                <a href="#" class="active" onclick="showTab('users'); return false;">
                    <i class="fas fa-users"></i> <span>Users</span>
                </a>
                <a href="#" onclick="showTab('messages'); return false;">
                    <i class="fas fa-envelope"></i> <span>Messages</span>
                </a>
                <a href="#" onclick="showTab('products'); return false;">
                    <i class="fas fa-box"></i> <span>Products</span>
                </a>
                <a href="logout.php" style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 20px;">
                    <i class="fas fa-sign-out"></i> <span>Logout</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>
                    <i class="fas fa-chart-pie"></i> 
                    Welcome back, <span>Admin</span>
                </h1>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out"></i> Logout
                </a>
            </div>

            <?php if($message): ?>
            <div class="message">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-info">
                        <h3><i class="fas fa-users"></i> Total Users</h3>
                        <div class="number"><?php echo $users_count; ?></div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3><i class="fas fa-envelope"></i> Messages</h3>
                        <div class="number"><?php echo $messages_count; ?></div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3><i class="fas fa-box"></i> Products</h3>
                        <div class="number"><?php echo $products_count; ?></div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="showTab('users')">
                    <i class="fas fa-users"></i> Manage Users
                </button>
                <button class="tab-btn" onclick="showTab('messages')">
                    <i class="fas fa-envelope"></i> View Messages
                </button>
                <button class="tab-btn" onclick="showTab('products')">
                    <i class="fas fa-box"></i> Products Catalog
                </button>
            </div>

            <!-- Users Section -->
            <div id="users" class="content-card active">
                <div class="card-header">
                    <h2><i class="fas fa-users"></i> Registered Users</h2>
                    <span class="badge">Total: <?php echo $users_count; ?></span>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Admin</th>
                                <th>Registration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($users)): ?>
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <p>No users registered yet</p>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach($users as $user): ?>
                                <tr>
                                    <td><strong>#<?php echo $user['id']; ?></strong></td>
                                    <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <?php if($user['is_admin']): ?>
                                            <span style="color: #28a745;"><i class="fas fa-check-circle"></i> Admin</span>
                                        <?php else: ?>
                                            <span style="color: #999;">User</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('M d, Y - h:i A', strtotime($user['created_at'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Messages Section -->
            <div id="messages" class="content-card">
                <div class="card-header">
                    <h2><i class="fas fa-envelope"></i> Contact Messages</h2>
                    <span class="badge">Total: <?php echo $messages_count; ?></span>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($messages)): ?>
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <i class="fas fa-envelope"></i>
                                    <p>No messages yet</p>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach($messages as $msg): ?>
                                <tr>
                                    <td><strong>#<?php echo $msg['id']; ?></strong></td>
                                    <td><?php echo htmlspecialchars($msg['name']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['email']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['phone'] ?: 'Not provided'); ?></td>
                                    <td><?php echo htmlspecialchars($msg['subject'] ?: 'General'); ?></td>
                                    <td class="message-preview"><?php echo htmlspecialchars($msg['message']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Products Section -->
            <div id="products" class="content-card">
                <div class="card-header">
                    <h2><i class="fas fa-box"></i> Products Catalog</h2>
                    <button class="add-btn" onclick="openAddProductModal()">
                        <i class="fas fa-plus"></i> Add New Product
                    </button>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Old Price</th>
                                <th>Discount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($products)): ?>
                            <tr>
                                <td colspan="8" class="empty-state">
                                    <i class="fas fa-box"></i>
                                    <p>No products found</p>
                                    <button class="add-btn" onclick="openAddProductModal()">
                                        <i class="fas fa-plus"></i> Add Your First Product
                                    </button>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach($products as $product): ?>
                                <tr>
                                    <td><strong>#<?php echo $product['id']; ?></strong></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                             class="product-image" 
                                             alt="<?php echo $product['name']; ?>"
                                             onerror="this.src='https://via.placeholder.com/50'">
                                    </td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><span class="category-badge"><?php echo $product['category']; ?></span></td>
                                    <td><strong>Rs. <?php echo number_format($product['price']); ?></strong></td>
                                    <td>
                                        <?php if($product['old_price']): ?>
                                            <span style="color: #999; text-decoration: line-through;">
                                                Rs. <?php echo number_format($product['old_price']); ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($product['old_price']): ?>
                                            <span style="color: #28a745; font-weight: 600;">
                                                <?php 
                                                $discount = (($product['old_price'] - $product['price']) / $product['old_price']) * 100;
                                                echo round($discount) . '% OFF';
                                                ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="action-btn edit-btn" onclick="openEditProductModal(<?php echo htmlspecialchars(json_encode($product)); ?>)">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="action-btn delete-btn" onclick="deleteProduct(<?php echo $product['id']; ?>, '<?php echo addslashes($product['name']); ?>')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddProductModal()">&times;</span>
            <h2><i class="fas fa-plus-circle"></i> Add New Product</h2>
            <form method="POST" id="addProductForm">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label><i class="fas fa-tag"></i> Product Name</label>
                    <input type="text" name="name" required placeholder="Enter product name">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-list"></i> Category</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <option value="flowers">Flowers</option>
                        <option value="gifts">Gift Items</option>
                        <option value="sale">Special Offers</option>
                        <option value="occasion">Occasion Specials</option>
                        <option value="new">New Arrivals</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-dollar-sign"></i> Current Price (Rs.)</label>
                    <input type="number" name="price" required placeholder="Enter current price" min="0" step="0.01">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-dollar-sign"></i> Old Price (Rs.) - Optional</label>
                    <input type="number" name="old_price" placeholder="Enter old price if on sale" min="0" step="0.01">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-align-left"></i> Description</label>
                    <textarea name="description" rows="3" placeholder="Enter product description"></textarea>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-image"></i> Image URL</label>
                    <input type="url" name="image_url" required placeholder="Enter image URL">
                </div>
                
                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i> Save Product
                </button>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditProductModal()">&times;</span>
            <h2><i class="fas fa-edit"></i> Edit Product</h2>
            <form method="POST" id="editProductForm">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="form-group">
                    <label><i class="fas fa-tag"></i> Product Name</label>
                    <input type="text" name="name" id="edit_name" required placeholder="Enter product name">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-list"></i> Category</label>
                    <select name="category" id="edit_category" required>
                        <option value="">Select Category</option>
                        <option value="flowers">Flowers</option>
                        <option value="gifts">Gift Items</option>
                        <option value="sale">Special Offers</option>
                        <option value="occasion">Occasion Specials</option>
                        <option value="new">New Arrivals</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-dollar-sign"></i> Current Price (Rs.)</label>
                    <input type="number" name="price" id="edit_price" required placeholder="Enter current price" min="0" step="0.01">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-dollar-sign"></i> Old Price (Rs.) - Optional</label>
                    <input type="number" name="old_price" id="edit_old_price" placeholder="Enter old price if on sale" min="0" step="0.01">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-align-left"></i> Description</label>
                    <textarea name="description" id="edit_description" rows="3" placeholder="Enter product description"></textarea>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-image"></i> Image URL</label>
                    <input type="url" name="image_url" id="edit_image_url" required placeholder="Enter image URL">
                </div>
                
                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i> Update Product
                </button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content" style="max-width: 400px; text-align: center;">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <i class="fas fa-exclamation-triangle" style="font-size: 60px; color: #dc3545; margin-bottom: 20px;"></i>
            <h2 style="color: #333; margin-bottom: 15px;">Confirm Delete</h2>
            <p style="color: #666; margin-bottom: 25px; font-size: 16px;">
                Are you sure you want to delete "<span id="deleteProductName"></span>"?
            </p>
            <form method="POST" id="deleteForm" style="display: inline;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="delete_id">
                <button type="button" class="action-btn edit-btn" onclick="closeDeleteModal()" style="margin-right: 10px;">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="action-btn delete-btn">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all content cards
            document.querySelectorAll('.content-card').forEach(card => {
                card.classList.remove('active');
            });
            
            // Remove active class from all sidebar links
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                link.classList.remove('active');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected content
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to clicked sidebar link
            event.currentTarget.classList.add('active');
            
            // Add active class to corresponding tab button
            document.querySelectorAll('.tab-btn').forEach((btn, index) => {
                if((tabName === 'users' && index === 0) ||
                   (tabName === 'messages' && index === 1) ||
                   (tabName === 'products' && index === 2)) {
                    btn.classList.add('active');
                }
            });
        }

        // Add Product Modal
        function openAddProductModal() {
            document.getElementById('addProductModal').style.display = 'flex';
        }

        function closeAddProductModal() {
            document.getElementById('addProductModal').style.display = 'none';
        }

        // Edit Product Modal
        function openEditProductModal(product) {
            document.getElementById('edit_id').value = product.id;
            document.getElementById('edit_name').value = product.name;
            document.getElementById('edit_category').value = product.category;
            document.getElementById('edit_price').value = product.price;
            document.getElementById('edit_old_price').value = product.old_price || '';
            document.getElementById('edit_description').value = product.description || '';
            document.getElementById('edit_image_url').value = product.image_url || '';
            
            document.getElementById('editProductModal').style.display = 'flex';
        }

        function closeEditProductModal() {
            document.getElementById('editProductModal').style.display = 'none';
        }

        // Delete Modal
        function deleteProduct(id, name) {
            document.getElementById('delete_id').value = id;
            document.getElementById('deleteProductName').textContent = name;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const addModal = document.getElementById('addProductModal');
            const editModal = document.getElementById('editProductModal');
            const deleteModal = document.getElementById('deleteModal');
            
            if (event.target === addModal) {
                closeAddProductModal();
            }
            if (event.target === editModal) {
                closeEditProductModal();
            }
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        }
    </script>
</body>
</html>