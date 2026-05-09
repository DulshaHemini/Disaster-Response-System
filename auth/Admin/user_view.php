<?php
require_once '../../config/config.php';

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $delete_sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully'); window.location.href='';</script>";
    } else {
        echo "Error deleting user";
    }
}

// Retrieve users
$view_sql = "SELECT * FROM users WHERE user_role='affected_people' OR user_role='volunteer'";
$result = $conn->query($view_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>

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

<h2>User Table</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>User Role</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
    <tr>
        <td><?php echo $row['user_id']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['user_role']; ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td>
            <button class="removeBtn" data-id="<?php echo $row['user_id']; ?>">
                Remove
            </button>
        </td>
    </tr>
<?php
    }
} else {
    echo "<tr><td colspan='5'>No users found</td></tr>";
}
?>

</table>

<script>
// Attach click event to all remove buttons
document.querySelectorAll(".removeBtn").forEach(button => {
    button.addEventListener("click", function() {
        let userId = this.getAttribute("data-id");

        if (confirm("Do you want to remove this user?")) {
            window.location.href = "?delete_id=" + userId;
        }
    });
});
</script>

</body>
</html>