<?php 
// Data passed from TrackerController via extract()
// $people - array of all affected people
// $total_people - total count of people
$tracker_assets_version = filemtime(BASE_PATH . '/public/assets/js/tracker/main.js');
$tracker_style_version = filemtime(BASE_PATH . '/public/assets/css/tracker.css');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tracker – DRCS · Disaster Response Coordination System</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Outfit:wght@300;400;500;600&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <!-- Theme CSS must be loaded first -->
    <link rel="stylesheet" href="../assets/css/theme.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/ticker.css">
    <link rel="stylesheet" href="../assets/css/tracker.css?v=<?php echo $tracker_style_version; ?>">
    
    <script defer src="../assets/js/tracker/config.js?v=<?php echo $tracker_assets_version; ?>"></script>
    <script defer src="../assets/js/tracker/helpers.js?v=<?php echo $tracker_assets_version; ?>"></script>
    <script defer src="../assets/js/tracker/map-handler.js?v=<?php echo $tracker_assets_version; ?>"></script>
    <script defer src="../assets/js/tracker/person-selection.js?v=<?php echo $tracker_assets_version; ?>"></script>
    <script defer src="../assets/js/tracker/details-panel.js?v=<?php echo $tracker_assets_version; ?>"></script>
    <script defer src="../assets/js/tracker/activity-modal.js?v=<?php echo $tracker_assets_version; ?>"></script>
    <script defer src="../assets/js/tracker/main.js?v=<?php echo $tracker_assets_version; ?>"></script>
