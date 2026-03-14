<?php

header('Content-Type: application/json');
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['product_id']) || !isset($data['quantity'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Product ID and quantity are required'
    ]);
    exit;
}

$product_id = (int)$data['product_id'];
$quantity = (int)$data['quantity'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = $quantity;
}

echo json_encode([
    'status' => 'success',
    'message' => 'Product added to cart',
    'cart' => $_SESSION['cart']
]);
