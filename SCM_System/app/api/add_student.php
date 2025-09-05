<?php
ob_start(); // Start output buffering
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Optional for testing

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['student_id'] ?? "";
    $name = $data['student_name'] ?? '';
    $faculty = $data['faculty'] ?? '';
    $email = $data['email'] ?? '';
    $added_date = date('Y-m-d H:i:s');

    if ($id && $name && $faculty && $email) {
        try {
            $stmt = $pdo->prepare("INSERT INTO students (student_id,student_name,faculty, email, added_date) VALUES (:student_id, :student_name, :faculty, :email,  :added_date)");
            $stmt->execute(['student_id' => $id,'student_name' => $name,'faculty' => $faculty, 'email' => $email, 'added_date' => $added_date]);
            $response = ['status' => 'success', 'message' => 'Student added successfully'];
             // Log success
        } catch (PDOException $e) {
            $response = ['status' => 'error', 'message' => 'Faild to add: ' . $e->getMessage()];
            error_log("adding error: " . $e->getMessage()); // Log error
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