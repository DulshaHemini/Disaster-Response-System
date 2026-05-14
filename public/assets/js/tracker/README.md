# JavaScript Files Structure

The JavaScript code has been separated into multiple files based on main tasks:

## Files Overview

### 1. **config.js**
- Configuration and constants
- `STATUS_CONFIG` - Status colors and emojis
- `LOG_ICONS` - Activity log type icons

### 2. **helpers.js**
- Helper utility functions
- `getInitials(name)` - Get initials from full name
- `formatDate(dateStr, includeYear)` - Format date for display
- `renderActivityItem(log, includeYear)` - Render activity log HTML

### 3. **map-handler.js**
- Map initialization and marker management
- `initMap()` - Initialize Leaflet map
- `addMarkersToMap(people)` - Add person markers to map
- `adjustMapForPanel(open)` - Adjust map when panel opens/closes
- Variables: `map`, `markers`

### 4. **person-selection.js**
- Person selection and focus functionality
- `selectPerson(personId)` - Select and highlight a person
- `focusPerson(personId)` - Zoom to person location
- Variables: `currentPersonId`

### 5. **details-panel.js**
- Details panel management
- `openDetails(personId)` - Open details panel for person
- `receivePersonData(person, logs, logsCount)` - Receive data from popup
- `updateProgressTracker(status)` - Update rescue progress tracker
- `closeDetailsPanel()` - Close details panel
- Variables: `allActivityLogs`

### 6. **activity-modal.js**
- Activity modal management
- `openActivityModal()` - Open full activity timeline modal
- `closeActivityModal()` - Close activity modal

### 7. **main.js**
- Main initialization and event handlers
- Keyboard shortcuts (ESC key)
- Page load initialization

## Load Order (Important!)

Files must be loaded in this order in tracker.php:

1. config.js (constants needed by other files)
2. helpers.js (functions used by other files)
3. map-handler.js (map setup)
4. person-selection.js (selection logic)
5. details-panel.js (panel management)
6. activity-modal.js (modal management)
7. main.js (initialization)

## Old File

- **map.js** - Original monolithic file (can be deleted)
