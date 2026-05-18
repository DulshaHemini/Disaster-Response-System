<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
$user_role = $_SESSION['user_role'] ?? '';
$user_id = $_SESSION['user_id'] ?? '';

// Define base URL for the application
$base_url = '/disaster-Response-System';

// Determine home link based on user role
$home_link = $base_url . '/public/index.php';
if ($is_logged_in) {
    switch ($user_role) {
        case 'admin':
            $home_link = $base_url . '/app/controllers/Admin.php';
            break;
        case 'relief_team':
            $home_link = $base_url . '/app/controllers/ReliefTeam.php';
            break;
        case 'affected_people':
            $home_link = $base_url . '/affected-people';
            break;
        case 'volunteer':
            $home_link = $base_url . '/app/controllers/volunteer.php';
            break;
        default:
            $home_link = $base_url . '/public/index.php';
    }
}

// Get user role display name
$role_display = '';
if ($is_logged_in) {
    $role_display = ucwords(str_replace('_', ' ', $user_role));
}
?>
<!-- NAVBAR -->
<nav>
  <a class="nav-brand" href="<?= $home_link ?>">
    <div class="logo-icon">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 15h-2v-2h2zm0-4h-2V7h2z"/>
      </svg>
    </div>
    <span class="brand-text">DR<em>CS</em></span>
  </a>

  <div class="nav-center">
    <?php if ($is_logged_in): ?>
      
    <?php else: ?>
      <span style="color: var(--text-muted, #666); font-size: 0.9rem;">
        Disaster Response Coordination System
      </span>
    <?php endif; ?>
  </div>

  <div class="nav-right">
    <?php if ($is_logged_in): ?>
      <!-- Logged in user navigation -->
      <?php if ($user_role === 'admin'): ?>
        <button class="btn-outline" onclick="window.location.href='<?= $base_url ?>/app/controllers/TrackerController.php'">
          <i class="fas fa-map-marked-alt"></i> Tracker
        </button>
      <?php elseif ($user_role === 'affected_people' || $user_role === 'volunteer' || $user_role === 'relief_team'): ?>
        <button class="btn-outline" onclick="window.location.href='<?= $base_url ?>/app/controllers/TrackerController.php'">
          <i class="fas fa-map-marked-alt"></i> Tracker
        </button>
      <?php endif; ?>
      
      <button class="btn-outline" onclick="window.location.href='<?= $base_url ?>/app/controllers/logout.php'">
        <i class="fas fa-sign-out-alt"></i> Logout
      </button>
    <?php else: ?>
      <!-- Guest navigation -->
      <button class="btn-outline" onclick="window.location.href='<?= $base_url ?>/app/controllers/signin.php'">Sign In</button>
      <button class="btn-fill" onclick="window.location.href='<?= $base_url ?>/app/controllers/signup.php'">Sign Up</button>
    <?php endif; ?>
  </div>
</nav>