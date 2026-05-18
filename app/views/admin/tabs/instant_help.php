<?php
// Compute counts
$totalInstant = count($instantRequests);
$pendingInstant = 0;
$inProgressInstant = 0;
$resolvedInstant = 0;

foreach ($instantRequests as $req) {
    $statusNorm = strtolower(trim($req['status']));
    if ($statusNorm === 'pending') $pendingInstant++;
    elseif (str_contains($statusNorm, 'progress')) $inProgressInstant++;
    elseif ($statusNorm === 'resolved') $resolvedInstant++;
}
?>

<!-- INSTANT HELP TAB -->
<div id="instantHelpTab" class="tab-content">
  <div class="section-header">
    <h2>⚡ Instant Help Requests</h2>
    <p style="color:var(--muted); font-size:0.8rem;">Emergency requests from unregistered users</p>
  </div>

  <div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card">
      <div class="label">📊 Total Requests</div>
      <div class="value"><?php echo $totalInstant; ?></div>
    </div>
    <div class="stat-card">
      <div class="label">⏳ Pending</div>
      <div class="value" style="color: var(--amber);"><?php echo $pendingInstant; ?></div>
    </div>
    <div class="stat-card">
      <div class="label">🔄 In Progress</div>
      <div class="value" style="color: var(--blue);"><?php echo $inProgressInstant; ?></div>
    </div>
    <div class="stat-card">
      <div class="label">✅ Resolved</div>
      <div class="value" style="color: var(--green);"><?php echo $resolvedInstant; ?></div>
    </div>
  </div>

  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Request ID</th>
          <th>Full Name</th>
          <th>Request Name</th>
          <th>Resource Type</th>
          <th>Count</th>
          <th>Contact</th>
          <th>Location</th>
          <th>District</th>
          <th>Description</th>
          <th>Created At</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="instantHelpTableBody">
        <?php if (count($instantRequests) > 0): ?>
          <?php foreach ($instantRequests as $row): ?>
            <?php
              $reqId = (int) $row['req_id'];
              $statusNorm = strtolower(trim($row['status']));
              $badgeClass = match(true) {
                  $statusNorm === 'pending' => 'badge-pending',
                  str_contains($statusNorm, 'progress') => 'badge-progress',
                  $statusNorm === 'resolved' => 'badge-resolved',
                  default => 'badge-pending',
              };
              
              $location = [];
              if (!empty($row['city'])) $location[] = $row['city'];
              if (!empty($row['street'])) $location[] = $row['street'];
              $locationStr = !empty($location) ? implode(', ', $location) : '—';
            ?>
            <tr data-id="<?php echo $reqId; ?>" data-status="<?php echo htmlspecialchars($statusNorm, ENT_QUOTES); ?>">
              <td>#<?php echo $reqId; ?></td>
              <td><?php echo htmlspecialchars($row['full_name'] ?? '—', ENT_QUOTES); ?></td>
              <td><?php echo htmlspecialchars($row['req_name'], ENT_QUOTES); ?></td>
              <td><span class="badge badge-progress"><?php echo htmlspecialchars($row['resource_type'], ENT_QUOTES); ?></span></td>
              <td><?php echo htmlspecialchars($row['resource_count'] ?? '—', ENT_QUOTES); ?></td>
              <td><?php echo htmlspecialchars($row['contact_number'], ENT_QUOTES); ?></td>
              <td><?php echo htmlspecialchars($locationStr, ENT_QUOTES); ?></td>
              <td><?php echo htmlspecialchars($row['district'] ?? '—', ENT_QUOTES); ?></td>
              <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" 
                  title="<?php echo htmlspecialchars($row['description'] ?? '', ENT_QUOTES); ?>">
                <?php echo htmlspecialchars($row['description'] ?? '—', ENT_QUOTES); ?>
              </td>
              <td><?php echo htmlspecialchars($row['created_at'], ENT_QUOTES); ?></td>
              <td class="statusCell">
                <span class="badge <?php echo $badgeClass; ?>">
                  <?php echo htmlspecialchars($row['status'], ENT_QUOTES); ?>
                </span>
              </td>
              <td>
                <select onchange="updateRequestStatus(<?php echo $reqId; ?>, this.value, this)">
                  <option value="pending" <?php echo $statusNorm === 'pending' ? 'selected' : ''; ?>>Pending</option>
                  <option value="in-progress" <?php echo str_contains($statusNorm, 'progress') ? 'selected' : ''; ?>>In Progress</option>
                  <option value="resolved" <?php echo $statusNorm === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                </select>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="12" style="text-align:center; color:var(--muted);">No instant help requests found</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>