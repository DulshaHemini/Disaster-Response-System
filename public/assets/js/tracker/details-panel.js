// details-panel.js - Details panel management

let allActivityLogs = [];

// Open details panel
function openDetails(personId) {
  currentPersonId = personId;
  selectPerson(personId);

  // Load person data directly without popup
  loadPersonData(personId);
}

// Load person data
function loadPersonData(personId) {
  // Find person in peopleData
  var person = null;
  for (var i = 0; i < peopleData.length; i++) {
    if (peopleData[i].id == personId) {
      person = peopleData[i];
      break;
    }
  }
  
  if (!person) {
    return;
  }
  
  // For now, use basic person data from peopleData
  // In future, you can load full details from get_person.php via AJAX
  var logs = [];
  var logsCount = 0;
  
  receivePersonData(person, logs, logsCount);
}

// Receive person data from popup
function receivePersonData(person, logs, logsCount) {
  var p = person;

  document.getElementById("detail-avatar").textContent = getInitials(p.full_name);
  document.getElementById("detail-name").textContent = p.full_name;
  document.getElementById("detail-meta").textContent = p.age + " years • " + p.gender + " • " + p.district;

  var badge = document.getElementById("detail-status");
  badge.textContent = p.status.replace("_", " ").toUpperCase();
  badge.className = "status-badge " + p.status;

  var reported = new Date(p.created_at);
  var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  document.getElementById("detail-reported").textContent = months[reported.getMonth()] + " " + reported.getDate();

  var now = new Date();
  var hours = Math.floor((now - reported) / 3600000);
  if (hours < 24) {
    document.getElementById("detail-duration").textContent = hours + "h";
  } else {
    document.getElementById("detail-duration").textContent = Math.floor(hours / 24) + "d";
  }

  updateProgressTracker(p.status);

  document.getElementById("detail-location").textContent = p.location_name;
  document.getElementById("detail-district").textContent = p.district;
  document.getElementById("detail-coords").textContent = p.latitude + ", " + p.longitude;
  
  var disasterType = p.disaster_type.charAt(0).toUpperCase() + p.disaster_type.slice(1);
  document.getElementById("detail-disaster").textContent = disasterType;
  
  // Handle optional fields
  var injuryStatus = p.injury_status ? p.injury_status : "Not specified";
  document.getElementById("detail-injury").textContent = injuryStatus;

  var severity = "Medium";
  if (p.status === "needs_aid") {
    severity = "High";
  } else if (p.status === "rescued" || p.status === "stable") {
    severity = "Low";
  }
  document.getElementById("detail-severity").textContent = severity;

  var familyCount = p.family_count ? p.family_count : 0;
  var familyText = familyCount + " ";
  if (familyCount === 1) {
    familyText = familyText + "member";
  } else {
    familyText = familyText + "members";
  }
  document.getElementById("detail-family").textContent = familyText;
  
  var contact = p.contact ? p.contact : "Not available";
  document.getElementById("detail-contact").textContent = contact;
  document.getElementById("detail-age").textContent = p.age + " years";
  
  var gender = p.gender.charAt(0).toUpperCase() + p.gender.slice(1);
  document.getElementById("detail-gender").textContent = gender;

  // Store logs
  allActivityLogs = logs;
  document.getElementById("detail-updates").textContent = logsCount;

  var container = document.getElementById("detail-activity");

  if (logsCount === 0) {
    container.className = "last-update-card empty";
    container.innerHTML = '<div>📭 No updates available yet</div>';
  } else {
    // Show only the last (most recent) update
    var lastLog = logs[0];
    var icon = LOG_ICONS[lastLog.log_type];
    if (!icon) {
      icon = "📋";
    }
    var typeName = lastLog.log_type.replace(/_/g, " ");

    container.className = "last-update-card";
    var html = '<div class="update-type">' + icon + ' ' + typeName + '</div>';
    html = html + '<div class="update-message">' + lastLog.message + '</div>';
    html = html + '<div class="update-time">' + formatDate(lastLog.created_at, false) + ' • ' + lastLog.created_by + '</div>';
    container.innerHTML = html;
  }

  var panel = document.getElementById("details-panel");
  panel.classList.remove("hidden");
  panel.classList.add("active");
  adjustMapForPanel(true);
}

// Update progress tracker
function updateProgressTracker(status) {
  var steps = ["reported", "team_sent", "arrived", "rescued"];
  var currentIndex = -1;
  
  for (var i = 0; i < steps.length; i++) {
    if (steps[i] === status) {
      currentIndex = i;
      break;
    }
  }

  var stepElements = document.querySelectorAll(".progress-step");
  for (var i = 0; i < stepElements.length; i++) {
    stepElements[i].classList.remove("completed", "active");

    if (i < currentIndex) {
      stepElements[i].classList.add("completed");
    } else if (i === currentIndex) {
      stepElements[i].classList.add("active");
    }
  }
}

// Close details panel
function closeDetailsPanel() {
  var panel = document.getElementById("details-panel");
  panel.classList.remove("active");

  setTimeout(function () {
    panel.classList.add("hidden");
  }, 400);

  var items = document.querySelectorAll(".person-item, .marker-icon");
  for (var i = 0; i < items.length; i++) {
    items[i].classList.remove("selected");
  }

  currentPersonId = null;
  
  // Clear hidden form field
  var personIdInput = document.getElementById("person-id-input");
  if (personIdInput) {
    personIdInput.value = "";
  }
  
  adjustMapForPanel(false);
}
