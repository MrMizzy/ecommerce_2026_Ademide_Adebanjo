<?php
require_once '../core/core.php';
require_once '../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['product_id'] ?? 0;
    $cat = $_POST['product_cat'] ?? '';
    $brand = $_POST['product_brand'] ?? '';
    $title = clean($_POST['product_title'] ?? '');
    $price = $_POST['product_price'] ?? 0;
    $desc = clean($_POST['product_desc'] ?? '');
    $keywords = clean($_POST['product_keywords'] ?? '');
    
    // Grab existing image filename from hidden field
    $image_filename = $_POST['existing_image'] ?? 'placeholder.png';

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        
        if (in_array($_FILES['product_image']['type'], $allowed)) {
            $filename = uniqid() . '_' . basename($_FILES['product_image']['name']);
            $target_path = BASE_URL . '/images/products/' . $filename;
            
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_path)) {
                $image_filename = $filename; // Override with new image
            }
        } else {
            set_flash('error', 'Invalid file type.');
            redirect(BASE_URL . '/views/admin/product.php?edit_id=' . $id);
        }
    }

    $controller = new ProductController();
    $success = $controller->updateProduct($id, $cat, $brand, $title, $price, $desc, $image_filename, $keywords);

    if ($success) {
        set_flash('success', 'Product updated successfully.');
    } else {
        set_flash('error', 'Failed to update product.');
    }
    
    redirect(BASE_URL . '/views/admin/product.php');
} else {
    redirect(BASE_URL . '/views/admin/product.php');
}