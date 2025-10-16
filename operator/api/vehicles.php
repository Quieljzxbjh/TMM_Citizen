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
    // Get vehicles from transport_mobility_db
    $stmt = $transport_db->prepare("
        SELECT 
            v.vehicle_id,
            v.plate_number,
            v.vehicle_type,
            v.make,
            v.model,
            v.year_manufactured,
            v.seating_capacity,
            v.status,
            f.franchise_number,
            f.expiry_date as franchise_expiry
        FROM vehicles v
        LEFT JOIN franchise_records f ON v.vehicle_id = f.vehicle_id
        WHERE v.operator_id = ?
    ");
    $stmt->execute([$operator_id]);
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($vehicles);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}