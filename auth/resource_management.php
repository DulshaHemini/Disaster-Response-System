<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resource Inventory – GovResponse</title>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg: #f4f6f9;
    --surface: #ffffff;
    --border: #e2e6ea;
    --text: #1a1d23;
    --muted: #6b7280;
    --accent: #1e3a5f;
    --accent-light: #e8eef5;
    --green-bg: #eaf7f0; --green: #1a7a4a;
    --amber-bg: #fff8e6; --amber: #a05a00;
    --red-bg: #fdf0f0; --red: #c0392b;
    --blue-bg: #e8eef5; --blue: #1e3a5f;
    --radius: 8px;
    --shadow: 0 1px 3px rgba(0,0,0,0.08);
  }

  body {
    font-family: 'Segoe UI', system-ui, sans-serif;
    background: var(--bg);
    color: var(--text);
    font-size: 14px;
    min-height: 100vh;
  }

  /* NAV */
  nav {
    background: var(--accent);
    padding: 0 24px;
    display: flex;
    align-items: center;
    height: 52px;
    gap: 8px;
  }
  .nav-logo { color: #fff; font-size: 15px; font-weight: 600; letter-spacing: 0.3px; }
  .nav-logo span { opacity: 0.6; font-weight: 400; }
  .nav-links { margin-left: auto; display: flex; gap: 4px; }
  .nav-links a {
    color: rgba(255,255,255,0.7); text-decoration: none;
    padding: 6px 12px; border-radius: 6px; font-size: 13px;
    transition: background 0.15s;
  }
  .nav-links a:hover { background: rgba(255,255,255,0.1); color: #fff; }
  .nav-links a.active { background: rgba(255,255,255,0.15); color: #fff; }
  .nav-user {
    margin-left: 16px; color: rgba(255,255,255,0.9);
    font-size: 13px; display: flex; align-items: center; gap: 8px;
  }
  .avatar {
    width: 30px; height: 30px; border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 600; color: #fff;
  }

  /* LAYOUT */
  .wrapper { max-width: 1100px; margin: 0 auto; padding: 28px 24px; }

  /* PAGE HEADER */
  .page-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; margin-bottom: 24px;
  }
  .page-header h1 { font-size: 20px; font-weight: 600; color: var(--text); }
  .page-header p { color: var(--muted); font-size: 13px; margin-top: 2px; }

  .btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: var(--radius);
    border: 1px solid var(--border);
    background: var(--surface); color: var(--text);
    font-size: 13px; font-weight: 500; cursor: pointer;
    transition: all 0.15s; text-decoration: none;
  }
  .btn:hover { background: var(--bg); }
  .btn-primary {
    background: var(--accent); color: #fff; border-color: var(--accent);
  }
  .btn-primary:hover { background: #162d4a; }
  .btn svg { width: 15px; height: 15px; stroke: currentColor; }

  /* STAT CARDS */
  .stats { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 24px; }
  .stat-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 16px 18px;
    box-shadow: var(--shadow);
  }
  .stat-card .label { font-size: 12px; color: var(--muted); margin-bottom: 6px; }
  .stat-card .value { font-size: 26px; font-weight: 600; line-height: 1; }
  .stat-card .sub { font-size: 11px; color: var(--muted); margin-top: 4px; }
  .stat-card.green .value { color: var(--green); }
  .stat-card.amber .value { color: var(--amber); }
  .stat-card.red .value { color: var(--red); }

  /* TABLE CARD */
  .table-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;
  }
  .table-top {
    padding: 14px 20px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
  }
  .table-top-left { display: flex; align-items: center; gap: 12px; }
  .table-top h2 { font-size: 14px; font-weight: 600; }

  .search-box {
    display: flex; align-items: center; gap: 8px;
    padding: 6px 12px; border: 1px solid var(--border);
    border-radius: var(--radius); background: var(--bg);
    font-size: 13px; color: var(--muted); width: 220px;
  }
  .search-box input {
    border: none; background: transparent; outline: none;
    font-size: 13px; color: var(--text); width: 100%;
  }
  .search-box svg { width: 14px; height: 14px; flex-shrink: 0; }

  .filter-select {
    padding: 6px 10px; border: 1px solid var(--border);
    border-radius: var(--radius); background: var(--bg);
    font-size: 13px; color: var(--text); cursor: pointer; outline: none;
  }
  .type-manager {
    display: flex; gap: 8px; margin-top: 8px; flex-wrap: wrap;
    align-items: center;
  }
  .type-manager .btn {
    white-space: nowrap;
  }
  .type-list {
    display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px;
  }
  .type-list .type-pill {
    padding: 5px 10px; border-radius: 999px; background: #eef2f7;
    color: var(--text); font-size: 12px; gap: 6px;
  }
  .type-list .type-pill .icon-btn {
    width: 22px; height: 22px; border-radius: 50%; border-color: transparent;
    color: var(--muted); font-size: 12px; padding: 0; min-width: 22px;
  }
  .type-list .type-pill .icon-btn:hover {
    background: rgba(0,0,0,0.04); color: var(--text);
  }

  table { width: 100%; border-collapse: collapse; }
  thead th {
    padding: 10px 16px; text-align: left;
    font-size: 11px; font-weight: 600; letter-spacing: 0.5px;
    color: var(--muted); text-transform: uppercase;
    background: #f8f9fb; border-bottom: 1px solid var(--border);
  }
  tbody td {
    padding: 12px 16px; border-bottom: 1px solid var(--border);
    vertical-align: middle;
  }
  tbody tr:last-child td { border-bottom: none; }
  tbody tr:hover td { background: #fafbfc; }

  .res-name { font-weight: 500; color: var(--text); }
  .res-updated { font-size: 11px; color: var(--muted); margin-top: 2px; }

  .type-pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px; border-radius: 20px;
    font-size: 11px; font-weight: 500;
  }
  .type-pill .dot { width: 6px; height: 6px; border-radius: 50%; }
  .type-food { background: var(--green-bg); color: var(--green); }
  .type-food .dot { background: var(--green); }
  .type-medicine { background: #fdf0f7; color: #8e2b6a; }
  .type-medicine .dot { background: #8e2b6a; }
  .type-shelter { background: var(--blue-bg); color: var(--blue); }
  .type-shelter .dot { background: var(--blue); }
  .type-transport { background: var(--amber-bg); color: var(--amber); }
  .type-transport .dot { background: var(--amber); }

  .badge {
    display: inline-block; padding: 3px 10px;
    border-radius: 20px; font-size: 11px; font-weight: 500;
  }
  .badge-ok { background: var(--green-bg); color: var(--green); }
  .badge-low { background: var(--amber-bg); color: var(--amber); }
  .badge-out { background: var(--red-bg); color: var(--red); }

  .qty-cell { font-size: 15px; font-weight: 600; color: var(--text); }

  .action-btns { display: flex; gap: 6px; }
  .icon-btn {
    width: 30px; height: 30px; border-radius: 6px;
    border: 1px solid var(--border); background: transparent;
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--muted); transition: all 0.15s;
  }
  .icon-btn svg { width: 14px; height: 14px; }
  .icon-btn:hover { background: var(--bg); color: var(--text); }
  .icon-btn.del:hover { background: var(--red-bg); color: var(--red); border-color: #f5c6c6; }

  /* MODAL */
  .modal-backdrop {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.35); z-index: 100;
    align-items: center; justify-content: center;
  }
  .modal-backdrop.open { display: flex; }
  .modal {
    background: var(--surface); border-radius: 10px;
    width: 420px; box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    overflow: hidden;
  }
  .modal-header {
    padding: 16px 20px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
  }
  .modal-header h3 { font-size: 15px; font-weight: 600; }
  .modal-close {
    width: 28px; height: 28px; border-radius: 6px;
    border: none; background: transparent; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--muted);
  }
  .modal-close:hover { background: var(--bg); }
  .modal-body { padding: 20px; }
  .modal-footer {
    padding: 14px 20px; border-top: 1px solid var(--border);
    display: flex; gap: 8px; justify-content: flex-end;
  }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .form-group { margin-bottom: 14px; }
  .form-group label {
    display: block; font-size: 12px; font-weight: 500;
    color: var(--muted); margin-bottom: 5px;
  }
  .form-group input, .form-group select, .form-group textarea {
    width: 100%; padding: 8px 10px;
    border: 1px solid var(--border); border-radius: 6px;
    font-size: 13px; color: var(--text);
    background: var(--bg); outline: none; transition: border 0.15s;
    font-family: inherit;
  }
  .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
    border-color: var(--accent); background: var(--surface);
  }
  .form-group textarea { resize: none; height: 70px; }

  /* ALERT */
  .alert-bar {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 16px; background: var(--red-bg);
    border: 1px solid #f5c6c6; border-radius: var(--radius);
    margin-bottom: 20px; font-size: 13px; color: var(--red);
  }
  .alert-bar svg { width: 16px; height: 16px; flex-shrink: 0; }

  /* EMPTY STATE */
  .empty-row td {
    text-align: center; padding: 40px;
    color: var(--muted); font-size: 13px;
  }

  /* TOAST */
  .toast {
    position: fixed; bottom: 24px; right: 24px;
    background: #1a1d23; color: #fff;
    padding: 10px 18px; border-radius: 8px;
    font-size: 13px; opacity: 0; transform: translateY(8px);
    transition: all 0.25s; pointer-events: none; z-index: 200;
  }
  .toast.show { opacity: 1; transform: translateY(0); }
