<?php
include '../../includes/config.php';

header('Content-Type: application/json');

try {
    // Get all feedback with operator information
    $stmt = $citizen_db->prepare("
        SELECT 
            cf.feedback_id,
            cf.rating,
            cf.comments,
            cf.created_at,
            op.name as operator_name
        FROM commuter_feedback cf
        LEFT JOIN operator_profiles op ON cf.operator_id = op.operator_id
        ORDER BY cf.created_at DESC
        LIMIT 50
    ");
    $stmt->execute();
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($feedbacks);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}
?>