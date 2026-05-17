-- ============================================
-- Tracker Database Tables
-- ============================================
-- This file contains SQL queries for creating
-- tracker.user and tracker.user_log tables
-- ============================================

-- Create tracker database if it doesn't exist
CREATE DATABASE IF NOT EXISTS tracker;
USE tracker;

-- ============================================
-- Table: user
-- Description: Stores information about affected people in disaster situations
-- ============================================
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    location_name VARCHAR(255) NOT NULL,
    district VARCHAR(100) NOT NULL,
    latitude DECIMAL(10, 7) NOT NULL,
    longitude DECIMAL(10, 7) NOT NULL,
    disaster_type ENUM('flood', 'landslide', 'tsunami', 'earthquake', 'cyclone', 'drought', 'other') NOT NULL,
    status ENUM('needs_aid', 'team_sent', 'rescued', 'safe', 'critical') NOT NULL DEFAULT 'needs_aid',
    injury_status VARCHAR(255) DEFAULT 'Not specified',
    family_count INT DEFAULT 0,
    contact VARCHAR(20) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================
-- Table: user_log
-- Description: Stores activity logs and status updates for tracked users
-- ============================================
CREATE TABLE IF NOT EXISTS user_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    person_id INT NOT NULL,
    log_type ENUM('incident_reported', 'team_dispatched', 'medical_aid', 'status_update', 'rescue_complete', 'aid_delivered', 'contact_made', 'other') NOT NULL,
    message TEXT NOT NULL,
    created_by VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (person_id) REFERENCES user(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Sample Data for Testing
-- ============================================

-- Insert sample users
INSERT INTO user (full_name, age, gender, location_name, district, latitude, longitude, disaster_type, status, injury_status, family_count, contact) VALUES
('Nimal Perera', 45, 'male', 'Galle Road', 'Colombo', 6.9271000, 79.8612000, 'flood', 'needs_aid', 'Minor injuries', 4, '0771234567'),
('Kamala Silva', 32, 'female', 'Main Street', 'Galle', 6.0535000, 80.2210000, 'landslide', 'team_sent', 'No injuries', 2, '0779876543'),
('Sunil Fernando', 28, 'male', 'Temple Road', 'Kandy', 7.2906000, 80.6337000, 'flood', 'rescued', 'Serious injuries', 3, '0765551234');

-- Insert sample logs
INSERT INTO user_log (person_id, log_type, message, created_by) VALUES
(1, 'incident_reported', 'Person reported trapped in flooded area', 'Emergency Hotline'),
(1, 'team_dispatched', 'Rescue team dispatched to location', 'Control Center'),
(2, 'incident_reported', 'Landslide reported, family needs evacuation', 'Local Police'),
(3, 'incident_reported', 'Person found in flood waters', 'Rescue Team Alpha'),
(3, 'medical_aid', 'Medical aid provided on site', 'Medical Team'),
(3, 'status_update', 'Person successfully rescued and transported to hospital', 'Rescue Team Alpha');

-- ============================================
-- Useful Queries
-- ============================================

-- Get all users with their latest status
-- SELECT * FROM user ORDER BY created_at DESC;

-- Get all logs for a specific person
-- SELECT * FROM user_log WHERE person_id = 1 ORDER BY created_at DESC;

-- Get users by status
-- SELECT * FROM user WHERE status = 'needs_aid';

-- Get users by disaster type
-- SELECT * FROM user WHERE disaster_type = 'flood';

-- Get users by district
-- SELECT * FROM user WHERE district = 'Colombo';

-- Get user with their log count
-- SELECT u.*, COUNT(ul.id) as log_count 
-- FROM user u 
-- LEFT JOIN user_log ul ON u.id = ul.person_id 
-- GROUP BY u.id;

-- Get recent activity logs across all users
-- SELECT ul.*, u.full_name, u.district 
-- FROM user_log ul 
-- JOIN user u ON ul.person_id = u.id 
-- ORDER BY ul.created_at DESC 
-- LIMIT 10;

-- ============================================
-- Maintenance Queries
-- ============================================

-- Drop tables (use with caution!)
-- DROP TABLE IF EXISTS user_log;
-- DROP TABLE IF EXISTS user;

-- Truncate tables (remove all data but keep structure)
-- TRUNCATE TABLE user_log;
-- TRUNCATE TABLE user;
