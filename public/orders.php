<?php 
session_start();
$currentPage = 'orders'; 

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../resources/views/layouts/main-header.php'; ?>

    <!-- Orders Page -->
    <section class="orders-page">
        <div class="orders-header">
            <h1 class="orders-title">My Orders</h1>
            <p class="orders-subtitle">Track and manage your orders</p>
        </div>
        
        <div class="orders-content">
            <div class="orders-sidebar">
                <div class="orders-nav">
                    <a href="profile.php" class="nav-item">Profile Information</a>
                    <a href="orders.php" class="nav-item active">My Orders</a>
                    <a href="#" class="nav-item">Addresses</a>
                    <a href="#" class="nav-item">Payment Methods</a>
                    <a href="#" class="nav-item">Security Settings</a>
                </div>
            </div>
            
            <div class="orders-main">
                <div class="orders-filters">
                    <div class="filter-group">
                        <label>Status</label>
                        <select id="statusFilter">
                            <option value="">All Orders</option>
                            <option value="pending">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label>Date Range</label>
                        <select id="dateFilter">
                            <option value="">All Time</option>
                            <option value="30">Last 30 days</option>
                            <option value="90">Last 3 months</option>
                            <option value="180">Last 6 months</option>
                            <option value="365">Last year</option>
                        </select>
                    </div>
                </div>
                
                <div class="orders-list" id="ordersList">
                    <!-- Orders will be loaded here -->
                </div>
            </div>
        </div>
    </section>

    <script>
        // Load user orders from API
        async function loadOrders() {
            try {
                const response = await fetch('../api/auth/user-orders.php');
                const data = await response.json();
                
                if (data.status === 'success') {
                    renderOrders(data.orders);
                } else {
                    document.getElementById('ordersList').innerHTML = '<p class="text-center">Failed to load orders</p>';
                }
            } catch (error) {
                console.error('Error loading orders:', error);
                document.getElementById('ordersList').innerHTML = '<p class="text-center">Failed to load orders</p>';
            }
        }

        function renderOrders(orders) {
            const ordersList = document.getElementById('ordersList');
            
            if (orders.length === 0) {
                ordersList.innerHTML = `
                    <div class="empty-orders">
                        <h2>No orders yet</h2>
                        <p>Looks like you haven't placed any orders yet.</p>
                        <a href="shop.php" class="shop-now-btn">Start Shopping</a>
                    </div>
                `;
                return;
            }
            
            ordersList.innerHTML = orders.map(order => `
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Order #ESY${String(order.id).padStart(6, '0')}</h3>
                            <p class="order-date">Placed on ${new Date(order.created_at).toLocaleDateString()}</p>
                        </div>
                        <div class="order-status">
                            <span class="status-badge ${order.status}">${order.status}</span>
                        </div>
                    </div>
                    
                    <div class="order-items">
                        ${order.items.map(item => `
                            <div class="order-item">
                                <img src="${item.product_image || 'https://via.placeholder.com/80x80/e5e7eb/6b7280?text=Product'}" alt="${item.product_name}">
                                <div class="item-details">
                                    <h4>${item.product_name}</h4>
                                    <p>Quantity: ${item.quantity}</p>
                                    <p class="item-price">Ksh ${parseFloat(item.price).toFixed(2)}</p>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    
                    <div class="order-footer">
                        <div class="order-total">
                            <span>Total: Ksh ${parseFloat(order.total_amount).toFixed(2)}</span>
                        </div>
                        <div class="order-actions">
                            <button class="action-btn" onclick="viewOrderDetails(${order.id})">View Details</button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function viewOrderDetails(orderId) {
            // Store order details in localStorage for potential details page
            localStorage.setItem('viewingOrder', orderId);
            // You could redirect to a details page here
            alert(`Order #ESY${String(orderId).padStart(6, '0')} details would be shown here`);
        }

        // Filter orders
        document.getElementById('statusFilter').addEventListener('change', loadOrders);
        document.getElementById('dateFilter').addEventListener('change', loadOrders);

        // Load orders on page load
        loadOrders();
    </script>

    <style>
        /* Orders Page */
        .orders-page {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .orders-header {
            text-align: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #eee;
        }

        .orders-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .orders-subtitle {
            color: var(--gray);
            font-size: 1.1rem;
        }

        .orders-content {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 2rem;
        }

        .orders-sidebar {
            background: var(--light);
            padding: 1.5rem;
            border-radius: 10px;
        }

        .orders-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-item {
            display: block;
            padding: 1rem;
            color: var(--dark);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .nav-item:hover {
            background: var(--primary);
            color: white;
        }

        .nav-item.active {
            background: var(--primary);
            color: white;
        }

        .orders-main {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .orders-filters {
            display: flex;
            gap: 2rem;
            padding: 1.5rem;
            background: var(--light);
            border-radius: 10px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-group label {
            font-weight: 600;
            color: var(--dark);
        }

        .filter-group select {
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            background: white;
        }

        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .order-card {
            background: white;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .order-info h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .order-date {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-badge.delivered {
            background: var(--success);
            color: white;
        }

        .status-badge.processing {
            background: var(--accent);
            color: white;
        }

        .status-badge.shipped {
            background: var(--primary);
            color: white;
        }

        .status-badge.cancelled {
            background: var(--gray);
            color: white;
        }

        .order-items {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .order-item {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .order-item img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-details h4 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .item-details p {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .item-price {
            font-weight: 600;
            color: var(--primary);
        }

        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .order-total {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
        }

        .order-actions {
            display: flex;
            gap: 1rem;
        }

        .action-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .action-btn:hover {
            background: var(--secondary);
        }

        .action-btn.secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .action-btn.secondary:hover {
            background: var(--primary);
            color: white;
        }

        .empty-orders {
            text-align: center;
            padding: 3rem;
            color: var(--gray);
        }

        .empty-orders h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .shop-now-btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 1rem;
            transition: background 0.3s;
        }

        .shop-now-btn:hover {
            background: var(--secondary);
        }

        @media (max-width: 768px) {
            .orders-content {
                grid-template-columns: 1fr;
            }

            .orders-sidebar {
                order: 2;
            }

            .orders-main {
                order: 1;
            }

            .orders-filters {
                flex-direction: column;
                gap: 1rem;
            }

            .order-footer {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .order-actions {
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>

    <script>
        function toggleAuthModal() {
            window.location.href = 'login.php';
        }
    </script>

<?php require_once __DIR__ . '/../resources/views/layouts/main-footer.php'; ?>
