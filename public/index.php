<?php
// DRCS – index.php  (UI only – no backend logic)
// All styling is in style.css · All interactivity is in main.js
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>DRCS – Disaster Response Coordination System</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css"/>
</head>
<body>

<!-- NAVBAR -->
<nav>
  <a class="nav-brand" href="#">
    <div class="logo-icon"></div>
    <span>DR<em>CS</em></span>
  </a>

  <div class="nav-center">
    <div class="lang-switcher">
      <button class="lang-btn" onclick="setLang('si')">සිං</button>
      <button class="lang-btn active" onclick="setLang('en')">EN</button>
      <button class="lang-btn" onclick="setLang('ta')">தமி</button>
    </div>
  </div>

  <div class="nav-right">
    <button class="btn-help" onclick="instantHelp()">INSTANT HELP</button>
    <button class="btn-outline" onclick="openModal('signin')">Sign In</button>
    <button class="btn-fill"   onclick="openModal('signup')">Sign Up</button>
  </div>
</nav>

<!-- ALERT TICKER -->
<div class="ticker-wrap" style="margin-top:64px;">
  <span class="ticker">
    🔴 ACTIVE — Flooding Alert: Southern Province, Sri Lanka &nbsp;|&nbsp;
    🟡 WARNING — Landslide Risk: Ratnapura District &nbsp;|&nbsp;
    🟢 RESOLVED — Cyclone Watch lifted: Eastern Coast &nbsp;|&nbsp;
    🔴 ACTIVE — Search &amp; Rescue teams deployed: Galle &nbsp;|&nbsp;
    📡 Emergency Coordination Centre is operational 24/7 &nbsp;&nbsp;&nbsp;&nbsp;
  </span>
</div>

<!-- HERO -->
<div class="hero">
  <div class="hero-bg"></div>
  <div class="hero-grid"></div>

  <div class="hero-badge fade-up">
    <span class="badge-dot"></span>
    LIVE SYSTEM OPERATIONAL
  </div>

  <h1 class="fade-up">
    DISASTER<br><span class="red">RESPONSE</span><br>COORDINATION
  </h1>

  <p class="hero-sub fade-up">
    Real-time coordination platform for emergency response teams, government agencies,
    and first responders across Sri Lanka — powered by live data and field intelligence.
  </p>

  <div class="hero-cta fade-up">
    <button class="btn-lg btn-lg-primary" onclick="scrollTo('dashboard')">View Dashboard</button>
    <button class="btn-lg btn-lg-ghost"   onclick="scrollTo('analysis')">See Analysis</button>
  </div>

  <div class="stat-row">
    <div class="stat-item">
      <div class="stat-num">24<span>/7</span></div>
      <div class="stat-label">MONITORING</div>
    </div>
    <div class="stat-item">
      <div class="stat-num">142<span>+</span></div>
      <div class="stat-label">RESPONSE TEAMS</div>
    </div>
    <div class="stat-item">
      <div class="stat-num">9<span> Districts</span></div>
      <div class="stat-label">ACTIVE ZONES</div>
    </div>
    <div class="stat-item">
      <div class="stat-num">3.2<span>k</span></div>
      <div class="stat-label">PEOPLE ASSISTED</div>
    </div>
  </div>
</div>

