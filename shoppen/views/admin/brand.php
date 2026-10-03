<?php
// views/admin/brand.php
require_once '../../core/core.php';
require_admin(); // Security check MUST be first

require_once '../layout/header.php';
require_once '../../controllers/ProductController.php';

$controller = new ProductController();
$brands = $controller->getAllBrands();

// Default form variables for "Add Mode"
$mode = 'Add';
$form_action = '../../actions/add_brand_action.php';
$current_brand_id = '';
$current_brand_name = '';

// Check if we are in "Edit Mode"
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $brandToEdit = $controller->getBrandById($edit_id);
    
    if ($brandToEdit) {
        $mode = 'Edit';
        $form_action = '../../actions/update_brand_action.php';
        $current_brand_id = $brandToEdit['brand_id'];
        $current_brand_name = $brandToEdit['brand_name'];
    }
}
?>

<main class="admin-container" style="padding: 20px;">
    <h2><?= $mode ?> Brand</h2>

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

    <!-- Dynamic Form (Handles both Add and Edit) -->
    <form action="<?= htmlspecialchars($form_action) ?>" method="POST" style="margin-bottom: 40px;">
        
        <!-- Hidden field needed for the update action -->
        <?php if ($mode === 'Edit'): ?>
            <input type="hidden" name="brand_id" value="<?= htmlspecialchars($current_brand_id) ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="brand_name">Brand Name:</label>
            <input type="text" id="brand_name" name="brand_name" value="<?= htmlspecialchars($current_brand_name) ?>" required>
        </div>
        <button type="submit"><?= $mode ?> Brand</button>
        
        <?php if ($mode === 'Edit'): ?>
            <a href="brand.php" style="margin-left: 10px;">Cancel</a>
        <?php endif; ?>
    </form>

    <!-- Brands Data Table -->
    <h3>Existing Brands</h3>
    <table border="1" style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="padding: 10px;">ID</th>
                <th style="padding: 10px;">Brand Name</th>
                <th style="padding: 10px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($brands)): ?>
                <tr>
                    <td colspan="3" style="padding: 10px;">No brands found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($brands as $brand): ?>
                    <tr>
                        <td style="padding: 10px;"><?= htmlspecialchars($brand['brand_id']) ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($brand['brand_name']) ?></td>
                        <td style="padding: 10px;">
                            <a href="brand.php?edit_id=<?= htmlspecialchars($brand['brand_id']) ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<?php require_once '../layout/footer.php'; ?>