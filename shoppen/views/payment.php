<?php
require_once '../core/core.php';
require_login();
require_once 'layout/header.php';

// $cartController and $user_ip are already initialized in header.php
$cartItems = $cartController->getCartItems($user_ip);
$total     = $cartController->getCartTotal($user_ip);

if (empty($cartItems)) {
    set_flash('error', 'Your cart is empty.');
    redirect(BASE_URL . '/views/cart.php');
}
?>
<main class="admin-container" style="max-width: 800px; margin: 2rem auto; padding: 20px;">
    <h2>Checkout &amp; Payment</h2>

    <table border="1" style="width: 100%; text-align: left; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr>
                <th style="padding: 10px;">Product</th>
                <th style="padding: 10px;">Quantity</th>
                <th style="padding: 10px;">Unit Price</th>
                <th style="padding: 10px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td style="padding: 10px;"><?= htmlspecialchars($item['product_title']) ?></td>
                    <td style="padding: 10px;"><?= (int)$item['qty'] ?></td>
                    <td style="padding: 10px;">GHS <?= number_format($item['product_price'], 2) ?></td>
                    <td style="padding: 10px;">GHS <?= number_format($item['product_price'] * $item['qty'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
        <h3>Total Amount: GHS <?= number_format($total, 2) ?></h3>
        <button type="button" onclick="payWithPaystack()" style="padding: 12px 24px; background: #22c55e; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; font-weight: bold;">
            Pay Now with Paystack
        </button>
    </div>
</main>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
function payWithPaystack() {
    var handler = PaystackPop.setup({
        key: 'pk_test_8b960bc2e22e5cc25f0ae9ac19b32fab872cb52e', // Paystack public test key
        email: '<?= htmlspecialchars($_SESSION["customer_email"] ?? "", ENT_QUOTES) ?>',
        amount: <?= (int)round($total * 100) ?>, // Amount in pesewas
        currency: 'GHS',
        callback: function(response) {
            window.location.href = '<?= BASE_URL ?>/actions/process_payment_action.php?ref=' + encodeURIComponent(response.reference);
        },
        onClose: function() {
            alert('Payment cancelled.');
        }
    });
    handler.openIframe();
}
</script>

<?php require_once 'layout/footer.php'; ?>