<?php
require_once '../../core/core.php';
require_admin(); // Security check

require_once '../layout/header.php';
require_once '../../controllers/ProductController.php';

$controller = new ProductController();
$categories = $controller->getAllCategories();

// Default form variables for "Add Mode"
$mode = 'Add';
$form_action = '../../actions/add_category_action.php';
$current_cat_id = '';
$current_cat_name = '';

// Check if we are in "Edit Mode"
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $catToEdit = $controller->getCategoryById($edit_id);
    
    if ($catToEdit) {
        $mode = 'Edit';
        $form_action = '../../actions/update_category_action.php';
        $current_cat_id = $catToEdit['cat_id'];
        $current_cat_name = $catToEdit['cat_name'];
    }
}
?>

<main class="admin-container" style="padding: 20px;">
    <h2><?= $mode ?> Category</h2>

    <!-- Display Flash Messages -->
    <?php if ($error = get_flash('error')): ?>
        <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 15px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    
    <?php if ($success = get_flash('success')): ?>
        <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 15px;">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <!-- Dynamic Form -->
    <form action="<?= htmlspecialchars($form_action) ?>" method="POST" style="margin-bottom: 40px;">
        <?php if ($mode === 'Edit'): ?>
            <input type="hidden" name="cat_id" value="<?= htmlspecialchars($current_cat_id) ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="cat_name">Category Name:</label>
            <input type="text" id="cat_name" name="cat_name" value="<?= htmlspecialchars($current_cat_name) ?>" required>
        </div>
        <button type="submit"><?= $mode ?> Category</button>
        
        <?php if ($mode === 'Edit'): ?>
            <a href="category.php" style="margin-left: 10px;">Cancel</a>
        <?php endif; ?>
    </form>

    <!-- Categories Data Table -->
    <h3>Existing Categories</h3>
    <table border="1" style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="padding: 10px;">ID</th>
                <th style="padding: 10px;">Category Name</th>
                <th style="padding: 10px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($categories)): ?>
                <tr>
                    <td colspan="3" style="padding: 10px;">No categories found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td style="padding: 10px;"><?= htmlspecialchars($category['cat_id']) ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($category['cat_name']) ?></td>
                        <td style="padding: 10px;">
                            <a href="category.php?edit_id=<?= htmlspecialchars($category['cat_id']) ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<?php require_once '../layout/footer.php'; ?>