<div id="resourcesTab" class="tab-content">
    <div class="admin-container" style="padding:0; margin:0; max-width:none;">
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
                    <?php if (count($resources) > 0): ?>
                        <?php foreach ($resources as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['resource_id'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['volunteer_id'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['resource_name'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['resource_type'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['resource_count'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($row['description'], ENT_QUOTES); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align:center; color:var(--muted);">No resources found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>