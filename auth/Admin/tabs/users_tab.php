<?php
// Include user_view.php only to populate $userRows, $volCount, $affCount.
define('USER_VIEW_EMBEDDED', true);
define('USER_VIEW_DATA_ONLY', true);
include __DIR__ . '/../user_view.php';
?>

<!-- MANAGE USERS TAB -->
<div id="usersTab" class="tab-content active-tab">
  <div class="section-header">
    <h2>👥 System Users</h2>
  </div>
  
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
