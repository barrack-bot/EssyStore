<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Admin middleware
require_once __DIR__ . '/../../middleware/admin.php';

require_once __DIR__ . '/../../app/models/Order.php';

$data = json_decode(file_get_contents('php://input'), true);

// Validate order ID
if (!isset($data['id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Order ID is required'
    ]);
    exit;
}

try {
    $order = new Order();
    
    // Check if order exists
    $existingOrder = $order->find($data['id']);
    if (!$existingOrder) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Order not found'
        ]);
        exit;
    }
    
    $result = $order->delete($data['id']);
    
    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Order deleted successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete order'
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to delete order'
    ]);
}
