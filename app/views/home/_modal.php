<!-- MODAL OVERLAY -->
<div id="modal-overlay">
  <div id="modal-box">
    <button class="modal-close" onclick="closeModal()" aria-label="Close modal">✕</button>
    <div id="modal-content"></div>
  </div>
</div>

<?php
// Pass emergency contacts to JS as a JSON object so the modal can render them
$contactsJson = json_encode($emergencyContacts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
?>
<script>
  window.DRCS_EMERGENCY_CONTACTS = <?= $contactsJson ?>;
</script>
