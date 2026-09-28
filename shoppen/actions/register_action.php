<?php
require_once '../core/core.php';
require_once '../controllers/CustomerController.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(BASE_URL . '/views/register.php');
}

// Sanitize Inputs
$name = clean($_POST['name'] ?? '');
$email = filter_var(clean($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$pass = $_POST['password'] ?? '';
$country = clean($_POST['country'] ?? '');
$city = clean($_POST['city'] ?? '');
$contact = clean($_POST['contact'] ?? '');

// Validate field constraints
if (!$email || strlen($email) > 50) {
    set_flash('error', 'Invalid email address or exceeds 50 characters.');
}

if (empty($name) || empty($pass) || empty($country)) {
    set_flash('error', 'Please fill in all required fields.');
}

// Call Controller
$controller = new CustomerController();
$data = [
    'name' => $name, 'email' => $email, 'pass' => $pass,
    'country' => $country, 'city' => $city, 'contact' => $contact
];

$result = $controller->register($data);

