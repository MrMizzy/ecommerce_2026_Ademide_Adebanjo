<?php
// Ensure the session is active before attempting to destroy it
require_once BASE_PATH . 'core/core.php';

// unset all session variables
session_unset();

// destroy the session
session_destroy();

header('Location: index.php');
exit();
?>