<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Assignments - DRCS</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/tracker.css">
    <link rel="stylesheet" href="assets/css/ticker.css">
    <link rel="stylesheet" href="assets/css/request.css">
    <style>
        body {
            overflow-y: auto !important;
            overflow-x: hidden !important;
            height: auto !important;
        }
        .table-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        /* spacing between table cards */
        .table-card { margin-bottom: 2rem; }
    </style>
</head>
<body>

<?php require APP_PATH . '/views/home/_navbar.php'; ?>
<?php require APP_PATH . '/views/home/_ticker.php'; ?>

<!-- SEARCH & FILTER TOOLBAR -->
<div class="toolbar">
    <div class="search-wrap">
        <span class="search-icon">🔍</span>
        <input type="text" id="search-input" placeholder="Search by ID, description, volunteer…" oninput="filterTable()">
    </div>
    <select class="filter-select" id="status-filter" onchange="filterTable()">
        <option value="">All Statuses</option>
        <option value="Assigned">Assigned</option>
        <option value="Allocated">Allocated</option>
        <option value="Received">Received</option>
        <option value="Pending">Pending</option>
        <option value="Rejected">Rejected</option>
    </select>
</div>

<!-- TABLE 1 — ALL / ACTIVE ASSIGNMENTS -->
<div class="table-card">
    <div class="table-head-row">
        <span class="table-head-label">// ASSIGNMENT RECORDS</span>
        <span class="record-count" id="record-count-1"></span>
    </div>
    <div class="table-scroll">
        <table id="assignment-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DATE</th>
                    <th>REQ ID</th>
                    <th>RESOURCE</th>
                    <th>VOLUNTEER</th>
                    <th>AFFECTED PEOPLE</th>
                    <th>DESCRIPTION</th>
                    <th>STATUS</th>
                    <th>CHANGE STATUS</th>
                    
                </tr>
            </thead>
            <tbody id="table-body-1">
                <?php foreach($result as $item): ?>
                    <//?php if($item['status'] == 'Assigned'): ?>
                <tr data-status="<?= htmlspecialchars($item['status']) ?>"
                    data-search="<?= strtolower(htmlspecialchars($item['description'] . ' ' . $item['volunteer_id'])) ?>">
                    <td class="td-id">#<?= str_pad($item['id'], 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="td-date"><?= htmlspecialchars($item['date']) ?></td>
                    <td class="td-ref" style="color:var(--blue)">REQ-<?= htmlspecialchars($item['req_id']) ?></td>
                    <td class="td-ref"><?= htmlspecialchars($item['resource_id']) ?></td>
                    <td><?= htmlspecialchars($item['volunteer_id']) ?></td>
                    <td class="td-ref"><?= htmlspecialchars($item['affected_people_id']) ?></td>
                    <td><div class="td-desc" title="<?= htmlspecialchars($item['description']) ?>"><?= htmlspecialchars($item['description']) ?></div></td>
                    <td class="status-cell"><?= htmlspecialchars($item['status']) ?></td>
                    <td>
                        <select class="status-select" onchange="updateStatus(<?= $item['id'] ?>, this)">
                            <option value="Allocated" <?= $item['status'] == 'Allocated' ? 'selected' : '' ?>>Allocated</option>
                            <option value="Received"  <?= $item['status'] == 'Received'  ? 'selected' : '' ?>>Received</option>
                            
                            <option value="Rejected"  <?= $item['status'] == 'Rejected'  ? 'selected' : '' ?>>Rejected</option>
                        </select>
                    </td>
                    
                </tr>
                <//?php endif; ?></tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- TABLE 2 — RECEIVED -->
