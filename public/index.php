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
      <button class="lang-btn" data-lang="si" onclick="setLang('si')">සිං</button>
      <button class="lang-btn active" data-lang="en" onclick="setLang('en')">EN</button>
      <button class="lang-btn" data-lang="ta" onclick="setLang('ta')">தமி</button>
    </div>
  </div>

  <div class="nav-right">
    <button class="btn-help" onclick="instantHelp()" data-i18n="nav-help">INSTANT HELP</button>
    <button class="btn-outline" onclick="openModal('signin')" data-i18n="nav-signin">Sign In</button>
    <button class="btn-fill"   onclick="openModal('signup')" data-i18n="nav-signup">Sign Up</button>
  </div>
</nav>

<!-- ALERT TICKER -->
<div class="ticker-wrap" style="margin-top:64px;">
  <span class="ticker">
    <span data-i18n="ticker-1">🔴 ACTIVE — Flooding Alert: Southern Province, Sri Lanka &nbsp;|&nbsp;</span>
    <span data-i18n="ticker-2">🟡 WARNING — Landslide Risk: Ratnapura District &nbsp;|&nbsp;</span>
    <span data-i18n="ticker-3">🟢 RESOLVED — Cyclone Watch lifted: Eastern Coast &nbsp;|&nbsp;</span>
    <span data-i18n="ticker-4">🔴 ACTIVE — Search &amp; Rescue teams deployed: Galle &nbsp;|&nbsp;</span>
    <span data-i18n="ticker-5">📡 Emergency Coordination Centre is operational 24/7 &nbsp;&nbsp;&nbsp;&nbsp;</span>
  </span>
</div>

<!-- HERO -->
<div class="hero">
  <div class="hero-bg"></div>
  <div class="hero-grid"></div>

  <div class="hero-badge fade-up">
    <span class="badge-dot"></span>
    <span data-i18n="hero-badge">LIVE SYSTEM OPERATIONAL</span>
  </div>

  <h1 class="fade-up" data-i18n="hero-title">
    DISASTER<br><span class="red">RESPONSE</span><br>COORDINATION
  </h1>

  <p class="hero-sub fade-up" data-i18n="hero-sub">
    Real-time coordination platform for emergency response teams, government agencies,
    and first responders across Sri Lanka — powered by live data and field intelligence.
  </p>

  <div class="hero-cta fade-up">
    <button class="btn-lg btn-lg-primary" onclick="scrollTo('dashboard')" data-i18n="hero-cta-1">View Dashboard</button>
    <button class="btn-lg btn-lg-ghost"   onclick="scrollTo('analysis')" data-i18n="hero-cta-2">See Analysis</button>
  </div>

  <div class="stat-row">
    <div class="stat-item">
      <div class="stat-num">24<span>/7</span></div>
      <div class="stat-label" data-i18n="stat-label-1">MONITORING</div>
    </div>
    <div class="stat-item">
      <div class="stat-num">142<span>+</span></div>
      <div class="stat-label" data-i18n="stat-label-2">RESPONSE TEAMS</div>
    </div>
    <div class="stat-item">
      <div class="stat-num">9<span data-i18n="stat-dist"> Districts</span></div>
      <div class="stat-label" data-i18n="stat-label-3">ACTIVE ZONES</div>
    </div>
    <div class="stat-item">
      <div class="stat-num">3.2<span>k</span></div>
      <div class="stat-label" data-i18n="stat-label-4">PEOPLE ASSISTED</div>
    </div>
  </div>
</div>

