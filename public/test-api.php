<?php
// Test API directly
header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../app/models/Product.php';
    
    $product = new Product();
    $products = $product->getAll();
    
    echo json_encode([
        'status' => 'success',
        'products' => $products,
        'count' => count($products),
        'debug' => 'API working correctly'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'debug' => 'API failed: ' . $e->getMessage()
    ]);
}
?>
