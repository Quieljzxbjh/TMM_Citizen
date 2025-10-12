<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once '../../includes/config.php';

try {
    // Get published announcements for citizens or all audiences
    $stmt = $transport_db->prepare("
        SELECT 
            announcement_id,
            title,
            content,
            image_path,
            priority,
            target_audience,
            publish_date,
            expiry_date,
            created_by,
            created_at
        FROM announcements 
        WHERE status = 'published' 
        AND (target_audience IN ('all', 'citizens'))
        AND (publish_date IS NULL OR publish_date <= NOW())
        AND (expiry_date IS NULL OR expiry_date >= NOW())
        ORDER BY 
            CASE priority 
                WHEN 'urgent' THEN 1 
                WHEN 'high' THEN 2 
                WHEN 'medium' THEN 3 
                WHEN 'low' THEN 4 
            END,
            created_at DESC
        LIMIT 10
    ");
    
    $stmt->execute();
    $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => $announcements,
        'count' => count($announcements)
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching announcements: ' . $e->getMessage()
    ]);
}
?>