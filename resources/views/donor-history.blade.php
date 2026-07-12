<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ResQMeal — My History</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="/css/style.css" />
  <link rel="stylesheet" href="/css/auth.css" />
  <link rel="stylesheet" href="/css/donate.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    .history-container { max-width: 1000px; margin: 100px auto 40px; padding: 0 20px; }
    .history-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .history-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .history-table th, .history-table td { padding: 16px; text-align: left; border-bottom: 1px solid #eaeaea; }
    .history-table th { background: #f9f9f9; font-weight: 600; color: var(--gray-dark); }
    .history-table tr:last-child td { border-bottom: none; }
    .status-active { color: var(--green-mid); font-weight: 600; background: rgba(74, 124, 89, 0.1); padding: 4px 8px; border-radius: 6px; }
    .status-expired { color: var(--coral); font-weight: 600; background: rgba(220, 53, 69, 0.1); padding: 4px 8px; border-radius: 6px; }
    .btn-edit { background: var(--green-mid); color: #fff; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 14px; border: none; cursor: pointer; }
    .btn-delete { background: var(--coral); color: #fff; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 14px; border: none; cursor: pointer; margin-left: 8px; }
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
        <a href="/my-history" class="dnav-link active">My History</a>
        <a href="/donor-requests" class="dnav-link">Requests <span id="reqBadge" style="display:none; background:var(--coral); color:#fff; border-radius:50%; padding:2px 6px; font-size:12px; margin-left:4px;">0</span></a>
        <a href="#" class="dnav-link">Live Feed</a>
        <a href="#" class="dnav-link">Analytics</a>
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

  <div class="history-container">
    <div class="history-header">
      <h1 style="font-family: 'Syne'; margin:0; font-size: 2.2rem;">My Donation History</h1>
    </div>
    
    <div style="overflow-x:auto;">
      <table class="history-table">
        <thead>
          <tr>
            <th>Food Item</th>
            <th>Quantity</th>
            <th>Posted On</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="historyBody">
          <tr><td colspan="5" style="text-align:center; padding: 40px;">Loading history...</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    const user = JSON.parse(sessionStorage.getItem('resqmeal_user') || 'null');
    if (!user || !user.id) {
      alert("Please log out and log back in to access history securely.");
      window.location.href = '/login?redirect=my-history';
    } else {
      document.getElementById('dpName').textContent = user.name || user.email.split('@')[0];
      document.getElementById('dpAvatar').textContent = (user.name || user.email)[0].toUpperCase();
      loadHistory();
    }

    document.getElementById('logoutBtn').addEventListener('click', () => {
      sessionStorage.removeItem('resqmeal_user');
      window.location.href = '/';
    });

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

    let currentDonations = [];

    function loadHistory() {
      fetch(`/api/donations/history?donor_id=${user.id}`)
        .then(r => r.json())
        .then(data => {
          if(data.success) {
            currentDonations = data.donations;
            renderTable();
          }
        })
        .catch(err => console.error("Error loading history:", err));
    }

    function renderTable() {
      const tbody = document.getElementById('historyBody');
      tbody.innerHTML = '';
      if(currentDonations.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 40px; color:#666;">You haven\'t posted any donations yet.</td></tr>';
        return;
      }
      
      currentDonations.forEach(d => {
        const isExpired = new Date(d.expiry) < new Date();
        const status = isExpired ? '<span class="status-expired">Expired</span>' : '<span class="status-active">Active</span>';
        const date = new Date(d.created_at).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' });
        
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td><strong>${d.food_name}</strong><br><small style="color:#666;">${d.category}</small></td>
          <td>${d.quantity} ${d.unit} <small style="color:#666;">(~${d.serves} serves)</small></td>
          <td>${date}</td>
          <td>${status}</td>
          <td>
            <a href="/donate?view=${d.id}" class="btn-edit" style="background:#4a7c59;">View</a>
            <a href="/donate?edit=${d.id}" class="btn-edit">Edit</a>
            <button class="btn-delete" onclick="deleteDonation(${d.id})">Delete</button>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    function deleteDonation(id) {
      if(!confirm("Are you sure you want to permanently delete this donation post?")) return;
      
      fetch(`/api/donations/${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        }
      })
      .then(r => r.json())
      .then(res => {
        if(res.success) {
          loadHistory();
        } else {
          alert("Failed to delete.");
        }
      });
    }
  </script>
</body>
</html>
