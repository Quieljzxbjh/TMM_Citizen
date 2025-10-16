<?php
include '../../includes/config.php';

header('Content-Type: application/json');

$origin = $_GET['origin'] ?? '';
$destination = $_GET['destination'] ?? '';

try {
    $sql = "
        SELECT 
            r.route_id,
            r.route_name,
            r.route_code,
            r.origin,
            r.destination,
            r.distance_km,
            r.estimated_travel_time,
            r.fare_amount,
            r.status
        FROM official_routes r
        WHERE r.status = 'Active'
    ";
    
    $params = [];
    
    if ($origin) {
        $sql .= " AND (r.origin LIKE ? OR r.route_name LIKE ?)";
        $params[] = "%$origin%";
        $params[] = "%$origin%";
    }
    
    if ($destination) {
        $sql .= " AND (r.destination LIKE ? OR r.route_name LIKE ?)";
        $params[] = "%$destination%";
        $params[] = "%$destination%";
    }
    
    $sql .= " ORDER BY r.route_name";
    
    $stmt = $transport_db->prepare($sql);
    $stmt->execute($params);
    $routes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($routes);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}
?>