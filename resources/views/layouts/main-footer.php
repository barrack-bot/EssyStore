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

        // Initialize cart count
        updateCartCount();
    </script>
</body>
</html>
