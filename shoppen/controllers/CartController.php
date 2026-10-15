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
}