<!-- ANALYSIS -->
<section id="analysis" class="border-sect">
  <div class="reveal">
    <div class="section-pre">INTELLIGENCE &amp; DATA</div>
    <h2>Disaster Response Analysis</h2>
  </div>

  <div class="analysis-grid">

    <!-- Response Readiness Index -->
    <div class="analysis-card reveal">
      <div class="a-icon">📊</div>
      <div class="a-title">Response Readiness Index</div>
      <div class="a-text">Real-time measurement of provincial preparedness across key readiness dimensions.</div>
      <?php foreach ($readiness as $row): ?>
      <div class="pb-wrap">
        <div class="pb-label">
          <span><?= htmlspecialchars($row['label']) ?></span>
          <span><?= (int)$row['pct'] ?>%</span>
        </div>
        <div class="pb">
          <div class="pb-fill <?= htmlspecialchars($row['color']) ?>" style="width:<?= (int)$row['pct'] ?>%"></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Disaster Type Breakdown -->
    <div class="analysis-card reveal">
      <div class="a-icon">🌊</div>
      <div class="a-title">Disaster Type Breakdown</div>
      <div class="a-text">Proportion of disaster events recorded over the past 12 months.</div>
      <div class="bar-chart">
        <?php foreach ($disasterTypes as $row): ?>
        <div class="bc-row">
          <div class="bc-lbl"><?= htmlspecialchars($row['label']) ?></div>
          <div class="bc-bar-wrap">
            <div class="bc-bar" style="width:<?= (int)$row['pct'] ?>%;background:<?= htmlspecialchars($row['color']) ?>"></div>
          </div>
          <div class="bc-val"><?= (int)$row['pct'] ?>%</div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Resource Allocation -->
    <div class="analysis-card reveal">
      <div class="a-icon">🚒</div>
      <div class="a-title">Resource Allocation</div>
      <div class="a-text">Current distribution of emergency resources across active incident zones.</div>
      <?php foreach ($resourceAllocation as $row): ?>
      <div class="pb-wrap">
        <div class="pb-label">
          <span><?= htmlspecialchars($row['label']) ?></span>
          <span><?= htmlspecialchars($row['detail']) ?></span>
        </div>
        <div class="pb">
          <div class="pb-fill <?= htmlspecialchars($row['color']) ?>" style="width:<?= (int)$row['pct'] ?>%"></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Average Response Times -->
    <div class="analysis-card reveal">
      <div class="a-icon">⏱️</div>
      <div class="a-title">Average Response Times</div>
      <div class="a-text">Time from incident alert to first-responder arrival, broken down by district tier.</div>
      <div class="bar-chart">
        <?php foreach ($responseTimes as $row): ?>
        <div class="bc-row">
          <div class="bc-lbl"><?= htmlspecialchars($row['label']) ?></div>
          <div class="bc-bar-wrap">
            <div class="bc-bar" style="width:<?= (int)$row['pct'] ?>%;background:<?= htmlspecialchars($row['color']) ?>"></div>
          </div>
          <div class="bc-val"><?= htmlspecialchars($row['val']) ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</section>
