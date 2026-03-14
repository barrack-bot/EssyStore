<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../../app/models/Product.php';

if (!isset($_GET['id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Product ID is required'
    ]);
    exit;
}

$product_id = (int)$_GET['id'];

try {
    $product = new Product();
    $productData = $product->find($product_id);
    
    if ($productData) {
        echo json_encode([
            'status' => 'success',
            'product' => $productData
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Product not found'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch product'
    ]);
}
