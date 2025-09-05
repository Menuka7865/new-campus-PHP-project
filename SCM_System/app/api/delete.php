<?php 
ob_start(); // Start output buffering
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Optional for testing
header('Access-Control-Allow-Methods: DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['student_id'] ?? "";

    if ($id) {
        try {
            // First check if student exists
            $checkStmt = $pdo->prepare("SELECT student_name FROM students WHERE student_id = :student_id");
            $checkStmt->execute(['student_id' => $id]);
            $student = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($student) {
                $stmt = $pdo->prepare("DELETE FROM students WHERE student_id = :student_id");
                $stmt->execute(['student_id' => $id]);
                
                if ($stmt->rowCount() > 0) {
                    $response = ['status' => 'success', 'message' => 'Student deleted successfully', 'deleted_student' => $student['student_name']];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to delete student'];
                }
            } else {
                $response = ['status' => 'error', 'message' => 'Student not found'];
            }
        } catch (PDOException $e) {
            $response = ['status' => 'error', 'message' => 'Failed to delete: ' . $e->getMessage()];
            error_log("Delete error: " . $e->getMessage()); // Log error
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Student ID is required'];
    }
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}

// Clear buffer and send only the JSON
ob_end_flush();
?>