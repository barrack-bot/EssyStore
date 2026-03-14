document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart
    Cart.loadCart();
    
    // Load products on homepage
    const productsGrid = document.getElementById('productsGrid');
    if (productsGrid) {
        Products.loadProducts();
    }
    
    // Auth modal handlers
    const loginBtn = document.getElementById('loginBtn');
    const registerBtn = document.getElementById('registerBtn');
    const logoutBtn = document.getElementById('logoutBtn');
    
    if (loginBtn) {
        loginBtn.addEventListener('click', () => showAuthModal('login'));
    }
    
    if (registerBtn) {
        registerBtn.addEventListener('click', () => showAuthModal('register'));
    }
    
    if (logoutBtn) {
        logoutBtn.addEventListener('click', () => Auth.logout());
    }
    
    // Auth form handlers
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }
    
    if (registerForm) {
        registerForm.addEventListener('submit', handleRegister);
    }
    
    // Modal close handlers
    const modalClose = document.querySelector('.modal-close');
    if (modalClose) {
        modalClose.addEventListener('click', hideAuthModal);
    }
    
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('authModal');
        if (event.target === modal) {
            hideAuthModal();
        }
    });
});

function showAuthModal(type) {
    const modal = document.getElementById('authModal');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    
    if (!modal) {
        createAuthModal();
        return showAuthModal(type);
    }
    
    if (type === 'login') {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        loginTab.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
        loginTab.classList.remove('text-gray-600');
        registerTab.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
        registerTab.classList.add('text-gray-600');
    } else {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        loginTab.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
        loginTab.classList.add('text-gray-600');
        registerTab.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
        registerTab.classList.remove('text-gray-600');
    }
    
    modal.style.display = 'flex';
}

function hideAuthModal() {
    const modal = document.getElementById('authModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

function createAuthModal() {
    const modal = document.createElement('div');
    modal.id = 'authModal';
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 w-full max-w-md relative">
            <span class="absolute top-4 right-4 text-2xl cursor-pointer text-gray-500 hover:text-gray-700 modal-close">&times;</span>
            <div class="flex border-b mb-6">
                <button id="loginTab" class="flex-1 pb-2 text-center font-semibold text-blue-600 border-b-2 border-blue-600 tab-button">Login</button>
                <button id="registerTab" class="flex-1 pb-2 text-center font-semibold text-gray-600 hover:text-blue-600 tab-button">Register</button>
            </div>
            
            <form id="loginForm" class="space-y-4">
                <h3 class="text-xl font-semibold text-center mb-4">Login to Your Account</h3>
                <div>
                    <input type="email" name="email" placeholder="Enter your email" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <input type="password" name="password" placeholder="Enter your password" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Login</button>
            </form>
            
            <form id="registerForm" class="space-y-4" style="display: none;">
                <h3 class="text-xl font-semibold text-center mb-4">Create New Account</h3>
                <div>
                    <input type="text" name="name" placeholder="Enter your name" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <input type="email" name="email" placeholder="Enter your email" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <input type="password" name="password" placeholder="Enter your password" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Register</button>
            </form>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Add tab switching
    document.getElementById('loginTab').addEventListener('click', () => showAuthModal('login'));
    document.getElementById('registerTab').addEventListener('click', () => showAuthModal('register'));
}

function handleLogin(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    Auth.login(formData.get('email'), formData.get('password'));
}

function handleRegister(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    Auth.register(formData.get('name'), formData.get('email'), formData.get('password'));
}
