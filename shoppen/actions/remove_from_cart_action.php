<?php
require_once '../core/core.php';
require_once BASE_PATH . 'controllers/CartController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = get_ip();
    $controller = new CartController();
    
    // Capture the array of checked product IDs
    $remove_ids = $_POST['remove'] ?? [];
    
    if (!empty($remove_ids)) {
        foreach ($remove_ids as $p_id) {
            $controller->removeFromCart($p_id, $ip);
        }
        set_flash('success', 'Selected items removed from cart.');
    } else {
        set_flash('error', 'No items were selected for removal.');
    }
    
    redirect(BASE_URL . '/views/cart.php');
} else {
    redirect(BASE_URL . '/views/cart.php');
}