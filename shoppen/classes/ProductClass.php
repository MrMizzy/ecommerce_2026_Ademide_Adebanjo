<?php
require_once dirname(__DIR__ ). '/core/db_class.php';

class ProductClass extends Database {
    
    // Add a new brand
    public function addBrand($name) {
        $stmt = $this->conn->prepare("INSERT INTO brands (brand_name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $success = $stmt->execute();
        $stmt->close();
        
        return $success;
    }

    // Get all brands
    public function getAllBrands() {
        $sql = "SELECT * FROM brands ORDER BY brand_name ASC";
        $result = $this->conn->query($sql);
        
        $brands = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $brands[] = $row;
            }
        }
        return $brands;
    }

    // Fetch a single brand by its ID
    public function getBrandById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM brands WHERE brand_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row ? $row : false;
    }

    // Update an existing brand
    public function updateBrand($id, $name) {
        $stmt = $this->conn->prepare("UPDATE brands SET brand_name = ? WHERE brand_id = ?");
        $stmt->bind_param("si", $name, $id);
        $success = $stmt->execute();
        $stmt->close();
        
        return $success;
    }

    // --- CATEGORY METHODS ---

    // Add a new category
    public function addCategory($name) {
        $stmt = $this->conn->prepare("INSERT INTO categories (cat_name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $success = $stmt->execute();
        $stmt->close();
        
        return $success;
    }

    // Get all categories
    public function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY cat_name ASC";
        $result = $this->conn->query($sql);
        
        $categories = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        return $categories;
    }

    // Fetch a single category by its ID
    public function getCategoryById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE cat_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        return $row ? $row : false;
    }

    // Update an existing category
    public function updateCategory($id, $name) {
        $stmt = $this->conn->prepare("UPDATE categories SET cat_name = ? WHERE cat_id = ?");
        $stmt->bind_param("si", $name, $id);
        $success = $stmt->execute();
        $stmt->close();
        
        return $success;
    }
}