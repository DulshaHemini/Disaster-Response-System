<?php
require_once '../../config/config.php';

// ── AJAX: delete user ──────────────────────────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'delete_user') {
    $id = intval($_POST['user_id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    echo json_encode(['ok' => $stmt->execute()]);
    $stmt->close();
    exit;
}

// ── AJAX: update request status ───────────────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'update_request_status') {
    $id     = intval($_POST['req_id']);
    $status = $_POST['status'];
    $allowed = ['pending', 'in-progress', 'resolved'];
    if (!in_array($status, $allowed)) { echo json_encode(['ok' => false]); exit; }
    $stmt = $conn->prepare("UPDATE Request SET status = ? WHERE req_id = ?");
    $stmt->bind_param("si", $status, $id);
    echo json_encode(['ok' => $stmt->execute()]);
    $stmt->close();
    exit;
}

// ── AJAX: assign volunteer ────────────────────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'assign_volunteer') {
    $req_id       = intval($_POST['req_id']);
    $volunteer_id = intval($_POST['volunteer_id']);
    // Update request status to in-progress
    $stmt = $conn->prepare("UPDATE Request SET status = 'in-progress' WHERE req_id = ? AND status = 'pending'");
    $stmt->bind_param("i", $req_id);
    $stmt->execute();
    $stmt->close();
    // Insert or update assignment
    $stmt = $conn->prepare(
        "INSERT INTO assignment (req_id, volunteer_id, assigned_date, status)
         VALUES (?, ?, CURDATE(), 'Assigned')
         ON DUPLICATE KEY UPDATE volunteer_id = VALUES(volunteer_id), status = 'Assigned'"
    );
    $stmt->bind_param("ii", $req_id, $volunteer_id);
    echo json_encode(['ok' => $stmt->execute()]);
    $stmt->close();
    exit;
}

// ── Fetch volunteers (for assign dropdown) ────────────────────────────────
$volResult = $conn->query(
    "SELECT user_id, username FROM users WHERE user_role = 'volunteer' ORDER BY username"
);
$volunteers = [];
while ($row = $volResult->fetch_assoc()) $volunteers[] = $row;

