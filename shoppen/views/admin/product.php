<?php
require_once '../../core/core.php';
require_admin();

require_once  BASE_PATH . 'views/layout/header.php';
require_once BASE_PATH . 'controllers/ProductController.php';

$controller = new ProductController();
$categories = $controller->getAllCategories();
$brands = $controller->getAllBrands();
$products = $controller->getAllProducts();

$mode = 'Add';
$form_action = BASE_URL . '/actions/add_product_action.php';
$current_product = [
    'product_id' => '', 'product_title' => '', 'product_price' => '', 
    'product_desc' => '', 'product_keywords' => '', 'product_cat' => '', 
    'product_brand' => '', 'product_image' => 'placeholder.png'
];

if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $productToEdit = $controller->getProductById($edit_id);
    
    if ($productToEdit) {
        $mode = 'Edit';
        $form_action = BASE_URL . '/actions/update_product_action.php';
        $current_product = $productToEdit;
    }
}
?>

<main class="admin-container" style="padding: 20px;">
    <h2><?= $mode ?> Product</h2>
    
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

    <form action="<?= htmlspecialchars($form_action) ?>" method="POST" enctype="multipart/form-data" style="margin-bottom: 40px;">
        <?php if ($mode === 'Edit'): ?>
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($current_product['product_id']) ?>">
            <input type="hidden" name="existing_image" value="<?= htmlspecialchars($current_product['product_image']) ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="product_title">Product Title:</label>
            <input type="text" id="product_title" name="product_title" value="<?= htmlspecialchars($current_product['product_title']) ?>" required>
        </div>

        <div class="form-group">
            <label for="product_price">Price (GHS):</label>
            <input type="number" step="0.01" id="product_price" name="product_price" value="<?= htmlspecialchars($current_product['product_price']) ?>" required>
        </div>

        <div class="form-group">
            <label for="product_cat">Category:</label>
            <select name="product_cat" id="product_cat" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['cat_id'] ?>" <?= ($current_product['product_cat'] == $cat['cat_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['cat_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="product_brand">Brand:</label>
            <select name="product_brand" id="product_brand" required>
                <option value="">Select Brand</option>
                <?php foreach ($brands as $brand): ?>
                    <option value="<?= $brand['brand_id'] ?>" <?= ($current_product['product_brand'] == $brand['brand_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($brand['brand_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="product_desc">Description:</label>
            <textarea id="product_desc" name="product_desc" rows="4" style="width: 100%; padding: 0.6rem;"><?= htmlspecialchars($current_product['product_desc']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="product_keywords">Keywords (comma separated):</label>
            <input type="text" id="product_keywords" name="product_keywords" value="<?= htmlspecialchars($current_product['product_keywords']) ?>">
        </div>

        <div class="form-group">
            <label for="product_image">Product Image:</label>
            <?php if ($mode === 'Edit' && $current_product['product_image']): ?>
                <div style="margin-bottom: 10px;">
                    <img src="../../images/products/<?= htmlspecialchars($current_product['product_image']) ?>" alt="Current Image" style="max-width: 150px;">
                </div>
            <?php endif; ?>
            <input type="file" id="product_image" name="product_image" accept="image/png, image/jpeg, image/gif, image/webp" <?= $mode === 'Add' ? 'required' : '' ?>>
        </div>

        <button type="submit"><?= $mode ?> Product</button>
        <?php if ($mode === 'Edit'): ?>
            <a href="product.php" style="margin-left: 10px;">Cancel</a>
        <?php endif; ?>
    </form>
    
    <h3>Existing Products</h3>
    <table border="1" style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="padding: 10px;">Image</th>
                <th style="padding: 10px;">Title</th>
                <th style="padding: 10px;">Price</th>
                <th style="padding: 10px;">Category</th>
                <th style="padding: 10px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
                <tr><td colspan="5" style="padding: 10px;">No products found.</td></tr>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td style="padding: 10px;"><img src="../../images/products/<?= htmlspecialchars($p['product_image']) ?>" style="height: 40px; width: auto;"></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($p['product_title']) ?></td>
                        <td style="padding: 10px;">GHS <?= htmlspecialchars($p['product_price']) ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($p['cat_name']) ?></td>
                        <td style="padding: 10px;">
                            <a href="product.php?edit_id=<?= htmlspecialchars($p['product_id']) ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<?php require_once  BASE_PATH . 'views/layout/footer.php'; ?>