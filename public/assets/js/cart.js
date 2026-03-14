class Cart {
    static async addToCart(productId, quantity = 1) {
        const result = await Api.post('../api/cart/add.php', {
            product_id: productId,
            quantity: quantity
        });
        
        if (result.status === 'success') {
            this.loadCart();
            this.showMessage('Product added to cart', 'success');
        } else {
            this.showMessage(result.message || 'Failed to add to cart', 'error');
        }
        
        return result;
    }

    static async removeFromCart(productId) {
        const result = await Api.post('../api/cart/remove.php', {
            product_id: productId
        });
        
        if (result.status === 'success') {
            this.loadCart();
            this.showMessage('Product removed from cart', 'success');
        } else {
            this.showMessage(result.message || 'Failed to remove from cart', 'error');
        }
        
        return result;
    }

    static async loadCart() {
        const result = await Api.get('../api/cart/fetch.php');
        
        if (result.status === 'success') {
            this.updateCartCounter(result.item_count || 0);
            return result.cart;
        }
        
        return {};
    }

    static updateCartCounter(count) {
        const cartCount = document.getElementById('cartCount');
        if (cartCount) {
            cartCount.textContent = count;
            cartCount.style.display = count > 0 ? 'block' : 'none';
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
}
