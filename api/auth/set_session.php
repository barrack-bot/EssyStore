<?php

header('Content-Type: application/json');

session_start();

try {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    if (isset($data['user'])) {
        $_SESSION['user'] = $data['user'];
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Session set successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No user data provided'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to set session'
    ]);
}
?>
