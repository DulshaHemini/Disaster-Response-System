<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Disaster Response Coordination System | DRCS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            background-color: #F4F7FB;
            color: #1F2937;
            line-height: 1.5;
            scroll-behavior: smooth;
        }

        /* ========== TYPOGRAPHY & UTILITIES ========== */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ========== NAVBAR ========== */
        .navbar {
            background: #1E3A5F;   /* Deep Blue - Trust & Stability */
            backdrop-filter: blur(0px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            gap: 1rem;
        }

        .logo h2 {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.3px;
            background: linear-gradient(130deg, #FFFFFF, #CBD5E1);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
        }

        .nav-btn {
            background: transparent;
            border: none;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 8px 16px;
            border-radius: 40px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
            color: #F1F5F9;
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .btn-signin {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .btn-signup {
            background: #F59E0B;   /* Amber alert accent but for signup prominence */
            color: #1E293B;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        .btn-signup:hover {
            background: #FBBF24;
            transform: translateY(-2px);
        }

        .btn-instant {
            background: #D32F2F;   /* Emergency Red - critical action */
            color: white;
            box-shadow: 0 2px 8px rgba(211, 47, 47, 0.4);
        }

        .btn-instant:hover {
            background: #FF3B30;
            transform: scale(1.02);
        }

        .language-group {
            display: flex;
            gap: 6px;
            margin-left: 8px;
            background: rgba(0,0,0,0.25);
            padding: 4px 8px;
            border-radius: 48px;
        }

        .lang-btn {
            background: transparent;
            border: none;
            color: white;
            font-weight: 500;
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 32px;
            cursor: pointer;
            transition: 0.2s;
            font-family: inherit;
        }

        .lang-btn:hover {
            background: #2C5282;
        }

        .lang-btn.active {
            background: #2C5282;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.1), 0 0 0 1px #FBBF24;
        }

        /* ========== HERO SECTION (URGENCY + CALM) ========== */
        .hero {
            background: linear-gradient(135deg, #1E3A5F, #2C5282, #0F172A);
            color: white;
            padding: 3rem 0 4rem;
            border-bottom: 4px solid #F59E0B;
        }

        .hero-content {
            max-width: 780px;
        }

        .hero-badge {
            background: #D32F2F;
            display: inline-block;
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 1.2rem;
        }

        .hero h1 {
            font-size: 2.7rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .emergency-btn {
            background: #D32F2F;
            color: white;
            border: none;
            padding: 14px 32px;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 60px;
            cursor: pointer;
            box-shadow: 0 10px 20px -5px rgba(211, 47, 47, 0.5);
            transition: all 0.2s;
            font-family: inherit;
        }

        .emergency-btn:hover {
            background: #FF3B30;
            transform: scale(1.02);
            box-shadow: 0 16px 24px -6px rgba(255, 59, 48, 0.4);
        }

        /* ========== SERVICE FLOW SECTION ========== */
        .flow-section {
            padding: 4rem 0;
            background: #F4F7FB;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: #1E3A5F;
        }

        .flow-steps {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            margin-top: 1rem;
        }

        .step-card {
            background: white;
            border-radius: 32px;
            padding: 2rem 1.5rem;
            flex: 1;
            min-width: 240px;
            max-width: 280px;
            text-align: center;
            box-shadow: 0 12px 28px -8px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            border-top: 5px solid #2E7D32;
        }

        .step-card.volunteer-step {
            border-top-color: #F59E0B;
        }
        .step-card.org-step {
            border-top-color: #2C5282;
        }

        .step-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 32px -12px rgba(0,0,0,0.15);
        }

        .step-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .step-card h3 {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
            font-weight: 700;
        }

        .step-card p {
            color: #4b5563;
            margin-bottom: 1rem;
        }

        .step-tag {
            background: #EFF6FF;
            display: inline-block;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #1E3A5F;
        }

        .connector-line {
            text-align: center;
            font-size: 2rem;
            color: #2C5282;
            font-weight: 300;
            display: none;
        }

        @media (min-width: 768px) {
            .connector-line {
                display: block;
                width: 40px;
                font-size: 2rem;
            }
            .flow-steps {
                flex-wrap: nowrap;
                align-items: center;
            }
        }

        .flow-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        /* volunteer & organization rows */
        .participant-row {
            margin-top: 3rem;
            background: #FFFFFFD0;
            border-radius: 48px;
            padding: 2rem 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .subtitle {
            text-align: center;
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 1.8rem;
            color: #0F172A;
            border-left: 6px solid #F59E0B;
            padding-left: 1rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .cards-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }

        /* ========== FOOTER (Detailed) ========== */
        .footer {
            background: #0B2A3B;
            color: #CBD5E1;
            padding: 3rem 0 1.5rem;
            margin-top: 2rem;
            border-top: 3px solid #F59E0B;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-col h4 {
            color: white;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            font-weight: 600;
            letter-spacing: -0.2px;
        }

        .footer-col p, .footer-col ul {
            font-size: 0.85rem;
            line-height: 1.5;
            opacity: 0.8;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col li {
            margin-bottom: 0.5rem;
        }

        .footer-col a {
            color: #CBD5E1;
            text-decoration: none;
            transition: 0.2s;
        }

        .footer-col a:hover {
            color: #FBBF24;
            text-decoration: underline;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-icons span {
            background: #1E3A5F;
            padding: 6px 12px;
            border-radius: 40px;
            font-size: 0.8rem;
            cursor: default;
        }

        .footer-bottom {
            border-top: 1px solid #2C4C6E;
            padding-top: 1.5rem;
            text-align: center;
            font-size: 0.75rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1rem;
        }

        /* Alert toast simulation for demo */
        .toast-msg {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: #1F2937;
            color: white;
            padding: 12px 24px;
            border-radius: 60px;
            font-weight: 500;
            z-index: 1200;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            backdrop-filter: blur(8px);
            transition: all 0.2s;
            pointer-events: none;
        }

        button {
            cursor: pointer;
        }

        @media (max-width: 780px) {
            .nav-container {
                flex-direction: column;
                align-items: stretch;
            }
            .nav-links {
                justify-content: center;
            }
            .language-group {
                justify-content: center;
            }
            .hero h1 {
                font-size: 1.9rem;
            }
        }
    </style>
</head>
<body>

<!-- NAVIGATION BAR -->
<nav class="navbar">
    <div class="nav-container">
        <div class="logo">
            <h2>🌊 DRCS · Lanka</h2>
        </div>
        <div class="nav-links">
            <button class="nav-btn btn-signin" id="signinBtn">Sign In</button>
            <button class="nav-btn btn-signup" id="signupBtn">Sign Up</button>
            <button class="nav-btn btn-instant" id="instantHelpBtn">⚡ InstantHelp</button>
            <button class="nav-btn" id="infoBtn">📘 Info</button>
            <div class="language-group">
                <button class="lang-btn" data-lang="en">🇬🇧 English</button>
                <button class="lang-btn" data-lang="si">🇱🇰 සිංහල</button>
                <button class="lang-btn" data-lang="ta">🇱🇰 தமிழ்</button>
            </div>
        </div>
    </div>
</nav>

<!-- HERO with emergency alert callout -->
<section class="hero">
    <div class="container hero-content">
        <div class="hero-badge">🚨 ACTIVE MONSOON FLOOD ALERT · Central & Sabaragamuwa</div>
        <h1>Coordination saves lives.<br>Real-time disaster response.</h1>
        <p>Connecting affected communities, volunteers, and relief organizations in one unified command center.</p>
        <button class="emergency-btn" id="heroEmergencyBtn">🆘 SEND EMERGENCY ALERT</button>
    </div>
</section>

<!-- BODY: FLOW OF SERVICE from volunteers & organizations to affected people -->
<div class="flow-section">
    <div class="container">
        <h2 class="section-title">🌀 How Our Coordination Works</h2>
        <p style="text-align: center; margin-bottom: 2rem; max-width: 700px; margin-left: auto; margin-right: auto;">From volunteers & organizations → immediate relief → affected families</p>

        <!-- Main flow visual: donors/volunteers/organizations -> affected people -->
        <div class="participant-row">
            <div class="subtitle">🙌 Volunteers & Community Heroes</div>
            <div class="cards-grid">
                <div class="step-card volunteer-step">
                    <div class="step-icon">🫱🏽‍🫲🏾</div>
                    <h3>Sign Up as Volunteer</h3>
                    <p>Register skills: first aid, rescue, supply distribution, shelter management.</p>
                    <span class="step-tag">Available: 1,240+ ready</span>
                </div>
                <div class="step-card volunteer-step">
                    <div class="step-icon">📱</div>
                    <h3>Respond to Calls</h3>
                    <p>Receive push alerts & coordinate via instant help hub.</p>
                    <span class="step-tag">Real-time dispatch</span>
                </div>
                <div class="step-card volunteer-step">
                    <div class="step-icon">🚚</div>
                    <h3>Deliver Relief</h3>
                    <p>Food, medicine, evacuation — mapped to highest priority zones.</p>
                </div>
            </div>
        </div>

        <div class="participant-row" style="background:#EFF6FF">
            <div class="subtitle">🏢 Organizations & NGO Partners</div>
            <div class="cards-grid">
                <div class="step-card org-step">
                    <div class="step-icon">🏥</div>
                    <h3>Resource Deployment</h3>
                    <p>Government agencies, Red Cross, local NGOs pool supplies & shelters.</p>
                    <span class="step-tag">45 orgs active</span>
                </div>
                <div class="step-card org-step">
                    <div class="step-icon">📊</div>
                    <h3>Coordination Dashboard</h3>
                    <p>Live damage heatmaps, request logs, and logistics tracking.</p>
                </div>
                <div class="step-card org-step">
                    <div class="step-icon">🤝</div>
                    <h3>Match & Mobilize</h3>
                    <p>Assign teams to affected Grama Niladhari divisions instantly.</p>
                </div>
            </div>
        </div>

        <!-- Central arrow / connection -->
        <div style="text-align: center; margin: 1.5rem 0;">
            <span style="background: #1E3A5F; color: white; padding: 8px 18px; border-radius: 40px; font-weight: 600;">⬇️ Direct assistance to affected communities ⬇️</span>
        </div>

        <!-- Affected People / Beneficiaries -->
        <div class="participant-row" style="background: #FFF7ED;">
            <div class="subtitle">🏠 Affected People & Families</div>
            <div class="cards-grid">
                <div class="step-card" style="border-top-color: #D32F2F;">
                    <div class="step-icon">🆘</div>
                    <h3>Request Help</h3>
                    <p>One-click SOS: food, shelter, medical or evacuation.</p>
                    <span class="step-tag">Critical need flag</span>
                </div>
                <div class="step-card" style="border-top-color: #F59E0B;">
                    <div class="step-icon">📍</div>
                    <h3>Get Matched</h3>
                    <p>System assigns nearest volunteer team or org.</p>
                </div>
                <div class="step-card" style="border-top-color: #2E7D32;">
                    <div class="step-icon">✅</div>
                    <h3>Receive Support</h3>
                    <p>Real-time updates, delivery tracking & follow-up care.</p>
                    <span class="step-tag">Relief confirmed</span>
                </div>
            </div>
        </div>

        <!-- End-to-end summary -->
        <div style="margin-top: 3rem; background: white; border-radius: 48px; padding: 1.5rem; text-align: center; box-shadow: 0 6px 14px rgba(0,0,0,0.05);">
            <p style="font-weight: 600; color:#1E3A5F;">✔️ From volunteers, organizations → rapid coordination → impacted individuals receive <strong>life-saving aid</strong> within golden hours.</p>
            <p style="font-size: 0.85rem; margin-top: 8px;">🔁 Closed-loop system: affected people → request → volunteer/organization response → status updated in real time</p>
        </div>
    </div>
</div>

<!-- DETAILED FOOTER (average-level but comprehensive) -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Disaster Response Coordination System</h4>
                <p>Unified platform for emergency management, real-time volunteer matching, and resource allocation across Sri Lanka.</p>
                <div class="social-icons">
                    <span>🌐 DRCS.gov</span>
                    <span>📱 Emergency App</span>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">About DRCS</a></li>
                    <li><a href="#">National Emergency Operations Centre</a></li>
                    <li><a href="#">Volunteer Registration</a></li>
                    <li><a href="#">NGO Partnership</a></li>
                    <li><a href="#">Disaster Risk Reduction</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Emergency Contacts</h4>
                <ul>
                    <li>🚨 National Hotline: <strong>117</strong></li>
                    <li>🚑 Disaster Service: <strong>110</strong></li>
                    <li>📍 Head Office: Colombo 07, Sri Lanka</li>
                    <li>📧 dcs@disaster.gov.lk</li>
                    <li>📞 +94 112 345 678</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Legal & Info</h4>
                <ul>
                    <li><a href="#">Privacy & Data Security</a></li>
                    <li><a href="#">Terms of Coordination</a></li>
                    <li><a href="#">Accessibility Statement</a></li>
                    <li><a href="#">Situation Reports</a></li>
                    <li><a href="#">Feedback / Grievance</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2026 DRCS — Ministry of Disaster Management. All alerts simulated for coordination demo.</span>
            <span>🕒 Last updated: April 18, 2026 · Crisis response version 3.0</span>
        </div>
    </div>
</footer>

<!-- SIMPLE LANGUAGE SWITCH DEMO (static content transformation for key texts) -->
<script>
    // Language content mapping (English, Sinhala, Tamil) for key UI phrases
    const translations = {
        en: {
            heroBadge: "🚨 ACTIVE MONSOON FLOOD ALERT · Central & Sabaragamuwa",
            heroTitle: "Coordination saves lives. Real-time disaster response.",
            heroDesc: "Connecting affected communities, volunteers, and relief organizations in one unified command center.",
            emergencyBtn: "🆘 SEND EMERGENCY ALERT",
            sectionTitle: "🌀 How Our Coordination Works",
            flowSub: "From volunteers & organizations → immediate relief → affected families",
            volunteerTitle: "🙌 Volunteers & Community Heroes",
            volunteerCard1: "Sign Up as Volunteer",
            volunteerCard1Desc: "Register skills: first aid, rescue, supply distribution, shelter management.",
            volunteerCard2: "Respond to Calls",
            volunteerCard2Desc: "Receive push alerts & coordinate via instant help hub.",
            volunteerCard3: "Deliver Relief",
            volunteerCard3Desc: "Food, medicine, evacuation — mapped to highest priority zones.",
            orgTitle: "🏢 Organizations & NGO Partners",
            orgCard1: "Resource Deployment",
            orgCard1Desc: "Government agencies, Red Cross, local NGOs pool supplies & shelters.",
            orgCard2: "Coordination Dashboard",
            orgCard2Desc: "Live damage heatmaps, request logs, and logistics tracking.",
            orgCard3: "Match & Mobilize",
            orgCard3Desc: "Assign teams to affected Grama Niladhari divisions instantly.",
            affectedTitle: "🏠 Affected People & Families",
            affectedCard1: "Request Help",
            affectedCard1Desc: "One-click SOS: food, shelter, medical or evacuation.",
            affectedCard2: "Get Matched",
            affectedCard2Desc: "System assigns nearest volunteer team or org.",
            affectedCard3: "Receive Support",
            affectedCard3Desc: "Real-time updates, delivery tracking & follow-up care.",
            flowNote: "✔️ From volunteers, organizations → rapid coordination → impacted individuals receive life-saving aid within golden hours.",
            flowNoteSub: "🔁 Closed-loop system: affected people → request → volunteer/organization response → status updated in real time"
        },
        si: {
            heroBadge: "🚨 ක්‍රියාකාරී නිරිත දිග මෝසම් ගංවතුර අනතුරු ඇඟවීම · මධ්‍යම සහ සබරගමුව",
            heroTitle: "සම්බන්ධීකරණය ජීවිත බේරා ගනී. සැබෑ වේලාවේ ආපදා ප්‍රතිචාර.",
            heroDesc: "බලපෑමට ලක් වූ ප්‍රජාවන්, ස්වේච්ඡා සේවකයන් සහ සහන සංවිධාන එක්සත් කරයි.",
            emergencyBtn: "🆘 හදිසි ඇඟවීම යවන්න",
            sectionTitle: "🌀 අපගේ සම්බන්ධීකරණ ප්‍රවාහය",
            flowSub: "ස්වේච්ඡා සේවක සහ සංවිධාන → වහාම සහනය → පීඩාවට පත් පවුල්",
            volunteerTitle: "🙌 ස්වේච්ඡා සේවක සහ ප්‍රජා වීරයෝ",
            volunteerCard1: "ස්වේච්ඡා සේවකයෙකු ලෙස ලියාපදිංචි වන්න",
            volunteerCard1Desc: "ප්‍රථමාධාර, ගලවාගැනීම්, සැපයුම් බෙදාහැරීමේ කුසලතා ලියාපදිංචි කරන්න.",
            volunteerCard2: "ඇමතුම් වලට ප්‍රතිචාර දක්වන්න",
            volunteerCard2Desc: "තල්ලු ඇඟවීම් ලබාගෙන ක්ෂණික උපකාර මධ්‍යස්ථානය හරහා සම්බන්ධීකරණය කරන්න.",
            volunteerCard3: "සහන ලබා දෙන්න",
            volunteerCard3Desc: "ආහාර, බෙහෙත්, ඉවත් කිරීම් — ඉහළ ප්‍රමුඛතා කලාප සඳහා සිතියම්ගත කර ඇත.",
            orgTitle: "🏢 සංවිධාන සහ රාජ්‍ය නොවන සංවිධාන හවුල්කරුවන්",
            orgCard1: "සම්පත් යෙදවීම",
            orgCard1Desc: "රාජ්‍ය ආයතන, රතු කුරුසය, ප්‍රාදේශීය රාජ්‍ය නොවන සංවිධාන සැපයුම් සහ නවාතැන් සම්පාදනය කරයි.",
            orgCard2: "සම්බන්ධීකරණ උපකරණ පුවරුව",
            orgCard2Desc: "සජීවී හානි තාප සිතියම්, ඉල්ලීම් ලොග, සැපයුම් ලුහුබැඳීම.",
            orgCard3: "ගැලපීම සහ බලමුලු ගැන්වීම",
            orgCard3Desc: "බලපෑමට ලක් වූ ග්‍රාම නිලධාරී කොට්ඨාශ සඳහා කණ්ඩායම් පවරන්න.",
            affectedTitle: "🏠 පීඩාවට පත් පුද්ගලයන් සහ පවුල්",
            affectedCard1: "උපකාර ඉල්ලන්න",
            affectedCard1Desc: "එක ක්ලික් SOS: ආහාර, නවාතැන්, වෛද්‍ය හෝ ඉවත් කිරීම.",
            affectedCard2: "ගැලපීම ලබා ගන්න",
            affectedCard2Desc: "පද්ධතිය ආසන්නතම ස්වේච්ඡා කණ්ඩායම හෝ සංවිධානය පවරයි.",
            affectedCard3: "සහයෝගය ලබා ගන්න",
            affectedCard3Desc: "සැබෑ වේලාව යාවත්කාලීන කිරීම්, බෙදාහැරීම් ලුහුබැඳීම සහ පසු විපරම් සත්කාර.",
            flowNote: "✔️ ස්වේච්ඡා සේවක, සංවිධාන → වේගවත් සම්බන්ධීකරණය → රන්වන් පැය තුළ ජීවිතාරක්ෂක ආධාර.",
            flowNoteSub: "🔁 සංවෘත ලූප පද්ධතිය: බලපෑමට ලක් වූවන් → ඉල්ලීම → ස්වේච්ඡා/සංවිධාන ප්‍රතිචාරය → තත්ත්වය යාවත්කාලීන"
        },
        ta: {
            heroBadge: "🚨 செயலில் பருவமழை வெள்ள எச்சரிக்கை · மத்திய & சப்ரகமுவா",
            heroTitle: "ஒருங்கிணைப்பு உயிர்களை காப்பாற்றுகிறது. நிகழ்நேர பேரிடர் பதில்.",
            heroDesc: "பாதிக்கப்பட்ட சமூகங்கள், தன்னார்வலர்கள் மற்றும் நிவாரண நிறுவனங்களை இணைக்கும் ஒருங்கிணைந்த கட்டளை மையம்.",
            emergencyBtn: "🆘 அவசர எச்சரிக்கையை அனுப்பு",
            sectionTitle: "🌀 எங்கள் ஒருங்கிணைப்பு ஓட்டம்",
            flowSub: "தன்னார்வலர்கள் & நிறுவனங்களிடமிருந்து → உடனடி நிவாரணம் → பாதிக்கப்பட்ட குடும்பங்கள்",
            volunteerTitle: "🙌 தன்னார்வலர்கள் மற்றும் சமூக ஹீரோக்கள்",
            volunteerCard1: "தன்னார்வலராக பதிவு செய்யுங்கள்",
            volunteerCard1Desc: "முதலுதவி, மீட்பு, விநியோக விநியோகம், தங்குமிட மேலாண்மை ஆகியவற்றை பதிவு செய்யுங்கள்.",
            volunteerCard2: "அழைப்புகளுக்கு பதிலளிக்கவும்",
            volunteerCard2Desc: "உந்துதல் அறிவிப்புகளைப் பெறுங்கள் & உடனடி உதவி மையம் மூலம் ஒருங்கிணைக்கவும்.",
            volunteerCard3: "நிவாரணத்தை வழங்குங்கள்",
            volunteerCard3Desc: "உணவு, மருந்து, வெளியேற்றம் — மிக உயர்ந்த முன்னுரிமை மண்டலங்களுக்கு வரைபடமாக்கப்பட்டது.",
            orgTitle: "🏢 நிறுவனங்கள் மற்றும் தன்னார்வ தொண்டு நிறுவன பங்காளிகள்",
            orgCard1: "வளப் பயன்பாடு",
            orgCard1Desc: "அரசு நிறுவனங்கள், செஞ்சிலுவைச் சங்கம், உள்ளூர் தன்னார்வ தொண்டு நிறுவனங்கள் விநியோகங்கள் & தங்குமிடங்களை ஒன்றிணைக்கின்றன.",
            orgCard2: "ஒருங்கிணைப்பு டாஷ்போர்டு",
            orgCard2Desc: "நேரடி சேத வெப்ப வரைபடங்கள், கோரிக்கை பதிவுகள் மற்றும் தளவாட கண்காணிப்பு.",
            orgCard3: "பொருத்தம் & திரட்டல்",
            orgCard3Desc: "பாதிக்கப்பட்ட கிராம நிலதாரி பிரிவுகளுக்கு குழுக்களை ஒதுக்குங்கள்.",
            affectedTitle: "🏠 பாதிக்கப்பட்ட மக்கள் மற்றும் குடும்பங்கள்",
            affectedCard1: "உதவி கோருங்கள்",
            affectedCard1Desc: "ஒரே கிளிக்கில் SOS: உணவு, தங்குமிடம், மருத்துவம் அல்லது வெளியேற்றம்.",
            affectedCard2: "பொருத்தம் பெறுக",
            affectedCard2Desc: "அமைப்பு அருகிலுள்ள தன்னார்வக் குழு அல்லது நிறுவனத்தை ஒதுக்குகிறது.",
            affectedCard3: "ஆதரவைப் பெறுக",
            affectedCard3Desc: "நிகழ்நேர புதுப்பிப்புகள், விநியோக கண்காணிப்பு மற்றும் பின்தொடர்தல் பராமரிப்பு.",
            flowNote: "✔️ தன்னார்வலர்கள், நிறுவனங்கள் → விரைவான ஒருங்கிணைப்பு → தங்க நேரத்திற்குள் உயிர்காக்கும் உதவி.",
            flowNoteSub: "🔁 மூடிய-லூப் அமைப்பு: பாதிக்கப்பட்டவர்கள் → கோரிக்கை → தன்னார்வ/நிறுவன பதில் → நிலை நிகழ்நேரத்தில் புதுப்பிக்கப்படுகிறது"
        }
    };

    let currentLang = 'en';
    function applyLanguage(lang) {
        const t = translations[lang];
        if (!t) return;
        document.querySelector('.hero-badge').innerText = t.heroBadge;
        document.querySelector('.hero h1').innerText = t.heroTitle;
        document.querySelector('.hero p').innerText = t.heroDesc;
        document.querySelector('.emergency-btn').innerHTML = t.emergencyBtn;
        document.querySelector('.section-title').innerText = t.sectionTitle;
        const flowSubP = document.querySelector('.flow-section .container > p');
        if (flowSubP) flowSubP.innerText = t.flowSub;
        
        // Volunteers block
        const volunteerTitleElem = document.querySelectorAll('.participant-row')[0]?.querySelector('.subtitle');
        if (volunteerTitleElem) volunteerTitleElem.innerText = t.volunteerTitle;
        const vCards = document.querySelectorAll('.participant-row')[0]?.querySelectorAll('.step-card');
        if(vCards && vCards[0]) { vCards[0].querySelector('h3').innerText = t.volunteerCard1; vCards[0].querySelector('p').innerText = t.volunteerCard1Desc; }
        if(vCards && vCards[1]) { vCards[1].querySelector('h3').innerText = t.volunteerCard2; vCards[1].querySelector('p').innerText = t.volunteerCard2Desc; }
        if(vCards && vCards[2]) { vCards[2].querySelector('h3').innerText = t.volunteerCard3; vCards[2].querySelector('p').innerText = t.volunteerCard3Desc; }
        
        // Organizations
        const orgTitleElem = document.querySelectorAll('.participant-row')[1]?.querySelector('.subtitle');
        if(orgTitleElem) orgTitleElem.innerText = t.orgTitle;
        const oCards = document.querySelectorAll('.participant-row')[1]?.querySelectorAll('.step-card');
        if(oCards && oCards[0]) { oCards[0].querySelector('h3').innerText = t.orgCard1; oCards[0].querySelector('p').innerText = t.orgCard1Desc; }
        if(oCards && oCards[1]) { oCards[1].querySelector('h3').innerText = t.orgCard2; oCards[1].querySelector('p').innerText = t.orgCard2Desc; }
        if(oCards && oCards[2]) { oCards[2].querySelector('h3').innerText = t.orgCard3; oCards[2].querySelector('p').innerText = t.orgCard3Desc; }
        
        // Affected block
        const affTitle = document.querySelectorAll('.participant-row')[2]?.querySelector('.subtitle');
        if(affTitle) affTitle.innerText = t.affectedTitle;
        const aCards = document.querySelectorAll('.participant-row')[2]?.querySelectorAll('.step-card');
        if(aCards && aCards[0]) { aCards[0].querySelector('h3').innerText = t.affectedCard1; aCards[0].querySelector('p').innerText = t.affectedCard1Desc; }
        if(aCards && aCards[1]) { aCards[1].querySelector('h3').innerText = t.affectedCard2; aCards[1].querySelector('p').innerText = t.affectedCard2Desc; }
        if(aCards && aCards[2]) { aCards[2].querySelector('h3').innerText = t.affectedCard3; aCards[2].querySelector('p').innerText = t.affectedCard3Desc; }
        
        const noteDiv = document.querySelector('.flow-section .container > div:last-child');
        if(noteDiv && noteDiv.querySelector('p:first-child')) noteDiv.querySelector('p:first-child').innerHTML = t.flowNote;
        if(noteDiv && noteDiv.querySelector('p:last-child')) noteDiv.querySelector('p:last-child').innerHTML = t.flowNoteSub;
        
        // update active class
        document.querySelectorAll('.lang-btn').forEach(btn => {
            if(btn.getAttribute('data-lang') === lang) btn.classList.add('active');
            else btn.classList.remove('active');
        });
        currentLang = lang;
    }
    
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const lang = btn.getAttribute('data-lang');
            applyLanguage(lang);
        });
    });
    
    // UI interactive toasts for navbar / emergency demo
    function showToast(message) {
        let toast = document.querySelector('.toast-msg');
        if(toast) toast.remove();
        let div = document.createElement('div');
        div.className = 'toast-msg';
        div.innerText = message;
        document.body.appendChild(div);
        setTimeout(() => div.remove(), 2500);
    }
    
    document.getElementById('signinBtn')?.addEventListener('click', () => showToast('🔐 Sign in portal – unified credentials for volunteers/orgs'));
    document.getElementById('signupBtn')?.addEventListener('click', () => showToast('📝 Registration: become a responder or partner organization'));
    document.getElementById('instantHelpBtn')?.addEventListener('click', () => showToast('⚡ Instant Help triggered: nearest response team notified. Stay safe.'));
    document.getElementById('infoBtn')?.addEventListener('click', () => showToast('📘 Live situation reports & coordination guidelines available.'));
    document.getElementById('heroEmergencyBtn')?.addEventListener('click', () => showToast('🚨 EMERGENCY ALERT SENT! Control center notified. Help is coming.'));
    
    // initial english active
    applyLanguage('en');
</script>
</body>
</html>