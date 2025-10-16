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
    // Get demand alerts
    $stmt = $citizen_db->prepare("
        SELECT 
            da.*,
            (SELECT terminal_name FROM terminals t WHERE t.terminal_id = da.route_id) as terminal_name
        FROM demand_alerts da
        WHERE da.operator_id = ? AND da.forecast_date >= CURDATE()
        ORDER BY da.forecast_date ASC
    ");
    $stmt->execute([$operator_id]);
    $alerts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get terminal capacity data
    $stmt = $transport_db->prepare("
        SELECT 
            t.terminal_id,
            t.terminal_name,
            tc.date_recorded,
            tc.occupied_slots,
            tc.utilization_rate,
            tc.peak_hours
        FROM terminal_assignments ta
        JOIN terminals t ON ta.terminal_id = t.terminal_id
        JOIN terminal_capacity_tracking tc ON t.terminal_id = tc.terminal_id
        WHERE ta.operator_id = ? AND tc.date_recorded = CURDATE()
    ");
    $stmt->execute([$operator_id]);
    $capacity = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'alerts' => $alerts,
        'capacity' => $capacity
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}