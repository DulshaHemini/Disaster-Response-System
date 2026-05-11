/**
 * DRCS Admin · Command Center
 * Handles tab switching, request filtering, and AJAX actions.
 */

// ── Toast ────────────────────────────────────────────────────────────────────
function showToast(msg) {
  const toast = document.getElementById('toastMsg');
  toast.innerText = msg;
  toast.style.opacity = '1';
  setTimeout(() => { toast.style.opacity = '0'; }, 2500);
}

// ── Tab switching ────────────────────────────────────────────────────────────
const tabs   = document.querySelectorAll('.tab-btn');
const tabIds = ['usersTab', 'requestsTab', 'assignTab'];

tabs.forEach((btn, idx) => {
  btn.addEventListener('click', () => {
    tabs.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    tabIds.forEach(id => document.getElementById(id).classList.remove('active-tab'));
    document.getElementById(tabIds[idx]).classList.add('active-tab');
  });
});

// ── Request status filter ────────────────────────────────────────────────────
document.getElementById('filterRequestStatus').addEventListener('change', function () {
  const filter = this.value;
  document.querySelectorAll('#requestsTableBody tr').forEach(row => {
    row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
  });
});

// ── Delete user ──────────────────────────────────────────────────────────────
function deleteUser(userId, username) {
  if (!confirm(`Remove user "${username}"?`)) return;

  fetch('admin.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=delete_user&user_id=${encodeURIComponent(userId)}`
  })
  .then(r => r.json())
  .then(data => {
    if (data.ok) {
      document.getElementById(`user-row-${userId}`)?.remove();
      showToast(`User "${username}" removed`);
    } else {
      showToast('Error deleting user');
    }
  })
  .catch(() => showToast('Network error'));
}

// ── Update request status ────────────────────────────────────────────────────
function updateRequestStatus(reqId, newStatus, selectEl) {
  fetch('admin.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=update_request_status&req_id=${encodeURIComponent(reqId)}&status=${encodeURIComponent(newStatus)}`
  })
  .then(r => r.json())
  .then(data => {
    if (data.ok) {
      const row        = selectEl.closest('tr');
      row.dataset.status = newStatus;
      const badgeClass = newStatus === 'pending'     ? 'badge-pending'
                       : newStatus === 'in-progress' ? 'badge-progress'
                       :                               'badge-resolved';
      row.querySelector('.statusCell').innerHTML =
        `<span class="badge ${badgeClass}">${newStatus}</span>`;
      showToast(`Request #${reqId} updated to "${newStatus}"`);
    } else {
      showToast('Error updating status');
    }
  })
  .catch(() => showToast('Network error'));
}

// ── Assign volunteer ─────────────────────────────────────────────────────────
function confirmAssign(reqId) {
  const select = document.getElementById(`assignSelect_${reqId}`);
  const volId  = select.value;
  if (!volId) { showToast('Select a volunteer first'); return; }

  fetch('admin.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=assign_volunteer&req_id=${encodeURIComponent(reqId)}&volunteer_id=${encodeURIComponent(volId)}`
  })
  .then(r => r.json())
  .then(data => {
    if (data.ok) {
      showToast(`Volunteer assigned to request #${reqId}`);
    } else {
      showToast('Error assigning volunteer');
    }
  })
  .catch(() => showToast('Network error'));
}
