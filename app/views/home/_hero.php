<!-- HERO -->
<div class="hero">
  <div class="hero-lines"></div>

  <div class="hero-badge">
    <span></span> LIVE SYSTEM ACTIVE
  </div>

  <h1 class="fade-up">DISASTER<br><em>RESPONSE</em><br>COORDINATION</h1>
  <p class="hero-sub fade-up">
    Real-time coordination platform for emergency response teams, government agencies,
    and first responders across Sri Lanka — powered by live data and field intelligence.
  </p>

  <div class="hero-cta fade-up">
    <button class="btn-help" onclick="instantHelp()">
      <span class="pulse-dot"></span> INSTANT HELP
    </button>
    <button class="btn-lg btn-lg-ghost" onclick="scrollTo('dashboard')">View Dashboard</button>
  </div>

  <div class="stat-row">
    <?php foreach ($heroStats as $stat): ?>
    <div class="stat-item">
      <div class="stat-num">
        <?= htmlspecialchars($stat['num']) ?><em><?= htmlspecialchars($stat['suffix']) ?></em>
      </div>
      <div class="stat-label"><?= htmlspecialchars($stat['label']) ?></div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
