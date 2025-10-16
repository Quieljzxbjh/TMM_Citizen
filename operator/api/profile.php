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
    // Get operator details from transport_mobility_db
    $stmt = $transport_db->prepare("
        SELECT 
            o.operator_id,
            o.first_name,
            o.last_name,
            o.contact_number,
            o.email,
            o.license_number,
            o.license_expiry,
            o.status
        FROM operators o
        WHERE o.operator_id = ?
    ");
    $stmt->execute([$operator_id]);
    $operator = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$operator) {
        http_response_code(404);
        echo json_encode(['error' => 'Operator not found']);
        exit();
    }

    echo json_encode($operator);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}