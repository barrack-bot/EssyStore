<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../../app/models/Product.php';

if (!isset($_GET['category'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Category is required'
    ]);
    exit;
}

$category = $_GET['category'];

try {
    $product = new Product();
    
    // Get all products and filter by category
    $allProducts = $product->getAll();
    $filteredProducts = [];
    
    foreach ($allProducts as $product) {
        if (strtolower($product['category']) === strtolower($category)) {
            $filteredProducts[] = $product;
        }
    }
    
    echo json_encode([
        'status' => 'success',
        'products' => $filteredProducts
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Category filter failed'
    ]);
}
