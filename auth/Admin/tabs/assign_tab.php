<?php
// ── Fetch volunteers (for assign dropdown) ────────────────────────────────
$volResult = $conn->query(
    "SELECT v.volunteer_id, u.username
     FROM volunteer v
     JOIN users u ON v.volunteer_id = u.user_id
     ORDER BY u.username"
);
$volunteers = [];
while ($row = $volResult->fetch_assoc()) $volunteers[] = $row;

// ── Fetch current assignments (request_id → volunteer_id map) ─────────────
$assignResult = $conn->query("SELECT request_id, volunteer_id FROM assignments");
$assignments  = [];
while ($row = $assignResult->fetch_assoc()) {
    $assignments[$row['request_id']] = $row['volunteer_id'];
}
?>

<!-- ASSIGN VOLUNTEERS TAB -->
<div id="assignTab" class="tab-content">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <div class="section-header">
    <h2>🔄 Assign Volunteers to Requests</h2>
    <p style="color:var(--muted); font-size:0.8rem;">Match volunteers with open requests</p>
  </div>
  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Request ID</th><th>Type</th><th>Resource</th><th>Location</th>
          <th>Status</th><th>Assign Volunteer</th><th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          // Fetch open requests from both tables
          $openReqResult = $conn->query(
              "SELECT req_id, req_type, resource_type, loc_id, status FROM Logged_Request
               WHERE LOWER(TRIM(status)) != 'resolved'
               UNION ALL
               SELECT req_id, NULL AS req_type, resource_type, loc_id, status FROM Instant_Request
               WHERE LOWER(TRIM(status)) != 'resolved'
               ORDER BY req_id DESC"
          );
          $openRequests = [];
          while ($oRow = $openReqResult->fetch_assoc()) $openRequests[] = $oRow;
        ?>
        <?php if (count($openRequests) > 0): ?>
          <?php foreach ($openRequests as $oRow): ?>
            <?php
              $statusNorm   = strtolower(trim($oRow['status']));
              $currentVolId = $assignments[$oRow['req_id']] ?? null;
            ?>
            <tr>
              <td>#<?php echo htmlspecialchars($oRow['req_id'], ENT_QUOTES); ?></td>
              <td><?php echo htmlspecialchars($oRow['req_type'] ?? '—', ENT_QUOTES); ?></td>
              <td><?php echo htmlspecialchars($oRow['resource_type'], ENT_QUOTES); ?></td>
              <td><?php echo htmlspecialchars($oRow['loc_id'], ENT_QUOTES); ?></td>
              <td><span class="badge badge-progress"><?php echo htmlspecialchars($oRow['status'], ENT_QUOTES); ?></span></td>
              <td>
                <select id="assignSelect_<?php echo $oRow['req_id']; ?>">
                  <option value="">— assign volunteer —</option>
                  <?php foreach ($volunteers as $v): ?>
                    <option value="<?php echo $v['volunteer_id']; ?>"
                      <?php echo $currentVolId == $v['volunteer_id'] ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($v['username'], ENT_QUOTES); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td>
                <button class="action-btn"
                  onclick="confirmAssign(<?php echo $oRow['req_id']; ?>)">
                  Assign
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="7" style="text-align:center; color:var(--muted);">No open requests</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
