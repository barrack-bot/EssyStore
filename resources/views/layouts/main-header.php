<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Essy\'s Store'; ?></title>
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
            text-decoration: none;
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
            text-decoration: none;
        }

        .icon-btn:hover {
            color: var(--primary);
        }

        .user-menu {
            position: relative;
        }

        .user-welcome {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--dark);
            font-weight: 600;
            cursor: pointer;
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            display: none;
            z-index: 1001;
        }

        .user-menu:hover .user-dropdown {
            display: block;
        }

        .user-dropdown a {
            display: block;
            padding: 0.8rem 1rem;
            color: var(--dark);
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .user-dropdown a:hover {
            background-color: var(--light);
            color: var(--primary);
        }

        .user-dropdown a:first-child {
            border-radius: 8px 8px 0 0;
        }

        .user-dropdown a:last-child {
            border-radius: 0 0 8px 8px;
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

        .nav-links a.active {
            color: var(--primary);
        }

        .nav-links a.active::after {
            width: 100%;
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
            .nav-links {
                flex-wrap: wrap;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="top-bar">
            <span>🔥 Free shipping on orders over Ksh 5,000</span>
            <span>📞 Call us: +254712345678</span>
        </div>
        
        <div class="main-header">
            <a href="index.php" class="logo">Essy<span>Store</span></a>
            
            <div class="search-bar">
                <input type="text" placeholder="Search for products...">
            </div>
            
            <div class="header-icons">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="user-menu">
                        <span class="user-welcome">Welcome, <?php echo htmlspecialchars($_SESSION['user']['name']); ?></span>
                        <div class="user-dropdown">
                            <a href="profile.php">My Profile</a>
                            <a href="orders.php">My Orders</a>
                            <a href="#" onclick="handleLogout()">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="icon-btn">👤</a>
                <?php endif; ?>
                <a href="cart.php" class="icon-btn">
                    🛒
                    <span class="cart-count" id="cartCount" style="display: none;">0</span>
                </a>
            </div>
        </div>
        
        <nav>
            <ul class="nav-links">
                <li><a href="index.php" <?php echo ($currentPage ?? '') === 'home' ? 'class="active"' : ''; ?>>Home</a></li>
                <li><a href="shop.php" <?php echo ($currentPage ?? '') === 'shop' ? 'class="active"' : ''; ?>>Shop</a></li>
                <li><a href="about.php" <?php echo ($currentPage ?? '') === 'about' ? 'class="active"' : ''; ?>>About</a></li>
                <li><a href="contact.php" <?php echo ($currentPage ?? '') === 'contact' ? 'class="active"' : ''; ?>>Contact</a></li>
            </ul>
        </nav>
    </header>

    <script>
        function updateCartCount() {
            fetch('../api/cart/fetch.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const cartCount = document.getElementById('cartCount');
                        if (cartCount) {
                            cartCount.textContent = data.item_count || 0;
                            cartCount.style.display = data.item_count > 0 ? 'block' : 'none';
                        }
                    }
                })
                .catch(error => console.error('Error fetching cart:', error));
        }

        function handleLogout() {
            fetch('../api/auth/logout.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Redirect to login page after successful logout
                        window.location.href = 'login.php';
                    } else {
                        alert('Failed to logout');
                    }
                })
                .catch(error => {
                    console.error('Logout error:', error);
                    alert('Failed to logout');
                });
        }

        // Initialize cart count
        updateCartCount();
    </script>
</body>
</html>
