<!-- REQUESTS TAB -->
<div id="requestsTab" class="tab-content">
  <div class="section-header">
    <h2><i class="fa-solid fa-check-to-slot"></i> All Help Requests</h2>
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
        <?php if (!empty($allRequests)): ?>
          <?php foreach ($allRequests as $row):
            $reqId      = (int) $row['req_id'];
            $statusNorm = strtolower(str_replace(' ', '-', trim($row['status'])));
            $badgeClass = match($statusNorm) {
                'pending' => 'badge-pending',
                'in-progress' => 'badge-progress',
                'resolved' => 'badge-resolved',
                default => 'badge-pending'
            };
          ?>
            <tr data-id="<?php echo $reqId; ?>" data-status="<?php echo htmlspecialchars($statusNorm, ENT_QUOTES); ?>">
                <td><?php echo $reqId; ?></td>
                <td><?php echo htmlspecialchars($row['affected_people_id'] ?? '—', ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($row['loc_id'] ?? '—',             ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($row['req_name'],           ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($row['resource_type'],      ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($row['req_type'] ?? '—',           ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($row['resource_count'],     ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($row['no_of_affected_people'] ?? '—', ENT_QUOTES); ?></td>
                <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars($row['description'] ?? '', ENT_QUOTES); ?>">
                    <?php echo htmlspecialchars($row['description'] ?? '—',        ENT_QUOTES); ?>
                </td>
                <td><?php echo htmlspecialchars($row['contact_number'],     ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($row['priority_level'] ?? '—',     ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($row['created_at'],         ENT_QUOTES); ?></td>
                <td class="statusCell">
                    <span class="badge <?php echo $badgeClass; ?>">
                        <?php echo htmlspecialchars($row['status'], ENT_QUOTES); ?>
                    </span>
                </td>
                <td><?php echo htmlspecialchars($row['is_instant'], ENT_QUOTES); ?></td>
                <td>
                    <select onchange="updateRequestStatus(<?php echo $reqId; ?>, this.value, this)">
                        <option value="pending"     <?php echo $statusNorm === 'pending'     ? 'selected' : ''; ?>>Pending</option>
                        <option value="in-progress" <?php echo $statusNorm === 'in-progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="resolved"    <?php echo $statusNorm === 'resolved'    ? 'selected' : ''; ?>>Resolved</option>
                    </select>
                </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="15" style="text-align:center; color:var(--muted);">No requests found</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>