<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: /essystore/public/login.php');
    exit;
}
$adminName = $_SESSION['user']['name'] ?? 'Admin';
$adminRole = $_SESSION['user']['role'] ?? 'admin';
$adminEmail = $_SESSION['user']['email'] ?? 'admin@essystore.com';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Admin Dashboard'; ?> - EssyStore Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Admin CSS -->
    <link rel="stylesheet" href="/essystore/public/assets/css/admin.css">
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid px-4">
                <!-- Brand -->
                <a class="navbar-brand" href="/essystore/public/admin/dashboard.php">
                    <div class="brand-wrapper">
                        <div class="brand-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="brand-text">
                            <span class="brand-main">EssyStore</span>
                            <span class="brand-sub">Admin Panel</span>
                        </div>
                    </div>
                </a>
                
                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <i class="fas fa-bars text-white"></i>
                </button>
                
                <!-- Navbar Content -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <!-- Search Bar -->
                    <form class="search-form d-none d-lg-flex mx-4">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search products, orders...">
                        </div>
                    </form>
                    
                    <!-- Right Side -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        <!-- Notifications -->
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link notification-icon" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bell"></i>
                                <span class="notification-badge">3</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end notification-dropdown">
                                <div class="dropdown-header d-flex justify-content-between align-items-center">
                                    <span>Notifications</span>
                                    <a href="#" class="text-muted small">Mark all read</a>
                                </div>
                                <div class="notification-list">
                                    <a href="#" class="dropdown-item notification-item">
                                        <div class="notification-icon-wrapper bg-primary">
                                            <i class="fas fa-shopping-cart text-white"></i>
                                        </div>
                                        <div class="notification-content">
                                            <p class="mb-0">New order received</p>
                                            <small class="text-muted">5 minutes ago</small>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item notification-item">
                                        <div class="notification-icon-wrapper bg-success">
                                            <i class="fas fa-user-plus text-white"></i>
                                        </div>
                                        <div class="notification-content">
                                            <p class="mb-0">New customer registered</p>
                                            <small class="text-muted">1 hour ago</small>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item notification-item">
                                        <div class="notification-icon-wrapper bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                        <div class="notification-content">
                                            <p class="mb-0">Low stock alert</p>
                                            <small class="text-muted">2 hours ago</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-footer text-center">
                                    <a href="#" class="text-primary">View all notifications</a>
                                </div>
                            </div>
                        </li>
                        
                        <!-- User Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link user-dropdown" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <div class="user-avatar">
                                    <span><?php echo strtoupper(substr($adminName, 0, 1)); ?></span>
                                </div>
                                <div class="user-info d-none d-md-block">
                                    <span class="user-name"><?php echo htmlspecialchars($adminName); ?></span>
                                    <span class="user-role"><?php echo ucfirst($adminRole); ?></span>
                                </div>
                                <i class="fas fa-chevron-down ms-2 d-none d-md-block"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end user-menu">
                                <div class="user-menu-header">
                                    <div class="user-avatar-lg">
                                        <span><?php echo strtoupper(substr($adminName, 0, 1)); ?></span>
                                    </div>
                                    <div class="user-details">
                                        <h6 class="mb-0"><?php echo htmlspecialchars($adminName); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($adminEmail); ?></small>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/essystore/public/profile.php">
                                    <i class="fas fa-user me-2"></i>My Profile
                                </a>
                                <a class="dropdown-item" href="/essystore/public/admin/settings.php">
                                    <i class="fas fa-cog me-2"></i>Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item logout-item" href="#" onclick="handleLogout()">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <script>
        function handleLogout() {
            fetch('/essystore/api/auth/logout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    window.location.href = '/essystore/public/login.php';
                }
            })
            .catch(error => {
                console.error('Logout error:', error);
                window.location.href = '/essystore/public/login.php';
            });
        }
    </script>
