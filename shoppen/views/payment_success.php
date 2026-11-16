<?php
require_once '../core/core.php';
require_login();
require_once 'layout/header.php';

$order_id = $_GET['order_id'] ?? 0;
$orderRows = $cartController->getOrderById($order_id);

if (empty($orderRows) || $orderRows[0]['customer_id'] != $_SESSION['customer_id']) {
    redirect(BASE_URL . '/index.php');
}

$orderMeta = $orderRows[0];
$grandTotal = 0;
?>
<main class="admin-container" style="max-width: 800px; margin: 2rem auto; padding: 20px;">
    <div style="border-bottom: 2px solid #22c55e; padding-bottom: 10px; margin-bottom: 20px;">
        <h2 style="color: #22c55e; margin-bottom: 5px;">Payment Successful!</h2>
        <p>Thank you for your order, <strong><?= htmlspecialchars($orderMeta['customer_name']) ?></strong>.</p>
    </div>

    <div style="margin-bottom: 20px; background: #f8fafc; padding: 15px; border-radius: 6px;">
        <p><strong>Order ID:</strong> #<?= htmlspecialchars($orderMeta['order_id']) ?></p>
        <p><strong>Invoice Number:</strong> <?= htmlspecialchars($orderMeta['invoice_no']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($orderMeta['order_date']) ?></p>
        <p><strong>Status:</strong> <span style="text-transform: uppercase; color: #22c55e; font-weight: bold;"><?= htmlspecialchars($orderMeta['order_status']) ?></span></p>
    </div>

    <h3>Order Details</h3>
    <table border="1" style="width: 100%; text-align: left; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr>
                <th style="padding: 10px;">Product</th>
                <th style="padding: 10px;">Qty</th>
                <th style="padding: 10px;">Unit Price</th>
                <th style="padding: 10px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderRows as $row): 
                $sub = $row['qty'] * $row['product_price'];
                $grandTotal += $sub;
            ?>
                <tr>
                    <td style="padding: 10px;"><?= htmlspecialchars($row['product_title']) ?></td>
                    <td style="padding: 10px;"><?= (int)$row['qty'] ?></td>
                    <td style="padding: 10px;">GHS <?= number_format($row['product_price'], 2) ?></td>
                    <td style="padding: 10px;">GHS <?= number_format($sub, 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3 style="text-align: right;">Total Paid: GHS <?= number_format($grandTotal, 2) ?></h3>

    <div style="margin-top: 25px;">
        <a href="<?= BASE_URL ?>/index.php" style="padding: 10px 20px; background: #2563eb; color: white; border-radius: 4px; text-decoration: none;">Continue Shopping</a>
    </div>
</main>
<?php require_once 'layout/footer.php'; ?>