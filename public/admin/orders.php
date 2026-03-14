<?php
$pageTitle = 'Orders Management';
$currentPage = 'orders';

$content = '
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Orders Management</h2>
        <div class="d-flex gap-2">
            <select class="form-select" id="statusFilter" onchange="filterOrders()">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>
    
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="orders-table">
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Order Details Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="orderDetails">
                        <!-- Order details will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        let orders = [];
        let filteredOrders = [];
        
        // Load orders
        async function loadOrders() {
            try {
                const response = await fetch("../../api/admin/orders/list.php");
                const data = await response.json();
                
                if (data.status === "success") {
                    orders = data.data || [];
                    filteredOrders = [...orders];
                    renderOrders();
                }
            } catch (error) {
                console.error("Error loading orders:", error);
                showNotification("Error loading orders", "error");
            }
        }
        
        function renderOrders() {
            const tbody = document.getElementById("orders-table");
            
            if (filteredOrders.length === 0) {
                tbody.innerHTML = "<tr><td colspan=\"6\" class=\"text-center\">No orders found</td></tr>";
                return;
            }
            
            tbody.innerHTML = filteredOrders.map(order => `
                <tr>
                    <td>#${order.id}</td>
                    <td>${order.customer_name || "Customer " + order.user_id}</td>
                    <td>${formatDate(order.created_at)}</td>
                    <td>$${parseFloat(order.total || 0).toFixed(2)}</td>
                    <td>
                        <span class="badge bg-${getStatusColor(order.status)}">${order.status || "pending"}</span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary me-1" onclick="viewOrder(${order.id})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-success me-1" onclick="updateOrderStatus(${order.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteOrder(${order.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join("");
        }
        
        function getStatusColor(status) {
            const colors = {
                "pending": "warning",
                "processing": "info",
                "shipped": "primary",
                "delivered": "success",
                "cancelled": "danger"
            };
            return colors[status] || "secondary";
        }
        
        function filterOrders() {
            const status = document.getElementById("statusFilter").value;
            
            if (status === "") {
                filteredOrders = [...orders];
            } else {
                filteredOrders = orders.filter(order => 
                    (order.status || "pending") === status
                );
            }
            
            renderOrders();
        }
        
        async function viewOrder(id) {
            try {
                const response = await fetch(`../../api/admin/orders/view.php?id=${id}`);
                const data = await response.json();
                
                if (data.status === "success") {
                    const order = data.data;
                    const items = order.items || [];
                    
                    document.getElementById("orderDetails").innerHTML = `
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Order ID:</strong> #${order.id}<br>
                                <strong>Date:</strong> ${formatDate(order.created_at)}<br>
                                <strong>Status:</strong> <span class="badge bg-${getStatusColor(order.status)}">${order.status || "pending"}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Customer:</strong> ${order.customer_name || "Customer " + order.user_id}<br>
                                <strong>Email:</strong> ${order.customer_email || "N/A"}<br>
                                <strong>Total:</strong> $${parseFloat(order.total || 0).toFixed(2)}
                            </div>
                        </div>
                        
                        <h6 class="mb-3">Order Items</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${items.length > 0 ? items.map(item => `
                                        <tr>
                                            <td>${item.name}</td>
                                            <td>$${parseFloat(item.price).toFixed(2)}</td>
                                            <td>${item.quantity}</td>
                                            <td>$${parseFloat(item.price * item.quantity).toFixed(2)}</td>
                                        </tr>
                                    `).join("") : "<tr><td colspan=\"4\" class=\"text-center\">No items found</td></tr>"}
                                </tbody>
                            </table>
                        </div>
                    `;
                    
                    const modal = new bootstrap.Modal(document.getElementById("orderModal"));
                    modal.show();
                } else {
                    showNotification(data.message, "error");
                }
            } catch (error) {
                console.error("Error viewing order:", error);
                showNotification("Error viewing order", "error");
            }
        }
        
        async function updateOrderStatus(id) {
            const newStatus = prompt("Enter new status (pending, processing, shipped, delivered, cancelled):");
            if (!newStatus) return;
            
            const validStatuses = ["pending", "processing", "shipped", "delivered", "cancelled"];
            if (!validStatuses.includes(newStatus)) {
                showNotification("Invalid status", "error");
                return;
            }
            
            try {
                const response = await fetch("../../api/admin/orders/update-status.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id: id, status: newStatus })
                });
                
                const result = await response.json();
                
                if (result.status === "success") {
                    showNotification(result.message, "success");
                    loadOrders();
                } else {
                    showNotification(result.message, "error");
                }
            } catch (error) {
                console.error("Error updating order:", error);
                showNotification("Error updating order", "error");
            }
        }
        
        async function deleteOrder(id) {
            if (!confirm("Are you sure you want to delete this order?")) return;
            
            try {
                const response = await fetch("../../api/admin/orders/delete.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id: id })
                });
                
                const result = await response.json();
                
                if (result.status === "success") {
                    showNotification(result.message, "success");
                    loadOrders();
                } else {
                    showNotification(result.message, "error");
                }
            } catch (error) {
                console.error("Error deleting order:", error);
                showNotification("Error deleting order", "error");
            }
        }
        
        // Initial load
        loadOrders();
    </script>
';

require_once __DIR__ . '/../../resources/views/admin/layouts/admin-layout.php';
?>
