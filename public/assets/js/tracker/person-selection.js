// person-selection.js - Person selection and focus functionality

let currentPersonId = null;

// Ensure details update automatically when person is focused
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

// Focus on person - smooth navigation WITHOUT opening panel
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

  // Select person first (updates UI, marks as selected)
  selectPerson(personId);

  // Smooth map animation to person location
  map.flyTo([person.latitude, person.longitude], 12, {
    duration: 1.5,
    easeLinearity: 0.5,
  });

  // Open popup marker after animation completes
  setTimeout(function () {
    if (markers[personId]) {
      markers[personId].openPopup();
    }
  }, 1500);

  // Load detail data in background for when user clicks Details button
  // NOTE: Panel does NOT open on focus - only on explicit Details click
  // loadPersonData(personId);
}
