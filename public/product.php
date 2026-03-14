<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Essy's Store | Product Details</title>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #4cc9f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f5f7ff;
            color: var(--dark);
            line-height: 1.6;
        }

        /* Header */
        header {
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .top-bar {
            background: var(--primary);
            color: white;
            padding: 0.5rem 2rem;
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
        }

        .main-header {
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
        }

        .logo span {
            color: var(--accent);
        }

        .search-bar {
            flex-grow: 0.5;
            margin: 0 2rem;
        }

        .search-bar input {
            width: 100%;
            padding: 0.8rem 1.5rem;
            border: 2px solid #e0e0e0;
            border-radius: 30px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .header-icons {
            display: flex;
            gap: 1.5rem;
        }

        .icon-btn {
            position: relative;
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: var(--dark);
            transition: color 0.3s;
        }

        .icon-btn:hover {
            color: var(--primary);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--accent);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Navigation */
        nav {
            background: white;
            border-top: 1px solid #eee;
            padding: 0.8rem 2rem;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            padding: 0.5rem 0;
            position: relative;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        /* Product Detail */
        .product-detail {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .product-image {
            height: 400px;
            background: #f0f0f0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 6rem;
            color: var(--gray);
        }

        .product-info {
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .product-price {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .product-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--gray);
            margin-bottom: 2rem;
        }

        .product-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-selector input {
            width: 80px;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1rem;
        }

        .add-to-cart-btn {
            background: var(--primary);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .add-to-cart-btn:hover {
            background: var(--secondary);
        }

        /* Related Products */
        .related-products {
            margin-top: 3rem;
        }

        .related-products h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            margin-bottom: 2rem;
            color: var(--secondary);
            text-align: center;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
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

        .product-card-info {
            padding: 1.5rem;
        }

        .product-card-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .product-card-price {
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

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 3rem 2rem 1rem;
            margin-top: 3rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-section h3 {
            font-family: 'Poppins', sans-serif;
            margin-bottom: 1.5rem;
            color: white;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section li {
            margin-bottom: 0.8rem;
        }

        .footer-section a {
            color: #aaa;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: white;
        }

        .copyright {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #444;
            color: #aaa;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-detail-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .product-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="top-bar">
            <span>🔥 Free shipping on orders over Ksh 7,500</span>
            <span>📞 Call us: +254712345678</span>
        </div>
        
        <div class="main-header">
            <div class="logo">Essy<span>Store</span></div>
            
            <div class="search-bar">
                <input type="text" placeholder="Search for products...">
            </div>
            
            <div class="header-icons">
                <button class="icon-btn" onclick="toggleAuthModal()">👤</button>
                <button class="icon-btn" onclick="toggleCart()">
                    🛒
                    <span class="cart-count" id="cartCount">0</span>
                </button>
            </div>
        </div>
        
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="#">Categories</a></li>
                <li><a href="#">New Arrivals</a></li>
                <li><a href="#">Sale</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Product Detail -->
    <section class="product-detail">
        <div class="product-detail-grid" id="productDetail">
            <!-- Product details will be loaded here -->
        </div>
        
        <div class="related-products">
            <h2>Related Products</h2>
            <div class="products-grid" id="relatedProductsGrid">
                <!-- Related products will be loaded here -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>EssyStore</h3>
                <p>Your trusted online marketplace for unique and beautiful products.</p>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Customer Service</h3>
                <ul>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Returns & Refunds</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Contact Info</h3>
                <p>📍 123 Store Street, City</p>
                <p>📧 info@essystore.com</p>
                <p>📞 +254712345678</p>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; 2026 EssyStore. All rights reserved. | Made by s.poison</p>
        </div>
    </footer>

    <script>
        // Sample product data
        const products = [
            { id: 1, name: "Wireless Headphones", price: 89.99, emoji: "🎧" },
            { id: 2, name: "Smart Watch", price: 199.99, emoji: "⌚" },
            { id: 3, name: "Laptop Stand", price: 34.99, emoji: "💻" },
            { id: 4, name: "Desk Lamp", price: 45.50, emoji: "💡" },
            { id: 5, name: "Water Bottle", price: 24.99, emoji: "💧" },
            { id: 6, name: "Notebook Set", price: 18.99, emoji: "📓" },
            { id: 7, name: "Phone Case", price: 29.99, emoji: "📱" },
            { id: 8, name: "Backpack", price: 59.99, emoji: "🎒" }
        ];

        // Shopping cart
        let cart = [];
        let cartCount = 0;
        let cartTotal = 0;

        // Get product ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const productId = parseInt(urlParams.get('id')) || 1;

        // Load product details
        function loadProduct(productId) {
            const product = products.find(p => p.id === productId);
            if (product) {
                renderProductDetail(product);
                loadRelatedProducts(productId);
            } else {
                document.getElementById('productDetail').innerHTML = '<p>Product not found</p>';
            }
        }

        function renderProductDetail(product) {
            const container = document.getElementById('productDetail');
            container.innerHTML = `
                <div class="product-image">${product.emoji}</div>
                <div class="product-info">
                    <h1 class="product-title">${product.name}</h1>
                    <div class="product-price">$${product.price.toFixed(2)}</div>
                    <div class="product-description">
                        <p>This is a high-quality ${product.name.toLowerCase()} with premium features and excellent durability. Perfect for everyday use and makes a great gift idea.</p>
                    </div>
                    <div class="product-actions">
                        <div class="quantity-selector">
                            <label>Quantity:</label>
                            <input type="number" id="quantity" value="1" min="1" max="10">
                        </div>
                        <button class="add-to-cart-btn" onclick="addToCart(${product.id})">
                            Add to Cart
                        </button>
                    </div>
                </div>
            `;
        }

        function loadRelatedProducts(productId) {
            const relatedProducts = products.filter(p => p.id !== productId).slice(0, 4);
            const container = document.getElementById('relatedProductsGrid');
            container.innerHTML = '';
            
            relatedProducts.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card';
                productCard.innerHTML = `
                    <div class="product-img">${product.emoji}</div>
                    <div class="product-card-info">
                        <h3 class="product-card-title">${product.name}</h3>
                        <div class="product-card-price">$${product.price.toFixed(2)}</div>
                        <button class="add-to-cart" onclick="addToCart(${product.id})">
                            Add to Cart
                        </button>
                    </div>
                `;
                container.appendChild(productCard);
            });
        }

        // Cart functions
        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            const existingItem = cart.find(item => item.id === productId);
            
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    ...product,
                    quantity: 1
                });
            }
            
            updateCart();
            showNotification(`${product.name} added to cart!`);
        }

        function updateCart() {
            cartCount = cart.reduce((total, item) => total + item.quantity, 0);
            cartTotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            
            document.getElementById('cartCount').textContent = cartCount;
        }

        function toggleCart() {
            alert('Cart functionality would open here in full implementation');
        }

        function toggleAuthModal() {
            alert('Login modal would open here in full implementation');
        }

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: #4cc9f0;
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
        loadProduct(productId);
        updateCart();
    </script>
</body>
</html>
