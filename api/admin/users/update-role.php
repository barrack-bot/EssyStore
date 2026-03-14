<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();

// Check if user is logged in and has admin role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode([
        'status' => 'error',
        'message' => 'Admin access required'
    ]);
    exit;
}

require_once __DIR__ . '/../../../app/models/User.php';

$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (!isset($data['id']) || !isset($data['role'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User ID and role are required'
    ]);
    exit;
}

// Validate role
if (!in_array($data['role'], ['customer', 'admin'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid role. Must be customer or admin'
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
    
    // Prevent changing own role
    if ($data['id'] == $_SESSION['user']['id']) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Cannot change your own role'
        ]);
        exit;
    }
    
    $result = $user->updateUserRole($data['id'], $data['role']);
    
    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'User role updated successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update user role'
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to update user role: ' . $e->getMessage()
    ]);
}
