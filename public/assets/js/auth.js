class Auth {
    static async login(email, password) {
        const result = await Api.post('../api/auth/login.php', {
            email: email,
            password: password
        });
        
        if (result.status === 'success') {
            // Store user data in localStorage for role checking
            localStorage.setItem('user', JSON.stringify(result.user));
            
            this.updateUI(result.user);
            this.showMessage('Login successful', 'success');
            this.closeModal();
            
            // Role-based redirection
            setTimeout(() => {
                if (result.user.role === 'admin') {
                    window.location.href = 'admin/dashboard.php';
                } else {
                    window.location.href = 'index.php';
                }
            }, 1500);
        } else {
            this.showMessage(result.message || 'Login failed', 'error');
        }
        
        return result;
    }

    static async register(name, email, password) {
        const result = await Api.post('../api/auth/register.php', {
            name: name,
            email: email,
            password: password
        });
        
        if (result.status === 'success') {
            this.updateUI(result.user);
            this.showMessage('Registration successful', 'success');
            this.closeModal();
        } else {
            this.showMessage(result.message || 'Registration failed', 'error');
        }
        
        return result;
    }

    static async logout() {
        const result = await Api.get('../api/auth/logout.php');
        
        if (result.status === 'success') {
            this.updateUI(null);
            this.showMessage('Logged out successfully', 'success');
        }
        
        return result;
    }

    static updateUI(user) {
        const authButtons = document.getElementById('authButtons');
        const userMenu = document.getElementById('userMenu');
        const userName = document.getElementById('userName');
        
        if (user) {
            authButtons.style.display = 'none';
            userMenu.style.display = 'block';
            userName.textContent = user.name;
        } else {
            authButtons.style.display = 'block';
            userMenu.style.display = 'none';
        }
    }

    static showMessage(message, type = 'info') {
        const messageDiv = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
        messageDiv.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all`;
        messageDiv.textContent = message;
        
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.style.opacity = '0';
            setTimeout(() => messageDiv.remove(), 300);
        }, 3000);
    }

    static closeModal() {
        const modal = document.getElementById('authModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }
}
