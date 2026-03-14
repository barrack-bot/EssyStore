<?php 
session_start();

// Include database configuration
require_once __DIR__ . '/../app/config/database.php';

// Create database connection
$database = new Database();
$conn = $database->connect();

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cartItems = [];
$total = 0;

// Fetch product details for cart items
if (!empty($cart)) {
    $productIds = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
    
    $sql = "SELECT * FROM products WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($productIds);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Create a lookup array by ID
    $productsById = [];
    foreach ($products as $product) {
        $productsById[$product['id']] = $product;
    }
    
    // Build cart items with product details
    foreach ($cart as $productId => $quantity) {
        if (isset($productsById[$productId])) {
            $product = $productsById[$productId];
            $subtotal = $product['price'] * $quantity;
            $total += $subtotal;
            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal
            ];
        }
    }
}

require_once __DIR__ . '/../resources/views/layouts/main-header.php';
?>

    <!-- Cart Page -->
    <section class="cart-page">
        <div class="cart-header">
            <h1>Shopping Cart</h1>
            <button class="icon-btn" onclick="clearCart()">🗑️ Clear Cart</button>
        </div>
        
        <div class="cart-items" id="cartItems">
            <?php if (empty($cartItems)): ?>
                <div class="empty-cart">
                    <h2>Your cart is empty</h2>
                    <p>Looks like you haven't added anything to your cart yet.</p>
                    <a href="shop.php" class="continue-shopping">Start Shopping</a>
                </div>
            <?php else: ?>
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item">
                        <div class="cart-item-img">
                            <img src="<?php echo htmlspecialchars($item['product']['image'] ?? '/essystore/public/assets/images/placeholder.svg'); ?>" 
                                 alt="<?php echo htmlspecialchars($item['product']['name']); ?>" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="cart-item-info">
                            <h3 class="cart-item-title"><?php echo htmlspecialchars($item['product']['name']); ?></h3>
                            <p class="cart-item-price">Ksh<?php echo number_format($item['product']['price'], 2); ?> × <?php echo $item['quantity']; ?></p>
                            <p class="cart-item-total">Ksh<?php echo number_format($item['subtotal'], 2); ?></p>
                        </div>
                        <button onclick="removeFromCart(<?php echo $item['product']['id']; ?>)" style="color: var(--accent); border: none; background: none; cursor: pointer; font-size: 1.2rem;">✕</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="cart-summary">
            <div class="cart-total">Total: Ksh<?php echo number_format($total, 2); ?></div>
            <button class="checkout-btn" onclick="checkout()">Proceed to Checkout</button>
            <a href="shop.php" class="continue-shopping">Continue Shopping</a>
        </div>
    </section>

    <style>
        /* Cart Page */
        .cart-page {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #eee;
        }

        .cart-items {
            margin-bottom: 2rem;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .cart-item-img {
            width: 80px;
            height: 80px;
            background: #f0f0f0;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--gray);
        }

        .cart-item-info {
            flex-grow: 1;
        }

        .cart-item-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .cart-item-price {
            font-size: 1rem;
            color: var(--gray);
            margin-bottom: 0.5rem;
        }

        .cart-item-total {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
        }

        .cart-summary {
            text-align: right;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #eee;
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
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .checkout-btn:hover {
            background: #45b049;
        }

        .empty-cart {
            text-align: center;
            padding: 3rem;
            color: var(--gray);
        }

        .empty-cart h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .continue-shopping {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 1rem;
            transition: background 0.3s;
        }

        .continue-shopping:hover {
            background: var(--secondary);
        }
    </style>

    <script>
        function clearCart() {
            if (confirm('Are you sure you want to clear your cart?')) {
                // Clear cart via API
                fetch('../api/cart/clear.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Reload page to reflect changes
                        location.reload();
                    } else {
                        alert('Failed to clear cart');
                    }
                })
                .catch(error => {
                    console.error('Error clearing cart:', error);
                    alert('Failed to clear cart');
                });
            }
        }

        function removeFromCart(productId) {
            // Remove from cart via API
            fetch('../api/cart/remove.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Reload page to reflect changes
                    location.reload();
                } else {
                    alert('Failed to remove item');
                }
            })
            .catch(error => {
                console.error('Error removing from cart:', error);
                alert('Failed to remove item');
            });
        }

        function checkout() {
            alert('Proceeding to checkout... (This is a demo)');
        }

        function toggleAuthModal() {
            window.location.href = 'login.php';
        }
    </script>

<?php require_once __DIR__ . '/../resources/views/layouts/main-footer.php'; ?>
