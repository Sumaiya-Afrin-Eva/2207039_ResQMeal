<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ResQMeal — My Requests</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="/css/style.css" />
  <link rel="stylesheet" href="/css/auth.css" />
  <link rel="stylesheet" href="/css/donate.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    body { background: #0d1117; color: #c9d1d9; }
    .donor-nav { background: rgba(13,17,23,0.85); border-bottom: 1px solid #30363d; }
    .donor-nav-links .dnav-link { color: #8b949e; }
    .donor-nav-links .dnav-link:hover { color: #c9d1d9; }
    .donor-nav-links .dnav-link.active { color: #58a6ff; }
    .donor-nav-links .dnav-link.active::after { background: #58a6ff !important; display: block; }
    .donor-profile .dp-name { color: #c9d1d9; }
    .donor-profile .dp-role { color: #8b949e; }
    .requests-container { max-width: 1100px; margin: 100px auto 40px; padding: 0 20px; }
    .requests-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .requests-header h1 { font-family: 'Syne'; margin:0; font-size: 2.2rem; color: #f0f6fc; }
    .requests-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
    
    .req-card { background: #161b22; border-radius: 12px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); border: 1px solid #30363d; display: flex; flex-direction: column; }
    .req-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
    .req-food-name { font-weight: 700; font-size: 1.1rem; color: #58a6ff; margin: 0; }
    .req-status { padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; }
    
    .status-pending { background: rgba(210, 153, 34, 0.15); color: #d29922; }
    .status-approved { background: rgba(46, 160, 67, 0.15); color: #3fb950; }
    .status-rejected { background: rgba(248, 81, 73, 0.15); color: #ff7b72; }
    
    .req-details { font-size: 0.9rem; color: #8b949e; margin-bottom: 16px; }
    .req-details p { margin: 6px 0; }
    .req-details strong { color: #c9d1d9; }
    
    .empty-state { text-align: center; padding: 60px; color: #8b949e; grid-column: 1 / -1; background: #161b22; border-radius: 12px; border: 1px dashed #30363d; }
    
    /* Notification Badge */
    #ngoBadge { display: none; background: #f85149; color: #fff; border-radius: 50%; padding: 2px 6px; font-size: 12px; margin-left: 4px; }
    .donor-nav .logo-text { color:#e2e8f0 !important; } /* Make "ResQ" visible on dark background */
  </style>
</head>
<body>
  
  <nav class="donor-nav" id="ngoNav">
    <div class="nav-inner">
      <a href="/" class="nav-logo">
        <span class="logo-icon">🥗</span>
        <span class="logo-text">ResQ<span class="logo-accent">Meal</span></span>
      </a>
      <div class="donor-nav-links">
        <a href="/#live-feed" class="dnav-link">Live Feed</a>
        <a href="/request" class="dnav-link">Request Food</a>
        <a href="/ngo-requests" class="dnav-link active">My Requests <span id="ngoBadge">0</span></a>
      </div>
      <div class="donor-profile" id="ngoProfile">
        <div class="dp-avatar" id="ngoAvatar">N</div>
        <div class="dp-info">
          <span class="dp-name" id="ngoName">NGO User</span>
          <span class="dp-role" id="ngoRoleLabel">Verified NGO</span>
        </div>
        <button class="dp-logout" id="logoutBtn" title="Log out">
          <svg viewBox="0 0 24 24" fill="none" stroke="#8b949e" stroke-width="1.8"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </button>
      </div>
    </div>
  </nav>

  <div class="requests-container">
    <div class="requests-header">
      <h1>My Food Requests</h1>
    </div>
    
    <div class="requests-grid" id="requestsGrid">
      <div class="empty-state">Loading requests...</div>
    </div>
  </div>

  <script>
    const ngoUser = JSON.parse(sessionStorage.getItem('resqmeal_ngo_user') || 'null');
    if (!ngoUser || !ngoUser.email) {
      alert("Please log in as an NGO/Volunteer to view your requests.");
      window.location.href = '/ngo-login';
    } else {
      const fullName = `${ngoUser.name||''} ${ngoUser.last||''}`.trim() || ngoUser.email.split('@')[0];
      document.getElementById('ngoName').textContent = ngoUser.org || fullName;
      document.getElementById('ngoAvatar').textContent = (ngoUser.org || fullName)[0].toUpperCase();
      document.getElementById('ngoRoleLabel').textContent = ngoUser.role === 'ngo' ? 'Verified NGO' : (ngoUser.role === 'shelter' ? 'Verified Shelter' : 'Verified Volunteer');
      
      loadRequests();
    }

    document.getElementById('logoutBtn').addEventListener('click', () => {
      sessionStorage.removeItem('resqmeal_ngo_user');
      window.location.href = '/';
    });

    function loadRequests() {
      fetch(`/api/ngo/requests?email=${encodeURIComponent(ngoUser.email)}`)
        .then(r => r.json())
        .then(data => {
          if(data.success) {
            // Notification logic: Save the count of approved/rejected requests
            const processedRequests = data.requests.filter(r => r.status !== 'pending').length;
            localStorage.setItem('last_seen_ngo_processed', processedRequests.toString());
            
            const badge = document.getElementById('ngoBadge');
            if(badge) badge.style.display = 'none';
            
            renderRequests(data.requests);
          } else {
            document.getElementById('requestsGrid').innerHTML = `<div class="empty-state">Failed to load requests.</div>`;
          }
        })
        .catch(err => {
          console.error(err);
          document.getElementById('requestsGrid').innerHTML = `<div class="empty-state">Error connecting to server.</div>`;
        });
    }

    function renderRequests(requests) {
      const grid = document.getElementById('requestsGrid');
      grid.innerHTML = '';

      if (requests.length === 0) {
        grid.innerHTML = `<div class="empty-state"><h3>No requests made yet!</h3><p>When you request food from the Live Feed, it will appear here.</p></div>`;
        return;
      }

      requests.forEach(req => {
        const donation = req.donation;
        const foodName = donation ? donation.food_name : 'Unknown Food';
        const donorName = (donation && donation.donor) ? `${donation.donor.first_name} ${donation.donor.last_name}` : 'Unknown Donor';
        const donorPhone = (donation && donation.donor) ? donation.donor.phone : 'N/A';
        
        const card = document.createElement('div');
        card.className = 'req-card';

        let statusClass = 'status-pending';
        let statusText = 'PENDING';
        let feedbackHtml = '';
        
        if (req.status === 'approved') {
          statusClass = 'status-approved';
          statusText = 'APPROVED';
          feedbackHtml = `<p><strong>Message:</strong> Your request was approved! Please contact the donor to arrange pickup.</p>`;
        }
        if (req.status === 'rejected') {
          statusClass = 'status-rejected';
          statusText = 'REJECTED';
          feedbackHtml = `<p><strong>Message:</strong> Unfortunately, the donor declined this request.</p>`;
        }

        card.innerHTML = `
          <div class="req-card-header">
            <h3 class="req-food-name">${foodName}</h3>
            <span class="req-status ${statusClass}">${statusText}</span>
          </div>
          <div class="req-details">
            <p><strong>Donor:</strong> ${donorName}</p>
            ${req.status === 'approved' ? `<p><strong>Donor Contact:</strong> ${donorPhone}</p>` : ''}
            <p><strong>Requested:</strong> ${req.requested_quantity} ${req.quantity_unit}</p>
            <p><strong>Pickup Address:</strong> ${donation ? donation.pickup_address : 'N/A'}</p>
            <p><strong>Preferred Pickup:</strong> ${new Date(req.preferred_pickup_from).toLocaleString([], {month:'short', day:'numeric', hour:'2-digit', minute:'2-digit'})}</p>
            ${feedbackHtml}
          </div>
        `;
        grid.appendChild(card);
      });
    }
  </script>
</body>
</html>
