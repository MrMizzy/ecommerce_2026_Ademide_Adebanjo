<?php
// views/home.php
require_once BASE_PATH .'views/layout/header.php';
require_once BASE_PATH .'controllers/ProductController.php';

$productController = new ProductController();

// Determine which products to fetch
if (isset($_GET['category'])) {
    $products = $productController->getProductsByCategory($_GET['category']);
} elseif (isset($_GET['brand'])) {
    $products = $productController->getProductsByBrand($_GET['brand']);
} else {
    $products = $productController->getFeaturedProducts();
}
?>

<div class="page-wrapper">
    
    <?php 
    // Include sidebar inside the wrapper so it sits on the left
    require_once BASE_PATH .'views/layout/sidebar.php'; 
    ?>

    <!-- Add flex: 1 so the main content fills the right side -->
    <main class="product-container" style="flex: 1;">
        <h2>Our Products</h2>
        
        <div class="product-grid">
            <?php if (empty($products)): ?>
                <p>No products found.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="<?= BASE_URL ?>/images/products/<?= htmlspecialchars($product['product_image']); ?>"
                        alt="<?= htmlspecialchars($product['product_title']); ?>">
                        <h3><?= htmlspecialchars($product['product_title']); ?></h3>
                        <p>GHS <?= htmlspecialchars($product['product_price']) ?></p>
                        
                        <div class="product-actions">
                            <a href="<?= BASE_URL ?>/views/single_product.php?pro_id=<?= htmlspecialchars($product['product_id']) ?>">Details</a>
                            <a href="<?= BASE_URL ?>/actions/add_to_cart_action.php?add_cart=<?= htmlspecialchars($product['product_id']) ?>">Add to Cart</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
    
</div>

<?php require_once BASE_PATH .'views/layout/footer.php'; ?>