<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ResQMeal — Donor Login</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/auth.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
</head>
<body class="auth-body">

  <!-- ── Background ── -->
  <div class="auth-bg">
    <div class="auth-bg-glow glow-1"></div>
    <div class="auth-bg-glow glow-2"></div>
    <div class="auth-grid-overlay"></div>
  </div>

  <!-- ── Nav strip ── -->
  <nav class="auth-nav">
    <a href="/" class="nav-logo">
      <span class="logo-icon">🥗</span>
      <span class="logo-text">ResQ<span class="logo-accent">Meal</span></span>
    </a>
    <a href="/" class="auth-back-link">← Back to Home</a>
  </nav>

  <!-- ── Main layout ── -->
  <main class="auth-main">

    <!-- Left panel: impact sidebar -->
    <aside class="auth-sidebar">
      <div class="sidebar-inner">
        <div class="sidebar-badge">
          <span class="pulse-dot"></span>
          <span>182,400+ meals rescued</span>
        </div>

        <h2 class="sidebar-headline">
          Your surplus.<br />
          Someone's <span class="sidebar-accent">lifeline.</span>
        </h2>

        <p class="sidebar-sub">
          Join 640 verified donors already rescuing food every day across Bangladesh.
        </p>

        <div class="sidebar-stats">
          <div class="ss-item">
            <span class="ss-num">18 min</span>
            <span class="ss-label">Avg. food-to-pickup time</span>
          </div>
          <div class="ss-item">
            <span class="ss-num">98%</span>
            <span class="ss-label">Successful pickup rate</span>
          </div>
          <div class="ss-item">
            <span class="ss-num">4.2 T</span>
            <span class="ss-label">CO₂ prevented this month</span>
          </div>
        </div>

        <!-- Live feed strip -->
        <div class="sidebar-feed">
          <span class="feed-label">LIVE RESCUES</span>
          <ul class="sidebar-feed-list" id="sidebarFeed">
            <li><span class="feed-dot dot-green"></span> 45 kg biryani rescued — Khulna</li>
            <li><span class="feed-dot dot-amber"></span> 12 kg vegetables claimed — Dhaka</li>
            <li><span class="feed-dot dot-coral"></span> Emergency alert cleared — Sylhet</li>
            <li><span class="feed-dot dot-green"></span> 60 meals posted by Spice Garden</li>
          </ul>
        </div>
      </div>
    </aside>

    <!-- Right panel: auth card -->
    <section class="auth-card-wrap">
      <div class="auth-card">

        <!-- Tabs -->
        <div class="auth-tabs">
          <button class="auth-tab active" data-tab="login">Log In</button>
          <button class="auth-tab" data-tab="register">Create Account</button>
          <div class="tab-indicator"></div>
        </div>

        <!-- ── LOGIN FORM ── -->
        <div class="auth-form-panel active" id="panel-login">
          <div class="form-header">
            <h3>Welcome back</h3>
            <p>Log in to access your donor dashboard and post food donations.</p>
          </div>

          <form id="loginForm" novalidate>

            <div class="field-group">
              <label for="login-email">Email address</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <input
                  type="email"
                  id="login-email"
                  name="email"
                  placeholder="you@example.com"
                  autocomplete="email"
                  required
                />
              </div>
              <span class="field-error" id="login-email-err"></span>
            </div>

            <div class="field-group">
              <label for="login-password">
                Password
                <a href="#" class="forgot-link">Forgot password?</a>
              </label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <input
                  type="password"
                  id="login-password"
                  name="password"
                  placeholder="Enter your password"
                  autocomplete="current-password"
                  required
                />
                <button type="button" class="toggle-pw" aria-label="Show password" data-target="login-password">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
              <span class="field-error" id="login-pw-err"></span>
            </div>

            <div class="field-group field-row">
              <label class="checkbox-label">
                <input type="checkbox" id="remember-me" />
                <span class="checkmark"></span>
                Keep me logged in
              </label>
            </div>

            <button type="submit" class="btn-auth" id="loginBtn">
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

        <!-- ── REGISTER FORM ── -->
        <div class="auth-form-panel" id="panel-register">
          <div class="form-header">
            <h3>Become a donor</h3>
            <p>Create your account and start rescuing food in your area today.</p>
          </div>

          <form id="registerForm" novalidate>

            <div class="field-row-2">
              <div class="field-group">
                <label for="reg-first">First name</label>
                <div class="input-wrap">
                  <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                  <input type="text" id="reg-first" placeholder="Arif" required />
                </div>
                <span class="field-error" id="reg-first-err"></span>
              </div>
              <div class="field-group">
                <label for="reg-last">Last name</label>
                <div class="input-wrap">
                  <input type="text" id="reg-last" placeholder="Hossain" required />
                </div>
                <span class="field-error" id="reg-last-err"></span>
              </div>
            </div>

            <div class="field-group">
              <label for="reg-email">Email address</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <input type="email" id="reg-email" placeholder="you@example.com" required />
              </div>
              <span class="field-error" id="reg-email-err"></span>
            </div>

            <div class="field-group">
              <label for="reg-phone">Phone number</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.91a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <input type="tel" id="reg-phone" placeholder="+880 1700-000000" required />
              </div>
              <span class="field-error" id="reg-phone-err"></span>
            </div>

            <div class="field-group">
              <label for="reg-org">Organization / Restaurant name <span class="label-optional">(optional)</span></label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <input type="text" id="reg-org" placeholder="Hotel Landmark / Personal" />
              </div>
            </div>

            <div class="field-group">
              <label for="reg-city">City / District</label>
              <div class="input-wrap select-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <select id="reg-city" required>
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
              <span class="field-error" id="reg-city-err"></span>
            </div>

            <div class="field-group">
              <label for="reg-donor-type">I am donating as a</label>
              <div class="donor-type-group">
                <label class="type-option">
                  <input type="radio" name="donor-type" value="individual" checked />
                  <div class="type-card">
                    <span class="type-icon">🙋</span>
                    <strong>Individual</strong>
                    <span>Personal surplus</span>
                  </div>
                </label>
                <label class="type-option">
                  <input type="radio" name="donor-type" value="restaurant" />
                  <div class="type-card">
                    <span class="type-icon">🍽️</span>
                    <strong>Restaurant</strong>
                    <span>Cooked excess</span>
                  </div>
                </label>
                <label class="type-option">
                  <input type="radio" name="donor-type" value="retailer" />
                  <div class="type-card">
                    <span class="type-icon">🏪</span>
                    <strong>Retailer</strong>
                    <span>Near-expiry stock</span>
                  </div>
                </label>
              </div>
            </div>

            <div class="field-group">
              <label for="reg-password">Create password</label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <input type="password" id="reg-password" placeholder="Min. 8 characters" autocomplete="new-password" required />
                <button type="button" class="toggle-pw" aria-label="Show password" data-target="reg-password">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
              <!-- Strength meter -->
              <div class="pw-strength" id="pwStrength">
                <div class="pw-strength-bars">
                  <span class="pw-bar"></span>
                  <span class="pw-bar"></span>
                  <span class="pw-bar"></span>
                  <span class="pw-bar"></span>
                </div>
                <span class="pw-strength-label" id="pwLabel">Enter a password</span>
              </div>
              <span class="field-error" id="reg-pw-err"></span>
            </div>

            <div class="field-group">
              <label class="checkbox-label">
                <input type="checkbox" id="reg-terms" required />
                <span class="checkmark"></span>
                I agree to ResQMeal's <a href="#" class="inline-link">Terms of Service</a> and <a href="#" class="inline-link">Privacy Policy</a>
              </label>
              <span class="field-error" id="reg-terms-err"></span>
            </div>

            <button type="submit" class="btn-auth" id="registerBtn">
              <span class="btn-text">Create Donor Account</span>
              <span class="btn-spinner" hidden>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
              </span>
            </button>

          </form>
        </div>

        <!-- Success state (hidden until submit) -->
        <div class="auth-success" id="authSuccess" hidden>
          <div class="success-icon">✅</div>
          <h3>You're in!</h3>
          <p>Redirecting you to your donation dashboard…</p>
          <div class="success-bar"><div class="success-fill" id="successFill"></div></div>
        </div>

      </div>
    </section>

  </main>

  <script>
    /* ─── TAB SWITCHING ─────────────────────────────── */
    const tabs   = document.querySelectorAll('.auth-tab');
    const panels = document.querySelectorAll('.auth-form-panel');
    const indicator = document.querySelector('.tab-indicator');

    function activateTab(tabEl) {
      tabs.forEach(t => t.classList.remove('active'));
      panels.forEach(p => p.classList.remove('active'));
      tabEl.classList.add('active');
      document.getElementById('panel-' + tabEl.dataset.tab).classList.add('active');
      // Move indicator
      const idx = [...tabs].indexOf(tabEl);
      indicator.style.transform = `translateX(${idx * 100}%)`;
    }
    tabs.forEach(t => t.addEventListener('click', () => activateTab(t)));

    /* ─── SHOW/HIDE PASSWORD ────────────────────────── */
    document.querySelectorAll('.toggle-pw').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.target);
        input.type = input.type === 'password' ? 'text' : 'password';
        btn.classList.toggle('active');
      });
    });

    /* ─── PASSWORD STRENGTH ─────────────────────────── */
    const regPwInput = document.getElementById('reg-password');
    const bars       = document.querySelectorAll('.pw-bar');
    const pwLabel    = document.getElementById('pwLabel');
    const levels     = ['Too short', 'Weak', 'Fair', 'Strong', 'Very strong'];
    const colors     = ['#E8614A', '#E8614A', '#F5A623', '#4A7C59', '#0B3D2E'];

    regPwInput && regPwInput.addEventListener('input', () => {
      const pw = regPwInput.value;
      let score = 0;
      if (pw.length >= 8)  score++;
      if (/[A-Z]/.test(pw)) score++;
      if (/[0-9]/.test(pw)) score++;
      if (/[^A-Za-z0-9]/.test(pw)) score++;
      bars.forEach((b, i) => {
        b.style.background = i < score ? colors[score] : 'rgba(0,0,0,.1)';
      });
      pwLabel.textContent = pw.length === 0 ? 'Enter a password' : levels[score] || levels[4];
      pwLabel.style.color = colors[score] || '#aaa';
    });

    /* ─── VALIDATION HELPER ─────────────────────────── */
    function setError(id, msg) {
      const el = document.getElementById(id);
      if (el) { el.textContent = msg; el.classList.toggle('visible', !!msg); }
    }
    function clearErrors() {
      document.querySelectorAll('.field-error').forEach(e => {
        e.textContent = ''; e.classList.remove('visible');
      });
      document.querySelectorAll('.input-wrap').forEach(w => w.classList.remove('error'));
    }
    function markError(inputId, errId, msg) {
      setError(errId, msg);
      const inp = document.getElementById(inputId);
      if (inp) inp.closest('.input-wrap')?.classList.add('error');
    }

    /* ─── SHOW AUTH SUCCESS ─────────────────────────── */
    function showSuccess() {
      document.querySelectorAll('.auth-form-panel').forEach(p => p.style.display = 'none');
      const s = document.getElementById('authSuccess');
      s.hidden = false;
      let w = 0;
      const fill = document.getElementById('successFill');
      const t = setInterval(() => {
        w += 2; fill.style.width = w + '%';
        if (w >= 100) { clearInterval(t); window.location.href = 'donate'; }
      }, 30);
    }

    /* ─── LOGIN SUBMIT ──────────────────────────────── */
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      clearErrors();
      const email = document.getElementById('login-email').value.trim();
      const pw    = document.getElementById('login-password').value;
      let valid   = true;

      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        markError('login-email', 'login-email-err', 'Enter a valid email address.');
        valid = false;
      }
      if (!pw || pw.length < 6) {
        markError('login-password', 'login-pw-err', 'Password must be at least 6 characters.');
        valid = false;
      }
      if (!valid) return;

      // Simulate async login
      const btn = document.getElementById('loginBtn');
      btn.querySelector('.btn-text').hidden   = true;
      btn.querySelector('.btn-spinner').hidden = false;
      btn.disabled = true;

      setTimeout(() => {
        // Demo: store session in sessionStorage
        sessionStorage.setItem('resqmeal_user', JSON.stringify({ email, name: email.split('@')[0] }));
        showSuccess();
      }, 1500);
    });

    /* ─── REGISTER SUBMIT ───────────────────────────── */
    document.getElementById('registerForm').addEventListener('submit', function(e) {
      e.preventDefault();
      clearErrors();
      const first  = document.getElementById('reg-first').value.trim();
      const last   = document.getElementById('reg-last').value.trim();
      const email  = document.getElementById('reg-email').value.trim();
      const phone  = document.getElementById('reg-phone').value.trim();
      const city   = document.getElementById('reg-city').value;
      const pw     = document.getElementById('reg-password').value;
      const terms  = document.getElementById('reg-terms').checked;
      let valid    = true;

      if (!first)  { markError('reg-first', 'reg-first-err', 'First name is required.'); valid = false; }
      if (!last)   { markError('reg-last',  'reg-last-err',  'Last name is required.');  valid = false; }
      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        markError('reg-email', 'reg-email-err', 'Enter a valid email address.'); valid = false;
      }
      if (!phone)  { markError('reg-phone', 'reg-phone-err', 'Phone number is required.'); valid = false; }
      if (!city)   { markError('reg-city',  'reg-city-err',  'Please select your city.');  valid = false; }
      if (pw.length < 8) { markError('reg-password', 'reg-pw-err', 'Password must be at least 8 characters.'); valid = false; }
      if (!terms) { setError('reg-terms-err', 'You must accept the terms to continue.'); valid = false; }
      if (!valid) return;

      const btn = document.getElementById('registerBtn');
      btn.querySelector('.btn-text').hidden   = true;
      btn.querySelector('.btn-spinner').hidden = false;
      btn.disabled = true;

      setTimeout(() => {
        const donorType = document.querySelector('input[name="donor-type"]:checked')?.value || 'individual';
        const org = document.getElementById('reg-org').value.trim();
        sessionStorage.setItem('resqmeal_user', JSON.stringify({ email, name: first, last, phone, city, donorType, org }));
        showSuccess();
      }, 2000);
    });

    /* ─── LIVE FEED ANIMATION ───────────────────────── */
    const feedItems = [
      '🟢 45 kg biryani rescued — Khulna',
      '🟡 12 kg vegetables claimed — Dhaka',
      '🔴 Emergency alert cleared — Sylhet',
      '🟢 60 meals posted by Spice Garden',
      '🟡 Bread (5 trays) — Sylhet pickup in 22 min',
      '🟢 Community kitchen posted 80 plates',
    ];
    let feedIdx = 0;
    const feedList = document.getElementById('sidebarFeed');
    if (feedList) {
      setInterval(() => {
        const li = feedList.querySelector('li:last-child');
        if (!li) return;
        feedIdx = (feedIdx + 1) % feedItems.length;
        li.style.opacity = '0';
        setTimeout(() => {
          feedList.removeChild(li);
          const newLi = document.createElement('li');
          newLi.innerHTML = feedItems[feedIdx];
          newLi.style.opacity = '0';
          feedList.insertBefore(newLi, feedList.firstChild);
          requestAnimationFrame(() => { newLi.style.transition = 'opacity .4s'; newLi.style.opacity = '1'; });
        }, 300);
      }, 3000);
    }

    /* ─── REDIRECT IF ALREADY LOGGED IN ─────────────── */
    if (sessionStorage.getItem('resqmeal_user')) {
      const params = new URLSearchParams(window.location.search);
      window.location.href = params.get('redirect') || 'donate';
    }
  </script>
</body>
</html>