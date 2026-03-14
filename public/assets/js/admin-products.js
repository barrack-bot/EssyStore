let products = [];
let isEditing = false;
let editingId = null;

document.addEventListener("DOMContentLoaded", function() {
    const productModal = new bootstrap.Modal(document.getElementById("productModal"));
    window.productModal = productModal;
    loadProducts();
    
    // Search functionality
    document.getElementById('searchProducts')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filteredProducts = products.filter(product => 
            product.name.toLowerCase().includes(searchTerm) ||
            product.description?.toLowerCase().includes(searchTerm) ||
            product.category.toLowerCase().includes(searchTerm)
        );
        renderProducts(filteredProducts);
    });
});

async function loadProducts() {
    try {
        const response = await fetch("/essystore/api/admin/products/list.php");
        
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            const text = await response.text();
            console.error("Expected JSON but got:", text);
            throw new Error("Response is not JSON");
        }
        
        const data = await response.json();
        
        if (data.status === "success") {
            products = data.data;
            renderProducts();
        } else {
            showNotification(data.message || "Error loading products", "error");
        }
    } catch (error) {
        console.error("Error loading products:", error);
        showNotification("Error loading products: " + error.message, "error");
    }
}

function renderProducts(productsToRender = null) {
    const tbody = document.getElementById("products-table");
    const productsList = productsToRender || products;
    
    if (!tbody) return;
    
    if (productsList.length === 0) {
        tbody.innerHTML = "<tr><td colspan=\"7\" class=\"text-center py-5 text-muted\">No products found</td></tr>";
        return;
    }
    
    tbody.innerHTML = productsList.map(product => {
        const stockClass = product.stock_quantity > 10 ? 'stock-in' : (product.stock_quantity > 0 ? 'stock-low' : 'stock-out');
        const stockText = product.stock_quantity > 10 ? 'In Stock' : (product.stock_quantity > 0 ? 'Low Stock' : 'Out of Stock');
        
        return `
            <tr>
                <td>
                    <img src="${product.image || 'https://picsum.photos/50'}" alt="${product.name}" class="product-thumb" onerror="this.src='https://picsum.photos/50'">
                </td>
                <td>
                    <strong>${product.name}</strong><br>
                    <small class="text-muted">${product.description ? (product.description.substring(0, 50) + (product.description.length > 50 ? '...' : '')) : 'No description'}</small>
                </td>
                <td><span class="badge bg-info">${product.category}</span></td>
                <td><strong>Ksh ${parseFloat(product.price).toFixed(2)}</strong></td>
                <td>${product.stock_quantity}</td>
                <td><span class="stock-badge ${stockClass}">${stockText}</span></td>
                <td>
                    <button class="btn btn-primary btn-action-sm me-1" onclick="editProduct(${product.id})" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-action-sm" onclick="deleteProduct(${product.id})" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    }).join("");
}

function editProduct(id) {
    const product = products.find(p => p.id === id);
    if (!product) return;
    
    isEditing = true;
    editingId = id;
    
    document.getElementById("modalTitle").textContent = "Edit Product";
    document.getElementById("productId").value = id;
    document.getElementById("productName").value = product.name;
    document.getElementById("productDescription").value = product.description || "";
    document.getElementById("productPrice").value = product.price;
    document.getElementById("productCategory").value = product.category;
    document.getElementById("productImage").value = product.image || "";
    document.getElementById("productStock").value = product.stock_quantity;
    
    window.productModal.show();
}

async function saveProduct() {
    const form = document.getElementById("productForm");
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    
    const url = isEditing ? "/essystore/api/admin/products/update.php" : "/essystore/api/admin/products/create.php";
    
    try {
        const response = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });
        
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            const text = await response.text();
            console.error("Expected JSON but got:", text);
            throw new Error("Response is not JSON");
        }
        
        const result = await response.json();
        
        if (result.status === "success") {
            showNotification(result.message, "success");
            window.productModal.hide();
            loadProducts();
            resetForm();
        } else {
            showNotification(result.message, "error");
        }
    } catch (error) {
        console.error("Error saving product:", error);
        showNotification("Error saving product: " + error.message, "error");
    }
}

async function deleteProduct(id) {
    if (!confirm("Are you sure you want to delete this product?")) return;
    
    try {
        const response = await fetch("/essystore/api/admin/products/delete.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: id })
        });
        
        const result = await response.json();
        
        if (result.status === "success") {
            showNotification(result.message, "success");
            loadProducts();
        } else {
            showNotification(result.message, "error");
        }
    } catch (error) {
        console.error("Error deleting product:", error);
        showNotification("Error deleting product", "error");
    }
}

function resetForm() {
    document.getElementById("productForm").reset();
    document.getElementById("modalTitle").textContent = "Add Product";
    isEditing = false;
    editingId = null;
}

// Notification function
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
    notification.style.cssText = 'top: 80px; right: 20px; z-index: 9999; min-width: 300px; animation: slideIn 0.3s ease;';
    notification.innerHTML = message;
    
    if (!document.getElementById('notificationStyles')) {
        const style = document.createElement('style');
        style.id = 'notificationStyles';
        style.textContent = '@keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }';
        document.head.appendChild(style);
    }
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideIn 0.3s ease reverse';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
