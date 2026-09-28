<?php
// Include layout elements
require_once BASE_PATH .'views/layout/header.php';
require_once BASE_PATH .'views/layout/sidebar.php';

// Instatiate ProductController
$productController = new ProductController();

// Determine which products to fetch
if (isset($_GET['category'])) {
    $products = $productController->getProductsByCategory($_GET['category']);
} elseif (isset($_GET['brand'])) {
    $products = $productController->getProductsByCategoryId($_GET['brand']);
}else {
    $products = $productController->getFeaturedProducts();
}
?>

<!-- Load the main content -->
<main class="product-container">
    <h2>Our Products</h2>
    <div class="product-grid">
        <?php if (empty($products)): ?>
            <p>No products found.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="images/products/<?= htmlspecialchars($product['product_image']); ?>"
                    alt="<?= htmlspecialchars($product['product_title']); ?>">

                    <h3><?= htmlspecialchars($product['product_title']); ?></h3>
                    <p>GHS <?= htmlspecialchars($product['product_price']) ?></p>

                    <div class="product-actions">
                        <a href="views/single_product.php?pro_id=<?= htmlspecialchars($product['product_id']) ?>">Details</a>
                        <a href="actions/add_to_cart_action.php?add_cart=<?= htmlspecialchars($product['product_id']) ?>">Add to Cart</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php
// Include footer layout
require_once BASE_PATH .'views/layout/footer.php';
?>