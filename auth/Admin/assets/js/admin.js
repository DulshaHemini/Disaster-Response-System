/**
 * DRCS Admin · Command Center
 * Main JavaScript for admin dashboard functionality
 * Handles tab switching, request filtering, and AJAX actions.
 */

/* ═══════════════════════════════════════════════════════════════════════════
   TOAST NOTIFICATIONS
   ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Display a toast notification message
 * @param {string} msg - Message to display
 */
function showToast(msg) {
  const toast = document.getElementById('toastMsg');
  toast.innerText = msg;
  toast.style.opacity = '1';
  setTimeout(() => { 
    toast.style.opacity = '0'; 
  }, 2500);
}

/* ═══════════════════════════════════════════════════════════════════════════
   TAB SWITCHING
   ═══════════════════════════════════════════════════════════════════════════ */

const tabs = document.querySelectorAll('.tab-btn');

tabs.forEach(btn => {
  btn.addEventListener('click', () => {
    const targetTab = btn.dataset.tab;
    
    // Remove active class from all tabs and buttons
    tabs.forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => {
      content.classList.remove('active-tab');
    });
    
    // Add active class to clicked button and corresponding tab
    btn.classList.add('active');
    const tabMap = {
      'users': 'usersTab',
      'requests': 'requestsTab',
      'instantHelp': 'instantHelpTab',
      'assign': 'assignTab',
      'resources': 'resourcesTab',
      'locations': 'locationsTab',
      'volunteers': 'volunteersTab'
    };
    const tabId = tabMap[targetTab];
    if (tabId) {
      document.getElementById(tabId).classList.add('active-tab');
    }
  });
});

/* ═══════════════════════════════════════════════════════════════════════════
   REQUEST STATUS FILTER
   ═══════════════════════════════════════════════════════════════════════════ */

const filterRequestStatus = document.getElementById('filterRequestStatus');
if (filterRequestStatus) {
  filterRequestStatus.addEventListener('change', function () {
    const filter = this.value;
    document.querySelectorAll('#requestsTableBody tr').forEach(row => {
      row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
    });
  });
}

/* ═══════════════════════════════════════════════════════════════════════════
   USER MANAGEMENT
   ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Delete a user from the system
 * @param {number} userId - User ID to delete
 * @param {string} username - Username for confirmation message
 */
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

/* ═══════════════════════════════════════════════════════════════════════════
   REQUEST STATUS MANAGEMENT
   ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Update the status of a request
 * @param {number} reqId - Request ID
 * @param {string} newStatus - New status value
 * @param {HTMLElement} selectEl - Select element that triggered the change
 */
function updateRequestStatus(reqId, newStatus, selectEl) {
  fetch('admin.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `action=update_request_status&req_id=${encodeURIComponent(reqId)}&status=${encodeURIComponent(newStatus)}`
  })
  .then(r => r.json())
  .then(data => {
    if (data.ok) {
      const row = selectEl.closest('tr');
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

/* ═══════════════════════════════════════════════════════════════════════════
   VOLUNTEER ASSIGNMENT
   ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Assign a volunteer to a request
 * @param {number} reqId - Request ID
 */
function confirmAssign(reqId) {
  const select = document.getElementById(`assignSelect_${reqId}`);
  const volId  = select.value;
  if (!volId) { 
    showToast('Select a volunteer first'); 
    return; 
  }

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
