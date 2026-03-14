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

if (!isset($data['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Product ID is required']);
    exit;
}

try {
    $product = new Product();
    
    $existingProduct = $product->find($data['id']);
    if (!$existingProduct) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        exit;
    }
    
    $productData = [];
    
    if (isset($data['name'])) $productData['name'] = $data['name'];
    if (isset($data['description'])) $productData['description'] = $data['description'];
    if (isset($data['price'])) $productData['price'] = $data['price'];
    if (isset($data['category'])) $productData['category'] = $data['category'];
    if (isset($data['image'])) $productData['image'] = $data['image'];
    if (isset($data['stock_quantity'])) $productData['stock_quantity'] = (int)$data['stock_quantity'];
    
    if (empty($productData)) {
        echo json_encode(['status' => 'error', 'message' => 'No data to update']);
        exit;
    }
    
    $result = $product->update($data['id'], $productData);
    
    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Product updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update product']);
    }
} catch (Exception $e) {
    error_log("Product update error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to update product']);
}
