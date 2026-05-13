<?php
require_once '../../config/config.php';

// JOIN with users to show who each location belongs to
$sql    = "SELECT l.loc_id, l.user_id, u.username, u.user_role,
                  l.district, l.city, l.street, l.home_no,
                  l.latitude, l.longitude
           FROM Location l
           LEFT JOIN users u ON l.user_id = u.user_id
           ORDER BY l.loc_id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations · DRCS Admin</title>
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

        .table-wrapper { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        th { text-align: left; padding: 1rem 1.2rem; background: var(--off); font-family: var(--font-mn); font-size: 0.7rem; color: var(--muted); border-bottom: 1px solid var(--border); }
        td { padding: 0.9rem 1.2rem; border-bottom: 1px solid var(--border); vertical-align: middle; }

        .badge { display: inline-block; padding: 0.2rem 0.7rem; border-radius: 30px; font-size: 0.7rem; font-weight: 600; }
        .badge-admin           { background: #fce7f3; color: #be185d; }
        .badge-volunteer       { background: #e8eef5; color: #1e3a5f; }
        .badge-affected_people { background: #f1f0f0; color: #4b5563; }

        .coords { font-family: var(--font-mn); font-size: 0.72rem; color: var(--muted); }

        @media (max-width: 800px) {
            .admin-nav { flex-wrap: wrap; height: auto; padding: 0.8rem; gap: 0.8rem; }
        }
    </style>
</head>
<body>

<div class="admin-nav">
    <div class="nav-brand">
        <div class="logo-icon"><svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 15h-2v-2h2zm0-4h-2V7h2z"/></svg></div>
        <span class="brand-text">DR<em>CS</em> · ADMIN</span>
        <span class="admin-badge">📍 Locations</span>
    </div>
    <button class="back-btn" onclick="window.location.href='admin.php'">← Back to Admin</button>
</div>

<div class="admin-container">
    <div class="section-header">
        <h2>📍 Locations</h2>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Loc ID</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>District</th>
                    <th>City</th>
                    <th>Street</th>
                    <th>Home No</th>
                    <th>Coordinates</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                            $role       = $row['user_role'] ?? '';
                            $badgeClass = match($role) {
                                'admin'           => 'badge-admin',
                                'volunteer'       => 'badge-volunteer',
                                'affected_people' => 'badge-affected_people',
                                default           => 'badge-volunteer',
                            };
                            // Format coordinates to 6 decimal places for readability
                            $lat = $row['latitude']  !== null ? number_format((float)$row['latitude'],  6) : '—';
                            $lng = $row['longitude'] !== null ? number_format((float)$row['longitude'], 6) : '—';
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['loc_id'],              ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['username']   ?? '—',   ENT_QUOTES); ?></td>
                            <td>
                                <?php if ($role): ?>
                                    <span class="badge <?php echo $badgeClass; ?>">
                                        <?php echo htmlspecialchars($role, ENT_QUOTES); ?>
                                    </span>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['district']   ?? '—',   ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['city']       ?? '—',   ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['street']     ?? '—',   ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['home_no']    ?? '—',   ENT_QUOTES); ?></td>
                            <td class="coords"><?php echo $lat; ?>, <?php echo $lng; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8" style="text-align:center; color:var(--muted);">No locations found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
