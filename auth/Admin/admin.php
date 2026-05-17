<?php
require_once '../../config/config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DRCS Admin · Command Center | Sri Lanka</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Outfit:wght@300;400;500;600&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Admin Styles -->
  <link rel="stylesheet" href="assets/css/admin.css">
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
      <button class="tab-btn" data-tab="locations"><i class="fa-solid fa-map-marker-alt"></i> Location Management</button>
      <button class="tab-btn" data-tab="volunteers"><i class="fa-solid fa-hands-helping"></i> Volunteer Management</button>
    </div>
  </div>

  <div class="nav-right">
    <button class="logout-btn" onclick="window.location.href='../../auth/signin.php'"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
    <php?  ?>
  </div>
</nav>


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
