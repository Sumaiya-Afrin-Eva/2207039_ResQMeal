<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>ResQMeal — Request Food</title>
  <meta name="description" content="Submit a food pickup request as a verified NGO or volunteer on ResQMeal." />
  <link rel="stylesheet" href="/css/style.css" />
  <link rel="stylesheet" href="/css/auth.css" />
  <link rel="stylesheet" href="/css/donate.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    :root { --req-blue:#3B82F6; --req-indigo:#6366F1; }
    .donate-body { background:#0d1117; }
    .donor-nav { background:rgba(13,17,23,.95); border-color:rgba(255,255,255,.06); }
    .donor-nav .logo-accent { color:var(--req-blue); }
    .dnav-link:hover,.dnav-link.active { color:var(--req-blue); }
    .dnav-link.active::after { background:var(--req-blue); }
    .donate-sidebar { background:linear-gradient(160deg,#111827 0%,#1e2a3a 100%); border-color:rgba(59,130,246,.15); }
    .step-circle { background:rgba(59,130,246,.12); color:#93c5fd; border-color:rgba(59,130,246,.3); }
    .stepper-step.active .step-circle { background:var(--req-blue); color:#fff; border-color:var(--req-blue); box-shadow:0 0 0 4px rgba(59,130,246,.2); }
    .stepper-step.done .step-circle { background:#10b981; border-color:#10b981; color:#fff; }
    .stepper-line { background:rgba(59,130,246,.15); }
    .stepper-line.active { background:var(--req-blue); }
    .step-label strong { color:#e2e8f0; }
    .step-label span { color:#64748b; }
    .donate-main { background:#161b22; border-color:rgba(59,130,246,.1); }
    .step-header h2 { color:#e2e8f0; }
    .step-header p { color:#8b949e; }
    .field-group label { color:#c9d1d9; }
    .req { color:#f87171; }
    .label-optional { color:#6e7681; font-size:.82rem; }

    /* ── Nav bar ── */
    .donor-nav .logo-text  { color:#e2e8f0 !important; }          /* "ResQ" white  */
    .donor-nav .logo-accent { color:var(--req-blue) !important; } /* "Meal" blue   */
    .donor-nav-links .dnav-link         { color:#8b949e !important; }
    .donor-nav-links .dnav-link:hover,
    .donor-nav-links .dnav-link.active  { color:var(--req-blue) !important; }
    .donor-nav-links .dnav-link.active::after { background:var(--req-blue) !important; }
    .dp-name   { color:#e2e8f0 !important; }
    .dp-role   { color:#6e7681 !important; }
    .dp-logout { color:#6e7681 !important; }
    .dp-logout:hover { color:#f87171 !important; }
    .donor-profile { border-color:rgba(255,255,255,.08) !important; }

    /* ── Main panel & form text ── */
    .donate-main               { background:#161b22 !important; border-color:rgba(59,130,246,.1) !important; }
    .step-header               { border-color:rgba(255,255,255,.06) !important; }
    .step-header h2            { color:#e2e8f0 !important; }
    .step-header p             { color:#8b949e !important; }
    .donate-main .field-group label { color:#c9d1d9 !important; }

    /* ── Stepper ── */
    .step-label strong { color:#e2e8f0 !important; }
    .step-label span   { color:#64748b !important; }
    .stepper-line      { background:rgba(59,130,246,.15) !important; }
    .stepper-line.active { background:var(--req-blue) !important; }
    .step-circle       { background:rgba(59,130,246,.12) !important; color:#93c5fd !important; border-color:rgba(59,130,246,.3) !important; }
    .stepper-step.active .step-circle { background:var(--req-blue) !important; color:#fff !important; border-color:var(--req-blue) !important; box-shadow:0 0 0 4px rgba(59,130,246,.2) !important; }
    .stepper-step.done  .step-circle  { background:#10b981 !important; border-color:#10b981 !important; color:#fff !important; }

    /* ── Input overrides — beat donate.css .donate-main .input-wrap specificity ── */
    .donate-main .input-wrap { background:#1c2333 !important; border-color:rgba(59,130,246,.25) !important; }
    .donate-main .input-wrap:focus-within { background:#1c2333 !important; border-color:var(--req-blue) !important; box-shadow:0 0 0 3px rgba(59,130,246,.15) !important; }
    .donate-main .input-wrap.error { border-color:#ef4444 !important; box-shadow:0 0 0 3px rgba(239,68,68,.15) !important; }
    .donate-main .input-wrap input,
    .donate-main .input-wrap select,
    .donate-main .input-wrap textarea { color:#e2e8f0 !important; background:transparent !important; }
    .donate-main .input-wrap input::placeholder,
    .donate-main .input-wrap select::placeholder,
    .donate-main .input-wrap textarea::placeholder { color:#484f58 !important; }
    /* Fix select option dropdown in dark mode */
    .donate-main .input-wrap select option { background:#1c2333; color:#e2e8f0; }
    /* datetime-local calendar icon colour */
    .donate-main .input-wrap input[type="datetime-local"]::-webkit-calendar-picker-indicator { filter:invert(1) opacity(.4); }

    .input-icon { color:#3B82F6; }
    .select-chevron { color:#3B82F6; }

    .cat-card { background:rgba(255,255,255,.04); border-color:rgba(59,130,246,.15); }
    .cat-option input:checked ~ .cat-card { border-color:var(--req-blue); background:rgba(59,130,246,.12); box-shadow:0 0 0 2px rgba(59,130,246,.25); }
    .cat-card strong { color:#c9d1d9; }
    .cat-card em { color:#6e7681; }

    .priority-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
    .priority-option { position:relative; cursor:pointer; }
    .priority-option input { position:absolute; opacity:0; }
    .priority-card { border:2px solid rgba(255,255,255,.08); border-radius:12px; padding:16px 12px; text-align:center; transition:all .2s; background:rgba(255,255,255,.03); }
    .priority-card span { font-size:1.8rem; display:block; margin-bottom:6px; }
    .priority-card strong { display:block; font-size:.85rem; color:#c9d1d9; }
    .priority-card em { display:block; font-size:.75rem; color:#6e7681; margin-top:2px; }
    .priority-option input:checked ~ .priority-card.normal { border-color:#10b981; background:rgba(16,185,129,.1); }
    .priority-option input:checked ~ .priority-card.urgent { border-color:#f59e0b; background:rgba(245,158,11,.1); }
    .priority-option input:checked ~ .priority-card.emergency { border-color:#ef4444; background:rgba(239,68,68,.1); }

    .transport-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .transport-option { position:relative; cursor:pointer; }
    .transport-option input { position:absolute; opacity:0; }
    .transport-card { border:2px solid rgba(255,255,255,.08); border-radius:12px; padding:16px; display:flex; align-items:center; gap:12px; background:rgba(255,255,255,.03); transition:all .2s; }
    .transport-card .t-icon { font-size:1.6rem; }
    .transport-card strong { display:block; font-size:.88rem; color:#c9d1d9; }
    .transport-card span { font-size:.75rem; color:#6e7681; }
    .transport-option input:checked ~ .transport-card { border-color:var(--req-blue); background:rgba(59,130,246,.1); }

    .btn-next { background:linear-gradient(135deg,var(--req-blue) 0%,var(--req-indigo) 100%); }
    .btn-next:hover { box-shadow:0 8px 30px rgba(59,130,246,.4); }
    .btn-submit { background:linear-gradient(135deg,#10b981 0%,var(--req-blue) 100%); }
    .btn-submit:hover { box-shadow:0 8px 30px rgba(16,185,129,.4); }
    .btn-back { border-color:rgba(59,130,246,.3); color:#93c5fd; }
    .btn-back:hover { background:rgba(59,130,246,.1); }

    .food-preview-banner { background:linear-gradient(135deg,rgba(59,130,246,.12) 0%,rgba(99,102,241,.08) 100%); border:1px solid rgba(59,130,246,.25); border-radius:14px; padding:18px 20px; margin-bottom:28px; display:flex; align-items:center; gap:14px; }
    .food-preview-icon { font-size:2.2rem; }
    .food-preview-info h4 { color:#e2e8f0; font-size:1rem; font-weight:600; margin:0 0 4px; }
    .food-preview-info p { color:#8b949e; font-size:.83rem; margin:0; }
    .food-preview-badge { margin-left:auto; background:rgba(59,130,246,.15); color:#93c5fd; border:1px solid rgba(59,130,246,.3); border-radius:6px; padding:4px 10px; font-size:.75rem; font-weight:600; }

    .sidebar-ngo-badge { background:linear-gradient(135deg,rgba(59,130,246,.15) 0%,rgba(99,102,241,.1) 100%); border:1px solid rgba(59,130,246,.2); border-radius:12px; padding:16px; margin-top:24px; }
    .sidebar-ngo-badge h5 { color:#93c5fd; font-size:.8rem; margin:0 0 6px; text-transform:uppercase; letter-spacing:.06em; }
    .sidebar-ngo-badge p { color:#c9d1d9; font-size:.85rem; margin:0; font-weight:600; }
    .sidebar-ngo-badge small { color:#6e7681; font-size:.75rem; }

    /* Sidebar tip — override light styles from donate.css */
    .sidebar-tip { background:rgba(255,255,255,.04) !important; border-color:rgba(255,255,255,.08) !important; }
    .sidebar-tip p { color:#c9d1d9 !important; }
    .sidebar-tip p strong { color:#e2e8f0 !important; }
    .tip-icon { filter:none; }

    .review-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .review-item { background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.06); border-radius:10px; padding:14px; }
    .review-item label { font-size:.72rem; color:#6e7681; text-transform:uppercase; letter-spacing:.05em; display:block; margin-bottom:4px; }
    .review-item span { color:#e2e8f0; font-size:.9rem; font-weight:600; }
    .review-item.full { grid-column:1 / -1; }

    .req-success { text-align:center; padding:48px 24px; display:none; }
    .req-success-icon { font-size:4rem; margin-bottom:16px; }
    .req-success h2 { color:#e2e8f0; font-family:'Syne',sans-serif; margin:0 0 10px; }
    .req-success p { color:#8b949e; margin:0 0 32px; }
    .req-success-fill-wrap { height:6px; background:rgba(255,255,255,.08); border-radius:3px; max-width:300px; margin:0 auto 8px; }
    .req-success-fill { height:100%; background:linear-gradient(90deg,#10b981,var(--req-blue)); border-radius:3px; width:0; transition:width .03s linear; }
    .req-success-note { font-size:.78rem; color:#6e7681; }

    .mobile-step-fill { background:linear-gradient(90deg,var(--req-blue),var(--req-indigo)); }
    .dp-avatar { background:linear-gradient(135deg,var(--req-blue),var(--req-indigo)); }
    .field-error { color:#f87171; }
    textarea.req-textarea { width:100%; min-height:100px; resize:vertical; padding:12px; border-radius:10px; font-size:.9rem; font-family:'Inter',sans-serif; box-sizing:border-box; color:#e2e8f0 !important; background:transparent !important; }

    /* donor-nav links in dark context */
    .donor-nav-links .dnav-link { color:#8b949e; }
    .donor-nav .dp-info .dp-name { color:#e2e8f0; }
    .donor-nav .dp-info .dp-role { color:#6e7681; }
    .donor-nav .dp-logout svg { stroke:#8b949e; }

    @keyframes spin { to { transform:rotate(360deg); } }
    .spin { animation:spin 1s linear infinite; }
    @media(max-width:640px){.priority-grid{grid-template-columns:1fr}.transport-row{grid-template-columns:1fr}.review-grid{grid-template-columns:1fr}}

  </style>
</head>
<body class="donate-body">

  <div class="auth-guard" id="authGuard">
    <div class="guard-spinner">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
    </div>
  </div>

  <nav class="donor-nav" id="donorNav">
    <div class="nav-inner">
      <a href="/" class="nav-logo">
        <span class="logo-icon">🥗</span>
        <span class="logo-text">ResQ<span class="logo-accent">Meal</span></span>
      </a>
      <div class="donor-nav-links">
        <a href="/#live-feed" class="dnav-link">Live Feed</a>
        <a href="/request" class="dnav-link active">Request Food</a>
        <a href="/ngo-requests" class="dnav-link">My Requests <span id="ngoBadge" style="display:none; background:#f85149; color:#fff; border-radius:50%; padding:2px 6px; font-size:12px; margin-left:4px;">0</span></a>
      </div>
      <div class="donor-profile" id="ngoProfile">
        <div class="dp-avatar" id="ngoAvatar">N</div>
        <div class="dp-info">
          <span class="dp-name" id="ngoName">NGO User</span>
          <span class="dp-role" id="ngoRoleLabel">Verified NGO</span>
        </div>
        <button class="dp-logout" id="logoutBtn" title="Log out">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </button>
      </div>
    </div>
  </nav>

  <div class="donate-page">

    <aside class="donate-sidebar">
      <div class="stepper">
        <div class="stepper-step active" data-step="1">
          <div class="step-circle">1</div>
          <div class="step-label"><strong>Request Details</strong><span>What you need</span></div>
        </div>
        <div class="stepper-line" id="line-1-2"></div>
        <div class="stepper-step" data-step="2">
          <div class="step-circle">2</div>
          <div class="step-label"><strong>Pickup &amp; Delivery</strong><span>When &amp; where</span></div>
        </div>
        <div class="stepper-line" id="line-2-3"></div>
        <div class="stepper-step" data-step="3">
          <div class="step-circle">3</div>
          <div class="step-label"><strong>Review &amp; Submit</strong><span>Confirm request</span></div>
        </div>
      </div>
      <div class="sidebar-ngo-badge">
        <h5>🏢 Requesting as</h5>
        <p id="sidebarOrgName">Your Organisation</p>
        <small id="sidebarNgoType">NGO</small>
      </div>
      <div class="sidebar-tip">
        <span class="tip-icon">💡</span>
        <p>Requests with accurate beneficiary counts and clear purpose are <strong>approved 2× faster.</strong></p>
      </div>
    </aside>

    <main class="donate-main">
      <div class="mobile-steps">
        <div class="mobile-step-bar">
          <div class="mobile-step-fill" id="mobileStepFill" style="width:33.33%"></div>
        </div>
        <span class="mobile-step-label" id="mobileStepLabel">Step 1 of 3 — Request Details</span>
      </div>

      <form id="requestForm" novalidate>

        <!-- STEP 1 -->
        <div class="form-step active" id="step-1">
          <div class="step-header">
            <h2>What food are you requesting?</h2>
            <p>Provide details about the food item and how many people it will benefit.</p>
          </div>

          <div class="food-preview-banner" id="foodPreviewBanner" style="display:none">
            <div class="food-preview-icon">🍱</div>
            <div class="food-preview-info">
              <h4 id="previewFoodName">Food Name</h4>
              <p id="previewFoodMeta">Qty · Location</p>
            </div>
            <div class="food-preview-badge">Selected</div>
          </div>

          @if(isset($weather) && $weather)
          <div class="weather-widget" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:12px; padding:16px; margin-bottom:24px; display:flex; align-items:center; gap:16px;">
            <div style="font-size:2rem;">
              @php
                  $icon = '🌤️';
                  $desc = strtolower($weather['weather'][0]['main'] ?? '');
                  if(str_contains($desc, 'rain')) $icon = '🌧️';
                  elseif(str_contains($desc, 'cloud')) $icon = '☁️';
                  elseif(str_contains($desc, 'clear')) $icon = '☀️';
                  elseif(str_contains($desc, 'snow')) $icon = '❄️';
                  elseif(str_contains($desc, 'thunder')) $icon = '⛈️';
              @endphp
              {{ $icon }}
            </div>
            <div style="flex-grow:1;">
              <h4 style="margin:0; font-size:1rem; color:#e2e8f0;">Pickup Location Weather</h4>
              <p style="margin:4px 0 0; font-size:0.85rem; color:#8b949e;">
                <strong>Temp:</strong> {{ round($weather['main']['temp'] ?? 0) }}°C &middot; 
                <strong>Condition:</strong> {{ ucfirst($weather['weather'][0]['description'] ?? 'Unknown') }} <br>
                <strong>Humidity:</strong> {{ $weather['main']['humidity'] ?? 0 }}% &middot; 
                <strong>Wind:</strong> {{ isset($weather['wind']['speed']) ? round($weather['wind']['speed'] * 3.6, 1) : 0 }} km/h
              </p>
            </div>
            @if(str_contains($desc, 'rain') || str_contains($desc, 'thunder') || str_contains($desc, 'snow') || str_contains($desc, 'extreme'))
            <div style="background:rgba(239,68,68,0.15); color:#fca5a5; border:1px solid rgba(239,68,68,0.3); padding:8px 12px; border-radius:8px; font-size:0.8rem; font-weight:600;">
              ⚠️ Delay Warning
            </div>
            @endif
          </div>
          @endif

          <div class="field-group">
            <label for="req-food-name">Food item name <span class="req">*</span></label>
            <div class="input-wrap">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
              <input type="text" id="req-food-name" placeholder="e.g. Biryani, Mixed Vegetables, Canned Lentils…" required />
            </div>
            <span class="field-error" id="req-food-name-err"></span>
          </div>

          <div class="field-row-2">
            <div class="field-group">
              <label for="req-quantity">Quantity needed <span class="req">*</span></label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                <input type="number" id="req-quantity" placeholder="e.g. 20" min="1" required />
              </div>
              <span class="field-error" id="req-quantity-err"></span>
            </div>
            <div class="field-group">
              <label for="req-unit">Unit <span class="req">*</span></label>
              <div class="input-wrap select-wrap">
                <select id="req-unit" required>
                  <option value="" disabled selected>Select unit</option>
                  <option value="portions">Portions / Plates</option>
                  <option value="kg">Kilograms (kg)</option>
                  <option value="grams">Grams (g)</option>
                  <option value="litres">Litres (L)</option>
                  <option value="packs">Packs</option>
                  <option value="boxes">Boxes</option>
                  <option value="trays">Trays</option>
                  <option value="units">Units / Items</option>
                </select>
                <svg class="select-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
              </div>
              <span class="field-error" id="req-unit-err"></span>
            </div>
          </div>

          <div class="field-group">
            <label for="req-beneficiary">Number of people who will benefit <span class="req">*</span></label>
            <div class="input-wrap">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
              <input type="number" id="req-beneficiary" placeholder="e.g. 50" min="1" required />
            </div>
            <span class="field-error" id="req-beneficiary-err"></span>
          </div>

          <div class="field-group">
            <label for="req-purpose">Purpose of request <span class="req">*</span></label>
            <div class="input-wrap">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              <input type="text" id="req-purpose" placeholder="e.g. Shelter feeding, Flood relief, Weekly meal drive…" required />
            </div>
            <span class="field-error" id="req-purpose-err"></span>
          </div>

          <div class="field-group">
            <label>Request priority <span class="req">*</span></label>
            <div class="priority-grid">
              <label class="priority-option">
                <input type="radio" name="req-priority" value="normal" checked />
                <div class="priority-card normal"><span>🟢</span><strong>Normal</strong><em>Within 24–48 hrs</em></div>
              </label>
              <label class="priority-option">
                <input type="radio" name="req-priority" value="urgent" />
                <div class="priority-card urgent"><span>🟡</span><strong>Urgent</strong><em>Within a few hours</em></div>
              </label>
              <label class="priority-option">
                <input type="radio" name="req-priority" value="emergency" />
                <div class="priority-card emergency"><span>🔴</span><strong>Emergency</strong><em>Immediate need</em></div>
              </label>
            </div>
            <span class="field-error" id="req-priority-err"></span>
          </div>

          <div class="step-actions">
            <div></div>
            <button type="button" class="btn-next" data-next="2">Continue to Pickup &amp; Delivery →</button>
          </div>
        </div>

        <!-- STEP 2 -->
        <div class="form-step" id="step-2">
          <div class="step-header">
            <h2>Pickup &amp; delivery details</h2>
            <p>Tell us when you can collect, and where the food will be distributed.</p>
          </div>

          <div class="field-group">
            <label>Preferred pickup window <span class="req">*</span></label>
            <div class="field-row-2">
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/></svg>
                <input type="datetime-local" id="req-pickup-from" required />
              </div>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <input type="datetime-local" id="req-pickup-to" required />
              </div>
            </div>
            <span class="field-error" id="req-pickup-err"></span>
          </div>

          <div class="field-group">
            <label for="req-delivery-address">Delivery / distribution address <span class="req">*</span></label>
            <div class="input-wrap">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <input type="text" id="req-delivery-address" placeholder="e.g. Hope Foundation, Road 5, Mirpur, Dhaka" required />
            </div>
            <span class="field-error" id="req-delivery-address-err"></span>
          </div>

          <div class="field-group">
            <label>Transport arrangement <span class="req">*</span></label>
            <div class="transport-row">
              <label class="transport-option">
                <input type="radio" name="req-transport" value="self" checked />
                <div class="transport-card"><div class="t-icon">🚐</div><div><strong>Self pickup</strong><span>We will collect from donor</span></div></div>
              </label>
              <label class="transport-option">
                <input type="radio" name="req-transport" value="need_help" />
                <div class="transport-card"><div class="t-icon">🤝</div><div><strong>Need transport help</strong><span>Request volunteer to deliver</span></div></div>
              </label>
            </div>
            <span class="field-error" id="req-transport-err"></span>
          </div>

          <div class="field-group">
            <label for="req-notes">Additional notes <span class="label-optional">(optional)</span></label>
            <div class="input-wrap" style="padding:0">
              <textarea id="req-notes" class="req-textarea" placeholder="Any special instructions, dietary constraints, storage needs…"></textarea>
            </div>
          </div>

          <div class="step-actions">
            <button type="button" class="btn-back" data-prev="1">← Back</button>
            <button type="button" class="btn-next" data-next="3">Review &amp; Submit →</button>
          </div>
        </div>

        <!-- STEP 3 -->
        <div class="form-step" id="step-3">
          <div class="step-header">
            <h2>Review your request</h2>
            <p>Please confirm all details before submitting.</p>
          </div>
          <div class="review-grid" id="reviewGrid"></div>
          <div class="field-group" style="margin-top:24px">
            <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
              <input type="checkbox" id="req-confirm-check" style="width:18px;height:18px;accent-color:var(--req-blue)" />
              <span style="color:#c9d1d9;font-size:.9rem">I confirm that all information is accurate and this request is genuine.</span>
            </label>
            <span class="field-error" id="req-confirm-err"></span>
          </div>
          <span class="field-error" id="req-submit-err" style="display:block;margin-bottom:12px"></span>
          <div class="step-actions">
            <button type="button" class="btn-back" data-prev="2">← Back</button>
            <button type="submit" class="btn-next btn-submit" id="reqSubmitBtn">
              <span class="btn-text">✅ Submit Request</span>
              <span class="btn-spinner" hidden>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="spin"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
              </span>
            </button>
          </div>
        </div>
      </form>

      <div class="req-success" id="reqSuccess">
        <div class="req-success-icon">🎉</div>
        <h2>Request Submitted!</h2>
        <p>Your food request has been received. Our team will review and coordinate with the donor shortly.</p>
        <div class="req-success-fill-wrap"><div class="req-success-fill" id="reqSuccessFill"></div></div>
        <p class="req-success-note">Redirecting you to the Live Feed…</p>
      </div>
    </main>
  </div>

  <script>
  (function(){
    /* Auth guard */
    const ngoUser=(()=>{try{return JSON.parse(sessionStorage.getItem('resqmeal_ngo_user'));}catch{return null;}})();
    if(!ngoUser||!ngoUser.isNgo){
      const p=new URLSearchParams(window.location.search);
      const did=p.get('donation_id')||'';
      window.location.href='/ngo-login'+(did?`?donation_id=${did}`:'');
      return;
    }
    document.getElementById('authGuard').style.display='none';

    /* Nav profile */
    const fullName=`${ngoUser.name||''} ${ngoUser.last||''}`.trim()||ngoUser.email;
    document.getElementById('ngoName').textContent=fullName;
    document.getElementById('ngoAvatar').textContent=(ngoUser.name||'N')[0].toUpperCase();
    const roleMap={ngo:'Verified NGO',volunteer:'Volunteer',shelter:'Shelter'};
    document.getElementById('ngoRoleLabel').textContent=roleMap[ngoUser.receiver_type]||'Verified NGO';
    document.getElementById('sidebarOrgName').textContent=ngoUser.org||fullName;
    document.getElementById('sidebarNgoType').textContent=roleMap[ngoUser.receiver_type]||'NGO';

    document.getElementById('logoutBtn').addEventListener('click',()=>{
      sessionStorage.removeItem('resqmeal_ngo_user');
      window.location.href='/ngo-login';
    });

    /* ─── NOTIFICATION BADGE ─── */
    fetch(`/api/ngo/requests?email=${encodeURIComponent(ngoUser.email)}`)
      .then(r => r.json())
      .then(data => {
        if(data.success) {
          const processed = data.requests.filter(r => r.status !== 'pending').length;
          const lastSeen = parseInt(localStorage.getItem('last_seen_ngo_processed') || '0');
          if (processed > lastSeen) {
            const badge = document.getElementById('ngoBadge');
            if (badge) {
              badge.textContent = processed - lastSeen; // show number of new updates
              badge.style.display = 'inline-block';
            }
          }
        }
      }).catch(err => console.error(err));

    /* Pre-fill from server-injected donation data */
    @if($donation)
    (function(){
      document.getElementById('foodPreviewBanner').style.display='flex';
      document.getElementById('previewFoodName').textContent='{{ addslashes($donation->food_name) }}';
      document.getElementById('previewFoodMeta').textContent='{{ $donation->quantity }} {{ $donation->unit }} \u00b7 {{ addslashes($donation->pickup_address) }}';
      document.getElementById('req-food-name').value='{{ addslashes($donation->food_name) }}';
      document.getElementById('req-quantity').value='{{ $donation->quantity }}';
      document.getElementById('req-unit').value='{{ $donation->unit }}';
    })();
    @endif

    /* Auto-fill default pickup times to prevent validation block */
    (function(){
      const now = new Date();
      now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
      document.getElementById('req-pickup-from').value = now.toISOString().slice(0,16);
      
      now.setHours(now.getHours() + 2);
      document.getElementById('req-pickup-to').value = now.toISOString().slice(0,16);
    })();

    const urlParams=new URLSearchParams(window.location.search);
    const donationId=urlParams.get('donation_id')||'';

    /* Stepper */
    let current=1;
    const labels=['Request Details','Pickup & Delivery','Review & Submit'];
    function goStep(n){
      document.getElementById(`step-${current}`).classList.remove('active');
      document.querySelectorAll('.stepper-step').forEach((s,i)=>{
        s.classList.toggle('active',i+1===n);
        s.classList.toggle('done',i+1<n);
      });
      for(let i=1;i<3;i++){const l=document.getElementById(`line-${i}-${i+1}`);if(l)l.classList.toggle('active',n>i);}
      current=n;
      document.getElementById(`step-${n}`).classList.add('active');
      const pct=Math.round(n/3*100);
      document.getElementById('mobileStepFill').style.width=pct+'%';
      document.getElementById('mobileStepLabel').textContent=`Step ${n} of 3 — ${labels[n-1]}`;
      window.scrollTo({top:0,behavior:'smooth'});
    }

    function clrAll(){document.querySelectorAll('.field-error').forEach(e=>e.textContent='');document.querySelectorAll('.input-wrap.error').forEach(e=>e.classList.remove('error'));}
    function setErr(id,msg){const e=document.getElementById(id);if(e)e.textContent=msg;}
    function markErr(iid,eid,msg){setErr(eid,msg);const i=document.getElementById(iid);if(i)i.closest('.input-wrap')?.classList.add('error');}

    function v1(){clrAll();let ok=true;
      if(!document.getElementById('req-food-name').value.trim()){markErr('req-food-name','req-food-name-err','Enter the food item name.');ok=false;}
      if(!document.getElementById('req-quantity').value||+document.getElementById('req-quantity').value<1){markErr('req-quantity','req-quantity-err','Enter the quantity needed.');ok=false;}
      if(!document.getElementById('req-unit').value){setErr('req-unit-err','Select a unit.');ok=false;}
      if(!document.getElementById('req-beneficiary').value||+document.getElementById('req-beneficiary').value<1){markErr('req-beneficiary','req-beneficiary-err','Enter beneficiary count.');ok=false;}
      if(!document.getElementById('req-purpose').value.trim()){markErr('req-purpose','req-purpose-err','Describe the purpose of this request.');ok=false;}
      if(!ok) {
        const err = document.querySelector('.field-error:not(:empty), .input-wrap.error');
        if(err) err.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
      return ok;}

    function v2(){clrAll();let ok=true;
      const fr=document.getElementById('req-pickup-from').value,to=document.getElementById('req-pickup-to').value;
      if(!fr){setErr('req-pickup-err','Select pickup start time.');ok=false;}
      else if(!to){setErr('req-pickup-err','Select pickup end time.');ok=false;}
      else if(new Date(to)<=new Date(fr)){setErr('req-pickup-err','End time must be after start time.');ok=false;}
      if(!document.getElementById('req-delivery-address').value.trim()){markErr('req-delivery-address','req-delivery-address-err','Enter the delivery address.');ok=false;}
      if(!ok) {
        const err = document.querySelector('.field-error:not(:empty), .input-wrap.error');
        if(err) err.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
      return ok;}

    function fmt(dt){if(!dt)return '—';return new Date(dt).toLocaleString('en-BD',{day:'numeric',month:'short',hour:'2-digit',minute:'2-digit'});}

    function collectData(){return{
      food_name:document.getElementById('req-food-name').value.trim(),
      qty:document.getElementById('req-quantity').value,
      unit:document.getElementById('req-unit').value,
      beneficiary:document.getElementById('req-beneficiary').value,
      purpose:document.getElementById('req-purpose').value.trim(),
      priority:document.querySelector('input[name="req-priority"]:checked')?.value||'normal',
      from:document.getElementById('req-pickup-from').value,
      to:document.getElementById('req-pickup-to').value,
      address:document.getElementById('req-delivery-address').value.trim(),
      transport:document.querySelector('input[name="req-transport"]:checked')?.value||'self',
      notes:document.getElementById('req-notes').value.trim(),
    };}

    function buildReview(){
      const d=collectData();
      const rt=roleMap[ngoUser.receiver_type]||'NGO';
      const tr=d.transport==='self'?'Self pickup':'Need transport help';
      const pri={normal:'🟢 Normal',urgent:'🟡 Urgent',emergency:'🔴 Emergency'}[d.priority]||d.priority;
      const items=[
        {l:'Food Item',v:d.food_name,f:false},{l:'Quantity',v:`${d.qty} ${d.unit}`,f:false},
        {l:'Beneficiaries',v:`${d.beneficiary} people`,f:false},{l:'Purpose',v:d.purpose,f:false},
        {l:'Priority',v:pri,f:false},{l:'Pickup From',v:fmt(d.from),f:false},
        {l:'Pickup To',v:fmt(d.to),f:false},{l:'Transport',v:tr,f:false},
        {l:'Delivery Address',v:d.address,f:true},{l:'Requesting As',v:`${ngoUser.org||fullName} (${rt})`,f:true},
        ...(d.notes?[{l:'Notes',v:d.notes,f:true}]:[]),
      ];
      document.getElementById('reviewGrid').innerHTML=items.map(it=>`<div class="review-item${it.f?' full':''}"><label>${it.l}</label><span>${it.v||'—'}</span></div>`).join('');
    }

    document.querySelectorAll('.btn-next[data-next]').forEach(b=>b.addEventListener('click',()=>{
      const n=+b.dataset.next;
      if(n===2&&!v1())return;
      if(n===3&&!v2())return;
      if(n===3)buildReview();
      goStep(n);
    }));
    document.querySelectorAll('.btn-back[data-prev]').forEach(b=>b.addEventListener('click',()=>goStep(+b.dataset.prev)));

    document.getElementById('requestForm').addEventListener('submit',function(e){
      e.preventDefault();clrAll();
      if(!document.getElementById('req-confirm-check').checked){setErr('req-confirm-err','Please confirm your information is accurate.');return;}
      const btn=document.getElementById('reqSubmitBtn');
      btn.querySelector('.btn-text').hidden=true;btn.querySelector('.btn-spinner').hidden=false;btn.disabled=true;
      const d=collectData();
      const csrf=document.querySelector('meta[name="csrf-token"]').content;
      fetch('/request',{
        method:'POST',
        headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf},
        body:JSON.stringify({
          donation_id:donationId||null,
          requester_name:`${ngoUser.name||''} ${ngoUser.last||''}`.trim(),
          requester_email:ngoUser.email,
          requester_phone:ngoUser.phone||'',
          organisation:ngoUser.org||'',
          receiver_type:ngoUser.receiver_type||'ngo',
          requester_city:ngoUser.city||'',
          requested_quantity:d.qty,
          quantity_unit:d.unit,
          beneficiary_count:d.beneficiary,
          purpose:d.purpose,
          transport:d.transport,
          preferred_pickup_from:d.from,
          preferred_pickup_to:d.to,
          delivery_address:d.address,
          priority:d.priority,
          notes:d.notes||null,
        }),
      })
      .then(async res=>{
        const data=await res.json();
        if(res.ok&&data.success){
          document.getElementById('requestForm').style.display='none';
          document.getElementById('reqSuccess').style.display='block';
          
          /* Log the user out so the next request requires login again */
          sessionStorage.removeItem('resqmeal_ngo_user');

          let w=0;const fill=document.getElementById('reqSuccessFill');
          const t=setInterval(()=>{w+=2;fill.style.width=w+'%';if(w>=100){clearInterval(t);window.location.href='/#live-feed';}},30);
        } else {
          btn.querySelector('.btn-text').hidden=false;btn.querySelector('.btn-spinner').hidden=true;btn.disabled=false;
          const msgs=data.errors?Object.values(data.errors).flat().join(' '):(data.message||'Submission failed.');
          setErr('req-submit-err',msgs);
        }
      })
      .catch(()=>{
        btn.querySelector('.btn-text').hidden=false;btn.querySelector('.btn-spinner').hidden=true;btn.disabled=false;
        setErr('req-submit-err','Network error — please check your connection.');
      });
    });
  })();
  </script>
</body>
</html>
