<?php
ob_start(); // Start output buffering
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Optional for testing
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    ob_end_clean();
    exit(0);
}

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON input
    $json_input = file_get_contents('php://input');
    $data = json_decode($json_input, true);
    
    // Check if JSON decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE) {
        ob_end_clean();
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON format']);
        exit;
    }
    
    // Extract data from JSON - matching your JSON structure
    $student_id = $data['student_id'] ?? '';
    $student_name = $data['student_name'] ?? '';
    $faculty = $data['faculty'] ?? '';
    $sport = $data['sport'] ?? '';
    $color = $data['color'] ?? '';
    $date = $data['date'] ?? '';
    
    // Convert date format from "2025.4.2" to "2025-04-02" if needed
    $formatted_date = '';
    if ($date) {
        try {
            // Handle the format "2025.4.2"
            $date_parts = explode('.', $date);
            if (count($date_parts) === 3) {
                $formatted_date = sprintf('%04d-%02d-%02d', 
                    (int)$date_parts[0], 
                    (int)$date_parts[1], 
                    (int)$date_parts[2]
                );
            } else {
                // If it's already in a different format, try to parse it
                $formatted_date = date('Y-m-d', strtotime($date));
            }
        } catch (Exception $e) {
            $formatted_date = date('Y-m-d'); // Use current date as fallback
        }
    }
    
    $added_date = date('Y-m-d H:i:s');
    
    // Validate required fields - adjust based on what you actually need
    if ($student_id && $student_name && $faculty && $sport && $color && $date) {
        try {
            // Updated SQL query to match your JSON structure
            $stmt = $pdo->prepare("INSERT INTO students_colors (student_id, student_name, faculty, sport, color, date) VALUES (:student_id, :student_name, :faculty, :sport, :color, :date)");
            
            $result = $stmt->execute([
                'student_id' => $student_id,
                'student_name' => $student_name,
                'faculty' => $faculty,
                'sport' => $sport,
                'color' => $color,
                'date' => $formatted_date,
                
            ]);
            
            if ($result) {
                $response = [
                    'status' => 'success', 
                    'message' => 'Student added successfully',
                    'student_id' => $student_id
                ];
            } else {
                $response = [
                    'status' => 'error', 
                    'message' => 'Failed to insert student data'
                ];
            }
            
        } catch (PDOException $e) {
            $response = [
                'status' => 'error', 
                'message' => 'Database error: ' . $e->getMessage()
            ];
            error_log("Database error: " . $e->getMessage());
        }
    } else {
        // Show which fields are missing for debugging
        $missing_fields = [];
        if (!$student_id) $missing_fields[] = 'student_id';
        if (!$student_name) $missing_fields[] = 'student_name';
        if (!$faculty) $missing_fields[] = 'faculty';
        if (!$sport) $missing_fields[] = 'sport';
        if (!$color) $missing_fields[] = 'color';
        if (!$date) $missing_fields[] = 'date';
        
        $response = [
            'status' => 'error', 
            'message' => 'All fields are required. Missing: ' . implode(', ', $missing_fields),
            'received_data' => $data // For debugging - remove in production
        ];
    }
    
    ob_end_clean(); // Clear buffer
    echo json_encode($response);
    
} else {
    ob_end_clean();
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed. Only POST requests are accepted.']);
}
?>