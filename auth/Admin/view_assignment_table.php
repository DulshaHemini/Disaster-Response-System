<?php
require_once '../../config/config.php';

// Retrieve assignments
$sql = "SELECT * FROM assignment";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Assignments</title>

    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f6f9;
    margin: 0;
    padding: 20px;
}

/* Title */
h2 {
    text-align: center;
    color: #333;
}

/* Table styling */
table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* Table header */
th {
    background-color: #007bff;
    color: white;
    padding: 12px;
    text-transform: uppercase;
    font-size: 14px;
}

/* Table rows */
td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

/* Zebra striping */
tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Hover effect */
tr:hover {
    background-color: #f1f1f1;
}

/* Remove button */
button.removeBtn {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 8px 14px;
    cursor: pointer;
    border-radius: 5px;
    transition: 0.3s;
}

/* Button hover */
button.removeBtn:hover {
    background-color: #c82333;
}

/* Responsive */
@media (max-width: 768px) {
    table {
        width: 100%;
    }

    th, td {
        font-size: 12px;
        padding: 8px;
    }

    button.removeBtn {
        padding: 6px 10px;
    }
}
</style>

</head>
<body>

<h2>Assignment Table</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Assignment Date</th>
        <th>Assignment ID</th>
        <th>Request ID</th>
        <th>Resource ID</th>
        <th>Volunteer ID</th>
        <th>Description</th>
        <th>Status</th>
    </tr>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
    <tr>
        <td><?php echo $row['assigned_date']; ?></td>
        <td><?php echo $row['assignment_id']; ?></td>
        <td><?php echo $row['req_id']; ?></td>
        <td><?php echo $row['resource_id']; ?></td>
        <td><?php echo $row['volunteer_id']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td><?php echo $row['status']; ?></td>
    </tr>
<?php
    }
} else {
    echo "<tr><td colspan='7'>No assignments found</td></tr>";
}
?>

</table>

</body>
</html>