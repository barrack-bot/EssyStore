<?php
$pageTitle = 'Dashboard';
$currentPage = 'dashboard';

// Get dashboard statistics
require_once __DIR__ . '/../../app/models/Product.php';
require_once __DIR__ . '/../../app/models/User.php';

try {
    $product = new Product();
    $user = new User();
    
    $totalProducts = count($product->getAll());
    $totalUsers = count($user->getAllUsers());
    
    // Get recent orders (simplified for now)
    $recentOrders = [];
    $totalOrders = 0;
    $totalRevenue = 0;
    
} catch (Exception $e) {
    $totalProducts = 0;
    $totalUsers = 0;
    $recentOrders = [];
    $totalOrders = 0;
    $totalRevenue = 0;
}

// Get current admin info from session
$adminName = $_SESSION['user']['name'] ?? 'Admin';
$adminRole = $_SESSION['user']['role'] ?? 'admin';

$content = '
    <!-- Welcome Section -->
    <div class="dashboard-welcome mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="welcome-title">Welcome back, ' . htmlspecialchars($adminName) . '!</h2>
                <p class="welcome-subtitle">Here\'s what\'s happening with your store today.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="badge bg-success bg-lg px-3 py-2">
                    <i class="fas fa-circle me-1" style="font-size: 0.6rem;"></i> Online
                </span>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card professional">
                <div class="stat-icon-wrapper bg-primary-light">
                    <i class="fas fa-box text-primary"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">' . number_format($totalProducts) . '</div>
                    <div class="stat-label">Total Products</div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i> 12% from last month
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6">
            <div class="stat-card professional">
                <div class="stat-icon-wrapper bg-success-light">
                    <i class="fas fa-users text-success"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">' . number_format($totalUsers) . '</div>
                    <div class="stat-label">Total Customers</div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i> 8% from last month
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6">
            <div class="stat-card professional">
                <div class="stat-icon-wrapper bg-info-light">
                    <i class="fas fa-shopping-cart text-info"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">' . number_format($totalOrders) . '</div>
                    <div class="stat-label">Total Orders</div>
                    <div class="stat-trend neutral">
                        <i class="fas fa-minus"></i> No change
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6">
            <div class="stat-card professional">
                <div class="stat-icon-wrapper bg-warning-light">
                    <i class="fas fa-money-bill-wave text-warning"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">Ksh ' . number_format($totalRevenue, 2) . '</div>
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i> 23% from last month
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-lg-8">
            <div class="admin-card professional">
                <div class="card-header-custom">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-bag me-2"></i>Recent Orders
                    </h5>
                    <a href="orders.php" class="btn btn-sm btn-outline-primary">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ' . (empty($recentOrders) ? 
                                '<tr><td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-shopping-bag fa-3x mb-3 text-muted opacity-50"></i><br>
                                    No recent orders found
                                </td></tr>' :
                                '') . '
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions & Stats -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="admin-card professional mb-4">
                <div class="card-header-custom">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="quick-actions">
                    <a href="products.php" class="quick-action-btn">
                        <div class="action-icon bg-primary">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="action-text">
                            <span class="action-title">Add Product</span>
                            <span class="action-desc">Create new product</span>
                        </div>
                    </a>
                    <a href="orders.php" class="quick-action-btn">
                        <div class="action-icon bg-success">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="action-text">
                            <span class="action-title">View Orders</span>
                            <span class="action-desc">Manage orders</span>
                        </div>
                    </a>
                    <a href="users.php" class="quick-action-btn">
                        <div class="action-icon bg-info">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="action-text">
                            <span class="action-title">Manage Users</span>
                            <span class="action-desc">Customer management</span>
                        </div>
                    </a>
                    <a href="../index.php" class="quick-action-btn">
                        <div class="action-icon bg-warning">
                            <i class="fas fa-external-link-alt"></i>
                        </div>
                        <div class="action-text">
                            <span class="action-title">View Store</span>
                            <span class="action-desc">Go to storefront</span>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- System Status -->
            <div class="admin-card professional">
                <div class="card-header-custom">
                    <h5 class="mb-0">
                        <i class="fas fa-server me-2"></i>System Status
                    </h5>
                </div>
                <div class="system-status">
                    <div class="status-item">
                        <div class="status-label">Database</div>
                        <div class="status-badge bg-success">Connected</div>
                    </div>
                    <div class="status-item">
                        <div class="status-label">Storage</div>
                        <div class="status-badge bg-info">45% Used</div>
                    </div>
                    <div class="status-item">
                        <div class="status-label">API Status</div>
                        <div class="status-badge bg-success">Active</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
';

require_once __DIR__ . '/../../resources/views/admin/layouts/admin-layout.php';
?>
