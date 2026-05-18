// map.js – Disaster Tracker map logic - Simple style like developme project

let map;
let currentPersonId = null;
let markers = {};
let allActivityLogs = [];

const STATUS_CONFIG = {
  needs_aid: { color: "#ea4335", emoji: "🆘" },
  team_sent: { color: "#fbbc04", emoji: "🚁" },
  arrived: { color: "#4285f4", emoji: "📍" },
  rescued: { color: "#34a853", emoji: "✅" },
  stable: { color: "#34a853", emoji: "💚" },
  reported: { color: "#9aa0a6", emoji: "📢" },
};

const LOG_ICONS = {
  incident_reported: "🚨",
  alert: "⚠️",
  team_dispatched: "🚁",
  team_arrived: "📍",
  medical_aid: "🏥",
  food_supply: "🍲",
  shelter: "🏠",
  status_update: "📋",
};

// Helper functions
function getInitials(name) {
  var parts = name.split(" ");
  var initials = "";
  for (var i = 0; i < parts.length; i++) {
    initials = initials + parts[i][0];
  }
  return initials.toUpperCase();
}

function formatDate(dateStr, includeYear) {
  var date = new Date(dateStr);
  var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  
  var month = months[date.getMonth()];
  var day = date.getDate();
  var hours = date.getHours();
  var minutes = date.getMinutes();
  
  if (hours < 10) hours = "0" + hours;
  if (minutes < 10) minutes = "0" + minutes;
  
  var result = month + " " + day + ", " + hours + ":" + minutes;
  
  if (includeYear) {
    result = month + " " + day + ", " + date.getFullYear() + " " + hours + ":" + minutes;
  }
  
  return result;
}

function renderActivityItem(log, includeYear) {
  var icon = LOG_ICONS[log.log_type];
  if (!icon) {
    icon = "📋";
  }
  
  var typeName = log.log_type.replace(/_/g, " ").toUpperCase();

  var html = '<div class="activity-item">';
  html = html + '<strong>' + icon + ' ' + typeName + '</strong>';
  html = html + '<span>' + log.message + '</span>';
  html = html + '<small>' + formatDate(log.created_at, includeYear) + ' • ' + log.created_by + '</small>';
  html = html + '</div>';
  
  return html;
}

// Initialize map
function initMap() {
  map = L.map("map").setView([7.8731, 80.7718], 7);

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "© OpenStreetMap contributors",
    maxZoom: 19,
  }).addTo(map);

  addMarkersToMap(peopleData);
}

// Add markers to map
function addMarkersToMap(people) {
  // Remove old markers
  for (var id in markers) {
    map.removeLayer(markers[id]);
  }
  markers = {};

  // Add new markers
  for (var i = 0; i < people.length; i++) {
    var p = people[i];
    var cfg = STATUS_CONFIG[p.status];
    if (!cfg) {
      cfg = STATUS_CONFIG.reported;
    }

    var icon = L.divIcon({
      className: "custom-marker",
      html: '<div class="marker-icon ' + p.status + '" data-id="' + p.id + '" data-emoji="' + cfg.emoji + '"></div>',
      iconSize: [36, 50],
      iconAnchor: [18, 50],
    });

    var marker = L.marker([p.latitude, p.longitude], { icon: icon }).addTo(map);

    var popupHtml = '<div class="popup-name">' + p.full_name + '</div>';
    popupHtml = popupHtml + '<div class="popup-info">📍 ' + p.district + '</div>';
    popupHtml = popupHtml + '<div class="popup-info">🚨 ' + p.disaster_type + '</div>';
    popupHtml = popupHtml + '<div class="popup-info">Status: ' + p.status.replace("_", " ") + '</div>';
    
    marker.bindPopup(popupHtml, {
      offset: [0, -40],
      closeButton: false,
      autoClose: false,
      closeOnClick: false
    });

    marker.personId = p.id;
    marker.personLat = p.latitude;
    marker.personLng = p.longitude;
    
    // Show popup on hover
    marker.on("mouseover", function () {
      this.openPopup();
    });
    
    // Hide popup when mouse leaves
    marker.on("mouseout", function () {
      this.closePopup();
    });
    
    // Focus on click
    marker.on("click", function () {
      selectPerson(this.personId);
      map.flyTo([this.personLat, this.personLng], 12, {
        duration: 1.5,
        easeLinearity: 0.5,
      });
    });

    markers[p.id] = marker;
  }
}

