<?php
$host = $_ENV["DB_HOST"] ?? "localhost";
$db_user = $_ENV["DB_USER"] ?? "root";
$db_pass = $_ENV["DB_PASS"] ?? "";
$db_name = $_ENV["DB_NAME"] ?? "tasks_app";
$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}