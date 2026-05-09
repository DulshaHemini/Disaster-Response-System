/**
 * Static Data Configuration for Disaster Response System
 * Contains reference data matching database ENUMs
 */

const StaticData = {
    // Disaster Types (matches Request.req_type ENUM)
    disasterTypes: [
        { id: 'tornadoes', label: 'Tornadoes', icon: '🌪️', color: '#8B4513' },
        { id: 'tsunamis', label: 'Tsunamis', icon: '🌊', color: '#1E90FF' },
        { id: 'landslides', label: 'Landslides', icon: '⛰️', color: '#A0522D' },
        { id: 'avalanches', label: 'Avalanches', icon: '❄️', color: '#B0E0E6' },
        { id: 'heat waves', label: 'Heat Waves', icon: '🔥', color: '#FF4500' }
    ],

    // Resource Types (matches Request.resource_type and resource.resource_type ENUMs)
    resourceTypes: [
        { id: 'Medicins', label: 'Medicines', icon: '💊' },
        { id: 'Foods', label: 'Foods', icon: '🍲' },
        { id: 'Shelters', label: 'Shelters', icon: '⛺' },
        { id: 'Clothes', label: 'Clothes', icon: '👕' },
        { id: 'Money', label: 'Money', icon: '💰' }
    ],

    // Resource Types for resource table (slightly different spelling)
    resourceTypesAlt: [
        { id: 'Medicals', label: 'Medicals', icon: '💊' },
        { id: 'Foods', label: 'Foods', icon: '🍲' },
        { id: 'Shelters', label: 'Shelters', icon: '⛺' },
        { id: 'Cloths', label: 'Cloths', icon: '👕' },
        { id: 'Money', label: 'Money', icon: '💰' }
    ],

    // Priority Levels (matches priority_level ENUM)
    priorityLevels: [
        { id: 'low', label: 'Low', color: '#28a745', badge: 'success' },
        { id: 'medium', label: 'Medium', color: '#ffc107', badge: 'warning' },
        { id: 'high', label: 'High', color: '#dc3545', badge: 'danger' }
    ],

    // Request Status (matches Request.status)
    requestStatus: [
        { id: 'Pending', label: 'Pending', color: '#6c757d' },
        { id: 'Approved', label: 'Approved', color: '#007bff' },
        { id: 'Assigned', label: 'Assigned', color: '#17a2b8' },
        { id: 'In Progress', label: 'In Progress', color: '#ffc107' },
        { id: 'Completed', label: 'Completed', color: '#28a745' },
        { id: 'Rejected', label: 'Rejected', color: '#dc3545' }
    ],

    // Assignment Status (matches assignment.status ENUM)
    assignmentStatus: [
        { id: 'Assigned', label: 'Assigned', color: '#007bff' },
        { id: 'Allocated', label: 'Allocated', color: '#ffc107' },
        { id: 'Received', label: 'Received', color: '#28a745' }
    ],

    // Volunteer Availability (matches volunteer.availability_status ENUM)
    volunteerStatus: [
        { id: 'available', label: 'Available', color: '#28a745' },
        { id: 'busy', label: 'Busy', color: '#ffc107' }
    ],

    // Gender Options (matches gender ENUM)
    genderOptions: [
        { id: 'Male', label: 'Male' },
        { id: 'Female', label: 'Female' }
    ],

    // User Roles (matches users.user_role ENUM)
    userRoles: [
        { id: 'admin', label: 'Administrator', icon: '👨‍💼' },
        { id: 'affected_people', label: 'Affected Person', icon: '🆘' },
        { id: 'volunteer', label: 'Volunteer', icon: '🤝' }
    ],

    // Sri Lankan Districts
    districts: [
        'Ampara', 'Anuradhapura', 'Badulla', 'Batticaloa', 'Colombo',
        'Galle', 'Gampaha', 'Hambantota', 'Jaffna', 'Kalutara',
        'Kandy', 'Kegalle', 'Kilinochchi', 'Kurunegala', 'Mannar',
        'Matale', 'Matara', 'Monaragala', 'Mullaitivu', 'Nuwara Eliya',
        'Polonnaruwa', 'Puttalam', 'Ratnapura', 'Trincomalee', 'Vavuniya'
    ],

    // Emergency Contacts
    emergencyContacts: [
        { label: '🏥 Ambulance', number: '110' },
        { label: '🚒 Fire & Rescue', number: '111' },
        { label: '👮 Police Emergency', number: '119' },
        { label: '🌊 Disaster Hotline', number: '1919' },
        { label: '☎️ NDMA HQ', number: '0112136136' }
    ],

    // Alert Types (for dashboard)
    alertTypes: [
        { id: 'critical', label: 'Critical', color: '#dc3545' },
        { id: 'warning', label: 'Warning', color: '#ffc107' },
        { id: 'info', label: 'Info', color: '#17a2b8' }
    ],

    // KPI Colors (for dashboard cards)
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
     * Get resource type by ID (for Request table)
     */
    getResourceType(id) {
        return StaticData.resourceTypes.find(r => r.id === id);
    },

    /**
     * Get resource type by ID (for resource table - alternative spelling)
     */
    getResourceTypeAlt(id) {
        return StaticData.resourceTypesAlt.find(r => r.id === id);
    },

    /**
     * Get priority level by ID
     */
    getPriorityLevel(id) {
        return StaticData.priorityLevels.find(p => p.id === id);
    },

    /**
     * Get request status by ID
     */
    getRequestStatus(id) {
        return StaticData.requestStatus.find(s => s.id === id);
    },

    /**
     * Get assignment status by ID
     */
    getAssignmentStatus(id) {
        return StaticData.assignmentStatus.find(s => s.id === id);
    },

    /**
     * Get volunteer status by ID
     */
    getVolunteerStatus(id) {
        return StaticData.volunteerStatus.find(s => s.id === id);
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
     * Get priority badge HTML
     */
    getPriorityBadge(priority) {
        const level = this.getPriorityLevel(priority);
        if (!level) return '';
        return `<span class="badge badge-${level.badge}">${level.label}</span>`;
    },

    /**
     * Get status badge HTML
     */
    getStatusBadge(status, type = 'request') {
        let statusObj;
        if (type === 'request') {
            statusObj = this.getRequestStatus(status);
        } else if (type === 'assignment') {
            statusObj = this.getAssignmentStatus(status);
        } else if (type === 'volunteer') {
            statusObj = this.getVolunteerStatus(status);
        }
        
        if (!statusObj) return '';
        return `<span class="badge" style="background-color: ${statusObj.color}; color: white;">${statusObj.label}</span>`;
    },

    /**
     * Generate district options for HTML select/datalist
     */
    getDistrictOptions() {
        return StaticData.districts.map(d => `<option value="${d}">${d}</option>`).join('');
    },

    /**
     * Generate disaster type options
     */
    getDisasterTypeOptions() {
        return StaticData.disasterTypes.map(d => 
            `<option value="${d.id}">${d.icon} ${d.label}</option>`
        ).join('');
    },

    /**
     * Generate resource type options (for Request form)
     */
    getResourceTypeOptions() {
        return StaticData.resourceTypes.map(r => 
            `<option value="${r.id}">${r.icon} ${r.label}</option>`
        ).join('');
    },

    /**
     * Generate resource type options (for resource form - alternative)
     */
    getResourceTypeOptionsAlt() {
        return StaticData.resourceTypesAlt.map(r => 
            `<option value="${r.id}">${r.icon} ${r.label}</option>`
        ).join('');
    },

    /**
     * Generate priority level options
     */
    getPriorityOptions() {
        return StaticData.priorityLevels.map(p => 
            `<option value="${p.id}">${p.label}</option>`
        ).join('');
    },

    /**
     * Generate gender options
     */
    getGenderOptions() {
        return StaticData.genderOptions.map(g => 
            `<option value="${g.id}">${g.label}</option>`
        ).join('');
    },

    /**
     * Generate user role options
     */
    getUserRoleOptions() {
        return StaticData.userRoles.map(r => 
            `<option value="${r.id}">${r.icon} ${r.label}</option>`
        ).join('');
    },

    /**
     * Format resource with icon
     */
    formatResource(type, count) {
        const resource = this.getResourceType(type);
        if (!resource) return `${count}`;
        return `${resource.icon} ${count} ${resource.label}`;
    }
};

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { StaticData, StaticDataHelpers };
}
