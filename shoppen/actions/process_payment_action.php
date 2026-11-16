<?php
require_once '../core/core.php';
require_once BASE_PATH . 'controllers/CartController.php';

require_login();

$reference = $_GET['ref'] ?? '';
if (empty($reference)) {
    set_flash('error', 'No payment reference provided.');
    redirect(BASE_URL . '/views/payment_failed.php');
}

// Verify transaction server-side via Paystack API
$url = 'https://api.paystack.co/transaction/verify/' . rawurlencode($reference);
$secret_key = 'sk_test_43b7ec8a6f9e11bbe26d2141f94c2f9ec7b90965'; // Paystack secret test key

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $secret_key,
    'Cache-Control: no-cache',
]);

// Localhost XAMPP often lacks an updated CA bundle; disable SSL peer check only on localhost
if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
}

$response = curl_exec($ch);
$curl_err = curl_error($ch);
curl_close($ch);

if ($curl_err) {
    log_err("Paystack cURL Error: " . $curl_err);
    set_flash('error', 'Could not connect to payment gateway for verification.');
    redirect(BASE_URL . '/views/payment_failed.php');
}

$result = json_decode($response, true);

// Confirm Paystack API call succeeded and transaction status is 'success'
if (isset($result['status']) && $result['status'] === true && $result['data']['status'] === 'success') {
    $customer_id = $_SESSION['customer_id'];
    $ip          = get_ip();
    $controller  = new CartController();
    
    // Paystack returns amount in pesewas; convert back to GHS
    $amount_paid = $result['data']['amount'] / 100;
    $currency    = $result['data']['currency'] ?? 'GHS';

    $order_id = $controller->processPayment($customer_id, $ip, $reference, $amount_paid, $currency);

    if ($order_id) {
        // Optional confirmation email (suppress warnings if local mail server isn't configured)
        $to      = $_SESSION['customer_email'];
        $subject = "Order Confirmation - Shoppn (#" . $order_id . ")";
        $message = "Thank you for your purchase of GHS " . number_format($amount_paid, 2) . ". Your Order ID is #" . $order_id . ".";
        $headers = "From: no-reply@shoppn.com";
        @mail($to, $subject, $message, $headers);

        redirect(BASE_URL . '/views/payment_success.php?order_id=' . $order_id);
    } else {
        set_flash('error', 'Payment succeeded, but saving the order failed.');
        redirect(BASE_URL . '/views/payment_failed.php');
    }
} else {
    $msg = $result['message'] ?? 'Payment verification failed.';
    set_flash('error', $msg);
    redirect(BASE_URL . '/views/payment_failed.php');
}