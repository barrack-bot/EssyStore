<?php 
session_start();
$currentPage = 'shop'; 
require_once __DIR__ . '/../resources/views/layouts/main-header.php'; ?>

    <!-- Shop Page -->
    <section class="shop-page">
        <div class="shop-header">
            <h1 class="shop-title">Shop</h1>
            <div class="shop-controls">
                <div class="search-input">
                    <input type="text" id="searchInput" placeholder="Search products...">
                </div>
                <button class="search-btn" onclick="searchProducts()">Search</button>
                <div class="filter-dropdown">
                    <select id="categoryFilter" onchange="filterByCategory()">
                        <option value="">All Categories</option>
                        <option value="electronics">Electronics</option>
                        <option value="clothing">Clothing</option>
                        <option value="home">Home & Garden</option>
                        <option value="sports">Sports</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="products-section">
            <h2 class="section-title">All Products</h2>
            
            <div class="products-grid" id="productsGrid">
                <!-- Products will be loaded here -->
            </div>
        </div>
    </section>

    <style>
        /* Shop Page */
        .shop-page {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .shop-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #eee;
        }

        .shop-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.2rem;
            color: var(--secondary);
        }

        .shop-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-input {
            flex: 1;
            max-width: 400px;
        }

        .search-input input {
            width: 100%;
            padding: 0.8rem 1.5rem;
            border: 2px solid #e0e0e0;
            border-radius: 30px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .search-input input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .search-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-btn:hover {
            background: var(--secondary);
        }

        .filter-dropdown {
            min-width: 200px;
        }

        .filter-dropdown select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1rem;
            background: white;
            cursor: pointer;
        }

        .filter-dropdown select:focus {
            outline: none;
            border-color: var(--primary);
        }

        /* Products Section */
        .products-section {
            margin-top: 2rem;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.2rem;
            margin-bottom: 2rem;
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

        /* Responsive */
        @media (max-width: 768px) {
            .shop-header {
                flex-direction: column;
                gap: 1rem;
            }
            
            .shop-controls {
                flex-direction: column;
                width: 100%;
                gap: 1rem;
            }
            
            .search-input {
                max-width: 100%;
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

        // Search functionality
        async function searchProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            if (searchTerm.trim() === '') {
                initializeProducts();
                return;
            }
            
            try {
                const response = await fetch(`../api/products/search.php?term=${encodeURIComponent(searchTerm)}`);
                const data = await response.json();
                
                if (data.status === 'success') {
                    renderProducts(data.products);
                } else {
                    document.getElementById('productsGrid').innerHTML = '<p>No products found</p>';
                }
            } catch (error) {
                console.error('Error searching products:', error);
                document.getElementById('productsGrid').innerHTML = '<p>Error searching products</p>';
            }
        }

        // Filter functionality
        async function filterByCategory() {
            const category = document.getElementById('categoryFilter').value;
            
            if (category === '') {
                initializeProducts();
                return;
            }
            
            try {
                const response = await fetch(`../api/products/category.php?category=${encodeURIComponent(category)}`);
                const data = await response.json();
                
                if (data.status === 'success') {
                    renderProducts(data.products);
                } else {
                    document.getElementById('productsGrid').innerHTML = '<p>No products found in this category</p>';
                }
            } catch (error) {
                console.error('Error filtering products:', error);
                document.getElementById('productsGrid').innerHTML = '<p>Error filtering products</p>';
            }
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

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            initializeProducts();
            
            // Add search on Enter key
            document.getElementById('searchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchProducts();
                }
            });
        });
    </script>

<?php require_once __DIR__ . '/../resources/views/layouts/main-footer.php'; ?>
