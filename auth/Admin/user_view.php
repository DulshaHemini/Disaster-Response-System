<?php
require_once '../../config/config.php';

$embedded  = defined('USER_VIEW_EMBEDDED');
$dataOnly  = defined('USER_VIEW_DATA_ONLY');

// Handle delete request (standalone mode only — embedded uses admin.php AJAX)
if (!$embedded && isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully'); window.location.href='" . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES) . "';</script>";
    } else {
        echo "Error deleting user";
    }
    $stmt->close();
}

// Retrieve users (volunteers + affected people only)
$view_sql = "SELECT * FROM users WHERE user_role='affected_people' OR user_role='volunteer'";
$result   = $conn->query($view_sql);

// Build row array and compute counts in one pass
$userRows = [];
$volCount = 0;
$affCount = 0;
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $userRows[] = $row;
        if ($row['user_role'] === 'volunteer')           $volCount++;
        elseif ($row['user_role'] === 'affected_people') $affCount++;
    }
}
// If data-only mode, stop here — $userRows, $volCount, $affCount are ready
if ($dataOnly) return;

?>
<?php if (!$embedded): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users · DRCS Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Outfit:wght@300;400;500;600&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --white: #ffffff;
            --off: #f8f5f2;
            --surface: #f2ede8;
            --red: #c8102e;
            --red-dk: #9b0b21;
            --red-lt: #fbeaec;
            --red-m: #f5c0c7;
            --amber: #d97706;
            --green: #15803d;
            --blue: #1d4ed8;
            --slate: #475569;
            --text: #1a1a1a;
            --muted: #6b6b6b;
            --border: #e2ddd8;
            --font-hd: 'Playfair Display', serif;
            --font-bd: 'Outfit', sans-serif;
            --font-mn: 'JetBrains Mono', monospace;
            --shadow: 0 4px 12px rgba(0,0,0,0.05);
            --radius-lg: 20px;
            --radius-md: 14px;
        }

        body { background: var(--off); font-family: var(--font-bd); color: var(--text); overflow-x: hidden; }

        .admin-nav {
            background: rgba(255,255,255,0.96);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(12px);
        }
        .nav-brand { display: flex; align-items: center; gap: 0.75rem; }
        .logo-icon { width: 38px; height: 38px; background: var(--red); border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .logo-icon svg { width: 22px; fill: #fff; }
        .brand-text { font-family: var(--font-hd); font-size: 1.3rem; }
        .brand-text em { color: var(--red); font-style: normal; }
        .admin-badge { background: var(--red-lt); padding: 0.3rem 1rem; border-radius: 40px; font-size: 0.75rem; font-weight: 600; color: var(--red); font-family: var(--font-mn); }
        .back-btn { background: transparent; border: 1.5px solid var(--border); padding: 0.4rem 1rem; border-radius: 40px; cursor: pointer; font-size: 0.75rem; font-family: var(--font-bd); }
        .back-btn:hover { background: var(--surface); }

        .admin-container { max-width: 1400px; margin: 0 auto; padding: 2rem; }

        .section-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 1.5rem; }
        .section-header h2 { font-family: var(--font-hd); font-size: 1.6rem; }

        .stats-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 1.2rem; }
        .stat-card .label { font-size: 0.7rem; text-transform: uppercase; color: var(--muted); }
        .stat-card .value { font-family: var(--font-hd); font-size: 2rem; }

        .table-wrapper { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        th { text-align: left; padding: 1rem 1.2rem; background: var(--off); font-family: var(--font-mn); font-size: 0.7rem; color: var(--muted); border-bottom: 1px solid var(--border); }
        td { padding: 0.9rem 1.2rem; border-bottom: 1px solid var(--border); vertical-align: middle; }

        .badge { display: inline-block; padding: 0.2rem 0.7rem; border-radius: 30px; font-size: 0.7rem; font-weight: 600; }
        .badge-volunteer { background: #e8eef5; color: #1e3a5f; }
        .badge-affected  { background: #f1f0f0; color: #4b5563; }

        .action-btn { background: transparent; border: 1px solid var(--border); border-radius: 30px; padding: 0.3rem 0.8rem; cursor: pointer; font-size: 0.7rem; transition: 0.2s; font-family: var(--font-bd); }
        .action-btn:hover { background: var(--red); color: white; border-color: var(--red); }

        @media (max-width: 800px) {
            .admin-nav { flex-wrap: wrap; height: auto; padding: 0.8rem; gap: 0.8rem; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="admin-nav">
    <div class="nav-brand">
        <div class="logo-icon"><svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 15h-2v-2h2zm0-4h-2V7h2z"/></svg></div>
        <span class="brand-text">DR<em>CS</em> · ADMIN</span>
        <span class="admin-badge">👥 User View</span>
    </div>
    <button class="back-btn" onclick="window.location.href='admin.php'">← Back to Admin</button>
</div>

<div class="admin-container">
    <div class="section-header">
        <h2>👥 User Table</h2>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="label">🤝 Volunteers</div>
            <div class="value"><?php echo $volCount; ?></div>
        </div>
        <div class="stat-card">
            <div class="label">🆘 Affected People</div>
            <div class="value"><?php echo $affCount; ?></div>
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>User Role</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php endif; ?>

<?php foreach ($userRows as $row):
    $uid        = (int) $row['user_id'];
    $username   = htmlspecialchars($row['username'],   ENT_QUOTES);
    $role       = htmlspecialchars($row['user_role'],  ENT_QUOTES);
    $createdAt  = htmlspecialchars($row['created_at'], ENT_QUOTES);
    $badgeClass = $row['user_role'] === 'volunteer' ? 'badge-volunteer' : 'badge-affected';
?>
                <tr id="user-row-<?php echo $uid; ?>">
                    <td><?php echo $uid; ?></td>
                    <td><?php echo $username; ?></td>
                    <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $role; ?></span></td>
                    <td><?php echo $createdAt; ?></td>
                    <td>
                        <?php if ($embedded): ?>
                            <button class="action-btn"
                                onclick="deleteUser(<?php echo $uid; ?>, '<?php echo $username; ?>')">
                                Remove
                            </button>
                        <?php else: ?>
                            <button class="action-btn" data-id="<?php echo $uid; ?>">
                                Remove
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
<?php endforeach; ?>

<?php if (empty($userRows)): ?>
    <tr><td colspan="5" style="text-align:center; color:var(--muted);">No users found</td></tr>
<?php endif; ?>

<?php if (!$embedded): ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.querySelectorAll('.action-btn[data-id]').forEach(button => {
    button.addEventListener('click', function () {
        const userId = this.getAttribute('data-id');
        if (confirm('Do you want to remove this user?')) {
            window.location.href = '?delete_id=' + encodeURIComponent(userId);
        }
    });
});
</script>

</body>
</html>
<?php endif; ?>
