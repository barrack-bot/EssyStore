<?php 
session_start();
$currentPage = 'profile'; 

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../resources/views/layouts/main-header.php'; ?>

    <!-- Profile Page -->
    <section class="profile-page">
        <div class="profile-header">
            <h1 class="profile-title">My Profile</h1>
            <p class="profile-subtitle">Manage your account information and preferences</p>
        </div>
        
        <div class="profile-content">
            <div class="profile-sidebar">
                <div class="profile-nav">
                    <a href="profile.php" class="nav-item active">Profile Information</a>
                    <a href="orders.php" class="nav-item">My Orders</a>
                    <a href="#" class="nav-item">Addresses</a>
                    <a href="#" class="nav-item">Payment Methods</a>
                    <a href="#" class="nav-item">Security Settings</a>
                </div>
            </div>
            
            <div class="profile-main">
                <div class="profile-section">
                    <h2>Personal Information</h2>
                    <form class="profile-form" method="POST" action="../api/auth/update-profile.php">
                        <div class="form-row">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION['user']['name'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="last_name" placeholder="Enter your last name" value="<?php echo htmlspecialchars($_SESSION['user']['last_name'] ?? ''); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user']['email'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" placeholder="+254 7XX XXX XXX" value="<?php echo htmlspecialchars($_SESSION['user']['phone'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($_SESSION['user']['date_of_birth'] ?? ''); ?>">
                        </div>
                        
                        <button type="submit" class="update-btn">Update Profile</button>
                    </form>
                </div>
                
                <div class="profile-section">
                    <h2>Account Preferences</h2>
                    <form class="preferences-form" method="POST" action="../api/auth/update-preferences.php">
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="email_notifications" value="1" checked>
                                <span>Email Notifications</span>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="sms_notifications" value="1" checked>
                                <span>SMS Notifications</span>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="newsletter_subscription" value="1">
                                <span>Newsletter Subscription</span>
                            </label>
                        </div>
                        
                        <button type="submit" class="update-btn">Save Preferences</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Profile Page */
        .profile-page {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #eee;
        }

        .profile-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .profile-subtitle {
            color: var(--gray);
            font-size: 1.1rem;
        }

        .profile-content {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 2rem;
        }

        .profile-sidebar {
            background: var(--light);
            padding: 1.5rem;
            border-radius: 10px;
        }

        .profile-nav {
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

        .profile-main {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .profile-section {
            background: white;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 2rem;
        }

        .profile-section h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #eee;
        }

        .profile-form, .preferences-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            font-weight: 600;
            color: var(--dark);
        }

        .form-group input {
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .form-group input[readonly] {
            background: var(--light);
            cursor: not-allowed;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .checkbox-label input[type="checkbox"] {
            width: auto;
        }

        .update-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .update-btn:hover {
            background: var(--secondary);
        }

        @media (max-width: 768px) {
            .profile-content {
                grid-template-columns: 1fr;
            }

            .profile-sidebar {
                order: 2;
            }

            .profile-main {
                order: 1;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        // Handle profile update form submission
        document.querySelector('.profile-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            console.log('Form submitted'); // Debug log
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            
            console.log('Form data:', data); // Debug log
            
            try {
                const response = await fetch('../api/auth/update-profile.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                
                console.log('API response status:', response.status); // Debug log
                
                const result = await response.json();
                console.log('API result:', result); // Debug log
                
                // Handle response
                if (result && result.status === 'success') {
                    showNotification('Profile updated successfully!', 'success');
                    // Update form fields with returned data
                    if (result.data) {
                        if (result.data.name) {
                            document.querySelector('input[name="name"]').value = result.data.name;
                        }
                        if (result.data.email) {
                            document.querySelector('input[name="email"]').value = result.data.email;
                        }
                    }
                } else {
                    showNotification(result.message || 'Failed to update profile', 'error');
                }
            } catch (error) {
                console.error('Error updating profile:', error);
                showNotification('Failed to update profile. Please try again.', 'error');
            }
        });

        // Handle preferences form submission
        document.querySelector('.preferences-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            
            try {
                const response = await fetch('../api/auth/update-preferences.php', {
                    method: 'POST',
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.status === 'success') {
                    showNotification('Preferences saved successfully!', 'success');
                } else {
                    showNotification(result.message || 'Failed to save preferences', 'error');
                }
            } catch (error) {
                console.error('Error saving preferences:', error);
                showNotification('Failed to save preferences', 'error');
            }
        });

        // Notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#4cc9f0' : '#f72585'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                z-index: 9999;
                font-weight: 600;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                animation: slideIn 0.3s ease;
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 3000);
            }, 3000);
        }

        function toggleAuthModal() {
            window.location.href = 'login.php';
        }
    </script>

<?php require_once __DIR__ . '/../resources/views/layouts/main-footer.php'; ?>
