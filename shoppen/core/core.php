<?php
// Setup session and timezone
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set('UTC');

// Define paths
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__) . '/');
}
if (!defined('BASE_URL')) {
    define('BASE_URL', '/ecomm/shoppen');
}

// Include database class
require_once BASE_PATH . 'core/db_class.php';

// Helper functions

/**
 * Returns the client IP address
 */
function get_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

/**
 * Sends Location header and exits
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Checks if a customer is logged in
 */
function is_logged_in() {
    // Makes sure variable is set and not empty to avoid false positives
    return isset($_SESSION['customer_id']) && !empty($_SESSION['customer_id']);
}

/**
 * Checks if the logged-in user is an admin
 */
function is_admin() {
    if (!is_logged_in()) {
        return false;
    }
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1;
}

/**
 * Redirects to login page if check fails
 */
function require_login() {
    if (!is_logged_in()) {
        set_flash('error', 'You must be logged in to view this page.');
        redirect(BASE_URL . '/views/login.php');
    }
}

/**
 * Redirects to index page if admin check fails
 */
function require_admin() {
    if (!is_admin()) {
        set_flash('error', 'Access denied. Admins only.');
        redirect(BASE_URL . '/index.php');
    }
}

/**
 * Sets a one-time session message (flash message)
 */
function set_flash($key, $msg) {
    $_SESSION[$key] = $msg;
}

/**
 * Retrieves and unsets a one-time session message
 */
function get_flash($key) {
    if (isset($_SESSION[$key])) {
        $msg = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $msg;
    }
    return null;
}

/**
 * Sanitizes input values
 */
function clean($value) {
    return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
}

/**
 * Appends error messages to error/error.log
 */
function log_err($msg) {
    $log_file = BASE_PATH . 'error/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $formatted_msg = "[{$timestamp}] " . $msg . PHP_EOL;
    
    // The '3' parameter appends to the file specified
    error_log($formatted_msg, 3, $log_file);
}
?>