<!-- ══ DASHBOARD ══ -->
<section id="dashboard">
  <div class="dashboard-header reveal">
    <div class="section-label" data-i18n="dash-label">LIVE OVERVIEW</div>
    <h2 class="section-title" data-i18n="dash-title">Situation Dashboard</h2>
    <div class="section-divider"></div>
  </div>

  <div class="dash-grid">
    <div class="kpi-card red reveal">
      <div class="kpi-icon">🆘</div>
      <div class="kpi-val">18</div>
      <div class="kpi-label" data-i18n="kpi-1-label">Active Incidents</div>
      <div class="kpi-delta down" data-i18n="kpi-1-delta">▲ 3 since 6h ago</div>
    </div>
    <div class="kpi-card amber reveal">
      <div class="kpi-icon">⚠️</div>
      <div class="kpi-val">7</div>
      <div class="kpi-label" data-i18n="kpi-2-label">High-Risk Zones</div>
      <div class="kpi-delta up" data-i18n="kpi-2-delta">▼ 2 since yesterday</div>
    </div>
    <div class="kpi-card green reveal">
      <div class="kpi-icon">🚁</div>
      <div class="kpi-val">142</div>
      <div class="kpi-label" data-i18n="kpi-3-label">Teams Deployed</div>
      <div class="kpi-delta up" data-i18n="kpi-3-delta">▲ 12 mobilised today</div>
    </div>
    <div class="kpi-card blue reveal">
      <div class="kpi-icon">🏥</div>
      <div class="kpi-val">3,214</div>
      <div class="kpi-label" data-i18n="kpi-4-label">People Evacuated</div>
      <div class="kpi-delta up" data-i18n="kpi-4-delta">▲ 480 in last 24h</div>
    </div>
  </div>

  <div class="dash-lower reveal">
    <div class="map-card">
      <div class="map-card-title" data-i18n="map-title">// INCIDENT MAP — SRI LANKA</div>
      <div class="map-visual">
        <div class="map-pin p1"></div>
        <div class="map-pin p2"></div>
        <div class="map-pin p3"></div>
        <span data-i18n="map-desc" style="position:relative;z-index:1;font-size:.75rem;color:var(--muted);">
          Interactive map loads on deployment
        </span>
      </div>
    </div>

    <div class="alerts-card">
      <div class="alerts-title" data-i18n="alerts-title">// LIVE ALERTS</div>

      <div class="alert-item">
        <span class="alert-dot critical"></span>
        <div>
          <div class="alert-text" data-i18n="alert-1-txt">Flash flood reported — Baddegama, Galle</div>
          <div class="alert-time" data-i18n="alert-1-time">2 min ago</div>
        </div>
      </div>
      <div class="alert-item">
        <span class="alert-dot warning"></span>
        <div>
          <div class="alert-text" data-i18n="alert-2-txt">Landslide risk elevated — Ratnapura</div>
          <div class="alert-time" data-i18n="alert-2-time">14 min ago</div>
        </div>
      </div>
      <div class="alert-item">
        <span class="alert-dot info"></span>
        <div>
          <div class="alert-text" data-i18n="alert-3-txt">Relief convoy dispatched to Matara</div>
          <div class="alert-time" data-i18n="alert-3-time">31 min ago</div>
        </div>
      </div>
      <div class="alert-item">
        <span class="alert-dot critical"></span>
        <div>
          <div class="alert-text" data-i18n="alert-4-txt">Road closure: A2 Highway blocked by debris</div>
          <div class="alert-time" data-i18n="alert-4-time">52 min ago</div>
        </div>
      </div>
      <div class="alert-item">
        <span class="alert-dot warning"></span>
        <div>
          <div class="alert-text" data-i18n="alert-5-txt">Shelter capacity at 87% — Kalutara</div>
          <div class="alert-time" data-i18n="alert-5-time">1h 10m ago</div>
        </div>
      </div>
      <div class="alert-item">
        <span class="alert-dot info"></span>
        <div>
          <div class="alert-text" data-i18n="alert-6-txt">Medical team air-lifted to Hambantota</div>
          <div class="alert-time" data-i18n="alert-6-time">2h ago</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ ANALYSIS ══ -->
