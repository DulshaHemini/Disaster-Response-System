<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>DRCS | Relief Team Dashboard</title>
    <!-- Fonts & Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ========= DRCS THEME VARIABLES ========= */
        :root {
            --white: #ffffff;
            --off: #f8f5f2;
            --surface: #f2ede8;
            --red: #c8102e;
            --red-dk: #9b0b21;
            --red-lt: #fbeaec;
            --red-m: #f5c0c7;
            --amber: #d97706;
            --green: #15803d;
            --blue: #1d4ed8;
            --text: #1a1a1a;
            --muted: #6b6b6b;
            --border: #e2ddd8;
            --font-hd: 'Playfair Display', serif;
            --font-bd: 'Outfit', sans-serif;
            --font-mn: 'JetBrains Mono', monospace;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--off);
            color: var(--text);
            font-family: var(--font-bd);
            overflow-x: hidden;
        }

        /* ── NAVBAR (exactly as provided, without language switcher) ── */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2.5rem;
            height: 64px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            text-decoration: none;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--red);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon svg {
            width: 20px;
            height: 20px;
            fill: #fff;
        }

        .brand-text {
            font-family: var(--font-hd);
            font-size: 1.25rem;
            color: var(--text);
            letter-spacing: .02em;
        }

        .brand-text em {
            color: var(--red);
            font-style: normal;
        }

        .nav-center {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: 1.4rem;
            font-family: var(--font-hd);
            font-weight: 600;
            color: var(--text);
            letter-spacing: .02em;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .btn-fill {
            background: var(--text);
            color: #fff;
            border: none;
            padding: .42rem 1.1rem;
            border-radius: 7px;
            font-family: var(--font-bd);
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity .2s;
        }

        .btn-fill:hover {
            opacity: .85;
        }

        /* Logout button special (appears when logged in as relief team) */
        .btn-logout {
            background: transparent;
            color: var(--red);
            border: 1.5px solid var(--red);
            padding: .4rem 1rem;
            border-radius: 7px;
            font-family: var(--font-bd);
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-logout:hover {
            background: var(--red);
            color: #fff;
        }

        /* Profile button */
        .btn-profile {
            background: var(--surface);
            color: var(--text);
            border: 1.5px solid var(--border);
            padding: .4rem 1rem;
            border-radius: 7px;
            font-family: var(--font-bd);
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-profile:hover {
            background: var(--text);
            color: #fff;
            border-color: var(--text);
        }

        /* Profile Modal CSS */
        .profile-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.25s ease-out;
        }

        .profile-modal-backdrop.open {
            display: flex;
        }

        .profile-modal-card {
            background: var(--white);
            border-radius: 24px;
            width: 90%;
            max-width: 480px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            border: 1.5px solid var(--border);
            overflow: hidden;
            transform: translateY(20px);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .profile-modal-header {
            padding: 1.2rem 1.8rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--off);
        }

        .profile-modal-header h3 {
            font-family: var(--font-hd);
            font-size: 1.25rem;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-modal-close {
            background: transparent;
            border: none;
            font-size: 1.7rem;
            cursor: pointer;
            color: var(--muted);
            line-height: 1;
            padding: 0;
            transition: color 0.2s;
        }

        .profile-modal-close:hover {
            color: var(--red);
        }

        .profile-modal-body {
            padding: 2rem 1.8rem;
        }

        .profile-avatar-sec {
            text-align: center;
            margin-bottom: 1.8rem;
        }

        .profile-avatar {
            width: 72px;
            height: 72px;
            background: var(--red-lt);
            color: var(--red);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            margin-bottom: 0.8rem;
            box-shadow: 0 4px 10px rgba(200, 16, 46, 0.1);
        }

        .profile-avatar-sec h4 {
            font-family: var(--font-hd);
            font-size: 1.4rem;
            color: var(--text);
            margin-bottom: 0.3rem;
        }

        .profile-badge {
            font-size: 0.72rem;
            font-family: var(--font-mn);
            background: var(--red-lt);
            color: var(--red);
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.2rem;
            margin-bottom: 1.2rem;
        }

        .profile-item {
            background: var(--off);
            border: 1px solid var(--border);
            padding: 0.8rem 1rem;
            border-radius: 12px;
        }

        .profile-label {
            display: block;
            font-size: 0.7rem;
            color: var(--muted);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .profile-label i {
            margin-right: 4px;
        }

        .profile-val {
            font-size: 0.88rem;
            color: var(--text);
            font-weight: 500;
        }

        .profile-address-full {
            background: var(--off);
            border: 1px solid var(--border);
            padding: 0.8rem 1rem;
            border-radius: 12px;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* ========= TICKER / ALERT BAR ========= */
        .ticker-wrap {
            background: var(--red);
            overflow: hidden;
            white-space: nowrap;
            padding: .4rem 0;
            margin-top: 64px;
        }

        .ticker {
            display: inline-block;
            animation: ticker-scroll 32s linear infinite;
            font-family: var(--font-mn);
            font-size: .9rem;
            color: #fff;
            letter-spacing: .03em;
        }

        @keyframes ticker-scroll {
            from {
                transform: translateX(100vw);
            }

            to {
                transform: translateX(-100%);
            }
        }

        /* ========= MAIN DASHBOARD ========= */
        .dashboard {
            max-width: 1300px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        /* Stats Row - simple & clean */
        .stats-row {
            display: flex;
            gap: 1.2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .stat-simple {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 1rem 1.8rem;
            flex: 1;
            min-width: 140px;
            text-align: center;
            transition: all 0.2s;
        }

        .stat-simple:hover {
            border-color: var(--red-m);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .stat-number {
            font-family: var(--font-hd);
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--red);
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--muted);
            font-family: var(--font-mn);
            letter-spacing: 0.03em;
        }

        /* Two column task layout */
        .tasks-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.8rem;
            margin-top: 1rem;
        }

        @media (max-width: 780px) {
            .tasks-grid {
                grid-template-columns: 1fr;
            }

            .stats-row {
                flex-direction: column;
            }

            nav {
                padding: 0 1rem;
            }
        }

        /* Task panels */
        .task-panel {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 24px;
            overflow: hidden;
            transition: box-shadow 0.2s;
        }

        .task-panel:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        .panel-header {
            background: var(--off);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .panel-header h3 {
            font-family: var(--font-hd);
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text);
        }

        .task-list {
            max-height: 460px;
            overflow-y: auto;
        }

        .task-list::-webkit-scrollbar {
            width: 4px;
        }

        .task-list::-webkit-scrollbar-track {
            background: var(--surface);
        }

        .task-list::-webkit-scrollbar-thumb {
            background: var(--red-m);
            border-radius: 4px;
        }

        .task-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--surface);
            transition: background 0.15s;
        }

        .task-item:hover {
            background: var(--off);
        }

        .task-info {
            flex: 1;
        }

        .task-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text);
        }

        .task-meta {
            font-size: 0.7rem;
            color: var(--muted);
            margin-top: 4px;
            display: flex;
            gap: 12px;
            font-family: var(--font-mn);
        }

        .task-desc {
            font-size: 0.72rem;
            color: #6b6b6b;
            margin-top: 5px;
            line-height: 1.4;
        }

        .status-badge {
            font-size: 0.6rem;
            background: var(--surface);
            padding: 2px 10px;
            border-radius: 30px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .status-badge.doing {
            background: #ffedd5;
            color: var(--amber);
        }

        .status-badge.done {
            background: #dcfce7;
            color: var(--green);
        }

        /* Buttons */
        .task-actions {
            display: flex;
            gap: 8px;
        }

        button {
            border: none;
            background: none;
            cursor: pointer;
            font-family: var(--font-bd);
            font-weight: 500;
            border-radius: 40px;
            padding: 6px 14px;
            font-size: 0.7rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-accept {
            background: var(--green);
            color: white;
        }

        .btn-accept:hover {
            background: #0f6a34;
            transform: scale(0.97);
        }

        .btn-reject {
            background: var(--surface);
            color: var(--red);
            border: 1px solid var(--red-m);
        }

        .btn-reject:hover {
            background: var(--red-lt);
        }

        .btn-doing {
            background: var(--amber);
            color: white;
        }

        .btn-doing:hover {
            background: #b45f06;
        }

        .btn-done {
            background: var(--blue);
            color: white;
        }

        .btn-done:hover {
            background: #1e3faa;
        }

        .empty-msg {
            text-align: center;
            padding: 2rem;
            color: var(--muted);
            font-size: 0.8rem;
        }

        footer {
            text-align: center;
            margin-top: 2.5rem;
            padding: 1.5rem 0;
            font-size: 0.7rem;
            color: var(--muted);
            border-top: 1px solid var(--border);
            font-family: var(--font-mn);
        }

        footer strong {
            color: var(--red);
        }
    </style>
</head>

<body>

    <!-- ========== EXACT NAVBAR (NO LANGUAGE BUTTONS) ========== -->
    <nav>
        <a class="nav-brand" href="#">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 15h-2v-2h2zm0-4h-2V7h2z" />
                </svg>
            </div>
            <span class="brand-text">DR<em>CS</em></span>
        </a>

        <div class="nav-center">
            Relief Team Task Handling
        </div>

        <div class="nav-right">
            <button class="btn-profile" id="profileBtn" onclick="openProfileModal()"><i class="fas fa-user-circle"></i> Profile</button>
            <a href="logout.php" class="btn-logout" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <!-- Alert ticker -->
    <div class="ticker-wrap">
        <div class="ticker">
            ⚠️ WARNING – Landslide Risk: Ratnapura District &nbsp;&nbsp;|&nbsp;&nbsp; ✅ RESOLVED – Cyclone Watch lifted:
            Eastern Coast &nbsp;&nbsp;|&nbsp;&nbsp; 🚨 ACTIVE – Search & Rescue teams deployed: Galle
        </div>
    </div>

    <!-- MAIN DASHBOARD CONTENT (simple & needful) -->
    <div class="dashboard">
        <!-- Simple stats -->
        <div class="stats-row">
            <div class="stat-simple">
                <div class="stat-number" id="affectedCount"><?= $affectedCount ?></div>
                <div class="stat-label">AFFECTED PEOPLE</div>
            </div>
            <div class="stat-simple">
                <div class="stat-number" id="activeTaskCount"><?= $activeTaskCount ?></div>
                <div class="stat-label">IN-PROGRESS TASKS</div>
            </div>
            <div class="stat-simple">
                <div class="stat-number" id="completedCount"><?= $completedCount ?></div>
                <div class="stat-label">COMPLETED TASKS</div>
            </div>
            <div class="stat-simple">
                <div class="stat-number" id="pendingAssignCount"><?= $pendingAssignCount ?></div>
                <div class="stat-label">PENDING ASSIGNMENTS</div>
            </div>
        </div>

        <!-- Task panels: accept/reject + active tasks -->
        <div class="tasks-grid">
            <!-- LEFT: New Assignments (accept / reject) -->
            <div class="task-panel">
                <div class="panel-header">
                    <h3><i class="fas fa-inbox" style="color: var(--red);"></i> Assigned Tasks</h3>
                    <p style="font-size:0.7rem; color:var(--muted);">Accept or reject tasks from command center</p>
                </div>
                <div class="task-list" id="pendingTasksList">
                    <?php if (empty($pendingTasks)): ?>
                        <div class="empty-msg">No pending tasks at the moment.</div>
                    <?php else: ?>
                        <?php foreach ($pendingTasks as $task): ?>
                            <div class="task-item">
                                <div class="task-info">
                                    <div class="task-title"><?= htmlspecialchars($task['title']) ?></div>
                                    <div class="task-desc"><?= htmlspecialchars($task['description']) ?></div>
                                    <div class="task-meta">
                                        <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($task['location']) ?></span>
                                        <span><i class="far fa-clock"></i> <?= htmlspecialchars($task['createdAt']) ?></span>
                                    </div>
                                </div>
                                <div class="task-actions">
                                    <form method="POST" action="ReliefTeam.php" style="display:inline;">
                                        <input type="hidden" name="action" value="accept">
                                        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                        <button type="submit" class="btn-accept"><i class="fas fa-check"></i> Accept</button>
                                    </form>
                                    <form method="POST" action="ReliefTeam.php" style="display:inline;">
                                        <input type="hidden" name="action" value="reject">
                                        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                        <button type="submit" class="btn-reject"><i class="fas fa-times"></i> Reject</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- RIGHT: My Active Tasks (doing / done) -->
            <div class="task-panel">
                <div class="panel-header">
                    <h3><i class="fas fa-clipboard-list" style="color: var(--green);"></i> My Active Tasks</h3>
                    <p style="font-size:0.7rem; color:var(--muted);">Update status: Doing → Done</p>
                </div>
                <div class="task-list" id="activeTasksList">
                    <?php if (empty($activeTasks)): ?>
                        <div class="empty-msg">No active tasks.</div>
                    <?php else: ?>
                        <?php foreach ($activeTasks as $task): ?>
                            <div class="task-item">
                                <div class="task-info">
                                    <div class="task-title">
                                        <?= htmlspecialchars($task['title']) ?>
                                        <span class="status-badge <?= $task['status'] ?>">
                                            <i class="fas <?= $task['status'] == 'doing' ? 'fa-spinner fa-spin' : 'fa-check-double' ?>"></i>
                                            <?= strtoupper($task['status']) ?>
                                        </span>
                                    </div>
                                    <div class="task-desc"><?= htmlspecialchars($task['description']) ?></div>
                                    <div class="task-meta">
                                        <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($task['location']) ?></span>
                                        <span><i class="far fa-clock"></i> Accepted: <?= htmlspecialchars($task['acceptedAt']) ?></span>
                                        <?php if ($task['status'] == 'done' && isset($task['completedAt'])): ?>
                                            <span><i class="fas fa-flag-checkered"></i> Done: <?= htmlspecialchars($task['completedAt']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="task-actions">
                                    <?php if ($task['status'] !== 'done'): ?>
                                        <form method="POST" action="ReliefTeam.php" style="display:inline;">
                                            <input type="hidden" name="action" value="mark_done">
                                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                            <button type="submit" class="btn-done"><i class="fas fa-check-double"></i> Done</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <footer>
            <strong>DRCS</strong> • Real‑time coordination platform • Relief Team Portal • Sri Lanka
        </footer>
    </div>

    <!-- PROFILE MODAL POPUP -->
    <div id="profileModal" class="profile-modal-backdrop" onclick="handleProfileBackdropClick(event)">
        <div class="profile-modal-card">
            <div class="profile-modal-header">
                <h3><i class="fas fa-id-card"></i> Relief Team Profile</h3>
                <button class="profile-modal-close" onclick="closeProfileModal()">&times;</button>
            </div>
            <div class="profile-modal-body">
                <div class="profile-avatar-sec">
                    <div class="profile-avatar">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h4><?= htmlspecialchars($profile['team_name'] ?? 'N/A') ?></h4>
                    <span class="profile-badge"><?= htmlspecialchars($profile['specialization'] ?? 'N/A') ?> Specialist</span>
                </div>
                <div class="profile-grid">
                    <div class="profile-item">
                        <span class="profile-label"><i class="fas fa-envelope"></i> Email</span>
                        <span class="profile-val"><?= htmlspecialchars($profile['email'] ?? 'N/A') ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label"><i class="fas fa-phone-alt"></i> Contact No</span>
                        <span class="profile-val"><?= htmlspecialchars($profile['contact_no'] ?? 'N/A') ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label"><i class="fas fa-users"></i> Team Members</span>
                        <span class="profile-val"><?= htmlspecialchars($profile['no_of_members'] ?? '1') ?> Members</span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label"><i class="fas fa-truck"></i> Vehicle Type</span>
                        <span class="profile-val"><?= htmlspecialchars($profile['vehicle_type'] ?? 'N/A') ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label"><i class="fas fa-hashtag"></i> Vehicle No</span>
                        <span class="profile-val"><?= htmlspecialchars($profile['vehicle_number'] ?? 'N/A') ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label"><i class="fas fa-map-marked-alt"></i> District / City</span>
                        <span class="profile-val"><?= htmlspecialchars(($profile['district'] ?? '') . ', ' . ($profile['city'] ?? '')) ?></span>
                    </div>
                </div>
                <div class="profile-address-full">
                    <span class="profile-label"><i class="fas fa-home"></i> Base Address</span>
                    <span class="profile-val"><?= htmlspecialchars(($profile['home_no'] ?? '') . ' ' . ($profile['street'] ?? '') . ', ' . ($profile['city'] ?? '')) ?></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openProfileModal() {
            document.getElementById('profileModal').classList.add('open');
        }

        function closeProfileModal() {
            document.getElementById('profileModal').classList.remove('open');
        }

        function handleProfileBackdropClick(e) {
            if (e.target === document.getElementById('profileModal')) {
                closeProfileModal();
            }
        }
    </script>
</body>
</html>
