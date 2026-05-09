/**
 * Static Data Configuration for Disaster Response System
 * Contains ONLY reference data used in homepage and forms
 */

const StaticData = {
    // Disaster Types (used in Request forms and dashboard)
    disasterTypes: [
        { id: 'tornado', label: 'Tornado', icon: '🌪️', color: '#8B4513' },
        { id: 'tsunami', label: 'Tsunami', icon: '🌊', color: '#1E90FF' },
        { id: 'landslide', label: 'Landslide', icon: '⛰️', color: '#A0522D' },
        { id: 'flood', label: 'Flood', icon: '💧', color: '#4682B4' },
        { id: 'other', label: 'Other', icon: '⚠️', color: '#808080' }
    ],

    // Resource Types (used in Request and Resource forms)
    resourceTypes: [
        { id: 'medical', label: 'Medical', icon: '💊' },
        { id: 'food', label: 'Food', icon: '🍲' },
        { id: 'shelter', label: 'Shelter', icon: '⛺' },
        { id: 'clothing', label: 'Clothing', icon: '👕' },
        { id: 'money', label: 'Money', icon: '💰' }
    ],

    // Priority Levels (used in forms and dashboard)
    priorityLevels: [
        { id: 'low', label: 'Low', color: '#28a745' },
        { id: 'medium', label: 'Medium', color: '#ffc107' },
        { id: 'high', label: 'High', color: '#dc3545' }
    ],

    // Severity Levels (used in incidents)
    severityLevels: [
        { id: 'low', label: 'Low', color: '#28a745' },
        { id: 'medium', label: 'Medium', color: '#ffc107' },
        { id: 'high', label: 'High', color: '#fd7e14' },
        { id: 'critical', label: 'Critical', color: '#dc3545' }
    ],

    // User Roles (used in signup)
    userRoles: [
        { id: 'admin', label: 'Admin' },
        { id: 'affected_people', label: 'Affected People' },
        { id: 'volunteer', label: 'Volunteer' }
    ],

    // Status Types (used in dashboard and forms)
    statusTypes: {
        request: [
            { id: 'pending', label: 'Pending', color: '#6c757d' },
            { id: 'assigned', label: 'Assigned', color: '#007bff' },
            { id: 'completed', label: 'Completed', color: '#28a745' }
        ],
        assignment: [
            { id: 'assigned', label: 'Assigned', color: '#007bff' },
            { id: 'in_progress', label: 'In Progress', color: '#ffc107' },
            { id: 'completed', label: 'Completed', color: '#28a745' }
        ],
        incident: [
            { id: 'active', label: 'Active', color: '#dc3545' },
            { id: 'resolved', label: 'Resolved', color: '#28a745' }
        ],
        volunteer: [
            { id: 'available', label: 'Available', color: '#28a745' },
            { id: 'busy', label: 'Busy', color: '#ffc107' }
        ]
    },

    // Sri Lankan Districts (used in forms)
    districts: [
        'Ampara', 'Anuradhapura', 'Badulla', 'Batticaloa', 'Colombo',
        'Galle', 'Gampaha', 'Hambantota', 'Jaffna', 'Kalutara',
        'Kandy', 'Kegalle', 'Kilinochchi', 'Kurunegala', 'Mannar',
        'Matale', 'Matara', 'Monaragala', 'Mullaitivu', 'Nuwara Eliya',
        'Polonnaruwa', 'Puttalam', 'Ratnapura', 'Trincomalee', 'Vavuniya'
    ],

    // Emergency Contacts (used in modal)
    emergencyContacts: [
        { label: '🏥 Ambulance', number: '110' },
        { label: '🚒 Fire & Rescue', number: '111' },
        { label: '👮 Police Emergency', number: '119' },
        { label: '🌊 Disaster Hotline', number: '1919' },
        { label: '☎️ NDMA HQ', number: '0112136136' }
    ],

    // Alert Types (used in dashboard)
    alertTypes: [
        { id: 'critical', label: 'Critical', color: '#dc3545' },
        { id: 'warning', label: 'Warning', color: '#ffc107' },
        { id: 'info', label: 'Info', color: '#17a2b8' }
    ],

    // KPI Colors (used in dashboard cards)
    kpiColors: {
        red: { bg: '#fee', border: '#fcc', text: '#c00' },
        amber: { bg: '#fff4e6', border: '#ffe0b2', text: '#e65100' },
        green: { bg: '#e8f5e9', border: '#c8e6c9', text: '#2e7d32' },
        blue: { bg: '#e3f2fd', border: '#bbdefb', text: '#1565c0' }
    }
};

// Helper Functions
const StaticDataHelpers = {
    /**
     * Get disaster type by ID
     */
    getDisasterType(id) {
        return StaticData.disasterTypes.find(d => d.id === id);
    },

    /**
     * Get resource type by ID
     */
    getResourceType(id) {
        return StaticData.resourceTypes.find(r => r.id === id);
    },

    /**
     * Get priority level by ID
     */
    getPriorityLevel(id) {
        return StaticData.priorityLevels.find(p => p.id === id);
    },

    /**
     * Get severity level by ID
     */
    getSeverityLevel(id) {
        return StaticData.severityLevels.find(s => s.id === id);
    },

    /**
     * Get status by type and ID
     */
    getStatus(type, id) {
        return StaticData.statusTypes[type]?.find(s => s.id === id);
    },

    /**
     * Get disaster icon
     */
    getDisasterIcon(type) {
        const disaster = this.getDisasterType(type);
        return disaster ? disaster.icon : '⚠️';
    },

    /**
     * Get resource icon
     */
    getResourceIcon(type) {
        const resource = this.getResourceType(type);
        return resource ? resource.icon : '📦';
    },

    /**
     * Get priority color
     */
    getPriorityColor(priority) {
        const level = this.getPriorityLevel(priority);
        return level ? level.color : '#6c757d';
    },

    /**
     * Generate district options for select/datalist
     */
    getDistrictOptions() {
        return StaticData.districts.map(d => `<option value="${d}">${d}</option>`).join('');
    },

    /**
     * Generate resource type options
     */
    getResourceTypeOptions() {
        return StaticData.resourceTypes.map(r => 
            `<option value="${r.id}">${r.icon} ${r.label}</option>`
        ).join('');
    }
};

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { StaticData, StaticDataHelpers };
}
