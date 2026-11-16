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

    // Process order, order details, payment record, and empty cart inside a DB transaction
    public function processPayment($customer_id, $ip, $reference, $amount, $currency = 'GHS') {
        $this->conn->begin_transaction();

        try {
            // Fetch current cart items before clearing
            $cart_items = $this->getCartItems($ip);
            if (empty($cart_items)) {
                throw new Exception("Cart is empty.");
            }

            // Generate invoice number & date
            $invoice_no = mt_rand(100000, 999999);
            $order_date = date('Y-m-d');
            $order_status = 'paid';

            // INSERT into orders table (matching shoppn_empty.sql schema)
            $stmtOrder = $this->conn->prepare(
                "INSERT INTO orders (customer_id, invoice_no, order_date, order_status) VALUES (?, ?, ?, ?)"
            );
            $stmtOrder->bind_param("iiss", $customer_id, $invoice_no, $order_date, $order_status);
            if (!$stmtOrder->execute()) {
                throw new Exception("Failed to insert order.");
            }
            $order_id = $stmtOrder->insert_id;
            $stmtOrder->close();

            // Copy cart rows into orderdetails table
            $stmtDetails = $this->conn->prepare(
                "INSERT INTO orderdetails (order_id, product_id, qty) VALUES (?, ?, ?)"
            );
            foreach ($cart_items as $item) {
                $p_id = $item['p_id'];
                $qty  = $item['qty'];
                $stmtDetails->bind_param("iii", $order_id, $p_id, $qty);
                if (!$stmtDetails->execute()) {
                    throw new Exception("Failed to insert order details.");
                }
            }
            $stmtDetails->close();

            // Record payment in payment table
            $stmtPay = $this->conn->prepare(
                "INSERT INTO payment (amt, customer_id, order_id, currency, payment_date) VALUES (?, ?, ?, ?, ?)"
            );
            $stmtPay->bind_param("diiss", $amount, $customer_id, $order_id, $currency, $order_date);
            if (!$stmtPay->execute()) {
                throw new Exception("Failed to record payment.");
            }
            $stmtPay->close();

            // DELETE from cart WHERE ip_add = ?
            $stmtClear = $this->conn->prepare("DELETE FROM cart WHERE ip_add = ?");
            $stmtClear->bind_param("s", $ip);
            if (!$stmtClear->execute()) {
                throw new Exception("Failed to clear cart.");
            }
            $stmtClear->close();

            // Commit transaction
            $this->conn->commit();
            return $order_id;

        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Payment Transaction Error: " . $e->getMessage());
            return false;
        }
    }

    // Fetch order header and joined product line items for the invoice
    public function getOrderById($order_id) {
        $stmt = $this->conn->prepare(
            "SELECT o.order_id, o.customer_id, o.invoice_no, o.order_date, o.order_status,
                    c.customer_name, c.customer_email,
                    od.product_id, od.qty,
                    p.product_title, p.product_price, p.product_image
             FROM orders o
             JOIN customer c ON o.customer_id = c.customer_id
             JOIN orderdetails od ON o.order_id = od.order_id
             JOIN products p ON od.product_id = p.product_id
             WHERE o.order_id = ?"
        );
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();

        return $rows;
    }
}