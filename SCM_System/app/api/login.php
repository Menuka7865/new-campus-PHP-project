<?php
ob_start(); // Start output buffering
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Optional for testing
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if ($email && $password) {
        try {
            $stmt = $pdo->prepare("SELECT user_Id, name, email, password, registered_date FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Login successful - remove password from response
                unset($user['password']);
                
                $response = [
                    'status' => 'success',
                    'message' => 'Login successful',
                    'user' => $user
                ];
                error_log("Login success for email: $email"); // Log success
                
                
                
            } else {
                $response = ['status' => 'error', 'message' => 'Invalid email or password'];
                error_log("Login failed for email: $email - Invalid credentials"); // Log failed attempt
            }
        } catch (PDOException $e) {
            $response = ['status' => 'error', 'message' => 'Login failed: ' . $e->getMessage()];
            error_log("Login error: " . $e->getMessage()); // Log error
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Email and password are required'];
        error_log("Login attempt with missing fields"); // Log incomplete request
    }
    
    echo json_encode($response); // Ensure JSON is echoed
} else {
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}

// Clear buffer and send only the JSON
ob_end_flush(); // Flush the buffer to send the response
?>