</style>
</head>
<body>

<nav>
  <span class="nav-logo">GovResponse <span>· Volunteer Portal</span></span>
  <div class="nav-links">
    <a href="#">Dashboard</a>
    <a href="#" class="active">Resources</a>
    <a href="#">My Tasks</a>
  </div>
  <div class="nav-user">
    <div class="avatar">PS</div>
    Praveen S.
  </div>
</nav>

<div class="wrapper">

  <div class="page-header">
    <div>
      <h1>Resource Inventory</h1>
      <p>Manage your volunteer-supplied resources for active relief operations</p>
    </div>
    <button class="btn btn-primary" onclick="openModal()">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add Resource
    </button>
  </div>

  <div id="alertBar" class="alert-bar" style="display:none;">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
      <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
    </svg>
    <span id="alertText"></span>
  </div>

  <div class="stats">
    <div class="stat-card">
      <div class="label">Total Items</div>
      <div class="value" id="stat-total">0</div>
      <div class="sub">resources registered</div>
    </div>
    <div class="stat-card green">
      <div class="label">Stocked</div>
      <div class="value" id="stat-ok">0</div>
      <div class="sub">sufficient supply</div>
    </div>
    <div class="stat-card amber">
      <div class="label">Running Low</div>
      <div class="value" id="stat-low">0</div>
      <div class="sub">need restocking</div>
    </div>
    <div class="stat-card red">
      <div class="label">Out of Stock</div>
      <div class="value" id="stat-out">0</div>
      <div class="sub">critical — restock now</div>
    </div>
  </div>

  <div class="table-card">
    <div class="table-top">
      <div class="table-top-left">
        <h2>All Resources</h2>
        <div class="search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
          <input type="text" id="searchInput" placeholder="Search resources…" oninput="renderTable()">
        </div>
        <div>
          <select class="filter-select" id="typeFilter" onchange="renderTable()">
            <option value="">All Types</option>
          </select>
          <div class="type-manager">
            <input id="newTypeInput" class="filter-select" placeholder="New type">
            <button class="btn" onclick="addType()">Add Type</button>
          </div>
          <div class="type-list" id="typeList"></div>
        </div>
      </div>
      <select class="filter-select" id="statusFilter" onchange="renderTable()">
        <option value="">All Status</option>
        <option>Stocked</option>
        <option>Running Low</option>
        <option>Out of Stock</option>
      </select>
    </div>
    <table>
      <thead>
        <tr>
          <th>Resource</th>
          <th>Type</th>
          <th>Quantity</th>
          <th>Unit</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="tableBody"></tbody>
    </table>
  </div>

