<?php
require_once '../core/core.php';
require_once BASE_PATH . '/views/layout/header.php';
// CartController is already instantiated in the header, so we can reuse $cartController and $user_ip

$cartItems = $cartController->getCartItems($user_ip);
$totalPrice = $cartController->getCartTotal($user_ip);
?>
<main class="cart-container" style="max-width: 1000px; margin: 2rem auto; padding: 20px;">
    <h2>Your Shopping Cart</h2>

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

    <?php if (empty($cartItems)): ?>
        <p>Your cart is currently empty.</p>
        <a href="<?= BASE_URL ?>/index.php" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: #2563eb; color: white; border-radius: 4px;">Continue Shopping</a>
    <?php else: ?>
        <form action="<?= BASE_URL ?>/actions/update_qty_action.php" method="POST">
            <table border="1" style="width: 100%; text-align: left; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th style="padding: 10px;">Product</th>
                        <th style="padding: 10px;">Name</th>
                        <th style="padding: 10px;">Unit Price</th>
                        <th style="padding: 10px;">Quantity</th>
                        <th style="padding: 10px;">Subtotal</th>
                        <th style="padding: 10px;">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td style="padding: 10px;">
                                <img src="<?= BASE_URL ?>/images/products/<?= htmlspecialchars($item['product_image']) ?>" style="height: 50px; width: auto;" alt="Product">
                            </td>
                            <td style="padding: 10px;"><?= htmlspecialchars($item['product_title']) ?></td>
                            <td style="padding: 10px;">GHS <?= number_format($item['product_price'], 2) ?></td>
                            <td style="padding: 10px;">
                                <input type="hidden" name="update[]" value="<?= htmlspecialchars($item['p_id']) ?>">
                                <input type="number" name="qty[]" value="<?= htmlspecialchars($item['qty']) ?>" min="1" style="width: 60px; padding: 5px;">
                            </td>
                            <td style="padding: 10px;">GHS <?= number_format($item['product_price'] * $item['qty'], 2) ?></td>
                            <td style="padding: 10px;">
                                <input type="checkbox" name="remove[]" value="<?= htmlspecialchars($item['p_id']) ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 2px solid #e2e8f0; padding-top: 20px;">
                <h3 style="margin: 0;">Total: GHS <?= number_format($totalPrice, 2) ?></h3>
                <div>
                    <!-- This submits the main form to update_qty_action -->
                    <button type="submit" style="padding: 10px 20px; background: #64748b; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;">Update Cart</button>
                    <!-- Form action overridden by form action for the remove button -->
                    <button type="submit" formaction="<?= BASE_URL ?>/actions/remove_from_cart_action.php" style="padding: 10px 20px; background: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer;">Remove Selected</button>
                </div>
            </div>
        </form>

        <div style="margin-top: 30px; text-align: right;">
            <a href="<?= BASE_URL ?>/index.php" style="padding: 12px 24px; background: #f8fafc; border: 1px solid #cbd5e1; color: #1e293b; border-radius: 4px; text-decoration: none; margin-right: 10px;">Continue Shopping</a>
            <a href="<?= BASE_URL ?>/views/checkout.php" style="padding: 12px 24px; background: #22c55e; color: white; border-radius: 4px; text-decoration: none; font-weight: bold;">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</main>
<?php require_once BASE_PATH . '/views/layout/footer.php'; ?>