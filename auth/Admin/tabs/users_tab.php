<?php
require_once __DIR__ . '/../../../config/config.php';

$embedded  = defined('USER_VIEW_EMBEDDED');
$dataOnly  = defined('USER_VIEW_DATA_ONLY');

// Handle delete request
if (!$embedded && isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('User deleted successfully'); window.location.href='" . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES) . "?filter=" . htmlspecialchars($filter, ENT_QUOTES) . "';</script>";
        } else {
            echo "<script>alert('User not found'); window.location.href='" . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES) . "?filter=" . htmlspecialchars($filter, ENT_QUOTES) . "';</script>";
        }
    } else {
        echo "<script>alert('Error deleting user: " . addslashes($stmt->error) . "'); window.location.href='" . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES) . "?filter=" . htmlspecialchars($filter, ENT_QUOTES) . "';</script>";
    }
    $stmt->close();
    exit;
}

// Get filter parameter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$validFilters = ['all', 'admin', 'volunteer', 'affected_people'];
if (!in_array($filter, $validFilters)) {
    $filter = 'all';
}

// Retrieve users based on filter
if ($filter === 'all') {
    $view_sql = "SELECT * FROM users ORDER BY created_at DESC";
} else {
    $view_sql = "SELECT * FROM users WHERE user_role = '" . $conn->real_escape_string($filter) . "' ORDER BY created_at DESC";
}

$result = $conn->query($view_sql);

// Build row array and compute counts in one pass
$userRows = [];
$volCount = 0;
$affCount = 0;
$adminCount = 0;

// Get total counts
$countSql = "SELECT user_role, COUNT(*) as count FROM users GROUP BY user_role";
$countResult = $conn->query($countSql);
if ($countResult) {
    while ($row = $countResult->fetch_assoc()) {
        if ($row['user_role'] === 'volunteer')           $volCount = $row['count'];
        elseif ($row['user_role'] === 'affected_people') $affCount = $row['count'];
        elseif ($row['user_role'] === 'admin')           $adminCount = $row['count'];
    }
}

// Fetch filtered users
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $userRows[] = $row;
    }
}

// If data-only mode, stop here
if ($dataOnly) return;

?>
<?php if (!$embedded): ?>

<!-- MANAGE USERS TAB -->
<div id="usersTab" class="tab-content active-tab">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .filter-container {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 0.5rem 1.2rem;
        border: 1.5px solid var(--border);
        border-radius: 30px;
        background: var(--white);
        font-family: var(--font-bd);
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.2s ease;
        color: var(--text);
    }

    .filter-btn:hover {
        border-color: var(--red);
        color: var(--red);
    }

    .filter-btn.active {
        background: var(--red);
        border-color: var(--red);
        color: white;
        box-shadow: 0 4px 12px rgba(200, 16, 46, 0.25);
    }

    .filter-label {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-family: var(--font-mn);
        color: var(--muted);
        align-self: center;
    }
</style>

  <div class="section-header">
    <h2> <i class="fa-solid fa-users"></i> System Users</h2>
     <a href="adminReg.php" style="text-decoration: none;">
       <button class="btn-primary">Add New Admin</button>
     </a>
  </div>

  <!-- Filter Controls -->
  <div class="filter-container">
    <span class="filter-label">Filter by Type:</span>
    <button class="filter-btn <?php echo $filter === 'all' ? 'active' : ''; ?>" onclick="filterUsers('all')">
      All Users
    </button>
    <button class="filter-btn <?php echo $filter === 'admin' ? 'active' : ''; ?>" onclick="filterUsers('admin')">
      Admins
    </button>
    <button class="filter-btn <?php echo $filter === 'volunteer' ? 'active' : ''; ?>" onclick="filterUsers('volunteer')">
      Volunteers
    </button>
    <button class="filter-btn <?php echo $filter === 'affected_people' ? 'active' : ''; ?>" onclick="filterUsers('affected_people')">
      Affected People
    </button>
  </div>
  
  <div class="stats-grid" style="grid-template-columns: repeat(3,1fr);">
    <div class="stat-card"><div class="label">Admins</div><div class="value"><?php echo $adminCount; ?></div></div>
    <div class="stat-card"><div class="label">Volunteers</div><div class="value"><?php echo $volCount; ?></div></div>
    <div class="stat-card"><div class="label">Affected People</div><div class="value"><?php echo $affCount; ?></div></div>
  </div>
  
  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>User ID</th><th>Username</th><th>User Role</th><th>Created At</th><th>Action</th>
        </tr>
      </thead>
      <?php endif; ?>
      <tbody id="usersTableBody">
        <?php foreach ($userRows as $row):
          $uid        = (int) $row['user_id'];
          $username   = htmlspecialchars($row['username'],   ENT_QUOTES);
          $role       = htmlspecialchars($row['user_role'],  ENT_QUOTES);
          $createdAt  = htmlspecialchars($row['created_at'], ENT_QUOTES);
          
          // Determine badge class based on role
          if ($row['user_role'] === 'volunteer') {
              $badgeClass = 'badge-volunteer';
          } elseif ($row['user_role'] === 'affected_people') {
              $badgeClass = 'badge-affected';
          } else {
              $badgeClass = 'badge-admin';
          }
          
          // Format role display
          $roleDisplay = ucfirst(str_replace('_', ' ', $role));
        ?>
          <tr id="user-row-<?php echo $uid; ?>">
            <td><?php echo $uid; ?></td>
            <td><?php echo $username; ?></td>
            <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $roleDisplay; ?></span></td>
            <td><?php echo $createdAt; ?></td>
            <td>
              <button class="action-btn" data-id="<?php echo $uid; ?>" data-username="<?php echo $username; ?>">
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

  <script>
    function filterUsers(filterType) {
        // Get current URL
        const url = new URL(window.location);
        url.searchParams.set('filter', filterType);
        window.location.href = url.toString();
    }

    // Delete user functionality
    document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            const username = this.getAttribute('data-username');
            
            if (confirm(`Are you sure you want to delete user "${username}"?`)) {
                window.location.href = '?delete_id=' + encodeURIComponent(userId) + '&filter=' + (new URL(window.location).searchParams.get('filter') || 'all');
            }
        });
    });
  </script>
</div>
