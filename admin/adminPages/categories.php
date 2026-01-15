<?php 
require __DIR__."/../../config/config.php";
require __DIR__."/../../includes/dashboardHeader.php";
$allCategories=getCategories($connection);
?>

<div id="content">
    
    <div class="top-navbar">
        <div class="nav-left">
            <button type="button" id="sidebarCollapse" class="menu-btn">
                <i class="fas fa-bars"></i>
            </button>
            <div class="page-title">Manage Categories</div>
        </div>
        <div class="nav-right">
            <div class="profile-preview">
                <img src="https://via.placeholder.com/40" alt="Admin">
                <span>Admin</span>
            </div>
        </div>
    </div>

    <div class="form-container add-cat-section">
        <h4 class="form-title">Add New Category</h4>
        <form class="inline-form" action="/admin/handlers/addCategories.php" method="post">
            <div class="input-wrapper">
                <input type="text" name="category" placeholder="Enter Category Name">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add
            </button>
        </form>
    </div>

    <div class="list-panel">
        <div class="panel-header">
            <h4>Existing Categories</h4>
        </div>
        
        <div class="category-list">
            <?php foreach ($allCategories as $category): ?>
    <div class="category-item">
        <div class="cat-content">
            <span class="cat-name"><?= htmlspecialchars($category->title) ?></span>
            <span class="badge warning"><?= getCount($connection, $category->id) ?> Books</span>
        </div>
        <div class="action-buttons">
            <form action="/admin/handlers/deleteCategory.php" method="post" class="bookform">
                <input type="hidden" name="id" value="<?= $category->id ?>">
                <button class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>

        </div>
    </div>

</div> </div> <script src="/assests/js/admin.js"></script>
</body>
</html>