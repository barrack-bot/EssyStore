<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();

require_once __DIR__ . '/../../app/models/Order.php';

try {
    $order = new Order();
    $userId = $_SESSION['user']['id'];
    
    // Get user's orders
    $orders = $order->getByUserId($userId);
    
    // Get order items for each order
    $ordersWithItems = [];
    foreach ($orders as $order) {
        $items = $order->getItems($order['id']);
        $ordersWithItems[] = array_merge($order, ['items' => $items]);
    }
    
    echo json_encode([
        'status' => 'success',
        'orders' => $ordersWithItems
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch orders'
    ]);
}
?>
