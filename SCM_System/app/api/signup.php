<?php
ob_start(); // Start output buffering
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Optional for testing

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $password = password_hash($data['password'] ?? '', PASSWORD_DEFAULT);
    $registered_date = date('Y-m-d H:i:s');

    if ($name && $email && $password) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, registered_date) VALUES (:name, :email, :password, :registered_date)");
            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password, 'registered_date' => $registered_date]);
            $response = ['status' => 'success', 'message' => 'User registered successfully'];
            error_log("Signup success for email: $email"); // Log success
        } catch (PDOException $e) {
            $response = ['status' => 'error', 'message' => 'Registration failed: ' . $e->getMessage()];
            error_log("Signup error: " . $e->getMessage()); // Log error
        }
    } else {
        $response = ['status' => 'error', 'message' => 'All fields are required'];
    }
    echo json_encode($response); // Ensure JSON is echoed
} else {
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}

// Clear buffer and send only the JSON
ob_end_flush(); // Flush the buffer instead of cleaning to send the response
?>