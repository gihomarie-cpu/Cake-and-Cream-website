<?php
// Database connection - updated section to use shared configuration file
require_once "db_connect.php";

// Handle only POST requests with order data.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo "Method not allowed.";
    exit;
}

// Get form data safely.
$cake_size = $_POST["cake_size"] ?? "";
$cake_flavor = $_POST["cake_flavor"] ?? "";
$cake_name = $_POST["cake_name"] ?? "";
$cake_number = isset($_POST["cake_number"]) && $_POST["cake_number"] !== "" ? (int) $_POST["cake_number"] : 0;
$email = $_POST["email"] ?? "";
$telephone = $_POST["telephone"] ?? "";
$location = $_POST["location"] ?? "";
$payment_method = $_POST["payment_method"] ?? "";
$delivery_time = $_POST["delivery_time"] ?? "";

// Insert order using a prepared statement.
$sql = "INSERT INTO orders (cake_size, cake_flavor, cake_name, cake_number, email, telephone, location, payment_method, delivery_time)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

$isAjax = !empty($_SERVER["HTTP_X_REQUESTED_WITH"]) &&
    strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest";

if (!$stmt) {
    if ($isAjax) {
        header("Content-Type: application/json");
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Unable to prepare the order."]);
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
    exit;
}

$stmt->bind_param(
    "sssisssss",
    $cake_size,
    $cake_flavor,
    $cake_name,
    $cake_number,
    $email,
    $telephone,
    $location,
    $payment_method,
    $delivery_time
);

if ($stmt->execute()) {
    if ($isAjax) {
        header("Content-Type: application/json");
        echo json_encode(["success" => true, "message" => "Thank you! Your order has been received successfully."]);
    } else {
        echo "Thank you! Your order has been received successfully.";
    }
} else {
    if ($isAjax) {
        header("Content-Type: application/json");
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Error submitting order."]);
    } else {
        echo "Error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
