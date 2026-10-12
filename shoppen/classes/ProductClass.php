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

    // Add a new product
    public function addProduct($cat, $brand, $title, $price, $desc, $image_filename, $keywords) {
        $stmt = $this->conn->prepare("INSERT INTO products (product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdsss", $cat, $brand, $title, $price, $desc, $image_filename, $keywords);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Update an existing product
    public function updateProduct($id, $cat, $brand, $title, $price, $desc, $image_filename, $keywords) {
        $stmt = $this->conn->prepare("UPDATE products SET product_cat = ?, product_brand = ?, product_title = ?, product_price = ?, product_desc = ?, product_image = ?, product_keywords = ? WHERE product_id = ?");
        $stmt->bind_param("iisdsssi", $cat, $brand, $title, $price, $desc, $image_filename, $keywords, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Fetch a single product by its ID with JOINs
    public function getProductById($id) {
        $stmt = $this->conn->prepare("SELECT p.*, c.cat_name, b.brand_name FROM products p JOIN categories c ON p.product_cat = c.cat_id JOIN brands b ON p.product_brand = b.brand_id WHERE p.product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row ? $row : false;
    }
    
    // Fetch all products for the admin table
    public function getAllProducts() {
        $sql = "SELECT p.*, c.cat_name, b.brand_name FROM products p JOIN categories c ON p.product_cat = c.cat_id JOIN brands b ON p.product_brand = b.brand_id ORDER BY p.product_id DESC";
        $result = $this->conn->query($sql);
        $products = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    // Fetch random featured products for the home page
    public function getFeaturedProducts($limit = 6) {
        $stmt = $this->conn->prepare("SELECT * FROM products ORDER BY RAND() LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    // Fetch products by category ID
    public function getProductsByCategory($cat_id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE product_cat = ?");
        $stmt->bind_param("i", $cat_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    // Fetch products by brand ID
    public function getProductsByBrand($brand_id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE product_brand = ?");
        $stmt->bind_param("i", $brand_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    // Search products by title or keywords
    public function searchProducts($query) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE product_title LIKE ? OR product_keywords LIKE ?");
        $searchTerm = '%' . $query . '%';
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }
}