<div class="navbar-top">
  <div class="navbar-container">
    <!-- Left Section: Page Title -->
    <div class="navbar-left">
      <div class="page-title-section">
        <h1 class="page-title">
          <?= htmlspecialchars(ucfirst($_GET['page'] ?? 'dashboard'), ENT_QUOTES, 'UTF-8'); ?>
        </h1>
        <p class="page-breadcrumb">
          <iconify-icon icon="mdi:home" width="16" height="16"></iconify-icon>
          <span> / <?= htmlspecialchars(ucfirst($_GET['page'] ?? 'dashboard'), ENT_QUOTES, 'UTF-8'); ?></span>
        </p>
      </div>
    </div>

    <!-- Center Section: Company Name -->
    <div class="navbar-center">
      <div class="company-badge">
        <iconify-icon icon="mdi:building" width="18" height="18"></iconify-icon>
        <span>Doorstep Technology Co.,Ltd</span>
      </div>
    </div>

    <!-- Right Section: User Info & Actions -->
    <div class="navbar-right">
      <!-- Notifications -->
      <div class="navbar-action">
        <button class="action-btn notification-btn" title="Notifications">
          <iconify-icon icon="mdi:bell" width="22" height="22"></iconify-icon>
          <span class="notification-badge">3</span>
        </button>
      </div>

      <!-- Messages -->
      <div class="navbar-action">
        <button class="action-btn message-btn" title="Messages">
          <iconify-icon icon="mdi:message-text" width="22" height="22"></iconify-icon>
          <span class="message-badge">2</span>
        </button>
      </div>

      <!-- Divider -->
      <div class="navbar-divider"></div>

      <!-- User Profile -->
      <div class="navbar-action user-action">
        <div class="user-display">
          <div class="user-avatar">
            <iconify-icon icon="mdi:account-circle" width="32" height="32"></iconify-icon>
          </div>
          <div class="user-details">
            <p class="user-type-label">
              <?= ($_SESSION['utype'] ?? 0) == 1 ? '👤 Admin' : '👥 ' . htmlspecialchars($_SESSION['uname'] ?? 'User', ENT_QUOTES, 'UTF-8'); ?>
            </p>
            <p class="user-role-label">
              <?= ($_SESSION['utype'] ?? 0) == 1 ? 'Administrator' : 'User'; ?>
            </p>
          </div>
          <iconify-icon icon="mdi:chevron-down" width="20" height="20" class="dropdown-icon"></iconify-icon>
        </div>

        <!-- Dropdown Menu -->
        <div class="user-dropdown">
          <a href="#" class="dropdown-item">
            <iconify-icon icon="mdi:account-settings" width="18" height="18"></iconify-icon>
            <span>Profile Settings</span>
          </a>
          <a href="#" class="dropdown-item">
            <iconify-icon icon="mdi:lock-reset" width="18" height="18"></iconify-icon>
            <span>Change Password</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#logout" class="dropdown-item logout-item">
            <iconify-icon icon="mdi:logout" width="18" height="18"></iconify-icon>
            <span>Logout</span>
          </a>
        </div>
      </div>

      <!-- Logout Button -->
      <div class="navbar-action">
        <button class="logout-btn" onclick="handleLogout()" title="Logout">
          <iconify-icon icon="mdi:power-off" width="22" height="22"></iconify-icon>
        </button>
      </div>
    </div>
  </div>
