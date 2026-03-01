<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    try {
        $stmt = $pdo->prepare("SELECT id, full_name, email, password, is_admin FROM users WHERE email = ? AND is_admin = 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['is_admin'] = true;
            $_SESSION['admin_logged_in'] = true;
            
            header('Location: index.php');
            exit();
        } else {
            $error = "Invalid admin credentials!";
        }
    } catch(PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - GIFY Flower Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            width: 350px;
        }
        .login-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }
        .login-container h2 span {
            color: #e84393;
        }
        .input-group {
            margin-bottom: 20px;
            position: relative;
        }
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        .input-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .input-group input:focus {
            border-color: #e84393;
            outline: none;
            box-shadow: 0 0 10px rgba(232,62,140,0.1);
        }
        .login-btn {
            width: 100%;
            padding: 15px;
            background: #e84393;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .login-btn:hover {
            background: #c13584;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(232,62,140,0.3);
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
        .info {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #666;
        }
        .info i {
            color: #e84393;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link a:hover {
            color: #e84393;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>GIFY<span> Admin</span></h2>
        
        <?php if(isset($error)): ?>
            <div class="error"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Admin Email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="login-btn">Login to Dashboard</button>
        </form>
        
        <div class="info">
            <i class="fas fa-info-circle"></i> Use the same credentials as your website login
        </div>
        
        <div class="back-link">
            <a href="http://localhost/GIFY_shop/gify/home.html"><i class="fas fa-arrow-left"></i> Back to Website</a>
        </div>
    </div>
</body>
</html>