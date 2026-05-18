<!-- NAVBAR -->
<nav>
  <a class="nav-brand" href="index.php">
    <div class="logo-icon">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 15h-2v-2h2zm0-4h-2V7h2z"/>
      </svg>
    </div>
    <span class="brand-text">DR<em>CS</em></span>
  </a>

  <div class="nav-center">
    <div class="lang-switcher">
      <button class="lang-btn" onclick="setLang('si',this)">සිං</button>
      <button class="lang-btn active" onclick="setLang('en',this)">EN</button>
      <button class="lang-btn" onclick="setLang('ta',this)">தமி</button>
    </div>
  </div>

  <div class="nav-right">
    <button class="btn-outline" onclick="window.location.href='../app/controllers/signin.php'">Sign In</button>
    <button class="btn-fill" onclick="window.location.href='../app/controllers/signup.php'">Sign Up</button>
</div>
</nav>
