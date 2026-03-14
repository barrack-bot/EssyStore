<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Enable output buffering
ob_start();

// Admin middleware
require_once __DIR__ . '/../../middleware/admin.php';

require_once __DIR__ . '/../../app/models/Category.php';

$data = json_decode(file_get_contents('php://input'), true);

// Validate category ID
if (!isset($data['id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Category ID is required'
    ]);
    exit;
}

try {
    $database = new Database();
    $db = $database->connect();
    $category = new Category($db);
    
    if ($category->delete($data['id'])) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete category'
        ]);
    }
    
} catch (Exception $e) {
    error_log("Category delete error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to delete category'
    ]);
}