// Select person
function selectPerson(personId) {
  currentPersonId = personId;

  // Update hidden form field
  var personIdInput = document.getElementById("person-id-input");
  if (personIdInput) {
    personIdInput.value = personId;
  }

  // Remove selected class from all
  var items = document.querySelectorAll(".person-item, .marker-icon");
  for (var i = 0; i < items.length; i++) {
    items[i].classList.remove("selected");
  }

  // Add selected class
  var item = document.getElementById("person-" + personId);
  if (item) {
    item.classList.add("selected");
    item.scrollIntoView({ behavior: "smooth", block: "nearest" });
  }

  var markerIcon = document.querySelector('.marker-icon[data-id="' + personId + '"]');
  if (markerIcon) {
    markerIcon.classList.add("selected");
  }
}

// Focus on person
function focusPerson(personId) {
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

  map.flyTo([person.latitude, person.longitude], 12, {
    duration: 1.5,
    easeLinearity: 0.5,
  });

  selectPerson(personId);

  setTimeout(function () {
    if (markers[personId]) {
      markers[personId].openPopup();
    }
  }, 1500);
}

// Open details panel
function openDetails(personId) {
  currentPersonId = personId;
  selectPerson(personId);

  // Open popup window to get person data
  window.open("get_person.php?id=" + personId, "personData", "width=100,height=100");
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
  document.getElementById("detail-injury").textContent = p.injury_status;

  var severity = "Medium";
  if (p.status === "needs_aid") {
    severity = "High";
  } else if (p.status === "rescued" || p.status === "stable") {
    severity = "Low";
  }
  document.getElementById("detail-severity").textContent = severity;

  var familyText = p.family_count + " ";
  if (p.family_count === 1) {
    familyText = familyText + "member";
  } else {
    familyText = familyText + "members";
  }
  document.getElementById("detail-family").textContent = familyText;
  document.getElementById("detail-contact").textContent = p.contact;
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

// Adjust map for panel
function adjustMapForPanel(open) {
  var mapElement = document.getElementById("map");

  if (open) {
    mapElement.classList.add("panel-open");
  } else {
    mapElement.classList.remove("panel-open");
  }

  setTimeout(function () {
    map.invalidateSize();

    if (open && currentPersonId) {
      var person = null;
      for (var i = 0; i < peopleData.length; i++) {
        if (peopleData[i].id == currentPersonId) {
          person = peopleData[i];
          break;
        }
      }

      if (person) {
        map.panTo([person.latitude, person.longitude]);
      }
    }
  }, 450);
}

// Open activity modal
function openActivityModal() {
  if (!currentPersonId) {
    return;
  }

  var person = null;
  for (var i = 0; i < peopleData.length; i++) {
    if (peopleData[i].id == currentPersonId) {
      person = peopleData[i];
      break;
    }
  }

  if (!person) {
    return;
  }

  document.getElementById("modal-avatar").textContent = getInitials(person.full_name);
  document.getElementById("modal-name").textContent = person.full_name;
  document.getElementById("modal-meta").textContent = person.district + " • " + person.status.replace("_", " ").toUpperCase();

  var timeline = document.getElementById("modal-activity-timeline");

  if (allActivityLogs.length === 0) {
    timeline.innerHTML = '<p style="color:#9aa0a6;text-align:center;padding:40px">No activity logs available</p>';
  } else {
    var html = "";
    for (var i = 0; i < allActivityLogs.length; i++) {
      html = html + renderActivityItem(allActivityLogs[i], true);
    }
    timeline.innerHTML = html;
  }

  document.getElementById("activity-modal").classList.remove("hidden");
}

// Close activity modal
function closeActivityModal() {
  document.getElementById("activity-modal").classList.add("hidden");
}

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
