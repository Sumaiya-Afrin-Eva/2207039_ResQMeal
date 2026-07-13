<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ResQMeal — Rescue Food. Rebuild Lives.</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
</head>
<body>

  <!-- ───────────────────── NAV ───────────────────── -->
  <nav class="nav" id="navbar">
    <div class="nav-inner">
      <a href="/" class="nav-logo">
        <span class="logo-icon">🥗</span>
        <span class="logo-text">ResQ<span class="logo-accent">Meal</span></span>
      </a>

      <ul class="nav-links">
        <li><a href="#features">Features</a></li>
        <li><a href="#live-feed">Live Feed</a></li>
        <li><a href="#analytics">Analytics</a></li>
        <li><a href="#trust">Trust Score</a></li>
        <li><a href="#alerts">Alerts</a></li>
      </ul>

      <div class="nav-actions">
        <a href="/login" class="btn-ghost">Log In</a>
        <a href="/donate" class="btn-primary">Donate Food</a>
      </div>

      <button class="hamburger" id="hamburger" aria-label="Open menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>

  <!-- ───────────────────── MOBILE MENU ───────────────────── -->
  <div class="mobile-menu" id="mobileMenu">
    <ul>
      <li><a href="#features">Features</a></li>
      <li><a href="#live-feed">Live Feed</a></li>
      <li><a href="#analytics">Analytics</a></li>
      <li><a href="#trust">Trust Score</a></li>
      <li><a href="#alerts">Alerts</a></li>
      <li><a href="/donate" class="btn-primary full-width">Donate Food</a></li>
    </ul>
  </div>

  <!-- ───────────────────── HERO ───────────────────── -->
  <section class="hero" id="home">
    <div class="hero-bg-pattern"></div>

    <div class="hero-content">
      <div class="hero-badge">
        <span class="pulse-dot"></span>
        <span>Live Rescue Operations Active</span>
      </div>

      <h1 class="hero-title">
        Every Meal<br />
        <em>Rescued</em> Is a<br />
        Life <span class="title-highlight">Nourished.</span>
      </h1>

      <p class="hero-sub">
        ResQMeal connects surplus food donors with NGOs, volunteers, and
        communities in real time — powered by smart matching, expiration
        alerts, and verified trust scores.
      </p>

      <div class="hero-cta">
        <a href="/login" class="btn-primary large">Start Donating</a>
        <a href="#live-feed" class="btn-outline large">Request Food Aid</a>
      </div>

      <!-- Rescue Ticker -->
      <div class="rescue-ticker">
        <span class="ticker-label">RESCUE TICKER</span>
        <div class="ticker-track">
          <div class="ticker-items">
            @forelse($tickerEvents as $event)
              <span>{{ $event['emoji'] ?? '🍱' }} {{ $event['text'] }} &nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;</span>
            @empty
              <span>No recent updates &nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;</span>
            @endforelse
            <!-- Duplicate for seamless infinite scroll animation -->
            @forelse($tickerEvents as $event)
              <span>{{ $event['emoji'] ?? '🍱' }} {{ $event['text'] }} &nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;</span>
            @empty
              <span>No recent updates &nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;</span>
            @endforelse
          </div>
        </div>
      </div>
    </div>

    <!-- Hero Stats Strip -->
    <div class="hero-stats">
      <div class="stat-item">
        <span class="stat-num" data-target="{{ $mealsApproved }}">0</span>
        <span class="stat-label">Meals Approved</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat-item">
        <span class="stat-num" data-target="{{ $activeDonors }}">0</span>
        <span class="stat-label">Active Donors</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat-item">
        <span class="stat-num" data-target="{{ $activeNGOs }}">0</span>
        <span class="stat-label">Active NGO/Volunteer</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat-item">
        <span class="stat-num" data-target="{{ $pickupRate }}">0</span>
        <span class="stat-label">% Pickup Rate</span>
      </div>
    </div>
  </section>

  <!-- ───────────────────── FEATURES ───────────────────── -->
  <section class="features" id="features">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Platform Features</span>
        <h2 class="section-title">Built for Speed.<br />Designed for Impact.</h2>
        <p class="section-desc">
          Every tool you need to turn surplus food into community lifelines — from instant donation posting to AI-powered distribution.
        </p>
      </div>

      <div class="features-grid">

        <div class="feat-card feat-card--large">
          <div class="feat-icon-wrap accent-green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/><path d="M12 6v6l4 2"/></svg>
          </div>
          <h3>Expiration Countdown</h3>
          <p>Real-time countdown timers on every food listing prioritize urgent rescues before spoilage.</p>
          <!-- Mini countdown demo -->
          <div class="countdown-demo">
            @foreach($donations->take(3) as $donation)
              @php
                $cdExpiry  = \Carbon\Carbon::parse($donation->expiry);
                $cdSeconds = $cdExpiry->isFuture() ? (int) now()->diffInSeconds($cdExpiry) : 0;
                $cdH = floor($cdSeconds / 3600);
                $cdM = floor(($cdSeconds % 3600) / 60);
                $cdS = $cdSeconds % 60;
                $cdTime = sprintf('%02d:%02d:%02d', $cdH, $cdM, $cdS);
                $cdClass = $cdSeconds < 3600 ? 'critical' : ($cdSeconds < 10800 ? 'warning' : 'safe');
              @endphp
              @if($cdExpiry->isFuture())
                <div class="cd-item {{ $cdClass }}">
                  <span class="cd-label">{{ $donation->food_name }} — {{ $donation->quantity }} {{ $donation->unit }}</span>
                  <span class="cd-time" data-expiry="{{ $cdExpiry->toIso8601String() }}">{{ $cdTime }}</span>
                </div>
              @endif
            @endforeach


            @if($donations->filter(fn($d) => \Carbon\Carbon::parse($d->expiry)->isFuture())->isEmpty())
              <div class="cd-item safe">
                <span class="cd-label">No active donations yet — be the first!</span>
                <span class="cd-time">--:--:--</span>
              </div>
            @endif
          </div>
        </div>

        <div class="feat-card">
          <div class="feat-icon-wrap accent-amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
          </div>
          <h3>Live Food Availability</h3>
          <p>See what's available right now — updated the moment a donor posts, with quantity, type, and location.</p>
        </div>

        <div class="feat-card">
          <div class="feat-icon-wrap accent-coral">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <h3>NGO / Volunteer Requests</h3>
          <p>NGOs and volunteers can submit verified food requests linked directly to donor supply in their zone.</p>
        </div>

        <div class="feat-card">
          <div class="feat-icon-wrap accent-green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          </div>
          <h3>Pickup Scheduling</h3>
          <p>Donors set windows; volunteers book slots. Automated reminders eliminate missed pickups.</p>
        </div>

        <div class="feat-card feat-card--large feat-card--dark">
          <div class="feat-icon-wrap accent-amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <h3>Location Tracking</h3>
          <p>Live map view of donors, pickup points, and NGO hubs. Volunteers navigate with one tap.</p>
          <!-- Map placeholder -->
          <div class="map-placeholder">
            <div class="map-pin pin-1">📍</div>
            <div class="map-pin pin-2">🏢</div>
            <div class="map-pin pin-3">🚐</div>
            <div class="map-grid"></div>
            <span class="map-label">Live Coverage Map</span>
          </div>
        </div>

        <div class="feat-card">
          <div class="feat-icon-wrap accent-sage">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <h3>Donation History</h3>
          <p>Donors receive a verified impact log — meals rescued, CO₂ saved, and communities reached.</p>
        </div>

        <div class="feat-card">
          <div class="feat-icon-wrap accent-amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
          </div>
          <h3>Food Waste Analytics</h3>
          <p>Dashboards track waste trends by category, zone, and time — turning data into policy insights.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- ───────────────────── LIVE FEED ───────────────────── -->
  <section class="live-feed" id="live-feed">
    <div class="container">
      <div class="feed-header">
        <div>
          <span class="section-tag light">Live Board</span>
          <h2 class="section-title light">Food Available<br />Right Now</h2>
        </div>
        <div class="feed-controls">
          <button class="filter-btn active">All</button>
          <button class="filter-btn">Cooked</button>
          <button class="filter-btn">Raw</button>
          <button class="filter-btn">Packaged</button>
        </div>
      </div>

      <div class="feed-grid">

        @foreach($donations as $donation)
          @php
            $expiryCarbon    = \Carbon\Carbon::parse($donation->expiry);
            $remainingSeconds = $expiryCarbon->isFuture()
                                  ? (int) now()->diffInSeconds($expiryCarbon)
                                  : 0;
            $h = floor($remainingSeconds / 3600);
            $m = floor(($remainingSeconds % 3600) / 60);
            $s = $remainingSeconds % 60;
            $timeStr = sprintf('%02d:%02d:%02d', $h, $m, $s);

            $urgencyClass = 'safe';
            $urgencyText  = '✅ Available';
            if ($remainingSeconds < 3600) {
                $urgencyClass = 'urgent';
                $urgencyText  = '⚡ Critical';
            } elseif ($remainingSeconds < 10800) {
                $urgencyClass = 'moderate';
                $urgencyText  = '🕐 Moderate';
            }

            $catClass = 'cat-cooked';
            if (in_array($donation->category, ['raw', 'beverages'])) {
                $catClass = 'cat-raw';
            } elseif ($donation->category === 'packaged') {
                $catClass = 'cat-packaged';
            }
          @endphp
          @if($expiryCarbon->isFuture())
            <div class="feed-card" data-category="{{ $donation->category }}">
              <div class="feed-card-top">
                <span class="food-category {{ $catClass }}">{{ ucfirst($donation->category) }}</span>
                <span class="urgency-badge {{ $urgencyClass }}">{{ $urgencyText }}</span>
              </div>
              <h4 class="food-title">{{ $donation->food_name }} — {{ $donation->quantity }} {{ $donation->unit }}</h4>
              <p class="food-donor">📍 {{ $donation->donor_name ?? 'Donor' }}, {{ $donation->pickup_address }}</p>
              <div class="food-meta">
                <span>🕐 Expires in <strong class="live-timer" data-expiry="{{ $expiryCarbon->toIso8601String() }}">{{ $timeStr }}</strong></span>
                <span>👥 Serves ~{{ $donation->serves }} people</span>
              </div>
              <div class="food-progress">
                <div class="progress-bar" style="--pct:0%"></div>
              </div>
              <p class="progress-note">Unclaimed — act now</p>
              <div style="display:flex; gap:10px; margin-top:16px;">
                <a href="/donation/{{ $donation->id }}" class="btn-claim" style="flex:1;text-align:center;text-decoration:none;background:rgba(255,255,255,0.08);color:#e2e8f0;border:1px solid rgba(255,255,255,0.1);">View Details</a>
                <a href="/ngo-login?donation_id={{ $donation->id }}" class="btn-claim" style="flex:1;text-align:center;text-decoration:none">Request Food</a>
              </div>
            </div>
          @endif
        @endforeach

        @if($donations->filter(fn($d) => \Carbon\Carbon::parse($d->expiry)->isFuture())->isEmpty())
          <div class="feed-empty" style="grid-column:1/-1;text-align:center;padding:3rem 1rem;opacity:.7">
            <div style="font-size:3rem;margin-bottom:1rem">🍽️</div>
            <h4 style="color:#fff;margin-bottom:.5rem">No active donations right now</h4>
            <p style="color:rgba(255,255,255,.6);margin-bottom:1.5rem">Be the first to post one — it takes under 60 seconds.</p>
            <a href="/donate" class="btn-primary">Post a Donation</a>
          </div>
        @endif

        <div class="feed-card feed-card-post">
          <div class="post-icon">➕</div>
          <h4>Have surplus food?</h4>
          <p>Post a donation in under 60 seconds. We'll handle the rest.</p>
          <a href="/donate" class="btn-primary">Post a Donation</a>
        </div>

      </div>
    </div>
  </section>

  <!-- ───────────────────── SMART MATCHING ───────────────────── -->
  <section class="smart-match" id="matching">
    <div class="container">
      <div class="match-layout">
        <div class="match-text">
          <span class="section-tag">AI-Powered</span>
          <h2 class="section-title">Smart Food Matching<br />&amp; Priority Distribution</h2>
          <p>Our algorithm continuously scores every donation against recipient need, distance, capacity, and dietary requirements — sending the right food to the right people in minutes.</p>
          <ul class="match-list">
            <li>
              <span class="match-dot dot-green"></span>
              <div>
                <strong>Need-Based Prioritization</strong>
                <p>Orphanages, shelters, and disaster zones receive highest priority routing.</p>
              </div>
            </li>
            <li>
              <span class="match-dot dot-amber"></span>
              <div>
                <strong>Proximity Optimization</strong>
                <p>Minimizes transport time and carbon footprint with shortest-path dispatch.</p>
              </div>
            </li>
            <li>
              <span class="match-dot dot-coral"></span>
              <div>
                <strong>Dietary Matching</strong>
                <p>Vegetarian, halal, allergen flags ensure safe delivery to every recipient.</p>
              </div>
            </li>
          </ul>
        </div>

        <div class="match-visual">
          <div class="match-card-wrap">
            <div class="match-node donor">
              <span class="node-icon">🏪</span>
              <span>Hotel Landmark</span>
              <span class="node-tag">Donor</span>
            </div>
            <div class="match-arrows">
              <div class="match-line line-1">
                <span class="match-score">96% match</span>
              </div>
              <div class="match-line line-2">
                <span class="match-score">78% match</span>
              </div>
            </div>
            <div class="match-recipients">
              <div class="match-node recipient priority">
                <span class="node-icon">🏠</span>
                <span>Safe Haven Shelter</span>
                <span class="node-tag priority-tag">Priority</span>
              </div>
              <div class="match-node recipient">
                <span class="node-icon">🕌</span>
                <span>Al-Noor Mosque</span>
                <span class="node-tag">Standard</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ───────────────────── ANALYTICS ───────────────────── -->
  <section class="analytics" id="analytics">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Food Waste Analytics</span>
        <h2 class="section-title">Data That Drives<br />Real Change</h2>
      </div>

      <div class="analytics-grid">

        <div class="chart-card">
          <h4 class="chart-title">Weekly Added Donations</h4>
          <div class="bar-chart">
            @foreach($chartData as $data)
            <div class="bar-group">
              <div class="bar {{ $data['is_today'] ? 'bar--today' : '' }}" style="--h:{{ $data['height'] }}%">
                <span class="bar-val">{{ $data['label'] }}</span>
              </div>
              <span class="bar-day">{{ $data['day'] }}</span>
            </div>
            @endforeach
          </div>
        </div>

        <div class="analytics-side">
          <div class="metric-card">
            <span class="metric-icon">🗑️</span>
            <div>
              <span class="metric-value">{{ $wastedFood ?? 0 }}</span>
              <span class="metric-label">Food donations wasted (Expired & Unrescued)</span>
            </div>
          </div>
          <div class="metric-card">
            <span class="metric-icon">💚</span>
            <div>
              <span class="metric-value">{{ $rescuedFood ?? 0 }}</span>
              <span class="metric-label">Food requests approved</span>
            </div>
          </div>

          <div class="donut-wrap">
            <h4>Food by Category</h4>
            <div class="donut-chart">
              <svg viewBox="0 0 120 120">
                @foreach($categoryStats as $stat)
                  @if($stat['percentage'] > 0)
                    <circle cx="60" cy="60" r="48" fill="none" stroke="{{ $stat['color'] }}" stroke-width="20" stroke-dasharray="{{ $stat['dasharray'] }}" stroke-dashoffset="{{ $stat['offset'] }}" />
                  @endif
                @endforeach
              </svg>
              <div class="donut-legend">
                @foreach($categoryStats as $stat)
                  <span class="legend-item"><em style="background:{{ $stat['color'] }}"></em>{{ $stat['name'] }} {{ $stat['percentage'] }}%</span>
                @endforeach
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ───────────────────── TRUST SCORE ───────────────────── -->
  <section class="trust" id="trust">
    <div class="container">
      <div class="trust-layout">
        <div class="trust-text">
          <span class="section-tag">Trust & Safety</span>
          <h2 class="section-title">Food Safety Verification<br />&amp; Trust Score System</h2>
          <p>Every donor and recipient is verified. Food is logged, timestamped, and temperature-flagged. Our Trust Score gives communities confidence in every rescue.</p>
          <a href="#" class="btn-primary">View Verification Process</a>
        </div>

        <div class="trust-cards">
          <div class="trust-card">
            <div class="trust-score-ring">
              <svg viewBox="0 0 80 80">
                <circle cx="40" cy="40" r="34" fill="none" stroke="#1f1f1f" stroke-width="6"/>
                <circle cx="40" cy="40" r="34" fill="none" stroke="#F5A623" stroke-width="6"
                  stroke-dasharray="178 35" stroke-dashoffset="25" stroke-linecap="round"/>
              </svg>
              <span class="ring-score">94</span>
            </div>
            <div class="trust-info">
              <strong>Hotel Landmark Dhaka</strong>
              <span class="trust-tag verified">✅ Verified Donor</span>
              <ul class="trust-checks">
                <li>✔ Food hygiene certificate</li>
                <li>✔ 47 successful rescues</li>
                <li>✔ Zero safety incidents</li>
              </ul>
            </div>
          </div>

          <div class="trust-card">
            <div class="trust-score-ring">
              <svg viewBox="0 0 80 80">
                <circle cx="40" cy="40" r="34" fill="none" stroke="#1f1f1f" stroke-width="6"/>
                <circle cx="40" cy="40" r="34" fill="none" stroke="#4A7C59" stroke-width="6"
                  stroke-dasharray="160 53" stroke-dashoffset="25" stroke-linecap="round"/>
              </svg>
              <span class="ring-score">87</span>
            </div>
            <div class="trust-info">
              <strong>Green Hope NGO</strong>
              <span class="trust-tag ngo">🏢 Certified NGO</span>
              <ul class="trust-checks">
                <li>✔ Government registered</li>
                <li>✔ 120 distributions completed</li>
                <li>✔ Real-time reporting enabled</li>
              </ul>
            </div>
          </div>

          <div class="trust-badges">
            <span class="badge">🔒 End-to-end Logged</span>
            <span class="badge">🌡️ Temperature Verified</span>
            <span class="badge">📋 Certified Partners</span>
            <span class="badge">🛡️ Zero-tolerance Policy</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ───────────────────── EMERGENCY ALERTS ───────────────────── -->
  <section class="alerts" id="alerts">
    <div class="container">
      <div class="alerts-header">
        <span class="section-tag light">Emergency System</span>
        <h2 class="section-title light">Food Alerts,<br />Activated in Seconds.</h2>
        <p class="section-desc light">When disaster strikes, ResQMeal's emergency food alert network mobilizes donors, NGOs, and volunteers instantly.</p>
      </div>

      <div class="alerts-grid">
        <div class="alert-card alert-active">
          <div class="alert-top">
            <span class="alert-status blink">🔴 ACTIVE</span>
            <span class="alert-zone">Sylhet Flood Zone 2</span>
          </div>
          <h4>Emergency Food Needed — 500+ people</h4>
          <p>Flash flood displaced families require cooked meals and dry rations immediately.</p>
          <div class="alert-progress">
            <span>Response: 68%</span>
            <div class="alert-bar"><div class="alert-fill" style="--fill:68%"></div></div>
          </div>
          <button class="btn-alert">Respond Now</button>
        </div>

        <div class="alert-card alert-resolved">
          <div class="alert-top">
            <span class="alert-status resolved">✅ RESOLVED</span>
            <span class="alert-zone">Khulna Zone 3</span>
          </div>
          <h4>Post-Cyclone Food Distribution</h4>
          <p>1,200 meals distributed in 4 hours. All families in zone reached.</p>
          <div class="alert-progress">
            <span>Response: 100%</span>
            <div class="alert-bar"><div class="alert-fill" style="--fill:100%"></div></div>
          </div>
          <button class="btn-secondary">View Report</button>
        </div>

        <div class="alert-setup">
          <h4>Set Up Your Alert Zone</h4>
          <p>Receive push notifications for food emergencies in your area and respond with a single tap.</p>
          <div class="alert-form">
            <input type="text" placeholder="Enter your city or district…" class="alert-input" />
            <button class="btn-primary">Activate Alerts</button>
          </div>
          <span class="alert-note">Free for all donors, NGOs, and volunteers.</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ───────────────────── HOW IT WORKS ───────────────────── -->
  <section class="how-it-works" id="how">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Simple Process</span>
        <h2 class="section-title">From Surplus to Served<br />in Four Steps</h2>
      </div>

      <div class="steps-row">
        <div class="step">
          <div class="step-num">01</div>
          <div class="step-icon">📸</div>
          <h4>Post Your Surplus</h4>
          <p>Snap a photo, enter quantity and expiry — done in 60 seconds.</p>
        </div>
        <div class="step-arrow">→</div>
        <div class="step">
          <div class="step-num">02</div>
          <div class="step-icon">🤖</div>
          <h4>Smart Matching</h4>
          <p>Our algorithm instantly finds the best-fit recipient in your zone.</p>
        </div>
        <div class="step-arrow">→</div>
        <div class="step">
          <div class="step-num">03</div>
          <div class="step-icon">🚐</div>
          <h4>Schedule Pickup</h4>
          <p>Volunteer or NGO confirms a slot and navigates to your location.</p>
        </div>
        <div class="step-arrow">→</div>
        <div class="step">
          <div class="step-num">04</div>
          <div class="step-icon">❤️</div>
          <h4>Impact Logged</h4>
          <p>Every rescue is added to your verified donation history and analytics.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ───────────────────── CTA ───────────────────── -->
  <section class="cta-section">
    <div class="container">
      <div class="cta-box">
        <div class="cta-glow"></div>
        <span class="section-tag light">Join the Movement</span>
        <h2>Stop Food Waste.<br />Start Saving Lives.</h2>
        <p>Join {{ $activeDonors }} donors and {{ $activeNGOs }} NGO/volunteers already rescuing meals every day.</p>
        <div class="cta-btns">
          <a href="/donate" class="btn-primary large">Donate Food Today</a>
          <a href="/ngo-login" class="btn-outline-light large">Request Food</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ───────────────────── FOOTER ───────────────────── -->
  <footer class="footer">
    <div class="container">
      <div class="footer-top">
        <div class="footer-brand">
          <a href="/" class="nav-logo">
            <span class="logo-icon">🥗</span>
            <span class="logo-text">ResQ<span class="logo-accent">Meal</span></span>
          </a>
          <p>Turning food surplus into community strength — one meal at a time.</p>
          <div class="social-links">
            <a href="#" aria-label="Facebook">f</a>
            <a href="#" aria-label="Twitter">𝕏</a>
            <a href="#" aria-label="Instagram">◎</a>
            <a href="#" aria-label="LinkedIn">in</a>
          </div>
        </div>

        <div class="footer-links">
          <div class="footer-col">
            <h5>Platform</h5>
            <ul>
              <li><a href="#">Donate Food</a></li>
              <li><a href="#">Request Food</a></li>
              <li><a href="#">Live Feed</a></li>
              <li><a href="#">Pickup Scheduling</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h5>Organization</h5>
            <ul>
              <li><a href="#">NGO Partners</a></li>
              <li><a href="#">Volunteer Network</a></li>
              <li><a href="#">Emergency Alerts</a></li>
              <li><a href="#">Trust & Safety</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h5>Resources</h5>
            <ul>
              <li><a href="#">Analytics Dashboard</a></li>
              <li><a href="#">Impact Reports</a></li>
              <li><a href="#">API for NGOs</a></li>
              <li><a href="#">Help Center</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p>© 2025 ResQMeal. Built with purpose. All rights reserved.</p>
        <div class="footer-legal">
          <a href="#">Privacy Policy</a>
          <a href="#">Terms of Service</a>
          <a href="#">Cookie Policy</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    // ── Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
      navbar.classList.toggle('scrolled', window.scrollY > 60);
    });

    // ── Mobile menu toggle
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('open');
      mobileMenu.classList.toggle('open');
    });

    // ── Counter animation
    function animateCounter(el) {
      const target = parseInt(el.dataset.target);
      const duration = 1800;
      const step = target / (duration / 16);
      let current = 0;
      const timer = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = Math.floor(current).toLocaleString();
        if (current >= target) clearInterval(timer);
      }, 16);
    }

    const counters = document.querySelectorAll('.stat-num');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          animateCounter(e.target);
          observer.unobserve(e.target);
        }
      });
    }, { threshold: 0.5 });
    counters.forEach(c => observer.observe(c));

    // ── Live countdown timers (real, driven by expiry timestamps)
    function updateLiveTimers() {
      document.querySelectorAll('.live-timer[data-expiry]').forEach(el => {
        const expiry = new Date(el.dataset.expiry);
        const diff = Math.max(0, Math.floor((expiry - Date.now()) / 1000));
        const h = Math.floor(diff / 3600);
        const m = Math.floor((diff % 3600) / 60);
        const s = diff % 60;
        el.textContent = `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;

        // Update urgency badge colour dynamically
        const card = el.closest('.feed-card');
        if (card) {
          const badge = card.querySelector('.urgency-badge');
          if (badge) {
            if (diff <= 0) {
              card.remove();
            } else if (diff < 3600) {
              badge.textContent = '⚡ Critical';
              badge.className = 'urgency-badge urgent';
            } else if (diff < 10800) {
              badge.textContent = '🕐 Moderate';
              badge.className = 'urgency-badge moderate';
            } else {
              badge.textContent = '✅ Available';
              badge.className = 'urgency-badge safe';
            }
          }
        }
      });

      // Also tick the feature-section countdown items
      document.querySelectorAll('.cd-time').forEach(el => {
        const expiryStr = el.dataset.expiry;
        if (!expiryStr) return;
        const expiry = new Date(expiryStr);
        const diff = Math.floor((expiry - Date.now()) / 1000);
        
        if (diff <= 0) {
          const cdItem = el.closest('.cd-item');
          if (cdItem) cdItem.remove();
          return;
        }

        const h = Math.floor(diff / 3600);
        const m = Math.floor((diff % 3600) / 60);
        const s = diff % 60;
        el.textContent = `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
        
        const cdItem = el.closest('.cd-item');
        if (cdItem) {
            cdItem.className = 'cd-item ' + (diff < 3600 ? 'critical' : (diff < 10800 ? 'warning' : 'safe'));
        }
      });
    }
    setInterval(updateLiveTimers, 1000);
    updateLiveTimers();

    // ── Filter buttons (real category filtering)
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.textContent.trim().toLowerCase();
        document.querySelectorAll('.feed-card:not(.feed-card-post)').forEach(card => {
          if (filter === 'all') {
            card.style.display = '';
          } else {
            const cat = (card.dataset.category || '').toLowerCase();
            card.style.display = (cat === filter || cat.includes(filter)) ? '' : 'none';
          }
        });
      });
    });

    // ── Scroll reveal
    const reveals = document.querySelectorAll('.feat-card, .feed-card, .step, .metric-card, .trust-card, .alert-card');
    const revealObs = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('visible'); revealObs.unobserve(e.target); }
      });
    }, { threshold: 0.15 });
    reveals.forEach(r => revealObs.observe(r));
  </script>
</body>
</html>