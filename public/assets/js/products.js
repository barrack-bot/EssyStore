class Products {
    static async loadProducts(containerId = 'productsGrid') {
        const result = await Api.get('../api/products/list.php');
        
        if (result.status === 'success') {
            this.renderProducts(result.products, containerId);
        } else {
            this.showMessage('Failed to load products', 'error');
        }
        
        return result;
    }

    static renderProducts(products, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        
        container.innerHTML = '';
        
        if (products.length === 0) {
            container.innerHTML = '<p class="text-center text-gray-500 col-span-full">No products found</p>';
            return;
        }
        
        products.forEach(product => {
            const productCard = this.createProductCard(product);
            container.appendChild(productCard);
        });
    }

    static createProductCard(product) {
        const card = document.createElement('div');
        card.className = 'bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow';
        
        card.innerHTML = `
            <div class="h-48 overflow-hidden bg-gray-100">
                <img src="${product.image || '/essystore/public/assets/images/placeholder.svg'}" alt="${product.name}" class="w-full h-full object-cover">
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-2">${product.name}</h3>
                <p class="text-gray-600 text-sm mb-3">${product.description || 'No description available'}</p>
                <div class="text-xl font-bold text-blue-600 mb-3">Ksh ${product.price}</div>
                <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition add-to-cart" data-product-id="${product.id}">
                    Add to Cart
                </button>
            </div>
        `;
        
        const addToCartBtn = card.querySelector('.add-to-cart');
        addToCartBtn.addEventListener('click', () => {
            Cart.addToCart(product.id, 1);
        });
        
        return card;
    }

    static async searchProducts(term) {
        const result = await Api.get(`../api/products/search.php?term=${encodeURIComponent(term)}`);
        
        if (result.status === 'success') {
            this.renderProducts(result.products, 'productsGrid');
        } else {
            this.showMessage('Search failed', 'error');
        }
        
        return result;
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
