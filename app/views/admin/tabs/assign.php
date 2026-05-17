<!-- ASSIGN VOLUNTEERS TAB -->
<div id="assignTab" class="tab-content">
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
        <?php if (count($openRequests) > 0): ?>
          <?php foreach ($openRequests as $oRow): ?>
            <?php
              $statusNorm   = strtolower(trim($oRow['status']));
              $currentVolId = $assignmentsMap[$oRow['req_id']] ?? null;
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
