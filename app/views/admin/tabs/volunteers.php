<div id="volunteersTab" class="tab-content">
    <div class="admin-container" style="padding:0; margin:0; max-width:none;">
        <div class="section-header">
            <h2><i class="fa-solid fa-hands-helping"></i> Volunteers</h2>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Volunteer ID</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>NIC</th>
                        <th>Gender</th>
                        <th>Contact No</th>
                        <th>Age</th>
                        <th>Availability</th>
                        <th>Organization</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($volunteers) > 0): ?>
                        <?php foreach ($volunteers as $row): ?>
                            <?php
                                $availability = $row['availability_status'];
                                $badgeClass   = $availability === 'available' ? 'badge-resolved' : 'badge-pending';
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['volunteer_id'],                ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['username'],                    ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['first_name'],                  ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['last_name'],                   ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['nic']              ?? '—',     ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['gender'],                      ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['contact_no']       ?? '—',     ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['age']              ?? '—',     ENT_QUOTES); ?></td>
                                <td>
                                    <span class="badge <?php echo $badgeClass; ?>">
                                        <?php echo htmlspecialchars($availability, ENT_QUOTES); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($row['organization_name'] ?? '—',    ENT_QUOTES); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="10" style="text-align:center; color:var(--muted);">No volunteers found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>