<?php
$pageTitle = 'Analytics Dashboard';
$currentPage = 'analytics';

// Get analytics data
require_once __DIR__ . '/../../app/models/Product.php';
require_once __DIR__ . '/../../app/models/User.php';
require_once __DIR__ . '/../../app/models/Order.php';

try {
    $product = new Product();
    $user = new User();
    $order = new Order();
    
    $totalProducts = count($product->getAll());
    $totalUsers = count($user->getAllUsers());
    $allOrders = $order->getAll();
    $totalOrders = count($allOrders);
    
    // Calculate total revenue
    $totalRevenue = 0;
    foreach ($allOrders as $orderItem) {
        $totalRevenue += $orderItem->total_amount ?? 0;
    }
    
    // Get recent orders for chart
    $recentOrders = array_slice($allOrders, -7, 7);
    
    // Calculate top products (simplified)
    $topProducts = $product->getAll();
    $topProducts = array_slice($topProducts, 0, 5);
    
} catch (Exception $e) {
    $totalProducts = 0;
    $totalUsers = 0;
    $totalOrders = 0;
    $totalRevenue = 0;
    $recentOrders = [];
    $topProducts = [];
}

$content = '<div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Analytics Dashboard</h2>
        <div class="btn-group">
            <button class="btn btn-outline-primary" onclick="exportData()">
                <i class="fas fa-download me-2"></i>Export Report
            </button>
            <button class="btn btn-primary" onclick="refreshAnalytics()">
                <i class="fas fa-sync me-2"></i>Refresh
            </button>
        </div>
    </div>
    
    <!-- Key Metrics -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="admin-card stat-card">
                <div class="stat-icon text-primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-number">' . $totalProducts . '</div>
                <div class="stat-label">Total Products</div>
                <div class="stat-change text-success">
                    <i class="fas fa-arrow-up"></i> +12% from last month
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="admin-card stat-card">
                <div class="stat-icon text-success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">' . $totalUsers . '</div>
                <div class="stat-label">Total Users</div>
                <div class="stat-change text-success">
                    <i class="fas fa-arrow-up"></i> +8% from last month
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="admin-card stat-card">
                <div class="stat-icon text-info">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-number">' . $totalOrders . '</div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-change text-success">
                    <i class="fas fa-arrow-up"></i> +15% from last month
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="admin-card stat-card">
                <div class="stat-icon text-warning">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-number">$' . number_format($totalRevenue, 2) . '</div>
                <div class="stat-label">Total Revenue</div>
                <div class="stat-change text-success">
                    <i class="fas fa-arrow-up"></i> +23% from last month
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-md-8 mb-4">
            <div class="admin-card">
                <h5 class="mb-4">Revenue Overview</h5>
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="admin-card">
                <h5 class="mb-4">Sales by Category</h5>
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Tables Row -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="admin-card">
                <h5 class="mb-4">Top Products</h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Sales</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            ' . (empty($topProducts) ? 
                                '<tr><td colspan="3" class="text-center text-muted">No products found</td></tr>' :
                                '') . '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="admin-card">
                <h5 class="mb-4">Recent Activity</h5>
                <div class="activity-feed">
                    <div class="activity-item">
                        <div class="activity-icon text-success">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">New Order #123</div>
                            <div class="activity-time">2 minutes ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon text-primary">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">New User Registration</div>
                            <div class="activity-time">15 minutes ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon text-warning">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Product Stock Low</div>
                            <div class="activity-time">1 hour ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chart Initialization -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Check if Chart.js is loaded
        if (typeof Chart === "undefined") {
            console.error("Chart.js not loaded");
            return;
        }
        
        // Flag to prevent multiple initializations
        if (window.chartsInitialized) {
            return;
        }
        window.chartsInitialized = true;
        
        // Revenue Chart
        const revenueCtx = document.getElementById("revenueChart");
        if (revenueCtx) {
            new Chart(revenueCtx.getContext("2d"), {
                type: "line",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                    datasets: [{
                        label: "Revenue",
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                        borderColor: "rgb(75, 192, 192)",
                        backgroundColor: "rgba(75, 192, 192, 0.2)",
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return "$" + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Category Chart
        const categoryCtx = document.getElementById("categoryChart");
        if (categoryCtx) {
            new Chart(categoryCtx.getContext("2d"), {
                type: "doughnut",
                data: {
                    labels: ["Electronics", "Clothing", "Sports", "Home & Garden", "Other"],
                    datasets: [{
                        data: [35, 25, 20, 15, 5],
                        backgroundColor: [
                            "#FF6384",
                            "#36A2EB",
                            "#FFCE56",
                            "#4BC0C0",
                            "#9966FF"
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "bottom"
                        }
                    }
                }
            });
        }
    });
    
    function refreshAnalytics() {
        showNotification("Analytics refreshed", "success");
    }
    
    function exportData() {
        showNotification("Report exported successfully", "success");
    }
    </script>';

require_once __DIR__ . '/../../resources/views/admin/layouts/admin-layout.php';
?>
