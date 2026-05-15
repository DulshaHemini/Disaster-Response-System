<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Assignments – DRCS</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="stylesheet" href="../../assets/css/tracker.css">
    <link rel="stylesheet" href="../../assets/css/ticker.css">
    <link rel="stylesheet" href="../../assets/css/request.css">
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
    </select>
</div>
 
<!-- TABLE -->
<div class="table-card">
    <div class="table-head-row">
        <span class="table-head-label">// ASSIGNMENT RECORDS</span>
        <span class="record-count" id="record-count"></span>
    </div>
 
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
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <?php foreach($result as $item): ?>
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
 
                <!-- CHANGE STATUS -->
                <td>
                    <select class="status-select" onchange="updateStatus(<?= $item['id'] ?>, this)">
                        <option value="Assigned"  <?= $item['status'] == 'Assigned'  ? 'selected' : '' ?>>Assigned</option>
                        <option value="Allocated" <?= $item['status'] == 'Allocated' ? 'selected' : '' ?>>Allocated</option>
                        <option value="Received"  <?= $item['status'] == 'Received'  ? 'selected' : '' ?>>Received</option>
                        <option value="Pending"   <?= $item['status'] == 'Pending'   ? 'selected' : '' ?>>Pending</option>
                        <option value="Pending"   <?= $item['status'] == 'Rejected'   ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </td>
 
                <!-- ACTIONS -->
                <td>
                    <div class="action-btns">
                        <button class="act-btn" title="View">👁</button>
                        <button class="act-btn" title="Edit">✏️</button>
                        <button class="act-btn danger" title="Delete">🗑</button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
 
<!-- TOAST -->
<div id="toast"><span id="toast-msg"></span></div>
 
<script>
// ── STATUS UPDATE ───────────────────────────────────── ─
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
              // update the status text cell in same row
              const row = select.closest('tr');
              row.querySelector('.status-cell').textContent = newStatus;
              row.dataset.status = newStatus;
              showToast('✅ Status updated to ' + newStatus);
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
    const rows   = document.querySelectorAll('#table-body tr');
    let visible  = 0;
 
    rows.forEach(row => {
        const matchSearch = !query  || row.dataset.search.includes(query);
        const matchStatus = !status || row.dataset.status === status;
        const show = matchSearch && matchStatus;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
 
    document.getElementById('record-count').textContlsent = `Showing ${visible} records`;
}
 
// ── TOAST ──────────────────────────────────────────────────
function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toast-msg').textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2800);
}
 
// init record count
filterTable();
</script>
</body>
</html>