<section id="analysis" style="border-top:1px solid var(--border);">
  <div class="reveal">
    <div class="section-label" data-i18n="analysis-label">INTELLIGENCE &amp; DATA</div>
    <h2 class="section-title" data-i18n="analysis-title">Disaster Response Analysis</h2>
    <div class="section-divider"></div>
  </div>

  <div class="analysis-grid">

    <!-- Response Readiness -->
    <div class="analysis-card reveal">
      <div class="a-icon">📊</div>
      <div class="a-title" data-i18n="card-1-title">Response Readiness Index</div>
      <div class="a-text" data-i18n="card-1-txt">Real-time measurement of provincial preparedness across key readiness dimensions.</div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span data-i18n="prov-1">Southern Province</span><span>82%</span></div>
        <div class="pb"><div class="pb-fill red"   style="width:82%"></div></div>
      </div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span data-i18n="prov-2">Sabaragamuwa</span><span>67%</span></div>
        <div class="pb"><div class="pb-fill amber" style="width:67%"></div></div>
      </div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span data-i18n="prov-3">Western Province</span><span>91%</span></div>
        <div class="pb"><div class="pb-fill green" style="width:91%"></div></div>
      </div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span data-i18n="prov-4">Eastern Province</span><span>58%</span></div>
        <div class="pb"><div class="pb-fill blue"  style="width:58%"></div></div>
      </div>
    </div>

    <!-- Disaster Type Breakdown -->
    <div class="analysis-card reveal">
      <div class="a-icon">🌊</div>
      <div class="a-title" data-i18n="card-2-title">Disaster Type Breakdown</div>
      <div class="a-text" data-i18n="card-2-txt">Proportion of disaster events recorded over the past 12 months.</div>
      <div class="bar-chart">
        <div class="bc-row">
          <div class="bc-lbl" data-i18n="dt-1">Flooding</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:74%;background:var(--blue)"></div></div>
          <div class="bc-val">74%</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl" data-i18n="dt-2">Landslides</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:52%;background:var(--amber)"></div></div>
          <div class="bc-val">52%</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl" data-i18n="dt-3">Cyclones</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:31%;background:var(--accent)"></div></div>
          <div class="bc-val">31%</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl" data-i18n="dt-4">Droughts</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:22%;background:var(--green)"></div></div>
          <div class="bc-val">22%</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl" data-i18n="dt-5">Other</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:14%;background:var(--muted)"></div></div>
          <div class="bc-val">14%</div>
        </div>
      </div>
    </div>

    <!-- Resource Allocation -->
    <div class="analysis-card reveal">
      <div class="a-icon">🚒</div>
      <div class="a-title" data-i18n="card-3-title">Resource Allocation</div>
      <div class="a-text" data-i18n="card-3-txt">Current distribution of emergency resources across active incident zones.</div>
      <div class="progress-bar-wrap" style="margin-top:1.2rem">
        <div class="pb-label"><span data-i18n="ra-1">Rescue Personnel</span><span>1,840 / 2,200</span></div>
        <div class="pb"><div class="pb-fill red"   style="width:84%"></div></div>
      </div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span data-i18n="ra-2">Vehicles Deployed</span><span>280 / 400</span></div>
        <div class="pb"><div class="pb-fill amber" style="width:70%"></div></div>
      </div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span data-i18n="ra-3">Shelter Capacity</span><span>9,200 / 12,000</span></div>
        <div class="pb"><div class="pb-fill green" style="width:77%"></div></div>
      </div>
      <div class="progress-bar-wrap">
        <div class="pb-label"><span data-i18n="ra-4">Medical Units</span><span>46 / 60</span></div>
        <div class="pb"><div class="pb-fill blue"  style="width:77%"></div></div>
      </div>
    </div>

    <!-- Response Times -->
    <div class="analysis-card reveal">
      <div class="a-icon">⏱️</div>
      <div class="a-title" data-i18n="card-4-title">Average Response Times</div>
      <div class="a-text" data-i18n="card-4-txt">Time from incident alert to first-responder arrival, broken down by district tier.</div>
      <div class="bar-chart">
        <div class="bc-row">
          <div class="bc-lbl" data-i18n="rt-1">Urban Tier 1</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:25%;background:var(--green)"></div></div>
          <div class="bc-val" data-i18n="rt-v1">12 min</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl" data-i18n="rt-2">Urban Tier 2</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:46%;background:var(--blue)"></div></div>
          <div class="bc-val" data-i18n="rt-v2">22 min</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl" data-i18n="rt-3">Semi-Rural</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:68%;background:var(--amber)"></div></div>
          <div class="bc-val" data-i18n="rt-v3">34 min</div>
        </div>
        <div class="bc-row">
          <div class="bc-lbl" data-i18n="rt-4">Remote</div>
          <div class="bc-bar-wrap"><div class="bc-bar" style="width:88%;background:var(--accent)"></div></div>
          <div class="bc-val" data-i18n="rt-v4">58 min</div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ══ VISION & MISSION ══ -->
