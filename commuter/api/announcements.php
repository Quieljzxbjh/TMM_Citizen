<?php
include '../../includes/config.php';

header('Content-Type: application/json');

try {
    // Get active announcements
    $stmt = $transport_db->prepare("
        SELECT 
            announcement_id,
            title,
            message,
            category,
            priority,
            published_date,
            expiry_date
        FROM public_announcements
        WHERE status = 'Active' 
        AND (expiry_date IS NULL OR expiry_date >= CURDATE())
        ORDER BY priority = 'High' DESC, published_date DESC
        LIMIT 10
    ");
    $stmt->execute();
    $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($announcements);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}
?>