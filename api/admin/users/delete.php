<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Admin middleware
require_once __DIR__ . '/../../middleware/admin.php';

require_once __DIR__ . '/../../app/models/User.php';

$data = json_decode(file_get_contents('php://input'), true);

// Validate user ID
if (!isset($data['id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User ID is required'
    ]);
    exit;
}

try {
    $user = new User();
    
    // Check if user exists
    $existingUser = $user->findById($data['id']);
    if (!$existingUser) {
        echo json_encode([
            'status' => 'error',
            'message' => 'User not found'
        ]);
        exit;
    }
    
    // Prevent deleting yourself
    if ($data['id'] == $_SESSION['user']['id']) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Cannot delete your own account'
        ]);
        exit;
    }
    
    $result = $user->deleteUser($data['id']);
    
    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete user'
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to delete user'
    ]);
}
