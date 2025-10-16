<?php
include '../../includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit();
}

$user_id = $_SESSION['user_id'];
$full_name = $_POST['full_name'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$license_number = $_POST['license_number'] ?? '';

if (empty($full_name) || empty($phone) || empty($address)) {
    http_response_code(400);
    echo json_encode(['error' => 'Required fields missing']);
    exit();
}

try {
    // Check if user already has a pending verification
    $stmt = $citizen_db->prepare("SELECT verification_id FROM account_verification_requests WHERE user_id = ? AND status = 'Pending'");
    $stmt->execute([$user_id]);
    if ($stmt->fetch()) {
        echo json_encode(['error' => 'You already have a pending verification request']);
        exit();
    }

    $document_path = null;
    
    // Handle file upload
    if (isset($_FILES['documents']) && $_FILES['documents']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/verification/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $file_extension = pathinfo($_FILES['documents']['name'], PATHINFO_EXTENSION);
        $filename = 'verification_' . $user_id . '_' . time() . '.' . $file_extension;
        $document_path = $upload_dir . $filename;
        
        if (!move_uploaded_file($_FILES['documents']['tmp_name'], $document_path)) {
            echo json_encode(['error' => 'Failed to upload document']);
            exit();
        }
        
        $document_path = 'uploads/verification/' . $filename;
    }

    // Insert verification request
    $stmt = $citizen_db->prepare("
        INSERT INTO account_verification_requests 
        (user_id, full_name, phone, address, license_number, document_path, status) 
        VALUES (?, ?, ?, ?, ?, ?, 'Pending')
    ");
    
    $stmt->execute([$user_id, $full_name, $phone, $address, $license_number, $document_path]);
    
    echo json_encode(['success' => true, 'message' => 'Verification request submitted successfully']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}
?>