<div class="table-card">
    <div class="table-head-row">
        <span class="table-head-label">// RECEIVED RECORDS</span>
        <span class="record-count" id="record-count-2"></span>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DATE</th>
                    <th>REQ ID</th>
                    <th>RESOURCE</th>
                    <th>VOLUNTEER</th>
                    <th>AFFECTED PEOPLE</th>
                    <th>DESCRIPTION</th>
                    <th>STATUS</th>
                    <th>CHANGE STATUS</th>
                    
                </tr>
            </thead>
            <tbody id="table-body-2">
                <?php foreach($result as $item): ?>
                    <?php if($item['status'] == 'Received'): ?>
                    <tr data-status="<?= htmlspecialchars($item['status']) ?>"
                        data-search="<?= strtolower(htmlspecialchars($item['description'] . ' ' . $item['volunteer_id'])) ?>">
                        <td class="td-id">#<?= str_pad($item['id'], 4, '0', STR_PAD_LEFT) ?></td>
                        <td class="td-date"><?= htmlspecialchars($item['date']) ?></td>
                        <td class="td-ref" style="color:var(--blue)">REQ-<?= htmlspecialchars($item['req_id']) ?></td>
                        <td class="td-ref"><?= htmlspecialchars($item['resource_id']) ?></td>
                        <td><?= htmlspecialchars($item['volunteer_id']) ?></td>
                        <td class="td-ref"><?= htmlspecialchars($item['affected_people_id']) ?></td>
                        <td><div class="td-desc" title="<?= htmlspecialchars($item['description']) ?>"><?= htmlspecialchars($item['description']) ?></div></td>
                        <td class="status-cell"><?= htmlspecialchars($item['status']) ?></td>
                        <td>
                            <select class="status-select" onchange="updateStatus(<?= $item['id'] ?>, this)">
                                <option value="Allocated" <?= $item['status'] == 'Allocated' ? 'selected' : '' ?>>Allocated</option>
                                <option value="Received"  <?= $item['status'] == 'Received'  ? 'selected' : '' ?>>Received</option>
                                
                                <option value="Rejected"  <?= $item['status'] == 'Rejected'  ? 'selected' : '' ?>>Rejected</option>
                            </select>
                        </td>
                        
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- TABLE 3 — REJECTED -->
<div class="table-card">
    <div class="table-head-row">
        <span class="table-head-label">// REJECTED RECORDS</span>
        <span class="record-count" id="record-count-3"></span>
    </div>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DATE</th>
                    <th>REQ ID</th>
                    <th>RESOURCE</th>
                    <th>VOLUNTEER</th>
                    <th>AFFECTED PEOPLE</th>
                    <th>DESCRIPTION</th>
                    <th>STATUS</th>
                    <th>CHANGE STATUS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody id="table-body-3">
                <?php foreach($result as $item): ?>
                    <?php if($item['status'] == 'Rejected'): ?>
                    <tr data-status="<?= htmlspecialchars($item['status']) ?>"
                        data-search="<?= strtolower(htmlspecialchars($item['description'] . ' ' . $item['volunteer_id'])) ?>">
                        <td class="td-id">#<?= str_pad($item['id'], 4, '0', STR_PAD_LEFT) ?></td>
                        <td class="td-date"><?= htmlspecialchars($item['date']) ?></td>
                        <td class="td-ref" style="color:var(--blue)">REQ-<?= htmlspecialchars($item['req_id']) ?></td>
                        <td class="td-ref"><?= htmlspecialchars($item['resource_id']) ?></td>
                        <td><?= htmlspecialchars($item['volunteer_id']) ?></td>
                        <td class="td-ref"><?= htmlspecialchars($item['affected_people_id']) ?></td>
                        <td><div class="td-desc" title="<?= htmlspecialchars($item['description']) ?>"><?= htmlspecialchars($item['description']) ?></div></td>
                        <td class="status-cell"><?= htmlspecialchars($item['status']) ?></td>
                        <td>
                            <select class="status-select" onchange="updateStatus(<?= $item['id'] ?>, this)">
                                <option value="Allocated" <?= $item['status'] == 'Allocated' ? 'selected' : '' ?>>Allocated</option>
                                <option value="Received"  <?= $item['status'] == 'Received'  ? 'selected' : '' ?>>Received</option>
                                
                                <option value="Rejected"  <?= $item['status'] == 'Rejected'  ? 'selected' : '' ?>>Rejected</option>
                            </select>
                        </td>
                        <td>
                            <div class="action-btns">
                                <button class="act-btn" title="View">👁</button>
                                <button class="act-btn" title="Edit">✏️</button>
                                <button class="act-btn danger" title="Delete">🗑</button>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- TOAST -->