</div>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

  * {
    font-family: 'Inter', sans-serif;
  }

  .navbar-top {
    background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
    border-bottom: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 0;
    z-index: 999;
    margin-left: 280px;
    transition: margin-left 0.3s ease;
  }

  .navbar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 28px;
    height: 80px;
    gap: 20px;
  }

  /* Left Section */
  .navbar-left {
    flex: 1;
    min-width: 0;
  }

  .page-title-section {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .page-title {
    font-size: 1.75em;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    text-transform: capitalize;
    letter-spacing: -0.3px;
  }

  .page-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85em;
    color: #6b7280;
    margin: 0;
  }

  /* Center Section */
  .navbar-center {
    flex: 0.5;
    display: flex;
    justify-content: center;
  }

  .company-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9em;
    white-space: nowrap;
  }

  .company-badge iconify-icon {
    flex-shrink: 0;
  }

  /* Right Section */
  .navbar-right {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 16px;
  }

  .navbar-action {
    position: relative;
    display: flex;
    align-items: center;
  }

  .action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: transparent;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #6b7280;
    position: relative;
  }

  .action-btn:hover {
    background: #f3f4f6;
    color: #1f2937;
    border-color: #d1d5db;
  }

  /* Notification & Message Badges */
  .notification-badge,
  .message-badge {
    position: absolute;
    top: -6px;
    right: -6px;
    width: 20px;
    height: 20px;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65em;
    font-weight: 700;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
  }

  .message-badge {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
  }

  /* Navbar Divider */
  .navbar-divider {
    width: 1px;
    height: 28px;
    background: #e5e7eb;
  }

  /* User Profile Section */
  .user-action {
    position: relative;
  }

  .user-display {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 12px;
    background: #f9fafb;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid transparent;
  }

  .user-display:hover {
    background: #f3f4f6;
    border-color: #e5e7eb;
  }

  .user-avatar {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-radius: 8px;
    color: white;
    flex-shrink: 0;
  }

  .user-details {
    min-width: 0;
  }

  .user-type-label {
    font-size: 0.9em;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .user-role-label {
    font-size: 0.8em;
    color: #6b7280;
    margin: 2px 0 0 0;
  }

  .dropdown-icon {
    color: #9ca3af;
    transition: transform 0.3s ease;
    flex-shrink: 0;
  }

  .user-display:hover .dropdown-icon {
    transform: rotate(180deg);
  }

  /* Dropdown Menu */
  .user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 8px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    min-width: 220px;
    display: none;
    z-index: 1000;
    overflow: hidden;
    animation: slideDown 0.2s ease-out;
  }

  .user-action:hover .user-dropdown,
  .user-dropdown.active {
    display: block;
  }

  .dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: #374151;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9em;
  }

  .dropdown-item:hover {
    background: #f9fafb;
    color: #1f2937;
    padding-left: 20px;
  }

  .dropdown-item iconify-icon {
    flex-shrink: 0;
    color: #6b7280;
  }

  .dropdown-item:hover iconify-icon {
    color: #3b82f6;
  }

  .logout-item {
    color: #ef4444;
  }

  .logout-item:hover {
    background: #fef2f2;
    color: #dc2626;
  }

  .logout-item iconify-icon {
    color: #ef4444;
  }

  .logout-item:hover iconify-icon {
    color: #dc2626;
  }

  .dropdown-divider {
    height: 1px;
    background: #e5e7eb;
    margin: 6px 0;
  }

  /* Logout Button */
  .logout-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #dc2626;
  }

  .logout-btn:hover {
    background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    transform: scale(1.05);
  }

  /* Animations */
  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-8px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Responsive Design */
  @media (max-width: 1024px) {
    .navbar-container {
      padding: 0 20px;
      height: 70px;
    }

    .navbar-center {
      display: none;
    }

    .page-title {
      font-size: 1.5em;
    }

    .user-details {
      display: none;
    }
  }

  @media (max-width: 768px) {
    .navbar-top {
      margin-left: 200px;
    }

    .navbar-container {
      padding: 0 16px;
      height: 60px;
      gap: 12px;
    }

    .page-breadcrumb {
      display: none;
    }

    .page-title {
      font-size: 1.2em;
    }

    .navbar-right {
      gap: 8px;
    }

    .navbar-divider {
      display: none;
    }

    .action-btn {
      width: 36px;
      height: 36px;
    }

    .logout-btn {
      width: 36px;
      height: 36px;
    }
  }

  @media (max-width: 640px) {
    .navbar-top {
      margin-left: 0;
    }

    .navbar-left {
      min-width: 150px;
    }

    .page-title {
      font-size: 1em;
    }

    .user-display {
      padding: 6px 8px;
    }

    .user-avatar {
      width: 32px;
      height: 32px;
    }

    .user-type-label {
      font-size: 0.85em;
    }
  }
</style>

<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

<script>
  function handleLogout() {
    if (confirm('Are you sure you want to logout?')) {
      window.location.href = '?logout=true';
    }
  }

  // Toggle dropdown menu
  document.querySelector('.user-action').addEventListener('click', function (e) {
    e.stopPropagation();
    this.querySelector('.user-dropdown').classList.toggle('active');
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', function () {
    const dropdown = document.querySelector('.user-dropdown');
    if (dropdown) {
      dropdown.classList.remove('active');
    }
  });
</script>