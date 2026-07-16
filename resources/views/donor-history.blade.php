<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ResQMeal — Donation Details</title>
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
    .donor-nav .logo-text  { color:#e2e8f0 !important; }
    .donor-nav .logo-accent { color:var(--req-blue) !important; }
    .donor-nav-links .dnav-link { color:#8b949e !important; }
    .donor-nav-links .dnav-link:hover,
    .donor-nav-links .dnav-link.active { color:var(--req-blue) !important; }
    .donor-nav-links .dnav-link.active::after { background:var(--req-blue) !important; }
    .dp-name { color:#e2e8f0 !important; }
    .dp-role { color:#6e7681 !important; }
    .dp-logout { color:#6e7681 !important; }
    .dp-logout:hover { color:#f87171 !important; }
    .donor-profile { border-color:rgba(255,255,255,.08) !important; }

    /* Override review card styles for dark theme */
    .preview-card { background:#161b22 !important; border-color:rgba(255,255,255,.06) !important; border-radius: 12px !important; overflow: hidden !important; box-shadow: 0 12px 32px rgba(0,0,0,0.4) !important; max-width: 700px !important; margin: 40px auto !important; }
    .preview-body { padding: 32px !important; background:#161b22 !important; }
    .preview-body h3 { color:#e2e8f0 !important; font-size: 1.8rem !important; margin-bottom: 8px !important; font-family: 'Syne', sans-serif !important; }
    .pv-donor-meta { color:#8b949e !important; margin-bottom: 24px !important; font-size: 0.95rem !important; }
    
    .pv-grid { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 20px !important; margin-bottom: 24px !important; border-top: 1px solid rgba(255,255,255,.06) !important; border-bottom: 1px solid rgba(255,255,255,.06) !important; padding: 24px 0 !important; }
    .pv-item { display: flex !important; align-items: center !important; gap: 12px !important; }
    .pv-icon { font-size: 1.5rem !important; background: rgba(255,255,255,.04) !important; width: 44px !important; height: 44px !important; display: flex !important; align-items: center !important; justify-content: center !important; border-radius: 50% !important; }
    .pv-item div { display: flex !important; flex-direction: column !important; }
    .pv-item strong { color:#e2e8f0 !important; font-size: 1rem !important; }
    .pv-item span { color:#6e7681 !important; font-size: 0.75rem !important; text-transform: uppercase !important; letter-spacing: 0.05em !important; font-weight: 600 !important; }
    
    .pv-address-row { display: flex !important; align-items: center !important; gap: 12px !important; padding: 16px !important; background: rgba(255,255,255,.03) !important; border-radius: 8px !important; margin-bottom: 24px !important; color:#c9d1d9 !important; border: 1px solid rgba(255,255,255,.06) !important; }
    
    .pv-dietary { display: flex !important; flex-wrap: wrap !important; gap: 8px !important; margin-bottom: 24px !important; }
    .pv-dietary span { background: rgba(59,130,246,.15) !important; border: 1px solid rgba(59,130,246,.2) !important; color: #93c5fd !important; padding: 6px 12px !important; border-radius: 20px !important; font-size: 0.8rem !important; font-weight: 500 !important; }
    
    .pv-notes-block { background: rgba(255,193,7,.1) !important; border-left: 4px solid #ffc107 !important; padding: 16px !important; border-radius: 0 8px 8px 0 !important; margin-bottom: 24px !important; }
    .pv-notes-block strong { color: #ffc107 !important; display: block !important; margin-bottom: 4px !important; font-size: 0.85rem !important; text-transform: uppercase !important; letter-spacing: 0.05em !important; }
    .pv-notes-block p { color: #e2e8f0 !important; margin: 0 !important; font-size: 0.95rem !important; line-height: 1.5 !important; }

    .pv-urgency-bar { height: 6px; background: rgba(255,255,255,.08); border-radius: 3px; overflow: hidden; margin-bottom: 8px; }
    .pv-ub-fill { height: 100%; background: #10b981; border-radius: 3px; }
    .pv-ub-label { font-size: 0.8rem; color: #8b949e; text-align: right; margin: 0; }

    .pv-action-row { margin-top: 32px; display: flex; gap: 16px; border-top: 1px solid rgba(255,255,255,.06); padding-top: 24px; }
    .btn-claim { background: linear-gradient(135deg,var(--req-blue) 0%,var(--req-indigo) 100%); color:#fff; text-decoration:none; text-align:center; padding:14px; border-radius:8px; font-weight:600; transition:all .2s; border:none; cursor:pointer; flex: 2; }
    .btn-claim:hover { box-shadow:0 8px 30px rgba(59,130,246,.4); transform: translateY(-2px); }
    .btn-back { background: rgba(255,255,255,.05); color:#c9d1d9; text-decoration:none; text-align:center; padding:14px; border-radius:8px; font-weight:600; transition:all .2s; flex: 1; }
    .btn-back:hover { background: rgba(255,255,255,.1); }

    .preview-image-area { height: 200px; background: #111827; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
    .preview-image-area img.real-food-img { width: 100%; height: 100%; object-fit: cover; }
    .preview-img-placeholder { font-size: 5rem; z-index: 2; }
    .preview-img-badges { position: absolute; top: 16px; left: 16px; right: 16px; display: flex; justify-content: space-between; z-index: 10; }
    .pv-cat-badge { background: #fff; color: #111; font-weight: 700; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; }
    .pv-urgency { background: #10b981; color: #fff; font-weight: 700; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; }
  </style>
</head>
<body class="donate-body">

  <!-- ── Nav ── -->
  <nav class="donor-nav" id="donorNav">
    <div class="nav-inner">
      <a href="/" class="nav-logo">
        <span class="logo-icon">🥗</span>
        <span class="logo-text">ResQ<span class="logo-accent">Meal</span></span>
      </a>
      <div class="donor-nav-links">
        <a href="/" class="dnav-link active">Live Feed</a>
      </div>
      <div class="donor-profile" id="ngoProfile" style="display:none">
        <div class="dp-avatar" id="ngoAvatar"></div>
        <div class="dp-info">
          <span class="dp-name" id="ngoName"></span>
          <span class="dp-role" id="ngoRole"></span>
        </div>
        <button class="dp-logout" id="ngoLogoutBtn" title="Log out">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </button>
      </div>
    </div>
  </nav>

  <main style="padding: 100px 24px;">
    <div class="preview-card">
      <div class="preview-image-area">
        @if($donation->image_path)
            <img src="{{ asset('storage/' . $donation->image_path) }}" alt="{{ $donation->food_name }}" class="real-food-img">
        @else
            <div class="preview-img-placeholder">
                @if($donation->category == 'cooked') 🍛 
                @elseif($donation->category == 'raw') 🥦 
                @elseif($donation->category == 'packaged') 📦 
                @elseif($donation->category == 'bakery') 🍞 
                @elseif($donation->category == 'beverages') 🧃 
                @else 🥗 
                @endif
            </div>
        @endif
        <div class="preview-img-badges">
          <span class="pv-cat-badge" style="text-transform: capitalize;">{{ $donation->category }}</span>
          @php
            $expiry = \Carbon\Carbon::parse($donation->expiry);
            $isExpired = $expiry->isPast();
            $diffHours = now()->diffInHours($expiry, false);
            $urgency = 'Available';
            $bgColor = '#10b981';
            if ($isExpired) { $urgency = 'Expired'; $bgColor = '#ef4444'; }
            elseif ($diffHours < 2 || $donation->emergency) { $urgency = 'Critical'; $bgColor = '#ef4444'; }
            elseif ($diffHours < 6) { $urgency = 'Urgent'; $bgColor = '#f59e0b'; }
          @endphp
          <span class="pv-urgency" style="background: {{ $bgColor }}">{{ $urgency }}</span>
        </div>
      </div>
      <div class="preview-body">
        <h3>{{ $donation->food_name }}</h3>
        <p class="pv-donor-meta">📍 {{ $donation->donor_name ?? 'Anonymous Donor' }}</p>

        <div class="pv-grid">
          <div class="pv-item">
            <span class="pv-icon">🍽️</span>
            <div><strong>{{ $donation->quantity }} {{ $donation->unit }}</strong><span>Quantity</span></div>
          </div>
          <div class="pv-item">
            <span class="pv-icon">👥</span>
            <div><strong>~{{ $donation->serves }} people</strong><span>People served</span></div>
          </div>
          <div class="pv-item">
            <span class="pv-icon">🕐</span>
            <div><strong>{{ $expiry->format('d M, H:i') }}</strong><span>Best before</span></div>
          </div>
          <div class="pv-item">
            <span class="pv-icon">🧊</span>
            <div><strong style="text-transform: capitalize;">{{ $donation->storage }}</strong><span>Storage</span></div>
          </div>
        </div>

        <div class="pv-address-row">
          <span>📍</span>
          <span>Pickup Address: <strong>{{ $donation->pickup_address }}</strong></span>
        </div>
        <div class="pv-address-row" style="margin-top:-16px;">
          <span>🕒</span>
          <span>Window: <strong>{{ \Carbon\Carbon::parse($donation->pickup_from)->format('H:i') }} to {{ \Carbon\Carbon::parse($donation->pickup_to)->format('H:i') }}</strong></span>
        </div>

        @if($donation->dietary || $donation->allergens)
        <div class="pv-dietary">
            @if($donation->dietary)
                @foreach(explode(', ', $donation->dietary) as $d)
                    <span>{{ ucfirst($d) }}</span>
                @endforeach
            @endif
            @if($donation->allergens)
                @foreach(explode(', ', $donation->allergens) as $a)
                    <span style="background:rgba(239,68,68,.15);border-color:rgba(239,68,68,.3);color:#fca5a5;">Allergen: {{ ucfirst($a) }}</span>
                @endforeach
            @endif
        </div>
        @endif

        @if($donation->notes)
        <div class="pv-notes-block">
          <strong>Donor notes:</strong>
          <p>{{ $donation->notes }}</p>
        </div>
        @endif

        {{-- ── Matched NGOs Section ── --}}
        @if($matchedNgos->isNotEmpty())
        <div style="margin-bottom:24px;">
          <strong style="color:#e2e8f0;font-size:0.85rem;text-transform:uppercase;letter-spacing:0.08em;display:block;margin-bottom:12px;">🎯 Smart Matched Recipients</strong>
          <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach($matchedNgos as $ngo)
            @php
              $name = $ngo->organisation ?? ($ngo->first_name . ' ' . $ngo->last_name);
              $score = $ngo->match_score;
              $isPriority = $ngo->is_priority;
              $barColor = $score >= 70 ? '#10b981' : ($score >= 40 ? '#f59e0b' : '#6b7280');
              $tagLabel = $isPriority ? 'Priority' : 'Standard';
              $tagColor = $isPriority ? 'rgba(16,185,129,.2)' : 'rgba(99,102,241,.15)';
              $tagTextColor = $isPriority ? '#6ee7b7' : '#a5b4fc';
            @endphp
            <div style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);border-radius:10px;padding:14px 16px;display:flex;align-items:center;gap:14px;">
              <div style="font-size:1.5rem;width:40px;text-align:center;">
                {{ $isPriority ? '🏠' : '🏢' }}
              </div>
              <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                  <strong style="color:#e2e8f0;font-size:0.9rem;">{{ $name }}</strong>
                  <span style="font-size:0.7rem;font-weight:600;padding:2px 8px;border-radius:20px;background:{{ $tagColor }};color:{{ $tagTextColor }};text-transform:uppercase;">{{ $tagLabel }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:8px;">
                  <div style="flex:1;height:5px;background:rgba(255,255,255,.08);border-radius:3px;overflow:hidden;">
                    <div style="height:100%;width:{{ $score }}%;background:{{ $barColor }};border-radius:3px;"></div>
                  </div>
                  <span style="font-size:0.75rem;color:#8b949e;white-space:nowrap;">{{ $score }}% match</span>
                </div>
                <span style="font-size:0.75rem;color:#6e7681;text-transform:capitalize;">{{ $ngo->receiver_type ?? 'NGO' }} • {{ $ngo->city ?? 'N/A' }}</span>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endif

        <div class="pv-action-row">
          <a href="/#live-feed" class="btn-back">← Back to Feed</a>
          <a href="/ngo-login?donation_id={{ $donation->id }}" class="btn-claim">Request Food Now</a>
        </div>
      </div>
    </div>
  </main>

  @if(session()->has('ngo'))
  <script>
    if (!sessionStorage.getItem('resqmeal_ngo_user')) {
      const serverNgo = {!! json_encode(session('ngo')) !!};
      sessionStorage.setItem('resqmeal_ngo_user', JSON.stringify({
        email:         serverNgo.email,
        name:          serverNgo.first_name,
        last:          serverNgo.last_name,
        phone:         serverNgo.phone,
        city:          serverNgo.city,
        org:           serverNgo.organisation,
        receiver_type: serverNgo.receiver_type,
        role:          'ngo',
        isNgo:         true,
      }));
    }
  </script>
  @endif

  <script>
    /* ── Render NGO User (if logged in) ── */
    const ngoUser = (() => {
      try { return JSON.parse(sessionStorage.getItem('resqmeal_ngo_user')); } catch { return null; }
    })();

    if (ngoUser && ngoUser.isNgo) {
      document.getElementById('ngoProfile').style.display = 'flex';
      const f = ngoUser.name.charAt(0).toUpperCase();
      document.getElementById('ngoAvatar').textContent = f;
      document.getElementById('ngoName').textContent = `${ngoUser.name} ${ngoUser.last||''}`.trim();
      let role = 'NGO';
      if(ngoUser.receiver_type === 'volunteer') role = 'Volunteer';
      if(ngoUser.receiver_type === 'shelter') role = 'Shelter';
      document.getElementById('ngoRole').textContent = role;
    }

    document.getElementById('ngoLogoutBtn')?.addEventListener('click', () => {
      sessionStorage.removeItem('resqmeal_ngo_user');
      window.location.href = '/ngo-logout';
    });
  </script>
</body>
</html>
