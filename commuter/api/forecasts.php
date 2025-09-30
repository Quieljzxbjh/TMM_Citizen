<?php
include '../../includes/config.php';

header('Content-Type: application/json');

try {
    // Get terminal capacity data
    $stmt = $transport_db->prepare("
        SELECT 
            t.terminal_name,
            tc.utilization_rate,
            tc.peak_hours,
            tc.date_recorded
        FROM terminal_capacity_tracking tc
        JOIN terminals t ON tc.terminal_id = t.terminal_id
        WHERE tc.date_recorded = CURDATE()
        ORDER BY tc.utilization_rate DESC
        LIMIT 10
    ");
    $stmt->execute();
    $forecasts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($forecasts);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}
?>