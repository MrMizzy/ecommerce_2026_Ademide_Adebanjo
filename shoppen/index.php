<?php
// Define base path
define('BASE_PATH', __DIR__ . '/');

// require core.php
require BASE_PATH .'core/core.php';

// load controllers
require_once BASE_PATH .'controllers/ProductController.php';

// render layout views
require_once BASE_PATH .'views/home.php';
