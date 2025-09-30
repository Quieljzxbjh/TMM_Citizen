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
    // Handle complaint submission
    $violation_id = $_POST['violation_id'] ?? null;
    $reason = $_POST['reason'] ?? null;

    if (!$violation_id || !$reason) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit();
    }

    try {
        $stmt = $citizen_db->prepare("
            INSERT INTO violation_complaints 
            (operator_id, violation_id, reason, status) 
            VALUES (?, ?, ?, 'Pending')
        ");
        $stmt->execute([$operator_id, $violation_id, $reason]);

        echo json_encode(['message' => 'Complaint submitted successfully']);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
} else {
    // Get violations
    try {
        $stmt = $transport_db->prepare("
            SELECT 
                vh.*,
                v.plate_number,
                vc.complaint_id,
                vc.status as complaint_status
            FROM violation_history vh
            JOIN vehicles v ON vh.vehicle_id = v.vehicle_id
            LEFT JOIN citizen_db.violation_complaints vc 
                ON vh.violation_id = vc.violation_id 
                AND vc.operator_id = ?
            WHERE v.operator_id = ?
            ORDER BY vh.date_issued DESC
        ");
        $stmt->execute([$operator_id, $operator_id]);
        $violations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($violations);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
}