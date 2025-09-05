<?php 
ob_start(); // Start output buffering
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Optional for testing
header('Access-Control-Allow-Methods: PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['student_id'] ?? "";
    $name = $data['student_name'] ?? '';
    $sport = $data['sport'] ?? '';
    $color = $data['color'] ?? '';
    $date = $data['date'] ?? '';
   
    if ($id && $name && $sport&& $color && $date) {
        try {
            // First check if student exists
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM students_colors WHERE student_id = :student_id");
            $checkStmt->execute(['student_id' => $id]);
            $exists = $checkStmt->fetchColumn();

            if ($exists) {
                $stmt = $pdo->prepare("UPDATE students_colors SET student_name = :student_name, sport = :sport, color = :color,date =:date  WHERE student_id = :student_id");
                $stmt->execute([
                    'student_id' => $id,
                    'student_name' => $name,
                    'sport' => $sport,
                    'color' => $color,
                    'date' => $date,
                    
                ]);
                
                if ($stmt->rowCount() > 0) {
                    $response = ['status' => 'success', 'message' => 'Student\'s color updated successfully'];
                } else {
                    $response = ['status' => 'info', 'message' => 'No changes made to student\'s color record'];
                }
            } else {
                $response = ['status' => 'error', 'message' => 'Student not found'];
            }
        } catch (PDOException $e) {
            $response = ['status' => 'error', 'message' => 'Failed to update: ' . $e->getMessage()];
            error_log("Update error: " . $e->getMessage()); // Log error
        }
    } else {
        $response = ['status' => 'error', 'message' => 'All fields are required'];
    }
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}

// Clear buffer and send only the JSON
ob_end_flush();
?>