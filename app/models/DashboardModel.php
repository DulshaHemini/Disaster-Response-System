<?php
/**
 * DashboardModel
 * Provides data for the home page dashboard.
 * In a real app these values would come from a database.
 */
class DashboardModel
{
    /** KPI cards shown at the top of the dashboard */
    public function getKpis(): array
    {
        return [
            [
                'color' => 'red',
                'icon'  => '🆘',
                'value' => '18',
                'label' => 'Active Incidents',
                'delta' => '▲ 3 since 6 hours ago',
                'trend' => 'down',
            ],
            [
                'color' => 'amber',
                'icon'  => '⚠️',
                'value' => '7',
                'label' => 'High-Risk Zones',
                'delta' => '▼ 2 since yesterday',
                'trend' => 'up',
            ],
            [
                'color' => 'green',
                'icon'  => '🚁',
                'value' => '142',
                'label' => 'Teams Deployed',
                'delta' => '▲ 12 mobilised today',
                'trend' => 'up',
            ],
            [
                'color' => 'blue',
                'icon'  => '🏥',
                'value' => '3,214',
                'label' => 'People Evacuated',
                'delta' => '▲ 480 in last 24h',
                'trend' => 'up',
            ],
        ];
    }

    /** Live alert feed */
    public function getAlerts(): array
    {
        return [
            ['type' => 'critical', 'text' => 'Flash flood reported – Baddegama, Galle',    'time' => '2 min ago'],
            ['type' => 'warning',  'text' => 'Landslide risk elevated – Ratnapura',         'time' => '14 min ago'],
            ['type' => 'info',     'text' => 'Relief convoy dispatched to Matara',          'time' => '31 min ago'],
            ['type' => 'critical', 'text' => 'Road closure: A2 Highway blocked by debris',  'time' => '52 min ago'],
            ['type' => 'warning',  'text' => 'Shelter capacity at 87% – Kalutara',          'time' => '1h 10m ago'],
            ['type' => 'info',     'text' => 'Medical team air-lifted to Hambantota',       'time' => '2h ago'],
        ];
    }

    /** Object / resource needs at disaster sites */
    public function getNeeds(): array
    {
        return [
            ['icon' => '💧', 'name' => 'Clean Water',    'qty' => '4,200 L', 'status' => 'crit', 'statusText' => '⚠ CRITICAL SHORTAGE', 'cardClass' => 'critical'],
            ['icon' => '🍱', 'name' => 'Food Packs',     'qty' => '1,850',   'status' => 'crit', 'statusText' => '⚠ LOW STOCK',          'cardClass' => 'critical'],
            ['icon' => '🩺', 'name' => 'Medical Kits',   'qty' => '320',     'status' => 'good', 'statusText' => '✓ SUFFICIENT',          'cardClass' => 'ok'],
            ['icon' => '⛺', 'name' => 'Tents / Shelter','qty' => '210',     'status' => 'warn', 'statusText' => '⚠ SHORTAGE',            'cardClass' => 'warn'],
            ['icon' => '👕', 'name' => 'Clothing Sets',  'qty' => '950',     'status' => 'good', 'statusText' => '✓ ADEQUATE',            'cardClass' => 'ok'],
            ['icon' => '🚤', 'name' => 'Rescue Boats',   'qty' => '8',       'status' => 'crit', 'statusText' => '⚠ CRITICAL LOW',        'cardClass' => 'critical'],
            ['icon' => '🔋', 'name' => 'Power Units',    'qty' => '45',      'status' => 'warn', 'statusText' => '⚠ NEEDED',              'cardClass' => 'warn'],
            ['icon' => '📻', 'name' => 'Comm. Radios',   'qty' => '130',     'status' => 'good', 'statusText' => '✓ SUFFICIENT',          'cardClass' => 'ok'],
        ];
    }

    /** Response readiness progress bars */
    public function getReadiness(): array
    {
        return [
            ['label' => 'Southern Province', 'pct' => 82, 'color' => 'red'],
            ['label' => 'Sabaragamuwa',       'pct' => 67, 'color' => 'amber'],
            ['label' => 'Western Province',   'pct' => 91, 'color' => 'green'],
            ['label' => 'Eastern Province',   'pct' => 58, 'color' => 'blue'],
        ];
    }

    /** Disaster type breakdown bar chart */
    public function getDisasterTypes(): array
    {
        return [
            ['label' => 'Flooding',   'pct' => 74, 'color' => 'var(--blue)'],
            ['label' => 'Landslides', 'pct' => 52, 'color' => 'var(--amber)'],
            ['label' => 'Cyclones',   'pct' => 31, 'color' => 'var(--red)'],
            ['label' => 'Droughts',   'pct' => 22, 'color' => 'var(--green)'],
            ['label' => 'Other',      'pct' => 14, 'color' => '#aaa'],
        ];
    }

    /** Resource allocation progress bars */
    public function getResourceAllocation(): array
    {
        return [
            ['label' => 'Rescue Personnel', 'detail' => '1,840 / 2,200', 'pct' => 84, 'color' => 'red'],
            ['label' => 'Vehicles Deployed','detail' => '280 / 400',     'pct' => 70, 'color' => 'amber'],
            ['label' => 'Shelter Capacity', 'detail' => '9,200 / 12,000','pct' => 77, 'color' => 'green'],
            ['label' => 'Medical Units',    'detail' => '46 / 60',       'pct' => 77, 'color' => 'blue'],
        ];
    }

    /** Average response times bar chart */
    public function getResponseTimes(): array
    {
        return [
            ['label' => 'Urban Tier 1', 'pct' => 25, 'color' => 'var(--green)', 'val' => '12 min'],
            ['label' => 'Urban Tier 2', 'pct' => 46, 'color' => 'var(--blue)',  'val' => '22 min'],
            ['label' => 'Semi-Rural',   'pct' => 68, 'color' => 'var(--amber)', 'val' => '34 min'],
            ['label' => 'Remote',       'pct' => 88, 'color' => 'var(--red)',   'val' => '58 min'],
        ];
    }

    /** Hero statistics row */
    public function getHeroStats(): array
    {
        return [
            ['num' => '24', 'suffix' => '/7',       'label' => 'MONITORING'],
            ['num' => '142','suffix' => '+',         'label' => 'RESPONSE TEAMS'],
            ['num' => '9',  'suffix' => ' Districts','label' => 'ACTIVE ZONES'],
            ['num' => '3.2','suffix' => 'k',         'label' => 'PEOPLE ASSISTED'],
        ];
    }

    /** Emergency contact numbers for the instant-help modal */
    public function getEmergencyContacts(): array
    {
        return [
            ['label' => '🏥 Ambulance',       'number' => '110'],
            ['label' => '🚒 Fire & Rescue',   'number' => '111'],
            ['label' => '👮 Police Emergency', 'number' => '119'],
            ['label' => '🌊 Disaster Hotline', 'number' => '1919'],
            ['label' => '☎️ NDMA HQ',          'number' => '0112136136'],
        ];
    }
}
