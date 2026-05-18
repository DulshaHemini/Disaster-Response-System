# Admin Panel Testing Checklist

## Pre-Testing Setup
- [ ] Database is running (XAMPP/MySQL)
- [ ] Database `DRCS` exists with all tables
- [ ] Test data is inserted (use `database/insert_test_data.php`)
- [ ] Web server is running (Apache)

## Visual Tests

### Navbar & Ticker
- [ ] DRCS logo displays correctly
- [ ] "Command Center" badge shows
- [ ] All 4 tab buttons visible: Users, Requests, Instant Help, Assign
- [ ] Exit button present
- [ ] Ticker scrolls continuously
- [ ] Ticker shows emergency alerts with emojis

### Tab Switching
- [ ] Click "👥 Manage Users" - Users tab displays
- [ ] Click "📋 All Requests" - Requests tab displays
- [ ] Click "⚡ Instant Help" - Instant Help tab displays
- [ ] Click "🔄 Assign Volunteers" - Assign tab displays
- [ ] Active tab button has white background
- [ ] Only one tab content visible at a time

### Responsive Design
- [ ] Resize browser to mobile width (< 800px)
- [ ] Navbar stacks properly
- [ ] Tabs move to new row
- [ ] Tables scroll horizontally
- [ ] Stats grid becomes single column

## Functional Tests

### 1. Users Tab (👥 Manage Users)

#### Display
- [ ] Statistics show correct volunteer count
- [ ] Statistics show correct affected people count
- [ ] User table displays all users
- [ ] Role badges show correct colors (volunteer = blue, affected = gray)
- [ ] Created dates display correctly

#### Actions
- [ ] Click "Remove" on a user
- [ ] Confirm dialog appears
- [ ] User is removed from table
- [ ] Toast notification shows "User removed"
- [ ] Refresh page - user is gone from database

### 2. Requests Tab (📋 All Requests)

#### Display
- [ ] All requests from both tables display
- [ ] "Is Instant" column shows "Yes" or "No"
- [ ] Status badges show correct colors
- [ ] Filter dropdown shows: All, Pending, In Progress, Resolved

#### Filtering
- [ ] Select "Pending" - only pending requests show
- [ ] Select "In Progress" - only in-progress requests show
- [ ] Select "Resolved" - only resolved requests show
- [ ] Select "All" - all requests show again

#### Status Update
- [ ] Change status dropdown on a request
- [ ] Status badge updates immediately
- [ ] Toast notification shows "Request #X updated"
- [ ] Refresh page - status persists in database

### 3. Instant Help Tab (⚡ Instant Help) - NEW!

#### Display
- [ ] Statistics show: Total, Pending, In Progress, Resolved
- [ ] Statistics have correct counts
- [ ] Table shows all instant requests
- [ ] Location columns show district and city
- [ ] Full name displays correctly
- [ ] Contact numbers visible

#### Status Update
- [ ] Change status dropdown on an instant request
- [ ] Status badge updates immediately
- [ ] Toast notification shows update
- [ ] Statistics update to reflect new status
- [ ] Refresh page - status persists

### 4. Assign Tab (🔄 Assign Volunteers)

#### Display
- [ ] Only open requests display (not resolved)
- [ ] Volunteer dropdown shows all volunteers
- [ ] Previously assigned volunteers are pre-selected
- [ ] Request details show: ID, Type, Resource, Location

#### Assignment
- [ ] Select a volunteer from dropdown
- [ ] Click "Assign" button
- [ ] Toast notification shows "Volunteer assigned"
- [ ] Refresh page - assignment persists
- [ ] Check assignments table in database

## Public Form Tests

### Instant Help Request Form (`/auth/instant_help_req.php`)

#### Display
- [ ] Form loads with DRCS navbar
- [ ] "EMERGENCY REQUEST" badge pulses
- [ ] All form fields visible
- [ ] Required fields marked with red asterisk

#### Validation
- [ ] Submit empty form - validation errors show
- [ ] Fill only name - validation error for contact
- [ ] Fill required fields - form submits

