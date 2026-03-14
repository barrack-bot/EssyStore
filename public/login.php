<?php $currentPage = 'login'; ?>
<?php require_once __DIR__ . '/../resources/views/layouts/main-header.php'; ?>

    <!-- Login/Register Page -->
    <section class="auth-page">
        <div class="auth-container">
            <div class="auth-header">
                <h1 class="auth-title">Welcome to EssyStore</h1>
                <p class="auth-subtitle">Sign in to your account or create a new one</p>
            </div>
            
            <div class="auth-content">
                <div class="auth-tabs">
                    <button class="auth-tab active" onclick="switchAuthTab('login')">Login</button>
                    <button class="auth-tab" onclick="switchAuthTab('register')">Register</button>
                </div>
                
                <form class="auth-form active" id="loginForm" onsubmit="handleLogin(event)">
                    <div class="form-group">
                        <label for="loginEmail">Email Address</label>
                        <input type="email" id="loginEmail" name="email" required placeholder="Enter your email">
                    </div>
                    
                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <input type="password" id="loginPassword" name="password" required placeholder="Enter your password">
                    </div>
                    
                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="forgot-password">Forgot password?</a>
                    </div>
                    
                    <button type="submit" class="submit-btn">Sign In</button>
                </form>
                
                <form class="auth-form" id="registerForm" onsubmit="handleRegister(event)">
                    <div class="form-group">
                        <label for="regName">Full Name</label>
                        <input type="text" id="regName" name="name" required placeholder="Enter your full name">
                    </div>
                    
                    <div class="form-group">
                        <label for="regEmail">Email Address</label>
                        <input type="email" id="regEmail" name="email" required placeholder="Enter your email">
                    </div>
                    
                    <div class="form-group">
                        <label for="regPassword">Password</label>
                        <input type="password" id="regPassword" name="password" required placeholder="Create a password">
                    </div>
                    
                    <div class="form-group">
                        <label for="regConfirmPassword">Confirm Password</label>
                        <input type="password" id="regConfirmPassword" name="confirmPassword" required placeholder="Confirm your password">
                    </div>
                    
                    <div class="form-options">
                        <label class="agree-terms">
                            <input type="checkbox" name="terms" required>
                            <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                        </label>
                    </div>
                    
                    <button type="submit" class="submit-btn">Create Account</button>
                </form>
            </div>
        </div>
    </section>

    <style>
        /* Auth Page */
        .auth-page {
            padding: 4rem 2rem;
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-container {
            max-width: 500px;
            width: 100%;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .auth-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .auth-subtitle {
            font-size: 1.1rem;
            color: var(--gray);
        }

        .auth-content {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .auth-tabs {
            display: flex;
            margin-bottom: 2rem;
            border-bottom: 2px solid #eee;
        }

        .auth-tab {
            flex: 1;
            padding: 1rem;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--gray);
            transition: all 0.3s;
        }

        .auth-tab.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .auth-tab:hover {
            color: var(--primary);
        }

        .auth-form {
            display: none;
        }

        .auth-form.active {
            display: block;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
            font-size: 1rem;
        }

        .form-group input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .remember-me,
        .agree-terms {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remember-me input,
        .agree-terms input {
            margin: 0;
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .agree-terms a {
            color: var(--primary);
            text-decoration: none;
        }

        .agree-terms a:hover {
            text-decoration: underline;
        }

        .submit-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .submit-btn:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-page {
                padding: 2rem 1rem;
            }
            
            .auth-container {
                max-width: 100%;
            }
            
            .auth-content {
                padding: 2rem;
            }
            
            .form-options {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>

    <script>
        function switchAuthTab(tab) {
            // Remove active class from all tabs and forms
            document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
            
            // Add active class to selected tab and form
            document.querySelector(`.auth-tab[onclick*="${tab}"]`).classList.add('active');
            document.getElementById(`${tab}Form`).classList.add('active');
        }

        function handleLogin(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData);
            
            // Try admin login first, then customer login
            fetch('../api/auth/admin-login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    showNotification('Admin login successful! Redirecting...', 'success');
                    setTimeout(() => {
                        window.location.href = 'admin/dashboard.php';
                    }, 1500);
                } else {
                    // If admin login fails, try customer login
                    fetch('../api/auth/login.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === 'success') {
                            showNotification('Login successful! Redirecting...', 'success');
                            setTimeout(() => {
                                window.location.href = 'index.php';
                            }, 1500);
                        } else {
                            showNotification(result.message || 'Login failed', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Login error:', error);
                        showNotification('Login failed. Please try again.', 'error');
                    });
                }
            })
            .catch(error => {
                console.error('Admin login error:', error);
                showNotification('Login failed. Please try again.', 'error');
            });
        }

        function handleAdminLogin(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData);
            
            // Send admin login request to API
            fetch('../api/auth/admin-login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    showNotification('Admin login successful! Redirecting...', 'success');
                    setTimeout(() => {
                        window.location.href = 'admin/dashboard.php';
                    }, 1500);
                } else {
                    showNotification(result.message || 'Admin login failed', 'error');
                }
            })
            .catch(error => {
                console.error('Admin login error:', error);
                showNotification('Admin login failed. Please try again.', 'error');
            });
        }

        function handleRegister(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData);
            
            // Validate passwords match
            if (data.password !== data.confirmPassword) {
                showNotification('Passwords do not match!', 'error');
                return;
            }
            
            // Send registration request to API
            fetch('../api/auth/register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    showNotification('Account created successfully! Redirecting...', 'success');
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 1500);
                } else {
                    showNotification(result.message || 'Registration failed', 'error');
                }
            })
            .catch(error => {
                console.error('Registration error:', error);
                showNotification('Registration failed. Please try again.', 'error');
            });
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#4cc9f0' : '#dc3545'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 5px;
                z-index: 4000;
                animation: slideIn 0.3s ease;
                max-width: 300px;
                word-wrap: break-word;
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Add animation styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>

<?php require_once __DIR__ . '/../resources/views/layouts/main-footer.php'; ?>
