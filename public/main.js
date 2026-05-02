/* DRCS – main.js */

/* ── SCROLL REVEAL ── */
const revealEls = document.querySelectorAll('.reveal');
const ro = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) { e.target.classList.add('in'); ro.unobserve(e.target); }
  });
}, { threshold: .12 });
revealEls.forEach(el => ro.observe(el));

/* ── SMOOTH SCROLL ── */
function scrollTo(id) {
  document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
}

/* ── LANGUAGE SWITCHER ── */
const labels = {
  en: { help: 'INSTANT HELP', signin: 'Sign In', signup: 'Sign Up' },
  si: { help: 'ක්‍ෂණික සහාය', signin: 'පිවිසෙන්න', signup: 'ලියාපදිංචි' },
  ta: { help: 'உடனடி உதவி', signin: 'உள்நுழை', signup: 'பதிவு செய்' }
};
function setLang(l) {
  document.querySelectorAll('.lang-btn').forEach(b => b.classList.remove('active'));
  event.target.classList.add('active');
  document.querySelector('.btn-help').textContent = '🚨 ' + labels[l].help;
  document.querySelectorAll('.btn-outline')[0].textContent = labels[l].signin;
  document.querySelector('.btn-fill').textContent = labels[l].signup;
}

/* ── MODAL HELPERS ── */
function inputStyle() {
  return `background:var(--surface);border:1px solid var(--border);border-radius:8px;padding:.75rem 1rem;color:var(--text);font-family:var(--font-bd);font-size:.9rem;width:100%;outline:none;`;
}
function btnStyle(bg) {
  return `background:${bg};color:#fff;border:none;border-radius:8px;padding:.8rem;font-family:var(--font-bd);font-size:.95rem;font-weight:600;cursor:pointer;width:100%;`;
}
function showModal() {
  document.getElementById('modal-overlay').style.display = 'flex';
}
function closeModal() {
  document.getElementById('modal-overlay').style.display = 'none';
}
document.getElementById('modal-overlay').addEventListener('click', e => {
  if (e.target.id === 'modal-overlay') closeModal();
});

/* ── INSTANT HELP ── */
function instantHelp() {
  document.getElementById('modal-content').innerHTML = `
    <h2 style="font-family:var(--font-hd);font-size:2rem;color:var(--accent);margin-bottom:.5rem;">🚨 INSTANT HELP</h2>
    <p style="color:var(--muted);font-size:.9rem;margin-bottom:1.5rem;">Emergency contacts — available 24 / 7</p>
    <div style="display:grid;gap:.75rem;">
      ${[['🏥 Ambulance','110'],['🚒 Fire & Rescue','111'],['👮 Police Emergency','119'],['🌊 Disaster Hotline','1919'],['☎️ NDMA HQ','0112136136']].map(([l,n]) =>
        `<div style="display:flex;justify-content:space-between;align-items:center;background:var(--surface);border:1px solid var(--border);border-radius:8px;padding:.9rem 1.1rem;">
          <span style="font-size:.9rem;">${l}</span>
          <a href="tel:${n}" style="font-family:var(--font-mn);color:var(--accent);font-weight:700;text-decoration:none;">${n}</a>
        </div>`).join('')}
    </div>`;
  showModal();
}

/* ── SIGN IN / SIGN UP ── */
function openModal(type) {
  if (type === 'signin') {
    document.getElementById('modal-content').innerHTML = `
      <h2 style="font-family:var(--font-hd);font-size:2rem;margin-bottom:1.5rem;">Sign In</h2>
      <div style="display:flex;flex-direction:column;gap:1rem;">
        <input type="text"     placeholder="Username / Email" style="${inputStyle()}">
        <input type="password" placeholder="Password"         style="${inputStyle()}">
        <button style="${btnStyle('var(--accent)')}" onclick="alert('Login submitted')">Sign In</button>
        <p style="text-align:center;font-size:.82rem;color:var(--muted);">Don't have an account?
          <a href="#" onclick="openModal('signup');return false;" style="color:var(--accent)">Sign Up</a></p>
      </div>`;
  } else {
    document.getElementById('modal-content').innerHTML = `
      <h2 style="font-family:var(--font-hd);font-size:2rem;margin-bottom:1.5rem;">Create Account</h2>
      <div style="display:flex;flex-direction:column;gap:1rem;">
        <input type="text"     placeholder="Full Name" style="${inputStyle()}">
        <input type="email"    placeholder="Email"     style="${inputStyle()}">
        <input type="password" placeholder="Password"  style="${inputStyle()}">
        <select style="${inputStyle()}">
          <option value="">Select Role</option>
          <option>First Responder</option>
          <option>Field Coordinator</option>
          <option>Government Agency</option>
          <option>NGO / Volunteer</option>
          <option>Public User</option>
        </select>
        <button style="${btnStyle('var(--accent)')}" onclick="alert('Registration submitted')">Create Account</button>
      </div>`;
  }
  showModal();
}
