# Quick Reference Guide

## 🎯 What to Use Where

### **For Forms (Signup, Requests, etc.)**
```html
<!-- Include static data -->
<script src="/public/assets/js/static-data.js"></script>

<!-- Use helper functions -->
<script>
    // Get districts for dropdown
    const districts = StaticData.districts;
    
    // Get resource types
    const resources = StaticData.resourceTypes;
    
    // Get disaster icon
    const icon = StaticDataHelpers.getDisasterIcon('flood'); // 💧
</script>
```

### **For Dashboard (Homepage)**
```php
// In Controller
$model = new DashboardModel();
$kpis = $model->getKpis();           // KPI cards
$alerts = $model->getAlerts();       // Live alerts
$needs = $model->getNeeds();         // Resource needs
$heroStats = $model->getHeroStats(); // Hero stats

// Optional: Get from database
$activeIncidents = $conn->query("SELECT COUNT(*) FROM incidents WHERE status='active'");
$recentAlerts = $conn->query("SELECT * FROM alerts WHERE is_active=1 ORDER BY created_at DESC LIMIT 6");
```

### **For Database Operations**
```php
// Insert new request
$stmt = $conn->prepare("INSERT INTO Request (affected_people_id, loc_id, req_type, resource_type, quantity, contact_number, priority_level) VALUES (?, ?, ?, ?, ?, ?, ?)");

// Get active incidents
$result = $conn->query("SELECT * FROM incidents WHERE status='active'");

// Get alerts
$result = $conn->query("SELECT * FROM alerts WHERE is_active=1 ORDER BY created_at DESC");
```

---

## 📊 Database Tables Quick Reference

### **User Management (4 tables)**
```
users (user_id, username, password, user_role, created_at)
  ├── admin (user_id, name, contact_no)
  ├── affected_people (user_id, name, contact_no, no_of_family_members, priority_level)
  └── volunteer (user_id, name, contact_no, availability_status)
```

### **Location & Requests (2 tables)**
```
Location (loc_id, user_id, latitude, longitude, district, city)

Request (req_id, affected_people_id, loc_id, req_type, resource_type, 
         quantity, description, contact_number, priority_level, status, created_at)
```

### **Resources & Assignments (2 tables)**
```
resource (resource_id, volunteer_id, resource_type, quantity, description)

assignment (assignment_id, req_id, resource_id, volunteer_id, status, assigned_date)
```

### **Dashboard Data (2 core + 3 optional)**
```
incidents (incident_id, incident_type, severity, loc_id, affected_count, status, created_at)
alerts (alert_id, alert_type, message, location, created_at, is_active)

[Optional]
teams_deployed (team_id, team_leader_id, incident_id, team_size, status, deployed_at)
evacuations (evacuation_id, incident_id, from_location_id, people_count, evacuation_date)
high_risk_zones (zone_id, district, city, risk_level, risk_type, status, identified_date)
```

---

## 🎨 Static Data Quick Reference

### **Disaster Types**
```javascript
StaticData.disasterTypes
// tornado, tsunami, landslide, flood, other
// Each has: id, label, icon, color
```

### **Resource Types**
```javascript
StaticData.resourceTypes
// medical, food, shelter, clothing, money
// Each has: id, label, icon
```

### **Priority Levels**
```javascript
StaticData.priorityLevels
// low, medium, high
// Each has: id, label, color
```

### **Status Types**
```javascript
StaticData.statusTypes.request      // pending, assigned, completed
StaticData.statusTypes.assignment   // assigned, in_progress, completed
StaticData.statusTypes.incident     // active, resolved
StaticData.statusTypes.volunteer    // available, busy
```

### **Districts**
```javascript
StaticData.districts
// Array of 25 Sri Lankan districts
```

### **Emergency Contacts**
```javascript
StaticData.emergencyContacts
// Ambulance: 110, Fire: 111, Police: 119, Disaster: 1919, NDMA: 0112136136
```

---

## 🔧 Helper Functions

### **Get Metadata**
```javascript
StaticDataHelpers.getDisasterType('flood')    // Returns: {id, label, icon, color}
StaticDataHelpers.getResourceType('food')     // Returns: {id, label, icon}
StaticDataHelpers.getPriorityLevel('high')    // Returns: {id, label, color}
StaticDataHelpers.getSeverityLevel('critical') // Returns: {id, label, color}
```

