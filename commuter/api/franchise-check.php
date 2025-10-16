<?php
include '../../includes/config.php';

header('Content-Type: application/json');

$plate_number = $_GET['plate'] ?? null;

if (!$plate_number) {
    http_response_code(400);
    echo json_encode(['error' => 'Plate number is required']);
    exit();
}

try {
    // Check franchise status
    $stmt = $transport_db->prepare("
        SELECT 
            v.vehicle_id,
            v.plate_number,
            v.vehicle_type,
            v.make,
            v.model,
            v.seating_capacity,
            v.status as vehicle_status,
            o.first_name,
            o.last_name,
            o.contact_number,
            f.franchise_number,
            f.issue_date,
            f.expiry_date,
            f.status as franchise_status,
            r.route_name
        FROM vehicles v
        LEFT JOIN operators o ON v.operator_id = o.operator_id
        LEFT JOIN franchise_records f ON v.vehicle_id = f.vehicle_id
        LEFT JOIN official_routes r ON f.route_assigned = r.route_id
        WHERE v.plate_number = ?
    ");
    $stmt->execute([$plate_number]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        echo json_encode([
            'found' => false,
            'message' => 'Vehicle not found in registry'
        ]);
    } else {
        // Determine franchise validity
        $is_valid = false;
        $status_message = '';
        
        if ($result['franchise_status'] === 'Valid' && 
            $result['expiry_date'] && 
            strtotime($result['expiry_date']) > time()) {
            $is_valid = true;
            $status_message = 'Valid franchise';
        } elseif ($result['expiry_date'] && strtotime($result['expiry_date']) <= time()) {
            $status_message = 'Franchise expired';
        } else {
            $status_message = 'No valid franchise found';
        }

        echo json_encode([
            'found' => true,
            'valid' => $is_valid,
            'status_message' => $status_message,
            'vehicle' => $result
        ]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}
?>