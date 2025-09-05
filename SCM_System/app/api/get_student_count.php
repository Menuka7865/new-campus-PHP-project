<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 

require_once 'db_connect.php';

try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM students");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'count' => $result['count']]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch student count: ' . $e->getMessage()]);
}
?>