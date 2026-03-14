<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();

// Check if user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'You must be logged in to update your profile'
    ]);
    exit;
}

require_once __DIR__ . '/../../app/models/User.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name']) || !isset($data['email'])) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Name and email are required'
    ]);
    exit;
}

// Validate email format
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid email format'
    ]);
    exit;
}

try {
    $user = new User();
    $userId = $_SESSION['user']['id'];
    
    // Update user in database
    $result = $user->update($userId, $data);
    
    if ($result) {
        // Update session with all provided data
        $_SESSION['user']['name'] = $data['name'];
        $_SESSION['user']['email'] = $data['email'];
        
        // Update optional fields if provided
        if (isset($data['last_name'])) {
            $_SESSION['user']['last_name'] = $data['last_name'];
        }
        if (isset($data['phone'])) {
            $_SESSION['user']['phone'] = $data['phone'];
        }
        if (isset($data['date_of_birth'])) {
            $_SESSION['user']['date_of_birth'] = $data['date_of_birth'];
        }
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => [
                'name' => $data['name'],
                'email' => $data['email'],
                'last_name' => $data['last_name'] ?? '',
                'phone' => $data['phone'] ?? '',
                'date_of_birth' => $data['date_of_birth'] ?? ''
            ]
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update profile'
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to update profile: ' . $e->getMessage()
    ]);
}
?>
