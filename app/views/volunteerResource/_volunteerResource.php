<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRCS | Volunteer Resource Manager</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="../views/volunteerResource/volunteerResource.css">

    <!-- Navigation styling block copied & adapted from admin.css for visual unity -->
    <style>
        :root {
            --white: #ffffff;
            --off: #f8f5f2;
            --surface: #f2ede8;
            --red: #c8102e;
            --red-dk: #9b0b21;
            --red-lt: #fbeaec;
            --border: #e2ddd8;
            --muted: #6b6b6b;
            --text: #1a1a1a;
            --font-hd: 'Playfair Display', serif;
            --font-bd: 'Outfit', sans-serif;
            --font-mn: 'JetBrains Mono', monospace;
            --shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        body {
            background: var(--off);
            font-family: var(--font-bd);
            color: var(--text);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        /* Ensure the navbar styles are contained and premium */
        nav {
            background: rgba(255,255,255,0.96);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            width: 100%;
            box-sizing: border-box;
            z-index: 100;
            backdrop-filter: blur(12px);
            box-shadow: var(--shadow);
            font-family: var(--font-bd);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: inherit;
        }

        .logo-icon {
            width: 38px;
            height: 38px;
            background: var(--red);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon svg {
            width: 22px;
            fill: #fff;
        }

        .brand-text {
            font-family: var(--font-hd);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text);
        }

        .brand-text em {
            color: var(--red);
            font-style: normal;
        }

        .nav-center {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-tabs {
            display: flex;
            gap: 0.25rem;
            background: var(--surface);
            padding: 0.25rem;
            border-radius: 48px;
        }

        .tab-btn {
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            border: none;
            background: transparent;
            font-family: var(--font-bd);
            font-weight: 500;
            font-size: 0.8rem;
            cursor: pointer;
            transition: 0.2s;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .tab-btn.active {
            background: var(--white);
            color: var(--red);
            box-shadow: var(--shadow);
        }

        .nav-right {
            display: flex;
            gap: 0.8rem;
        }

        .logout-btn {
            background: transparent;
            border: 1.5px solid var(--border);
            padding: 0.4rem 1rem;
            border-radius: 40px;
            cursor: pointer;
            font-size: 0.75rem;
            font-family: var(--font-bd);
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: var(--surface);
        }

        /* ========= TICKER / ALERT BAR ========= */
        .ticker-wrap {
            background: var(--red);
            overflow: hidden;
            white-space: nowrap;
            padding: .4rem 0;
            margin-top: 0; /* Flush under sticky navbar */
            width: 100%;
        }

        .ticker {
            display: inline-block;
            animation: ticker-scroll 32s linear infinite;
            font-family: var(--font-mn);
            font-size: .9rem;
            color: #fff;
            letter-spacing: .03em;
        }

        @keyframes ticker-scroll {
            from {
                transform: translateX(100vw);
            }
            to {
                transform: translateX(-100%);
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Bar (styled like admin panel) -->
    <nav>
        <a class="nav-brand" href="../../public/index.php">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 15h-2v-2h2zm0-4h-2V7h2z"/>
                </svg>
            </div>
            <span class="brand-text">DR<em>CS</em> | VOLUNTEER</span>
        </a>

        <div class="nav-center">
            <div class="nav-tabs">
                <button class="tab-btn" onclick="window.location.href='volunteer.php'"><i class="fa-solid fa-list-check"></i> Tasks</button>
                <button class="tab-btn active" onclick="window.location.href='volunteerResource.php'"><i class="fa-solid fa-boxes-stacked"></i> Resource</button>
            </div>
        </div>

        <div class="nav-right">
            <button class="logout-btn" onclick="window.location.href='logout.php'"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
        </div>
    </nav>
    <div class="ticker-wrap">
        <div class="ticker">
            ⚠️ WARNING – Landslide Risk: Ratnapura District &nbsp;&nbsp;|&nbsp;&nbsp; ✅ RESOLVED – Cyclone Watch lifted: Eastern Coast &nbsp;&nbsp;|&nbsp;&nbsp; 🚨 ACTIVE – Search & Rescue teams deployed: Galle
        </div>
    </div>

    <!-- Main Container -->
    <div class="rm_header" style="margin-top: 20px;">Resource Manager</div>

    <!-- Dashboard stats -->
    <div class="rm_dashboard-wrapper">
        <div class="rm_card">
            <h1 id="stat-total">0</h1>
            <p>Total Resources</p>
        </div>
        <div class="rm_card">
            <h1 id="stat-ok">0</h1>
            <p>Stocked</p>
        </div>
        <div class="rm_card">
            <h1 id="stat-low">0</h1>
            <p>Running Low</p>
        </div>
        <div class="rm_card">
            <h1 id="stat-out">0</h1>
            <p>Out of Stock</p>
        </div>
    </div>

    <!-- Main Table and search box -->
    <div class="rm_main-box">
        <div class="rm_row" style="justify-content: space-between; align-items: center;">
            <div class="rm_row" style="gap: 10px; margin-bottom: 0;">
                <input type="text" id="searchInput" placeholder="Search resources..." onkeyup="renderTable()">
                <select id="typeFilter" onchange="renderTable()">
                    <option value="">All Types</option>
                </select>
                <select id="statusFilter" onchange="renderTable()">
                    <option value="">All Statuses</option>
                    <option value="Stocked">Stocked</option>
                    <option value="Running Low">Running Low</option>
                    <option value="Out of Stock">Out of Stock</option>
                </select>
            </div>
            <button class="rm_btn-red" onclick="openModal()">+ Add Resource</button>
        </div>

        <table style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>Resource Name</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Rendered by JS -->
            </tbody>
        </table>
    </div>

    <!-- Type Management elements (minimally rendered / hidden, needed for JS script structure) -->
    <div style="display:none;">
        <input type="text" id="newTypeInput">
        <div id="typeList"></div>
        <form id="addTypeForm" method="POST" action="volunteerResource.php">
            <input type="hidden" id="typeNameInput" name="typeNameInput">
        </form>
        <form id="deleteTypeForm" method="POST" action="volunteerResource.php">
            <input type="hidden" id="deleteTypeId" name="deleteTypeId">
        </form>
    </div>

    <!-- Edit/Add Modal -->
    <div class="rm_modal-backdrop" id="modalBackdrop" onclick="handleBackdropClick(event)">
        <div class="rm_modal">
            <div class="rm_modal-header">
                <h3 id="modalTitle">Add Resource</h3>
                <button onclick="closeModal()" style="border:none; background:none; font-size:1.5rem; cursor:pointer;">&times;</button>
            </div>
            <div class="rm_modal-body">
                <div class="rm_form-group">
                    <label for="fName">Resource Name *</label>
                    <input type="text" id="fName" style="width: 100%; box-sizing: border-box;">
                </div>
                <div class="rm_form-row">
                    <div class="rm_form-group">
                        <label for="fType">Type *</label>
                        <select id="fType" style="width: 100%; box-sizing: border-box;">
                            <option value="">Select Type</option>
                        </select>
                    </div>
                    <div class="rm_form-group">
                        <label for="fUnit">Unit *</label>
                        <input type="text" id="fUnit" style="width: 100%; box-sizing: border-box;" value="Units">
                    </div>
                </div>
                <div class="rm_form-row">
                    <div class="rm_form-group">
                        <label for="fQty">Quantity *</label>
                        <input type="number" id="fQty" style="width: 100%; box-sizing: border-box;" min="0">
                    </div>
                    <div class="rm_form-group">
                        <label for="fMax">Max Threshold</label>
                        <input type="number" id="fMax" style="width: 100%; box-sizing: border-box;" min="0" value="0">
                    </div>
                </div>
                <div class="rm_form-group">
                    <label for="fNotes">Description / Notes</label>
                    <textarea id="fNotes" style="width: 100%; box-sizing: border-box;"></textarea>
                </div>
            </div>
            <div class="rm_modal-footer">
                <button class="rm_btn-white" onclick="closeModal()">Cancel</button>
                <button class="rm_btn-red" onclick="saveResource()">Save</button>
            </div>
        </div>
    </div>

    <!-- Hidden Forms for JS Actions -->
    <form id="resourceForm" method="POST" action="volunteerResource.php" style="display:none;">
        <input type="hidden" id="actionType" name="actionType">
        <input type="hidden" id="resourceId" name="resourceId">
        <input type="hidden" id="resourceName" name="resourceName">
        <input type="hidden" id="resourceTypeId" name="resourceTypeId">
        <input type="hidden" id="resourceUnit" name="resourceUnit">
        <input type="hidden" id="resourceCount" name="resourceCount">
        <input type="hidden" id="resourceMax" name="resourceMax">
        <input type="hidden" id="descriptionInput" name="descriptionInput">
    </form>

    <form id="deleteForm" method="POST" action="volunteerResource.php" style="display:none;">
        <input type="hidden" id="deleteResourceId" name="deleteResourceId">
    </form>

    <!-- Toast element -->
    <div class="rm_toast" id="toast"></div>

    <!-- Inject data into JavaScript from PHP Controller -->
    <script>
        const resources = <?php echo json_encode($resourcesList); ?>;
        const resourceTypes = <?php echo json_encode($resourceTypes); ?>;
        const flashMessage = <?php echo json_encode($flashMessage); ?>;
    </script>

    <!-- JS Logic -->
    <script src="../views/volunteerResource/volunteerResource.js"></script>
</body>
</html>
