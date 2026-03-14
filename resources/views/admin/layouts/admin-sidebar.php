<!-- Admin Sidebar -->
<aside class="admin-sidebar">
    <div class="sidebar-content">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <div class="admin-profile">
                <div class="profile-avatar">
                    <span><?php echo strtoupper(substr($_SESSION['user']['name'] ?? 'A', 0, 1)); ?></span>
                </div>
                <div class="profile-info">
                    <h6 class="profile-name"><?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Admin'); ?></h6>
                    <span class="profile-role">Administrator</span>
                </div>
            </div>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="sidebar-nav-main">
            <div class="nav-section">
                <span class="nav-section-title">Main</span>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>" href="/essystore/public/admin/dashboard.php">
                            <span class="nav-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </span>
                            <span class="nav-text">Dashboard</span>
                            <span class="nav-badge">New</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="nav-section">
                <span class="nav-section-title">Commerce</span>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'products') ? 'active' : ''; ?>" href="/essystore/public/admin/products.php">
                            <span class="nav-icon">
                                <i class="fas fa-box"></i>
                            </span>
                            <span class="nav-text">Products</span>
                            <span class="nav-count"><?php echo isset($totalProducts) ? $totalProducts : '0'; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'orders') ? 'active' : ''; ?>" href="/essystore/public/admin/orders.php">
                            <span class="nav-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </span>
                            <span class="nav-text">Orders</span>
                            <span class="nav-count">12</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'users') ? 'active' : ''; ?>" href="/essystore/public/admin/users.php">
                            <span class="nav-icon">
                                <i class="fas fa-users"></i>
                            </span>
                            <span class="nav-text">Customers</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="nav-section">
                <span class="nav-section-title">Analytics</span>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'analytics') ? 'active' : ''; ?>" href="/essystore/public/admin/analytics.php">
                            <span class="nav-icon">
                                <i class="fas fa-chart-line"></i>
                            </span>
                            <span class="nav-text">Analytics</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'reports') ? 'active' : ''; ?>" href="/essystore/public/admin/reports.php">
                            <span class="nav-icon">
                                <i class="fas fa-chart-bar"></i>
                            </span>
                            <span class="nav-text">Reports</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="nav-section">
                <span class="nav-section-title">Account</span>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'profile') ? 'active' : ''; ?>" href="/essystore/public/admin/profile.php">
                            <span class="nav-icon">
                                <i class="fas fa-user-cog"></i>
                            </span>
                            <span class="nav-text">My Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'settings') ? 'active' : ''; ?>" href="/essystore/public/admin/settings.php">
                            <span class="nav-icon">
                                <i class="fas fa-cog"></i>
                            </span>
                            <span class="nav-text">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <a href="/essystore/public/index.php" class="view-store-btn" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                <span>View Store</span>
            </a>
            <div class="sidebar-version">
                <span class="text-muted">Version 1.0.0</span>
            </div>
        </div>
    </div>
</aside>
