<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../../app/models/Product.php';

try {
    $product = new Product();
    $products = $product->getAll();
    
    echo json_encode([
        'status' => 'success',
        'products' => $products
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch products'
    ]);
}
