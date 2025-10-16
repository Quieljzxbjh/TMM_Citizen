<?php
include '../../includes/config.php';

header('Content-Type: application/json');

$operator_id = $_SESSION['operator_id'] ?? null;

if (!$operator_id) {
    http_response_code(401);
    echo json_encode(['error' => 'No operator ID found in session']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle new inspection request
    $vehicle_id = $_POST['vehicle_id'] ?? null;
    $requested_date = $_POST['requested_date'] ?? null;

    if (!$vehicle_id || !$requested_date) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit();
    }

    try {
        $stmt = $citizen_db->prepare("
            INSERT INTO inspection_requests 
            (operator_id, vehicle_id, requested_date, status) 
            VALUES (?, ?, ?, 'Pending')
        ");
        $stmt->execute([$operator_id, $vehicle_id, $requested_date]);

        echo json_encode(['message' => 'Inspection request submitted successfully']);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
} else {
    // Get inspection requests and history
    try {
        $stmt = $citizen_db->prepare("
            SELECT 
                ir.*,
                v.plate_number,
                v.vehicle_type
            FROM inspection_requests ir
            JOIN vehicles v ON ir.vehicle_id = v.vehicle_id
            WHERE ir.operator_id = ?
            ORDER BY ir.requested_date DESC
        ");
        $stmt->execute([$operator_id]);
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get completed inspections from transport_mobility_db
        $stmt = $transport_db->prepare("
            SELECT 
                i.*,
                v.plate_number,
                v.vehicle_type
            FROM inspection_records i
            JOIN vehicles v ON i.vehicle_id = v.vehicle_id
            WHERE v.operator_id = ?
            ORDER BY i.inspection_date DESC
        ");
        $stmt->execute([$operator_id]);
        $inspections = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'requests' => $requests,
            'inspections' => $inspections
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
}