<?php
header('Content-Type: application/json');

// Start session for admin check
session_start();

require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/models/Product.php';

try {
    $product = new Product();
    $products = $product->getAll();
    
    echo json_encode(['status' => 'success', 'data' => $products]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch products', 'error' => $e->getMessage()]);
}
