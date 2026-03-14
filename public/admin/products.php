<?php
$pageTitle = 'Products Management';
$currentPage = 'products';

// Get dashboard statistics
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/models/Product.php';
require_once __DIR__ . '/../../app/models/Category.php';

try {
    $database = new Database();
    $db = $database->connect();
    $product = new Product();
    $category = new Category($db);
    
    $products = $product->getAll();
    $categories = $category->read();
    $totalProducts = count($products);
    
} catch (Exception $e) {
    $products = [];
    $categories = [];
    $totalProducts = 0;
}

$content = '
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="page-title">Products Management</h2>
                <p class="page-subtitle">Manage your product catalog</p>
            </div>
            <div class="col-md-6 text-md-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                    <i class="fas fa-plus me-2"></i> Add Product
                </button>
            </div>
        </div>
    </div>
    
    <!-- Stats Card -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card simple">
                <div class="stat-icon-wrapper-simple bg-primary-simple">
                    <i class="fas fa-box text-primary-simple"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number-simple">' . number_format($totalProducts) . '</div>
                    <div class="stat-label-simple">Total Products</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card simple">
                <div class="stat-icon-wrapper-simple bg-success-simple">
                    <i class="fas fa-tags text-success-simple"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number-simple">' . number_format(count($categories)) . '</div>
                    <div class="stat-label-simple">Categories</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card simple">
                <div class="stat-icon-wrapper-simple bg-info-simple">
                    <i class="fas fa-check-circle text-info-simple"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number-simple">' . number_format(array_sum(array_column($products, 'stock_quantity'))) . '</div>
                    <div class="stat-label-simple">Total Stock</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products Table -->
    <div class="admin-card professional">
        <div class="card-header-custom">
            <h5 class="mb-0">
                <i class="fas fa-box me-2"></i>All Products
            </h5>
            <div class="d-flex gap-2">
                <input type="text" id="searchProducts" class="form-control form-control-sm" placeholder="Search products..." style="width: 200px;">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-modern" id="productsTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="products-table">
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <input type="hidden" id="productId" name="id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="productName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="productDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" step="0.01" class="form-control" id="productPrice" name="price" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-control" id="productCategory" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Clothing">Clothing</option>
                                    <option value="Sports">Sports</option>
                                    <option value="Home & Garden">Home & Garden</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image URL</label>
                            <input type="url" class="form-control" id="productImage" name="image" placeholder="https://example.com/image.jpg">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" id="productStock" name="stock_quantity" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveProduct()">Save Product</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products Management JS -->
    <script src="../../public/assets/js/admin-products.js"></script>
    
    <style>
        /* Additional styles for products page */
        .page-header {
            background: var(--bg-white);
            padding: 1.5rem;
            border-radius: var(--radius-medium);
            border: 2px solid var(--rose-light);
        }
        
        .page-title {
            font-family: "Playfair Display", serif;
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }
        
        .page-subtitle {
            color: var(--text-muted);
            margin: 0;
            font-size: 0.9rem;
        }
        
        .stat-card.simple {
            background: var(--bg-white);
            border-radius: var(--radius-medium);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow-soft);
            border: 2px solid var(--rose-light);
        }
        
        .stat-icon-wrapper-simple {
            width: 56px;
            height: 56px;
            border-radius: var(--radius-small);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .bg-primary-simple {
            background: var(--rose-light);
        }
        
        .text-primary-simple {
            color: var(--primary);
        }
        
        .bg-success-simple {
            background: #d4edda;
        }
        
        .text-success-simple {
            color: #28a745;
        }
        
        .bg-info-simple {
            background: #d1ecf1;
        }
        
        .text-info-simple {
            color: #17a2b8;
        }
        
        .stat-number-simple {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
        }
        
        .stat-label-simple {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
        
        .form-control-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border-radius: var(--radius-small);
        }
        
        .product-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: var(--radius-small);
        }
        
        .stock-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .stock-in {
            background: #d4edda;
            color: #155724;
        }
        
        .stock-low {
            background: #fff3cd;
            color: #856404;
        }
        
        .stock-out {
            background: #f8d7da;
            color: #721c24;
        }
        
        .btn-action-sm {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
            border-radius: var(--radius-small);
        }
    </style>
';

require_once __DIR__ . '/../../resources/views/admin/layouts/admin-layout.php';
?>
