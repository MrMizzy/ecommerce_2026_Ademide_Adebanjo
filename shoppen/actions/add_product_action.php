<?php
require_once '../core/core.php';
require_once '../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cat = $_POST['product_cat'] ?? '';
    $brand = $_POST['product_brand'] ?? '';
    $title = clean($_POST['product_title'] ?? '');
    $price = $_POST['product_price'] ?? 0;
    $desc = clean($_POST['product_desc'] ?? '');
    $keywords = clean($_POST['product_keywords'] ?? '');

    $image_filename = 'placeholder.png'; // Default fallback

    // Handle Image Upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        
        $allowed_mime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $allowed_ext  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        // Extract the extension from the uploaded file and convert to lowercase
        $file_ext = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
        $file_mime = $_FILES['product_image']['type'];
        
        // Validate BOTH the MIME type and the physical extension
        if (in_array($file_mime, $allowed_mime) && in_array($file_ext, $allowed_ext)) {
            
            // Generate a completely new name, discarding the user's original filename
            $filename = uniqid('img_') . '.' . $file_ext;
            $target_path = BASE_PATH . 'images/products/' . $filename;
            
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_path)) {
                $image_filename = $filename;
            }
        } else {
            set_flash('error', 'Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.');
            redirect(BASE_URL . '/views/admin/product.php');
        }
    }

    $controller = new ProductController();
    $success = $controller->addProduct($cat, $brand, $title, $price, $desc, $image_filename, $keywords);

    if ($success) {
        set_flash('success', 'Product added successfully.');
    } else {
        set_flash('error', 'Failed to add product. Please try again.');
    }
    
    redirect(BASE_URL . '/views/admin/product.php');
} else {
    redirect(BASE_URL . '/views/admin/product.php');
}