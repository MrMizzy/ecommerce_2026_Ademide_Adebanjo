<?php
require_once "../core/core.php";
require_once "../controllers/CustomerController.php";

// Only allow POST requests for login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    redirect(BASE_URL.'views/login.php');
}

// Sanitize input
$email = filter_var_array($_POST['email'], [FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL])[0] ?? '';
$pass = $_POST['password'] ?? ''; // Default to empty string if not set

if (empty($email) || empty($pass)) {
    set_flash('error','Please enter a valid email and/or password');
    redirect(BASE_URL.'views/login.php');
}

// Call the CustomerController to handle login
$customerController = new CustomerController();
$result = $customerController->login($email, $pass);

// Handle the result of the login attempt
if ($result['success']) {
    $user = $result['data'];

    // Set session variables for logged-in user
    $_SESSION['customer_id'] = $user['customer_id'];
    $_SESSION['customer_name'] = $user['customer_name'];
    $_SESSION['customer_email'] = $user['customer_email'];
    $_SESSION['user_role'] = $user['user_role'];

    // Redirect to home page or dashboard after successful login
    redirect(BASE_URL.'index.php');
} else {
    // Set error message and redirect back to login page
    set_flash('error', $result['error']);
    redirect(BASE_URL.'/views/login.php');
}