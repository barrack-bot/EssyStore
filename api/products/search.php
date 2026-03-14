<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../../app/models/Product.php';

if (!isset($_GET['term'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Search term is required'
    ]);
    exit;
}

$term = $_GET['term'];

try {
    $product = new Product();
    $products = $product->search($term);
    
    echo json_encode([
        'status' => 'success',
        'products' => $products
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Search failed'
    ]);
}
