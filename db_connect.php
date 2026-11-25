<?php
// Database connection configuration.
// Update these values to match your database environment.
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "cake_shop";

mysqli_report(MYSQLI_REPORT_OFF);

// Create and check the database connection.
$conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    throw new RuntimeException("Database connection failed: " . $conn->connect_error);
}

// Ensure UTF-8 encoding for stored customer/order data.
$conn->set_charset("utf8mb4");

