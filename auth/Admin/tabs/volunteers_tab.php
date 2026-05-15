<?php
require_once __DIR__ . '/../../../config/config.php';

// JOIN with users to get the username alongside volunteer profile data
$sql    = "SELECT v.volunteer_id, u.username, v.first_name, v.last_name,
                  v.nic, v.gender, v.contact_no, v.age,
                  v.availability_status, v.organization_name
           FROM volunteer v
           JOIN users u ON v.volunteer_id = u.user_id
           ORDER BY v.volunteer_id ASC";
$result = $conn->query($sql);
?>

<div id="volunteersTab" class="tab-content">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="admin-container">
        <div class="section-header">
            <h2>🤝 Volunteers</h2>
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
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <?php
                                $availability = $row['availability_status'];
                                $badgeClass   = $availability === 'available' ? 'badge-available' : 'badge-busy';
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
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="10" style="text-align:center; color:var(--muted);">No volunteers found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