<!-- ══ DASHBOARD ══ -->
<section id="dashboard">
  <div class="dashboard-header reveal">
    <div class="section-label">LIVE OVERVIEW</div>
    <h2 class="section-title">Situation Dashboard</h2>
    <div class="section-divider"></div>
  </div>

  <div class="dash-grid">
    <div class="kpi-card red reveal">
      <div class="kpi-icon">🆘</div>
      <div class="kpi-val">18</div>
      <div class="kpi-label">Active Incidents</div>
      <div class="kpi-delta down">▲ 3 since 6h ago</div>
    </div>
    <div class="kpi-card amber reveal">
      <div class="kpi-icon">⚠️</div>
      <div class="kpi-val">7</div>
      <div class="kpi-label">High-Risk Zones</div>
      <div class="kpi-delta up">▼ 2 since yesterday</div>
    </div>
    <div class="kpi-card green reveal">
      <div class="kpi-icon">🚁</div>
      <div class="kpi-val">142</div>
      <div class="kpi-label">Teams Deployed</div>
      <div class="kpi-delta up">▲ 12 mobilised today</div>
    </div>
    <div class="kpi-card blue reveal">
      <div class="kpi-icon">🏥</div>
      <div class="kpi-val">3,214</div>
      <div class="kpi-label">People Evacuated</div>
      <div class="kpi-delta up">▲ 480 in last 24h</div>
    </div>
  </div>

  <div class="dash-lower reveal">
    <div class="map-card">
      <div class="map-card-title">// INCIDENT MAP — SRI LANKA</div>
      <div class="map-visual">
        <div class="map-pin p1"></div>
        <div class="map-pin p2"></div>
        <div class="map-pin p3"></div>
        <span style="position:relative;z-index:1;font-size:.75rem;color:var(--muted);">
          Interactive map loads on deployment
        </span>
      </div>
    </div>

    <div class="alerts-card">
      <div class="alerts-title">// LIVE ALERTS</div>

      <div class="alert-item">
        <span class="alert-dot critical"></span>
        <div>
          <div class="alert-text">Flash flood reported — Baddegama, Galle</div>
          <div class="alert-time">2 min ago</div>
        </div>
      </div>
      <div class="alert-item">
        <span class="alert-dot warning"></span>
        <div>
          <div class="alert-text">Landslide risk elevated — Ratnapura</div>
          <div class="alert-time">14 min ago</div>
        </div>
      </div>
      <div class="alert-item">
        <span class="alert-dot info"></span>
        <div>
          <div class="alert-text">Relief convoy dispatched to Matara</div>
          <div class="alert-time">31 min ago</div>
        </div>
      </div>
      <div class="alert-item">
        <span class="alert-dot critical"></span>
        <div>
          <div class="alert-text">Road closure: A2 Highway blocked by debris</div>
          <div class="alert-time">52 min ago</div>
        </div>
      </div>
      <div class="alert-item">
        <span class="alert-dot warning"></span>
        <div>
          <div class="alert-text">Shelter capacity at 87% — Kalutara</div>
          <div class="alert-time">1h 10m ago</div>
        </div>
      </div>
      <div class="alert-item">
        <span class="alert-dot info"></span>
        <div>
          <div class="alert-text">Medical team air-lifted to Hambantota</div>
          <div class="alert-time">2h ago</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ ANALYSIS ══ -->
<section id="analysis" style="border-top:1px solid var(--border);">
  <div class="reveal">
    <div class="section-label">INTELLIGENCE &amp; DATA</div>
    <h2 class="section-title">Disaster Response Analysis</h2>
    <div class="section-divider"></div>
  </div>

  <div class="analysis-grid">

    <!-- Response Readiness -->
    <div class="analysis-card reveal">
      <div class="a-icon">📊</div>
      <div class="a-title">Response Readiness Index</div>
      <div class="a-text">Real-time measurement of provincial preparedness across key readiness dimensions.</div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span>Southern Province</span><span>82%</span></div>
        <div class="pb"><div class="pb-fill red"   style="width:82%"></div></div>
      </div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span>Sabaragamuwa</span><span>67%</span></div>
        <div class="pb"><div class="pb-fill amber" style="width:67%"></div></div>
      </div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span>Western Province</span><span>91%</span></div>
        <div class="pb"><div class="pb-fill green" style="width:91%"></div></div>
      </div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span>Eastern Province</span><span>58%</span></div>
        <div class="pb"><div class="pb-fill blue"  style="width:58%"></div></div>
      </div>
    </div>

    <!-- Disaster Type Breakdown -->
    <div class="analysis-card reveal">
      <div class="a-icon">🌊</div>
      <div class="a-title">Disaster Type Breakdown</div>
      <div class="a-text">Proportion of disaster events recorded over the past 12 months.</div>
      <div class="bar-chart">
        <div class="bc-row">
          <div class="bc-lbl">Flooding</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:74%;background:var(--blue)"></div></div>
          <div class="bc-val">74%</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl">Landslides</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:52%;background:var(--amber)"></div></div>
          <div class="bc-val">52%</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl">Cyclones</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:31%;background:var(--accent)"></div></div>
          <div class="bc-val">31%</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl">Droughts</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:22%;background:var(--green)"></div></div>
          <div class="bc-val">22%</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl">Other</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:14%;background:var(--muted)"></div></div>
          <div class="bc-val">14%</div>
        </div>
      </div>
    </div>

    <!-- Resource Allocation -->
    <div class="analysis-card reveal">
      <div class="a-icon">🚒</div>
      <div class="a-title">Resource Allocation</div>
      <div class="a-text">Current distribution of emergency resources across active incident zones.</div>
      <div class="progress-bar-wrap" style="margin-top:1.2rem">
        <div class="pb-label"><span>Rescue Personnel</span><span>1,840 / 2,200</span></div>
        <div class="pb"><div class="pb-fill red"   style="width:84%"></div></div>
      </div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span>Vehicles Deployed</span><span>280 / 400</span></div>
        <div class="pb"><div class="pb-fill amber" style="width:70%"></div></div>
      </div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span>Shelter Capacity</span><span>9,200 / 12,000</span></div>
        <div class="pb"><div class="pb-fill green" style="width:77%"></div></div>
      </div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span>Medical Units</span><span>46 / 60</span></div>
        <div class="pb"><div class="pb-fill blue"  style="width:77%"></div></div>
      </div>
    </div>

    <!-- Response Times -->
    <div class="analysis-card reveal">
      <div class="a-icon">⏱️</div>
      <div class="a-title">Average Response Times</div>
      <div class="a-text">Time from incident alert to first-responder arrival, broken down by district tier.</div>
      <div class="bar-chart">
        <div class="bc-row">
          <div class="bc-lbl">Urban Tier 1</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:25%;background:var(--green)"></div></div>
          <div class="bc-val">12 min</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl">Urban Tier 2</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:46%;background:var(--blue)"></div></div>
          <div class="bc-val">22 min</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl">Semi-Rural</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:68%;background:var(--amber)"></div></div>
          <div class="bc-val">34 min</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl">Remote</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:88%;background:var(--accent)"></div></div>
          <div class="bc-val">58 min</div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ══ VISION & MISSION ══ -->
