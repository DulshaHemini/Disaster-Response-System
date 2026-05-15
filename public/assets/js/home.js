/**
 * DRCS – Main JavaScript
 */

/* ── SCROLL REVEAL ── */
(function initReveal() {
  const revealEls = document.querySelectorAll('.reveal');
  const observer  = new IntersectionObserver(
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
  if (el) el.scrollIntoView({ behavior: 'smooth' });
}

/* ── LANGUAGE SWITCHER ── */
const labels = {
  en: { help: 'INSTANT HELP', signin: 'Sign In',  signup: 'Sign Up'        },
  si: { help: 'ක්ෂණික සහාය',  signin: 'පිවිසෙන්න', signup: 'ලියාපදිංචි'  },
  ta: { help: 'உடனடி உதவி',   signin: 'உள்நுழை',   signup: 'பதிவு செய்'  },
};

function setLang(lang, btn) {
  document.querySelectorAll('.lang-btn').forEach((b) => b.classList.remove('active'));
  btn.classList.add('active');

  const t = labels[lang] || labels.en;

  const helpBtn = document.querySelector('.btn-help');
  if (helpBtn) {
    helpBtn.innerHTML = '<span class="pulse-dot"></span> ' + t.help;
  }

  const signInBtn = document.querySelector('.btn-outline');
  if (signInBtn) signInBtn.textContent = t.signin;

  const signUpBtn = document.querySelector('.btn-fill');
  if (signUpBtn) signUpBtn.textContent = t.signup;
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

// Close on backdrop click
document.getElementById('modal-overlay').addEventListener('click', (e) => {
  if (e.target.id === 'modal-overlay') closeModal();
});

// Close on Escape key
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeModal();
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
    <p class="modal-sub">Emergency contacts — available 24/7</p>
    <div class="contact-list">${rows}</div>
  `;

  // Inject scoped styles if not already present
  if (!document.getElementById('modal-contact-styles')) {
    const style = document.createElement('style');
    style.id = 'modal-contact-styles';
    style.textContent = `
      .modal-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: .4rem; }
      .modal-title--red { color: var(--red); }
      .modal-sub { color: var(--muted); font-size: .85rem; margin-bottom: 1.4rem; }
      .contact-list { display: grid; gap: .65rem; }
      .contact-row {
        display: flex; justify-content: space-between; align-items: center;
        background: var(--off); border: 1.5px solid var(--border);
        border-radius: 8px; padding: .85rem 1rem;
      }
      .contact-label { font-size: .88rem; }
      .contact-number {
        font-family: 'JetBrains Mono', monospace; color: var(--red);
        font-weight: 700; text-decoration: none; font-size: .9rem;
      }
      .contact-number:hover { text-decoration: underline; }
      .modal-form { display: flex; flex-direction: column; gap: .9rem; }
      .modal-submit {
        background: var(--red); color: #fff; border: none; border-radius: 8px;
        padding: .8rem; font-family: 'Outfit', sans-serif; font-size: .92rem;
        font-weight: 600; cursor: pointer; transition: background .2s;
      }
      .modal-submit:hover { background: var(--red-dk); }
      .modal-link { text-align: center; font-size: .8rem; color: var(--muted); }
      .modal-link a { color: var(--red); text-decoration: none; }
    `;
    document.head.appendChild(style);
  }

  showModal();
}

/* ── SIGN IN / SIGN UP MODALS ── */
function openModal(type) {
  const content = document.getElementById('modal-content');

  if (type === 'signin') {
    content.innerHTML = `
      <h2 class="modal-title" style="margin-bottom:1.4rem;">Sign In</h2>
      <div class="modal-form">
        <input type="text"     placeholder="Username / Email" autocomplete="username"/>
        <input type="password" placeholder="Password"         autocomplete="current-password"/>
        <button class="modal-submit" onclick="handleSignIn(event)">Sign In</button>
        <p class="modal-link">No account?
          <a href="#" onclick="openModal('signup');return false;">Sign Up</a>
        </p>
      </div>
    `;
  } else {
    content.innerHTML = `
      <h2 class="modal-title" style="margin-bottom:1.4rem;">Create Account</h2>
      <div class="modal-form">
        <input type="text"     placeholder="Full Name"  autocomplete="name"/>
        <input type="email"    placeholder="Email"      autocomplete="email"/>
        <input type="password" placeholder="Password"   autocomplete="new-password"/>
        <select aria-label="Select role">
          <option value="">Select Role</option>
          <option value="responder">First Responder</option>
          <option value="coordinator">Field Coordinator</option>
          <option value="government">Government Agency</option>
          <option value="ngo">NGO / Volunteer</option>
          <option value="public">Public User</option>
        </select>
        <button class="modal-submit" onclick="handleSignUp(event)">Create Account</button>
      </div>
    `;
  }

  showModal();
}

/* ── FORM HANDLERS (stubs – wire to your backend) ── */
function handleSignIn(e) {
  e.preventDefault();
  // TODO: POST to /index.php?controller=auth&action=signin
  alert('Sign-in submitted — connect to your auth controller.');
}

function handleSignUp(e) {
  e.preventDefault();
  // TODO: POST to /index.php?controller=auth&action=signup
  alert('Registration submitted — connect to your auth controller.');
}