// ── Fetch current assignments (req_id → volunteer_id map) ─────────────────
$assignResult = $conn->query("SELECT req_id, volunteer_id FROM assignment");
$assignments  = [];
while ($row = $assignResult->fetch_assoc()) {
    $assignments[$row['req_id']] = $row['volunteer_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DRCS Admin · Command Center | Sri Lanka</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Outfit:wght@300;400;500;600&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

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
      --slate: #475569;
      --text: #1a1a1a;
      --muted: #6b6b6b;
      --border: #e2ddd8;
      --font-hd: 'Playfair Display', serif;
      --font-bd: 'Outfit', sans-serif;
      --font-mn: 'JetBrains Mono', monospace;
      --shadow: 0 4px 12px rgba(0,0,0,0.05);
      --radius-lg: 20px;
      --radius-md: 14px;
    }

    body { background: var(--off); font-family: var(--font-bd); color: var(--text); overflow-x: hidden; }

    .admin-nav {
      background: rgba(255,255,255,0.96);
      border-bottom: 1px solid var(--border);
      padding: 0 2rem;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
      backdrop-filter: blur(12px);
    }
    .nav-brand { display: flex; align-items: center; gap: 0.75rem; }
    .logo-icon { width: 38px; height: 38px; background: var(--red); border-radius: 10px; display: flex; align-items: center; justify-content: center; }
    .logo-icon svg { width: 22px; fill: #fff; }
    .brand-text { font-family: var(--font-hd); font-size: 1.3rem; }
    .brand-text em { color: var(--red); font-style: normal; }
    .admin-badge { background: var(--red-lt); padding: 0.3rem 1rem; border-radius: 40px; font-size: 0.75rem; font-weight: 600; color: var(--red); font-family: var(--font-mn); }
    .nav-tabs { display: flex; gap: 0.25rem; background: var(--surface); padding: 0.25rem; border-radius: 48px; }
    .tab-btn { padding: 0.5rem 1.2rem; border-radius: 40px; border: none; background: transparent; font-family: var(--font-bd); font-weight: 500; font-size: 0.8rem; cursor: pointer; transition: 0.2s; color: var(--muted); }
    .tab-btn.active { background: var(--white); color: var(--red); box-shadow: var(--shadow); }
    .logout-btn { background: transparent; border: 1.5px solid var(--border); padding: 0.4rem 1rem; border-radius: 40px; cursor: pointer; font-size: 0.75rem; }

    .admin-container { max-width: 1400px; margin: 0 auto; padding: 2rem; }

    .tab-content { display: none; animation: fadeIn 0.25s ease; }
    .tab-content.active-tab { display: block; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

    .section-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 1.5rem; }
    .section-header h2 { font-family: var(--font-hd); font-size: 1.6rem; }

    .btn-primary { background: var(--red); border: none; padding: 0.6rem 1.3rem; border-radius: 40px; color: white; font-weight: 600; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; }
    .btn-outline { background: transparent; border: 1.5px solid var(--border); padding: 0.5rem 1rem; border-radius: 40px; cursor: pointer; }

    .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 2rem; }
    .stat-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 1.2rem; }
    .stat-card .label { font-size: 0.7rem; text-transform: uppercase; color: var(--muted); }
    .stat-card .value { font-family: var(--font-hd); font-size: 2rem; }

    .table-wrapper { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
    th { text-align: left; padding: 1rem 1.2rem; background: var(--off); font-family: var(--font-mn); font-size: 0.7rem; color: var(--muted); border-bottom: 1px solid var(--border); }
    td { padding: 0.9rem 1.2rem; border-bottom: 1px solid var(--border); vertical-align: middle; }

    .badge { display: inline-block; padding: 0.2rem 0.7rem; border-radius: 30px; font-size: 0.7rem; font-weight: 600; }
    .badge-pending  { background: #fff3e3; color: #b45309; }
    .badge-progress { background: #e0f2fe; color: #0369a1; }
    .badge-resolved { background: #e0f2e9; color: #15803d; }
    .badge-admin    { background: #fce7f3; color: #be185d; }
    .badge-volunteer{ background: #e8eef5; color: #1e3a5f; }
    .badge-affected { background: #f1f0f0; color: #4b5563; }

    select, input { padding: 0.4rem 0.7rem; border-radius: 30px; border: 1.5px solid var(--border); background: var(--white); font-family: var(--font-bd); }
    .action-btn { background: transparent; border: 1px solid var(--border); border-radius: 30px; padding: 0.3rem 0.8rem; cursor: pointer; font-size: 0.7rem; transition: 0.2s; }
    .action-btn:hover { background: var(--red); color: white; border-color: var(--red); }

    .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); align-items: center; justify-content: center; z-index: 1000; }
    .modal-card { background: white; border-radius: 28px; width: 90%; max-width: 460px; border: 1px solid var(--border); }
    .modal-header { padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; font-weight: 700; }
    .modal-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; }
    .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 0.8rem; }

    .toast { position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: white; padding: 0.6rem 1.2rem; border-radius: 40px; font-size: 0.8rem; opacity: 0; transition: 0.2s; z-index: 1100; }

    @media (max-width: 800px) {
      .stats-grid { grid-template-columns: 1fr; }
      .admin-nav { flex-wrap: wrap; height: auto; padding: 0.8rem; gap: 0.8rem; }
    }
  </style>
</head>
<body>

<div class="admin-nav">
  <div class="nav-brand">
    <div class="logo-icon"><svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 15h-2v-2h2zm0-4h-2V7h2z"/></svg></div>
    <span class="brand-text">DR<em>CS</em> · ADMIN</span>
    <span class="admin-badge">🔐 Command Center</span>
  </div>
  <div class="nav-tabs">
    <button class="tab-btn active" data-tab="users">👥 Manage Users</button>
    <button class="tab-btn" data-tab="requests">📋 All Requests</button>
    <button class="tab-btn" data-tab="assign">🔄 Assign Volunteers</button>
  </div>
  <button class="logout-btn" onclick="window.location.href='../../auth/signin.php'">🚪 Exit</button>
</div>

<div class="admin-container">

  <!-- MANAGE USERS TAB -->
  <div id="usersTab" class="tab-content active-tab">
    <div class="section-header">
      <h2>👥 System Users</h2>
    </div>
    <?php
      // Include user_view.php only to populate $userRows, $volCount, $affCount.
      // USER_VIEW_EMBEDDED suppresses its HTML shell; the table rows are
      // rendered directly below so we have full control over the markup.
      define('USER_VIEW_EMBEDDED', true);
      define('USER_VIEW_DATA_ONLY', true);
      include 'user_view.php';
    ?>
    <div class="stats-grid" style="grid-template-columns: repeat(2,1fr);">
      <div class="stat-card"><div class="label">🤝 Volunteers</div><div class="value"><?php echo $volCount; ?></div></div>
      <div class="stat-card"><div class="label">🆘 Affected People</div><div class="value"><?php echo $affCount; ?></div></div>
    </div>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>User ID</th><th>Username</th><th>User Role</th><th>Created At</th><th>Action</th>
          </tr>
        </thead>
        <tbody id="usersTableBody">
          <?php foreach ($userRows as $row):
            $uid        = (int) $row['user_id'];
            $username   = htmlspecialchars($row['username'],   ENT_QUOTES);
            $role       = htmlspecialchars($row['user_role'],  ENT_QUOTES);
            $createdAt  = htmlspecialchars($row['created_at'], ENT_QUOTES);
            $badgeClass = $row['user_role'] === 'volunteer' ? 'badge-volunteer' : 'badge-affected';
          ?>
            <tr id="user-row-<?php echo $uid; ?>">
              <td><?php echo $uid; ?></td>
              <td><?php echo $username; ?></td>
              <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $role; ?></span></td>
              <td><?php echo $createdAt; ?></td>
              <td>
                <button class="action-btn"
                  onclick="deleteUser(<?php echo $uid; ?>, '<?php echo $username; ?>')">
                  Remove
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (empty($userRows)): ?>
            <tr><td colspan="5" style="text-align:center; color:var(--muted);">No users found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- REQUESTS TAB -->
  <div id="requestsTab" class="tab-content">
    <div class="section-header">
      <h2>📋 Citizen & Field Requests</h2>
      <select id="filterRequestStatus">
        <option value="all">All requests</option>
        <option value="pending">Pending</option>
        <option value="in-progress">In Progress</option>
        <option value="resolved">Resolved</option>
      </select>
    </div>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Request ID</th>
            <th>Affected People ID</th>
            <th>Loc ID</th>
            <th>Request Name</th>
            <th>Resource Type</th>
            <th>Request Type</th>
            <th>Resource Count</th>
            <th>No. Affected</th>
            <th>Description</th>
            <th>Contact</th>
            <th>Priority</th>
            <th>Created At</th>
            <th>Status</th>
            <th>Is Instant</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="requestsTableBody">
          <?php
            define('VIEW_REQUEST_EMBEDDED', true);
            include 'view_request.php';
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ASSIGN VOLUNTEERS TAB -->
  <div id="assignTab" class="tab-content">
    <div class="section-header">
      <h2>🔄 Assign Volunteers to Requests</h2>
      <p style="color:var(--muted); font-size:0.8rem;">Match volunteers with open requests</p>
    </div>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Request ID</th><th>Type</th><th>Resource</th><th>Location</th>
            <th>Status</th><th>Assign Volunteer</th><th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $openReqResult = $conn->query(
                "SELECT r.req_id, r.req_type, r.resource_type, r.loc_id, r.status
                 FROM Request r
                 WHERE LOWER(TRIM(r.status)) != 'resolved'
                 ORDER BY r.req_id DESC"
            );
            $openRequests = [];
            while ($oRow = $openReqResult->fetch_assoc()) $openRequests[] = $oRow;
          ?>
          <?php if (count($openRequests) > 0): ?>
            <?php foreach ($openRequests as $oRow): ?>
              <?php
                $statusNorm   = strtolower(trim($oRow['status']));
                $currentVolId = $assignments[$oRow['req_id']] ?? null;
              ?>
              <tr>
                <td>#<?php echo htmlspecialchars($oRow['req_id'], ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($oRow['req_type'], ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($oRow['resource_type'], ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($oRow['loc_id'], ENT_QUOTES); ?></td>
                <td><span class="badge badge-progress"><?php echo htmlspecialchars($oRow['status'], ENT_QUOTES); ?></span></td>
                <td>
                  <select id="assignSelect_<?php echo $oRow['req_id']; ?>">
                    <option value="">— assign volunteer —</option>
                    <?php foreach ($volunteers as $v): ?>
                      <option value="<?php echo $v['user_id']; ?>"
                        <?php echo $currentVolId == $v['user_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($v['username'], ENT_QUOTES); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </td>
                <td>
                  <button class="action-btn"
                    onclick="confirmAssign(<?php echo $oRow['req_id']; ?>)">
                    Assign
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="7" style="text-align:center; color:var(--muted);">No open requests</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- TOAST -->
<div id="toastMsg" class="toast"></div>

<script src="admin.js"></script>
</body>
</html>
