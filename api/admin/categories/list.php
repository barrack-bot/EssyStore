<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Admin middleware
require_once __DIR__ . '/../../middleware/admin.php';

require_once __DIR__ . '/../../app/models/Category.php';

try {
    $database = new Database();
    $db = $database->connect();
    $category = new Category($db);
    
    $categories = $category->read();
    
    echo json_encode([
        'status' => 'success',
        'data' => $categories
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch categories'
    ]);
}
