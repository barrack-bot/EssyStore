<?php

header('Content-Type: application/json');
session_start();

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

echo json_encode([
    'status' => 'success',
    'cart' => $cart,
    'item_count' => array_sum($cart)
]);