</div>

<!-- ADD / EDIT MODAL -->
<div class="modal-backdrop" id="modalBackdrop" onclick="handleBackdropClick(event)">
  <div class="modal">
    <div class="modal-header">
      <h3 id="modalTitle">Add New Resource</h3>
      <button class="modal-close" onclick="closeModal()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="editId">
      <div class="form-group">
        <label>Resource Name *</label>
        <input type="text" id="fName" placeholder="e.g. Rice packets">
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Type *</label>
          <select id="fType">
            <option value="">Select type…</option>
          </select>
        </div>
        <div class="form-group">
          <label>Unit *</label>
          <input type="text" id="fUnit" placeholder="e.g. packets, kits">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Quantity *</label>
          <input type="number" id="fQty" placeholder="0" min="0">
        </div>
        <div class="form-group">
          <label>Max Capacity</label>
          <input type="number" id="fMax" placeholder="e.g. 150" min="1">
        </div>
      </div>
      <div class="form-group" style="margin-bottom:0">
        <label>Notes (optional)</label>
        <textarea id="fNotes" placeholder="Storage location, expiry date, etc."></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" onclick="closeModal()">Cancel</button>
      <button class="btn btn-primary" onclick="saveResource()">Save Resource</button>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
let resources = [
  { id:1, name:'Rice packets',       type:'Food',      qty:120, max:150, unit:'packets',  notes:'Stored in Warehouse B', updated:'Today, 09:00 AM' },
  { id:2, name:'Emergency med kits', type:'Medicine',  qty:8,   max:30,  unit:'kits',     notes:'Check expiry monthly',  updated:'Yesterday' },
  { id:3, name:'Folding beds',        type:'Shelter',   qty:35,  max:50,  unit:'units',    notes:'',                      updated:'2 days ago' },
  { id:4, name:'Potable water',       type:'Food',      qty:0,   max:200, unit:'bottles',  notes:'Urgent restock needed', updated:'Today, 08:00 AM' },
  { id:5, name:'Blankets',            type:'Shelter',   qty:62,  max:100, unit:'units',    notes:'',                      updated:'3 days ago' },
  { id:6, name:'ORS sachets',         type:'Medicine',  qty:5,   max:50,  unit:'sachets',  notes:'',                      updated:'Yesterday' },
];
let nextId = 7;
let resourceTypes = ['Food', 'Medicine', 'Shelter', 'Transport'];

