<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DRCS Admin</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Outfit:wght@300;400;500;600&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  
  <!-- Admin Styles -->
  <link rel="stylesheet" href="../views/admin/assets/css/admin.css">
</head>
<body>

<nav>
  <a class="nav-brand admin" href="../../public/index.php">
    <div class="logo-icon">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 15h-2v-2h2zm0-4h-2V7h2z"/>
      </svg>
    </div>
    <span class="brand-text">DR<em>CS</em> | ADMIN</span>
  </a>

  <div class="nav-center">
    <div class="nav-tabs">
      <button class="tab-btn active" data-tab="users"><i class="fa-solid fa-users-gear"></i> Manage Users</button>
      <button class="tab-btn" data-tab="requests"><i class="fa-solid fa-check-to-slot"></i> All Requests</button>
      <button class="tab-btn" data-tab="instantHelp"><i class="fa-solid fa-bolt"></i> Instant Help</button>
      <button class="tab-btn" data-tab="assign"><i class="fa-solid fa-user-plus"></i> Assign Volunteers</button>
      <button class="tab-btn" data-tab="resources"><i class="fa-solid fa-boxes-stacked"></i> Resource Management</button>
      <button class="tab-btn" data-tab="locations"><i class="fa-solid fa-hands-holding-child"></i>Relief Teams</button>
      <button class="tab-btn" data-tab="volunteers"><i class="fa-solid fa-hands-helping"></i> Volunteer Management</button>
    </div>
  </div>

  <div class="nav-right">
    <button class="logout-btn" onclick="window.location.href='../../auth/signin.php'"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
  </div>
</nav>

<!-- Alert Ticker -->
<?php require_once __DIR__ . '/../home/_ticker.php'; ?>

<div class="admin-container">
  <?php require_once __DIR__ . '/tabs/users.php'; ?>
  <?php require_once __DIR__ . '/tabs/requests.php'; ?>
  <?php require_once __DIR__ . '/tabs/instant_help.php'; ?>
  <?php require_once __DIR__ . '/tabs/assign.php'; ?>
  <?php require_once __DIR__ . '/tabs/resources.php'; ?>
  <?php require_once __DIR__ . '/tabs/reliefTeam.php'; ?>
  <?php require_once __DIR__ . '/tabs/volunteers.php'; ?>
</div>

<!-- TOAST -->
<div id="toastMsg" class="toast"></div>

<!-- Admin Scripts -->
<script src="../views/admin/assets/js/admin.js"></script>
</body>
</html>