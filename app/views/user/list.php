<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
</head>
<body>

<h2>User List</h2>

<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <?php echo $user['name'] . " - " . $user['role']; ?>
        </li>
    <?php endforeach; ?>
</ul>

</body>
</html>