function getStatus(qty, max) {
  const pct = max ? qty / max : 1;
  if (qty === 0) return 'Out of Stock';
  if (pct < 0.25) return 'Running Low';
  return 'Stocked';
}

function badgeHTML(status) {
  const cls = status === 'Stocked' ? 'badge-ok' : status === 'Running Low' ? 'badge-low' : 'badge-out';
  return `<span class="badge ${cls}">${status}</span>`;
}

function typeHTML(type) {
  const cls = {
    Food:'type-food', Medicine:'type-medicine', Shelter:'type-shelter', Transport:'type-transport'
  }[type] || '';
  return `<span class="type-pill ${cls}"><span class="dot"></span>${type}</span>`;
}

function renderTypeOptions(selectId, includeAll) {
  const select = document.getElementById(selectId);
  const current = select.value;
  select.innerHTML = includeAll
    ? '<option value="">All Types</option>'
    : '<option value="">Select type…</option>';
  resourceTypes.forEach(type => {
    select.insertAdjacentHTML('beforeend', `<option>${type}</option>`);
  });
  if (resourceTypes.includes(current)) select.value = current;
}

function renderTypeManager() {
  renderTypeOptions('typeFilter', true);
  renderTypeOptions('fType', false);
  document.getElementById('typeList').innerHTML = resourceTypes.map(type =>
    `<span class="type-pill">
       ${type}
       <button class="icon-btn del" title="Delete type" onclick="deleteType('${type}')">×</button>
     </span>`
  ).join('');
}

function addType() {
  const input = document.getElementById('newTypeInput');
  const value = input.value.trim();
  if (!value) { showToast('Enter a type name.'); return; }
  const exists = resourceTypes.some(t => t.toLowerCase() === value.toLowerCase());
  if (exists) { showToast('This type already exists.'); return; }
  resourceTypes.push(value);
  input.value = '';
  renderTypeManager();
  showToast('Type added.');
}

function deleteType(type) {
  if (resources.some(r => r.type === type)) {
    showToast('Cannot delete type while resources use it.');
    return;
  }
  if (!confirm(`Delete type ${type}?`)) return;
  resourceTypes = resourceTypes.filter(t => t !== type);
  renderTypeManager();
  renderTable();
  showToast('Type deleted.');
}

