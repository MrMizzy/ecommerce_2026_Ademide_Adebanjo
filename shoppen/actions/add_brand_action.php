<?php
require_once '../core/core.php';
require_once '../controllers/ProductController.php';

// Security Check: Only admins can perform this action
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_name = clean($_POST['brand_name'] ?? '');

    if (empty($brand_name)) {
        set_flash('error', 'Brand name cannot be empty.');
        redirect(BASE_URL . '/views/admin/brand.php');
    }

    $controller = new ProductController();
    $success = $controller->addBrand($brand_name);

    if ($success) {
        set_flash('success', 'Brand added successfully.');
    } else {
        set_flash('error', 'Failed to add brand. Please try again.');
    }
    
    redirect(BASE_URL . '/views/admin/brand.php');
} else {
    redirect(BASE_URL . '/views/admin/brand.php');
}
