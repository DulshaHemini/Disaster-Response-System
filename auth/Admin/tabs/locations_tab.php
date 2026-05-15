<?php
require_once __DIR__ . '/../../../config/config.php';

// JOIN with users to show who each location belongs to
$sql    = "SELECT l.loc_id, l.user_id, u.username, u.user_role,
                  l.district, l.city, l.street, l.home_no,
                  l.latitude, l.longitude
           FROM Location l
           LEFT JOIN users u ON l.user_id = u.user_id
           ORDER BY l.loc_id ASC";
$result = $conn->query($sql);
?>

<div id="locationsTab" class="tab-content">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="admin-container">
        <div class="section-header">
            <h2>📍 Locations</h2>
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
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <?php
                                $role       = $row['user_role'] ?? '';
                                $badgeClass = match($role) {
                                    'admin'           => 'badge-admin',
                                    'volunteer'       => 'badge-volunteer',
                                    'affected_people' => 'badge-affected_people',
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
                                            <?php echo htmlspecialchars($role, ENT_QUOTES); ?>
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
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8" style="text-align:center; color:var(--muted);">No locations found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
