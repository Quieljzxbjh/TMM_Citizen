<?php
// Database configuration
$citizen_db_host = 'localhost';
$citizen_db_name = 'citizen_db';
$citizen_db_user = 'root';
$citizen_db_pass = '';  // No password

// Try to create citizen_db if it doesn't exist
try {
    $temp_db = new PDO(
        "mysql:host=$citizen_db_host",
        $citizen_db_user,
        $citizen_db_pass
    );
    
    // Only create citizen_db as transport_mobility_db is an existing superadmin database
    $temp_db->exec("CREATE DATABASE IF NOT EXISTS $citizen_db_name");
    
    // Create tables in citizen_db only
    $temp_db->exec("USE $citizen_db_name");
    
    // Create operator_profiles table for local storage
    $temp_db->exec("
        CREATE TABLE IF NOT EXISTS operator_profiles (
            operator_id INT PRIMARY KEY,
            name VARCHAR(100),
            contact_info TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ");

    // Create operator_user_logs table for activity tracking
    $temp_db->exec("
        CREATE TABLE IF NOT EXISTS operator_user_logs (
            log_id INT AUTO_INCREMENT PRIMARY KEY,
            operator_id INT,
            login_time DATETIME,
            logout_time DATETIME,
            ip_address VARCHAR(45),
            device_info TEXT,
            FOREIGN KEY (operator_id) REFERENCES operator_profiles(operator_id)
        )
    ");

    // Create violation_complaints table for local complaints
    $temp_db->exec("
        CREATE TABLE IF NOT EXISTS violation_complaints (
            complaint_id INT AUTO_INCREMENT PRIMARY KEY,
            operator_id INT,
            violation_id INT,
            reason TEXT,
            status ENUM('Pending', 'Reviewed', 'Resolved') DEFAULT 'Pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (operator_id) REFERENCES operator_profiles(operator_id)
        )
    ");

    // Create franchise_applications table for local applications
    $temp_db->exec("
        CREATE TABLE IF NOT EXISTS franchise_applications (
            application_id INT AUTO_INCREMENT PRIMARY KEY,
            operator_id INT,
            vehicle_id INT,
            application_type ENUM('New', 'Renewal'),
            date_submitted DATETIME DEFAULT CURRENT_TIMESTAMP,
            status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
            FOREIGN KEY (operator_id) REFERENCES operator_profiles(operator_id)
        )
    ");

    // Create application_documents table for uploaded files
    $temp_db->exec("
        CREATE TABLE IF NOT EXISTS application_documents (
            document_id INT AUTO_INCREMENT PRIMARY KEY,
            application_id INT,
            file_path VARCHAR(255),
            uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (application_id) REFERENCES franchise_applications(application_id)
        )
    ");

    // Create inspection_requests table for local requests
    $temp_db->exec("
        CREATE TABLE IF NOT EXISTS inspection_requests (
            request_id INT AUTO_INCREMENT PRIMARY KEY,
            operator_id INT,
            vehicle_id INT,
            requested_date DATE,
            status ENUM('Pending', 'Approved', 'Completed') DEFAULT 'Pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (operator_id) REFERENCES operator_profiles(operator_id)
        )
    ");

    // Create demand_alerts table for local alerts
    $temp_db->exec("
        CREATE TABLE IF NOT EXISTS demand_alerts (
            alert_id INT AUTO_INCREMENT PRIMARY KEY,
            operator_id INT,
            route_id INT,
            forecast_date DATE,
            message TEXT,
            is_read BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (operator_id) REFERENCES operator_profiles(operator_id)
        )
    ");

    // Create commuter_complaints table
    $temp_db->exec("
        CREATE TABLE IF NOT EXISTS commuter_complaints (
            complaint_id INT AUTO_INCREMENT PRIMARY KEY,
            commuter_id INT DEFAULT 1,
            operator_id INT,
            vehicle_id INT,
            reason TEXT,
            status ENUM('Pending', 'Reviewed', 'Resolved') DEFAULT 'Pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Create commuter_feedback table
    $temp_db->exec("
        CREATE TABLE IF NOT EXISTS commuter_feedback (
            feedback_id INT AUTO_INCREMENT PRIMARY KEY,
            commuter_id INT DEFAULT 1,
            operator_id INT,
            rating INT CHECK (rating >= 1 AND rating <= 5),
            comments TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Insert sample operator profile if none exists
    $stmt = $temp_db->query("SELECT COUNT(*) FROM operator_profiles");
    if ($stmt->fetchColumn() == 0) {
        $temp_db->exec("
            INSERT INTO operator_profiles (operator_id, name, contact_info)
            VALUES (1, 'John Doe', '{\"email\":\"john@example.com\",\"phone\":\"1234567890\"}')
        ");
    }

} catch(PDOException $e) {
    die("Could not create database: " . $e->getMessage());
}

$transport_db_host = 'localhost';
$transport_db_name = 'transport_mobility_db';
$transport_db_user = 'root';
$transport_db_pass = '';  // No password

// Create connection to citizen_db
try {
    $citizen_db = new PDO(
        "mysql:host=$citizen_db_host;dbname=$citizen_db_name",
        $citizen_db_user,
        $citizen_db_pass
    );
    $citizen_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Create connection to transport_mobility_db
try {
    $transport_db = new PDO(
        "mysql:host=$transport_db_host;dbname=$transport_db_name",
        $transport_db_user,
        $transport_db_pass
    );
    $transport_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Session start
session_start();
?>