-- Create citizen_db database
CREATE DATABASE IF NOT EXISTS citizen_db;
USE citizen_db;

-- Operator Profiles table
CREATE TABLE IF NOT EXISTS operator_profiles (
    operator_id INT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    contact_info TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Operator User Logs table
CREATE TABLE IF NOT EXISTS operator_user_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    operator_id INT NOT NULL,
    login_time DATETIME NOT NULL,
    logout_time DATETIME,
    ip_address VARCHAR(45),
    device_info TEXT,
    FOREIGN KEY (operator_id) REFERENCES operator_profiles(operator_id)
);

-- Violation Complaints table
CREATE TABLE IF NOT EXISTS violation_complaints (
    complaint_id INT AUTO_INCREMENT PRIMARY KEY,
    operator_id INT NOT NULL,
    violation_id INT NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('Pending', 'Reviewed', 'Resolved') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (operator_id) REFERENCES operator_profiles(operator_id)
);

-- Franchise Applications table
CREATE TABLE IF NOT EXISTS franchise_applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    operator_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    application_type ENUM('New', 'Renewal') NOT NULL,
    date_submitted DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    FOREIGN KEY (operator_id) REFERENCES operator_profiles(operator_id)
);

-- Application Documents table
CREATE TABLE IF NOT EXISTS application_documents (
    document_id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES franchise_applications(application_id)
);

-- Inspection Requests table
CREATE TABLE IF NOT EXISTS inspection_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    operator_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    requested_date DATE NOT NULL,
    status ENUM('Pending', 'Approved', 'Completed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (operator_id) REFERENCES operator_profiles(operator_id)
);

-- Demand Alerts table
CREATE TABLE IF NOT EXISTS demand_alerts (
    alert_id INT AUTO_INCREMENT PRIMARY KEY,
    operator_id INT NOT NULL,
    route_id INT NOT NULL,
    forecast_date DATE NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (operator_id) REFERENCES operator_profiles(operator_id)
);

-- Commuter Complaints table
CREATE TABLE IF NOT EXISTS commuter_complaints (
    complaint_id INT AUTO_INCREMENT PRIMARY KEY,
    commuter_id INT DEFAULT 1,
    operator_id INT,
    vehicle_id INT,
    reason TEXT NOT NULL,
    status ENUM('Pending', 'Reviewed', 'Resolved') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Commuter Feedback table
CREATE TABLE IF NOT EXISTS commuter_feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    commuter_id INT DEFAULT 1,
    operator_id INT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);