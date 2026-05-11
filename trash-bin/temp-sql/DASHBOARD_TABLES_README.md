# Dashboard Database Tables - Analysis & Implementation

## Overview
This document explains the database tables that were **missing** from the original database schema but are **required** to support the `DashboardModel.php` functionality.

## Current Situation
The `DashboardModel.php` file returns **hardcoded data** for the dashboard. To make this a fully functional database-driven application, we need to create tables to store this data dynamically.

---

## 📊 Missing Tables Analysis

### Existing Tables (from `create_databases.php`)
The system already has these tables:
1. ✅ `users` - User authentication
2. ✅ `admin` - Admin user details
3. ✅ `affected_people` - People affected by disasters
4. ✅ `volunteer` - Volunteer information
5. ✅ `Location` - Geographic locations
6. ✅ `Request` - Help requests from affected people
7. ✅ `resource` - Resources provided by volunteers
8. ✅ `assignment` - Assignment of resources to requests
9. ✅ `money_allocation` - Financial aid tracking

### Missing Tables (Required for Dashboard)
The following tables were **completely missing** and have been created:

#### 1. **`kpi_metrics`** ❌ MISSING
**Purpose:** Store Key Performance Indicators shown at the top of the dashboard
- Active Incidents count
- High-Risk Zones count
- Teams Deployed count
- People Evacuated count

**Why needed:** Currently hardcoded in `getKpis()` method

---

#### 2. **`alerts`** ❌ MISSING
**Purpose:** Store live alert feed for the dashboard
- Critical alerts (flash floods, road closures)
- Warning alerts (landslide risks, shelter capacity)
- Info alerts (relief convoys, medical teams)

**Why needed:** Currently hardcoded in `getAlerts()` method

---

#### 3. **`resource_needs`** ❌ MISSING
**Purpose:** Track critical resource shortages at disaster sites
- Clean Water
- Food Packs
- Medical Kits
- Tents/Shelter
- Rescue Boats
- Power Units
- Communication Radios

**Why needed:** Currently hardcoded in `getNeeds()` method

---

#### 4. **`response_readiness`** ❌ MISSING
**Purpose:** Track response readiness by province/region
- Southern Province: 82%
- Sabaragamuwa: 67%
- Western Province: 91%
- Eastern Province: 58%

**Why needed:** Currently hardcoded in `getReadiness()` method

---

#### 5. **`disaster_type_stats`** ❌ MISSING
**Purpose:** Store disaster type breakdown for analytics
- Flooding: 74%
- Landslides: 52%
- Cyclones: 31%
- Droughts: 22%
- Other: 14%

**Why needed:** Currently hardcoded in `getDisasterTypes()` method

---

#### 6. **`resource_allocation_stats`** ❌ MISSING
**Purpose:** Track resource allocation progress
- Rescue Personnel: 1,840 / 2,200 (84%)
- Vehicles Deployed: 280 / 400 (70%)
- Shelter Capacity: 9,200 / 12,000 (77%)
- Medical Units: 46 / 60 (77%)

**Why needed:** Currently hardcoded in `getResourceAllocation()` method

---

#### 7. **`response_times`** ❌ MISSING
**Purpose:** Track average response times by area tier
- Urban Tier 1: 12 min
- Urban Tier 2: 22 min
- Semi-Rural: 34 min
- Remote: 58 min

**Why needed:** Currently hardcoded in `getResponseTimes()` method

---

#### 8. **`hero_statistics`** ❌ MISSING
**Purpose:** Store hero section statistics
- 24/7 Monitoring
- 142+ Response Teams
- 9 Districts Active Zones
- 3.2k People Assisted

**Why needed:** Currently hardcoded in `getHeroStats()` method

---

#### 9. **`emergency_contacts`** ❌ MISSING
**Purpose:** Store emergency contact numbers
- 🏥 Ambulance: 110
- 🚒 Fire & Rescue: 111
- 👮 Police Emergency: 119
- 🌊 Disaster Hotline: 1919
- ☎️ NDMA HQ: 0112136136

**Why needed:** Currently hardcoded in `getEmergencyContacts()` method

---

#### 10. **`incidents`** ❌ MISSING (Enhanced)
**Purpose:** Main incidents table to track all disaster incidents
- Links to many dashboard metrics
- Tracks incident status, severity, affected people
- More comprehensive than the existing `Request` table

**Why needed:** To properly track active incidents shown in KPIs

---

#### 11. **`high_risk_zones`** ❌ MISSING
**Purpose:** Track areas identified as high-risk zones
- Zone name, district, city
- Risk level and type
- Population at risk
- Assessment dates

**Why needed:** To support the "High-Risk Zones" KPI

---

#### 12. **`teams_deployed`** ❌ MISSING
**Purpose:** Track response teams deployed to disaster sites
- Team name, type, leader
- Deployment status
- Team size
- Deployment and return dates

**Why needed:** To support the "Teams Deployed" KPI (currently shows 142)

---

