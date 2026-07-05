<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>ResQMeal — NGO / Volunteer Login</title>
  <meta name="description" content="Log in or register as an NGO or volunteer to request food donations on ResQMeal." />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/auth.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&amp;family=Inter:wght@300;400;500;600&amp;display=swap" rel="stylesheet" />
  <style>
    /* ── NGO-specific accent overrides ── */
    :root {
      --ngo-primary:   #3B82F6;
      --ngo-secondary: #6366F1;
      --ngo-glow-1:    rgba(59,130,246,.28);
      --ngo-glow-2:    rgba(99,102,241,.20);
    }
    .auth-bg .glow-1 { background: radial-gradient(circle at 30% 40%, var(--ngo-glow-1), transparent 60%); }
    .auth-bg .glow-2 { background: radial-gradient(circle at 75% 65%, var(--ngo-glow-2), transparent 55%); }
    .sidebar-accent  { color: #60A5FA; }
    .sidebar-badge   { border-color: rgba(96,165,250,.35); background: rgba(59,130,246,.12); }
    .pulse-dot       { background: #3B82F6; box-shadow: 0 0 0 6px rgba(59,130,246,.25); }
    .auth-tab.active,
    .tab-indicator   { background: var(--ngo-primary) !important; }
    .btn-auth        { background: linear-gradient(135deg, var(--ngo-primary) 0%, var(--ngo-secondary) 100%) !important; }
    .btn-auth:hover  { box-shadow: 0 8px 30px rgba(59,130,246,.45) !important; }
    .receiver-type-group {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: .75rem;
    }
    .type-option input { display: none; }
    .type-option input:checked + .type-card {
      border-color: var(--ngo-primary);
      background: rgba(59,130,246,.12);
      box-shadow: 0 0 0 2px rgba(59,130,246,.3);
    }
    .ngo-note {
      background: rgba(59,130,246,.1);
      border: 1px solid rgba(59,130,246,.3);
      border-radius: 10px;
      padding: .75rem 1rem;
      font-size: .82rem;
      color: #93C5FD;
      margin-bottom: 1rem;
      line-height: 1.5;
    }
    .ngo-note strong { color: #BFDBFE; }
    .ngo-success-sub { color: rgba(255,255,255,.65); font-size:.9rem; margin-top:.4rem; }
  </style>
</head>
<body class="auth-body">

  <!-- Background -->
  <div class="auth-bg">
    <div class="auth-bg-glow glow-1"></div>
    <div class="auth-bg-glow glow-2"></div>
    <div class="auth-grid-overlay"></div>
  </div>

  <!-- Nav -->
  <nav class="auth-nav">
    <a href="/" class="nav-logo">
      <span class="logo-icon">&#x1F957;</span>
      <span class="logo-text">ResQ<span class="logo-accent">Meal</span></span>
    </a>
    <a href="/" class="auth-back-link">&#x2190; Back to Home</a>
  </nav>

  <!-- Main -->
  <main class="auth-main">

    <!-- Sidebar -->
    <aside class="auth-sidebar">
      <div class="sidebar-inner">
        <div class="sidebar-badge">
          <span class="pulse-dot"></span>
          <span>1,200+ NGOs &amp; volunteers active</span>
        </div>
        <h2 class="sidebar-headline">
          Food ready.<br />
          Your community <span class="sidebar-accent">needs you.</span>
        </h2>
        <p class="sidebar-sub">
          Join verified NGOs and volunteers already collecting surplus food and delivering it to those who need it most across Bangladesh.
        </p>
        <div class="sidebar-stats">
          <div class="ss-item">
            <span class="ss-num">18 min</span>
            <span class="ss-label">Avg. food-to-pickup time</span>
          </div>
          <div class="ss-item">
            <span class="ss-num">96%</span>
            <span class="ss-label">Successful claim rate</span>
          </div>
          <div class="ss-item">
            <span class="ss-num">182K+</span>
            <span class="ss-label">Meals delivered by NGOs</span>
          </div>
        </div>
        <div class="sidebar-feed">
          <span class="feed-label">LIVE ACTIVITY</span>
          <ul class="sidebar-feed-list" id="sidebarFeedNgo">
            <li><span class="feed-dot dot-green"></span> Hope Foundation claimed 30 kg — Dhaka</li>
            <li><span class="feed-dot dot-amber"></span> Volunteer Rahim picked up bread — Sylhet</li>
            <li><span class="feed-dot dot-green"></span> Greenfield NGO request approved — Khulna</li>
            <li><span class="feed-dot dot-coral"></span> Emergency batch claimed in 4 min — Rajshahi</li>
          </ul>
        </div>
      </div>
    </aside>

    <!-- Auth card -->
    <section class="auth-card-wrap">
      <div class="auth-card">

        <!-- Tabs -->
        <div class="auth-tabs">
          <button class="auth-tab active" data-tab="ngo-login">Log In</button>
          <button class="auth-tab" data-tab="ngo-register">Register</button>
          <div class="tab-indicator"></div>
        </div>

        <!-- LOGIN -->
        <div class="auth-form-panel active" id="panel-ngo-login">
          <div class="form-header">
            <h3>Welcome back</h3>
            <p>Log in to your NGO / Volunteer account to request food donations.</p>
          </div>
          <div class="ngo-note">
            &#x1F3E2; <strong>NGO or Volunteer account only.</strong>
            Donors should use the <a href="/login" style="color:#93C5FD;text-decoration:underline">Donor Login</a>.
          </div>
          <form id="ngoLoginForm" novalidate>
            <div class="field-group">
              <label for="ngo-login-email">Email address</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <input type="email" id="ngo-login-email" placeholder="you@ngo.org" autocomplete="email" required />
              </div>
              <span class="field-error" id="ngo-login-email-err"></span>
            </div>
            <div class="field-group">
              <label for="ngo-login-password">
                Password
                <a href="#" class="forgot-link">Forgot password?</a>
              </label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <input type="password" id="ngo-login-password" placeholder="Enter your password" autocomplete="current-password" required />
                <button type="button" class="toggle-pw" data-target="ngo-login-password">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
              <span class="field-error" id="ngo-login-pw-err"></span>
            </div>
            <div class="field-group field-row">
              <label class="checkbox-label">
                <input type="checkbox" id="ngo-remember-me" />
                <span class="checkmark"></span>
                Keep me logged in
              </label>
            </div>
            <button type="submit" class="btn-auth" id="ngoLoginBtn">
              <span class="btn-text">Log In</span>
              <span class="btn-spinner" hidden>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
              </span>
            </button>
            <div class="auth-divider"><span>or continue with</span></div>
            <div class="social-auth">
              <button type="button" class="social-btn">
                <svg viewBox="0 0 24 24" width="18" height="18"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                Google
              </button>
              <button type="button" class="social-btn">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Facebook
              </button>
            </div>
          </form>
        </div>

        <!-- REGISTER -->
        <div class="auth-form-panel" id="panel-ngo-register">
          <div class="form-header">
            <h3>Register your account</h3>
            <p>Create an NGO or volunteer account to start requesting food from donors.</p>
          </div>
          <div class="ngo-note">
            &#x1F3E2; <strong>For NGOs &amp; Volunteers only.</strong>
            Want to donate food? <a href="/login" style="color:#93C5FD;text-decoration:underline">Register as Donor</a>.
          </div>
          <form id="ngoRegisterForm" novalidate>
            <div class="field-row-2">
              <div class="field-group">
                <label for="ngo-reg-first">First name</label>
                <div class="input-wrap">
                  <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                  <input type="text" id="ngo-reg-first" placeholder="Rahim" required />
                </div>
                <span class="field-error" id="ngo-reg-first-err"></span>
              </div>
              <div class="field-group">
                <label for="ngo-reg-last">Last name</label>
                <div class="input-wrap">
                  <input type="text" id="ngo-reg-last" placeholder="Uddin" required />
                </div>
                <span class="field-error" id="ngo-reg-last-err"></span>
              </div>
            </div>
            <div class="field-group">
              <label for="ngo-reg-email">Email address</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <input type="email" id="ngo-reg-email" placeholder="you@ngo.org" required />
              </div>
              <span class="field-error" id="ngo-reg-email-err"></span>
            </div>
            <div class="field-group">
              <label for="ngo-reg-phone">Phone number</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.91a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <input type="tel" id="ngo-reg-phone" placeholder="+880 1700-000000" required />
              </div>
              <span class="field-error" id="ngo-reg-phone-err"></span>
            </div>
            <div class="field-group">
              <label for="ngo-reg-org">Organisation / NGO name <span class="label-optional">(optional for individual volunteers)</span></label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <input type="text" id="ngo-reg-org" placeholder="Hope Foundation / Red Crescent" />
              </div>
            </div>
            <div class="field-group">
              <label>I am registering as a</label>
              <div class="receiver-type-group">
                <label class="type-option">
                  <input type="radio" name="receiver-type" value="ngo" checked />
                  <div class="type-card">
                    <span class="type-icon">&#x1F3E2;</span>
                    <strong>NGO</strong>
                    <span>Registered org</span>
                  </div>
                </label>
                <label class="type-option">
                  <input type="radio" name="receiver-type" value="volunteer" />
                  <div class="type-card">
                    <span class="type-icon">&#x1F64B;</span>
                    <strong>Volunteer</strong>
                    <span>Individual helper</span>
                  </div>
                </label>
                <label class="type-option">
                  <input type="radio" name="receiver-type" value="shelter" />
                  <div class="type-card">
                    <span class="type-icon">&#x1F3E0;</span>
                    <strong>Shelter</strong>
                    <span>Orphanage / shelter</span>
                  </div>
                </label>
              </div>
            </div>
            <div class="field-group">
              <label for="ngo-reg-city">Area of operation</label>
              <div class="input-wrap select-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <select id="ngo-reg-city" required>
                  <option value="" disabled selected>Select your city</option>
                  <option>Dhaka</option>
                  <option>Chittagong</option>
                  <option>Khulna</option>
                  <option>Rajshahi</option>
                  <option>Sylhet</option>
                  <option>Barisal</option>
                  <option>Rangpur</option>
                  <option>Mymensingh</option>
                  <option>Other</option>
                </select>
                <svg class="select-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
              </div>
              <span class="field-error" id="ngo-reg-city-err"></span>
            </div>
            <div class="field-group">
              <label for="ngo-reg-password">Create password</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <input type="password" id="ngo-reg-password" placeholder="Min. 8 characters" autocomplete="new-password" required />
                <button type="button" class="toggle-pw" data-target="ngo-reg-password">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
              <div class="pw-strength" id="ngoPwStrength">
                <div class="pw-strength-bars">
                  <span class="pw-bar ngo-bar"></span>
                  <span class="pw-bar ngo-bar"></span>
                  <span class="pw-bar ngo-bar"></span>
                  <span class="pw-bar ngo-bar"></span>
                </div>
                <span class="pw-strength-label" id="ngoPwLabel">Enter a password</span>
              </div>
              <span class="field-error" id="ngo-reg-pw-err"></span>
            </div>
            <div class="field-group">
              <label class="checkbox-label">
                <input type="checkbox" id="ngo-reg-terms" required />
                <span class="checkmark"></span>
                I agree to ResQMeal's <a href="#" class="inline-link">Terms of Service</a> and <a href="#" class="inline-link">Privacy Policy</a>
              </label>
              <span class="field-error" id="ngo-reg-terms-err"></span>
            </div>
            <button type="submit" class="btn-auth" id="ngoRegisterBtn">
              <span class="btn-text">Create NGO / Volunteer Account</span>
              <span class="btn-spinner" hidden>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
              </span>
            </button>
          </form>
        </div>

        <!-- Success state -->
        <div class="auth-success" id="ngoAuthSuccess" hidden>
          <div class="success-icon">&#x2705;</div>
          <h3>You're in!</h3>
          <p>Redirecting you to the Live Board to request food&hellip;</p>
          <p class="ngo-success-sub">Account type: <strong id="ngoRoleDisplay">NGO</strong></p>
          <div class="success-bar"><div class="success-fill" id="ngoSuccessFill"></div></div>
        </div>

      </div>
    </section>

  </main>

  <script>
    /* ── Tab switching ── */
    const ngoTabs      = document.querySelectorAll('.auth-tab');
    const ngoPanels    = document.querySelectorAll('.auth-form-panel');
    const ngoIndicator = document.querySelector('.tab-indicator');

    function activateNgoTab(tabEl) {
      ngoTabs.forEach(t => t.classList.remove('active'));
      ngoPanels.forEach(p => p.classList.remove('active'));
      tabEl.classList.add('active');
      document.getElementById('panel-' + tabEl.dataset.tab).classList.add('active');
      const idx = [...ngoTabs].indexOf(tabEl);
      ngoIndicator.style.transform = `translateX(${idx * 100}%)`;
    }
    ngoTabs.forEach(t => t.addEventListener('click', () => activateNgoTab(t)));

    /* ── Show/hide password ── */
    document.querySelectorAll('.toggle-pw').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.target);
        input.type = input.type === 'password' ? 'text' : 'password';
        btn.classList.toggle('active');
      });
    });

    /* ── Password strength ── */
    const ngoPwInput = document.getElementById('ngo-reg-password');
    const ngoBars    = document.querySelectorAll('.ngo-bar');
    const ngoPwLabel = document.getElementById('ngoPwLabel');
    const levels = ['Too weak','Weak','Fair','Strong','Very strong'];
    const colors = ['#E8614A','#E8614A','#F5A623','#3B82F6','#22C55E'];

    ngoPwInput && ngoPwInput.addEventListener('input', () => {
      const pw = ngoPwInput.value;
      let score = 0;
      if (pw.length >= 8)          score++;
      if (/[A-Z]/.test(pw))        score++;
      if (/[0-9]/.test(pw))        score++;
      if (/[^A-Za-z0-9]/.test(pw)) score++;
      ngoBars.forEach((b, i) => {
        b.style.background = i < score ? colors[score] : 'rgba(0,0,0,.1)';
      });
      ngoPwLabel.textContent = pw.length === 0 ? 'Enter a password' : (levels[score] || levels[4]);
      ngoPwLabel.style.color = colors[score] || '#aaa';
    });

    /* ── Validation helpers ── */
    function ngoSetErr(id, msg) {
      const el = document.getElementById(id);
      if (el) { el.textContent = msg; el.classList.toggle('visible', !!msg); }
    }
    function ngoClear() {
      document.querySelectorAll('.field-error').forEach(e => { e.textContent=''; e.classList.remove('visible'); });
      document.querySelectorAll('.input-wrap').forEach(w => w.classList.remove('error'));
    }
    function ngoMark(inputId, errId, msg) {
      ngoSetErr(errId, msg);
      const inp = document.getElementById(inputId);
      if (inp) inp.closest('.input-wrap')?.classList.add('error');
    }

    /* ── Local storage helpers ── */
    function getNgoUsers() {
      try { return JSON.parse(localStorage.getItem('resqmeal_ngo_users') || '[]'); } catch(e) { return []; }
    }
    function saveNgoUsers(u) { localStorage.setItem('resqmeal_ngo_users', JSON.stringify(u)); }

    /* ── Success redirect ── */
    function showNgoSuccess(roleLabel) {
      document.querySelectorAll('.auth-form-panel').forEach(p => p.style.display = 'none');
      const s = document.getElementById('ngoAuthSuccess');
      s.hidden = false;
      document.getElementById('ngoRoleDisplay').textContent = roleLabel;
      let w = 0;
      const fill = document.getElementById('ngoSuccessFill');
      const t = setInterval(() => {
        w += 2; fill.style.width = w + '%';
        if (w >= 100) { clearInterval(t); window.location.href = '/#live-feed'; }
      }, 30);
    }

    /* ── Login submit ── */
    document.getElementById('ngoLoginForm').addEventListener('submit', function(e) {
      e.preventDefault(); ngoClear();
      const email = document.getElementById('ngo-login-email').value.trim();
      const pw    = document.getElementById('ngo-login-password').value;
      let ok = true;
      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { ngoMark('ngo-login-email','ngo-login-email-err','Enter a valid email address.'); ok=false; }
      if (!pw || pw.length < 6)  { ngoMark('ngo-login-password','ngo-login-pw-err','Password must be at least 6 characters.'); ok=false; }
      if (!ok) return;

      const btn = document.getElementById('ngoLoginBtn');
      btn.querySelector('.btn-text').hidden = true;
      btn.querySelector('.btn-spinner').hidden = false;
      btn.disabled = true;

      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

      fetch('/ngo-login-check', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept':       'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ email, password: pw }),
      })
      .then(async res => {
        const data = await res.json();
        if (res.ok && data.success) {
          /* ✅ Credentials verified against DB */
          sessionStorage.setItem('resqmeal_ngo_user', JSON.stringify(data));
          const roleMap = { ngo:'NGO', volunteer:'Volunteer', shelter:'Shelter' };
          showNgoSuccess(roleMap[data.receiver_type] || 'NGO');
        } else {
          /* ❌ Wrong credentials — show error on the right field */
          btn.querySelector('.btn-text').hidden = false;
          btn.querySelector('.btn-spinner').hidden = true;
          btn.disabled = false;
          if (data.field === 'email') {
            ngoMark('ngo-login-email','ngo-login-email-err', data.message);
          } else {
            ngoMark('ngo-login-password','ngo-login-pw-err', data.message);
          }
        }
      })
      .catch(() => {
        btn.querySelector('.btn-text').hidden = false;
        btn.querySelector('.btn-spinner').hidden = true;
        btn.disabled = false;
        ngoSetErr('ngo-login-pw-err', 'Network error. Please check your connection.');
      });
    });

    /* ── Register submit ── */
    document.getElementById('ngoRegisterForm').addEventListener('submit', function(e) {
      e.preventDefault(); ngoClear();
      const first = document.getElementById('ngo-reg-first').value.trim();
      const last  = document.getElementById('ngo-reg-last').value.trim();
      const email = document.getElementById('ngo-reg-email').value.trim();
      const phone = document.getElementById('ngo-reg-phone').value.trim();
      const org   = document.getElementById('ngo-reg-org').value.trim();
      const city  = document.getElementById('ngo-reg-city').value;
      const pw    = document.getElementById('ngo-reg-password').value;
      const terms = document.getElementById('ngo-reg-terms').checked;
      const receiverType = document.querySelector('input[name="receiver-type"]:checked')?.value || 'ngo';
      let ok = true;

      if (!first) { ngoMark('ngo-reg-first','ngo-reg-first-err','First name is required.'); ok=false; }
      if (!last)  { ngoMark('ngo-reg-last','ngo-reg-last-err','Last name is required.'); ok=false; }
      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { ngoMark('ngo-reg-email','ngo-reg-email-err','Enter a valid email address.'); ok=false; }
      if (!phone) { ngoMark('ngo-reg-phone','ngo-reg-phone-err','Phone number is required.'); ok=false; }
      if (!city)  { ngoMark('ngo-reg-city','ngo-reg-city-err','Please select your area.'); ok=false; }
      if (pw.length < 8) { ngoMark('ngo-reg-password','ngo-reg-pw-err','Password must be at least 8 characters.'); ok=false; }
      if (!terms) { ngoSetErr('ngo-reg-terms-err','You must accept the terms to continue.'); ok=false; }
      if (!ok) return;

      const btn = document.getElementById('ngoRegisterBtn');
      btn.querySelector('.btn-text').hidden = true;
      btn.querySelector('.btn-spinner').hidden = false;
      btn.disabled = true;

      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

      fetch('/ngo-register', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept':       'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
          first_name:    first,
          last_name:     last,
          email:         email,
          phone:         phone,
          organisation:  org,
          receiver_type: receiverType,
          city:          city,
          password:      pw,
        }),
      })
      .then(async res => {
        const data = await res.json();
        if (res.ok) {
          /* Success — store session info and show success screen */
          const newUser = { email, name: first, last, phone, city, org, receiverType, role:'ngo', isNgo:true };
          sessionStorage.setItem('resqmeal_ngo_user', JSON.stringify(newUser));
          const roleMap = { ngo:'NGO', volunteer:'Volunteer', shelter:'Shelter' };
          showNgoSuccess(roleMap[receiverType] || 'NGO');
        } else {
          /* Validation error from server (e.g. duplicate email) */
          btn.querySelector('.btn-text').hidden = false;
          btn.querySelector('.btn-spinner').hidden = true;
          btn.disabled = false;
          if (data.errors?.email) {
            ngoMark('ngo-reg-email','ngo-reg-email-err', data.errors.email[0]);
          } else {
            ngoSetErr('ngo-reg-terms-err', data.message || 'Something went wrong. Please try again.');
          }
        }
      })
      .catch(() => {
        btn.querySelector('.btn-text').hidden = false;
        btn.querySelector('.btn-spinner').hidden = true;
        btn.disabled = false;
        ngoSetErr('ngo-reg-terms-err', 'Network error. Please check your connection and try again.');
      });
    });

    /* ── Live activity feed animation ── */
    const ngoFeedItems = [
      '&#x1F7E2; Hope Foundation claimed 30 kg — Dhaka',
      '&#x1F7E1; Volunteer Rahim picked up bread — Sylhet',
      '&#x1F7E2; Greenfield NGO request approved — Khulna',
      '&#x1F534; Emergency batch claimed in 4 min — Rajshahi',
      '&#x1F7E2; Al-Amin Shelter received 60 plates — Dhaka',
      '&#x1F7E1; 5 volunteers dispatched — Chittagong',
    ];
    let ngoFeedIdx = 0;
    const ngoFeedList = document.getElementById('sidebarFeedNgo');
    if (ngoFeedList) {
      setInterval(() => {
        const li = ngoFeedList.querySelector('li:last-child');
        if (!li) return;
        ngoFeedIdx = (ngoFeedIdx + 1) % ngoFeedItems.length;
        li.style.opacity = '0';
        setTimeout(() => {
          ngoFeedList.removeChild(li);
          const newLi = document.createElement('li');
          newLi.innerHTML = ngoFeedItems[ngoFeedIdx];
          newLi.style.opacity = '0';
          ngoFeedList.insertBefore(newLi, ngoFeedList.firstChild);
          requestAnimationFrame(() => { newLi.style.transition = 'opacity .4s'; newLi.style.opacity = '1'; });
        }, 300);
      }, 3000);
    }

    /* ── Redirect if already logged in ── */
    if (sessionStorage.getItem('resqmeal_ngo_user')) {
      window.location.href = '/#live-feed';
    }
  </script>
</body>
</html>

