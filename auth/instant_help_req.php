<?php
require_once '../config/config.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $full_name = trim($_POST['full_name'] ?? '');
    $req_name = trim($_POST['req_name'] ?? '');
    $resource_type = $_POST['resource_type'] ?? '';
    $resource_count = intval($_POST['resource_count'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $contact_number = trim($_POST['contact_number'] ?? '');
    
    // Location data
    $latitude = floatval($_POST['latitude'] ?? 0);
    $longitude = floatval($_POST['longitude'] ?? 0);
    $district = trim($_POST['district'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $street = trim($_POST['street'] ?? '');
    $home_no = trim($_POST['home_no'] ?? '');
    
    // Validate required fields
    if (empty($full_name) || empty($req_name) || empty($resource_type) || empty($contact_number)) {
        $error = 'Please fill in all required fields.';
    } else {
        // Start transaction
        $conn->begin_transaction();
        
        try {
            // 1. Insert into requests table first
            $stmt = $conn->prepare("INSERT INTO requests (request_type) VALUES ('Instant_Request')");
            $stmt->execute();
            $request_id = $conn->insert_id;
            $stmt->close();
            
            // 2. Insert location (optional - can be null for user_id)
            $loc_id = null;
            if (!empty($district) || !empty($city) || $latitude != 0 || $longitude != 0) {
                $stmt = $conn->prepare(
                    "INSERT INTO Location (user_id, latitude, longitude, district, city, street, home_no) 
                     VALUES (NULL, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->bind_param("ddssss", $latitude, $longitude, $district, $city, $street, $home_no);
                $stmt->execute();
                $loc_id = $conn->insert_id;
                $stmt->close();
            }
            
            // 3. Insert into Instant_Request table
            $stmt = $conn->prepare(
                "INSERT INTO Instant_Request 
                (req_id, user_id, loc_id, full_name, req_name, resource_type, resource_count, description, contact_number, status) 
                VALUES (?, NULL, ?, ?, ?, ?, ?, ?, ?, 'Pending')"
            );
            $stmt->bind_param("iisssiss", $request_id, $loc_id, $full_name, $req_name, $resource_type, $resource_count, $description, $contact_number);
            $stmt->execute();
            $stmt->close();
            
            // Commit transaction
            $conn->commit();
            $success = true;
            
        } catch (Exception $e) {
            // Rollback on error
            $conn->rollback();
            $error = 'Error submitting request: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instant Help Request · DRCS</title>
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
            --amber: #d97706;
            --green: #15803d;
            --blue: #1d4ed8;
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

        body { 
            background: linear-gradient(135deg, var(--off) 0%, var(--surface) 100%);
            font-family: var(--font-bd); 
            color: var(--text); 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* NAVBAR */
        nav {
            background: rgba(255,255,255,0.96);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            backdrop-filter: blur(12px);
        }
        .nav-brand { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: inherit; }
        .logo-icon { width: 38px; height: 38px; background: var(--red); border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .logo-icon svg { width: 22px; fill: #fff; }
        .brand-text { font-family: var(--font-hd); font-size: 1.3rem; }
        .brand-text em { color: var(--red); font-style: normal; }
        .emergency-badge { background: var(--red); color: white; padding: 0.3rem 1rem; border-radius: 40px; font-size: 0.75rem; font-weight: 600; font-family: var(--font-mn); animation: pulse 2s infinite; }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .back-btn { 
            background: transparent; 
            border: 1.5px solid var(--border); 
            padding: 0.4rem 1rem; 
            border-radius: 40px; 
            cursor: pointer; 
            font-size: 0.75rem; 
            font-family: var(--font-bd);
            transition: 0.2s;
        }
        .back-btn:hover { background: var(--surface); }

        /* MAIN CONTAINER */
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            flex: 1;
        }

        .form-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            box-shadow: var(--shadow);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h1 {
            font-family: var(--font-hd);
            font-size: 2rem;
            color: var(--red);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #e0f2e9;
            color: var(--green);
            border: 1px solid var(--green);
        }

        .alert-error {
            background: #fee;
            color: #c00;
            border: 1px solid #c00;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: var(--text);
        }

        .form-group label .required {
            color: var(--red);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            font-family: var(--font-bd);
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--red);
            box-shadow: 0 0 0 3px var(--red-lt);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .section-title {
            font-family: var(--font-hd);
            font-size: 1.2rem;
            color: var(--red);
            margin: 2rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border);
        }

        .btn-submit {
            width: 100%;
            background: var(--red);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: var(--radius-md);
            font-family: var(--font-bd);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            background: var(--red-dk);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .help-text {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 0.3rem;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .form-card {
                padding: 1.5rem;
            }
            
            nav {
                padding: 0 1rem;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a class="nav-brand" href="../public/index.php">
        <div class="logo-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 15h-2v-2h2zm0-4h-2V7h2z"/>
            </svg>
        </div>
        <span class="brand-text">DR<em>CS</em></span>
    </a>
    <span class="emergency-badge">⚡ EMERGENCY REQUEST</span>
    <button class="back-btn" onclick="window.location.href='../public/index.php'">← Back to Home</button>
</nav>

<div class="container">
    <div class="form-card">
        <div class="form-header">
            <h1>⚡ Instant Help Request</h1>
            <p>Submit an emergency request without registration. Our team will respond as soon as possible.</p>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success">
                ✅ <strong>Request submitted successfully!</strong><br>
                Your request has been received. Our team will contact you shortly at <?php echo htmlspecialchars($contact_number); ?>.
            </div>
            <button class="btn-submit" onclick="window.location.href='../public/index.php'">Return to Home</button>
        <?php else: ?>
            <?php if ($error): ?>
                <div class="alert alert-error">
                    ❌ <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <!-- Personal Information -->
                <div class="form-group">
                    <label>Full Name <span class="required">*</span></label>
                    <input type="text" name="full_name" required placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label>Contact Number <span class="required">*</span></label>
                    <input type="tel" name="contact_number" required placeholder="+94 XX XXX XXXX">
                    <div class="help-text">We'll use this to contact you about your request</div>
                </div>

                <!-- Request Details -->
                <div class="section-title">Request Details</div>

                <div class="form-group">
                    <label>Request Name <span class="required">*</span></label>
                    <input type="text" name="req_name" required placeholder="Brief title for your request">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Resource Type <span class="required">*</span></label>
                        <select name="resource_type" required>
                            <option value="">Select resource type</option>
                            <option value="Medicins">Medicines</option>
                            <option value="Foods">Food</option>
                            <option value="Shelters">Shelter</option>
                            <option value="Clothes">Clothes</option>
                            <option value="Money">Financial Aid</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Quantity Needed</label>
                        <input type="number" name="resource_count" min="1" placeholder="e.g., 5">
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" placeholder="Describe your situation and what help you need..."></textarea>
                </div>

                <!-- Location Information -->
                <div class="section-title">Location Information</div>

                <div class="form-row">
                    <div class="form-group">
                        <label>District</label>
                        <input type="text" name="district" placeholder="e.g., Colombo">
                    </div>

                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" placeholder="e.g., Dehiwala">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Street</label>
                        <input type="text" name="street" placeholder="Street name">
                    </div>

                    <div class="form-group">
                        <label>Home No.</label>
                        <input type="text" name="home_no" placeholder="House/Building number">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Latitude</label>
                        <input type="number" step="any" name="latitude" placeholder="e.g., 6.9271">
                        <div class="help-text">Optional: GPS coordinates</div>
                    </div>

                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="number" step="any" name="longitude" placeholder="e.g., 79.8612">
                        <div class="help-text">Optional: GPS coordinates</div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">🚨 Submit Emergency Request</button>
            </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
