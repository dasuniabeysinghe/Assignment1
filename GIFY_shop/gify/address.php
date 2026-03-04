<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

switch ($action) {
    case 'get':
        try {
            $stmt = $pdo->prepare("SELECT * FROM addresses WHERE user_id = ? ORDER BY is_default DESC, id DESC");
            $stmt->execute([$userId]);
            $addresses = $stmt->fetchAll();
            echo json_encode(['success' => true, 'addresses' => $addresses]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Failed to load addresses']);
        }
        break;
        
    case 'add':
        $address_line = $_POST['address_line'] ?? '';
        $building_name = $_POST['building_name'] ?? '';
        $faculty = $_POST['faculty'] ?? '';
        $is_default = isset($_POST['is_default']) ? 1 : 0;
        
        if (empty($address_line) || empty($building_name) || empty($faculty)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required']);
            exit;
        }
        
        try {
            if ($is_default) {
                $pdo->prepare("UPDATE addresses SET is_default = 0 WHERE user_id = ?")->execute([$userId]);
            }
            
            $stmt = $pdo->prepare("INSERT INTO addresses (user_id, address_line, building_name, faculty, is_default) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$userId, $address_line, $building_name, $faculty, $is_default]);
            
            echo json_encode(['success' => true, 'message' => 'Address added successfully']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Failed to add address']);
        }
        break;
        
    case 'delete':
        $id = $_POST['id'] ?? 0;
        
        try {
            $stmt = $pdo->prepare("DELETE FROM addresses WHERE id = ? AND user_id = ?");
            $stmt->execute([$id, $userId]);
            echo json_encode(['success' => true, 'message' => 'Address deleted']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Failed to delete address']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>
