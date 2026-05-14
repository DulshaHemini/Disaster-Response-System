-- ============================================================================
-- DASHBOARD TABLES - ONLY ESSENTIAL DYNAMIC DATA
-- ============================================================================
-- These tables store ONLY data that changes frequently and is displayed
-- on the homepage dashboard. Static reference data is in static-data.js
-- ============================================================================

USE DRCS;

-- ============================================================================
-- 1. INCIDENTS (Active disaster incidents - used in KPI cards)
-- ============================================================================
CREATE TABLE IF NOT EXISTS incidents(
    incident_id INT PRIMARY KEY AUTO_INCREMENT,
    incident_type ENUM('tornado', 'tsunami', 'landslide', 'flood', 'other') NOT NULL,
    severity ENUM('low', 'medium', 'high', 'critical') NOT NULL,
    loc_id INT,
    affected_count INT DEFAULT 0,
    status ENUM('active', 'resolved') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL,
    FOREIGN KEY (loc_id) REFERENCES Location(loc_id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_created (created_at DESC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Active disaster incidents';

-- ============================================================================
-- 2. ALERTS (Live alert feed - displayed in dashboard)
-- ============================================================================
CREATE TABLE IF NOT EXISTS alerts(
    alert_id INT PRIMARY KEY AUTO_INCREMENT,
    alert_type ENUM('critical', 'warning', 'info') NOT NULL,
    message TEXT NOT NULL,
    location VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active TINYINT(1) DEFAULT 1,
    INDEX idx_active (is_active, created_at DESC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Live alert feed';

-- ============================================================================
-- 3. TEAMS_DEPLOYED (Response teams - used in KPI "Teams Deployed")
-- ============================================================================
CREATE TABLE IF NOT EXISTS teams_deployed(
    team_id INT PRIMARY KEY AUTO_INCREMENT,
    team_leader_id INT,
    incident_id INT,
    team_size INT NOT NULL,
    status ENUM('deployed', 'standby', 'returned') DEFAULT 'deployed',
    deployed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    returned_at TIMESTAMP NULL,
    FOREIGN KEY (team_leader_id) REFERENCES volunteer(user_id) ON DELETE SET NULL,
    FOREIGN KEY (incident_id) REFERENCES incidents(incident_id) ON DELETE SET NULL,
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Response teams deployment';

-- ============================================================================
-- 4. EVACUATIONS (Evacuation records - used in KPI "People Evacuated")
-- ============================================================================
CREATE TABLE IF NOT EXISTS evacuations(
    evacuation_id INT PRIMARY KEY AUTO_INCREMENT,
    incident_id INT,
    from_location_id INT,
    people_count INT NOT NULL,
    evacuation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('in_progress', 'completed') DEFAULT 'in_progress',
    FOREIGN KEY (incident_id) REFERENCES incidents(incident_id) ON DELETE SET NULL,
    FOREIGN KEY (from_location_id) REFERENCES Location(loc_id) ON DELETE SET NULL,
    INDEX idx_incident (incident_id),
    INDEX idx_date (evacuation_date DESC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Evacuation records';

-- ============================================================================
-- 5. HIGH_RISK_ZONES (High-risk areas - used in KPI "High-Risk Zones")
-- ============================================================================
CREATE TABLE IF NOT EXISTS high_risk_zones(
    zone_id INT PRIMARY KEY AUTO_INCREMENT,
    district VARCHAR(50) NOT NULL,
    city VARCHAR(50),
    risk_level ENUM('low', 'medium', 'high', 'critical') NOT NULL,
    risk_type ENUM('tornado', 'tsunami', 'landslide', 'flood', 'multiple') NOT NULL,
    population_at_risk INT DEFAULT 0,
    status ENUM('active', 'cleared') DEFAULT 'active',
    identified_date DATE NOT NULL,
    last_assessment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_status (status, risk_level),
    INDEX idx_district (district)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='High-risk zones tracking';

-- ============================================================================
-- END OF DASHBOARD TABLES
-- ============================================================================

-- NOTES:
-- 1. KPI "Active Incidents" = COUNT(*) FROM incidents WHERE status='active'
-- 2. KPI "High-Risk Zones" = COUNT(*) FROM high_risk_zones WHERE status='active'
-- 3. KPI "Teams Deployed" = COUNT(*) FROM teams_deployed WHERE status='deployed'
-- 4. KPI "People Evacuated" = SUM(people_count) FROM evacuations WHERE DATE(evacuation_date) >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
-- 5. Alerts feed = SELECT * FROM alerts WHERE is_active=1 ORDER BY created_at DESC LIMIT 6
-- 6. All other dashboard data (needs, readiness, disaster breakdown, etc.) comes from DashboardModel.php
