<?php
// Debug script to check API and database connection
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>EssyStore Debug</h1>";

// Test database connection
echo "<h2>Database Connection Test</h2>";
try {
    require_once __DIR__ . '/../app/config/database.php';
    $database = new Database();
    $conn = $database->connect();
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Check if products table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'products'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Products table exists</p>";
        
        // Count products
        $count = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
        echo "<p style='color: green;'>✓ Found $count products in database</p>";
    } else {
        echo "<p style='color: red;'>✗ Products table does not exist</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

// Test API endpoints
echo "<h2>API Endpoint Tests</h2>";

$apiEndpoints = [
    '../api/products/list.php',
    '../api/cart/fetch.php'
];

foreach ($apiEndpoints as $endpoint) {
    echo "<h3>Testing: $endpoint</h3>";
    $fullPath = __DIR__ . '/' . $endpoint;
    if (file_exists($fullPath)) {
        echo "<p style='color: green;'>✓ File exists: $fullPath</p>";
        
        // Try to include and test
        ob_start();
        try {
            include $fullPath;
            $output = ob_get_clean();
            echo "<p style='color: green;'>✓ API executed successfully</p>";
            echo "<pre>" . htmlspecialchars($output) . "</pre>";
        } catch (Exception $e) {
            ob_end_clean();
            echo "<p style='color: red;'>✗ API execution failed: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ File not found: $fullPath</p>";
    }
}

// Check file structure
echo "<h2>File Structure</h2>";
$requiredFiles = [
    '../app/config/database.php',
    '../app/models/Product.php',
    '../api/products/list.php',
    '../api/cart/fetch.php'
];

foreach ($requiredFiles as $file) {
    $fullPath = __DIR__ . '/' . $file;
    if (file_exists($fullPath)) {
        echo "<p style='color: green;'>✓ $file</p>";
    } else {
        echo "<p style='color: red;'>✗ $file (missing)</p>";
    }
}
?>