<div id="toast"><span id="toast-msg"></span></div>

<script>
// ── TABLE ROUTING MAP ──────────────────────────────────────
// Defines which tbody each status belongs to.
// Table 1 = all other statuses (Assigned, Allocated, Pending)
// Table 2 = Received
// Table 3 = Rejected
const STATUS_TABLE_MAP = {
    'Assigned':  'table-body-1',
    'Allocated': 'table-body-1',
    'Pending':   'table-body-1',
    'Received':  'table-body-2',
    'Rejected':  'table-body-3',
};

// ── STATUS UPDATE ──────────────────────────────────────────
function updateStatus(id, select) {
    const newStatus = select.value;

    const formData = new FormData();
    formData.append('action', 'update_status');
    formData.append('id', id);
    formData.append('status', newStatus);

    fetch(window.location.href, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const row = select.closest('tr');

                // 1. Update the visible status text cell
                row.querySelector('.status-cell').textContent = newStatus;
                row.dataset.status = newStatus;

                // 2. Work out which tbody this row should live in
                const targetBodyId = STATUS_TABLE_MAP[newStatus] || 'table-body-1';
                const currentBody  = row.closest('tbody');

                // 3. Only move if it's going to a different table
                if (currentBody.id !== targetBodyId) {
                    const targetBody = document.getElementById(targetBodyId);

                    // Animate out
                    row.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                    row.style.opacity    = '0';
                    row.style.transform  = 'translateX(16px)';

                    setTimeout(() => {
                        // Move the row
                        targetBody.appendChild(row);

                        // Sync the dropdown selection value in the new location
                        const newSelect = row.querySelector('.status-select');
                        newSelect.value = newStatus;

                        // Animate in
                        row.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                        row.style.opacity    = '0';
                        row.style.transform  = 'translateX(-16px)';

                        requestAnimationFrame(() => {
                            requestAnimationFrame(() => {
                                row.style.opacity   = '1';
                                row.style.transform = 'translateX(0)';
                            });
                        });

                        updateCounts();
                    }, 260);
                }

                showToast('✅ Status updated to ' + newStatus);
                updateCounts();
            } else {
                showToast('❌ Failed to update status');
            }
        })
        .catch(() => showToast('❌ Connection error'));
}

// ── SEARCH & FILTER ────────────────────────────────────────
function filterTable() {
    const query  = document.getElementById('search-input').value.toLowerCase();
    const status = document.getElementById('status-filter').value;

    // Filter across ALL three tables
    const rows = document.querySelectorAll('#table-body-1 tr, #table-body-2 tr, #table-body-3 tr');
    let visible = 0;

    rows.forEach(row => {
        const matchSearch = !query  || (row.dataset.search || '').includes(query);
        const matchStatus = !status || row.dataset.status === status;
        const show = matchSearch && matchStatus;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    document.getElementById('record-count-1').textContent = `Showing ${visible} records`;
}

// ── RECORD COUNTS ──────────────────────────────────────────
function updateCounts() {
    const c1 = document.querySelectorAll('#table-body-1 tr').length;
    const c2 = document.querySelectorAll('#table-body-2 tr').length;
    const c3 = document.querySelectorAll('#table-body-3 tr').length;
    document.getElementById('record-count-1').textContent = `${c1} record${c1 !== 1 ? 's' : ''}`;
    document.getElementById('record-count-2').textContent = `${c2} record${c2 !== 1 ? 's' : ''}`;
    document.getElementById('record-count-3').textContent = `${c3} record${c3 !== 1 ? 's' : ''}`;
}

// ── TOAST ──────────────────────────────────────────────────
function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toast-msg').textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2800);
}

// Init
filterTable();
updateCounts();
</script>
</body>
</html>