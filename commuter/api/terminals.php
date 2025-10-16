<?php
include '../../includes/config.php';

header('Content-Type: application/json');

try {
    // Get all terminals
    $stmt = $transport_db->prepare("
        SELECT 
            t.terminal_id,
            t.terminal_name,
            t.terminal_code,
            t.location,
            t.address,
            t.capacity,
            t.current_occupancy,
            t.operating_hours,
            t.contact_person,
            t.contact_number,
            t.status
        FROM terminals t
        WHERE t.status = 'Active'
        ORDER BY t.terminal_name
    ");
    $stmt->execute();
    $terminals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($terminals);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}
?>