<div
  class="navigation max-h-[calc(100vh-56px)] bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white h-screen flex flex-col shadow-2xl border-r border-slate-700/50">

  <!-- Menu Section -->
  <div class="menu flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-transparent">
    <ul class="p-3 space-y-1.5">
      <?php
      $current_page = isset($_GET['page']) ? ucfirst(strtolower($_GET['page'])) : 'Dashboard';

      $menu_items = [
        ['page' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'mdi:view-dashboard', 'mid' => 1],
        ['page' => 'attendance', 'label' => 'Attendance', 'icon' => 'mdi:clock-check-outline', 'mid' => 2],
        ['page' => 'employee', 'label' => 'Employees', 'icon' => 'mdi:account-group', 'mid' => 3],
        ['page' => 'leave', 'label' => 'Leave Requests', 'icon' => 'mdi:calendar-month', 'mid' => 4],
        ['page' => 'report', 'label' => 'Reports', 'icon' => 'mdi:chart-box', 'mid' => 5],
        ['page' => 'user', 'label' => 'User Management', 'icon' => 'mdi:shield-account', 'mid' => 6],
        ['page' => 'audits', 'label' => 'Audits', 'icon' => 'mdi:cellphone-link', 'mid' => 7]
      ];


      if ($_SESSION['utype'] === 'admin') {
        foreach ($menu_items as $index => $item) {
          $is_active = (strtolower($current_page) === strtolower($item['page']));
          $active_class = $is_active
            ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/50'
            : 'hover:bg-slate-700/50 text-slate-300 hover:text-white';

          echo '
            <li data-opt="' . $index . '" class="rounded-xl ' . $active_class . ' transition-all duration-300 transform hover:scale-[1.02]">
              <a href="?page=' . strtolower($item['page']) . '" data-page="' . strtolower($item['page']) . '" class="nav-link flex items-center px-4 py-3 gap-3 group">
                <span class="iconify text-xl ' . ($is_active ? 'text-white' : 'text-slate-400 group-hover:text-white') . ' transition-colors" data-icon="' . $item['icon'] . '"></span>
                <span class="text-sm font-semibold tracking-wide">' . $item['label'] . '</span>
                ' . ($is_active ? '<span class="ml-auto w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>' : '') . '
              </a>
            </li>';
        }
      } else {
        // Regular users (permission-based)
        foreach ($menu_items as $index => $item) {
          if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $permission = $row['aid'];

            if ($permission > 0) {
              $is_active = (strtolower($current_page) === strtolower($item['page']));
              $active_class = $is_active
                ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/50'
                : 'hover:bg-slate-700/50 text-slate-300 hover:text-white';

              echo '
                <li data-opt="' . $index . '" class="rounded-xl ' . $active_class . ' transition-all duration-300 transform hover:scale-[1.02]">
                  <a href="?page=' . strtolower($item['page']) . '" data-page="' . strtolower($item['page']) . '" class="nav-link flex items-center px-4 py-3 gap-3 group">
                    <span class="iconify text-xl ' . ($is_active ? 'text-white' : 'text-slate-400 group-hover:text-white') . ' transition-colors" data-icon="' . $item['icon'] . '"></span>
                    <span class="text-sm font-semibold tracking-wide">' . $item['label'] . '</span>
                    ' . ($is_active ? '<span class="ml-auto w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>' : '') . '
                  </a>
                </li>';
            }
          }
        }
      }
      ?>
    </ul>
  </div>

  <!-- Footer Section -->
  <div class="p-4 border-t border-slate-700/50 backdrop-blur-sm bg-slate-800/50">
    <div class="flex items-center gap-3 text-slate-400 text-xs">
      <span class="iconify text-lg" data-icon="mdi:copyright"></span>
      <div class="flex flex-col">
        <span class="font-semibold text-slate-300"><?= date('Y') ?> Doorstep Technology</span>
        <span class="text-[10px] text-slate-500">All rights reserved</span>
      </div>
    </div>
  </div>
</div>

