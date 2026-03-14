<?php

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Admin middleware
require_once __DIR__ . '/../../middleware/admin.php';

require_once __DIR__ . '/../../app/models/User.php';
require_once __DIR__ . '/../../app/models/Product.php';

try {
    $user = new User();
    $product = new Product();
    
    $database = new Database();
    $db = $database->connect();
    
    // Get total counts
    $totalUsers = $user->getUserCount();
    $totalProducts = count($product->getAll());
    
    // Get total orders
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM orders");
    $stmt->execute();
    $totalOrders = $stmt->fetch()['count'];
    
    // Get total revenue
    $stmt = $db->prepare("SELECT COALESCE(SUM(total_amount), 0) as total FROM orders WHERE status != 'cancelled'");
    $stmt->execute();
    $totalRevenue = $stmt->fetch()['total'];
    
    // Get recent orders
    $stmt = $db->prepare("
        SELECT o.*, u.name as user_name, u.email as user_email
        FROM orders o
        LEFT JOIN users u ON o.user_id = u.id
        ORDER BY o.created_at DESC
        LIMIT 5
    ");
    $stmt->execute();
    $recentOrders = $stmt->fetchAll();
    
    // Get recent users
    $stmt = $db->prepare("
        SELECT id, name, email, role, created_at
        FROM users
        ORDER BY created_at DESC
        LIMIT 5
    ");
    $stmt->execute();
    $recentUsers = $stmt->fetchAll();
    
    // Get orders by status
    $stmt = $db->prepare("
        SELECT status, COUNT(*) as count
        FROM orders
        GROUP BY status
    ");
    $stmt->execute();
    $ordersByStatus = $stmt->fetchAll();
    
    echo json_encode([
        'status' => 'success',
        'data' => [
            'stats' => [
                'total_users' => $totalUsers,
                'total_products' => $totalProducts,
                'total_orders' => $totalOrders,
                'total_revenue' => number_format($totalRevenue, 2, '.', '')
            ],
            'recent_orders' => $recentOrders,
            'recent_users' => $recentUsers,
            'orders_by_status' => $ordersByStatus
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch dashboard data'
    ]);
}
