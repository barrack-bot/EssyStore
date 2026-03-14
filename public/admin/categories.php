<?php
$pageTitle = 'Categories Management';
$currentPage = 'categories';

// Get dashboard statistics
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/models/Category.php';

try {
    $database = new Database();
    $db = $database->connect();
    $category = new Category($db);
    
    $categories = $category->read();
    $totalCategories = count($categories);
    
} catch (Exception $e) {
    $categories = [];
    $totalCategories = 0;
}

$content = '
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="page-title">Categories Management</h2>
                <p class="page-subtitle">Manage your product categories</p>
            </div>
            <div class="col-md-6 text-md-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    <i class="fas fa-plus me-2"></i> Add Category
                </button>
            </div>
        </div>
    </div>
    
    <!-- Stats Card -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card simple">
                <div class="stat-icon-wrapper-simple bg-primary-simple">
                    <i class="fas fa-tags text-primary-simple"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number-simple">' . number_format($totalCategories) . '</div>
                    <div class="stat-label-simple">Total Categories</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card simple">
                <div class="stat-icon-wrapper-simple bg-success-simple">
                    <i class="fas fa-box text-success-simple"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number-simple">-</div>
                    <div class="stat-label-simple">Active Categories</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card simple">
                <div class="stat-icon-wrapper-simple bg-info-simple">
                    <i class="fas fa-folder-open text-info-simple"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number-simple">-</div>
                    <div class="stat-label-simple">Featured Categories</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Categories Table -->
    <div class="admin-card professional">
        <div class="card-header-custom">
            <h5 class="mb-0">
                <i class="fas fa-tags me-2"></i>All Categories
            </h5>
            <div class="d-flex gap-2">
                <input type="text" id="searchCategories" class="form-control form-control-sm" placeholder="Search categories..." style="width: 200px;">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-modern" id="categoriesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Products Count</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="categories-table">
                    ' . (empty($categories) ? 
                        '<tr><td colspan="6" class="text-center py-5">
                            <i class="fas fa-tags fa-3x mb-3 text-muted opacity-50"></i><br>
                            No categories found
                        </td></tr>' :
                        implode('', array_map(function($cat) {
                            return '
                            <tr>
                                <td><strong>' . $cat['id'] . '</strong></td>
                                <td><span class="badge bg-info">' . htmlspecialchars($cat['name']) . '</span></td>
                                <td>' . (isset($cat['description']) ? htmlspecialchars($cat['description']) : '-') . '</td>
                                <td>-</td>
                                <td>' . (isset($cat['created_at']) ? date('M d, Y', strtotime($cat['created_at'])) : '-') . '</td>
                                <td>
                                    <button class="btn btn-primary btn-action-sm me-1" onclick="editCategory(' . $cat['id'] . ')" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-action-sm" onclick="deleteCategory(' . $cat['id'] . ')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            ';
                        }, $categories)) . '
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Category Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalTitle">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryForm">
                        <input type="hidden" id="categoryId" name="id">
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="categoryDescription" name="description" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveCategory()">Save Category</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Categories Management JS -->
    <script src="../../public/assets/js/admin-categories.js"></script>
    
    <style>
        /* Additional styles for categories page */
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
        
        .btn-action-sm {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
            border-radius: var(--radius-small);
        }
    </style>
';

require_once __DIR__ . '/../../resources/views/admin/layouts/admin-layout.php';
?>
