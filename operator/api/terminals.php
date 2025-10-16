<?php
include '../../includes/config.php';

header('Content-Type: application/json');

$operator_id = $_SESSION['operator_id'] ?? null;

if (!$operator_id) {
    http_response_code(401);
    echo json_encode(['error' => 'No operator ID found in session']);
    exit();
}

try {
    // Get terminal assignments
    $stmt = $transport_db->prepare("
        SELECT 
            ta.assignment_id,
            ta.assigned_date,
            ta.status,
            t.terminal_id,
            t.terminal_name,
            t.terminal_code,
            t.location,
            t.capacity,
            t.operating_hours,
            t.status as terminal_status
        FROM terminal_assignments ta
        JOIN terminals t ON ta.terminal_id = t.terminal_id
        WHERE ta.operator_id = ?
        ORDER BY ta.assigned_date DESC
    ");
    $stmt->execute([$operator_id]);
    $terminals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($terminals);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}