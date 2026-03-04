<?php
// Update admin email to lowercase
require_once 'config/database.php';

try {
    // Update admin user email to lowercase
    $stmt = $pdo->prepare("UPDATE users SET email = LOWER(email) WHERE is_admin = 1");
    $stmt->execute();
    
    $rowsAffected = $stmt->rowCount();
    echo "SUCCESS! Updated $rowsAffected admin user email(s) to lowercase.\n";
    echo "All admin emails are now in lowercase format.\n";
    echo "\nYou can now delete this file: fix_admin_email.php\n";
    
} catch(PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