<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {

    const contentArea = document.getElementById('content-area');
    if (!contentArea) return console.error('Content area not found!');

    // Store mounted pages
    const pageCache = {}; // { pageName: htmlContent }
    let currentPage = null;

    // Event delegation for nav links
    document.addEventListener('click', function (e) {
      const link = e.target.closest('.nav-link');
      if (!link) return;

      e.preventDefault();
      const page = link.dataset.page;
      if (!page) return;

      if (page === currentPage) return; // Already mounted, do nothing

      currentPage = page;
      updateActiveState(link);
      showPage(page);

      const newUrl = window.location.pathname + '?page=' + page;
      window.history.pushState({ page }, '', newUrl);
      updatePageTitle(page);
    });

    // Handle back/forward buttons
    window.addEventListener('popstate', function (e) {
      const urlParams = new URLSearchParams(window.location.search);
      const page = urlParams.get('page') || 'dashboard';

      if (page === currentPage) return; // Already mounted

      currentPage = page;
      const activeLink = document.querySelector(`.nav-link[data-page="${page}"]`);
      if (activeLink) updateActiveState(activeLink);

      showPage(page);
      updatePageTitle(page);
    });

    // Initial load
    const urlParams = new URLSearchParams(window.location.search);
    const initialPage = urlParams.get('page') || 'dashboard';
    currentPage = initialPage;
    const initialLink = document.querySelector(`.nav-link[data-page="${initialPage}"]`);
    if (initialLink) updateActiveState(initialLink);
    showPage(initialPage);

    // --- Functions ---
    function showPage(page) {
      if (pageCache[page]) {
        // Page already loaded, use cache
        contentArea.innerHTML = pageCache[page];
        if (window.initializePageScripts) window.initializePageScripts();
        return;
      }

      // Show loading spinner
      contentArea.innerHTML = `
      <div class="flex items-center justify-center h-64">
        <div class="text-center">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-500 mx-auto mb-4"></div>
          <p class="text-slate-600">Loading ${page}...</p>
        </div>
      </div>
    `;

      fetch('pages/' + page + '.php')
        .then(res => {
          if (!res.ok) throw new Error('Page not found');
          return res.text();
        })
        .then(html => {
          pageCache[page] = html; // Save to cache
          contentArea.innerHTML = html;
          if (window.initializePageScripts) window.initializePageScripts();
        })
        .catch(err => {
          console.error(err);
          contentArea.innerHTML = `
          <div class="p-8 text-center">
            <div class="text-red-500 text-5xl mb-4">⚠️</div>
            <h3 class="text-xl font-semibold text-slate-700 mb-2">Error Loading Page</h3>
            <p class="text-slate-500">Could not load ${page}.php</p>
          </div>
        `;
        });
    }

    function updateActiveState(clickedLink) {
      document.querySelectorAll('.nav-link').forEach(l => {
        const parent = l.parentElement;
        parent.classList.remove('bg-gradient-to-r', 'from-indigo-500', 'to-purple-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/50');
        parent.classList.add('hover:bg-slate-700/50', 'text-slate-300', 'hover:text-white');

        const pulseDot = l.querySelector('.animate-pulse');
        if (pulseDot) pulseDot.remove();

        const icon = l.querySelector('.iconify');
        if (icon) {
          icon.classList.remove('text-white');
          icon.classList.add('text-slate-400', 'group-hover:text-white');
        }
      });

      const parent = clickedLink.parentElement;
      parent.classList.add('bg-gradient-to-r', 'from-indigo-500', 'to-purple-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/50');
      parent.classList.remove('hover:bg-slate-700/50', 'text-slate-300', 'hover:text-white');

      const pulseDot = document.createElement('span');
      pulseDot.className = 'ml-auto w-1.5 h-1.5 bg-white rounded-full animate-pulse';
      clickedLink.appendChild(pulseDot);

      const icon = clickedLink.querySelector('.iconify');
      if (icon) {
        icon.classList.add('text-white');
        icon.classList.remove('text-slate-400', 'group-hover:text-white');
      }
    }

    function updatePageTitle(page) {
      const navTitle = document.querySelector('.nav-title') || document.querySelector('h2.text-white');
      if (navTitle) {
        navTitle.textContent = page.charAt(0).toUpperCase() + page.slice(1);
      }
    }

  });

</script>

</script>

<style>
  /* Custom Scrollbar */
  .scrollbar-thin::-webkit-scrollbar {
    width: 6px;
  }

  .scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
  }

  .scrollbar-thin::-webkit-scrollbar-thumb {
    background: #475569;
    border-radius: 3px;
  }

  .scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: #64748b;
  }
</style>