<section id="vision" style="border-top:1px solid var(--border);">
  <div class="vm-bg"></div>
  <div class="reveal">
    <div class="section-label">WHO WE ARE</div>
    <h2 class="section-title">Vision &amp; Mission</h2>
    <div class="section-divider"></div>
  </div>

  <div class="vm-grid">

    <div class="vm-card reveal">
      <div class="vm-card-tag">OUR VISION</div>
      <div class="vm-card-title">A Resilient Nation, Every Life Protected</div>
      <div class="vm-card-text">
        We envision a Sri Lanka where no community is left behind in times of crisis — a nation where
        cutting-edge technology, coordinated governance, and community empowerment converge to protect
        every life, minimise displacement, and accelerate recovery from any disaster.
      </div>
      <div class="vm-pillars">
        <div class="pillar"><span class="pillar-icon">🛡️</span>Zero Preventable Loss</div>
        <div class="pillar"><span class="pillar-icon">🤝</span>Inclusive Response</div>
        <div class="pillar"><span class="pillar-icon">📡</span>Tech-Driven Alerts</div>
        <div class="pillar"><span class="pillar-icon">🌍</span>Community First</div>
      </div>
    </div>

    <div class="vm-card reveal">
      <div class="vm-card-tag">OUR MISSION</div>
      <div class="vm-card-title">Coordinate. Respond. Rebuild.</div>
      <div class="vm-card-text">
        Our mission is to provide a unified, real-time disaster response coordination platform that
        connects government agencies, emergency services, NGOs, and communities — enabling faster
        decisions, smarter resource deployment, and data-driven relief operations across every
        district of Sri Lanka, 24 hours a day, 365 days a year.
      </div>
      <div class="vm-pillars">
        <div class="pillar"><span class="pillar-icon">⚡</span>Rapid Mobilisation</div>
        <div class="pillar"><span class="pillar-icon">📊</span>Data Intelligence</div>
        <div class="pillar"><span class="pillar-icon">🏥</span>Life-Saving Care</div>
        <div class="pillar"><span class="pillar-icon">🔄</span>Continuous Recovery</div>
      </div>
    </div>

  </div>
</section>

<!-- FOOTER -->
<footer>
  <p>© 2025 <span>DRCS</span> — Disaster Response Coordination System · Sri Lanka</p>
  <p style="margin-top:.4rem;">Emergency Hotline: <span>1919</span> &nbsp;|&nbsp; Operated by the National Disaster Management Authority</p>
</footer>

<!-- MODALS -->
<div id="modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:2000;align-items:center;justify-content:center;backdrop-filter:blur(6px)">
  <div id="modal-box" style="background:var(--card);border:1px solid var(--border);border-radius:16px;padding:2.5rem;width:min(420px,90vw);position:relative;">
    <button onclick="closeModal()" style="position:absolute;top:1rem;right:1rem;background:none;border:none;color:var(--muted);font-size:1.4rem;cursor:pointer;">✕</button>
    <div id="modal-content"></div>
  </div>
</div>

<script src="main.js"></script>
</body>
</html>
