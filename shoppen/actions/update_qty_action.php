<?php
require_once '../core/core.php';
require_once BASE_PATH . 'controllers/CartController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = get_ip();
    $controller = new CartController();
    
    $product_ids = $_POST['update'] ?? [];
    $quantities = $_POST['qty'] ?? [];
    
    // Ensure both arrays exist and have the same number of items
    if (!empty($product_ids) && count($product_ids) === count($quantities)) {
        for ($i = 0; $i < count($product_ids); $i++) {
            $p_id = $product_ids[$i];
            $qty = $quantities[$i];
            
            // Only update if the quantity is a positive number
            if ($qty >= 1) {
                $controller->updateQty($p_id, $qty, $ip);
            }
        }
        set_flash('success', 'Cart quantities updated.');
    } else {
        set_flash('error', 'Failed to update quantities.');
    }
    
    redirect(BASE_URL . '/views/cart.php');
} else {
    redirect(BASE_URL . '/views/cart.php');
}