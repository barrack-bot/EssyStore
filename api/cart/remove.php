<?php

header('Content-Type: application/json');
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['product_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Product ID is required'
    ]);
    exit;
}

$product_id = (int)$data['product_id'];

if (isset($_SESSION['cart'][$product_id])) {
    unset($_SESSION['cart'][$product_id]);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Product removed from cart',
        'cart' => $_SESSION['cart']
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Product not found in cart'
    ]);
}
