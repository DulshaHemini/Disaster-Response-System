<?php
require_once '../../config/config.php';

// Handle AJAX actions from tabs (they exit after handling)
if (isset($_POST['action'])) {
    // Users tab actions
    if ($_POST['action'] === 'delete_user') {
        $id = intval($_POST['user_id']);
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        echo json_encode(['ok' => $stmt->execute()]);
        $stmt->close();
        exit;
    }
    
    // Requests tab actions
    if ($_POST['action'] === 'update_request_status') {
        $id     = intval($_POST['req_id']);
        $status = $_POST['status'];
        $allowed = ['pending', 'in-progress', 'resolved'];
        if (!in_array($status, $allowed)) { echo json_encode(['ok' => false]); exit; }
        $stmt = $conn->prepare("UPDATE Logged_Request SET status = ? WHERE req_id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
        $stmt = $conn->prepare("UPDATE Instant_Request SET status = ? WHERE req_id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
        echo json_encode(['ok' => true]);
        exit;
    }
    
    // Assign tab actions
    if ($_POST['action'] === 'assign_volunteer') {
        $req_id       = intval($_POST['req_id']);
        $volunteer_id = intval($_POST['volunteer_id']);
        $stmt = $conn->prepare("UPDATE Logged_Request SET status = 'in-progress' WHERE req_id = ? AND status = 'Pending'");
        $stmt->bind_param("i", $req_id);
        $stmt->execute();
        $stmt->close();
        $stmt = $conn->prepare("UPDATE Instant_Request SET status = 'in-progress' WHERE req_id = ? AND status = 'Pending'");
        $stmt->bind_param("i", $req_id);
        $stmt->execute();
        $stmt->close();
        $stmt = $conn->prepare(
            "INSERT INTO assignments (request_id, volunteer_id, assigned_date, status)
             VALUES (?, ?, CURDATE(), 'Assigned')
             ON DUPLICATE KEY UPDATE volunteer_id = VALUES(volunteer_id), status = 'Assigned'"
        );
        $stmt->bind_param("ii", $req_id, $volunteer_id);
        echo json_encode(['ok' => $stmt->execute()]);
        $stmt->close();
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DRCS Admin · Command Center | Sri Lanka</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Outfit:wght@300;400;500;600&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet"/>
  
  <!-- Admin Styles -->
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<!-- NAVBAR (adapted from home/_navbar.php) -->
<nav>
  <a class="nav-brand" href="../../public/index.php">
    <div class="logo-icon">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 15h-2v-2h2zm0-4h-2V7h2z"/>
      </svg>
    </div>
    <span class="brand-text">DR<em>CS</em> | ADMIN</span>
  </a>

  <div class="nav-center">
    <span class="admin-badge">🔐 Command Center</span>
    <div class="nav-tabs">
      <button class="tab-btn active" data-tab="users">👥 Manage Users</button>
      <button class="tab-btn" data-tab="requests">📋 All Requests</button>
      <button class="tab-btn" data-tab="instantHelp">⚡ Instant Help</button>
      <button class="tab-btn" data-tab="assign">🔄 Assign Volunteers</button>
      <button class="tab-btn" data-tab="resources">📦 Resource Management</button>
      <button class="tab-btn" data-tab="locations">🗺️ Location Management</button>
      <button class="tab-btn" data-tab="volunteers">👨‍💼 Volunteer Management</button>
    </div>
  </div>

  <div class="nav-right">
    <button class="logout-btn" onclick="window.location.href='../../auth/signin.php'">🚪 Exit</button>
  </div>
</nav>

<!-- TICKER (from home/_ticker.php) -->
<?php include '../../app/views/home/_ticker.php'; ?>

<div class="admin-container">
  <?php include 'tabs/users_tab.php'; ?>
  <?php include 'tabs/requests_tab.php'; ?>
  <?php include 'tabs/instant_help_tab.php'; ?>
  <?php include 'tabs/assign_tab.php'; ?>
  <?php include 'tabs/resources_tab.php'; ?>
  <?php include 'tabs/locations_tab.php'; ?>
  <?php include 'tabs/volunteers_tab.php'; ?>
</div>

<!-- TOAST -->
<div id="toastMsg" class="toast"></div>

<!-- Admin Scripts -->
<script src="assets/js/admin.js"></script>
</body>
</html>
