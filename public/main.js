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
let currentLang = localStorage.getItem('drcs_lang') || 'en';

function setLang(l) {
  currentLang = l;
  localStorage.setItem('drcs_lang', l);
  
  // Update buttons
  document.querySelectorAll('.lang-btn').forEach(b => b.classList.remove('active'));
  const btn = document.querySelector(`.lang-btn[data-lang="${l}"]`);
  if (btn) btn.classList.add('active');

  // Update all data-i18n elements
  document.querySelectorAll('[data-i18n]').forEach(el => {
    const key = el.getAttribute('data-i18n');
    if (window.translations && window.translations[l] && window.translations[l][key]) {
      el.innerHTML = window.translations[l][key];
    }
  });
}

// Initialize on load
document.addEventListener("DOMContentLoaded", () => {
  setLang(currentLang);
});

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
  const t = window.translations[currentLang];
  document.getElementById('modal-content').innerHTML = `
    <h2 style="font-family:var(--font-hd);font-size:2rem;color:var(--accent);margin-bottom:.5rem;">${t['modal-help-title']}</h2>
    <p style="color:var(--muted);font-size:.9rem;margin-bottom:1.5rem;">${t['modal-help-sub']}</p>
    <div style="display:grid;gap:.75rem;">
      ${[[t['modal-amb'],'110'],[t['modal-fire'],'111'],[t['modal-pol'],'119'],[t['modal-dis'],'1919'],[t['modal-ndma'],'0112136136']].map(([l,n]) =>
        `<div style="display:flex;justify-content:space-between;align-items:center;background:var(--surface);border:1px solid var(--border);border-radius:8px;padding:.9rem 1.1rem;">
          <span style="font-size:.9rem;">${l}</span>
          <a href="tel:${n}" style="font-family:var(--font-mn);color:var(--accent);font-weight:700;text-decoration:none;">${n}</a>
        </div>`).join('')}
    </div>`;
  showModal();
}

/* ── SIGN IN / SIGN UP ── */
function openModal(type) {
  const t = window.translations[currentLang];
  if (type === 'signin') {
    document.getElementById('modal-content').innerHTML = `
      <h2 style="font-family:var(--font-hd);font-size:2rem;margin-bottom:1.5rem;">${t['modal-signin-title']}</h2>
      <div style="display:flex;flex-direction:column;gap:1rem;">
        <input type="text"     placeholder="${t['modal-user']}" style="${inputStyle()}">
        <input type="password" placeholder="${t['modal-pass']}"         style="${inputStyle()}">
        <button style="${btnStyle('var(--accent)')}" onclick="alert('Login submitted')">${t['modal-signin-title']}</button>
        <p style="text-align:center;font-size:.82rem;color:var(--muted);">${t['modal-noacc']}
          <a href="#" onclick="openModal('signup');return false;" style="color:var(--accent)">${t['modal-signup-btn']}</a></p>
      </div>`;
  } else {
    document.getElementById('modal-content').innerHTML = `
      <h2 style="font-family:var(--font-hd);font-size:2rem;margin-bottom:1.5rem;">${t['modal-signup-title']}</h2>
      <div style="display:flex;flex-direction:column;gap:1rem;">
        <input type="text"     placeholder="${t['modal-name']}" style="${inputStyle()}">
        <input type="email"    placeholder="${t['modal-email']}"     style="${inputStyle()}">
        <input type="password" placeholder="${t['modal-pass']}"  style="${inputStyle()}">
        <select style="${inputStyle()}">
          <option value="">${t['modal-role']}</option>
          <option>${t['modal-r1']}</option>
          <option>${t['modal-r2']}</option>
          <option>${t['modal-r3']}</option>
          <option>${t['modal-r4']}</option>
          <option>${t['modal-r5']}</option>
        </select>
        <button style="${btnStyle('var(--accent)')}" onclick="alert('Registration submitted')">${t['modal-create-btn']}</button>
      </div>`;
  }
  showModal();
}
