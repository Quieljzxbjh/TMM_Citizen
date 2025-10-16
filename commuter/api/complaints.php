<?php
include '../../includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plate_number = $_POST['plate_number'] ?? null;
    $complaint_type = $_POST['complaint_type'] ?? null;
    $description = $_POST['description'] ?? null;
    $contact = $_POST['contact'] ?? '';

    if (!$plate_number || !$complaint_type || !$description) {
        http_response_code(400);
        echo json_encode(['error' => 'All required fields must be filled']);
        exit();
    }

    try {
        // Get vehicle and operator info
        $stmt = $transport_db->prepare("
            SELECT v.vehicle_id, v.operator_id 
            FROM vehicles v 
            WHERE v.plate_number = ?
        ");
        $stmt->execute([$plate_number]);
        $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$vehicle) {
            http_response_code(404);
            echo json_encode(['error' => 'Vehicle not found']);
            exit();
        }

        // Insert complaint
        $reason = $complaint_type . ': ' . $description;
        if ($contact) {
            $reason .= ' (Contact: ' . $contact . ')';
        }

        $stmt = $citizen_db->prepare("
            INSERT INTO commuter_complaints 
            (commuter_id, operator_id, vehicle_id, reason, status, created_at) 
            VALUES (1, ?, ?, ?, 'Pending', NOW())
        ");
        $stmt->execute([$vehicle['operator_id'], $vehicle['vehicle_id'], $reason]);

        $complaint_id = $citizen_db->lastInsertId();

        echo json_encode([
            'message' => 'Complaint submitted successfully',
            'complaint_id' => $complaint_id
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>