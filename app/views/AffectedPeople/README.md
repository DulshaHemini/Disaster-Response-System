# Affected People Dashboard

## Overview
The Affected People Dashboard is a dedicated portal for individuals affected by disasters to view their personal data, including submitted requests, assigned resources, and activity logs.

## Features

### 1. **Personal Statistics**
- Total Requests submitted
- Pending Requests count
- Completed Requests count
- Total Assigned Resources

### 2. **My Requests Panel**
Displays all requests submitted by the logged-in affected person:
- Request name and description
- Request type (disaster type)
- Resource type and count needed
- Location information
- Priority level (low, medium, high)
- Status (Pending, Done, etc.)
- Submission timestamp

### 3. **Assigned Resources Panel**
Shows resources allocated to the affected person:
- Resource name and type
- Resource count
- Assignment status (Assigned, Allocated, Received)
- Volunteer information (name and contact)
- Assignment date
- Resource description

### 4. **Activity Logs Panel**
Displays recent activity logs related to the affected person:
- Log type (incident_reported, alert, team_dispatched, etc.)
- Log message
- Created by (admin/system user)
- Timestamp

### 5. **Profile Modal**
View personal profile information:
- Full name
- NIC (National Identity Card)
- Contact number
- Age and Gender
- Number of family members
- Location (District, City, Address)

## File Structure

```
app/
├── controllers/
│   └── AffectedPeople.php          # Controller handling session, data fetching
├── models/
│   └── AffectedPeople_.php         # Model with database queries
└── views/
    └── AffectedPeople/
        ├── _AffectedPeople.php     # Main dashboard view
        └── README.md               # This file
```

## Database Tables Used

### Primary Tables:
- `affected_people` - Profile information
- `users` - Authentication data
- `Location` - Address information

### Request Tables:
- `Logged_Request` - All requests submitted by affected people

### Resource Tables:
- `assignments` - Resource assignments (type: 'Volunteer_Resource')
- `resource` - Resource details
- `volunteer` - Volunteer information

### Activity Tables:
- `activity_logs` - Tracking logs for affected people

## Access Control
- **Role Required**: `affected_people`
- **Session Variables**: `user_id`, `user_role`
- **Redirect**: Unauthorized users are redirected to signin page

## Routing
- **URL**: `/affected-people` or direct access via `AffectedPeople.php`
- **Route Definition**: Added in `config/routes.php`
- **Signin Redirect**: Updated in `app/controllers/Signin.php`

## Design Pattern
Follows the same MVC pattern as other dashboards:
1. **Controller** validates session and fetches data via model
2. **Model** contains all database queries
3. **View** displays data with consistent DRCS theme

## Styling
Uses the DRCS design system:
- Color scheme: Red (#c8102e), Amber, Green, Blue
- Fonts: Playfair Display (headers), Outfit (body), JetBrains Mono (code/meta)
- Responsive grid layout
- Profile modal with backdrop blur
- Status badges with color coding

## Future Enhancements
- Real-time notifications for resource assignments
- Request submission form integration
- Resource acknowledgment/receipt confirmation
- Chat with assigned volunteers
- Document upload for verification
