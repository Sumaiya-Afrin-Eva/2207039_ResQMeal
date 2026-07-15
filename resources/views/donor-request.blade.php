<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ResQMeal — Food Requests</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="/css/style.css" />
  <link rel="stylesheet" href="/css/auth.css" />
  <link rel="stylesheet" href="/css/donate.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    .requests-container { max-width: 1100px; margin: 100px auto 40px; padding: 0 20px; }
    .requests-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .requests-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
    .req-card { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #eaeaea; display: flex; flex-direction: column; }
    .req-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
    .req-food-name { font-weight: 700; font-size: 1.1rem; color: var(--green-dark); margin: 0; }
    .req-status { padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; }
    .status-pending { background: rgba(245, 166, 35, 0.15); color: #B27300; }
    .status-approved { background: rgba(74, 124, 89, 0.15); color: var(--green-mid); }
    .status-rejected { background: rgba(220, 53, 69, 0.15); color: var(--coral); }
    .req-details { font-size: 0.9rem; color: var(--gray-dark); margin-bottom: 16px; }
    .req-details p { margin: 4px 0; }
    .req-details strong { color: var(--green-dark); }
    .req-actions { display: flex; gap: 10px; margin-top: auto; }
    .btn-approve { flex: 1; background: var(--green-mid); color: #fff; border: none; padding: 8px; border-radius: 6px; cursor: pointer; font-weight: 600; transition: 0.2s; }
    .btn-approve:hover { background: var(--green-deep); }
    .btn-reject { flex: 1; background: #fff; color: var(--coral); border: 1px solid var(--coral); padding: 8px; border-radius: 6px; cursor: pointer; font-weight: 600; transition: 0.2s; }
    .btn-reject:hover { background: rgba(220, 53, 69, 0.05); }
    .empty-state { text-align: center; padding: 60px; color: var(--gray-dark); grid-column: 1 / -1; background: #fff; border-radius: 12px; border: 1px dashed #ccc; }
  </style>
</head>
<body class="donate-body">
  
  <nav class="donor-nav" id="donorNav">
    <div class="nav-inner">
      <a href="/" class="nav-logo">
        <span class="logo-icon">🥗</span>
        <span class="logo-text">ResQ<span class="logo-accent">Meal</span></span>
      </a>
      <div class="donor-nav-links">
        <a href="/donate" class="dnav-link">Post Donation</a>
        <a href="/my-history" class="dnav-link">My History</a>
        <a href="/donor-requests" class="dnav-link active">Requests <span id="reqBadge" style="display:none; background:var(--coral); color:#fff; border-radius:50%; padding:2px 6px; font-size:12px; margin-left:4px;">0</span></a>
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

  <div class="requests-container">
    <div class="requests-header">
      <h1 style="font-family: 'Syne'; margin:0; font-size: 2.2rem;">Incoming Food Requests</h1>
    </div>
    
    <div class="requests-grid" id="requestsGrid">
      <div class="empty-state">Loading requests...</div>
    </div>
  </div>

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
    const user = JSON.parse(sessionStorage.getItem('resqmeal_user') || 'null');
    if (!user || !user.id) {
      alert("Please log out and log back in to access requests securely.");
      window.location.href = '/login?redirect=donor-requests';
    } else {
      document.getElementById('dpName').textContent = user.name || user.email.split('@')[0];
      document.getElementById('dpAvatar').textContent = (user.name || user.email)[0].toUpperCase();
      loadRequests();
    }

    document.getElementById('logoutBtn').addEventListener('click', () => {
      sessionStorage.removeItem('resqmeal_user');
      window.location.href = '/donor-logout';
    });

    function loadRequests() {
      fetch(`/api/donor/requests?donor_id=${user.id}`)
        .then(r => r.json())
        .then(data => {
          if(data.success) {
            currentRequests = data.requests;
            
            // Notification Logic: Save the total count and hide the badge
            const total = data.requests.length;
            localStorage.setItem('last_seen_req_total', total.toString());
            
            const badge = document.getElementById('reqBadge');
            if(badge) badge.style.display = 'none';
            
            renderRequests(currentRequests);
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
        grid.innerHTML = `<div class="empty-state"><h3>No requests yet!</h3><p>When NGOs or volunteers request your food, they will appear here.</p></div>`;
        return;
      }

      let pendingCount = 0;

      requests.forEach(req => {
        if (req.status === 'pending') pendingCount++;

        const donation = req.donation;
        const foodName = donation ? donation.food_name : 'Unknown Food';
        const card = document.createElement('div');
        card.className = 'req-card';

        let statusClass = 'status-pending';
        if (req.status === 'approved') statusClass = 'status-approved';
        if (req.status === 'rejected') statusClass = 'status-rejected';

        let actionsHtml = '';
        if (req.status === 'pending') {
          actionsHtml = `
            <div class="req-actions">
              <button class="btn-approve" onclick="updateStatus(${req.id}, 'approve', this)">Approve</button>
              <button class="btn-reject" onclick="updateStatus(${req.id}, 'reject', this)">Reject</button>
            </div>
          `;
        }

        card.innerHTML = `
          <div class="req-card-header">
            <h3 class="req-food-name">${foodName}</h3>
            <span class="req-status ${statusClass}">${req.status}</span>
          </div>
          <div class="req-details">
            <p><strong>Requester:</strong> ${req.requester_name} (${req.receiver_type.toUpperCase()})</p>
            ${req.organisation ? `<p><strong>Org:</strong> ${req.organisation}</p>` : ''}
            <p><strong>Contact:</strong> ${req.requester_phone}</p>
            <p><strong>Quantity Requested:</strong> ${req.requested_quantity} ${req.quantity_unit}</p>
            <p><strong>Purpose:</strong> ${req.purpose}</p>
            <p><strong>Pickup:</strong> ${new Date(req.preferred_pickup_from).toLocaleString([], {month:'short', day:'numeric', hour:'2-digit', minute:'2-digit'})}</p>
          </div>
          ${actionsHtml}
        `;
        grid.appendChild(card);
      });

    }

    window.updateStatus = function(reqId, action, btnElement) {
      if(!confirm(`Are you sure you want to ${action} this request?`)) return;

      // Disable buttons to prevent double-clicks
      const actionDiv = btnElement.closest('.req-actions');
      if (actionDiv) {
          actionDiv.querySelectorAll('button').forEach(b => {
              b.disabled = true;
              b.style.opacity = '0.6';
              b.style.cursor = 'not-allowed';
          });
      }

      fetch(`/api/requests/${reqId}/${action}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
      .then(r => r.json())
      .then(data => {
        if(data.success) {
          loadRequests(); // refresh grid
        } else {
          alert(data.message || 'Action failed.');
          if (actionDiv) {
              actionDiv.querySelectorAll('button').forEach(b => {
                  b.disabled = false;
                  b.style.opacity = '1';
                  b.style.cursor = 'pointer';
              });
          }
        }
      })
      .catch(err => {
        console.error(err);
        alert('Server error.');
      });
    }
  </script>
</body>
</html>
