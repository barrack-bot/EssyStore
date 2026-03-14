<?php
// Test database connection
header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../app/config/database.php';
    
    $database = new Database();
    $conn = $database->connect();
    
    // Test basic query
    $stmt = $conn->query("SELECT COUNT(*) as count FROM products");
    $result = $stmt->fetch();
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Database connection successful',
        'product_count' => $result['count'],
        'connection_info' => [
            'host' => $database->host,
            'dbname' => $database->dbname,
            'connected' => $conn ? true : false
        ]
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed: ' . $e->getMessage(),
        'error_details' => [
            'file' => __FILE__,
            'line' => $e->getLine(),
            'code' => $e->getCode()
        ]
    ]);
}
?>
