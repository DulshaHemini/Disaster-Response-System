<?php
require_once __DIR__ . '/../../../config/config.php';

$view_sql = "SELECT * FROM resource";
$result = $conn->query($view_sql);
?>

<div id="resourcesTab" class="tab-content">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="admin-container">
        <div class="section-header">
            <h2><i class="fa-solid fa-boxes-stacked"></i> Resources</h2>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Resource ID</th>
                        <th>Volunteer ID</th>
                        <th>Resource Name</th>
                        <th>Resource Type</th>
                        <th>Resource Count</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['resource_id'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['volunteer_id'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['resource_name'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['resource_type'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['resource_count'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['description'], ENT_QUOTES); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align:center; color:var(--muted);">No resources found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
