-- ============================================================================
-- DASHBOARD DATA INSERTION FOR DISASTER RESPONSE SYSTEM
-- ============================================================================
-- This SQL file inserts sample data into the dashboard tables to match
-- the data currently hardcoded in DashboardModel.php
-- ============================================================================

USE DRCS;

-- ============================================================================
-- 1. INSERT KPI METRICS
-- ============================================================================
INSERT INTO kpi_metrics (color, icon, value, label, delta, trend, display_order, is_active) VALUES
('red', '🆘', '18', 'Active Incidents', '▲ 3 since 6 hours ago', 'down', 1, 1),
('amber', '⚠️', '7', 'High-Risk Zones', '▼ 2 since yesterday', 'up', 2, 1),
('green', '🚁', '142', 'Teams Deployed', '▲ 12 mobilised today', 'up', 3, 1),
('blue', '🏥', '3,214', 'People Evacuated', '▲ 480 in last 24h', 'up', 4, 1);

-- ============================================================================
-- 2. INSERT ALERTS
-- ============================================================================
INSERT INTO alerts (alert_type, alert_text, location, created_at, is_active) VALUES
('critical', 'Flash flood reported – Baddegama, Galle', 'Baddegama, Galle', DATE_SUB(NOW(), INTERVAL 2 MINUTE), 1),
('warning', 'Landslide risk elevated – Ratnapura', 'Ratnapura', DATE_SUB(NOW(), INTERVAL 14 MINUTE), 1),
('info', 'Relief convoy dispatched to Matara', 'Matara', DATE_SUB(NOW(), INTERVAL 31 MINUTE), 1),
('critical', 'Road closure: A2 Highway blocked by debris', 'A2 Highway', DATE_SUB(NOW(), INTERVAL 52 MINUTE), 1),
('warning', 'Shelter capacity at 87% – Kalutara', 'Kalutara', DATE_SUB(NOW(), INTERVAL 70 MINUTE), 1),
('info', 'Medical team air-lifted to Hambantota', 'Hambantota', DATE_SUB(NOW(), INTERVAL 2 HOUR), 1);

-- ============================================================================
-- 3. INSERT RESOURCE NEEDS
-- ============================================================================
INSERT INTO resource_needs (icon, resource_name, quantity, status, status_text, card_class, priority, is_active) VALUES
('💧', 'Clean Water', '4,200 L', 'crit', '⚠ CRITICAL SHORTAGE', 'critical', 10, 1),
('🍱', 'Food Packs', '1,850', 'crit', '⚠ LOW STOCK', 'critical', 9, 1),
('🩺', 'Medical Kits', '320', 'good', '✓ SUFFICIENT', 'ok', 5, 1),
('⛺', 'Tents / Shelter', '210', 'warn', '⚠ SHORTAGE', 'warn', 7, 1),
('👕', 'Clothing Sets', '950', 'good', '✓ ADEQUATE', 'ok', 4, 1),
('🚤', 'Rescue Boats', '8', 'crit', '⚠ CRITICAL LOW', 'critical', 8, 1),
('🔋', 'Power Units', '45', 'warn', '⚠ NEEDED', 'warn', 6, 1),
('📻', 'Comm. Radios', '130', 'good', '✓ SUFFICIENT', 'ok', 3, 1);

-- ============================================================================
-- 4. INSERT RESPONSE READINESS
-- ============================================================================
INSERT INTO response_readiness (region_label, percentage, color, last_assessment_date, is_active) VALUES
('Southern Province', 82, 'red', NOW(), 1),
('Sabaragamuwa', 67, 'amber', NOW(), 1),
('Western Province', 91, 'green', NOW(), 1),
('Eastern Province', 58, 'blue', NOW(), 1);

-- ============================================================================
-- 5. INSERT DISASTER TYPE STATISTICS
-- ============================================================================
INSERT INTO disaster_type_stats (disaster_label, percentage, color, incident_count, period_start, period_end, is_current) VALUES
('Flooding', 74, 'var(--blue)', 148, DATE_SUB(CURDATE(), INTERVAL 30 DAY), CURDATE(), 1),
('Landslides', 52, 'var(--amber)', 104, DATE_SUB(CURDATE(), INTERVAL 30 DAY), CURDATE(), 1),
('Cyclones', 31, 'var(--red)', 62, DATE_SUB(CURDATE(), INTERVAL 30 DAY), CURDATE(), 1),
('Droughts', 22, 'var(--green)', 44, DATE_SUB(CURDATE(), INTERVAL 30 DAY), CURDATE(), 1),
('Other', 14, '#aaa', 28, DATE_SUB(CURDATE(), INTERVAL 30 DAY), CURDATE(), 1);

