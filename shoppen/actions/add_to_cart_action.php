<?php
require_once '../core/core.php';
require_once BASE_PATH . 'controllers/CartController.php';

if (isset($_GET['add_cart'])) {
    $product_id = $_GET['add_cart'];
    $ip = get_ip();
    $qty = 1; // Default quantity for new additions

    if (!filter_var($product_id, FILTER_VALIDATE_INT)) {
        redirect(BASE_URL . '/index.php');
    }

    $controller = new CartController();
    
    // Check for duplicates
    if ($controller->isInCart($product_id, $ip)) {
        set_flash('error', 'This item is already in your cart. Go to cart to update quantity.');
    } else {
        $success = $controller->addToCart($product_id, $qty, $ip);
        if ($success) {
            set_flash('success', 'Product added to cart.');
        } else {
            set_flash('error', 'Failed to add product to cart.');
        }
    }
    
    // Send user back to the exact page they clicked the link from
    $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL . '/index.php';
    redirect($referer);
} else {
    redirect(BASE_URL . '/index.php');
}