</head>
<body>
    <!-- Include Navbar Component -->
    <?php include APP_PATH . '/views/home/_navbar.php'; ?>

    <!-- Include Ticker Component -->
    <?php include APP_PATH . '/views/home/_ticker.php'; ?>

    <!-- Left Sidebar -->
    <div class="left-sidebar">
        <div class="sidebar-header">
            <div class="section-pre" style="color:white;margin-bottom:.5rem">AFFECTED PEOPLE</div>
            <div class="total-count" id="total-count"><?php echo $total_people; ?> People</div>
        </div>
        <div class="people-list" id="people-list">
            <?php
            // Display people list
            foreach ($people as $person) {
                $initials = '';
                $name_parts = explode(' ', $person['full_name']);
                foreach ($name_parts as $part) {
                    $initials .= strtoupper($part[0]);
                }
                
                echo '<div class="person-item" id="person-' . $person['id'] . '" data-id="' . $person['id'] . '">';
                echo '<div class="person-item-header">';
                echo '<div class="person-avatar">' . $initials . '</div>';
                echo '<div class="person-item-info">';
                echo '<div class="person-item-name">' . $person['full_name'] . '</div>';
                echo '<div class="person-item-location">📍 ' . $person['district'] . '</div>';
                echo '</div>';
                echo '</div>';
                echo '<div class="person-item-footer">';
                echo '<span class="disaster-tag">🚨 ' . $person['disaster_type'] . '</span>';
                echo '<div class="person-actions">';
                echo '<button class="btn-focus" onclick="focusPerson(' . $person['id'] . ')">🎯 Focus</button>';
                echo '<button class="btn-details" onclick="openDetails(' . $person['id'] . ')">👁️ Details</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Map -->
    <div id="map"></div>

    <!-- Right Panel -->
    <div id="details-panel" class="details-panel hidden">
        <div class="panel-header">
            <button class="close-btn" onclick="closeDetailsPanel()">✕</button>
            <h3>Person Details</h3>
        </div>
        <div class="panel-content">
            <div class="person-card">
                <div class="avatar" id="detail-avatar">NJ</div>
                <div class="person-info">
                    <h2 id="detail-name">Select a person</h2>
                    <p id="detail-meta" class="meta">Age • Gender • District</p>
                </div>
                <span class="status-badge" id="detail-status">Status</span>
            </div>

            <div class="quick-stats">
                <div class="stat-box"><div class="stat-icon">📅</div><div class="stat-info"><div class="stat-label">Reported</div><div class="stat-value" id="detail-reported">-</div></div></div>
                <div class="stat-box"><div class="stat-icon">⏱️</div><div class="stat-info"><div class="stat-label">Duration</div><div class="stat-value" id="detail-duration">-</div></div></div>
                <div class="stat-box"><div class="stat-icon">📝</div><div class="stat-info"><div class="stat-label">Updates</div><div class="stat-value" id="detail-updates">0</div></div></div>
            </div>

            <div class="info-section">
                <h4>🎯 Rescue Progress</h4>
                <div class="progress-tracker">
                    <div class="progress-step" data-status="needs_aid"><div class="step-circle">1</div><div class="step-label">Needs Aid</div></div>
                    <div class="progress-line"></div>
                    <div class="progress-step" data-status="team_sent"><div class="step-circle">2</div><div class="step-label">Team Sent</div></div>
                    <div class="progress-line"></div>
                    <div class="progress-step" data-status="arrived"><div class="step-circle">3</div><div class="step-label">Arrived</div></div>
                    <div class="progress-line"></div>
                    <div class="progress-step" data-status="rescued"><div class="step-circle">4</div><div class="step-label">Rescued</div></div>
                </div>
            </div>

            <div class="info-section">
                <h4>📍 Location Details</h4>
                <div class="detail-grid">
                    <div class="detail-item"><span class="detail-label">Location:</span><span class="detail-value" id="detail-location">-</span></div>
                    <div class="detail-item"><span class="detail-label">District:</span><span class="detail-value" id="detail-district">-</span></div>
                    <div class="detail-item"><span class="detail-label">Coordinates:</span><span class="detail-value coords" id="detail-coords">-</span></div>
                </div>
            </div>

            <div class="info-section">
                <h4>🚨 Disaster Information</h4>
                <div class="detail-grid">
                    <div class="detail-item"><span class="detail-label">Type:</span><span class="detail-value" id="detail-disaster">-</span></div>
                    <div class="detail-item"><span class="detail-label">Injury Status:</span><span class="detail-value" id="detail-injury">-</span></div>
                    <div class="detail-item"><span class="detail-label">Severity:</span><span class="detail-value" id="detail-severity">-</span></div>
                </div>
            </div>

            <div class="info-section">
                <h4>👨‍👩‍👧‍👦 Family &amp; Contact</h4>
                <div class="detail-grid">
                    <div class="detail-item"><span class="detail-label">Family Members:</span><span class="detail-value" id="detail-family">-</span></div>
                    <div class="detail-item"><span class="detail-label">Contact:</span><span class="detail-value" id="detail-contact">-</span></div>
                    <div class="detail-item"><span class="detail-label">Age:</span><span class="detail-value" id="detail-age">-</span></div>
                    <div class="detail-item"><span class="detail-label">Gender:</span><span class="detail-value" id="detail-gender">-</span></div>
                </div>
            </div>

            <div class="info-section">
                <h4>🎁 Aid &amp; Supplies</h4>
                <div class="supply-grid">
                    <div class="supply-item"><div class="supply-icon">🍲</div><div class="supply-name">Food</div><div class="supply-status pending">Pending</div></div>
                    <div class="supply-item"><div class="supply-icon">🏥</div><div class="supply-name">Medical</div><div class="supply-status pending">Pending</div></div>
                    <div class="supply-item"><div class="supply-icon">🏠</div><div class="supply-name">Shelter</div><div class="supply-status pending">Pending</div></div>
                </div>
            </div>

            <div class="info-section">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
                    <h4 style="margin-bottom:0">📋 Latest Update</h4>
                    <button class="btn-expand" onclick="openActivityModal()"><span>⤢ View Timeline</span></button>
                </div>
                <div id="detail-activity" class="last-update-card"></div>
            </div>

            <div class="info-section">
                <h4>➕ Add New Update</h4>
                <form id="update-form" method="POST" action="add_log.php">
                    <input type="hidden" id="person-id-input" name="person_id" value="">
                    <select id="log-type" name="log_type" class="form-input" required>
                        <option value="">Select update type...</option>
                        <option value="incident_reported">🚨 Incident Reported</option>
                        <option value="alert">⚠️ Alert / Warning</option>
                        <option value="team_dispatched">🚁 Team Dispatched</option>
                        <option value="team_arrived">📍 Team Arrived</option>
                        <option value="medical_aid">🏥 Medical Aid Provided</option>
                        <option value="food_supply">🍲 Food Supply Delivered</option>
                        <option value="shelter">🏠 Shelter Arranged</option>
                        <option value="status_update">📋 Status Update</option>
                    </select>
                    <textarea id="log-message" name="message" class="form-input" placeholder="Enter update details..." rows="4" required></textarea>
                    <input type="text" name="created_by" class="form-input" placeholder="Your name (optional)" value="Operator">
                    <button type="submit" class="btn-submit"><span>📤 Add Update</span></button>
                </form>
            </div>
        </div>
    </div>

    <!-- Activity Modal -->
    <div id="activity-modal" class="activity-modal hidden">
        <div class="modal-overlay" onclick="closeActivityModal()"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h3>📋 Complete Activity Timeline</h3>
                <button class="close-btn" onclick="closeActivityModal()">✕</button>
            </div>
            <div class="modal-body">
                <div class="person-info-bar">
                    <div class="person-avatar-small" id="modal-avatar">NJ</div>
                    <div>
                        <div class="person-name-small" id="modal-name">Person Name</div>
                        <div class="person-meta-small" id="modal-meta">District • Status</div>
                    </div>
                </div>
                <div id="modal-activity-timeline" class="activity-timeline-full"></div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Pass PHP data to JavaScript
        var peopleData = <?php echo '['; 
        $first = true;
        foreach ($people as $p) {
            if (!$first) echo ',';
            echo '{';
            echo '"id":' . $p['id'] . ',';
            echo '"full_name":"' . addslashes($p['full_name']) . '",';
            echo '"age":' . $p['age'] . ',';
            echo '"gender":"' . $p['gender'] . '",';
            echo '"location_name":"' . addslashes($p['location_name']) . '",';
            echo '"district":"' . addslashes($p['district']) . '",';
            echo '"latitude":' . $p['latitude'] . ',';
            echo '"longitude":' . $p['longitude'] . ',';
            echo '"disaster_type":"' . addslashes($p['disaster_type']) . '",';
            echo '"status":"' . $p['status'] . '",';
            echo '"created_at":"' . $p['created_at'] . '",';
            echo '"injury_status":"' . addslashes(isset($p['injury_status']) ? $p['injury_status'] : 'Not specified') . '",';
            echo '"family_count":' . (isset($p['family_count']) ? (int) $p['family_count'] : 0) . ',';
            echo '"contact":"' . addslashes(isset($p['contact']) ? $p['contact'] : 'Not available') . '"';
            echo '}';
            $first = false;
        }
        echo ']'; ?>;
    </script>
</body>
</html>
