<?php
$pageTitle = 'Users Management';
$currentPage = 'users';

$content = '
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Users Management</h2>
        <div class="d-flex gap-2">
            <select class="form-select" id="roleFilter" onchange="filterUsers()">
                <option value="">All Roles</option>
                <option value="admin">Admin</option>
                <option value="customer">Customer</option>
            </select>
        </div>
    </div>
    
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="users-table">
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
    
    <!-- Update Role Modal -->
    <div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update User Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="roleForm">
                        <input type="hidden" id="userId" name="id">
                        <div class="mb-3">
                            <label class="form-label">User</label>
                            <input type="text" class="form-control" id="userName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-control" id="userRole" name="role" required>
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="updateRole()">Update Role</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        let users = [];
        let filteredUsers = [];
        
        // Load users
        async function loadUsers() {
            try {
                const response = await fetch("../../api/admin/users/list.php");
                const data = await response.json();
                
                if (data.status === "success") {
                    users = data.data || [];
                    filteredUsers = [...users];
                    renderUsers();
                }
            } catch (error) {
                console.error("Error loading users:", error);
                showNotification("Error loading users", "error");
            }
        }
        
        function renderUsers() {
            const tbody = document.getElementById("users-table");
            
            if (filteredUsers.length === 0) {
                tbody.innerHTML = "<tr><td colspan=\"6\" class=\"text-center\">No users found</td></tr>";
                return;
            }
            
            tbody.innerHTML = filteredUsers.map(user => `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>
                        <span class="badge bg-${user.role === "admin" ? "danger" : "primary"}">${user.role}</span>
                    </td>
                    <td>${formatDate(user.created_at)}</td>
                    <td>
                        <button class="btn btn-sm btn-warning me-1" onclick="editRole(${user.id}, "${user.name}", "${user.role}")">
                            <i class="fas fa-user-tag"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})" ${user.id === ' . ($_SESSION["user"]["id"] ?? 0) . ' ? "disabled" : ""}>
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join("");
        }
        
        function filterUsers() {
            const role = document.getElementById("roleFilter").value;
            
            if (role === "") {
                filteredUsers = [...users];
            } else {
                filteredUsers = users.filter(user => user.role === role);
            }
            
            renderUsers();
        }
        
        function editRole(id, name, currentRole) {
            document.getElementById("userId").value = id;
            document.getElementById("userName").value = name;
            document.getElementById("userRole").value = currentRole;
            
            const modal = new bootstrap.Modal(document.getElementById("roleModal"));
            modal.show();
        }
        
        async function updateRole() {
            const form = document.getElementById("roleForm");
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            
            try {
                const response = await fetch("../../api/admin/users/update-role.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.status === "success") {
                    showNotification(result.message, "success");
                    bootstrap.Modal.getInstance(document.getElementById("roleModal")).hide();
                    loadUsers();
                } else {
                    showNotification(result.message, "error");
                }
            } catch (error) {
                console.error("Error updating role:", error);
                showNotification("Error updating role", "error");
            }
        }
        
        async function deleteUser(id) {
            if (!confirm("Are you sure you want to delete this user? This action cannot be undone.")) return;
            
            try {
                const response = await fetch("../../api/admin/users/delete.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id: id })
                });
                
                const result = await response.json();
                
                if (result.status === "success") {
                    showNotification(result.message, "success");
                    loadUsers();
                } else {
                    showNotification(result.message, "error");
                }
            } catch (error) {
                console.error("Error deleting user:", error);
                showNotification("Error deleting user", "error");
            }
        }
        
        // Initial load
        loadUsers();
    </script>
';

require_once __DIR__ . '/../../resources/views/admin/layouts/admin-layout.php';
?>
