let categories = [];
let isEditing = false;
let editingId = null;

document.addEventListener("DOMContentLoaded", function() {
    const categoryModal = new bootstrap.Modal(document.getElementById("categoryModal"));
    window.categoryModal = categoryModal;
    loadCategories();
    
    // Search functionality
    document.getElementById('searchCategories')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filteredCategories = categories.filter(category => 
            category.name.toLowerCase().includes(searchTerm) ||
            category.description?.toLowerCase().includes(searchTerm)
        );
        renderCategories(filteredCategories);
    });
});

async function loadCategories() {
    try {
        const response = await fetch("../../api/admin/categories/list.php");
        const data = await response.json();
        
        if (data.status === "success") {
            categories = data.data;
            renderCategories();
        }
    } catch (error) {
        console.error("Error loading categories:", error);
        showNotification("Error loading categories", "error");
    }
}

function renderCategories(categoriesToRender = null) {
    const tbody = document.getElementById("categories-table");
    const categoriesList = categoriesToRender || categories;
    
    if (!tbody) return;
    
    if (categoriesList.length === 0) {
        tbody.innerHTML = "<tr><td colspan=\"6\" class=\"text-center py-5 text-muted\">No categories found</td></tr>";
        return;
    }
    
    tbody.innerHTML = categoriesList.map(category => `
        <tr>
            <td><strong>${category.id}</strong></td>
            <td><span class="badge bg-info">${category.name}</span></td>
            <td>${category.description ? (category.description.substring(0, 50) + (category.description.length > 50 ? '...' : '')) : '-'}</td>
            <td>-</td>
            <td>${category.created_at ? new Date(category.created_at).toLocaleDateString() : '-'}</td>
            <td>
                <button class="btn btn-primary btn-action-sm me-1" onclick="editCategory(${category.id})" title="Edit">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-danger btn-action-sm" onclick="deleteCategory(${category.id})" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join("");
}

function editCategory(id) {
    const category = categories.find(c => c.id === id);
    if (!category) return;
    
    isEditing = true;
    editingId = id;
    
    document.getElementById("categoryModalTitle").textContent = "Edit Category";
    document.getElementById("categoryId").value = id;
    document.getElementById("categoryName").value = category.name;
    document.getElementById("categoryDescription").value = category.description || "";
    
    window.categoryModal.show();
}

async function saveCategory() {
    const form = document.getElementById("categoryForm");
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    
    const url = isEditing ? "../../api/admin/categories/update.php" : "../../api/admin/categories/create.php";
    
    try {
        const response = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.status === "success") {
            showNotification(result.message, "success");
            window.categoryModal.hide();
            loadCategories();
            resetForm();
        } else {
            showNotification(result.message, "error");
        }
    } catch (error) {
        console.error("Error saving category:", error);
        showNotification("Error saving category: " + error.message, "error");
    }
}

async function deleteCategory(id) {
    if (!confirm("Are you sure you want to delete this category?")) return;
    
    try {
        const response = await fetch("../../api/admin/categories/delete.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: id })
        });
        
        const result = await response.json();
        
        if (result.status === "success") {
            showNotification(result.message, "success");
            loadCategories();
        } else {
            showNotification(result.message, "error");
        }
    } catch (error) {
        console.error("Error deleting category:", error);
        showNotification("Error deleting category", "error");
    }
}

function resetForm() {
    document.getElementById("categoryForm").reset();
    document.getElementById("categoryModalTitle").textContent = "Add Category";
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
