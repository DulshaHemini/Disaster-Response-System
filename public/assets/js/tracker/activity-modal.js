// activity-modal.js - Activity modal management

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

  document.getElementById("modal-avatar").textContent = getInitials(
    person.full_name
  );
  document.getElementById("modal-name").textContent = person.full_name;

  var statusLabel = person.status.replace(/_/g, " ").toUpperCase();
  document.getElementById("modal-meta").textContent =
    person.district + "  •  " + person.age + " yrs  •  " + person.gender;

  // Drive the badge in the sticky person header
  var badgeEl = document.querySelector(".mph-badge");
  if (badgeEl) {
    badgeEl.textContent = statusLabel;
    // Mirror the status-badge colour classes
    badgeEl.className = "mph-badge " + person.status;
  }

  var timeline = document.getElementById("modal-activity-timeline");

  if (allActivityLogs.length === 0) {
    timeline.innerHTML =
      '<p style="color:#9aa0a6;text-align:center;padding:40px">No activity logs available</p>';
  } else {
    var html = "";
    var currentGroupDate = "";

    for (var i = 0; i < allActivityLogs.length; i++) {
      var log = allActivityLogs[i];
      var d = new Date(log.created_at);

      var months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ];
      var dateStr =
        months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear();

      if (dateStr !== currentGroupDate) {
        if (currentGroupDate !== "") {
          html += "</div>"; // close previous group
        }
        html += '<div class="timeline-date-header">' + dateStr + "</div>";
        html += '<div class="timeline-day-group">'; // start new group
        currentGroupDate = dateStr;
      }

      var hours = d.getHours();
      var minutes = d.getMinutes();
      var ampm = hours >= 12 ? "PM" : "AM";
      hours = hours % 12;
      hours = hours ? hours : 12; // the hour '0' should be '12'
      minutes = minutes < 10 ? "0" + minutes : minutes;
      var timeStr = hours + ":" + minutes + " " + ampm;

      var icon = LOG_ICONS[log.log_type] || "📋";
      // Title case the type name
      var typeWords = log.log_type.split("_");
      var typeName = "";
      for (var t = 0; t < typeWords.length; t++) {
        typeName +=
          typeWords[t].charAt(0).toUpperCase() + typeWords[t].slice(1) + " ";
      }

      html += '<div class="activity-item-compact">';
      html += '  <div class="activity-time">' + timeStr + "</div>";
      html += '  <div class="activity-content-compact">';
      html +=
        '    <div class="activity-type-compact">' +
        icon +
        " " +
        typeName.trim() +
        "</div>";
      html += '    <div class="activity-msg-compact">' + log.message + "</div>";
      html +=
        '    <div class="activity-author-compact">by ' +
        log.created_by +
        "</div>";
      html += "  </div>";
      html += "</div>";
    }

    if (currentGroupDate !== "") {
      html += "</div>"; // close last group
    }
    timeline.innerHTML = html;
  }

  document.getElementById("activity-modal").classList.remove("hidden");
}

// Close activity modal
function closeActivityModal() {
  document.getElementById("activity-modal").classList.add("hidden");
}
