<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>DRCS | Affected People Dashboard</title>
    <!-- Fonts & Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/disaster-Response-System/public/assets/css/theme.css">
    <link rel="stylesheet" href="/disaster-Response-System/public/assets/css/navbar.css">
    <link rel="stylesheet" href="/disaster-Response-System/public/assets/css/ticker.css">
    <link rel="stylesheet" href="/disaster-Response-System/app/views/AffectedPeople/assets/css/affected-people.css">
</head>

<body>

    <!-- ========== NAVBAR ========== -->
    <?php include __DIR__ . '/../home/_navbar.php'; ?>

    <!-- ========== TICKER ========== -->
    <?php include __DIR__ . '/../home/_ticker.php'; ?>

    <!-- MAIN DASHBOARD CONTENT -->
    <div class="dashboard">
        <!-- Personal Data Card -->
        <div class="personal-data-card">
            <div class="personal-data-header">
                <div class="personal-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="personal-info-main">
                    <h2><?= htmlspecialchars(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? 'N/A')) ?></h2>
                    <span class="personal-role-badge">AFFECTED PERSON</span>
                </div>
            </div>
            <div class="personal-data-grid">
                <div class="personal-data-item">
                    <div class="personal-data-label">
                        <i class="fas fa-id-badge"></i> NIC Number
                    </div>
                    <div class="personal-data-value"><?= htmlspecialchars($profile['nic'] ?? 'N/A') ?></div>
                </div>
                <div class="personal-data-item">
                    <div class="personal-data-label">
                        <i class="fas fa-phone-alt"></i> Contact Number
                    </div>
                    <div class="personal-data-value"><?= htmlspecialchars($profile['contact_no'] ?? 'N/A') ?></div>
                </div>
                <div class="personal-data-item">
                    <div class="personal-data-label">
                        <i class="fas fa-birthday-cake"></i> Age
                    </div>
                    <div class="personal-data-value"><?= htmlspecialchars($profile['age'] ?? 'N/A') ?> years</div>
                </div>
                <div class="personal-data-item">
                    <div class="personal-data-label">
                        <i class="fas fa-venus-mars"></i> Gender
                    </div>
                    <div class="personal-data-value"><?= htmlspecialchars($profile['gender'] ?? 'N/A') ?></div>
                </div>
                <div class="personal-data-item">
                    <div class="personal-data-label">
                        <i class="fas fa-users"></i> Family Members
                    </div>
                    <div class="personal-data-value"><?= htmlspecialchars($profile['no_of_family_members'] ?? '0') ?> Members</div>
                </div>
                <div class="personal-data-item">
                    <div class="personal-data-label">
                        <i class="fas fa-map-marked-alt"></i> District
                    </div>
                    <div class="personal-data-value"><?= htmlspecialchars($profile['district'] ?? 'N/A') ?></div>
                </div>
            </div>
            <div class="personal-address-full">
                <div class="personal-data-label">
                    <i class="fas fa-home"></i> Full Address
                </div>
                <div class="personal-data-value">
                    <?= htmlspecialchars(($profile['home_no'] ?? '') . ' ' . ($profile['street'] ?? '') . ', ' . ($profile['city'] ?? '') . ', ' . ($profile['district'] ?? '')) ?>
                </div>
            </div>
        </div>

        <!-- Simple stats -->
        <div class="stats-row">
            <div class="stat-simple">
                <div class="stat-number"><?= $totalRequests ?></div>
                <div class="stat-label">TOTAL REQUESTS</div>
            </div>
            <div class="stat-simple">
                <div class="stat-number"><?= $pendingRequests ?></div>
                <div class="stat-label">PENDING REQUESTS</div>
            </div>
            <div class="stat-simple">
                <div class="stat-number"><?= $completedRequests ?></div>
                <div class="stat-label">COMPLETED REQUESTS</div>
            </div>
            <div class="stat-simple">
                <div class="stat-number"><?= $totalResources ?></div>
                <div class="stat-label">ASSIGNED RESOURCES</div>
            </div>
        </div>

        <!-- Three column layout: My Requests | Assigned Resources | Activity Logs -->
        <div class="content-grid">
            <!-- LEFT: My Requests -->
            <div class="panel">
                <div class="panel-header">
                    <h3><i class="fas fa-file-alt" style="color: var(--red);"></i> My Requests</h3>
                    <p style="font-size:0.7rem; color:var(--muted);">All your submitted requests</p>
                </div>
                <div class="panel-body">
                    <?php if (empty($myRequests)): ?>
                        <div class="empty-msg">No requests submitted yet.</div>
                    <?php else: ?>
                        <?php foreach ($myRequests as $req): ?>
                            <div class="item">
                                <div class="item-title">
                                    <?= htmlspecialchars($req['req_name']) ?>
                                    <span class="status-badge <?= strtolower($req['status']) ?>">
                                        <?= htmlspecialchars($req['status']) ?>
                                    </span>
                                    <?php if ($req['priority_level']): ?>
                                        <span class="priority-badge <?= strtolower($req['priority_level']) ?>">
                                            <?= strtoupper($req['priority_level']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="item-desc"><?= htmlspecialchars($req['description']) ?></div>
                                <div class="item-meta">
                                    <span><i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($req['req_type']) ?></span>
                                    <span><i class="fas fa-box"></i> <?= htmlspecialchars($req['resource_type']) ?> (<?= $req['resource_count'] ?>)</span>
                                    <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($req['location']) ?></span>
                                    <span><i class="far fa-clock"></i> <?= htmlspecialchars($req['created_at']) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- MIDDLE: Assigned Resources -->
            <div class="panel">
                <div class="panel-header">
                    <h3><i class="fas fa-boxes" style="color: var(--green);"></i> Assigned Resources</h3>
                    <p style="font-size:0.7rem; color:var(--muted);">Resources allocated to you</p>
                </div>
                <div class="panel-body">
                    <?php if (empty($assignedResources)): ?>
                        <div class="empty-msg">No resources assigned yet.</div>
                    <?php else: ?>
                        <?php foreach ($assignedResources as $res): ?>
                            <div class="item">
                                <div class="item-title">
                                    <?= htmlspecialchars($res['resource_name'] ?? 'Resource') ?>
                                    <span class="status-badge <?= strtolower($res['status']) ?>">
                                        <?= htmlspecialchars($res['status']) ?>
                                    </span>
                                </div>
                                <div class="item-desc">
                                    <?= htmlspecialchars($res['resource_desc'] ?? $res['assignment_desc'] ?? 'No description') ?>
                                </div>
                                <div class="item-meta">
                                    <span><i class="fas fa-box"></i> <?= htmlspecialchars($res['resource_type']) ?> (<?= $res['resource_count'] ?>)</span>
                                    <span><i class="fas fa-user"></i> <?= htmlspecialchars($res['volunteer_name'] ?? 'N/A') ?></span>
                                    <?php if ($res['volunteer_contact']): ?>
                                        <span><i class="fas fa-phone"></i> <?= htmlspecialchars($res['volunteer_contact']) ?></span>
                                    <?php endif; ?>
                                    <span><i class="far fa-clock"></i> <?= htmlspecialchars($res['assigned_date']) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- RIGHT: Activity Logs -->
            <div class="panel">
                <div class="panel-header">
                    <h3><i class="fas fa-history" style="color: var(--blue);"></i> Activity Logs</h3>
                    <p style="font-size:0.7rem; color:var(--muted);">Recent updates about you</p>
                </div>
                <div class="panel-body">
                    <?php if (empty($activityLogs)): ?>
                        <div class="empty-msg">No activity logs yet.</div>
                    <?php else: ?>
                        <?php foreach ($activityLogs as $log): ?>
                            <div class="log-item">
                                <div class="log-type"><?= htmlspecialchars(str_replace('_', ' ', $log['log_type'])) ?></div>
                                <div class="log-message"><?= htmlspecialchars($log['message']) ?></div>
                                <div class="log-footer">
                                    <span><i class="fas fa-user-shield"></i> <?= htmlspecialchars($log['created_by']) ?></span>
                                    <span><i class="far fa-clock"></i> <?= htmlspecialchars($log['created_at']) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <footer>
            <strong>DRCS</strong> • Real‑time coordination platform • Affected People Portal • Sri Lanka
        </footer>
    </div>

    <!-- PROFILE MODAL POPUP -->
    <div id="profileModal" class="profile-modal-backdrop" onclick="handleProfileBackdropClick(event)">
        <div class="profile-modal-card">
            <div class="profile-modal-header">
                <h3><i class="fas fa-id-card"></i> My Profile</h3>
                <button class="profile-modal-close" onclick="closeProfileModal()">&times;</button>
            </div>
            <div class="profile-modal-body">
                <div class="profile-avatar-sec">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4><?= htmlspecialchars(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? '')) ?></h4>
                    <span class="profile-badge">AFFECTED PERSON</span>
                </div>
                <div class="profile-grid">
                    <div class="profile-item">
                        <span class="profile-label"><i class="fas fa-id-badge"></i> NIC</span>
                        <span class="profile-val"><?= htmlspecialchars($profile['nic'] ?? 'N/A') ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label"><i class="fas fa-phone-alt"></i> Contact No</span>
                        <span class="profile-val"><?= htmlspecialchars($profile['contact_no'] ?? 'N/A') ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label"><i class="fas fa-birthday-cake"></i> Age</span>
                        <span class="profile-val"><?= htmlspecialchars($profile['age'] ?? 'N/A') ?> years</span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label"><i class="fas fa-venus-mars"></i> Gender</span>
                        <span class="profile-val"><?= htmlspecialchars($profile['gender'] ?? 'N/A') ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label"><i class="fas fa-users"></i> Family Members</span>
                        <span class="profile-val"><?= htmlspecialchars($profile['no_of_family_members'] ?? '0') ?> Members</span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label"><i class="fas fa-map-marked-alt"></i> District / City</span>
                        <span class="profile-val"><?= htmlspecialchars(($profile['district'] ?? '') . ', ' . ($profile['city'] ?? '')) ?></span>
                    </div>
                </div>
                <div class="profile-address-full">
                    <span class="profile-label"><i class="fas fa-home"></i> Address</span>
                    <span class="profile-val"><?= htmlspecialchars(($profile['home_no'] ?? '') . ' ' . ($profile['street'] ?? '') . ', ' . ($profile['city'] ?? '')) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom JavaScript -->
    <script src="/disaster-Response-System/app/views/AffectedPeople/assets/js/affected-people.js"></script>
</body>
</html>
