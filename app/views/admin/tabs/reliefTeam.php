<div id="locationsTab" class="tab-content">
    <div class="admin-container" style="padding:0; margin:0; max-width:none;">
        <div class="section-header">
            <h2><i class="fa-solid fa-hands-holding-child"></i> Relief Teams</h2>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Team ID</th>
                        <th>Team Name</th>
                        <th>Specialization</th>
                        <th>Contact No</th>
                        <th>Email</th>
                        <th>Team Members</th>
                        <th>Vehicle Type</th>
                        <th>Vehicle No</th>
                        <th>Availability Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($locations) > 0): ?>
                        <?php foreach ($locations as $row): ?>
                            <?php
                                $statusClass = match(strtolower($row['status'] ?? 'inactive')) {
                                    'active'   => 'badge-active',
                                    'inactive' => 'badge-inactive',
                                    'busy'     => 'badge-busy',
                                    default    => 'badge-inactive',
                                };
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['relief_team_id'] ?? '—', ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['team_name'] ?? '—', ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['specialization'] ?? '—', ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['contact_no'] ?? '—', ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['email'] ?? '—', ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['no_of_members'] ?? '—', ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['vehicle_type'] ?? '—', ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['vehicle_number'] ?? '—', ENT_QUOTES); ?></td>
                                <td>
                                    <?php if (isset($row['availability_status'])): ?>
                                        <span class="badge <?php echo $statusClass; ?>">
                                            <?php echo htmlspecialchars(ucfirst($row['availability_status']), ENT_QUOTES); ?>
                                        </span>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="11" style="text-align:center; color:var(--muted);">No relief teams found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
