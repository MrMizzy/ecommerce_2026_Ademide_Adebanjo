<?php
require_once '../core/core.php';
require_once BASE_PATH . 'views/layout/header.php';
require_once BASE_PATH . 'controllers/ProductController.php';

$query = $_GET['user_query'] ?? '';
$controller = new ProductController();
$products = $controller->searchProducts($query);
?>
<div class="page-wrapper">
    <main class="product-container" style="flex: 1;">
        <h2>Search Results for "<?= htmlspecialchars($query) ?>"</h2>
        
        <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
            <?php if (empty($products)): ?>
                <p>No products matched your search.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card" style="border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px; text-align: center;">
                        <img src="<?= BASE_URL ?>/images/products/<?= htmlspecialchars($product['product_image']) ?>" 
                             alt="<?= htmlspecialchars($product['product_title']) ?>" style="max-width: 100%; height: auto;">
                        <h3 style="font-size: 1.1rem; margin: 10px 0;"><?= htmlspecialchars($product['product_title']) ?></h3>
                        <p style="font-weight: bold; color: #2563eb;">GHS <?= htmlspecialchars($product['product_price']) ?></p>
                        
                        <div class="product-actions" style="margin-top: 15px; display: flex; justify-content: space-between;">
                            <a href="<?= BASE_URL ?>/views/single_product.php?pro_id=<?= htmlspecialchars($product['product_id']) ?>" style="padding: 5px 10px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px;">Details</a>
                            <a href="<?= BASE_URL ?>/actions/add_to_cart_action.php?add_cart=<?= htmlspecialchars($product['product_id']) ?>" style="padding: 5px 10px; background: #22c55e; color: white; border-radius: 4px;">Add to Cart</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>
<?php require_once BASE_PATH . 'views/layout/footer.php'; ?>