#### 13. **`evacuations`** ❌ MISSING
**Purpose:** Track people evacuated from disaster zones
- Number of people evacuated
- From/to locations
- Coordinating admin and team
- Evacuation status

**Why needed:** To support the "People Evacuated" KPI (currently shows 3,214)

---

## 📁 Files Created

### 1. `create_dashboard_tables.sql`
Contains the SQL `CREATE TABLE` statements for all 13 missing tables with:
- Proper column definitions
- Data types and constraints
- Foreign key relationships
- Indexes for performance
- Comments explaining each table

### 2. `insert_dashboard_data.sql`
Contains the SQL `INSERT` statements to populate the tables with:
- Sample data matching the current hardcoded values in `DashboardModel.php`
- Realistic test data for development
- 142 teams deployed (matching the KPI)
- 3,214+ people evacuated (matching the KPI)
- 18 active incidents (matching the KPI)
- 7 high-risk zones (matching the KPI)

### 3. `DASHBOARD_TABLES_README.md` (this file)
Documentation explaining:
- What tables were missing
- Why they are needed
- How they relate to `DashboardModel.php`
- How to use the SQL files

---

## 🚀 How to Use

### Step 1: Create the Tables
Run the table creation script:
```bash
# Option 1: Using MySQL command line
mysql -u root -p DRCS < database/create_dashboard_tables.sql

# Option 2: Using phpMyAdmin
# - Open phpMyAdmin
# - Select the DRCS database
# - Go to SQL tab
# - Copy and paste the contents of create_dashboard_tables.sql
# - Click "Go"
```

### Step 2: Insert Sample Data
Run the data insertion script:
```bash
# Option 1: Using MySQL command line
mysql -u root -p DRCS < database/insert_dashboard_data.sql

# Option 2: Using phpMyAdmin
# - Open phpMyAdmin
# - Select the DRCS database
# - Go to SQL tab
# - Copy and paste the contents of insert_dashboard_data.sql
# - Click "Go"
```

### Step 3: Update DashboardModel.php
Modify the `DashboardModel.php` methods to fetch data from the database instead of returning hardcoded arrays. For example:

**Before (Hardcoded):**
```php
public function getKpis(): array
{
    return [
        ['color' => 'red', 'icon' => '🆘', 'value' => '18', ...],
        // ... hardcoded data
    ];
}
```

**After (Database-driven):**
```php
public function getKpis(): array
{
    $conn = $this->getConnection(); // Your database connection
    $sql = "SELECT color, icon, value, label, delta, trend 
            FROM kpi_metrics 
            WHERE is_active = 1 
            ORDER BY display_order";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
```

---

## 🔗 Table Relationships

```
users
├── admin
├── volunteer
│   └── teams_deployed (team_leader_id)
└── affected_people
    └── Request

Location
├── incidents
├── high_risk_zones
├── teams_deployed
└── evacuations

incidents
├── teams_deployed
└── evacuations

admin
├── response_readiness (assessed_by)
├── alerts (acknowledged_by)
└── evacuations (coordinated_by)
```

---

## 📈 Data Flow

1. **Incidents occur** → Stored in `incidents` table
2. **Alerts generated** → Stored in `alerts` table
3. **Teams deployed** → Stored in `teams_deployed` table
4. **People evacuated** → Stored in `evacuations` table
5. **Resources tracked** → Stored in `resource_needs` table
6. **KPIs calculated** → Aggregated from various tables → Stored in `kpi_metrics`
7. **Dashboard displays** → `DashboardModel.php` fetches from database

---

## ⚠️ Important Notes

1. **Foreign Keys:** Some tables reference existing tables (`users`, `admin`, `volunteer`, `Location`). Make sure those tables exist first.

2. **Data Consistency:** The sample data is designed to match the current hardcoded values in `DashboardModel.php` for easy testing.

3. **Real-time Updates:** In production, you'll need to implement:
   - Automated KPI calculation (cron jobs or triggers)
   - Real-time alert generation
   - Automatic team deployment tracking
   - Evacuation counting mechanisms

4. **Performance:** Indexes have been added to frequently queried columns. Monitor query performance as data grows.

5. **Data Validation:** Add application-level validation to ensure data integrity (e.g., percentages between 0-100).

---

## 🎯 Next Steps

1. ✅ Create the tables using `create_dashboard_tables.sql`
2. ✅ Insert sample data using `insert_dashboard_data.sql`
3. ⏳ Update `DashboardModel.php` to fetch from database
4. ⏳ Create admin interfaces to manage dashboard data
5. ⏳ Implement automated KPI calculation
6. ⏳ Add real-time alert generation
7. ⏳ Create APIs for mobile apps (if needed)

---

## 📞 Support

If you encounter any issues:
1. Check that the DRCS database exists
2. Verify all existing tables are created first
3. Check MySQL error logs
4. Ensure proper user permissions

---

**Created:** 2026-05-09  
**Version:** 1.0  
**Author:** Kiro AI Assistant
