<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 

require_once 'db_connect.php';

try {
    $stmt = $pdo->query("SELECT * FROM students");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $students]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch students: ' . $e->getMessage()]);
}
?>