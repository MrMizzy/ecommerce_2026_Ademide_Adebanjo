<?php
require_once '../core/core.php';

// Ensure customer is logged in before paying
require_login();

require_once BASE_PATH . 'controllers/CartController.php';
$cartController = new CartController();
$ip = get_ip();

if ($cartController->getCartCount($ip) === 0) {
    set_flash('error', 'Your cart is empty.');
    redirect(BASE_URL . '/views/cart.php');
}

// Forward logged-in customer with active cart items to payment page
redirect(BASE_URL . '/views/payment.php');