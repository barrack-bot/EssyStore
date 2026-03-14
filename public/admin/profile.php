<?php
$pageTitle = 'Admin Profile';
$currentPage = 'profile';

// Get current admin user data
$adminUser = $_SESSION['user'] ?? null;

if (!$adminUser || $adminUser['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$content = '
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Admin Profile</h2>
        <div class="btn-group">
            <button class="btn btn-outline-warning" onclick="toggleEditMode()">
                <i class="fas fa-edit me-2"></i>Edit Profile
            </button>
            <button class="btn btn-outline-danger" onclick="showPasswordModal()">
                <i class="fas fa-key me-2"></i>Change Password
            </button>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="admin-card text-center">
                <div class="admin-avatar mb-3">
                    <img src="https://picsum.photos/150/150?random=' . ($adminUser['id'] ?? 1) . '" alt="Admin Avatar" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    <div class="avatar-upload mt-3">
                        <button class="btn btn-sm btn-primary" onclick="document.getElementById(\'avatarInput\').click()">
                            <i class="fas fa-camera me-1"></i>Change Avatar
                        </button>
                        <input type="file" id="avatarInput" accept="image/*" style="display: none;" onchange="handleAvatarUpload(event)">
                    </div>
                </div>
                
                <h4>' . htmlspecialchars($adminUser['name'] ?? 'Admin User') . '</h4>
                <p class="text-muted">Administrator</p>
                
                <div class="admin-stats">
                    <div class="stat-item">
                        <strong>Member Since:</strong><br>
                        ' . date('M d, Y', strtotime($adminUser['created_at'] ?? 'now')) . '
                    </div>
                    <div class="stat-item">
                        <strong>Last Login:</strong><br>
                        ' . date('M d, Y H:i', strtotime($adminUser['last_login'] ?? 'now')) . '
                    </div>
                    <div class="stat-item">
                        <strong>Account Status:</strong><br>
                        <span class="badge bg-success">Active</span>
                    </div>
                </div>
            </div>
            
            <div class="admin-card mt-4">
                <h5 class="mb-4">Admin Privileges</h5>
                <div class="privileges-list">
                    <div class="privilege-item">
                        <i class="fas fa-check text-success me-2"></i>
                        <span>Product Management</span>
                    </div>
                    <div class="privilege-item">
                        <i class="fas fa-check text-success me-2"></i>
                        <span>Order Processing</span>
                    </div>
                    <div class="privilege-item">
                        <i class="fas fa-check text-success me-2"></i>
                        <span>User Management</span>
                    </div>
                    <div class="privilege-item">
                        <i class="fas fa-check text-success me-2"></i>
                        <span>Analytics Access</span>
                    </div>
                    <div class="privilege-item">
                        <i class="fas fa-check text-success me-2"></i>
                        <span>System Settings</span>
                    </div>
                    <div class="privilege-item">
                        <i class="fas fa-check text-success me-2"></i>
                        <span>Database Backup</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="admin-card mb-4">
                <h5 class="mb-4">Personal Information</h5>
                <form id="profileForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="adminName" name="name" value="' . htmlspecialchars($adminUser['name'] ?? '') . '" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="adminEmail" name="email" value="' . htmlspecialchars($adminUser['email'] ?? '') . '" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="adminPhone" name="phone" value="' . htmlspecialchars($adminUser['phone'] ?? '') . '" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <input type="text" class="form-control" id="adminDepartment" name="department" value="' . htmlspecialchars($adminUser['department'] ?? 'Administration') . '" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Bio/Notes</label>
                            <textarea class="form-control" id="adminBio" name="bio" rows="3" readonly>' . htmlspecialchars($adminUser['bio'] ?? '') . '</textarea>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Preferred Language</label>
                            <select class="form-control" id="adminLanguage" name="language" disabled>
                                <option value="en" ' . (($adminUser['language'] ?? 'en') === 'en' ? 'selected' : '') . '>English</option>
                                <option value="es" ' . (($adminUser['language'] ?? '') === 'es' ? 'selected' : '') . '>Spanish</option>
                                <option value="fr" ' . (($adminUser['language'] ?? '') === 'fr' ? 'selected' : '') . '>French</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Timezone</label>
                            <select class="form-control" id="adminTimezone" name="timezone" disabled>
                                <option value="UTC" ' . (($adminUser['timezone'] ?? 'UTC') === 'UTC' ? 'selected' : '') . '>UTC</option>
                                <option value="EST" ' . (($adminUser['timezone'] ?? '') === 'EST' ? 'selected' : '') . '>Eastern Time</option>
                                <option value="PST" ' . (($adminUser['timezone'] ?? '') === 'PST' ? 'selected' : '') . '>Pacific Time</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="admin-card mb-4">
                <h5 class="mb-4">Security Settings</h5>
                <div class="security-settings">
                    <div class="setting-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Two-Factor Authentication</strong>
                                <div class="text-muted small">Add an extra layer of security to your account</div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="twoFactor" onchange="toggleTwoFactor()">
                                <label class="form-check-label" for="twoFactor"></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Email Notifications</strong>
                                <div class="text-muted small">Receive security alerts via email</div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="emailNotifications" checked onchange="toggleEmailNotifications()">
                                <label class="form-check-label" for="emailNotifications"></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="setting-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Login Alerts</strong>
                                <div class="text-muted small">Get notified when someone logs into your account</div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="loginAlerts" checked onchange="toggleLoginAlerts()">
                                <label class="form-check-label" for="loginAlerts"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="admin-card">
                <h5 class="mb-4">Recent Activity</h5>
                <div class="activity-timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon bg-success">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Logged in to admin panel</div>
                            <div class="timeline-time">2 hours ago</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-primary">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Updated product #123</div>
                            <div class="timeline-time">5 hours ago</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-warning">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Created new user account</div>
                            <div class="timeline-time">Yesterday</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-info">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Modified system settings</div>
                            <div class="timeline-time">2 days ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Change Password Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="passwordForm">
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" required>
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" id="passwordStrength" style="width: 0%"></div>
                                </div>
                                <small class="text-muted" id="passwordStrengthText">Enter a password</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="changePassword()">Change Password</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        let editMode = false;
        
        function toggleEditMode() {
            editMode = !editMode;
            const form = document.getElementById("profileForm");
            const inputs = form.querySelectorAll("input, select, textarea");
            
            inputs.forEach(input => {
                if (input.id !== "adminEmail") { // Keep email readonly for security
                    input.readOnly = !editMode;
                    input.disabled = !editMode;
                }
            });
            
            if (editMode) {
                showNotification("Edit mode enabled. Make your changes and save.", "info");
            } else {
                saveProfile();
            }
        }
        
        function saveProfile() {
            const formData = new FormData(document.getElementById("profileForm"));
            const data = Object.fromEntries(formData);
            
            console.log("Saving admin profile:", data);
            showNotification("Profile updated successfully", "success");
            
            // In a real app, this would send data to the server
        }
        
        function showPasswordModal() {
            const modal = new bootstrap.Modal(document.getElementById("passwordModal"));
            modal.show();
        }
        
        function changePassword() {
            const currentPassword = document.getElementById("currentPassword").value;
            const newPassword = document.getElementById("newPassword").value;
            const confirmPassword = document.getElementById("confirmPassword").value;
            
            if (newPassword !== confirmPassword) {
                showNotification("New passwords do not match", "error");
                return;
            }
            
            if (newPassword.length < 8) {
                showNotification("Password must be at least 8 characters long", "error");
                return;
            }
            
            console.log("Changing password");
            showNotification("Password changed successfully", "success");
            
            // Close modal and reset form
            bootstrap.Modal.getInstance(document.getElementById("passwordModal")).hide();
            document.getElementById("passwordForm").reset();
        }
        
        function handleAvatarUpload(event) {
            const file = event.target.files[0];
            if (file) {
                console.log("Uploading avatar:", file.name);
                showNotification("Avatar uploaded successfully", "success");
                // In a real app, this would upload the file to the server
            }
        }
        
        function toggleTwoFactor() {
            const enabled = document.getElementById("twoFactor").checked;
            showNotification(`Two-factor authentication ${enabled ? "enabled" : "disabled"}`, "info");
        }
        
        function toggleEmailNotifications() {
            const enabled = document.getElementById("emailNotifications").checked;
            showNotification(`Email notifications ${enabled ? "enabled" : "disabled"}`, "info");
        }
        
        function toggleLoginAlerts() {
            const enabled = document.getElementById("loginAlerts").checked;
            showNotification(`Login alerts ${enabled ? "enabled" : "disabled"}`, "info");
        }
        
        // Password strength checker
        document.getElementById("newPassword")?.addEventListener("input", function(e) {
            const password = e.target.value;
            let strength = 0;
            let strengthText = "";
            
            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]/)) strength += 25;
            if (password.match(/[A-Z]/)) strength += 25;
            if (password.match(/[0-9]/)) strength += 25;
            
            const strengthBar = document.getElementById("passwordStrength");
            const strengthTextEl = document.getElementById("passwordStrengthText");
            
            if (strengthBar && strengthTextEl) {
                strengthBar.style.width = strength + "%";
                
                if (strength <= 25) {
                    strengthBar.className = "progress-bar bg-danger";
                    strengthText = "Weak password";
                } else if (strength <= 50) {
                    strengthBar.className = "progress-bar bg-warning";
                    strengthText = "Fair password";
                } else if (strength <= 75) {
                    strengthBar.className = "progress-bar bg-info";
                    strengthText = "Good password";
                } else {
                    strengthBar.className = "progress-bar bg-success";
                    strengthText = "Strong password";
                }
                
                strengthTextEl.textContent = strengthText;
            }
        });
    </script>
    
    <style>
        .admin-avatar {
            position: relative;
        }
        
        .admin-stats {
            text-align: left;
            margin-top: 20px;
        }
        
        .admin-stats .stat-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .admin-stats .stat-item:last-child {
            border-bottom: none;
        }
        
        .privileges-list {
            text-align: left;
        }
        
        .privilege-item {
            padding: 8px 0;
            display: flex;
            align-items: center;
        }
        
        .security-settings .setting-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .security-settings .setting-item:last-child {
            border-bottom: none;
        }
        
        .activity-timeline {
            position: relative;
            padding-left: 40px;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }
        
        .timeline-icon {
            position: absolute;
            left: -40px;
            top: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
        }
        
        .timeline-content {
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 5px;
            border-left: 3px solid #007bff;
        }
        
        .timeline-title {
            font-weight: 500;
            margin-bottom: 2px;
        }
        
        .timeline-time {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
';

require_once __DIR__ . '/../../resources/views/admin/layouts/admin-layout.php';
?>
