<?php
require_once dirname(__DIR__) . '/classes/CartClass.php';

class CartController {
    private $model;

    public function __construct() {
        $this->model = new CartClass();
    }

    public function isInCart($product_id, $ip) {
        return $this->model->isInCart($product_id, $ip);
    }

    public function addToCart($product_id, $qty, $ip, $customer_id = null) {
        return $this->model->addToCart($product_id, $qty, $ip, $customer_id);
    }

    public function getCartItems($ip) {
        return $this->model->getCartItems($ip);
    }

    public function getCartCount($ip) {
        return $this->model->getCartCount($ip);
    }

    public function getCartTotal($ip) {
        return $this->model->getCartTotal($ip);
    }

    public function removeFromCart($product_id, $ip) {
        if (!filter_var($product_id, FILTER_VALIDATE_INT)) {
            return false;
        }
        return $this->model->removeFromCart($product_id, $ip);
    }

    public function updateQty($product_id, $new_qty, $ip) {
        if (!filter_var($product_id, FILTER_VALIDATE_INT) || !filter_var($new_qty, FILTER_VALIDATE_INT) || $new_qty < 1) {
            return false;
        }
        return $this->model->updateQty($product_id, $new_qty, $ip);
    }

    public function processPayment($customer_id, $ip, $reference, $amount, $currency = 'GHS') {
        if (!filter_var($customer_id, FILTER_VALIDATE_INT) || $amount <= 0) {
            return false;
        }
        return $this->model->processPayment($customer_id, $ip, $reference, $amount, $currency);
    }

    public function getOrderById($order_id) {
        if (!filter_var($order_id, FILTER_VALIDATE_INT)) {
            return [];
        }
        return $this->model->getOrderById($order_id);
    }
}