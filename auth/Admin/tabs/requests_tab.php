<!-- REQUESTS TAB -->
<div id="requestsTab" class="tab-content">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <div class="section-header">
    <h2><i class="fa-solid fa-check-to-slot"></i> All Help Requests</h2>
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
        <?php
          define('VIEW_REQUEST_EMBEDDED', true);
          include __DIR__ . '/../view_request.php';
        ?>
      </tbody>
    </table>
  </div>
</div>