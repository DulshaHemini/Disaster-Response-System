// main.js - Main initialization and event handlers

// Keyboard shortcuts
document.addEventListener("keydown", function (e) {
  if (e.key !== "Escape") {
    return;
  }

  var modal = document.getElementById("activity-modal");

  if (!modal || modal.classList.contains("hidden")) {
    closeDetailsPanel();
  } else {
    closeActivityModal();
  }
});

// Initialize on page load
document.addEventListener("DOMContentLoaded", function () {
  initMap();
});
