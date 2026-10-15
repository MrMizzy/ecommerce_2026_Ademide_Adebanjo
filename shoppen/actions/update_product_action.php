<?php
require_once '../core/core.php';
require_once BASE_PATH . 'controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['product_id'] ?? 0;
    $cat = $_POST['product_cat'] ?? '';
    $brand = $_POST['product_brand'] ?? '';
    $title = clean($_POST['product_title'] ?? '');
    $price = $_POST['product_price'] ?? 0;
    $desc = clean($_POST['product_desc'] ?? '');
    $keywords = clean($_POST['product_keywords'] ?? '');
    
    // Establish the default state: keep the existing image
    $image_filename = $_POST['existing_image'] ?? 'placeholder.png';

    // Check if the user attempted to upload a new file
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        
        $allowed_mime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $allowed_ext  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        $file_ext = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
        $file_mime = $_FILES['product_image']['type'];
        
        // Validate the new file
        if (in_array($file_mime, $allowed_mime) && in_array($file_ext, $allowed_ext)) {
            
            $filename = uniqid('img_') . '.' . $file_ext;
            $target_path = BASE_PATH . 'images/products/' . $filename;
            
            // Move the file and overwrite the filename variable
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_path)) {
                $image_filename = $filename; 
            } else {
                // Failsafe: if the move fails, abort the entire update
                set_flash('error', 'Server failed to save the uploaded image.');
                redirect(BASE_URL . '/views/admin/product.php?edit_id=' . $id);
            }
        } else {
            // Failsafe: if validation fails, abort the entire update
            set_flash('error', 'Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.');
            redirect(BASE_URL . '/views/admin/product.php?edit_id=' . $id);
        }
    }

    // Proceed with the database update using either the new or existing filename
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