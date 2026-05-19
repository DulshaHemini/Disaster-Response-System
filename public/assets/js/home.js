/**
 * DRCS – Main JavaScript
 */

/* ── SCROLL REVEAL ── */
(function initReveal() {
  const revealEls = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in');
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.1 }
  );

  revealEls.forEach((el) => observer.observe(el));
})();

/* ── SMOOTH SCROLL HELPER ── */
function scrollTo(id) {
  const el = document.getElementById(id);

  if (el) {
    el.scrollIntoView({ behavior: 'smooth' });
  }
}

/* ── LANGUAGE SWITCHER ── */
const labels = {
  en: { help: 'INSTANT HELP' },
  si: { help: 'ක්ෂණික සහාය' },
  ta: { help: 'உடனடி உதவி' },
};

function setLang(lang, btn) {

  document.querySelectorAll('.lang-btn').forEach((b) => {
    b.classList.remove('active');
  });

  btn.classList.add('active');

  const t = labels[lang] || labels.en;

  const helpBtn = document.querySelector('.btn-help');

  if (helpBtn) {
    helpBtn.innerHTML =
      '<span class="pulse-dot"></span> ' + t.help;
  }
}

/* ── MODAL HELPERS ── */
function showModal() {
  const overlay = document.getElementById('modal-overlay');
  overlay.style.display = 'flex';
}

function closeModal() {
  const overlay = document.getElementById('modal-overlay');
  overlay.style.display = 'none';
}

/* ── CLOSE MODAL ON BACKDROP CLICK ── */
document.getElementById('modal-overlay').addEventListener('click', (e) => {
  if (e.target.id === 'modal-overlay') {
    closeModal();
  }
});

/* ── CLOSE MODAL ON ESCAPE KEY ── */
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    closeModal();
  }
});

/* ── INSTANT HELP MODAL ── */
function instantHelp() {

  const contacts = window.DRCS_EMERGENCY_CONTACTS || [];

  const rows = contacts.map(({ label, number }) => `
    <div class="contact-row">
      <span class="contact-label">${label}</span>
      <a href="tel:${number}" class="contact-number">${number}</a>
    </div>
  `).join('');

  document.getElementById('modal-content').innerHTML = `
    <h2 class="modal-title modal-title--red">🚨 Instant Help</h2>

    <p class="modal-sub">
      Emergency contacts — available 24/7
    </p>

    <div class="contact-list">
      ${rows}
    </div>
  `;

  /* Inject modal styles only once */
  if (!document.getElementById('modal-contact-styles')) {

    const style = document.createElement('style');

    style.id = 'modal-contact-styles';

    style.textContent = `
      .modal-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        margin-bottom: .4rem;
      }

      .modal-title--red {
        color: var(--red);
      }

      .modal-sub {
        color: var(--muted);
        font-size: .85rem;
        margin-bottom: 1.4rem;
      }

      .contact-list {
        display: grid;
        gap: .65rem;
      }

      .contact-row {
        display: flex;
        justify-content: space-between;
        align-items: center;

        background: var(--off);
        border: 1.5px solid var(--border);

        border-radius: 8px;
        padding: .85rem 1rem;
      }

      .contact-label {
        font-size: .88rem;
      }

      .contact-number {
        font-family: 'JetBrains Mono', monospace;
        color: var(--red);

        font-weight: 700;
        text-decoration: none;
        font-size: .9rem;
      }

      .contact-number:hover {
        text-decoration: underline;
      }
    `;

    document.head.appendChild(style);
  }

  showModal();
}
