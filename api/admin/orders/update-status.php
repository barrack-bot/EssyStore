<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Admin middleware
require_once __DIR__ . '/../../middleware/admin.php';

require_once __DIR__ . '/../../app/models/Order.php';

$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (!isset($data['id']) || !isset($data['status'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Order ID and status are required'
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
    
    $result = $order->updateStatus($data['id'], $data['status']);
    
    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Order status updated successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid status value'
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to update order status'
    ]);
}
