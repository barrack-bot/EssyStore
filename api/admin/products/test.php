<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

echo "Session data: " . json_encode($_SESSION) . "\n";

if (!isset($_SESSION['user'])) {
    echo "User not logged in\n";
    exit;
}

if ($_SESSION['user']['role'] !== 'admin') {
    echo "User role: " . $_SESSION['user']['role'] . " (not admin)\n";
    exit;
}

echo "User is admin: " . $_SESSION['user']['name'] . "\n";

require_once __DIR__ . '/../../../app/models/Product.php';

try {
    $product = new Product();
    $products = $product->getAll();
    
    echo "Products found: " . count($products) . "\n";
    
    echo json_encode([
        'status' => 'success',
        'data' => $products
    ]);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch products: ' . $e->getMessage()
    ]);
}
?>
