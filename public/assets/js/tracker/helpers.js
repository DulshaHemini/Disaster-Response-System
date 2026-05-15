// helpers.js - Helper functions

// Get initials from name
function getInitials(name) {
  var parts = name.split(" ");
  var initials = "";
  for (var i = 0; i < parts.length; i++) {
    initials = initials + parts[i][0];
  }
  return initials.toUpperCase();
}

// Format date
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

// Render activity item
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
