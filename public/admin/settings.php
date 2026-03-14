<?php
$pageTitle = 'Settings';
$currentPage = 'settings';

// Get current settings (simplified for demo)
$settings = [
    'site_name' => 'EssyStore',
    'site_email' => 'admin@essystore.com',
    'site_phone' => '+1 234 567 8900',
    'site_address' => '123 Main St, City, State 12345',
    'currency' => 'USD',
    'tax_rate' => '8.5',
    'shipping_cost' => '10.00',
    'enable_notifications' => '1',
    'maintenance_mode' => '0'
];

$content = '
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Settings</h2>
        <div class="btn-group">
            <button class="btn btn-outline-secondary" onclick="resetSettings()">
                <i class="fas fa-undo me-2"></i>Reset to Defaults
            </button>
            <button class="btn btn-primary" onclick="saveSettings()">
                <i class="fas fa-save me-2"></i>Save Changes
            </button>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="admin-card mb-4">
                <h5 class="mb-4">General Settings</h5>
                <form id="settingsForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Site Name</label>
                            <input type="text" class="form-control" name="site_name" value="' . htmlspecialchars($settings['site_name']) . '" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Site Email</label>
                            <input type="email" class="form-control" name="site_email" value="' . htmlspecialchars($settings['site_email']) . '" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="site_phone" value="' . htmlspecialchars($settings['site_phone']) . '">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="site_address" value="' . htmlspecialchars($settings['site_address']) . '">
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="admin-card mb-4">
                <h5 class="mb-4">Payment & Shipping</h5>
                <form id="paymentForm">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Currency</label>
                            <select class="form-control" name="currency">
                                <option value="USD" ' . ($settings['currency'] === 'USD' ? 'selected' : '') . '>USD ($)</option>
                                <option value="EUR" ' . ($settings['currency'] === 'EUR' ? 'selected' : '') . '>EUR (€)</option>
                                <option value="GBP" ' . ($settings['currency'] === 'GBP' ? 'selected' : '') . '>GBP (£)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tax Rate (%)</label>
                            <input type="number" step="0.1" class="form-control" name="tax_rate" value="' . htmlspecialchars($settings['tax_rate']) . '" min="0" max="100">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Shipping Cost</label>
                            <input type="number" step="0.01" class="form-control" name="shipping_cost" value="' . htmlspecialchars($settings['shipping_cost']) . '" min="0">
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="admin-card mb-4">
                <h5 class="mb-4">System Settings</h5>
                <form id="systemForm">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="enable_notifications" id="enableNotifications" ' . ($settings['enable_notifications'] ? 'checked' : '') . '>
                                <label class="form-check-label" for="enableNotifications">
                                    Enable Email Notifications
                                </label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenanceMode" ' . ($settings['maintenance_mode'] ? 'checked' : '') . '>
                                <label class="form-check-label" for="maintenanceMode">
                                    Maintenance Mode
                                    <small class="text-muted d-block">Site will be temporarily unavailable for users</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="admin-card mb-4">
                <h5 class="mb-4">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary" onclick="backupDatabase()">
                        <i class="fas fa-database me-2"></i>Backup Database
                    </button>
                    <button class="btn btn-outline-info" onclick="clearCache()">
                        <i class="fas fa-broom me-2"></i>Clear Cache
                    </button>
                    <button class="btn btn-outline-warning" onclick="testEmail()">
                        <i class="fas fa-envelope me-2"></i>Test Email
                    </button>
                    <button class="btn btn-outline-success" onclick="viewLogs()">
                        <i class="fas fa-file-alt me-2"></i>View Logs
                    </button>
                </div>
            </div>
            
            <div class="admin-card mb-4">
                <h5 class="mb-4">System Information</h5>
                <div class="system-info">
                    <div class="info-item">
                        <strong>PHP Version:</strong> ' . PHP_VERSION . '
                    </div>
                    <div class="info-item">
                        <strong>Server:</strong> ' . $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' . '
                    </div>
                    <div class="info-item">
                        <strong>Database:</strong> MySQL
                    </div>
                    <div class="info-item">
                        <strong>Memory Limit:</strong> ' . ini_get('memory_limit') . '
                    </div>
                    <div class="info-item">
                        <strong>Upload Max Size:</strong> ' . ini_get('upload_max_filesize') . '
                    </div>
                </div>
            </div>
            
            <div class="admin-card">
                <h5 class="mb-4">Storage Usage</h5>
                <div class="storage-info">
                    <div class="storage-item">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Database</span>
                            <span>45 MB</span>
                        </div>
                        <div class="progress mb-3">
                            <div class="progress-bar" style="width: 45%"></div>
                        </div>
                    </div>
                    <div class="storage-item">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Images</span>
                            <span>120 MB</span>
                        </div>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                    </div>
                    <div class="storage-item">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Logs</span>
                            <span>8 MB</span>
                        </div>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-warning" style="width: 4%"></div>
                        </div>
                    </div>
                    <div class="storage-item">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Used</span>
                            <span>173 MB / 500 MB</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width: 34.6%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function saveSettings() {
            // Collect all form data
            const formData = new FormData(document.getElementById("settingsForm"));
            const paymentData = new FormData(document.getElementById("paymentForm"));
            const systemData = new FormData(document.getElementById("systemForm"));
            
            // Merge all form data
            const allData = Object.fromEntries(formData);
            Object.assign(allData, Object.fromEntries(paymentData));
            Object.assign(allData, Object.fromEntries(systemData));
            
            // Convert checkbox values
            allData.enable_notifications = document.getElementById("enableNotifications").checked ? "1" : "0";
            allData.maintenance_mode = document.getElementById("maintenanceMode").checked ? "1" : "0";
            
            console.log("Saving settings:", allData);
            showNotification("Settings saved successfully", "success");
        }
        
        function resetSettings() {
            if (confirm("Are you sure you want to reset all settings to default values?")) {
                document.getElementById("settingsForm").reset();
                document.getElementById("paymentForm").reset();
                document.getElementById("systemForm").reset();
                showNotification("Settings reset to defaults", "info");
            }
        }
        
        function backupDatabase() {
            showNotification("Database backup started", "info");
            setTimeout(() => {
                showNotification("Database backup completed successfully", "success");
            }, 2000);
        }
        
        function clearCache() {
            showNotification("Cache cleared successfully", "success");
        }
        
        function testEmail() {
            showNotification("Test email sent to admin@essystore.com", "success");
        }
        
        function viewLogs() {
            showNotification("Opening system logs...", "info");
        }
    </script>
    
    <style>
        .system-info .info-item,
        .storage-info .storage-item {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        
        .system-info .info-item:last-child,
        .storage-info .storage-item:last-child {
            border-bottom: none;
        }
        
        .activity-feed {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            background: #f8f9fa;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-title {
            font-weight: 500;
            margin-bottom: 2px;
        }
        
        .activity-time {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
';

require_once __DIR__ . '/../../resources/views/admin/layouts/admin-layout.php';
?>
