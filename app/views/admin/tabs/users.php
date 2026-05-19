<!-- MANAGE USERS TAB -->
<div id="usersTab" class="tab-content active-tab">
  <div class="section-header">
    <h2><i class="fa-solid fa-users"></i> System Users</h2>
     <a href="../../app/views/admin/adminReg.php" style="text-decoration: none;">
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
  
  <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card"><div class="label">Admins</div><div class="value"><?php echo $userCounts['admin']; ?></div></div>
    <div class="stat-card"><div class="label">Volunteers</div><div class="value"><?php echo $userCounts['volunteer']; ?></div></div>
    <div class="stat-card"><div class="label">Affected People</div><div class="value"><?php echo $userCounts['affected_people']; ?></div></div>
  </div>
  
  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>User ID</th><th>Username</th><th>User Role</th><th>Created At</th><th>Action</th>
        </tr>
      </thead>
      <tbody id="usersTableBody">
        <?php foreach ($users as $row):
          $uid        = (int) $row['user_id'];
          $username   = htmlspecialchars($row['username'],   ENT_QUOTES);
          $role       = htmlspecialchars($row['user_role'],  ENT_QUOTES);
          $createdAt  = htmlspecialchars($row['created_at'], ENT_QUOTES);
          
          if ($row['user_role'] === 'volunteer') {
              $badgeClass = 'badge-volunteer';
          } elseif ($row['user_role'] === 'affected_people') {
              $badgeClass = 'badge-affected';
          } else {
              $badgeClass = 'badge-admin';
          }
          
          $roleDisplay = ucfirst(str_replace('_', ' ', $role));
        ?>
          <tr id="user-row-<?php echo $uid; ?>">
            <td><?php echo $uid; ?></td>
            <td><?php echo $username; ?></td>
            <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $roleDisplay; ?></span></td>
            <td><?php echo $createdAt; ?></td>
            <td>
              <button class="action-btn" onclick="deleteUser(<?php echo $uid; ?>, '<?php echo $username; ?>')">
                Remove
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($users)): ?>
          <tr><td colspan="5" style="text-align:center; color:var(--muted);">No users found</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>