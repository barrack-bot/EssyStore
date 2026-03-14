<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Admin middleware
require_once __DIR__ . '/../../middleware/admin.php';

require_once __DIR__ . '/../../app/models/Order.php';

// Get order ID from query parameter
$orderId = $_GET['id'] ?? null;

if (!$orderId) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Order ID is required'
    ]);
    exit;
}

try {
    $order = new Order();
    $orderData = $order->find($orderId);
    
    if (!$orderData) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Order not found'
        ]);
        exit;
    }
    
    // Get order items
    $items = $order->getItems($orderId);
    
    echo json_encode([
        'status' => 'success',
        'data' => [
            'order' => $orderData,
            'items' => $items
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch order details'
    ]);
}
