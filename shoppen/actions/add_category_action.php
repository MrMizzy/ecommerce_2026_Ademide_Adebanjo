<?php
require_once '../core/core.php';
require_once '../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cat_name = clean($_POST['cat_name'] ?? '');

    if (empty($cat_name)) {
        set_flash('error', 'Category name cannot be empty.');
        redirect(BASE_URL . '/views/admin/category.php');
    }

    $controller = new ProductController();
    $success = $controller->addCategory($cat_name);

    if ($success) {
        set_flash('success', 'Category added successfully.');
    } else {
        set_flash('error', 'Failed to add category. Please try again.');
    }
    
    redirect(BASE_URL . '/views/admin/category.php');
} else {
    redirect(BASE_URL . '/views/admin/category.php');
}