### **Get Icons & Colors**
```javascript
StaticDataHelpers.getDisasterIcon('tsunami')  // Returns: 🌊
StaticDataHelpers.getResourceIcon('medical')  // Returns: 💊
StaticDataHelpers.getPriorityColor('high')    // Returns: #dc3545
```

### **Generate HTML**
```javascript
StaticDataHelpers.getDistrictOptions()        // Returns: <option> tags for all districts
StaticDataHelpers.getResourceTypeOptions()    // Returns: <option> tags for all resources
```

---

## 📝 Common Queries

### **Dashboard KPIs**
```sql
-- Active Incidents
SELECT COUNT(*) FROM incidents WHERE status='active';

-- High-Risk Zones
SELECT COUNT(*) FROM high_risk_zones WHERE status='active';

-- Teams Deployed
SELECT COUNT(*) FROM teams_deployed WHERE status='deployed';

-- People Evacuated (last 24h)
SELECT SUM(people_count) FROM evacuations 
WHERE evacuation_date >= DATE_SUB(NOW(), INTERVAL 24 HOUR);
```

### **Live Alerts**
```sql
SELECT * FROM alerts 
WHERE is_active=1 
ORDER BY created_at DESC 
LIMIT 6;
```

### **Recent Requests**
```sql
SELECT r.*, l.district, l.city, a.name 
FROM Request r
LEFT JOIN Location l ON r.loc_id = l.loc_id
LEFT JOIN affected_people a ON r.affected_people_id = a.user_id
WHERE r.status = 'pending'
ORDER BY r.priority_level DESC, r.created_at DESC;
```

### **Available Volunteers**
```sql
SELECT v.*, u.username 
FROM volunteer v
JOIN users u ON v.user_id = u.user_id
WHERE v.availability_status = 'available';
```

---

## 🚀 Setup Checklist

### **1. Database Setup**
```bash
# Create core tables
php database/create_databases.php

# (Optional) Create dashboard tables
mysql -u root -p DRCS < docs/temp-sql/create_dashboard_tables.sql

# (Optional) Insert test data
php database/insert_test_data.php
```

### **2. Include Static Data**
```html
<!-- In your HTML head or before closing body tag -->
<script src="/public/assets/js/static-data.js"></script>
```

### **3. Verify Setup**
```javascript
// In browser console
console.log(StaticData.disasterTypes);  // Should show array of 5 disaster types
console.log(StaticData.districts);      // Should show array of 25 districts
```

---

## 🎯 File Locations

```
database/
├── create_databases.php          ← Run this first
├── insert_test_data.php          ← Optional test data
└── delete_test_data.php          ← Clean test data

docs/
├── temp-sql/
│   └── create_dashboard_tables.sql  ← Optional dashboard tables
├── OPTIMIZED_ARCHITECTURE.md     ← Full documentation
├── ANALYSIS_SUMMARY.md           ← Analysis details
└── QUICK_REFERENCE.md            ← This file

public/assets/js/
└── static-data.js                ← Include in all pages

app/
├── models/
│   └── DashboardModel.php        ← Dashboard data provider
└── controllers/
    └── HomeController.php        ← Homepage controller
```

---

## ⚡ Performance Tips

1. **Cache static data** - It never changes, so cache it in browser
2. **Use indexes** - All foreign keys have indexes
3. **Limit queries** - Use LIMIT for large result sets
4. **Use prepared statements** - Prevent SQL injection
5. **Optimize joins** - Only join tables you need

---

## 🐛 Troubleshooting

### **Static data not loading?**
```javascript
// Check if script is loaded
if (typeof StaticData === 'undefined') {
    console.error('static-data.js not loaded!');
}
```

### **Database connection error?**
```php
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
```

### **Foreign key constraint error?**
```sql
-- Temporarily disable foreign key checks
SET FOREIGN_KEY_CHECKS = 0;
-- Your query here
SET FOREIGN_KEY_CHECKS = 1;
```

---

## 📞 Need Help?

1. Check `docs/OPTIMIZED_ARCHITECTURE.md` for detailed documentation
2. Check `docs/ANALYSIS_SUMMARY.md` for analysis details
3. Review `app/models/DashboardModel.php` for data structure examples
4. Check browser console for JavaScript errors
5. Check PHP error logs for database errors
