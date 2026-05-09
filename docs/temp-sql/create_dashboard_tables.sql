-- ============================================================================
-- DASHBOARD TABLES FOR DISASTER RESPONSE SYSTEM
-- ============================================================================
-- This SQL file creates all the tables needed to support the DashboardModel.php
-- Currently, DashboardModel returns hardcoded data. These tables will allow
-- the system to store and retrieve real-time dashboard data from the database.
-- ============================================================================

USE DRCS;

-- ============================================================================
-- 1. KPI (Key Performance Indicators) Table
-- ============================================================================
-- Stores the main dashboard KPI cards (Active Incidents, High-Risk Zones, etc.)
CREATE TABLE IF NOT EXISTS kpi_metrics (
    kpi_id INT AUTO_INCREMENT PRIMARY KEY,
    color ENUM('red', 'amber', 'green', 'blue') NOT NULL,
    icon VARCHAR(10) NOT NULL COMMENT 'Emoji icon for the KPI',
    value VARCHAR(20) NOT NULL COMMENT 'Current value (e.g., "18", "142")',
    label VARCHAR(100) NOT NULL COMMENT 'KPI label (e.g., "Active Incidents")',
    delta VARCHAR(100) COMMENT 'Change indicator (e.g., "▲ 3 since 6 hours ago")',
    trend ENUM('up', 'down', 'stable') DEFAULT 'stable',
    display_order INT DEFAULT 0 COMMENT 'Order to display on dashboard',
    is_active TINYINT(1) DEFAULT 1,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active_order (is_active, display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Dashboard KPI metrics';

-- ============================================================================
-- 2. ALERTS Table
-- ============================================================================
-- Stores live alert feed for the dashboard
CREATE TABLE IF NOT EXISTS alerts (
    alert_id INT AUTO_INCREMENT PRIMARY KEY,
    alert_type ENUM('critical', 'warning', 'info') NOT NULL,
    alert_text TEXT NOT NULL,
    location VARCHAR(255) COMMENT 'Location of the alert',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active TINYINT(1) DEFAULT 1,
    acknowledged_by INT COMMENT 'Admin user who acknowledged',
    acknowledged_at TIMESTAMP NULL,
    INDEX idx_active_created (is_active, created_at DESC),
    INDEX idx_type (alert_type),
    FOREIGN KEY (acknowledged_by) REFERENCES admin(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Live alert feed';

-- ============================================================================
-- 3. RESOURCE NEEDS Table
-- ============================================================================
-- Tracks critical resource needs at disaster sites
CREATE TABLE IF NOT EXISTS resource_needs (
    need_id INT AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(10) NOT NULL COMMENT 'Emoji icon',
    resource_name VARCHAR(100) NOT NULL,
    quantity VARCHAR(50) NOT NULL COMMENT 'e.g., "4,200 L", "1,850"',
    status ENUM('crit', 'warn', 'good') NOT NULL,
    status_text VARCHAR(100) NOT NULL COMMENT 'e.g., "⚠ CRITICAL SHORTAGE"',
    card_class ENUM('critical', 'warn', 'ok') NOT NULL,
    priority INT DEFAULT 0 COMMENT 'Higher number = higher priority',
    location_id INT COMMENT 'Specific location if applicable',
    is_active TINYINT(1) DEFAULT 1,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_active_priority (is_active, priority DESC),
    FOREIGN KEY (location_id) REFERENCES Location(loc_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Resource needs tracking';

-- ============================================================================
-- 4. RESPONSE READINESS Table
-- ============================================================================
-- Tracks response readiness by province/region
CREATE TABLE IF NOT EXISTS response_readiness (
    readiness_id INT AUTO_INCREMENT PRIMARY KEY,
    region_label VARCHAR(100) NOT NULL COMMENT 'e.g., "Southern Province"',
    percentage INT NOT NULL CHECK (percentage >= 0 AND percentage <= 100),
    color ENUM('red', 'amber', 'green', 'blue') NOT NULL,
    last_assessment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    assessed_by INT COMMENT 'Admin who assessed',
    notes TEXT,
    is_active TINYINT(1) DEFAULT 1,
    INDEX idx_active (is_active),
    FOREIGN KEY (assessed_by) REFERENCES admin(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Regional response readiness';

-- ============================================================================
-- 5. DISASTER TYPES STATISTICS Table
-- ============================================================================
-- Tracks disaster type breakdown for analytics
CREATE TABLE IF NOT EXISTS disaster_type_stats (
    stat_id INT AUTO_INCREMENT PRIMARY KEY,
    disaster_label VARCHAR(100) NOT NULL COMMENT 'e.g., "Flooding", "Landslides"',
    percentage INT NOT NULL CHECK (percentage >= 0 AND percentage <= 100),
    color VARCHAR(50) NOT NULL COMMENT 'CSS color value',
    incident_count INT DEFAULT 0 COMMENT 'Actual number of incidents',
    period_start DATE NOT NULL,
    period_end DATE NOT NULL,
    is_current TINYINT(1) DEFAULT 1 COMMENT 'Is this the current period data',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_current (is_current),
    INDEX idx_period (period_start, period_end)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Disaster type statistics';

-- ============================================================================
-- 6. RESOURCE ALLOCATION Table
-- ============================================================================
-- Tracks resource allocation progress (personnel, vehicles, shelters, etc.)
CREATE TABLE IF NOT EXISTS resource_allocation_stats (
    allocation_id INT AUTO_INCREMENT PRIMARY KEY,
    resource_label VARCHAR(100) NOT NULL COMMENT 'e.g., "Rescue Personnel"',
    detail VARCHAR(100) NOT NULL COMMENT 'e.g., "1,840 / 2,200"',
    current_value INT NOT NULL,
    max_value INT NOT NULL,
    percentage INT NOT NULL CHECK (percentage >= 0 AND percentage <= 100),
    color ENUM('red', 'amber', 'green', 'blue') NOT NULL,
    category ENUM('personnel', 'vehicles', 'shelter', 'medical', 'other') NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active TINYINT(1) DEFAULT 1,
    INDEX idx_active_category (is_active, category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Resource allocation tracking';

-- ============================================================================
-- 7. RESPONSE TIMES Table
-- ============================================================================
-- Tracks average response times by area tier
CREATE TABLE IF NOT EXISTS response_times (
    response_time_id INT AUTO_INCREMENT PRIMARY KEY,
    tier_label VARCHAR(100) NOT NULL COMMENT 'e.g., "Urban Tier 1", "Remote"',
    percentage INT NOT NULL CHECK (percentage >= 0 AND percentage <= 100) COMMENT 'For bar chart visualization',
    color VARCHAR(50) NOT NULL COMMENT 'CSS color value',
    avg_minutes INT NOT NULL COMMENT 'Average response time in minutes',
    display_value VARCHAR(50) NOT NULL COMMENT 'e.g., "12 min", "58 min"',
    tier_order INT DEFAULT 0 COMMENT 'Display order',
    measurement_period_start DATE NOT NULL,
    measurement_period_end DATE NOT NULL,
    is_current TINYINT(1) DEFAULT 1,
    INDEX idx_current_order (is_current, tier_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Response time statistics';

-- ============================================================================
-- 8. HERO STATISTICS Table
-- ============================================================================
-- Stores the hero section statistics (24/7 Monitoring, Response Teams, etc.)
CREATE TABLE IF NOT EXISTS hero_statistics (
    hero_stat_id INT AUTO_INCREMENT PRIMARY KEY,
    stat_number VARCHAR(20) NOT NULL COMMENT 'e.g., "24", "142", "9", "3.2"',
    suffix VARCHAR(20) NOT NULL COMMENT 'e.g., "/7", "+", " Districts", "k"',
    label VARCHAR(100) NOT NULL COMMENT 'e.g., "MONITORING", "RESPONSE TEAMS"',
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active_order (is_active, display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Hero section statistics';

-- ============================================================================
-- 9. EMERGENCY CONTACTS Table
-- ============================================================================
-- Stores emergency contact numbers for the instant-help modal
CREATE TABLE IF NOT EXISTS emergency_contacts (
    contact_id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(100) NOT NULL COMMENT 'e.g., "🏥 Ambulance", "🚒 Fire & Rescue"',
    phone_number VARCHAR(20) NOT NULL,
    category ENUM('medical', 'fire', 'police', 'disaster', 'other') NOT NULL,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    notes TEXT,
    INDEX idx_active_order (is_active, display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Emergency contact numbers';

-- ============================================================================
-- 10. INCIDENTS Table (Enhanced)
-- ============================================================================
-- Main incidents table to track all disaster incidents
-- This links to many of the dashboard metrics
CREATE TABLE IF NOT EXISTS incidents (
    incident_id INT AUTO_INCREMENT PRIMARY KEY,
    incident_name VARCHAR(255) NOT NULL,
    incident_type ENUM('flooding', 'landslides', 'cyclones', 'droughts', 'tornadoes', 'tsunamis', 'avalanches', 'heat waves', 'other') NOT NULL,
    severity ENUM('low', 'medium', 'high', 'critical') NOT NULL,
    status ENUM('active', 'monitoring', 'resolved', 'closed') DEFAULT 'active',
    location_id INT,
    district VARCHAR(100),
    city VARCHAR(100),
    affected_people_count INT DEFAULT 0,
    casualties INT DEFAULT 0,
    description TEXT,
    reported_by INT COMMENT 'User who reported',
    assigned_to INT COMMENT 'Admin/coordinator assigned',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL,
    INDEX idx_status (status),
    INDEX idx_type (incident_type),
    INDEX idx_severity (severity),
    INDEX idx_created (created_at DESC),
    FOREIGN KEY (location_id) REFERENCES Location(loc_id) ON DELETE SET NULL,
    FOREIGN KEY (reported_by) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (assigned_to) REFERENCES admin(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Disaster incidents tracking';

-- ============================================================================
-- 11. HIGH RISK ZONES Table
-- ============================================================================
-- Tracks areas identified as high-risk zones
CREATE TABLE IF NOT EXISTS high_risk_zones (
    zone_id INT AUTO_INCREMENT PRIMARY KEY,
    zone_name VARCHAR(255) NOT NULL,
    district VARCHAR(100) NOT NULL,
    city VARCHAR(100),
    risk_level ENUM('low', 'medium', 'high', 'critical') NOT NULL,
    risk_type ENUM('flooding', 'landslides', 'cyclones', 'droughts', 'multiple') NOT NULL,
    latitude DECIMAL(20,16),
    longitude DECIMAL(20,16),
    population_at_risk INT DEFAULT 0,
    status ENUM('active', 'monitoring', 'cleared') DEFAULT 'active',
    identified_date DATE NOT NULL,
    last_assessment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    assessed_by INT,
    notes TEXT,
    INDEX idx_status_risk (status, risk_level),
    INDEX idx_district (district),
    FOREIGN KEY (assessed_by) REFERENCES admin(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='High-risk zone tracking';

-- ============================================================================
-- 12. TEAMS DEPLOYED Table
-- ============================================================================
-- Tracks response teams deployed to disaster sites
CREATE TABLE IF NOT EXISTS teams_deployed (
    team_id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(255) NOT NULL,
    team_type ENUM('rescue', 'medical', 'relief', 'assessment', 'logistics') NOT NULL,
    team_leader_id INT COMMENT 'Volunteer who leads the team',
    incident_id INT COMMENT 'Incident they are responding to',
    location_id INT,
    deployment_status ENUM('deployed', 'en_route', 'standby', 'returned') DEFAULT 'deployed',
    team_size INT NOT NULL,
    deployed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    returned_at TIMESTAMP NULL,
    notes TEXT,
    INDEX idx_status (deployment_status),
    INDEX idx_incident (incident_id),
    FOREIGN KEY (team_leader_id) REFERENCES volunteer(user_id) ON DELETE SET NULL,
    FOREIGN KEY (incident_id) REFERENCES incidents(incident_id) ON DELETE SET NULL,
    FOREIGN KEY (location_id) REFERENCES Location(loc_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Response teams deployment';

-- ============================================================================
-- 13. EVACUATIONS Table
-- ============================================================================
-- Tracks people evacuated from disaster zones
CREATE TABLE IF NOT EXISTS evacuations (
    evacuation_id INT AUTO_INCREMENT PRIMARY KEY,
    incident_id INT,
    from_location_id INT COMMENT 'Location evacuated from',
    to_location_id INT COMMENT 'Shelter/safe location',
    people_count INT NOT NULL,
    evacuation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    coordinated_by INT COMMENT 'Admin who coordinated',
    team_id INT COMMENT 'Team that performed evacuation',
    status ENUM('in_progress', 'completed', 'partial') DEFAULT 'in_progress',
    notes TEXT,
    INDEX idx_incident (incident_id),
    INDEX idx_date (evacuation_date DESC),
    FOREIGN KEY (incident_id) REFERENCES incidents(incident_id) ON DELETE SET NULL,
    FOREIGN KEY (from_location_id) REFERENCES Location(loc_id) ON DELETE SET NULL,
    FOREIGN KEY (to_location_id) REFERENCES Location(loc_id) ON DELETE SET NULL,
    FOREIGN KEY (coordinated_by) REFERENCES admin(user_id) ON DELETE SET NULL,
    FOREIGN KEY (team_id) REFERENCES teams_deployed(team_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Evacuation records';

-- ============================================================================
-- END OF DASHBOARD TABLES
-- ============================================================================
