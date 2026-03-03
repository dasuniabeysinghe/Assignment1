<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

// This file handles broadcasting product updates to all connected clients
// It writes a timestamp file that the frontend checks

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    if ($action === 'notify_update') {
        // Broadcast that products were updated
        $update_file = '../product-update-timestamp.txt';
        file_put_contents($update_file, time());
        
        echo json_encode(['success' => true, 'message' => 'Update broadcast sent']);
    } 
    else if ($action === 'check_update') {
        // Frontend checks this to see if products were updated
        $update_file = '../product-update-timestamp.txt';
        
        if (file_exists($update_file)) {
            $last_update = file_get_contents($update_file);
            $client_last_update = $_GET['last_update'] ?? 0;
            
            if ($last_update > $client_last_update) {
                echo json_encode([
                    'success' => true,
                    'updated' => true,
                    'timestamp' => (int)$last_update
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'updated' => false,
                    'timestamp' => (int)$last_update
                ]);
            }
        } else {
            echo json_encode([
                'success' => true,
                'updated' => false,
                'timestamp' => 0
            ]);
        }
    }
    else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