function renderTable() {
  const search = document.getElementById('searchInput').value.toLowerCase();
  const typeF = document.getElementById('typeFilter').value;
  const statusF = document.getElementById('statusFilter').value;

  const filtered = resources.filter(r => {
    const status = getStatus(r.qty, r.max);
    return (!search || r.name.toLowerCase().includes(search) || r.type.toLowerCase().includes(search))
      && (!typeF || r.type === typeF)
      && (!statusF || status === statusF);
  });

  const tbody = document.getElementById('tableBody');
  if (filtered.length === 0) {
    tbody.innerHTML = `<tr class="empty-row"><td colspan="6">No resources found.</td></tr>`;
  } else {
    tbody.innerHTML = filtered.map(r => {
      const status = getStatus(r.qty, r.max);
      return `<tr>
        <td><div class="res-name">${r.name}</div><div class="res-updated">Updated: ${r.updated}</div></td>
        <td>${typeHTML(r.type)}</td>
        <td><span class="qty-cell">${r.qty}</span></td>
        <td>${r.unit}</td>
        <td>${badgeHTML(status)}</td>
        <td>
          <div class="action-btns">
            <button class="icon-btn" title="Edit" onclick="editResource(${r.id})">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </button>
            <button class="icon-btn del" title="Delete" onclick="deleteResource(${r.id})">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
            </button>
          </div>
        </td>
      </tr>`;
    }).join('');
  }

  updateStats();
  updateAlert();
}

function updateStats() {
  document.getElementById('stat-total').textContent = resources.length;
  document.getElementById('stat-ok').textContent  = resources.filter(r => getStatus(r.qty,r.max) === 'Stocked').length;
  document.getElementById('stat-low').textContent = resources.filter(r => getStatus(r.qty,r.max) === 'Running Low').length;
  document.getElementById('stat-out').textContent = resources.filter(r => getStatus(r.qty,r.max) === 'Out of Stock').length;
}

function updateAlert() {
  const problems = resources.filter(r => getStatus(r.qty,r.max) !== 'Stocked');
  const bar = document.getElementById('alertBar');
  if (problems.length > 0) {
    document.getElementById('alertText').textContent =
      `${problems.length} resource(s) need attention: ${problems.map(r=>r.name).join(', ')}.`;
    bar.style.display = 'flex';
  } else {
    bar.style.display = 'none';
  }
}

function openModal(clear=true) {
  if (clear) {
    document.getElementById('modalTitle').textContent = 'Add New Resource';
    document.getElementById('editId').value = '';
    ['fName','fUnit','fNotes'].forEach(id => document.getElementById(id).value = '');
    ['fType'].forEach(id => document.getElementById(id).value = '');
    ['fQty','fMax'].forEach(id => document.getElementById(id).value = '');
  }
  document.getElementById('modalBackdrop').classList.add('open');
}

function closeModal() {
  document.getElementById('modalBackdrop').classList.remove('open');
}

function handleBackdropClick(e) {
  if (e.target === document.getElementById('modalBackdrop')) closeModal();
}

function editResource(id) {
  const r = resources.find(x => x.id === id);
  if (!r) return;
  document.getElementById('modalTitle').textContent = 'Edit Resource';
  document.getElementById('editId').value = r.id;
  document.getElementById('fName').value = r.name;
  document.getElementById('fType').value = r.type;
  document.getElementById('fUnit').value = r.unit;
  document.getElementById('fQty').value  = r.qty;
  document.getElementById('fMax').value  = r.max;
  document.getElementById('fNotes').value = r.notes;
  openModal(false);
}

function saveResource() {
  const name = document.getElementById('fName').value.trim();
  const type = document.getElementById('fType').value;
  const unit = document.getElementById('fUnit').value.trim();
  const qty  = parseInt(document.getElementById('fQty').value) || 0;
  const max  = parseInt(document.getElementById('fMax').value) || 100;
  const notes = document.getElementById('fNotes').value.trim();

  if (!name || !type || !unit) { showToast('Please fill all required fields.'); return; }

  const editId = parseInt(document.getElementById('editId').value);
  if (editId) {
    const idx = resources.findIndex(r => r.id === editId);
    resources[idx] = { ...resources[idx], name, type, unit, qty, max, notes, updated: 'Just now' };
    showToast('Resource updated.');
  } else {
    resources.push({ id: nextId++, name, type, unit, qty, max, notes, updated: 'Just now' });
    showToast('Resource added.');
  }
  closeModal();
  renderTable();
}

function deleteResource(id) {
  if (!confirm('Delete this resource?')) return;
  resources = resources.filter(r => r.id !== id);
  renderTable();
  showToast('Resource deleted.');
}

function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 2500);
}

renderTypeManager();
renderTable();
</script>
</body>
</html>
