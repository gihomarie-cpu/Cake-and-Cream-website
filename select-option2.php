<?php

$isAjax = !empty($_SERVER["HTTP_X_REQUESTED_WITH"]) &&
    strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest";

function order_response(bool $success, string $message, bool $isAjax, int $statusCode = 200): void
{
    http_response_code($statusCode);

    if ($isAjax) {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(["success" => $success, "message" => $message]);
        exit;
    }

    if ($success) {
        header("Location: send-request.html");
        exit;
    }

    header("Content-Type: text/plain; charset=utf-8");
    echo $message;
    exit;
}

try {
    require_once __DIR__ . "/db_connect.php";

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        order_response(false, "Method not allowed.", $isAjax, 405);
    }

    $cake_size = trim((string) ($_POST["cake_size"] ?? ""));
    $cake_flavor = trim((string) ($_POST["cake_flavor"] ?? ""));
    $cake_name = trim((string) ($_POST["cake_name"] ?? ""));
    $cake_number_raw = $_POST["cake_number"] ?? "";
    $cake_number = $cake_number_raw === "" ? 0 : (int) $cake_number_raw;
    $email = trim((string) ($_POST["email"] ?? ""));
    $telephone = trim((string) ($_POST["telephone"] ?? ""));
    $location = trim((string) ($_POST["location"] ?? ""));
    $payment_method = trim((string) ($_POST["payment_method"] ?? ""));
    $delivery_time = trim((string) ($_POST["delivery_time"] ?? ""));

    if ($email === "" || $telephone === "") {
        order_response(false, "Email and phone number are required.", $isAjax, 400);
    }

    $createTableSql = "CREATE TABLE IF NOT EXISTS orders (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        cake_size VARCHAR(100) NOT NULL DEFAULT '',
        cake_flavor VARCHAR(100) NOT NULL DEFAULT '',
        cake_name TEXT NOT NULL,
        cake_number INT UNSIGNED NOT NULL DEFAULT 0,
        email VARCHAR(255) NOT NULL DEFAULT '',
        telephone VARCHAR(50) NOT NULL DEFAULT '',
        location VARCHAR(255) NOT NULL DEFAULT '',
        payment_method VARCHAR(50) NOT NULL DEFAULT '',
        delivery_time VARCHAR(100) NOT NULL DEFAULT '',
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    if (!$conn->query($createTableSql)) {
        throw new RuntimeException("Unable to prepare the orders table.");
    }

    $sql = "INSERT INTO orders (cake_size, cake_flavor, cake_name, cake_number, email, telephone, location, payment_method, delivery_time)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new RuntimeException("Unable to prepare the order.");
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

    if (!$stmt->execute()) {
        throw new RuntimeException("Error submitting order.");
    }

    $stmt->close();
    $conn->close();

    order_response(true, "Thank you! Your order has been received successfully.", $isAjax);
} catch (Throwable $e) {
    if (isset($stmt) && $stmt instanceof mysqli_stmt) {
        $stmt->close();
    }
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }

    error_log("Order submission failed: " . $e->getMessage());

    $fallbackFile = __DIR__ . "/orders_submissions.json";
    $orderData = [
        "cake_size" => trim((string) ($_POST["cake_size"] ?? "")),
        "cake_flavor" => trim((string) ($_POST["cake_flavor"] ?? "")),
        "cake_name" => trim((string) ($_POST["cake_name"] ?? "")),
        "cake_number" => ($_POST["cake_number"] ?? "") === "" ? 0 : (int) ($_POST["cake_number"] ?? 0),
        "email" => trim((string) ($_POST["email"] ?? "")),
        "telephone" => trim((string) ($_POST["telephone"] ?? "")),
        "location" => trim((string) ($_POST["location"] ?? "")),
        "payment_method" => trim((string) ($_POST["payment_method"] ?? "")),
        "delivery_time" => trim((string) ($_POST["delivery_time"] ?? "")),
        "submitted_at" => date("c"),
    ];

    $existingOrders = [];
    if (is_file($fallbackFile)) {
        $decodedOrders = json_decode((string) file_get_contents($fallbackFile), true);
        if (is_array($decodedOrders)) {
            $existingOrders = $decodedOrders;
        }
    }

    $existingOrders[] = $orderData;
    $saved = @file_put_contents(
        $fallbackFile,
        json_encode($existingOrders, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        LOCK_EX
    );

    if ($saved === false) {
        $tempFallbackFile = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . "cake_orders_submissions.json";
        @file_put_contents(
            $tempFallbackFile,
            json_encode($existingOrders, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            LOCK_EX
        );
    }

    order_response(true, "Thank you! Your order has been received successfully.", $isAjax);
}

