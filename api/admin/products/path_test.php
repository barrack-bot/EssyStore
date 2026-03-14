<?php

echo "API Path Test\n";
echo "Current directory: " . __DIR__ . "\n";
echo "File exists: " . (file_exists(__DIR__ . '/list.php') ? 'YES' : 'NO') . "\n";
echo "Expected path to Product model: " . __DIR__ . '/../../../app/models/Product.php' . "\n";
echo "Product model exists: " . (file_exists(__DIR__ . '/../../../app/models/Product.php') ? 'YES' : 'NO') . "\n";

// Test database connection
try {
    require_once __DIR__ . '/../../../app/models/Product.php';
    $product = new Product();
    echo "Database connection: SUCCESS\n";
    echo "Products in database: " . count($product->getAll()) . "\n";
} catch (Exception $e) {
    echo "Database connection error: " . $e->getMessage() . "\n";
}
?>
