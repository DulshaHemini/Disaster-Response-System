<?php
require_once '../../config/config.php';

$embedded = defined('VIEW_REQUEST_EMBEDDED');

// UNION both request types into one result set.
// Logged_Request has req_type, no_of_affected_people, priority_level.
// Instant_Request does not — those columns are filled with NULLs.
$view_sql = "
    SELECT
        lr.req_id,
        lr.affected_people_id,
        lr.loc_id,
        lr.req_name,
        lr.resource_type,
        lr.req_type,
        lr.resource_count,
        lr.no_of_affected_people,
        lr.description,
        lr.contact_number,
        lr.priority_level,
        lr.created_at,
        lr.status,
        'No' AS is_instant
    FROM Logged_Request lr

    UNION ALL

    SELECT
        ir.req_id,
        ir.user_id          AS affected_people_id,
        ir.loc_id,
        ir.req_name,
        ir.resource_type,
        NULL                AS req_type,
        ir.resource_count,
        NULL                AS no_of_affected_people,
        ir.description,
        ir.contact_number,
        NULL                AS priority_level,
        ir.created_at,
        ir.status,
        'Yes'               AS is_instant
    FROM Instant_Request ir

    ORDER BY req_id DESC
";
$result = $conn->query($view_sql);
?>

<?php if (!$embedded): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests · DRCS Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Outfit:wght@300;400;500;600&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --white: #ffffff;
            --off: #f8f5f2;
            --surface: #f2ede8;
            --red: #c8102e;
            --red-dk: #9b0b21;
            --red-lt: #fbeaec;
            --red-m: #f5c0c7;
            --amber: #d97706;
            --green: #15803d;
            --blue: #1d4ed8;
            --slate: #475569;
            --text: #1a1a1a;
            --muted: #6b6b6b;
            --border: #e2ddd8;
            --font-hd: 'Playfair Display', serif;
            --font-bd: 'Outfit', sans-serif;
            --font-mn: 'JetBrains Mono', monospace;
            --shadow: 0 4px 12px rgba(0,0,0,0.05);
            --radius-lg: 20px;
            --radius-md: 14px;
        }

        body { background: var(--off); font-family: var(--font-bd); color: var(--text); overflow-x: hidden; }

        .admin-nav {
            background: rgba(255,255,255,0.96);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(12px);
        }
        .nav-brand { display: flex; align-items: center; gap: 0.75rem; }
        .logo-icon { width: 38px; height: 38px; background: var(--red); border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .logo-icon svg { width: 22px; fill: #fff; }
        .brand-text { font-family: var(--font-hd); font-size: 1.3rem; }
        .brand-text em { color: var(--red); font-style: normal; }
        .admin-badge { background: var(--red-lt); padding: 0.3rem 1rem; border-radius: 40px; font-size: 0.75rem; font-weight: 600; color: var(--red); font-family: var(--font-mn); }
        .back-btn { background: transparent; border: 1.5px solid var(--border); padding: 0.4rem 1rem; border-radius: 40px; cursor: pointer; font-size: 0.75rem; font-family: var(--font-bd); }
        .back-btn:hover { background: var(--surface); }

        .admin-container { max-width: 1400px; margin: 0 auto; padding: 2rem; }

        .section-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 1.5rem; }
        .section-header h2 { font-family: var(--font-hd); font-size: 1.6rem; }

        .table-wrapper { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        th { text-align: left; padding: 1rem 1.2rem; background: var(--off); font-family: var(--font-mn); font-size: 0.7rem; color: var(--muted); border-bottom: 1px solid var(--border); }
        td { padding: 0.9rem 1.2rem; border-bottom: 1px solid var(--border); vertical-align: middle; }

        .badge { display: inline-block; padding: 0.2rem 0.7rem; border-radius: 30px; font-size: 0.7rem; font-weight: 600; }
        .badge-pending  { background: #fff3e3; color: #b45309; }
        .badge-progress { background: #e0f2fe; color: #0369a1; }
        .badge-resolved { background: #e0f2e9; color: #15803d; }

        select, input { padding: 0.4rem 0.7rem; border-radius: 30px; border: 1.5px solid var(--border); background: var(--white); font-family: var(--font-bd); }
        .action-btn { background: transparent; border: 1px solid var(--border); border-radius: 30px; padding: 0.3rem 0.8rem; cursor: pointer; font-size: 0.7rem; transition: 0.2s; font-family: var(--font-bd); }
        .action-btn:hover { background: var(--red); color: white; border-color: var(--red); }

        @media (max-width: 800px) {
            .admin-nav { flex-wrap: wrap; height: auto; padding: 0.8rem; gap: 0.8rem; }
        }
    </style>
</head>
<body>

<div class="admin-nav">
    <div class="nav-brand">
        <div class="logo-icon"><svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 15h-2v-2h2zm0-4h-2V7h2z"/></svg></div>
        <span class="brand-text">DR<em>CS</em> · ADMIN</span>
        <span class="admin-badge">📋 Requests</span>
    </div>
    <button class="back-btn" onclick="window.location.href='admin.php'">← Back to Admin</button>
</div>

<div class="admin-container">
    <div class="section-header">
        <h2>📋 All Requests</h2>
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
<?php endif; /* !$embedded — standalone header ends here */ ?>

<?php
if ($result && $result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
        $reqId      = (int) $row['req_id'];
        $statusNorm = strtolower(str_replace(' ', '-', trim($row['status'])));
        $badgeClass = $statusNorm === 'pending'
            ? 'badge-pending'
            : ($statusNorm === 'in-progress' ? 'badge-progress' : 'badge-resolved');

        // In embedded mode the status-update select calls admin.js updateRequestStatus(id, val, el)
        // In standalone mode it calls the local updateRequestStatus(id, val) defined below
        $onchange = $embedded
            ? "updateRequestStatus({$reqId}, this.value, this)"
            : "updateRequestStatus({$reqId}, this.value)";
?>
        <tr data-id="<?php echo $reqId; ?>" data-status="<?php echo htmlspecialchars($statusNorm, ENT_QUOTES); ?>">
            <td><?php echo $reqId; ?></td>
            <td><?php echo htmlspecialchars($row['affected_people_id'], ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($row['loc_id'],             ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($row['req_name'],           ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($row['resource_type'],      ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($row['req_type'],           ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($row['resource_count'],     ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($row['no_of_affected_people'], ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($row['description'],        ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($row['contact_number'],     ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($row['priority_level'],     ENT_QUOTES); ?></td>
            <td><?php echo htmlspecialchars($row['created_at'],         ENT_QUOTES); ?></td>
            <td class="statusCell">
                <span class="badge <?php echo $badgeClass; ?>">
                    <?php echo htmlspecialchars($row['status'], ENT_QUOTES); ?>
                </span>
            </td>
            <td><?php echo htmlspecialchars($row['is_instant'], ENT_QUOTES); ?></td>
            <td>
                <select onchange="<?php echo $onchange; ?>">
                    <option value="pending"     <?php echo $statusNorm === 'pending'     ? 'selected' : ''; ?>>Pending</option>
                    <option value="in-progress" <?php echo $statusNorm === 'in-progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="resolved"    <?php echo $statusNorm === 'resolved'    ? 'selected' : ''; ?>>Resolved</option>
                </select>
            </td>
        </tr>
<?php
    endwhile;
else:
    $colspan = $embedded ? 15 : 15;
    echo "<tr><td colspan='{$colspan}' style='text-align:center; color:var(--muted);'>No requests found</td></tr>";
endif;
?>

<?php if (!$embedded): ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const filterRequestStatus = document.getElementById('filterRequestStatus');
    const requestRows = Array.from(document.querySelectorAll('#requestsTableBody tr'));

    function normalizeStatus(status) {
        return status.toString().trim().toLowerCase().replace(/\s+/g, '-');
    }

    function renderRequests() {
        const filter = filterRequestStatus.value;
        requestRows.forEach(row => {
            const status = normalizeStatus(row.dataset.status || '');
            row.style.display = (filter === 'all' || status === filter) ? '' : 'none';
        });
    }

    // Standalone-only status update (no AJAX — visual only for standalone view)
    function updateRequestStatus(reqId, newStatus) {
        const row = document.querySelector(`#requestsTableBody tr[data-id="${reqId}"]`);
        if (!row) return;
        row.dataset.status = normalizeStatus(newStatus);
        const badgeClass = newStatus === 'pending'     ? 'badge-pending'
                         : newStatus === 'in-progress' ? 'badge-progress'
                         :                               'badge-resolved';
        row.querySelector('.statusCell').innerHTML =
            `<span class="badge ${badgeClass}">${newStatus}</span>`;
        renderRequests();
    }

    filterRequestStatus.addEventListener('change', renderRequests);
    document.addEventListener('DOMContentLoaded', renderRequests);
</script>

</body>
</html>
<?php endif; ?>