<section id="vision" style="border-top:1px solid var(--border);">
  <div class="vm-bg"></div>
  <div class="reveal">
    <div class="section-label" data-i18n="vm-label">WHO WE ARE</div>
    <h2 class="section-title" data-i18n="vm-title">Vision &amp; Mission</h2>
    <div class="section-divider"></div>
  </div>

  <div class="vm-grid">

    <div class="vm-card reveal">
      <div class="vm-card-tag" data-i18n="vm-v-tag">OUR VISION</div>
      <div class="vm-card-title" data-i18n="vm-v-title">A Resilient Nation, Every Life Protected</div>
      <div class="vm-card-text" data-i18n="vm-v-txt">
        We envision a Sri Lanka where no community is left behind in times of crisis — a nation where
        cutting-edge technology, coordinated governance, and community empowerment converge to protect
        every life, minimise displacement, and accelerate recovery from any disaster.
      </div>
      <div class="vm-pillars">
        <div class="pillar"><span class="pillar-icon">🛡️</span><span data-i18n="vm-v-p1">Zero Preventable Loss</span></div>
        <div class="pillar"><span class="pillar-icon">🤝</span><span data-i18n="vm-v-p2">Inclusive Response</span></div>
        <div class="pillar"><span class="pillar-icon">📡</span><span data-i18n="vm-v-p3">Tech-Driven Alerts</span></div>
        <div class="pillar"><span class="pillar-icon">🌍</span><span data-i18n="vm-v-p4">Community First</span></div>
      </div>
    </div>

    <div class="vm-card reveal">
      <div class="vm-card-tag" data-i18n="vm-m-tag">OUR MISSION</div>
      <div class="vm-card-title" data-i18n="vm-m-title">Coordinate. Respond. Rebuild.</div>
      <div class="vm-card-text" data-i18n="vm-m-txt">
        Our mission is to provide a unified, real-time disaster response coordination platform that
        connects government agencies, emergency services, NGOs, and communities — enabling faster
        decisions, smarter resource deployment, and data-driven relief operations across every
        district of Sri Lanka, 24 hours a day, 365 days a year.
      </div>
      <div class="vm-pillars">
        <div class="pillar"><span class="pillar-icon">⚡</span><span data-i18n="vm-m-p1">Rapid Mobilisation</span></div>
        <div class="pillar"><span class="pillar-icon">📊</span><span data-i18n="vm-m-p2">Data Intelligence</span></div>
        <div class="pillar"><span class="pillar-icon">🏥</span><span data-i18n="vm-m-p3">Life-Saving Care</span></div>
        <div class="pillar"><span class="pillar-icon">🔄</span><span data-i18n="vm-m-p4">Continuous Recovery</span></div>
      </div>
    </div>

  </div>
</section>

<!-- FOOTER -->
<footer>
  <p data-i18n="footer-1">© 2025 <span>DRCS</span> — Disaster Response Coordination System · Sri Lanka</p>
  <p style="margin-top:.4rem;" data-i18n="footer-2">Emergency Hotline: <span>1919</span> &nbsp;|&nbsp; Operated by the National Disaster Management Authority</p>
</footer>

<!-- MODALS -->
<div id="modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:2000;align-items:center;justify-content:center;backdrop-filter:blur(6px)">
  <div id="modal-box" style="background:var(--card);border:1px solid var(--border);border-radius:16px;padding:2.5rem;width:min(420px,90vw);position:relative;">
    <button onclick="closeModal()" style="position:absolute;top:1rem;right:1rem;background:none;border:none;color:var(--muted);font-size:1.4rem;cursor:pointer;">✕</button>
    <div id="modal-content"></div>
  </div>
</div>

<script src="i18n.js"></script>
<script src="main.js"></script>
</body>
</html>
