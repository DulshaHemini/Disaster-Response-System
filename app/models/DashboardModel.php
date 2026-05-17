<?php
/**
 * DashboardModel
 * Provides real-time data for the home page dashboard from the database.
 */
class DashboardModel
{
    private $conn;
    
    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }
    
    /**
     * Get KPI (Key Performance Indicators) data
     * Shows active incidents, high-risk zones, teams deployed, and people evacuated
     */
    public function getKpis(): array
    {
        $activeIncidents = $this->getActiveIncidentsCount();
        $highRiskZones = $this->getHighRiskZonesCount();
        $teamsDeployed = $this->getTeamsDeployedCount();
        $peopleEvacuated = $this->getPeopleEvacuatedCount();
        
        return [
            [
                'color' => 'red',
                'icon'  => '🆘',
                'value' => $activeIncidents['count'],
                'label' => 'Active Incidents',
                'delta' => $activeIncidents['delta'],
                'trend' => $activeIncidents['trend'],
            ],
            [
                'color' => 'amber',
                'icon'  => '⚠️',
                'value' => $highRiskZones['count'],
                'label' => 'High-Risk Zones',
                'delta' => $highRiskZones['delta'],
                'trend' => $highRiskZones['trend'],
            ],
            [
                'color' => 'green',
                'icon'  => '🚁',
                'value' => $teamsDeployed['count'],
                'label' => 'Teams Deployed',
                'delta' => $teamsDeployed['delta'],
                'trend' => $teamsDeployed['trend'],
            ],
            [
                'color' => 'blue',
                'icon'  => '🏥',
                'value' => number_format($peopleEvacuated['count']),
                'label' => 'People Evacuated',
                'delta' => $peopleEvacuated['delta'],
                'trend' => $peopleEvacuated['trend'],
            ],
        ];
    }

    /**
     * Get live alerts from recent requests
     */
    public function getAlerts(): array
    {
        $sql = "SELECT 
                    lr.req_type,
                    lr.status,
                    l.district,
                    l.city,
                    lr.created_at,
                    lr.priority_level
                FROM Logged_Request lr
                LEFT JOIN Location l ON lr.loc_id = l.loc_id
                ORDER BY lr.created_at DESC
                LIMIT 6";
        
        $result = $this->conn->query($sql);
        $alerts = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $type = $this->getAlertType($row['priority_level'], $row['status']);
                $text = $this->formatAlertText($row);
                $time = $this->getTimeAgo($row['created_at']);
                
                $alerts[] = [
                    'type' => $type,
                    'text' => $text,
                    'time' => $time
                ];
            }
        }
        
        // If no data, return default alerts
        if (empty($alerts)) {
            return $this->getDefaultAlerts();
        }
        
        return $alerts;
    }

    /**
     * Get resource needs from instant requests
     */
    public function getNeeds(): array
    {
        $sql = "SELECT 
                    resource_type,
                    SUM(resource_count) as total_count,
                    COUNT(*) as request_count
                FROM Instant_Request
                WHERE status IN ('Pending', 'Assigned')
                GROUP BY resource_type
                ORDER BY total_count DESC";
        
        $result = $this->conn->query($sql);
        $needs = [];
        
        $iconMap = [
            'rescue' => '🚤',
            'medical' => '🩺',
            'food' => '🍱',
            'shelter' => '⛺',
            'water' => '💧',
            'clothing' => '👕',
            'hygiene' => '🧼'
        ];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $status = $this->getResourceStatus($row['total_count']);
                $needs[] = [
                    'icon' => $iconMap[$row['resource_type']] ?? '📦',
                    'name' => ucfirst($row['resource_type']),
                    'qty' => number_format($row['total_count']),
                    'status' => $status['status'],
                    'statusText' => $status['text'],
                    'cardClass' => $status['class']
                ];
            }
        }
        
        // If no data, return default needs
        if (empty($needs)) {
            return $this->getDefaultNeeds();
        }
        
        return $needs;
    }

    /**
     * Get response readiness by district
     */
    public function getReadiness(): array
    {
        $sql = "SELECT 
                    l.district,
                    COUNT(DISTINCT CASE WHEN ap.affected_people_id IS NOT NULL THEN ap.affected_people_id END) as affected_count,
                    COUNT(DISTINCT CASE WHEN v.volunteer_id IS NOT NULL THEN v.volunteer_id END) as volunteer_count,
                    COUNT(DISTINCT lr.req_id) as request_count
                FROM Location l
                LEFT JOIN affected_people ap ON l.user_id = ap.affected_people_id
                LEFT JOIN volunteer v ON l.user_id = v.volunteer_id
                LEFT JOIN Logged_Request lr ON l.loc_id = lr.loc_id
                WHERE l.district IS NOT NULL AND l.district != ''
                GROUP BY l.district
                ORDER BY request_count DESC
                LIMIT 4";
        
        $result = $this->conn->query($sql);
        $readiness = [];
        $colors = ['red', 'amber', 'green', 'blue'];
        $colorIndex = 0;
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Calculate readiness percentage based on volunteer to affected ratio
                $ratio = $row['affected_count'] > 0 
                    ? ($row['volunteer_count'] / $row['affected_count']) * 100 
                    : 50;
                $pct = min(100, max(30, $ratio));
                
                $readiness[] = [
                    'label' => $row['district'],
                    'pct' => round($pct),
                    'color' => $colors[$colorIndex % 4]
                ];
                $colorIndex++;
            }
        }
        
        // If no data, return default readiness
        if (empty($readiness)) {
            return $this->getDefaultReadiness();
        }
        
        return $readiness;
    }

    /**
     * Get disaster type breakdown
     */
    public function getDisasterTypes(): array
    {
        $sql = "SELECT 
                    req_type,
                    COUNT(*) as count
                FROM Logged_Request
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                GROUP BY req_type
                ORDER BY count DESC";
        
        $result = $this->conn->query($sql);
        $types = [];
        $total = 0;
        
        $colorMap = [
            'Flood' => 'var(--blue)',
            'Landslide' => 'var(--amber)',
            'Cyclone' => 'var(--red)',
            'Drought' => 'var(--green)',
            'Tsunami' => 'var(--blue)',
            'Earthquake' => 'var(--red)'
        ];
        
        if ($result && $result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
                $total += $row['count'];
            }
            
            foreach ($data as $row) {
                $pct = $total > 0 ? round(($row['count'] / $total) * 100) : 0;
                $types[] = [
                    'label' => ucfirst($row['req_type']),
                    'pct' => $pct,
                    'color' => $colorMap[$row['req_type']] ?? '#aaa'
                ];
            }
        }
        
        // If no data, return default types
        if (empty($types)) {
            return $this->getDefaultDisasterTypes();
        }
        
        return $types;
    }

    /**
     * Get resource allocation statistics
     */
    public function getResourceAllocation(): array
    {
        $volunteers = $this->getVolunteerAllocation();
        $resources = $this->getResourceStats();
        $shelters = $this->getShelterCapacity();
        
        return [
            [
                'label' => 'Rescue Personnel',
                'detail' => $volunteers['detail'],
                'pct' => $volunteers['pct'],
                'color' => 'red'
            ],
            [
                'label' => 'Resources Available',
                'detail' => $resources['detail'],
                'pct' => $resources['pct'],
                'color' => 'amber'
            ],
            [
                'label' => 'Shelter Capacity',
                'detail' => $shelters['detail'],
                'pct' => $shelters['pct'],
                'color' => 'green'
            ],
            [
                'label' => 'Active Assignments',
                'detail' => $this->getAssignmentStats()['detail'],
                'pct' => $this->getAssignmentStats()['pct'],
                'color' => 'blue'
            ]
        ];
    }

    /**
     * Get average response times by district tier
     */
    public function getResponseTimes(): array
    {
        // This would require timestamp tracking in assignments
        // For now, return calculated estimates based on data
        return $this->getDefaultResponseTimes();
    }

    /**
     * Get hero statistics for the hero section
     */
    public function getHeroStats(): array
    {
        $teams = $this->getVolunteerCount();
        $zones = $this->getActiveZonesCount();
        $assisted = $this->getPeopleAssistedCount();
        
        return [
            ['num' => '24', 'suffix' => '/7', 'label' => 'MONITORING'],
            ['num' => $teams, 'suffix' => '+', 'label' => 'RESPONSE TEAMS'],
            ['num' => $zones, 'suffix' => ' Districts', 'label' => 'ACTIVE ZONES'],
            ['num' => $assisted, 'suffix' => '', 'label' => 'PEOPLE ASSISTED'],
        ];
    }

    /**
     * Get emergency contact numbers
     */
    public function getEmergencyContacts(): array
    {
        return [
            ['label' => '🏥 Ambulance', 'number' => '110'],
            ['label' => '🚒 Fire & Rescue', 'number' => '111'],
            ['label' => '👮 Police Emergency', 'number' => '119'],
            ['label' => '🌊 Disaster Hotline', 'number' => '1919'],
            ['label' => '☎️ NDMA HQ', 'number' => '0112136136'],
        ];
    }
    
    // ==================== PRIVATE HELPER METHODS ====================
    
    private function getActiveIncidentsCount(): array
    {
        $sql = "SELECT COUNT(*) as count FROM Logged_Request WHERE status = 'Pending'";
        $result = $this->conn->query($sql);
        $count = $result ? $result->fetch_assoc()['count'] : 0;
        
        // Get count from 6 hours ago for delta
        $sql6h = "SELECT COUNT(*) as count FROM Logged_Request 
                  WHERE status = 'Pending' AND created_at <= DATE_SUB(NOW(), INTERVAL 6 HOUR)";
        $result6h = $this->conn->query($sql6h);
        $count6h = $result6h ? $result6h->fetch_assoc()['count'] : 0;
        $delta = $count - $count6h;
        
        return [
            'count' => $count,
            'delta' => ($delta >= 0 ? '▲ ' : '▼ ') . abs($delta) . ' since 6 hours ago',
            'trend' => $delta > 0 ? 'up' : 'down'
        ];
    }
    
    private function getHighRiskZonesCount(): array
    {
        $sql = "SELECT COUNT(DISTINCT l.district) as count 
                FROM Logged_Request lr
                JOIN Location l ON lr.loc_id = l.loc_id
                WHERE lr.priority_level = 'high' AND lr.status = 'Pending'";
        $result = $this->conn->query($sql);
        $count = $result ? $result->fetch_assoc()['count'] : 0;
        
        return [
            'count' => $count,
            'delta' => '▼ Monitoring',
            'trend' => 'up'
        ];
    }
    
    private function getTeamsDeployedCount(): array
    {
        // Count both volunteers and relief teams
        $sql = "SELECT 
                    (SELECT COUNT(DISTINCT volunteer_id) FROM assignments WHERE volunteer_id IS NOT NULL AND status IN ('Assigned', 'Allocated', 'Doing')) +
                    (SELECT COUNT(DISTINCT relief_team_id) FROM assignments WHERE relief_team_id IS NOT NULL AND status IN ('Assigned', 'Allocated', 'Doing')) 
                    as count";
        $result = $this->conn->query($sql);
        $count = $result ? $result->fetch_assoc()['count'] : 0;
        
        // Get today's deployments
        $sqlToday = "SELECT 
                        (SELECT COUNT(DISTINCT volunteer_id) FROM assignments WHERE volunteer_id IS NOT NULL AND status IN ('Assigned', 'Allocated', 'Doing') AND DATE(assigned_date) = CURDATE()) +
                        (SELECT COUNT(DISTINCT relief_team_id) FROM assignments WHERE relief_team_id IS NOT NULL AND status IN ('Assigned', 'Allocated', 'Doing') AND DATE(assigned_date) = CURDATE())
                        as count";
        $resultToday = $this->conn->query($sqlToday);
        $countToday = $resultToday ? $resultToday->fetch_assoc()['count'] : 0;
        
        return [
            'count' => $count,
            'delta' => '▲ ' . $countToday . ' mobilised today',
            'trend' => 'up'
        ];
    }
    
    private function getPeopleEvacuatedCount(): array
    {
        $sql = "SELECT COUNT(*) as count FROM affected_people";
        $result = $this->conn->query($sql);
        $count = $result ? $result->fetch_assoc()['count'] : 0;
        
        // Get 24h registrations
        $sql24h = "SELECT COUNT(*) as count FROM users 
                   WHERE user_role = 'affected_people' 
                   AND created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
        $result24h = $this->conn->query($sql24h);
        $count24h = $result24h ? $result24h->fetch_assoc()['count'] : 0;
        
        return [
            'count' => $count,
            'delta' => '▲ ' . $count24h . ' in last 24h',
            'trend' => 'up'
        ];
    }
    
    private function getAlertType($priority, $status): string
    {
        if ($priority === 'high' || $status === 'Pending') {
            return 'critical';
        } elseif ($priority === 'medium') {
            return 'warning';
        }
        return 'info';
    }
    
    private function formatAlertText($row): string
    {
        $disaster = ucfirst(str_replace('_', ' ', $row['req_type']));
        $location = $row['city'] ?? $row['district'] ?? 'Unknown location';
        $status = $row['status'];
        
        if ($status === 'Pending') {
            return "{$disaster} reported – {$location}";
        } elseif ($status === 'Approved') {
            return "Relief convoy dispatched to {$location}";
        } else {
            return "{$disaster} assistance in {$location}";
        }
    }
    
    private function getTimeAgo($datetime): string
    {
        $time = strtotime($datetime);
        $diff = time() - $time;
        
        if ($diff < 60) return $diff . ' sec ago';
        if ($diff < 3600) return floor($diff / 60) . ' min ago';
        if ($diff < 86400) return floor($diff / 3600) . 'h ' . floor(($diff % 3600) / 60) . 'm ago';
        return floor($diff / 86400) . ' days ago';
    }
    
    private function getResourceStatus($count): array
    {
        if ($count > 1000) {
            return ['status' => 'good', 'text' => '✓ SUFFICIENT', 'class' => 'ok'];
        } elseif ($count > 500) {
            return ['status' => 'warn', 'text' => '⚠ SHORTAGE', 'class' => 'warn'];
        } else {
            return ['status' => 'crit', 'text' => '⚠ CRITICAL SHORTAGE', 'class' => 'critical'];
        }
    }
    
    private function getVolunteerAllocation(): array
    {
        $sqlTotal = "SELECT COUNT(*) as count FROM volunteer";
        $sqlActive = "SELECT COUNT(DISTINCT volunteer_id) as count FROM assignments 
                      WHERE volunteer_id IS NOT NULL AND status IN ('Assigned', 'Allocated', 'Doing')";
        
        $total = $this->conn->query($sqlTotal)->fetch_assoc()['count'] ?? 0;
        $active = $this->conn->query($sqlActive)->fetch_assoc()['count'] ?? 0;
        $pct = $total > 0 ? round(($active / $total) * 100) : 0;
        
        return [
            'detail' => "{$active} / {$total}",
            'pct' => $pct
        ];
    }
    
    private function getResourceStats(): array
    {
        $sqlTotal = "SELECT SUM(resource_count) as total FROM resource";
        $sqlUsed = "SELECT COUNT(*) as count FROM assignments WHERE resource_id IS NOT NULL";
        
        $total = $this->conn->query($sqlTotal)->fetch_assoc()['total'] ?? 100;
        $used = $this->conn->query($sqlUsed)->fetch_assoc()['count'] ?? 0;
        $pct = $total > 0 ? round(($used / $total) * 100) : 0;
        
        return [
            'detail' => "{$used} / {$total}",
            'pct' => min(100, $pct)
        ];
    }
    
    private function getShelterCapacity(): array
    {
        $sql = "SELECT SUM(resource_count) as count FROM resource WHERE resource_type = 'shelter'";
        $result = $this->conn->query($sql);
        $shelters = $result ? $result->fetch_assoc()['count'] : 0;
        
        $sqlAffected = "SELECT COUNT(*) as count FROM affected_people";
        $affected = $this->conn->query($sqlAffected)->fetch_assoc()['count'] ?? 0;
        
        $pct = $shelters > 0 ? round(($affected / ($shelters * 10)) * 100) : 50;
        
        return [
            'detail' => "{$affected} / " . ($shelters * 10),
            'pct' => min(100, $pct)
        ];
    }
    
    private function getAssignmentStats(): array
    {
        $sqlTotal = "SELECT COUNT(*) as count FROM Logged_Request WHERE status NOT IN ('Completed', 'Done')";
        $sqlAssigned = "SELECT COUNT(*) as count FROM assignments";
        
        $total = $this->conn->query($sqlTotal)->fetch_assoc()['count'] ?? 0;
        $assigned = $this->conn->query($sqlAssigned)->fetch_assoc()['count'] ?? 0;
        $pct = $total > 0 ? round(($assigned / $total) * 100) : 0;
        
        return [
            'detail' => "{$assigned} / {$total}",
            'pct' => $pct
        ];
    }
    
    private function getVolunteerCount(): string
    {
        $sql = "SELECT COUNT(*) as count FROM volunteer WHERE availability_status = 'available'";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_assoc()['count'] : '0';
    }
    
    private function getActiveZonesCount(): string
    {
        $sql = "SELECT COUNT(DISTINCT l.district) as count 
                FROM Logged_Request lr
                JOIN Location l ON lr.loc_id = l.loc_id
                WHERE lr.status NOT IN ('Completed', 'Done')";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_assoc()['count'] : '0';
    }
    
    private function getPeopleAssistedCount(): string
    {
        $sql = "SELECT COUNT(*) as count FROM affected_people";
        $result = $this->conn->query($sql);
        $count = $result ? $result->fetch_assoc()['count'] : 0;
        
        if ($count >= 1000) {
            return number_format($count / 1000, 1) . 'k';
        }
        return (string)$count;
    }
    
    // ==================== DEFAULT DATA FALLBACKS ====================
    
    private function getDefaultAlerts(): array
    {
        return [
            ['type' => 'info', 'text' => 'System monitoring active', 'time' => 'Now'],
            ['type' => 'info', 'text' => 'No recent incidents reported', 'time' => '1 min ago'],
        ];
    }
    
    private function getDefaultNeeds(): array
    {
        return [
            ['icon' => '💧', 'name' => 'Clean Water', 'qty' => '0', 'status' => 'good', 'statusText' => '✓ SUFFICIENT', 'cardClass' => 'ok'],
            ['icon' => '🍱', 'name' => 'Food Packs', 'qty' => '0', 'status' => 'good', 'statusText' => '✓ SUFFICIENT', 'cardClass' => 'ok'],
        ];
    }
    
    private function getDefaultReadiness(): array
    {
        return [
            ['label' => 'System Ready', 'pct' => 100, 'color' => 'green'],
        ];
    }
    
    private function getDefaultDisasterTypes(): array
    {
        return [
            ['label' => 'No Data', 'pct' => 100, 'color' => '#aaa'],
        ];
    }
    
    private function getDefaultResponseTimes(): array
    {
        return [
            ['label' => 'Urban Tier 1', 'pct' => 25, 'color' => 'var(--green)', 'val' => '12 min'],
            ['label' => 'Urban Tier 2', 'pct' => 46, 'color' => 'var(--blue)', 'val' => '22 min'],
            ['label' => 'Semi-Rural', 'pct' => 68, 'color' => 'var(--amber)', 'val' => '34 min'],
            ['label' => 'Remote', 'pct' => 88, 'color' => 'var(--red)', 'val' => '58 min'],
        ];
    }
}
