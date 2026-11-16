<?php
require_once '../core/core.php';
require_once 'layout/header.php';
?>
<main class="admin-container" style="max-width: 600px; margin: 2rem auto; padding: 20px; text-align: center;">
    <h2 style="color: #ef4444;">Payment Failed</h2>
    <?php if ($error = get_flash('error')): ?>
        <p style="color: #ef4444; margin: 15px 0;"><?= htmlspecialchars($error) ?></p>
    <?php else: ?>
        <p style="margin: 15px 0;">We could not verify your payment. Your cart has not been charged.</p>
    <?php endif; ?>
    <div style="margin-top: 20px;">
        <a href="<?= BASE_URL ?>/views/payment.php" style="padding: 10px 20px; background: #2563eb; color: white; border-radius: 4px; text-decoration: none; margin-right: 10px;">Try Again</a>
        <a href="<?= BASE_URL ?>/views/cart.php" style="padding: 10px 20px; background: #64748b; color: white; border-radius: 4px; text-decoration: none;">Return to Cart</a>
    </div>
</main>
<?php require_once 'layout/footer.php'; ?>