<?php
require_once '../core/core.php';
require_once '../controllers/ProductController.php';

// Security check
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_id = $_POST['brand_id'] ?? 0;
    $brand_name = clean($_POST['brand_name'] ?? '');

    // Validate ID is a positive integer
    if (!filter_var($brand_id, FILTER_VALIDATE_INT) || $brand_id <= 0) {
        set_flash('error', 'Invalid brand ID.');
        redirect(BASE_URL . '/views/admin/brand.php');
    }

    if (empty($brand_name)) {
        set_flash('error', 'Brand name cannot be empty.');
        redirect(BASE_URL . '/views/admin/brand.php?edit_id=' . $brand_id);
    }

    $controller = new ProductController();
    $success = $controller->updateBrand($brand_id, $brand_name);

    if ($success) {
        set_flash('success', 'Brand updated successfully.');
    } else {
        set_flash('error', 'Failed to update brand. Please try again.');
    }
    
    redirect(BASE_URL . '/views/admin/brand.php');
} else {
    redirect(BASE_URL . '/views/admin/brand.php');
}
?>