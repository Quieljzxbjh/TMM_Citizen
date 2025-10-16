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
    // Get active vehicles count
    $stmt = $transport_db->prepare("
        SELECT COUNT(*) as count 
        FROM vehicles 
        WHERE operator_id = ? AND status = 'Active'
    ");
    $stmt->execute([$operator_id]);
    $activeVehicles = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Get pending violations count
    $stmt = $transport_db->prepare("
        SELECT COUNT(*) as count 
        FROM violation_history vh 
        JOIN vehicles v ON vh.vehicle_id = v.vehicle_id 
        WHERE v.operator_id = ? AND vh.settlement_status = 'Pending'
    ");
    $stmt->execute([$operator_id]);
    $pendingViolations = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Get upcoming inspections count
    $stmt = $citizen_db->prepare("
        SELECT COUNT(*) as count 
        FROM inspection_requests 
        WHERE operator_id = ? AND status != 'Completed'
    ");
    $stmt->execute([$operator_id]);
    $upcomingInspections = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Get franchise status
    $stmt = $transport_db->prepare("
        SELECT status, expiry_date 
        FROM franchise_records 
        WHERE operator_id = ? 
        ORDER BY expiry_date DESC 
        LIMIT 1
    ");
    $stmt->execute([$operator_id]);
    $franchise = $stmt->fetch(PDO::FETCH_ASSOC);
    $franchiseStatus = $franchise ? $franchise['status'] : 'No Franchise';

    echo json_encode([
        'activeVehicles' => $activeVehicles,
        'pendingViolations' => $pendingViolations,
        'upcomingInspections' => $upcomingInspections,
        'franchiseStatus' => $franchiseStatus
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}