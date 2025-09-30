<?php
include '../../includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plate_number = $_POST['plate_number'] ?? null;
    $rating = $_POST['rating'] ?? null;
    $comments = $_POST['comments'] ?? '';

    if (!$plate_number || !$rating) {
        http_response_code(400);
        echo json_encode(['error' => 'Plate number and rating are required']);
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

        // Insert feedback
        $stmt = $citizen_db->prepare("
            INSERT INTO commuter_feedback 
            (commuter_id, operator_id, rating, comments, created_at) 
            VALUES (1, ?, ?, ?, NOW())
        ");
        $stmt->execute([$vehicle['operator_id'], $rating, $comments]);

        echo json_encode(['message' => 'Feedback submitted successfully']);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>