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
    
    // Check if category exists
    $existingCategory = $category->find($data['id']);
    if (!$existingCategory) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Category not found'
        ]);
        exit;
    }
    
    // Prepare update data
    $categoryData = [];
    
    if (isset($data['name'])) {
        $categoryData['name'] = $data['name'];
    }
    if (isset($data['description'])) {
        $categoryData['description'] = $data['description'];
    }
    
    if (empty($categoryData)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'No data to update'
        ]);
        exit;
    }
    
    $result = $category->update($data['id'], $categoryData);
    
    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Category updated successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update category'
        ]);
    }
    
} catch (Exception $e) {
    error_log("Category update error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to update category'
    ]);
}
