<?php
// Get person details by ID
define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH);

require_once APP_PATH . '/models/TrackerModel.php';
require_once dirname(BASE_PATH) . '/config/config.php';

// Initialize model with global connection
$model = new TrackerModel($conn);

// Get person ID from URL
$person_id = '';
if (isset($_GET['id'])) {
    $person_id = $_GET['id'];
}

if (empty($person_id)) {
    echo 'Error: No person ID provided';
    exit;
}

// Get person from database
$person = $model->getPersonById($person_id);

if (!$person) {
    echo 'Error: Person not found';
    exit;
}

// Get activity logs for this person
$logs = $model->getLogsByPerson($person_id);
$logs_count = count($logs);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Person Details</title>
</head>
<body>
    <div id="person-data" style="display:none;">
        <div class="person-info">
            <span class="data-id"><?php echo $person['id']; ?></span>
            <span class="data-name"><?php echo $person['full_name']; ?></span>
            <span class="data-age"><?php echo $person['age']; ?></span>
            <span class="data-gender"><?php echo $person['gender']; ?></span>
            <span class="data-location"><?php echo $person['location_name']; ?></span>
            <span class="data-district"><?php echo $person['district']; ?></span>
            <span class="data-lat"><?php echo $person['latitude']; ?></span>
            <span class="data-lng"><?php echo $person['longitude']; ?></span>
            <span class="data-disaster"><?php echo $person['disaster_type']; ?></span>
            <span class="data-status"><?php echo $person['status']; ?></span>
            <span class="data-created"><?php echo $person['created_at']; ?></span>
            <span class="data-injury"><?php echo isset($person['injury_status']) ? $person['injury_status'] : 'Not specified'; ?></span>
            <span class="data-family"><?php echo isset($person['family_count']) ? $person['family_count'] : 0; ?></span>
            <span class="data-contact"><?php echo isset($person['contact']) ? $person['contact'] : 'Not available'; ?></span>
        </div>
        
        <div class="logs-info">
            <span class="logs-count"><?php echo $logs_count; ?></span>
            <?php foreach ($logs as $log) { ?>
            <div class="log-item">
                <span class="log-id"><?php echo $log['id']; ?></span>
                <span class="log-person-id"><?php echo $log['person_id']; ?></span>
                <span class="log-type"><?php echo $log['log_type']; ?></span>
                <span class="log-message"><?php echo $log['message']; ?></span>
                <span class="log-created-by"><?php echo $log['created_by']; ?></span>
                <span class="log-created-at"><?php echo $log['created_at']; ?></span>
            </div>
            <?php } ?>
        </div>
    </div>
    
    <script>
        // Simple way to send data back
        var personData = {
            id: <?php echo $person['id']; ?>,
            full_name: "<?php echo str_replace('"', '\\"', $person['full_name']); ?>",
            age: <?php echo $person['age']; ?>,
            gender: "<?php echo $person['gender']; ?>",
            location_name: "<?php echo str_replace('"', '\\"', $person['location_name']); ?>",
            district: "<?php echo str_replace('"', '\\"', $person['district']); ?>",
            latitude: <?php echo $person['latitude']; ?>,
            longitude: <?php echo $person['longitude']; ?>,
            disaster_type: "<?php echo str_replace('"', '\\"', $person['disaster_type']); ?>",
            status: "<?php echo $person['status']; ?>",
            created_at: "<?php echo $person['created_at']; ?>",
            injury_status: "<?php echo isset($person['injury_status']) ? str_replace('"', '\\"', $person['injury_status']) : 'Not specified'; ?>",
            family_count: <?php echo isset($person['family_count']) ? $person['family_count'] : 0; ?>,
            contact: "<?php echo isset($person['contact']) ? str_replace('"', '\\"', $person['contact']) : 'Not available'; ?>"
        };
        
        var logsData = [
            <?php
            $first = true;
            foreach ($logs as $log) {
                if (!$first) echo ',';
                echo '{';
                echo 'id:' . $log['id'] . ',';
                echo 'person_id:' . $log['person_id'] . ',';
                echo 'log_type:"' . str_replace('"', '\\"', $log['log_type']) . '",';
                echo 'message:"' . str_replace('"', '\\"', $log['message']) . '",';
                echo 'created_by:"' . str_replace('"', '\\"', $log['created_by']) . '",';
                echo 'created_at:"' . $log['created_at'] . '"';
                echo '}';
                $first = false;
            }
            ?>
        ];
        
        var logsCount = <?php echo $logs_count; ?>;
        
        // Send to parent window
        if (window.opener) {
            window.opener.receivePersonData(personData, logsData, logsCount);
            window.close();
        }
    </script>
</body>
</html>
