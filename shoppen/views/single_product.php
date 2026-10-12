<?php
require_once BASE_PATH . 'core/core.php';
require_once BASE_PATH . 'views/layout/header.php';
require_once BASE_PATH . 'controllers/ProductController.php';

if (!isset($_GET['pro_id']) || !is_numeric($_GET['pro_id'])) {
    redirect(BASE_URL . '/index.php');
}

$controller = new ProductController();
$product = $controller->getProductById($_GET['pro_id']);

if (!$product) {
    redirect(BASE_URL . '/index.php');
}
?>
<main class="product-detail-container" style="max-width: 1000px; margin: 2rem auto; padding: 20px; display: flex; gap: 40px;">
    <div class="product-image" style="flex: 1;">
        <img src="<?= BASE_URL ?>/images/products/<?= htmlspecialchars($product['product_image']) ?>" alt="<?= htmlspecialchars($product['product_title']) ?>" style="width: 100%; border-radius: 8px; border: 1px solid #e2e8f0;">
    </div>
    <div class="product-info" style="flex: 1;">
        <h2><?= htmlspecialchars($product['product_title']) ?></h2>
        <p style="color: #64748b; margin-bottom: 15px;">
            Category: <?= htmlspecialchars($product['cat_name']) ?> | Brand: <?= htmlspecialchars($product['brand_name']) ?>
        </p>
        <h3 style="color: #2563eb; font-size: 1.5rem; margin-bottom: 20px;">GHS <?= htmlspecialchars($product['product_price']) ?></h3>
        
        <div class="description" style="margin-bottom: 25px; line-height: 1.6;">
            <h4>Description</h4>
            <p><?= nl2br(htmlspecialchars($product['product_desc'])) ?></p>
        </div>
        
        <a href="<?= BASE_URL ?>/actions/add_to_cart_action.php?add_cart=<?= htmlspecialchars($product['product_id']) ?>" 
           style="display: inline-block; padding: 12px 24px; background: #22c55e; color: white; border-radius: 4px; font-weight: bold;">
           Add to Cart
        </a>
    </div>
</main>
<?php require_once  BASE_PATH . 'views/layout/footer.php'; ?>