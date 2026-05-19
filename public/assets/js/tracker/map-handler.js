// map-handler.js - Map initialization and marker management

let map;
let markers = {};

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
      cfg = STATUS_CONFIG.needs_aid;
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

// Adjust map for panel - with intelligent centering
function adjustMapForPanel(open) {
  var mapElement = document.getElementById("map");

  if (open) {
    mapElement.classList.add("panel-open");
  } else {
    mapElement.classList.remove("panel-open");
  }

  // Wait for CSS transition to complete before adjusting map
  setTimeout(function () {
    // Recalculate map size after panel animation
    map.invalidateSize(false);

    if (open && currentPersonId) {
      var person = null;
      for (var i = 0; i < peopleData.length; i++) {
        if (peopleData[i].id == currentPersonId) {
          person = peopleData[i];
          break;
        }
      }

      if (person) {
        // Smooth animated pan to center the person in the available map area
        // When panel opens, the map shrinks from right, so we center to account for that
        map.panTo(
          [person.latitude, person.longitude],
          {
            animate: true,
            duration: 0.6, // Smooth animation duration
            easeLinearity: 0.25 // Smooth easing curve
          }
        );
      }
    }
  }, 400); // Wait for CSS transition (0.4s) to complete
}

