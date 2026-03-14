<?php
header('Content-Type: application/json');
error_reporting(0);

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Admin access required']);
    exit;
}

require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/models/Product.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name']) || !isset($data['price'])) {
    echo json_encode(['status' => 'error', 'message' => 'Product name and price are required']);
    exit;
}

try {
    $product = new Product();
    
    $productData = [
        'name' => $data['name'],
        'description' => $data['description'] ?? '',
        'price' => $data['price'],
        'category' => $data['category'] ?? 'Uncategorized',
        'image' => $data['image'] ?? 'https://via.placeholder.com/400x300?text=No+Image',
        'stock_quantity' => (int)($data['stock_quantity'] ?? 0)
    ];
    
    $productId = $product->create($productData);
    
    if ($productId) {
        echo json_encode(['status' => 'success', 'message' => 'Product created successfully', 'product_id' => $productId]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to create product']);
    }
} catch (Exception $e) {
    error_log("Product create error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to create product']);
}
