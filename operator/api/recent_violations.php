<?php
include '../../includes/config.php';

header('Content-Type: application/json');

// The operator_id will come from the session managed by the main system
$operator_id = $_SESSION['operator_id'] ?? null;

if (!$operator_id) {
    http_response_code(401);
    echo json_encode(['error' => 'No operator ID found in session']);
    exit();
}

try {
    $stmt = $transport_db->prepare("
        SELECT 
            vh.date_issued as date,
            vh.violation_type as type,
            vh.settlement_status as status
        FROM violation_history vh 
        JOIN vehicles v ON vh.vehicle_id = v.vehicle_id 
        WHERE v.operator_id = ? 
        ORDER BY vh.date_issued DESC 
        LIMIT 5
    ");
    $stmt->execute([$operator_id]);
    $violations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($violations);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}