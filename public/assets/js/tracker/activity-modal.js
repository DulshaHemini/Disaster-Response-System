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
