<?php
require_once dirname(__DIR__) . '/core/db_class.php';

class CartClass extends Database {
    // Check if an item already exists in the cart for this IP
    public function isInCart($product_id, $ip) {
        $stmt = $this->conn->prepare("SELECT * FROM cart WHERE p_id = ? AND ip_add = ?");
        $stmt->bind_param("is", $product_id, $ip);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    // Add a new item to the cart
    public function addToCart($product_id, $qty, $ip, $customer_id = null) {
        $stmt = $this->conn->prepare("INSERT INTO cart (p_id, ip_add, qty) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $product_id, $ip, $qty);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Get all cart items with product details
    public function getCartItems($ip) {
        $stmt = $this->conn->prepare("SELECT cart.*, products.product_title, products.product_price, products.product_image FROM cart JOIN products ON cart.p_id = products.product_id WHERE cart.ip_add = ?");
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        $stmt->close();
        return $items;
    }

    // Get the total number of distinct items in the cart
    public function getCartCount($ip) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM cart WHERE ip_add = ?");
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['count'] ?? 0;
    }

    // Calculate the total price of all items in the cart
    public function getCartTotal($ip) {
        $items = $this->getCartItems($ip);
        $total = 0;
        foreach ($items as $item) {
            $total += ($item['qty'] * $item['product_price']);
        }
        return $total;
    }

    // Remove a specific product from the cart
    public function removeFromCart($product_id, $ip) {
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE p_id = ? AND ip_add = ?");
        $stmt->bind_param("is", $product_id, $ip);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Update the quantity of a specific product
    public function updateQty($product_id, $new_qty, $ip) {
        // Double-check the quantity at the database layer
        if ($new_qty < 1) {
            return false;
        }
        $stmt = $this->conn->prepare("UPDATE cart SET qty = ? WHERE p_id = ? AND ip_add = ?");
        $stmt->bind_param("iis", $new_qty, $product_id, $ip);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}