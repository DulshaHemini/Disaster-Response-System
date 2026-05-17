<div id="locationsTab" class="tab-content">
    <div class="admin-container" style="padding:0; margin:0; max-width:none;">
        <div class="section-header">
            <h2><i class="fa-solid fa-map-marker-alt"></i> Locations</h2>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Loc ID</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>District</th>
                        <th>City</th>
                        <th>Street</th>
                        <th>Home No</th>
                        <th>Coordinates</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($locations) > 0): ?>
                        <?php foreach ($locations as $row): ?>
                            <?php
                                $role       = $row['user_role'] ?? '';
                                $badgeClass = match($role) {
                                    'admin'           => 'badge-admin',
                                    'volunteer'       => 'badge-volunteer',
                                    'affected_people' => 'badge-affected',
                                    default           => 'badge-volunteer',
                                };
                                $lat = $row['latitude']  !== null ? number_format((float)$row['latitude'],  6) : '—';
                                $lng = $row['longitude'] !== null ? number_format((float)$row['longitude'], 6) : '—';
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['loc_id'],              ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['username']   ?? '—',   ENT_QUOTES); ?></td>
                                <td>
                                    <?php if ($role): ?>
                                        <span class="badge <?php echo $badgeClass; ?>">
                                            <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $role)), ENT_QUOTES); ?>
                                        </span>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['district']   ?? '—',   ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['city']       ?? '—',   ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['street']     ?? '—',   ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['home_no']    ?? '—',   ENT_QUOTES); ?></td>
                                <td class="coords"><?php echo $lat; ?>, <?php echo $lng; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" style="text-align:center; color:var(--muted);">No locations found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
