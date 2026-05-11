# Tracker System MVC Architecture

## Overview
The Tracker system has been refactored from a monolithic view file (`tracker.php`) into a proper MVC (Model-View-Controller) architecture following the project's established patterns.

## Architecture Structure

### 1. **Model Layer** - `app/models/TrackerModel.php`
Handles all data operations and business logic.

**Key Methods:**
- `getAllPeople()` - Retrieves all affected people
- `getPersonById($person_id)` - Gets a specific person's details
- `getLogsByPerson($person_id)` - Retrieves activity logs for a person
- `addActivityLog($person_id, $log_type, $message, $created_by)` - Adds a new activity log
- `formatPersonInitials($full_name)` - Utility to format person initials

**Usage:**
```php
$model = new TrackerModel($conn);
$people = $model->getAllPeople();
$person = $model->getPersonById(1);
```

### 2. **Controller Layer** - `app/controllers/TrackerController.php`
Handles requests and orchestrates data flow between models and views.

**Key Methods:**
- `index()` - Main tracker page (displays all people and map)
- `getPerson()` - API endpoint to get person details (AJAX)
- `addLog()` - API endpoint to add activity logs (AJAX)

**Usage Pattern:**
```php
$ctrl = new TrackerController();
$ctrl->index();  // Displays the tracker page
```

### 3. **View Layer** - `app/views/tracker/tracker.php`
Displays the tracker interface with maps and person list.

**Data Passed from Controller:**
- `$people` - Array of all affected people
- `$total_people` - Total count of people

### 4. **Supporting Files**

#### `app/views/tracker/add_log.php`
Handles form submission for adding activity logs.
- Uses `TrackerModel` to save logs
- Redirects back to tracker page on success

#### `app/views/tracker/get_person.php`
AJAX endpoint for fetching person details.
- Uses `TrackerModel` to retrieve person and logs
- Returns data as HTML for popup display

#### `public/tracker/index.php`
Entry point for tracker requests.
- Defines paths (BASE_PATH, APP_PATH, CONFIG_PATH)
- Loads TrackerController and calls index() method

## Data Flow

```
User Request (tracker page)
    ↓
public/tracker/index.php
    ↓
app/controllers/TrackerController.php (index method)
    ↓
app/models/TrackerModel.php (getAllPeople)
    ↓
app/views/tracker/tracker.php (displays with $people data)
```

## How It Follows Project MVC Patterns

This implementation follows the same patterns used in `HomeController`:

1. **Model Instantiation**: Creates model instance with database connection
2. **Data Extraction**: Uses PHP's `extract()` to pass data to views
3. **Output Buffering**: Uses `ob_start()` and `ob_get_clean()` for clean rendering
4. **Layout System**: Uses `layouts/main.php` for consistent page structure

## Database Connection

Currently uses mock data. To enable real database queries:

1. In `TrackerModel.php`, replace mock data methods with MySQL queries
2. Update `getAllPeopleData()` with real query
3. Update `getPersonByIdData()` with real query
4. Update `getLogsByPersonData()` with real query
5. Update `addActivityLogData()` with real INSERT query

Example replacement:
```php
// Before (Mock)
private function getAllPeopleData(): array {
    return array(...);
}

// After (Real DB)
private function getAllPeopleData(): array {
    $query = "SELECT * FROM affected_people ORDER BY created_at DESC";
    $result = mysqli_query($this->conn, $query);
    $people = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $people[] = $row;
    }
    return $people;
}
```

## File Organization

```
app/
├── controllers/
│   └── TrackerController.php      ← Handles requests
├── models/
│   └── TrackerModel.php           ← Handles data
└── views/
    └── tracker/
        ├── tracker.php            ← Main view
        ├── add_log.php            ← Add log form handler
        └── get_person.php         ← Person details AJAX endpoint

public/
└── tracker/
    └── index.php                  ← Entry point
```

## Key Features

- **Separation of Concerns**: Business logic (models) separate from presentation (views)
- **Reusability**: Model can be used by multiple controllers if needed
- **Maintainability**: Easy to update queries in one place
- **Consistency**: Follows project's existing MVC patterns
- **Beginner-Friendly**: Uses simple, easy-to-understand code patterns

## Future Improvements

1. Add database queries to replace mock data
2. Implement input validation in controller
3. Add error handling with custom exceptions
4. Create API response helper utilities
5. Add logging for audit trails
6. Implement person status transitions
