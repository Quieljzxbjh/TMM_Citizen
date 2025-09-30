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
    // Get upcoming inspections
    $stmt = $citizen_db->prepare("
        SELECT 
            requested_date as date,
            'Inspection' as type,
            status
        FROM inspection_requests 
        WHERE operator_id = ? AND status != 'Completed'
        AND requested_date >= CURDATE()
    ");
    $stmt->execute([$operator_id]);
    $inspections = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get upcoming franchise renewals
    $stmt = $transport_db->prepare("
        SELECT 
            expiry_date as date,
            'Franchise Renewal' as type,
            'Upcoming' as status
        FROM franchise_records 
        WHERE operator_id = ? 
        AND expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
    ");
    $stmt->execute([$operator_id]);
    $franchiseRenewals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Combine and sort all schedules
    $schedules = array_merge($inspections, $franchiseRenewals);
    usort($schedules, function($a, $b) {
        return strtotime($a['date']) - strtotime($b['date']);
    });

    // Return only the next 5 schedules
    $schedules = array_slice($schedules, 0, 5);

    echo json_encode($schedules);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}