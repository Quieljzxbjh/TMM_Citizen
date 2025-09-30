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
    // Handle new franchise application
    $vehicle_id = $_POST['vehicle_id'] ?? null;
    $application_type = $_POST['application_type'] ?? null;

    if (!$vehicle_id || !$application_type) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit();
    }

    try {
        $stmt = $citizen_db->prepare("
            INSERT INTO franchise_applications 
            (operator_id, vehicle_id, application_type, status) 
            VALUES (?, ?, ?, 'Pending')
        ");
        $stmt->execute([$operator_id, $vehicle_id, $application_type]);
        $application_id = $citizen_db->lastInsertId();

        echo json_encode([
            'message' => 'Application submitted successfully',
            'application_id' => $application_id
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
} else {
    // Get franchise applications
    try {
        $stmt = $citizen_db->prepare("
            SELECT 
                fa.*,
                v.plate_number,
                v.vehicle_type,
                GROUP_CONCAT(ad.file_path) as documents
            FROM franchise_applications fa
            JOIN vehicles v ON fa.vehicle_id = v.vehicle_id
            LEFT JOIN application_documents ad ON fa.application_id = ad.application_id
            WHERE fa.operator_id = ?
            GROUP BY fa.application_id
            ORDER BY fa.date_submitted DESC
        ");
        $stmt->execute([$operator_id]);
        $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($applications);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
}