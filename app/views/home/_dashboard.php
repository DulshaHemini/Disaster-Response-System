<!-- DASHBOARD -->
<section id="dashboard">
  <div class="reveal">
    <div class="section-pre">LIVE OVERVIEW</div>
    <h2>Situation Dashboard</h2>
  </div>

  <!-- KPI Cards -->
  <div class="dash-grid">
    <?php foreach ($kpis as $kpi): ?>
    <div class="kpi-card <?= htmlspecialchars($kpi['color']) ?> reveal">
      <div class="kpi-icon"><?= $kpi['icon'] ?></div>
      <div class="kpi-val"><?= htmlspecialchars($kpi['value']) ?></div>
      <div class="kpi-label"><?= htmlspecialchars($kpi['label']) ?></div>
      <div class="kpi-delta <?= htmlspecialchars($kpi['trend']) ?>">
        <?= htmlspecialchars($kpi['delta']) ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Map + Alerts -->
  <div class="dash-lower reveal">
    <div class="map-card">
      <div class="card-label">// INCIDENT MAP — SRI LANKA</div>
      <div class="map-visual">
        <div class="map-pin p1"></div>
        <div class="map-pin p2"></div>
        <div class="map-pin p3"></div>
        <span style="position:relative;z-index:1;font-size:.75rem;">Interactive map loads on deployment</span>
      </div>
    </div>

    <div class="alerts-card">
      <div class="card-label">// LIVE ALERTS</div>
      <?php foreach ($alerts as $alert): ?>
      <div class="alert-item">
        <span class="alert-dot <?= htmlspecialchars($alert['type']) ?>"></span>
        <div>
          <div class="alert-text"><?= htmlspecialchars($alert['text']) ?></div>
          <div class="alert-time"><?= htmlspecialchars($alert['time']) ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
