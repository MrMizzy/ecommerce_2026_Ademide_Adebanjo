<?php
// include controller if not present
require_once BASE_PATH .'controllers/ProductController.php';
$sidebarController = new ProductController();

$categories = $sidebarController->getAllCategories();
$brands = $sidebarController->getAllBrands();
?>

<aside class="sidebar">
    <div class="sidebar-section">
        <h3>Categories</h3>
        <ul>
            <?php if (empty($categories)): ?>
                <li>No categories available.</li>
            <?php else: ?>
                <?php foreach ($categories as $category): ?>
                    <li>
                        <a href="index.php?cat=<?= htmlspecialchars($category['cat_id']) ?>">
                            <?= htmlspecialchars($category['cat_name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>

    <div class="sidebar-section">
        <h3>Brands</h3>
        <ul>
            <?php if (empty($brands)): ?>
                <li>No brands available.</li>
            <?php else: ?>
                <?php foreach ($brands as $brand): ?>
                    <li>
                        <a href="index.php?brand=<?= htmlspecialchars($brand['brand_id']) ?>">
                            <?= htmlspecialchars($brand['brand_name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</aside>