-- ============================================================================
-- 6. INSERT RESOURCE ALLOCATION STATS
-- ============================================================================
INSERT INTO resource_allocation_stats (resource_label, detail, current_value, max_value, percentage, color, category, is_active) VALUES
('Rescue Personnel', '1,840 / 2,200', 1840, 2200, 84, 'red', 'personnel', 1),
('Vehicles Deployed', '280 / 400', 280, 400, 70, 'amber', 'vehicles', 1),
('Shelter Capacity', '9,200 / 12,000', 9200, 12000, 77, 'green', 'shelter', 1),
('Medical Units', '46 / 60', 46, 60, 77, 'blue', 'medical', 1);

-- ============================================================================
-- 7. INSERT RESPONSE TIMES
-- ============================================================================
INSERT INTO response_times (tier_label, percentage, color, avg_minutes, display_value, tier_order, measurement_period_start, measurement_period_end, is_current) VALUES
('Urban Tier 1', 25, 'var(--green)', 12, '12 min', 1, DATE_SUB(CURDATE(), INTERVAL 30 DAY), CURDATE(), 1),
('Urban Tier 2', 46, 'var(--blue)', 22, '22 min', 2, DATE_SUB(CURDATE(), INTERVAL 30 DAY), CURDATE(), 1),
('Semi-Rural', 68, 'var(--amber)', 34, '34 min', 3, DATE_SUB(CURDATE(), INTERVAL 30 DAY), CURDATE(), 1),
('Remote', 88, 'var(--red)', 58, '58 min', 4, DATE_SUB(CURDATE(), INTERVAL 30 DAY), CURDATE(), 1);

-- ============================================================================
-- 8. INSERT HERO STATISTICS
-- ============================================================================
INSERT INTO hero_statistics (stat_number, suffix, label, display_order, is_active) VALUES
('24', '/7', 'MONITORING', 1, 1),
('142', '+', 'RESPONSE TEAMS', 2, 1),
('9', ' Districts', 'ACTIVE ZONES', 3, 1),
('3.2', 'k', 'PEOPLE ASSISTED', 4, 1);

-- ============================================================================
-- 9. INSERT EMERGENCY CONTACTS
-- ============================================================================
INSERT INTO emergency_contacts (label, phone_number, category, display_order, is_active) VALUES
('🏥 Ambulance', '110', 'medical', 1, 1),
('🚒 Fire & Rescue', '111', 'fire', 2, 1),
('👮 Police Emergency', '119', 'police', 3, 1),
('🌊 Disaster Hotline', '1919', 'disaster', 4, 1),
('☎️ NDMA HQ', '0112136136', 'disaster', 5, 1);

