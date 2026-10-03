<?php
require_once '../core/core.php';
require_once '../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cat_id = $_POST['cat_id'] ?? 0;
    $cat_name = clean($_POST['cat_name'] ?? '');

    if (!filter_var($cat_id, FILTER_VALIDATE_INT) || $cat_id <= 0) {
        set_flash('error', 'Invalid category ID.');
        redirect(BASE_URL . '/views/admin/category.php');
    }

    if (empty($cat_name)) {
        set_flash('error', 'Category name cannot be empty.');
        redirect(BASE_URL . '/views/admin/category.php?edit_id=' . $cat_id);
    }

    $controller = new ProductController();
    $success = $controller->updateCategory($cat_id, $cat_name);

    if ($success) {
        set_flash('success', 'Category updated successfully.');
    } else {
        set_flash('error', 'Failed to update category. Please try again.');
    }
    
    redirect(BASE_URL . '/views/admin/category.php');
} else {
    redirect(BASE_URL . '/views/admin/category.php');
}