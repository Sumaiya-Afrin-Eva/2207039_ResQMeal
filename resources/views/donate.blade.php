<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ResQMeal — Post a Food Donation</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/auth.css" />
  <link rel="stylesheet" href="css/donate.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
</head>
<body class="donate-body">

  <!-- ── Auth Guard overlay (shown briefly while checking) ── -->
  <div class="auth-guard" id="authGuard">
    <div class="guard-spinner">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
    </div>
  </div>

  <!-- ── Donor Nav ── -->
  <nav class="donor-nav" id="donorNav">
    <div class="nav-inner">
      <a href="/" class="nav-logo">
        <span class="logo-icon">🥗</span>
        <span class="logo-text">ResQ<span class="logo-accent">Meal</span></span>
      </a>

      <div class="donor-nav-links">
        <a href="/donate" class="dnav-link active">Post Donation</a>
        <a href="/my-history" class="dnav-link">My History</a>
        <a href="/donor-requests" class="dnav-link">Requests <span id="reqBadge" style="display:none; background:var(--coral); color:#fff; border-radius:50%; padding:2px 6px; font-size:12px; margin-left:4px;">0</span></a>
      </div>

      <div class="donor-profile" id="donorProfile">
        <div class="dp-avatar" id="dpAvatar">A</div>
        <div class="dp-info">
          <span class="dp-name" id="dpName">Donor</span>
          <span class="dp-role">Verified Donor</span>
        </div>
        <button class="dp-logout" id="logoutBtn" title="Log out">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </button>
      </div>
    </div>
  </nav>

  <!-- ── Page body ── -->
  <div class="donate-page">

    <!-- ── Sidebar / stepper ── -->
    <aside class="donate-sidebar">
      <div class="stepper">
        <div class="stepper-step active" data-step="1">
          <div class="step-circle">1</div>
          <div class="step-label">
            <strong>Food Details</strong>
            <span>What you're donating</span>
          </div>
        </div>
        <div class="stepper-line"></div>
        <div class="stepper-step" data-step="2">
          <div class="step-circle">2</div>
          <div class="step-label">
            <strong>Pickup Info</strong>
            <span>When &amp; where</span>
          </div>
        </div>
        <div class="stepper-line"></div>
        <div class="stepper-step" data-step="3">
          <div class="step-circle">3</div>
          <div class="step-label">
            <strong>Safety Check</strong>
            <span>Conditions &amp; notes</span>
          </div>
        </div>
        <div class="stepper-line"></div>
        <div class="stepper-step" data-step="4">
          <div class="step-circle">4</div>
          <div class="step-label">
            <strong>Review &amp; Post</strong>
            <span>Confirm listing</span>
          </div>
        </div>
      </div>

      <!-- Donor trust snapshot -->
      <div class="sidebar-trust">
        <div class="trust-ring-small">
          <svg viewBox="0 0 60 60">
            <circle cx="30" cy="30" r="24" fill="none" stroke="rgba(255,255,255,.08)" stroke-width="5"/>
            <circle id="trustCircle" cx="30" cy="30" r="24" fill="none" stroke="#F5A623" stroke-width="5"
              stroke-dasharray="150.8 0" stroke-dashoffset="0" stroke-linecap="round"/>
          </svg>
          <span id="trustScoreVal">--</span>
        </div>
        <div>
          <strong id="sidebarName">Your Trust Score</strong>
          <span id="trustScoreMeta">Loading stats...</span>
        </div>
      </div>

      <div class="sidebar-tip">
        <span class="tip-icon">💡</span>
        <p>Listings with a photo and accurate expiry time are claimed <strong>3× faster.</strong></p>
      </div>
    </aside>

    <!-- ── Main form area ── -->
    <main class="donate-main">

      <!-- Step progress bar (mobile) -->
      <div class="mobile-steps">
        <div class="mobile-step-bar">
          <div class="mobile-step-fill" id="mobileStepFill" style="width:25%"></div>
        </div>
        <span class="mobile-step-label" id="mobileStepLabel">Step 1 of 4 — Food Details</span>
      </div>

      <form id="donateForm" novalidate>
        @csrf

        <!-- ════════════ STEP 1: FOOD DETAILS ════════════ -->
        <div class="form-step active" id="step-1">
          <div class="step-header">
            <h2>What are you donating?</h2>
            <p>Provide as much detail as possible — it helps our system match your donation faster.</p>
          </div>

          <!-- Food photo upload -->
          <div class="field-group">
            <label>Food photo <span class="label-optional">(strongly recommended)</span></label>
            <div class="photo-upload-area" id="photoUploadArea">
              <input type="file" id="photoInput" accept="image/*" hidden />
              <div class="photo-placeholder" id="photoPlaceholder">
                <div class="photo-icon">📷</div>
                <strong>Click to upload a photo</strong>
                <span>PNG, JPG, WEBP · Max 5 MB</span>
              </div>
              <img src="" alt="Preview" class="photo-preview" id="photoPreview" hidden />
              <button type="button" class="photo-remove" id="photoRemove" hidden>✕ Remove</button>
            </div>
          </div>

          <!-- Food name -->
          <div class="field-group">
            <label for="food-name">Food name / description <span class="req">*</span></label>
            <div class="input-wrap">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
              <input type="text" id="food-name" placeholder="e.g. Mixed Biryani, Fresh Vegetables, Canned Lentils…" required />
            </div>
            <span class="field-error" id="food-name-err"></span>
          </div>

          <!-- Food category -->
          <div class="field-group">
            <label>Food category <span class="req">*</span></label>
            <div class="category-grid">
              <label class="cat-option">
                <input type="radio" name="food-cat" value="cooked" />
                <div class="cat-card"><span>🍛</span><strong>Cooked Food</strong><em>Prepared meals, rice, curry…</em></div>
              </label>
              <label class="cat-option">
                <input type="radio" name="food-cat" value="raw" />
                <div class="cat-card"><span>🥦</span><strong>Raw Ingredients</strong><em>Vegetables, meat, dairy…</em></div>
              </label>
              <label class="cat-option">
                <input type="radio" name="food-cat" value="packaged" />
                <div class="cat-card"><span>📦</span><strong>Packaged / Sealed</strong><em>Canned, bottled, boxed…</em></div>
              </label>
              <label class="cat-option">
                <input type="radio" name="food-cat" value="bakery" />
                <div class="cat-card"><span>🍞</span><strong>Bakery Items</strong><em>Bread, pastries, snacks…</em></div>
              </label>
              <label class="cat-option">
                <input type="radio" name="food-cat" value="beverages" />
                <div class="cat-card"><span>🧃</span><strong>Beverages</strong><em>Juice, water, milk…</em></div>
              </label>
              <label class="cat-option">
                <input type="radio" name="food-cat" value="other" />
                <div class="cat-card"><span>🥗</span><strong>Other</strong><em>Doesn't fit above</em></div>
              </label>
            </div>
            <span class="field-error" id="food-cat-err"></span>
          </div>

          <!-- Quantity row -->
          <div class="field-row-2">
            <div class="field-group">
              <label for="food-qty">Quantity <span class="req">*</span></label>
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                <input type="number" id="food-qty" placeholder="e.g. 30" min="1" required />
              </div>
              <span class="field-error" id="food-qty-err"></span>
            </div>
            <div class="field-group">
              <label for="food-unit">Unit <span class="req">*</span></label>
              <div class="input-wrap select-wrap">
                <select id="food-unit" required>
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
              <span class="field-error" id="food-unit-err"></span>
            </div>
          </div>

          <!-- Serves estimate -->
          <div class="field-group">
            <label for="food-serves">Estimated number of people it can serve <span class="req">*</span></label>
            <div class="input-wrap">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
              <input type="number" id="food-serves" placeholder="e.g. 30" min="1" required />
            </div>
            <span class="field-error" id="food-serves-err"></span>
          </div>

          <!-- Dietary flags -->
          <div class="field-group">
            <label>Dietary information <span class="label-optional">(check all that apply)</span></label>
            <div class="dietary-flags">
              <label class="flag-option">
                <input type="checkbox" value="halal" /> <span>🕌 Halal</span>
              </label>
              <label class="flag-option">
                <input type="checkbox" value="vegetarian" /> <span>🥗 Vegetarian</span>
              </label>
              <label class="flag-option">
                <input type="checkbox" value="vegan" /> <span>🌱 Vegan</span>
              </label>
              <label class="flag-option">
                <input type="checkbox" value="gluten-free" /> <span>🌾 Gluten-Free</span>
              </label>
              <label class="flag-option">
                <input type="checkbox" value="nut-free" /> <span>🥜 Nut-Free</span>
              </label>
              <label class="flag-option">
                <input type="checkbox" value="dairy-free" /> <span>🥛 Dairy-Free</span>
              </label>
            </div>
          </div>

          <div class="step-actions">
            <div></div>
            <button type="button" class="btn-next" data-next="2">Continue to Pickup Info →</button>
          </div>
        </div>

        <!-- ════════════ STEP 2: PICKUP INFO ════════════ -->
        <div class="form-step" id="step-2">
          <div class="step-header">
            <h2>Pickup details</h2>
            <p>Tell us when and where volunteers or NGOs can collect the food.</p>
          </div>

          <!-- Expiry datetime -->
          <div class="field-group">
            <label for="food-expiry">Food expires / best before <span class="req">*</span></label>
            <div class="input-wrap">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <input type="datetime-local" id="food-expiry" required />
            </div>
            <div class="expiry-preview" id="expiryPreview" hidden>
              <span class="expiry-countdown" id="expiryCountdown">Calculating…</span>
              <span class="expiry-tag" id="expiryTag"></span>
            </div>
            <span class="field-error" id="food-expiry-err"></span>
          </div>

          <!-- Pickup window -->
          <div class="field-group">
            <label>Available pickup window <span class="req">*</span></label>
            <div class="field-row-2">
              <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/></svg>
                <input type="datetime-local" id="pickup-from" required placeholder="From" />
              </div>
              <div class="input-wrap">
                <input type="datetime-local" id="pickup-to" required placeholder="To" />
              </div>
            </div>
            <span class="field-error" id="pickup-err"></span>
          </div>

          <!-- Pickup address -->
          <div class="field-group">
            <label for="pickup-address">Pickup address <span class="req">*</span></label>
            <div class="input-wrap">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <input type="text" id="pickup-address" placeholder="House 12, Road 4, Khulna Sadar…" required />
            </div>
            <span class="field-error" id="pickup-address-err"></span>
          </div>

          <!-- Landmark -->
          <div class="field-group">
            <label for="pickup-landmark">Nearby landmark <span class="label-optional">(optional)</span></label>
            <div class="input-wrap">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
              <input type="text" id="pickup-landmark" placeholder="e.g. Near City Hospital gate" />
            </div>
          </div>

          <!-- Location on map (visual placeholder with detect button) -->
          <div class="field-group">
            <label>Pin your location <span class="label-optional">(for volunteer navigation)</span></label>
            <div class="map-pin-area" id="mapPinArea">
              <div class="map-grid-overlay"></div>
              <div class="map-center-pin" id="mapCenterPin">📍</div>
              <div class="map-label-overlay">Click "Detect Location" to pin your exact coordinates</div>
            </div>
            <button type="button" class="btn-detect" id="detectLocationBtn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="16" height="16"><circle cx="12" cy="12" r="3"/><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4"/></svg>
              Detect My Location
            </button>
            <span class="location-status" id="locationStatus"></span>
          </div>

          <!-- Pickup contact -->
          <div class="field-group">
            <label for="pickup-contact">Contact number for pickup coordination <span class="req">*</span></label>
            <div class="input-wrap">
              <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.91a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              <input type="tel" id="pickup-contact" placeholder="+880 1700-000000" required />
            </div>
            <span class="field-error" id="pickup-contact-err"></span>
          </div>

          <div class="step-actions">
            <button type="button" class="btn-back" data-prev="1">← Back</button>
            <button type="button" class="btn-next" data-next="3">Continue to Safety Check →</button>
          </div>
        </div>

        <!-- ════════════ STEP 3: SAFETY CHECK ════════════ -->
        <div class="form-step" id="step-3">
          <div class="step-header">
            <h2>Food safety &amp; conditions</h2>
            <p>Honest safety information protects everyone. These declarations become part of your Trust Score.</p>
          </div>

          <!-- Storage conditions -->
          <div class="field-group">
            <label>Current food storage condition <span class="req">*</span></label>
            <div class="radio-card-group">
              <label class="radio-card">
                <input type="radio" name="storage" value="refrigerated" />
                <div class="rc-inner">
                  <span class="rc-icon">🧊</span>
                  <strong>Refrigerated</strong>
                  <span>Stored at 0–5°C</span>
                </div>
              </label>
              <label class="radio-card">
                <input type="radio" name="storage" value="room-temp" />
                <div class="rc-inner">
                  <span class="rc-icon">🌡️</span>
                  <strong>Room Temperature</strong>
                  <span>Dry, covered storage</span>
                </div>
              </label>
              <label class="radio-card">
                <input type="radio" name="storage" value="hot" />
                <div class="rc-inner">
                  <span class="rc-icon">♨️</span>
                  <strong>Kept Hot</strong>
                  <span>Active warming / chafing</span>
                </div>
              </label>
              <label class="radio-card">
                <input type="radio" name="storage" value="frozen" />
                <div class="rc-inner">
                  <span class="rc-icon">❄️</span>
                  <strong>Frozen</strong>
                  <span>Below −18°C</span>
                </div>
              </label>
            </div>
            <span class="field-error" id="storage-err"></span>
          </div>

          <!-- Packaging -->
          <div class="field-group">
            <label>Packaging status <span class="req">*</span></label>
            <div class="radio-card-group">
              <label class="radio-card">
                <input type="radio" name="packaging" value="sealed" />
                <div class="rc-inner"><span class="rc-icon">✅</span><strong>Factory Sealed</strong><span>Original packaging</span></div>
              </label>
              <label class="radio-card">
                <input type="radio" name="packaging" value="covered" />
                <div class="rc-inner"><span class="rc-icon">🥡</span><strong>Covered / Wrapped</strong><span>Cling wrap, lids…</span></div>
              </label>
              <label class="radio-card">
                <input type="radio" name="packaging" value="open" />
                <div class="rc-inner"><span class="rc-icon">⚠️</span><strong>Open / Exposed</strong><span>No covering</span></div>
              </label>
            </div>
            <span class="field-error" id="packaging-err"></span>
          </div>

          <!-- Safety declarations -->
          <div class="field-group">
            <label>Safety declarations <span class="req">*</span></label>
            <div class="declarations">
              <label class="declaration-item">
                <input type="checkbox" class="decl-check" required />
                <span class="checkmark"></span>
                <div>
                  <strong>The food has not been tampered with</strong>
                  <span>It is in its original prepared or packaged state.</span>
                </div>
              </label>
              <label class="declaration-item">
                <input type="checkbox" class="decl-check" required />
                <span class="checkmark"></span>
                <div>
                  <strong>The expiry/best-before date I entered is accurate</strong>
                  <span>I'm not over-estimating shelf life.</span>
                </div>
              </label>
              <label class="declaration-item">
                <input type="checkbox" class="decl-check" required />
                <span class="checkmark"></span>
                <div>
                  <strong>I prepared/stored this food under clean conditions</strong>
                  <span>Hygienic handling, surfaces, and utensils were used.</span>
                </div>
              </label>
              <label class="declaration-item">
                <input type="checkbox" class="decl-check" />
                <span class="checkmark"></span>
                <div>
                  <strong>I can provide more detail to the recipient if needed</strong>
                  <span>(Optional) I consent to being contacted with food-related questions.</span>
                </div>
              </label>
            </div>
            <span class="field-error" id="decl-err"></span>
          </div>

          <!-- Known allergens -->
          <div class="field-group">
            <label>Known allergens present <span class="label-optional">(check all that apply)</span></label>
            <div class="dietary-flags">
              <label class="flag-option"><input type="checkbox" value="nuts" /> <span>🥜 Nuts</span></label>
              <label class="flag-option"><input type="checkbox" value="gluten" /> <span>🌾 Gluten</span></label>
              <label class="flag-option"><input type="checkbox" value="dairy" /> <span>🥛 Dairy</span></label>
              <label class="flag-option"><input type="checkbox" value="eggs" /> <span>🥚 Eggs</span></label>
              <label class="flag-option"><input type="checkbox" value="shellfish" /> <span>🦐 Shellfish</span></label>
              <label class="flag-option"><input type="checkbox" value="soy" /> <span>🫘 Soy</span></label>
            </div>
          </div>

          <!-- Additional notes -->
          <div class="field-group">
            <label for="safety-notes">Additional notes for recipient <span class="label-optional">(optional)</span></label>
            <div class="textarea-wrap">
              <textarea id="safety-notes" rows="4" placeholder="e.g. 'Contains fish — prepared in restaurant kitchen. Best reheated before serving.'"></textarea>
            </div>
            <span class="char-count" id="notesCount">0 / 300</span>
          </div>

          <div class="step-actions">
            <button type="button" class="btn-back" data-prev="2">← Back</button>
            <button type="button" class="btn-next" data-next="4">Review My Listing →</button>
          </div>
        </div>

        <!-- ════════════ STEP 4: REVIEW & POST ════════════ -->
        <div class="form-step" id="step-4">
          <div class="step-header">
            <h2>Review &amp; publish</h2>
            <p>This is exactly how your donation will appear on the live feed. Check it and post.</p>
          </div>

          <!-- Preview card -->
          <div class="preview-card" id="previewCard">
            <div class="preview-image-area" id="previewImageArea">
              <div class="preview-img-placeholder" id="previewImgPlaceholder">🍱</div>
              <img src="" alt="Food preview" class="preview-img" id="previewImg" hidden />
              <div class="preview-img-badges">
                <span class="pv-cat-badge" id="pvCatBadge">—</span>
                <span class="pv-urgency" id="pvUrgency">—</span>
              </div>
            </div>
            <div class="preview-body">
              <h3 id="pvFoodName">—</h3>
              <p class="pv-donor-meta" id="pvDonorMeta">📍 —</p>

              <div class="pv-grid">
                <div class="pv-item">
                  <span class="pv-icon">🍽️</span>
                  <div><strong id="pvQuantity">—</strong><span>Quantity</span></div>
                </div>
                <div class="pv-item">
                  <span class="pv-icon">👥</span>
                  <div><strong id="pvServes">—</strong><span>People served</span></div>
                </div>
                <div class="pv-item">
                  <span class="pv-icon">🕐</span>
                  <div><strong id="pvExpiry">—</strong><span>Best before</span></div>
                </div>
                <div class="pv-item">
                  <span class="pv-icon">🧊</span>
                  <div><strong id="pvStorage">—</strong><span>Storage</span></div>
                </div>
              </div>

              <div class="pv-address-row">
                <span>📍</span>
                <span id="pvAddress">—</span>
              </div>

              <div class="pv-dietary" id="pvDietary"></div>

              <div class="pv-notes-block" id="pvNotesBlock" hidden>
                <strong>Donor notes:</strong>
                <p id="pvNotes"></p>
              </div>

              <!-- Urgency bar preview -->
              <div class="pv-urgency-bar">
                <div class="pv-ub-fill" id="pvUBFill"></div>
              </div>
              <p class="pv-ub-label" id="pvUBLabel"></p>
            </div>
          </div>

          <!-- Visibility setting -->
          <div class="field-group">
            <label>Who can claim this donation? <span class="req">*</span></label>
            <div class="radio-card-group visibility-group">
              <label class="radio-card">
                <input type="radio" name="visibility" value="all" checked />
                <div class="rc-inner"><span class="rc-icon">🌍</span><strong>Everyone</strong><span>NGOs, volunteers, individuals</span></div>
              </label>
              <label class="radio-card">
                <input type="radio" name="visibility" value="ngo-only" />
                <div class="rc-inner"><span class="rc-icon">🏢</span><strong>NGOs only</strong><span>Verified NGO partners</span></div>
              </label>
              <label class="radio-card">
                <input type="radio" name="visibility" value="volunteer-only" />
                <div class="rc-inner"><span class="rc-icon">🙋</span><strong>Volunteers only</strong><span>Registered volunteers</span></div>
              </label>
            </div>
          </div>

          <!-- Emergency flag -->
          <div class="field-group">
            <label class="checkbox-label emergency-flag">
              <input type="checkbox" id="emergencyFlag" />
              <span class="checkmark checkmark-coral"></span>
              <div>
                <strong>🚨 Flag as emergency / urgent donation</strong>
                <span>Use only if food needs pickup within the next 2 hours. Triggers immediate NGO alert.</span>
              </div>
            </label>
          </div>

          <!-- Final declaration -->
          <div class="final-declaration">
            <label class="checkbox-label">
              <input type="checkbox" id="finalDecl" required />
              <span class="checkmark"></span>
              I confirm all the information above is accurate and I take responsibility for this food donation as per ResQMeal's <a href="#" class="inline-link">Donor Agreement</a>.
            </label>
            <span class="field-error" id="final-decl-err"></span>
          </div>

          <!-- ── Smart Matched Recipients (View Mode Only) ── -->
          <div id="matchedNgosPanel" style="display:none; margin-bottom: 28px; border-top: 1px solid #eaeaea; padding-top: 24px;">
            <p style="font-size:0.8rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#4a7c59;margin-bottom:14px;">🎯 Smart Matched Recipients</p>
            <div id="matchedNgosList" style="display:flex;flex-direction:column;gap:10px;"></div>
          </div>

          <div class="step-actions post-actions">
            <button type="button" class="btn-back" data-prev="3">← Back</button>
            <button type="submit" class="btn-post" id="postBtn">
              <span class="btn-text">🚀 Post Donation Now</span>
              <span class="btn-spinner" hidden>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
              </span>
            </button>
          </div>
        </div>

      </form>

      <!-- ════════════ SUCCESS STATE ════════════ -->
      <div class="post-success" id="postSuccess" hidden>
        <div class="success-animation">
          <div class="success-circle">
            <svg viewBox="0 0 60 60" fill="none" stroke="#0B3D2E" stroke-width="3">
              <circle cx="30" cy="30" r="28" stroke="#4A7C59" stroke-width="3" fill="rgba(74,124,89,.08)"/>
              <polyline points="18,31 26,39 42,22" stroke="#0B3D2E" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </div>
        <h2>Donation <span id="successTitleAction">Posted</span>! 🎉</h2>
        <p>Your food listing is now <strong>live on the feed</strong>. Our system is matching it to nearby NGOs and volunteers right now.</p>

        <div class="success-stats-row">
          <div class="ss-stat"><span>⚡</span><strong>~18 min</strong><em>Expected pickup time</em></div>
          <div class="ss-stat"><span>🤖</span><strong>Smart Match</strong><em>AI finding best recipient</em></div>
          <div class="ss-stat"><span>📱</span><strong>Alert Sent</strong><em>NGOs notified</em></div>
        </div>

        <div class="success-actions">
          <a href="donate" class="btn-primary">Post Another Donation</a>
          <a href="/" class="btn-outline-dark">Back to Home</a>
        </div>

        <!-- Reference ID -->
        <div class="ref-id">
          Listing ID: <strong id="listingId">RQM-2025-</strong> · <span id="postedAt"></span>
        </div>
      </div>

    </main>
  </div>

  <script>
    const urlParams = new URLSearchParams(window.location.search);
    const editId = urlParams.get('edit');
    const viewId = urlParams.get('view');
    const activeId = editId || viewId;

    if (activeId) {
      document.querySelector('#postBtn .btn-text').textContent = "🚀 Update Donation";
      document.getElementById('successTitleAction').textContent = "Updated";

      fetch(`/api/donations/${activeId}`)
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            const d = data.donation;
            document.getElementById('food-name').value = d.food_name || '';
            
            if (d.category) {
              const cat = document.querySelector(`input[name="food-cat"][value="${d.category.toLowerCase()}"]`);
              if (cat) cat.checked = true;
            }
            
            document.getElementById('food-qty').value = d.quantity || '';
            
            if (d.unit) {
               document.getElementById('food-unit').value = d.unit.toLowerCase();
            }
            
            document.getElementById('food-serves').value = d.serves || '';

            // Date formatting for datetime-local
            if (d.expiry) {
              const ex = new Date(d.expiry);
              ex.setMinutes(ex.getMinutes() - ex.getTimezoneOffset());
              document.getElementById('food-expiry').value = ex.toISOString().slice(0, 16);
            }
            if (d.pickup_from) {
              const pf = new Date(d.pickup_from);
              pf.setMinutes(pf.getMinutes() - pf.getTimezoneOffset());
              document.getElementById('pickup-from').value = pf.toISOString().slice(0, 16);
            }
            if (d.pickup_to) {
              const pt = new Date(d.pickup_to);
              pt.setMinutes(pt.getMinutes() - pt.getTimezoneOffset());
              document.getElementById('pickup-to').value = pt.toISOString().slice(0, 16);
            }

            document.getElementById('pickup-address').value = d.pickup_address || '';
            document.getElementById('pickup-contact').value = d.pickup_contact || '';

            if (d.storage) {
              const storage = document.querySelector(`input[name="storage"][value="${d.storage.toLowerCase()}"]`);
              if (storage) storage.checked = true;
            }
            if (d.packaging) {
              const packaging = document.querySelector(`input[name="packaging"][value="${d.packaging.toLowerCase()}"]`);
              if (packaging) packaging.checked = true;
            }
            
            document.getElementById('safety-notes').value = d.notes || '';
            
            if (d.visibility) {
              const visibility = document.querySelector(`input[name="visibility"][value="${d.visibility.toLowerCase()}"]`);
              if (visibility) visibility.checked = true;
            }
            
            if (d.emergency) {
              document.getElementById('emergencyFlag').checked = true;
            }

            if (d.allergens) {
              const allergens = d.allergens.toLowerCase().split(',').map(s => s.trim());
              allergens.forEach(a => {
                const cb = document.querySelector(`#step-3 .dietary-flags input[value="${a}"]`);
                if (cb) cb.checked = true;
              });
            }
            if (d.dietary) {
              const dietary = d.dietary.toLowerCase().split(',').map(s => s.trim());
              dietary.forEach(di => {
                const cb = document.querySelector(`#step-1 .dietary-flags input[value="${di}"]`);
                if (cb) cb.checked = true;
              });
            }
            
            // Automatically jump to Step 4 (Review & Publish) ONLY for view mode
            if (viewId) {
              setTimeout(() => {
                goToStep(4);
              }, 100);

              // Fetch and render Smart Matched Recipients
              fetch(`/api/donations/${viewId}/matched-ngos`)
                .then(r => r.json())
                .then(res => {
                  if (res.success && res.matched.length > 0) {
                    const panel = document.getElementById('matchedNgosPanel');
                    const list  = document.getElementById('matchedNgosList');
                    panel.style.display = 'block';
                    list.innerHTML = res.matched.map(ngo => {
                      const barColor = ngo.match_score >= 70 ? '#4a7c59' : (ngo.match_score >= 40 ? '#f59e0b' : '#adb5bd');
                      const tagBg    = ngo.is_priority ? 'rgba(74,124,89,0.12)' : 'rgba(99,102,241,0.1)';
                      const tagColor = ngo.is_priority ? '#4a7c59' : '#6366f1';
                      const tagText  = ngo.is_priority ? 'Priority' : 'Standard';
                      const icon     = ngo.is_priority ? '🏠' : '🏢';
                      return `
                        <div style="background:#f8f9fa;border:1px solid #eaeaea;border-radius:10px;padding:14px 16px;display:flex;align-items:center;gap:14px;">
                          <div style="font-size:1.4rem;width:36px;text-align:center;">${icon}</div>
                          <div style="flex:1;min-width:0;">
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:5px;">
                              <strong style="font-size:0.9rem;color:#1a1a1a;">${ngo.name}</strong>
                              <span style="font-size:0.7rem;font-weight:700;padding:2px 8px;border-radius:20px;background:${tagBg};color:${tagColor};text-transform:uppercase;">${tagText}</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                              <div style="flex:1;height:5px;background:#e9ecef;border-radius:3px;overflow:hidden;">
                                <div style="height:100%;width:${ngo.match_score}%;background:${barColor};border-radius:3px;"></div>
                              </div>
                              <span style="font-size:0.75rem;color:#6c757d;white-space:nowrap;">${ngo.match_score}% match</span>
                            </div>
                            <span style="font-size:0.75rem;color:#999;text-transform:capitalize;">${ngo.type} • ${ngo.city}</span>
                          </div>
                        </div>`;
                    }).join('');
                  }
                }).catch(() => {});
            }
          }
        })
        .catch(err => console.error("Error fetching donation:", err));
    }
  </script>

  @if(session()->has('donor'))
  <script>
    if (!sessionStorage.getItem('resqmeal_user')) {
      const serverDonor = {!! json_encode(session('donor')) !!};
      const formattedDonor = {
          id: serverDonor.id,
          email: serverDonor.email,
          name: serverDonor.first_name,
          last: serverDonor.last_name,
          phone: serverDonor.phone,
          city: serverDonor.city,
          donorType: serverDonor.donor_type,
          org: serverDonor.organisation,
      };
      sessionStorage.setItem('resqmeal_user', JSON.stringify(formattedDonor));
    }
  </script>
  @endif

  <script>
    /* ─── AUTH GUARD ────────────────────────────────── */
    const user = JSON.parse(sessionStorage.getItem('resqmeal_user') || 'null');
    const guard = document.getElementById('authGuard');

    if (!user) {
      window.location.href = 'login?redirect=donate';
    } else {
      guard.style.display = 'none';
      // Populate donor info
      document.getElementById('dpName').textContent = user.name || user.email.split('@')[0];
      document.getElementById('dpAvatar').textContent = (user.name || user.email)[0].toUpperCase();
      document.getElementById('sidebarName').textContent = (user.name || 'Your') + "'s Trust Score";

      // Fetch dynamic trust score
      if (user.id) {
        fetch(`/api/donor/trust-score?donor_id=${user.id}`)
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              const score = data.trust_score;
              document.getElementById('trustScoreVal').textContent = score;
              document.getElementById('trustScoreMeta').textContent = `Based on ${data.total_donations} past ${data.total_donations === 1 ? 'donation' : 'donations'}`;

              // Update SVG circle ring matching score
              const circle = document.getElementById('trustCircle');
              if (circle) {
                const circumference = 2 * Math.PI * 24; // ~150.8
                const strokeLength = (score / 100) * circumference;
                const gapLength = circumference - strokeLength;
                circle.setAttribute('stroke-dasharray', `${strokeLength} ${gapLength}`);
                circle.setAttribute('stroke-dashoffset', '0');
              }
            }
          })
          .catch(err => console.error("Error fetching trust score:", err));
      }
    }

    /* ─── LOGOUT ────────────────────────────────────── */
    document.getElementById('logoutBtn').addEventListener('click', () => {
      sessionStorage.removeItem('resqmeal_user');
      window.location.href = '/donor-logout';
    });

    /* ─── REQUEST BADGE NOTIFICATION ────────────────── */
    if (user && user.id) {
      fetch(`/api/donor/requests?donor_id=${user.id}`)
        .then(r => r.json())
        .then(data => {
          if(data.success) {
            const total = data.requests.length;
            const pending = data.requests.filter(r => r.status === 'pending').length;
            const lastSeenTotal = parseInt(localStorage.getItem('last_seen_req_total') || '0');
            
            if(pending > 0 && total > lastSeenTotal) {
              const badge = document.getElementById('reqBadge');
              if(badge) {
                badge.textContent = pending;
                badge.style.display = 'inline-block';
              }
            }
          }
        }).catch(err => console.error(err));
    }

    /* ─── STEP NAVIGATION ───────────────────────────── */
    let currentStep = 1;
    const totalSteps = 4;
    const stepLabels = ['Food Details', 'Pickup Info', 'Safety Check', 'Review & Post'];

    function goToStep(n) {
      document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active', 'exiting'));
      document.querySelectorAll('.stepper-step').forEach(s => {
        s.classList.remove('active', 'done');
        const sn = parseInt(s.dataset.step);
        if (sn < n) s.classList.add('done');
        if (sn === n) s.classList.add('active');
      });
      document.getElementById('step-' + n).classList.add('active');
      document.getElementById('mobileStepFill').style.width = (n / totalSteps * 100) + '%';
      document.getElementById('mobileStepLabel').textContent = `Step ${n} of ${totalSteps} — ${stepLabels[n-1]}`;
      currentStep = n;
      window.scrollTo({ top: 0, behavior: 'smooth' });
      if (n === 4) buildPreview();
    }

    // Event listeners are bound inside bindStepNavigation()
    function bindStepNavigation() {
      document.querySelectorAll('.btn-next[data-next]').forEach(btn => {
        btn.addEventListener('click', event => {
          event.preventDefault();
          const next = Number(btn.dataset.next);
          if (!Number.isInteger(next) || next < 1 || next > totalSteps) return;
          if (validateStep(currentStep)) goToStep(next);
        });
      });

      document.querySelectorAll('.btn-back[data-prev]').forEach(btn => {
        btn.addEventListener('click', event => {
          event.preventDefault();
          const prev = Number(btn.dataset.prev);
          if (Number.isInteger(prev)) goToStep(prev);
        });
      });
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', bindStepNavigation);
    } else {
      bindStepNavigation();
    }

    /* ─── VALIDATION ────────────────────────────────── */
    function setErr(id, msg) {
      const el = document.getElementById(id);
      if (!el) return;
      el.textContent = msg;
      el.classList.toggle('visible', !!msg);
    }
    function clearAllErr() {
      document.querySelectorAll('.field-error').forEach(e => { e.textContent = ''; e.classList.remove('visible'); });
      document.querySelectorAll('.input-wrap').forEach(w => w.classList.remove('error'));
    }
    function markErr(inputId, errId, msg) {
      setErr(errId, msg);
      const el = document.getElementById(inputId);
      if (el) el.closest('.input-wrap')?.classList.add('error');
    }

    function validateStep(n) {
      clearAllErr();
      let ok = true;
      if (n === 1) {
        if (!document.getElementById('food-name').value.trim())
          { markErr('food-name','food-name-err','Food name is required.'); ok=false; }
        if (!document.querySelector('input[name="food-cat"]:checked'))
          { setErr('food-cat-err','Please select a food category.'); ok=false; }
        if (!document.getElementById('food-qty').value || parseInt(document.getElementById('food-qty').value) < 1)
          { markErr('food-qty','food-qty-err','Enter a valid quantity.'); ok=false; }
        if (!document.getElementById('food-unit').value)
          { setErr('food-unit-err','Please select a unit.'); ok=false; }
        if (!document.getElementById('food-serves').value || parseInt(document.getElementById('food-serves').value) < 1)
          { markErr('food-serves','food-serves-err','Enter estimated number of people served.'); ok=false; }
      }
      if (n === 2) {
        if (!document.getElementById('food-expiry').value)
          { markErr('food-expiry','food-expiry-err','Expiry date is required.'); ok=false; }
        if (!document.getElementById('pickup-from').value || !document.getElementById('pickup-to').value)
          { setErr('pickup-err','Please set a pickup window.'); ok=false; }
        if (!document.getElementById('pickup-address').value.trim())
          { markErr('pickup-address','pickup-address-err','Pickup address is required.'); ok=false; }
        if (!document.getElementById('pickup-contact').value.trim())
          { markErr('pickup-contact','pickup-contact-err','Contact number is required.'); ok=false; }
      }
      if (n === 3) {
        if (!document.querySelector('input[name="storage"]:checked'))
          { setErr('storage-err','Please select a storage condition.'); ok=false; }
        if (!document.querySelector('input[name="packaging"]:checked'))
          { setErr('packaging-err','Please select a packaging status.'); ok=false; }
        const requiredDecls = document.querySelectorAll('.decl-check[required]');
        let allChecked = true;
        requiredDecls.forEach(d => { if (!d.checked) allChecked = false; });
        if (!allChecked) { setErr('decl-err','Please confirm all required safety declarations.'); ok=false; }
      }
      return ok;
    }

    /* ─── PHOTO UPLOAD ──────────────────────────────── */
    const photoArea    = document.getElementById('photoUploadArea');
    const photoInput   = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const photoPlaceh  = document.getElementById('photoPlaceholder');
    const photoRemove  = document.getElementById('photoRemove');

    photoArea.addEventListener('click', e => {
      if (e.target === photoRemove) return;
      photoInput.click();
    });
    photoInput.addEventListener('change', () => {
      const file = photoInput.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = e => {
        photoPreview.src = e.target.result;
        photoPreview.hidden = false;
        photoPlaceh.hidden = true;
        photoRemove.hidden = false;
      };
      reader.readAsDataURL(file);
    });
    photoRemove.addEventListener('click', e => {
      e.stopPropagation();
      photoPreview.src = ''; photoPreview.hidden = true;
      photoPlaceh.hidden = false; photoRemove.hidden = false;
      photoInput.value = '';
      photoRemove.hidden = true;
    });

    /* ─── DRAG & DROP PHOTO ─────────────────────────── */
    photoArea.addEventListener('dragover', e => { e.preventDefault(); photoArea.classList.add('drag-over'); });
    photoArea.addEventListener('dragleave', ()  => photoArea.classList.remove('drag-over'));
    photoArea.addEventListener('drop', e => {
      e.preventDefault(); photoArea.classList.remove('drag-over');
      const file = e.dataTransfer.files[0];
      if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer(); dt.items.add(file);
        photoInput.files = dt.files;
        photoInput.dispatchEvent(new Event('change'));
      }
    });

    /* ─── EXPIRY COUNTDOWN PREVIEW ──────────────────── */
    const expiryInput = document.getElementById('food-expiry');
    const expiryPrev  = document.getElementById('expiryPreview');
    const expiryCount = document.getElementById('expiryCountdown');
    const expiryTag   = document.getElementById('expiryTag');

    expiryInput && expiryInput.addEventListener('change', updateExpiryPreview);
    function updateExpiryPreview() {
      const val = expiryInput.value;
      if (!val) { expiryPrev.hidden = true; return; }
      const diff = new Date(val) - new Date();
      if (diff <= 0) { expiryCount.textContent = 'Expiry time is in the past!'; expiryTag.textContent = ''; expiryPrev.hidden = false; return; }
      const h = Math.floor(diff / 3600000);
      const m = Math.floor((diff % 3600000) / 60000);
      expiryCount.textContent = `⏱ Expires in ${h > 0 ? h + 'h ' : ''}${m}m from now`;
      if (diff < 3600000)       { expiryTag.textContent = '⚡ Critical'; expiryTag.className = 'expiry-tag tag-critical'; }
      else if (diff < 10800000) { expiryTag.textContent = '🕐 Moderate'; expiryTag.className = 'expiry-tag tag-moderate'; }
      else                      { expiryTag.textContent = '✅ Available'; expiryTag.className = 'expiry-tag tag-safe'; }
      expiryPrev.hidden = false;
    }

    /* ─── CHAR COUNT ────────────────────────────────── */
    const notesTA = document.getElementById('safety-notes');
    const notesCt = document.getElementById('notesCount');
    notesTA && notesTA.addEventListener('input', () => {
      const len = notesTA.value.length;
      if (len > 300) notesTA.value = notesTA.value.slice(0, 300);
      notesCt.textContent = Math.min(len,300) + ' / 300';
    });

    /* ─── DETECT LOCATION ───────────────────────────── */
    document.getElementById('detectLocationBtn').addEventListener('click', () => {
      const status = document.getElementById('locationStatus');
      const pin    = document.getElementById('mapCenterPin');
      status.textContent = 'Detecting your location…';
      status.style.color = 'var(--amber)';
      if (!navigator.geolocation) { status.textContent = 'Geolocation not supported.'; return; }
      navigator.geolocation.getCurrentPosition(pos => {
        status.textContent = `✅ Location pinned: ${pos.coords.latitude.toFixed(5)}, ${pos.coords.longitude.toFixed(5)}`;
        status.style.color = 'var(--green-mid)';
        pin.style.transform = 'scale(1.4)';
        setTimeout(() => pin.style.transform = 'scale(1)', 500);
      }, () => {
        status.textContent = 'Unable to detect location. Please enter address manually.';
        status.style.color = 'var(--coral)';
      });
    });

    /* ─── BUILD PREVIEW (Step 4) ────────────────────── */
    function buildPreview() {
      // Food name
      document.getElementById('pvFoodName').textContent =
        document.getElementById('food-name').value || '—';

      // Category badge
      const cat = document.querySelector('input[name="food-cat"]:checked')?.value || '';
      const catMap = { cooked:'🍛 Cooked', raw:'🥦 Raw', packaged:'📦 Packaged', bakery:'🍞 Bakery', beverages:'🧃 Beverages', other:'🥗 Other' };
      document.getElementById('pvCatBadge').textContent = catMap[cat] || '—';

      // Quantity
      const qty  = document.getElementById('food-qty').value;
      const unit = document.getElementById('food-unit').options[document.getElementById('food-unit').selectedIndex]?.text || '';
      document.getElementById('pvQuantity').textContent = qty ? `${qty} ${unit}` : '—';

      // Serves
      const serves = document.getElementById('food-serves').value;
      document.getElementById('pvServes').textContent = serves ? `~${serves} people` : '—';

      // Expiry
      const expiry = document.getElementById('food-expiry').value;
      if (expiry) {
        const d = new Date(expiry);
        document.getElementById('pvExpiry').textContent = d.toLocaleString('en-GB', { day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit' });
        const diff = d - new Date();
        const h = Math.floor(diff/3600000), m = Math.floor((diff%3600000)/60000);
        document.getElementById('pvUBLabel').textContent = `Expires in ${h > 0 ? h + 'h ' : ''}${m}m`;
        const urgencyEl = document.getElementById('pvUrgency');
        const fillEl    = document.getElementById('pvUBFill');
        if (diff < 3600000)       { urgencyEl.textContent='⚡ Critical'; urgencyEl.className='pv-urgency urgency-critical'; fillEl.style.cssText='width:90%;background:var(--coral)'; }
        else if (diff < 10800000) { urgencyEl.textContent='🕐 Moderate'; urgencyEl.className='pv-urgency urgency-moderate'; fillEl.style.cssText='width:55%;background:var(--amber)'; }
        else                      { urgencyEl.textContent='✅ Available'; urgencyEl.className='pv-urgency urgency-safe';    fillEl.style.cssText='width:25%;background:var(--green-mid)'; }
      }

      // Storage
      const storageMap = { refrigerated:'Refrigerated 🧊', 'room-temp':'Room Temp 🌡️', hot:'Kept Hot ♨️', frozen:'Frozen ❄️' };
      document.getElementById('pvStorage').textContent = storageMap[document.querySelector('input[name="storage"]:checked')?.value] || '—';

      // Address
      const addr = document.getElementById('pickup-address').value;
      const land = document.getElementById('pickup-landmark').value;
      document.getElementById('pvAddress').textContent = addr + (land ? ` (${land})` : '');

      // Donor meta
      document.getElementById('pvDonorMeta').textContent =
        `📍 ${document.getElementById('pickup-address').value || 'Location not set'}`;

      // Dietary
      const dietChecked = [...document.querySelectorAll('.dietary-flags input[type="checkbox"]:checked')].map(i => i.value);
      const pvDietary = document.getElementById('pvDietary');
      pvDietary.innerHTML = '';
      dietChecked.forEach(d => {
        const s = document.createElement('span');
        s.className = 'pv-diet-tag';
        const iconMap = { halal:'🕌', vegetarian:'🥗', vegan:'🌱', 'gluten-free':'🌾', 'nut-free':'🥜', 'dairy-free':'🥛' };
        s.textContent = (iconMap[d] || '') + ' ' + d.charAt(0).toUpperCase() + d.slice(1);
        pvDietary.appendChild(s);
      });

      // Notes
      const notes = document.getElementById('safety-notes').value.trim();
      const notesBlock = document.getElementById('pvNotesBlock');
      if (notes) { document.getElementById('pvNotes').textContent = notes; notesBlock.hidden = false; }
      else        { notesBlock.hidden = true; }

      // Photo
      if (photoPreview.src && !photoPreview.hidden) {
        document.getElementById('previewImg').src = photoPreview.src;
        document.getElementById('previewImg').hidden = false;
        document.getElementById('previewImgPlaceholder').hidden = true;
      }
    }

    /* ─── FORM SUBMIT ───────────────────────────────── */
    document.getElementById('donateForm').addEventListener('submit', function(e) {
      e.preventDefault();
      if (!document.getElementById('finalDecl').checked) {
        setErr('final-decl-err', 'You must confirm the donor agreement before posting.'); return;
      }
      setErr('final-decl-err', '');
      const btn = document.getElementById('postBtn');
      btn.querySelector('.btn-text').hidden   = true;
      btn.querySelector('.btn-spinner').hidden = false;
      btn.disabled = true;

      // Use FormData to support file uploads
      const formData = new FormData();
      formData.append('_token', document.querySelector('input[name="_token"]').value);
      formData.append('food_name', document.getElementById('food-name').value);
      formData.append('category', document.querySelector('input[name="food-cat"]:checked')?.value || '');
      formData.append('quantity', document.getElementById('food-qty').value);
      formData.append('unit', document.getElementById('food-unit').value);
      formData.append('serves', document.getElementById('food-serves').value);
      formData.append('expiry', document.getElementById('food-expiry').value);
      formData.append('pickup_from', document.getElementById('pickup-from').value);
      formData.append('pickup_to', document.getElementById('pickup-to').value);
      formData.append('pickup_address', document.getElementById('pickup-address').value);
      formData.append('pickup_contact', document.getElementById('pickup-contact').value);
      formData.append('storage', document.querySelector('input[name="storage"]:checked')?.value || '');
      formData.append('packaging', document.querySelector('input[name="packaging"]:checked')?.value || '');
      formData.append('notes', document.getElementById('safety-notes').value);
      formData.append('visibility', document.querySelector('input[name="visibility"]:checked')?.value || 'all');
      formData.append('emergency', document.getElementById('emergencyFlag').checked ? 1 : 0);
      
      const allergens = [...document.querySelectorAll('#step-3 .dietary-flags input[type="checkbox"]:checked')].map(i => i.value);
      allergens.forEach(val => formData.append('allergens[]', val));
      
      const dietary = [...document.querySelectorAll('#step-1 .dietary-flags input[type="checkbox"]:checked')].map(i => i.value);
      dietary.forEach(val => formData.append('dietary[]', val));
      
      formData.append('donor_name', user ? (user.name || user.email.split('@')[0]) : 'Donor');
      if (user && user.id) formData.append('donor_id', user.id);
      if (user) formData.append('donor_email', user.email);

      // Append Photo if present
      const photoInput = document.getElementById('photoInput');
      if (photoInput.files && photoInput.files[0]) {
          formData.append('photo', photoInput.files[0]);
      }

      const endpoint = editId ? `/api/donations/${editId}` : '/donate';
      // For multipart/form-data, PHP needs POST method. We can spoof PUT with _method for updates
      if (editId) {
          formData.append('_method', 'PUT');
      }

      fetch(endpoint, {
        method: 'POST',
        headers: {
          'Accept': 'application/json'
          // Do NOT set Content-Type manually when sending FormData, the browser sets the correct boundary automatically
        },
        body: formData
      })
      .then(res => {
        if (!res.ok) {
          throw new Error(`Server returned status ${res.status}`);
        }
        return res.json();
      })
      .then(data => {
        btn.querySelector('.btn-text').hidden   = false;
        btn.querySelector('.btn-spinner').hidden = true;
        btn.disabled = false;

        if (data.success) {
          document.getElementById('donateForm').hidden = true;
          document.querySelector('.donate-sidebar').style.display = 'none';
          document.querySelector('.mobile-steps').style.display   = 'none';
          document.querySelector('.donate-page').classList.add('success-active');
          const successEl = document.getElementById('postSuccess');
          successEl.hidden = false;
          document.getElementById('listingId').textContent = 'RQM-' + new Date().getFullYear() + '-' + data.donation.id;
          document.getElementById('postedAt').textContent = new Date(data.donation.created_at).toLocaleString('en-GB', { day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit' });
        } else {
          setErr('final-decl-err', data.message || 'An error occurred while posting your donation.');
        }
      })
      .catch(err => {
        btn.querySelector('.btn-text').hidden   = false;
        btn.querySelector('.btn-spinner').hidden = true;
        btn.disabled = false;        
        let msg = 'Failed to connect to server. Please try again.';
        if (err.message && err.message.includes('Server returned status')) {
          msg = `Server Error: ${err.message}. Please check your server console or logs.`;
        }
        setErr('final-decl-err', msg);
      });
    });
  </script>
</body>
</html>