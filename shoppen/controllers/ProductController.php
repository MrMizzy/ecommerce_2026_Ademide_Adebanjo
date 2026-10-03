<?php
require_once dirname(__DIR__ ) ."/classes/ProductClass.php";

class ProductController {
    private $model;

    public function __construct() {
        $this->model = new ProductClass();
    }

    public function addBrand($name) {
        if (empty($name)) {
            return false;
        }
        return $this->model->addBrand($name);
    }

    public function getAllBrands() {
        return $this->model->getAllBrands();
    }

    public function getBrandById($id) {
        return $this->model->getBrandById($id);
    }

    public function updateBrand($id, $name) {
        if (empty($name) || !is_numeric($id) || $id <= 0) {
            return false;
        }
        return $this->model->updateBrand($id, $name);
    }

    // --- CATEGORY METHODS ---

    public function addCategory($name) {
        if (empty($name)) {
            return false;
        }
        return $this->model->addCategory($name);
    }

    // (Replace your placeholder version with this one)
    public function getAllCategories() {
        return $this->model->getAllCategories();
    }

    public function getCategoryById($id) {
        return $this->model->getCategoryById($id);
    }

    public function updateCategory($id, $name) {
        if (empty($name) || !is_numeric($id) || $id <= 0) {
            return false;
        }
        return $this->model->updateCategory($id, $name);
    }
    
    // Temporary placeholders to keep views/home.php working
    public function getFeaturedProducts() { return []; }
    public function getProductsByCategory($cat_id) { return []; }
    public function getProductsByBrand($brand_id) { return []; }    
}
?>