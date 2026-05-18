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

        /* ========== NAVBAR ========== */
        .navbar {
            background: #1E3A5F;
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
            background: #F59E0B;
            color: #1E293B;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        .btn-signup:hover {
            background: #FBBF24;
            transform: translateY(-2px);
        }

        .btn-instant {
            background: #D32F2F;
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

        /* ========== HERO SECTION ========== */
        .hero {
            background: linear-gradient(135deg, #1E3A5F, #2C5282, #0F172A);
            color: white;
            padding: 3rem 0 4rem;
            border-bottom: 4px solid #F59E0B;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
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

        /* ========== FOOTER ========== */
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
            pointer-events: none;
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

<section class="hero">
    <div class="container hero-content">
        <div class="hero-badge" data-key="badge">🚨 ACTIVE MONSOON FLOOD ALERT · Central & Sabaragamuwa</div>
        <h1 data-key="title">Coordination saves lives.<br>Real-time disaster response.</h1>
        <p data-key="desc">Connecting affected communities, volunteers, and relief organizations in one unified command center.</p>
        <button class="emergency-btn" id="heroEmergencyBtn" data-key="emergencyBtn">🆘 SEND EMERGENCY ALERT</button>
    </div>
</section>

<div class="flow-section">
    <div class="container">
        <h2 class="section-title" data-key="sectionTitle">🌀 How Our Coordination Works</h2>
        <p style="text-align: center; margin-bottom: 2rem;" data-key="flowSub">From volunteers & organizations → immediate relief → affected families</p>

        <div class="participant-row">
            <div class="subtitle" data-key="volunteerTitle">🙌 Volunteers & Community Heroes</div>
            <div class="cards-grid">
                <div class="step-card volunteer-step">
                    <div class="step-icon">🫱🏽‍🫲🏾</div>
                    <h3 data-key="volCard1Title">Sign Up as Volunteer</h3>
                    <p data-key="volCard1Desc">Register skills: first aid, rescue, supply distribution, shelter management.</p>
                    <span class="step-tag" data-key="volCard1Tag">Available: 1,240+ ready</span>
                </div>
                <div class="step-card volunteer-step">
                    <div class="step-icon">📱</div>
                    <h3 data-key="volCard2Title">Respond to Calls</h3>
                    <p data-key="volCard2Desc">Receive push alerts & coordinate via instant help hub.</p>
                    <span class="step-tag" data-key="volCard2Tag">Real-time dispatch</span>
                </div>
                <div class="step-card volunteer-step">
                    <div class="step-icon">🚚</div>
                    <h3 data-key="volCard3Title">Deliver Relief</h3>
                    <p data-key="volCard3Desc">Food, medicine, evacuation — mapped to highest priority zones.</p>
                </div>
            </div>
        </div>

        <div class="participant-row" style="background:#EFF6FF">
            <div class="subtitle" data-key="orgTitle">🏢 Organizations & NGO Partners</div>
            <div class="cards-grid">
                <div class="step-card org-step">
                    <div class="step-icon">🏥</div>
                    <h3 data-key="orgCard1Title">Resource Deployment</h3>
                    <p data-key="orgCard1Desc">Government agencies, Red Cross, local NGOs pool supplies & shelters.</p>
                    <span class="step-tag" data-key="orgCard1Tag">45 orgs active</span>
                </div>
                <div class="step-card org-step">
                    <div class="step-icon">📊</div>
                    <h3 data-key="orgCard2Title">Coordination Dashboard</h3>
                    <p data-key="orgCard2Desc">Live damage heatmaps, request logs, and logistics tracking.</p>
                </div>
                <div class="step-card org-step">
                    <div class="step-icon">🤝</div>
                    <h3 data-key="orgCard3Title">Match & Mobilize</h3>
                    <p data-key="orgCard3Desc">Assign teams to affected Grama Niladhari divisions instantly.</p>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin: 1.5rem 0;">
            <span style="background: #1E3A5F; color: white; padding: 8px 18px; border-radius: 40px; font-weight: 600;" data-key="arrow">⬇️ Direct assistance to affected communities ⬇️</span>
        </div>

        <div class="participant-row" style="background: #FFF7ED;">
            <div class="subtitle" data-key="affectedTitle">🏠 Affected People & Families</div>
            <div class="cards-grid">
                <div class="step-card" style="border-top-color: #D32F2F;">
                    <div class="step-icon">🆘</div>
                    <h3 data-key="affCard1Title">Request Help</h3>
                    <p data-key="affCard1Desc">One-click SOS: food, shelter, medical or evacuation.</p>
                    <span class="step-tag" data-key="affCard1Tag">Critical need flag</span>
                </div>
                <div class="step-card" style="border-top-color: #F59E0B;">
                    <div class="step-icon">📍</div>
                    <h3 data-key="affCard2Title">Get Matched</h3>
                    <p data-key="affCard2Desc">System assigns nearest volunteer team or org.</p>
                </div>
                <div class="step-card" style="border-top-color: #2E7D32;">
                    <div class="step-icon">✅</div>
                    <h3 data-key="affCard3Title">Receive Support</h3>
                    <p data-key="affCard3Desc">Real-time updates, delivery tracking & follow-up care.</p>
                    <span class="step-tag" data-key="affCard3Tag">Relief confirmed</span>
                </div>
            </div>
        </div>

        <div style="margin-top: 3rem; background: white; border-radius: 48px; padding: 1.5rem; text-align: center;">
            <p style="font-weight: 600; color:#1E3A5F;" data-key="note1">✔️ From volunteers, organizations → rapid coordination → impacted individuals receive <strong>life-saving aid</strong> within golden hours.</p>
            <p style="font-size: 0.85rem; margin-top: 8px;" data-key="note2">🔁 Closed-loop system: affected people → request → volunteer/organization response → status updated in real time</p>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4 data-key="footerTitle">Disaster Response Coordination System</h4>
                <p data-key="footerDesc">Unified platform for emergency management, real-time volunteer matching, and resource allocation across Sri Lanka.</p>
            </div>
            <div class="footer-col">
                <h4 data-key="quickLinks">Quick Links</h4>
                <ul>
                    <li><a href="#" data-key="link1">About DRCS</a></li>
                    <li><a href="#" data-key="link2">National Emergency Operations Centre</a></li>
                    <li><a href="#" data-key="link3">Volunteer Registration</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 data-key="emergencyContacts">Emergency Contacts</h4>
                <ul>
                    <li>🚨 National Hotline: <strong>117</strong></li>
                    <li>🚑 Disaster Service: <strong>110</strong></li>
                    <li>📧 dcs@disaster.gov.lk</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span data-key="copyright">© 2026 DRCS — Ministry of Disaster Management</span>
        </div>
    </div>
</footer>

<script>
    // Complete translations for all 3 languages
    const translations = {
        en: {
            badge: "🚨 ACTIVE MONSOON FLOOD ALERT · Central & Sabaragamuwa",
            title: "Coordination saves lives.<br>Real-time disaster response.",
            desc: "Connecting affected communities, volunteers, and relief organizations in one unified command center.",
            emergencyBtn: "🆘 SEND EMERGENCY ALERT",
            sectionTitle: "🌀 How Our Coordination Works",
            flowSub: "From volunteers & organizations → immediate relief → affected families",
            volunteerTitle: "🙌 Volunteers & Community Heroes",
            volCard1Title: "Sign Up as Volunteer",
            volCard1Desc: "Register skills: first aid, rescue, supply distribution, shelter management.",
            volCard1Tag: "Available: 1,240+ ready",
            volCard2Title: "Respond to Calls",
            volCard2Desc: "Receive push alerts & coordinate via instant help hub.",
            volCard2Tag: "Real-time dispatch",
            volCard3Title: "Deliver Relief",
            volCard3Desc: "Food, medicine, evacuation — mapped to highest priority zones.",
            orgTitle: "🏢 Organizations & NGO Partners",
            orgCard1Title: "Resource Deployment",
            orgCard1Desc: "Government agencies, Red Cross, local NGOs pool supplies & shelters.",
            orgCard1Tag: "45 orgs active",
            orgCard2Title: "Coordination Dashboard",
            orgCard2Desc: "Live damage heatmaps, request logs, and logistics tracking.",
            orgCard3Title: "Match & Mobilize",
            orgCard3Desc: "Assign teams to affected Grama Niladhari divisions instantly.",
            affectedTitle: "🏠 Affected People & Families",
            affCard1Title: "Request Help",
            affCard1Desc: "One-click SOS: food, shelter, medical or evacuation.",
            affCard1Tag: "Critical need flag",
            affCard2Title: "Get Matched",
            affCard2Desc: "System assigns nearest volunteer team or org.",
            affCard3Title: "Receive Support",
            affCard3Desc: "Real-time updates, delivery tracking & follow-up care.",
            affCard3Tag: "Relief confirmed",
            arrow: "⬇️ Direct assistance to affected communities ⬇️",
            note1: "✔️ From volunteers, organizations → rapid coordination → impacted individuals receive life-saving aid within golden hours.",
            note2: "🔁 Closed-loop system: affected people → request → volunteer/organization response → status updated in real time",
            footerTitle: "Disaster Response Coordination System",
            footerDesc: "Unified platform for emergency management, real-time volunteer matching, and resource allocation across Sri Lanka.",
            quickLinks: "Quick Links",
            link1: "About DRCS",
            link2: "National Emergency Operations Centre",
            link3: "Volunteer Registration",
            emergencyContacts: "Emergency Contacts",
            copyright: "© 2026 DRCS — Ministry of Disaster Management"
        },
        si: {
            badge: "🚨 ක්‍රියාකාරී මෝසම් ගංවතුර අනතුරු ඇඟවීම · මධ්‍යම සහ සබරගමුව",
            title: "සම්බන්ධීකරණය ජීවිත බේරා ගනී.<br>සැබෑ වේලාවේ ආපදා ප්‍රතිචාර.",
            desc: "බලපෑමට ලක් වූ ප්‍රජාවන්, ස්වේච්ඡා සේවකයන් සහ සහන සංවිධාන එක්සත් කරයි.",
            emergencyBtn: "🆘 හදිසි ඇඟවීම යවන්න",
            sectionTitle: "🌀 අපගේ සම්බන්ධීකරණ ප්‍රවාහය",
            flowSub: "ස්වේච්ඡා සේවක සහ සංවිධාන → වහාම සහනය → පීඩාවට පත් පවුල්",
            volunteerTitle: "🙌 ස්වේච්ඡා සේවක සහ ප්‍රජා වීරයෝ",
            volCard1Title: "ස්වේච්ඡා සේවකයෙකු ලෙස ලියාපදිංචි වන්න",
            volCard1Desc: "ප්‍රථමාධාර, ගලවාගැනීම්, සැපයුම් බෙදාහැරීමේ කුසලතා ලියාපදිංචි කරන්න.",
            volCard1Tag: "පවතී: 1,240+ සූදානම්",
            volCard2Title: "ඇමතුම් වලට ප්‍රතිචාර දක්වන්න",
            volCard2Desc: "තල්ලු ඇඟවීම් ලබාගෙන ක්ෂණික උපකාර මධ්‍යස්ථානය හරහා සම්බන්ධීකරණය කරන්න.",
            volCard2Tag: "සැබෑ වේලාව යැවීම",
            volCard3Title: "සහන ලබා දෙන්න",
            volCard3Desc: "ආහාර, බෙහෙත්, ඉවත් කිරීම් — ඉහළ ප්‍රමුඛතා කලාප සඳහා සිතියම්ගත කර ඇත.",
            orgTitle: "🏢 සංවිධාන සහ රාජ්‍ය නොවන සංවිධාන හවුල්කරුවන්",
            orgCard1Title: "සම්පත් යෙදවීම",
            orgCard1Desc: "රාජ්‍ය ආයතන, රතු කුරුසය, ප්‍රාදේශීය රාජ්‍ය නොවන සංවිධාන සැපයුම් සහ නවාතැන් සම්පාදනය කරයි.",
            orgCard1Tag: "සංවිධාන 45 ක් ක්‍රියාකාරීයි",
            orgCard2Title: "සම්බන්ධීකරණ උපකරණ පුවරුව",
            orgCard2Desc: "සජීවී හානි තාප සිතියම්, ඉල්ලීම් ලොග, සැපයුම් ලුහුබැඳීම.",
            orgCard3Title: "ගැලපීම සහ බලමුලු ගැන්වීම",
            orgCard3Desc: "බලපෑමට ලක් වූ ග්‍රාම නිලධාරී කොට්ඨාශ සඳහා කණ්ඩායම් පවරන්න.",
            affectedTitle: "🏠 පීඩාවට පත් පුද්ගලයන් සහ පවුල්",
            affCard1Title: "උපකාර ඉල්ලන්න",
            affCard1Desc: "එක ක්ලික් SOS: ආහාර, නවාතැන්, වෛද්‍ය හෝ ඉවත් කිරීම.",
            affCard1Tag: "විවේචනාත්මක අවශ්‍යතාවය",
            affCard2Title: "ගැලපීම ලබා ගන්න",
            affCard2Desc: "පද්ධතිය ආසන්නතම ස්වේච්ඡා කණ්ඩායම හෝ සංවිධානය පවරයි.",
            affCard3Title: "සහයෝගය ලබා ගන්න",
            affCard3Desc: "සැබෑ වේලාව යාවත්කාලීන කිරීම්, බෙදාහැරීම් ලුහුබැඳීම සහ පසු විපරම් සත්කාර.",
            affCard3Tag: "සහන තහවුරු කරන ලදී",
            arrow: "⬇️ පීඩාවට පත් ප්‍රජාවන්ට සෘජු සහාය ⬇️",
            note1: "✔️ ස්වේච්ඡා සේවක, සංවිධාන → වේගවත් සම්බන්ධීකරණය → රන්වන් පැය තුළ ජීවිතාරක්ෂක ආධාර.",
            note2: "🔁 සංවෘත ලූප පද්ධතිය: බලපෑමට ලක් වූවන් → ඉල්ලීම → ස්වේච්ඡා/සංවිධාන ප්‍රතිචාරය → තත්ත්වය යාවත්කාලීන",
            footerTitle: "ව්‍යසන ප්‍රතිචාර සම්බන්ධීකරණ පද්ධතිය",
            footerDesc: "හදිසි කළමනාකරණය, සැබෑ වේලාවේ ස්වේච්ඡා ගැලපීම සහ ශ්‍රී ලංකාව පුරා සම්පත් වෙන් කිරීම සඳහා ඒකාබද්ධ වේදිකාව.",
            quickLinks: "ඉක්මන් සබැඳි",
            link1: "DRCS ගැන",
            link2: "ජාතික හදිසි මෙහෙයුම් මධ්‍යස්ථානය",
            link3: "ස්වේච්ඡා ලියාපදිංචිය",
            emergencyContacts: "හදිසි සම්බන්ධතා",
            copyright: "© 2026 DRCS — ව්‍යසන කළමනාකරණ අමාත්‍යාංශය"
        },
        ta: {
            badge: "🚨 செயலில் பருவமழை வெள்ள எச்சரிக்கை · மத்திய & சப்ரகமுவா",
            title: "ஒருங்கிணைப்பு உயிர்களை காப்பாற்றுகிறது.<br>நிகழ்நேர பேரிடர் பதில்.",
            desc: "பாதிக்கப்பட்ட சமூகங்கள், தன்னார்வலர்கள் மற்றும் நிவாரண நிறுவனங்களை இணைக்கும் ஒருங்கிணைந்த கட்டளை மையம்.",
            emergencyBtn: "🆘 அவசர எச்சரிக்கையை அனுப்பு",
            sectionTitle: "🌀 எங்கள் ஒருங்கிணைப்பு ஓட்டம்",
            flowSub: "தன்னார்வலர்கள் & நிறுவனங்களிடமிருந்து → உடனடி நிவாரணம் → பாதிக்கப்பட்ட குடும்பங்கள்",
            volunteerTitle: "🙌 தன்னார்வலர்கள் மற்றும் சமூக ஹீரோக்கள்",
            volCard1Title: "தன்னார்வலராக பதிவு செய்யுங்கள்",
            volCard1Desc: "முதலுதவி, மீட்பு, விநியோக விநியோகம், தங்குமிட மேலாண்மை ஆகியவற்றை பதிவு செய்யுங்கள்.",
            volCard1Tag: "கிடைக்கும்: 1,240+ தயார்",
            volCard2Title: "அழைப்புகளுக்கு பதிலளிக்கவும்",
            volCard2Desc: "உந்துதல் அறிவிப்புகளைப் பெறுங்கள் & உடனடி உதவி மையம் மூலம் ஒருங்கிணைக்கவும்.",
            volCard2Tag: "நிகழ்நேர அனுப்புதல்",
            volCard3Title: "நிவாரணத்தை வழங்குங்கள்",
            volCard3Desc: "உணவு, மருந்து, வெளியேற்றம் — மிக உயர்ந்த முன்னுரிமை மண்டலங்களுக்கு வரைபடமாக்கப்பட்டது.",
            orgTitle: "🏢 நிறுவனங்கள் மற்றும் தன்னார்வ தொண்டு நிறுவன பங்காளிகள்",
            orgCard1Title: "வளப் பயன்பாடு",
            orgCard1Desc: "அரசு நிறுவனங்கள், செஞ்சிலுவைச் சங்கம், உள்ளூர் தன்னார்வ தொண்டு நிறுவனங்கள் விநியோகங்கள் & தங்குமிடங்களை ஒன்றிணைக்கின்றன.",
            orgCard1Tag: "45 நிறுவனங்கள் செயலில்",
            orgCard2Title: "ஒருங்கிணைப்பு டாஷ்போர்டு",
            orgCard2Desc: "நேரடி சேத வெப்ப வரைபடங்கள், கோரிக்கை பதிவுகள் மற்றும் தளவாட கண்காணிப்பு.",
            orgCard3Title: "பொருத்தம் & திரட்டல்",
            orgCard3Desc: "பாதிக்கப்பட்ட கிராம நிலதாரி பிரிவுகளுக்கு குழுக்களை ஒதுக்குங்கள்.",
            affectedTitle: "🏠 பாதிக்கப்பட்ட மக்கள் மற்றும் குடும்பங்கள்",
            affCard1Title: "உதவி கோருங்கள்",
            affCard1Desc: "ஒரே கிளிக்கில் SOS: உணவு, தங்குமிடம், மருத்துவம் அல்லது வெளியேற்றம்.",
            affCard1Tag: "முக்கிய தேவை கொடி",
            affCard2Title: "பொருத்தம் பெறுக",
            affCard2Desc: "அமைப்பு அருகிலுள்ள தன்னார்வக் குழு அல்லது நிறுவனத்தை ஒதுக்குகிறது.",
            affCard3Title: "ஆதரவைப் பெறுக",
            affCard3Desc: "நிகழ்நேர புதுப்பிப்புகள், விநியோக கண்காணிப்பு மற்றும் பின்தொடர்தல் பராமரிப்பு.",
            affCard3Tag: "நிவாரணம் உறுதி செய்யப்பட்டது",
            arrow: "⬇️ பாதிக்கப்பட்ட சமூகங்களுக்கு நேரடி உதவி ⬇️",
            note1: "✔️ தன்னார்வலர்கள், நிறுவனங்கள் → விரைவான ஒருங்கிணைப்பு → தங்க நேரத்திற்குள் உயிர்காக்கும் உதவி.",
            note2: "🔁 மூடிய-லூப் அமைப்பு: பாதிக்கப்பட்டவர்கள் → கோரிக்கை → தன்னார்வ/நிறுவன பதில் → நிலை நிகழ்நேரத்தில் புதுப்பிக்கப்படுகிறது",
            footerTitle: "பேரிடர் பதில் ஒருங்கிணைப்பு அமைப்பு",
            footerDesc: "அவசர மேலாண்மை, நிகழ்நேர தன்னார்வ பொருத்தம் மற்றும் இலங்கை முழுவதும் வள ஒதுக்கீடு ஆகியவற்றிற்கான ஒருங்கிணைந்த தளம்.",
            quickLinks: "விரைவு இணைப்புகள்",
            link1: "DRCS பற்றி",
            link2: "தேசிய அவசர செயல்பாட்டு மையம்",
            link3: "தன்னார்வ பதிவு",
            emergencyContacts: "அவசர தொடர்புகள்",
            copyright: "© 2026 DRCS — பேரிடர் மேலாண்மை அமைச்சு"
        }
    };

    let currentLang = 'en';

    function applyLanguage(lang) {
        const t = translations[lang];
        if (!t) return;
        
        // Update all elements with data-key attribute
        document.querySelectorAll('[data-key]').forEach(element => {
            const key = element.getAttribute('data-key');
            if (t[key]) {
                if (element.tagName === 'INPUT' || element.tagName === 'BUTTON') {
                    element.value = t[key];
                } else {
                    element.innerHTML = t[key];
                }
            }
        });
        
        // Update active button
        document.querySelectorAll('.lang-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-lang') === lang) {
                btn.classList.add('active');
            }
        });
        
        currentLang = lang;
        showToast(`🌐 Changed to ${lang === 'en' ? 'English' : lang === 'si' ? 'සිංහල' : 'தமிழ'}`);
    }

    function showToast(message) {
        let toast = document.querySelector('.toast-msg');
        if(toast) toast.remove();
        let div = document.createElement('div');
        div.className = 'toast-msg';
        div.innerText = message;
        document.body.appendChild(div);
        setTimeout(() => div.remove(), 2000);
    }

    // Button event listeners
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const lang = btn.getAttribute('data-lang');
            applyLanguage(lang);
        });
    });

    document.getElementById('signinBtn')?.addEventListener('click', () => showToast('🔐 Sign in portal'));
    document.getElementById('signupBtn')?.addEventListener('click', () => showToast('📝 Registration portal'));
    document.getElementById('instantHelpBtn')?.addEventListener('click', () => showToast('⚡ Instant Help triggered'));
    document.getElementById('infoBtn')?.addEventListener('click', () => showToast('📘 Information center'));
    document.getElementById('heroEmergencyBtn')?.addEventListener('click', () => showToast('🚨 EMERGENCY ALERT SENT!'));

    // Set English as default
    applyLanguage('en');
</script>
</body>
</html>