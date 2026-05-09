<!-- OBJECT NEEDS -->
<section id="needs" class="border-sect needs-section">
  <div class="section-inner">
    <div class="reveal">
      <div class="section-pre">DISASTER SITE REQUIREMENTS</div>
      <h2>Object Needs</h2>
      <p class="needs-intro">
        Real-time inventory of critical resources required across active disaster zones.
        Items marked critical require immediate procurement and dispatch.
      </p>
    </div>

    <div class="needs-grid reveal">
      <?php foreach ($needs as $need): ?>
      <div class="need-card <?= htmlspecialchars($need['cardClass']) ?>">
        <div class="need-icon-wrap"><?= $need['icon'] ?></div>
        <div class="need-name"><?= htmlspecialchars($need['name']) ?></div>
        <div class="need-qty"><?= htmlspecialchars($need['qty']) ?></div>
        <div class="need-status <?= htmlspecialchars($need['status']) ?>">
          <?= htmlspecialchars($need['statusText']) ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
