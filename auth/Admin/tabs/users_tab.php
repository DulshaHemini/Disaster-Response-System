<?php
require_once __DIR__ . '/../../../config/config.php';

$embedded  = defined('USER_VIEW_EMBEDDED');
$dataOnly  = defined('USER_VIEW_DATA_ONLY');

// Handle delete request (standalone mode only — embedded uses admin.php AJAX)
if (!$embedded && isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully'); window.location.href='" . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES) . "';</script>";
    } else {
        echo "Error deleting user";
    }
    $stmt->close();
}

// Retrieve users (volunteers + affected people only)
$view_sql = "SELECT * FROM users WHERE user_role='affected_people' OR user_role='volunteer'";
$result   = $conn->query($view_sql);

// Build row array and compute counts in one pass
$userRows = [];
$volCount = 0;
$affCount = 0;
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $userRows[] = $row;
        if ($row['user_role'] === 'volunteer')           $volCount++;
        elseif ($row['user_role'] === 'affected_people') $affCount++;
    }
}
// If data-only mode, stop here — $userRows, $volCount, $affCount are ready
if ($dataOnly) return;

?>
<?php if (!$embedded): ?>

<!-- MANAGE USERS TAB -->
<div id="usersTab" class="tab-content active-tab">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <div class="section-header">
    <h2> <i class="fa-solid fa-users"></i> System Users</h2>
     <a href="adminReg.php" style="text-decoration: none;">
       <button class="btn-primary">Add New Admin</button>
     </a>
  </div>
  
  <div class="stats-grid" style="grid-template-columns: repeat(2,1fr);">
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
  <script>
    document.querySelectorAll('.action-btn[data-id]').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            if (confirm('Do you want to remove this user?')) {
                window.location.href = '?delete_id=' + encodeURIComponent(userId);
            }
        });
    });
</script>
</div>