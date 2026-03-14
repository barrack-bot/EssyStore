<?php 
session_start();
$currentPage = 'home'; 
require_once __DIR__ . '/../resources/views/layouts/main-header.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Welcome to EssyStore</h1>
        <p>Discover amazing products at unbeatable prices</p>
        <a href="#products" class="cta-button">Shop Now</a>
    </section>

    <!-- Products Section -->
    <section class="products-section" id="products">
        <h2 class="section-title">Featured Products</h2>
        
        <div class="products-grid" id="productsGrid">
            <!-- Products will be loaded here -->
        </div>
    </section>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h3>Shopping Cart</h3>
            <button onclick="toggleCart()" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer;">✕</button>
        </div>
        
        <div class="cart-items" id="cartItems">
            <p>Your cart is empty</p>
        </div>
        
        <div class="cart-footer">
            <div class="cart-total">Total: Ksh<span id="cartTotal">0.00</span></div>
            <button class="checkout-btn" onclick="checkout()">Checkout</button>
        </div>
    </div>

    <!-- Auth Modal -->
    <div class="auth-modal" id="authModal">
        <div class="auth-content">
            <div class="auth-tabs">
                <button class="auth-tab active" onclick="switchAuthTab('login')">Login</button>
                <button class="auth-tab" onclick="switchAuthTab('register')">Register</button>
            </div>
            
            <form class="auth-form active" id="loginForm">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" required>
                </div>
                <button type="submit" class="submit-btn">Login</button>
            </form>
            
            <form class="auth-form" id="registerForm">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" required>
                </div>
                <button type="submit" class="submit-btn">Register</button>
            </form>
        </div>
    </div>

    <style>
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 4rem 2rem;
            text-align: center;
        }

        .hero h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 3.5rem;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease 0.2s;
            animation-fill-mode: both;
        }

        .cta-button {
            background: var(--accent);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            animation: fadeInUp 1s ease 0.4s;
            animation-fill-mode: both;
            text-decoration: none;
            display: inline-block;
        }

        .cta-button:hover {
            background: #d62876;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(247, 37, 133, 0.3);
        }

        /* Products Section */
        .products-section {
            padding: 4rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: var(--secondary);
            text-align: center;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .product-img {
            width: 100%;
            height: 200px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--gray);
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .product-price {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .add-to-cart {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }

        .add-to-cart:hover {
            background: var(--secondary);
        }

        /* Cart Sidebar */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100%;
            background: white;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 3000;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .cart-sidebar.active {
            right: 0;
        }

        .cart-header {
            padding: 1.5rem;
            background: var(--primary);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-items {
            flex-grow: 1;
            padding: 1.5rem;
            overflow-y: auto;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .cart-item-img {
            width: 60px;
            height: 60px;
            background: #f0f0f0;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--gray);
        }

        .cart-footer {
            padding: 1.5rem;
            background: #f8f9fa;
            border-top: 1px solid #eee;
        }

        .cart-total {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .checkout-btn {
            background: var(--success);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 5px;
            width: 100%;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .checkout-btn:hover {
            background: #45b049;
        }

        /* Auth Modal */
        .auth-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 4000;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .auth-modal.active {
            display: flex;
        }

        .auth-content {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            width: 400px;
            max-width: 90%;
        }

        .auth-tabs {
            display: flex;
            margin-bottom: 2rem;
        }

        .auth-tab {
            flex: 1;
            padding: 1rem;
            background: none;
            border: none;
            border-bottom: 2px solid #eee;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .auth-tab.active {
            border-bottom-color: var(--primary);
            color: var(--primary);
        }

        .auth-form {
            display: none;
        }

        .auth-form.active {
            display: block;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .submit-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 5px;
            width: 100%;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .submit-btn:hover {
            background: var(--secondary);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .cart-sidebar {
                width: 100%;
                right: -100%;
            }
        }
    </style>

    <script>
        // Initialize products from database
        async function initializeProducts() {
            try {
                const response = await fetch('../api/products/list.php');
                const data = await response.json();
                
                if (data.status === 'success') {
                    renderProducts(data.products);
                } else {
                    document.getElementById('productsGrid').innerHTML = '<p>Error loading products</p>';
                }
            } catch (error) {
                console.error('Error loading products:', error);
                document.getElementById('productsGrid').innerHTML = '<p>Error loading products</p>';
            }
        }

        function renderProducts(productsToRender) {
            const productsGrid = document.getElementById('productsGrid');
            productsGrid.innerHTML = '';
            
            if (productsToRender.length === 0) {
                productsGrid.innerHTML = '<p style="text-align: center; color: var(--gray); font-size: 1.2rem;">No products found</p>';
                return;
            }
            
            productsToRender.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card';
                productCard.innerHTML = `
                    <div class="product-img">
                        <img src="${product.image || 'https://via.placeholder.com/400x300/e5e7eb/6b7280?text=Product'}" alt="${product.name}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">${product.name}</h3>
                        <div class="product-price">Ksh ${product.price}</div>
                        <button class="add-to-cart" onclick="addToCart(${product.id})">
                            Add to Cart
                        </button>
                    </div>
                `;
                productsGrid.appendChild(productCard);
            });
        }

        // Cart functions
        function addToCart(productId) {
            // Add to cart via API
            fetch('../api/cart/add.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showNotification('Product added to cart!', 'success');
                    updateCartCount();
                } else {
                    showNotification(data.message || 'Failed to add to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                showNotification('Failed to add to cart', 'error');
            });
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: ${type === 'success' ? '#4cc9f0' : '#dc3545'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 5px;
                z-index: 4000;
                animation: slideIn 0.3s ease;
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        function toggleCart() {
            document.getElementById('cartSidebar').classList.toggle('active');
        }

        // Auth modal functions
        function toggleAuthModal() {
            document.getElementById('authModal').classList.toggle('active');
        }

        function switchAuthTab(tab) {
            document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
            
            document.querySelector(`.auth-tab[onclick*="${tab}"]`).classList.add('active');
            document.getElementById(`${tab}Form`).classList.add('active');
        }

        // Form submissions
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Login successful! (This is a demo)');
            toggleAuthModal();
        });

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Account created! (This is a demo)');
            toggleAuthModal();
        });

        // Checkout
        function checkout() {
            alert('Proceeding to checkout... (This is a demo)');
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

        // Initialize
        initializeProducts();

        // Close cart when clicking outside
        document.addEventListener('click', function(e) {
            const cartSidebar = document.getElementById('cartSidebar');
            if (cartSidebar.classList.contains('active') && 
                !cartSidebar.contains(e.target) && 
                !e.target.closest('.icon-btn')) {
                toggleCart();
            }
        });

        // Close auth modal when clicking outside
        document.getElementById('authModal').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleAuthModal();
            }
        });
    </script>

<?php require_once __DIR__ . '/../resources/views/layouts/main-footer.php'; ?>
