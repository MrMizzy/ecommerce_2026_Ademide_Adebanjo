<?php
require_once dirname(__DIR__ ) ."/core/db_class.php";

class CustomerClass extends Database {
    
    public function emailExists($email) : bool {
        $stmt = $this->conn->prepare("SELECT customer_email FROM customer WHERE customer_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $exists = $result->num_rows > 0;
        $stmt->close();
        
        return $exists;
    }

    public function addCustomer($name, $email, $pass, $country, $city, $contact) {
        // Hash password before storing it in the database
        $hash = password_hash($pass, PASSWORD_BCRYPT);
        
        $stmt = $this->conn->prepare(
            "INSERT INTO customer (customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssssss", $name, $email, $hash, $country, $city, $contact);
        
        $success = $stmt->execute();
        
        // Capture the new user's ID to log them in automatically
        $insert_id = $stmt->insert_id; 
        
        $stmt->close();
        
        return $success ? $insert_id : false;
    }
}