-- ============================================================================
-- 10. INSERT SAMPLE INCIDENTS
-- ============================================================================
INSERT INTO incidents (incident_name, incident_type, severity, status, district, city, affected_people_count, casualties, description, created_at) VALUES
('Flash Flood - Baddegama', 'flooding', 'critical', 'active', 'Galle', 'Baddegama', 450, 2, 'Severe flash flooding due to heavy rainfall', DATE_SUB(NOW(), INTERVAL 2 HOUR)),
('Landslide - Ratnapura Central', 'landslides', 'high', 'active', 'Ratnapura', 'Ratnapura', 280, 5, 'Major landslide blocking main road', DATE_SUB(NOW(), INTERVAL 5 HOUR)),
('Coastal Flooding - Matara', 'flooding', 'high', 'monitoring', 'Matara', 'Matara', 620, 0, 'Coastal areas affected by high tide', DATE_SUB(NOW(), INTERVAL 8 HOUR)),
('Cyclone Warning - Hambantota', 'cyclones', 'critical', 'active', 'Hambantota', 'Hambantota', 1200, 1, 'Cyclone approaching coastal areas', DATE_SUB(NOW(), INTERVAL 12 HOUR)),
('Drought - Anuradhapura', 'droughts', 'medium', 'monitoring', 'Anuradhapura', 'Anuradhapura', 3500, 0, 'Prolonged drought affecting agriculture', DATE_SUB(NOW(), INTERVAL 15 DAY)),
('Landslide - Kandy Hills', 'landslides', 'high', 'active', 'Kandy', 'Kandy', 180, 3, 'Hill area landslide affecting multiple homes', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('Flash Flood - Kalutara', 'flooding', 'high', 'active', 'Kalutara', 'Kalutara', 890, 1, 'River overflow causing widespread flooding', DATE_SUB(NOW(), INTERVAL 6 HOUR)),
('Landslide Risk - Nuwara Eliya', 'landslides', 'medium', 'monitoring', 'Nuwara Eliya', 'Nuwara Eliya', 150, 0, 'Elevated landslide risk due to soil saturation', DATE_SUB(NOW(), INTERVAL 3 HOUR)),
('Coastal Erosion - Galle', 'flooding', 'medium', 'monitoring', 'Galle', 'Galle', 320, 0, 'Coastal erosion threatening homes', DATE_SUB(NOW(), INTERVAL 2 DAY)),
('Tornado - Jaffna', 'tornadoes', 'high', 'active', 'Jaffna', 'Jaffna', 240, 4, 'Tornado damage to residential areas', DATE_SUB(NOW(), INTERVAL 10 HOUR)),
('Heat Wave - Puttalam', 'heat waves', 'medium', 'monitoring', 'Puttalam', 'Puttalam', 1800, 0, 'Extreme heat affecting vulnerable populations', DATE_SUB(NOW(), INTERVAL 4 DAY)),
('Flood - Colombo Suburbs', 'flooding', 'high', 'active', 'Colombo', 'Colombo', 1500, 0, 'Urban flooding in low-lying areas', DATE_SUB(NOW(), INTERVAL 4 HOUR)),
('Landslide - Badulla', 'landslides', 'critical', 'active', 'Badulla', 'Badulla', 95, 8, 'Massive landslide burying homes', DATE_SUB(NOW(), INTERVAL 18 HOUR)),
('Drought - Monaragala', 'droughts', 'high', 'monitoring', 'Monaragala', 'Monaragala', 2200, 0, 'Severe water shortage', DATE_SUB(NOW(), INTERVAL 20 DAY)),
('Cyclone Aftermath - Trincomalee', 'cyclones', 'medium', 'monitoring', 'Trincomalee', 'Trincomalee', 680, 2, 'Recovery operations after cyclone', DATE_SUB(NOW(), INTERVAL 3 DAY)),
('Flash Flood - Kurunegala', 'flooding', 'high', 'active', 'Kurunegala', 'Kurunegala', 420, 1, 'Sudden flooding from dam overflow', DATE_SUB(NOW(), INTERVAL 7 HOUR)),
('Landslide - Kegalle', 'landslides', 'high', 'active', 'Kegalle', 'Kegalle', 310, 6, 'Multiple landslides in hilly terrain', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('Tsunami Warning - Southern Coast', 'tsunamis', 'critical', 'monitoring', 'Galle', 'Multiple', 5000, 0, 'Tsunami warning issued for southern coast', DATE_SUB(NOW(), INTERVAL 30 MINUTE));

-- ============================================================================
-- 11. INSERT HIGH RISK ZONES
-- ============================================================================
INSERT INTO high_risk_zones (zone_name, district, city, risk_level, risk_type, population_at_risk, status, identified_date) VALUES
('Ratnapura Hill Slopes', 'Ratnapura', 'Ratnapura', 'critical', 'landslides', 1200, 'active', DATE_SUB(CURDATE(), INTERVAL 2 DAY)),
('Galle Coastal Belt', 'Galle', 'Galle', 'high', 'flooding', 3500, 'active', DATE_SUB(CURDATE(), INTERVAL 5 DAY)),
('Kalutara River Basin', 'Kalutara', 'Kalutara', 'high', 'flooding', 2800, 'active', DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
('Kandy Central Hills', 'Kandy', 'Kandy', 'high', 'landslides', 950, 'monitoring', DATE_SUB(CURDATE(), INTERVAL 3 DAY)),
('Hambantota Coastal Area', 'Hambantota', 'Hambantota', 'critical', 'cyclones', 4200, 'active', DATE_SUB(CURDATE(), INTERVAL 1 DAY)),
('Badulla Mountain Region', 'Badulla', 'Badulla', 'high', 'landslides', 680, 'active', DATE_SUB(CURDATE(), INTERVAL 4 DAY)),
('Matara Low-lying Areas', 'Matara', 'Matara', 'medium', 'flooding', 1500, 'monitoring', DATE_SUB(CURDATE(), INTERVAL 7 DAY));

-- ============================================================================
-- 12. INSERT TEAMS DEPLOYED
-- ============================================================================
-- Note: Using volunteer user_ids 3, 4, 5 from the existing test data
INSERT INTO teams_deployed (team_name, team_type, team_leader_id, team_size, deployment_status, deployed_at, notes) VALUES
('Alpha Rescue Team', 'rescue', 3, 12, 'deployed', DATE_SUB(NOW(), INTERVAL 3 HOUR), 'Deployed to Baddegama flood zone'),
('Bravo Medical Unit', 'medical', 4, 8, 'deployed', DATE_SUB(NOW(), INTERVAL 5 HOUR), 'Medical support in Ratnapura'),
('Charlie Relief Team', 'relief', 5, 15, 'deployed', DATE_SUB(NOW(), INTERVAL 2 HOUR), 'Food and water distribution in Matara'),
('Delta Assessment Team', 'assessment', 3, 6, 'en_route', DATE_SUB(NOW(), INTERVAL 1 HOUR), 'Heading to Hambantota'),
('Echo Rescue Team', 'rescue', 4, 10, 'deployed', DATE_SUB(NOW(), INTERVAL 6 HOUR), 'Search and rescue in Kandy'),
('Foxtrot Logistics Team', 'logistics', 5, 8, 'deployed', DATE_SUB(NOW(), INTERVAL 4 HOUR), 'Supply chain coordination'),
('Golf Medical Unit', 'medical', 3, 7, 'deployed', DATE_SUB(NOW(), INTERVAL 8 HOUR), 'Field hospital setup in Kalutara'),
('Hotel Relief Team', 'relief', 4, 12, 'deployed', DATE_SUB(NOW(), INTERVAL 7 HOUR), 'Shelter management in Galle'),
('India Rescue Team', 'rescue', 5, 14, 'deployed', DATE_SUB(NOW(), INTERVAL 9 HOUR), 'Water rescue operations'),
('Juliet Assessment Team', 'assessment', 3, 5, 'standby', NOW(), 'Ready for deployment');

-- Additional teams to reach 142 total (adding 132 more generic entries)
INSERT INTO teams_deployed (team_name, team_type, team_size, deployment_status, deployed_at)
SELECT 
    CONCAT('Team-', LPAD(n, 3, '0')) as team_name,
    ELT(FLOOR(1 + RAND() * 5), 'rescue', 'medical', 'relief', 'assessment', 'logistics') as team_type,
    FLOOR(5 + RAND() * 15) as team_size,
    ELT(FLOOR(1 + RAND() * 3), 'deployed', 'en_route', 'standby') as deployment_status,
    DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 48) HOUR) as deployed_at
FROM (
    SELECT @row := @row + 1 as n
    FROM (SELECT 0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
         (SELECT 0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
         (SELECT 0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
         (SELECT @row := 10) r
    LIMIT 132
) numbers;

-- ============================================================================
-- 13. INSERT EVACUATIONS
-- ============================================================================
INSERT INTO evacuations (people_count, evacuation_date, status, notes) VALUES
(480, DATE_SUB(NOW(), INTERVAL 2 HOUR), 'completed', 'Emergency evacuation from flood zone'),
(320, DATE_SUB(NOW(), INTERVAL 5 HOUR), 'completed', 'Landslide area evacuation'),
(250, DATE_SUB(NOW(), INTERVAL 8 HOUR), 'completed', 'Coastal area evacuation'),
(180, DATE_SUB(NOW(), INTERVAL 12 HOUR), 'completed', 'Cyclone preparedness evacuation'),
(420, DATE_SUB(NOW(), INTERVAL 1 DAY), 'completed', 'Flood zone evacuation'),
(290, DATE_SUB(NOW(), INTERVAL 1 DAY), 'completed', 'High-risk area evacuation'),
(380, DATE_SUB(NOW(), INTERVAL 2 DAY), 'completed', 'Preventive evacuation'),
(210, DATE_SUB(NOW(), INTERVAL 2 DAY), 'completed', 'Emergency shelter relocation'),
(340, DATE_SUB(NOW(), INTERVAL 3 DAY), 'completed', 'Disaster zone evacuation'),
(344, DATE_SUB(NOW(), INTERVAL 3 DAY), 'completed', 'Mass evacuation operation');

-- ============================================================================
-- VERIFICATION QUERIES
-- ============================================================================
-- Uncomment these to verify the data was inserted correctly

-- SELECT 'KPI Metrics Count:' as Info, COUNT(*) as Count FROM kpi_metrics;
-- SELECT 'Alerts Count:' as Info, COUNT(*) as Count FROM alerts;
-- SELECT 'Resource Needs Count:' as Info, COUNT(*) as Count FROM resource_needs;
-- SELECT 'Response Readiness Count:' as Info, COUNT(*) as Count FROM response_readiness;
-- SELECT 'Disaster Type Stats Count:' as Info, COUNT(*) as Count FROM disaster_type_stats;
-- SELECT 'Resource Allocation Stats Count:' as Info, COUNT(*) as Count FROM resource_allocation_stats;
-- SELECT 'Response Times Count:' as Info, COUNT(*) as Count FROM response_times;
-- SELECT 'Hero Statistics Count:' as Info, COUNT(*) as Count FROM hero_statistics;
-- SELECT 'Emergency Contacts Count:' as Info, COUNT(*) as Count FROM emergency_contacts;
-- SELECT 'Incidents Count:' as Info, COUNT(*) as Count FROM incidents;
-- SELECT 'High Risk Zones Count:' as Info, COUNT(*) as Count FROM high_risk_zones;
-- SELECT 'Teams Deployed Count:' as Info, COUNT(*) as Count FROM teams_deployed;
-- SELECT 'Evacuations Count:' as Info, COUNT(*) as Count FROM evacuations;

-- ============================================================================
-- END OF DASHBOARD DATA INSERTION
-- ============================================================================
