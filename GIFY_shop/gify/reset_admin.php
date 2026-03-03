<?php
require_once 'config/database.php';

$email = 'Admin@Gify.Com';
$password = '123456'; 

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    $user = $check->fetch();
    
    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET password = ?, is_admin = 1 WHERE email = ?");
        $stmt->execute([$hashed_password, $email]);
        echo "✓ Admin user updated successfully!<br>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, is_admin) VALUES (?, ?, ?, 1)");
        $stmt->execute(['Admin', $email, $hashed_password]);
        echo "✓ Admin user created successfully!<br>";
    }
    
    echo "Email: " . $email . "<br>";
    echo "Password: " . $password . "<br>";
    echo "Hash: " . $hashed_password . "<br>";
    
    echo "<br>Testing verification: ";
    if (password_verify($password, $hashed_password)) {
        echo "<span style='color:green'>✓ Hash works correctly</span>";
    } else {
        echo "<span style='color:red'>✗ Hash verification failed</span>";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>