#### Submission
- [ ] Fill all required fields:
  - Full Name: "Test User"
  - Contact: "+94 77 123 4567"
  - Request Name: "Emergency Food"
  - Resource Type: "Foods"
  - Quantity: 5
  - Description: "Need food for family"
- [ ] Fill location (optional):
  - District: "Colombo"
  - City: "Dehiwala"
  - Street: "Galle Road"
- [ ] Click "Submit Emergency Request"
- [ ] Success message displays
- [ ] Contact number shown in success message
- [ ] "Return to Home" button appears

#### Database Verification
- [ ] Check `requests` table - new entry with type 'Instant_Request'
- [ ] Check `Instant_Request` table - new entry with correct data
- [ ] Check `Location` table - new entry with location data
- [ ] `req_id` in Instant_Request matches `request_id` in requests
- [ ] `loc_id` in Instant_Request matches `loc_id` in Location
- [ ] Status is 'Pending'

#### Admin View
- [ ] Go to admin panel
- [ ] Click "⚡ Instant Help" tab
- [ ] New request appears in table
- [ ] Statistics updated (Pending count +1)
- [ ] All submitted data displays correctly

## Error Handling Tests

### Network Errors
- [ ] Stop MySQL server
- [ ] Try to load admin panel - connection error
- [ ] Try to submit instant help form - error message

### Invalid Data
- [ ] Try to update request status to invalid value (via browser console)
- [ ] Should fail gracefully with error toast
- [ ] Try to delete non-existent user
- [ ] Should show error toast

### SQL Injection Prevention
- [ ] Try entering `'; DROP TABLE users; --` in form fields
- [ ] Data should be escaped/sanitized
- [ ] No SQL errors should occur

## Performance Tests

### Load Time
- [ ] Admin panel loads in < 2 seconds
- [ ] Tab switching is instant (< 100ms)
- [ ] AJAX actions complete in < 1 second

### Large Data
- [ ] Insert 100+ test requests
- [ ] Admin panel still loads quickly
- [ ] Tables scroll smoothly
- [ ] Filtering works correctly

## Browser Compatibility

Test in multiple browsers:
- [ ] Chrome/Edge (Chromium)
- [ ] Firefox
- [ ] Safari (if available)
- [ ] Mobile browsers (Chrome Mobile, Safari iOS)

## Security Tests

### Authentication (TODO)
- [ ] Try accessing admin.php without login
- [ ] Should redirect to signin.php
- [ ] After login, admin panel accessible

### Authorization (TODO)
- [ ] Login as non-admin user
- [ ] Try accessing admin.php
- [ ] Should show "Access Denied"

### CSRF Protection (TODO)
- [ ] Add CSRF tokens to forms
- [ ] Verify tokens on submission

## Known Issues

Document any issues found:

1. **Issue**: 
   - **Steps to reproduce**: 
   - **Expected**: 
   - **Actual**: 
   - **Priority**: High/Medium/Low

## Test Results Summary

**Date Tested**: _______________
**Tested By**: _______________
**Browser**: _______________
**Pass Rate**: _____ / _____ tests passed

### Critical Issues Found:
- 

### Minor Issues Found:
- 

### Recommendations:
- 

---

## Quick Test Commands

### Insert Test Data
```bash
# Navigate to database folder
cd database/

# Run insert script
php insert_test_data.php
```

### Check Database
```sql
-- Count users
SELECT user_role, COUNT(*) FROM users GROUP BY user_role;

-- Count requests
SELECT 'Logged' as type, COUNT(*) FROM Logged_Request
UNION ALL
SELECT 'Instant' as type, COUNT(*) FROM Instant_Request;

-- Check assignments
SELECT * FROM assignments;

-- View instant requests with location
SELECT ir.*, l.district, l.city 
FROM Instant_Request ir 
LEFT JOIN Location l ON ir.loc_id = l.loc_id;
```

### Clear Test Data
```bash
php database/delete_test_data.php
```
