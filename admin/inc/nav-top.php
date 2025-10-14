<!-- Top Navigation -->
<nav class="bg-gradient-to-r from-indigo-600 via-purple-600 to-purple-700 shadow-lg sticky top-0 z-50">
  <div class="w-full  px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-end w-full h-[56px]">

      <!-- Logo & Brand -->
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 bg-white/10 backdrop-blur-md rounded-lg p-0.5 shadow-md">
          <img src="img/logo.png" alt="Logo" class="w-full h-full rounded-md object-cover">
        </div>
        <div class="hidden sm:flex flex-col">
          <h1 class="text-white text-sm font-bold leading-tight">Doorstep Technology</h1>
          <span class="text-white/70 text-[10px] font-medium uppercase tracking-wider">Admin Portal</span>
        </div>
      </div>

      <!-- Page Title -->
      <div class="flex-1 text-center">
        <h2 class="text-white text-base sm:text-lg font-semibold">
          <?= htmlspecialchars(ucfirst($_GET['page'] ?? 'Dashboard'), ENT_QUOTES, 'UTF-8'); ?>
        </h2>
      </div>

      <!-- User Section -->
      <div class="flex items-center gap-3">
        <!-- User Info -->
        <div class="hidden md:flex items-center gap-2.5">
          <div
            class="w-8 h-8 bg-gradient-to-br from-pink-400 to-red-500 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-md">
            <?php
            $name = htmlspecialchars($_SESSION['uname'] ?? 'User');
            echo strtoupper(substr($name, 0, 1));
            ?>
          </div>
          <span class="text-white text-sm font-semibold">
            <?= htmlspecialchars($_SESSION['uname'] ?? 'User'); ?>
          </span>
        </div>

        <!-- Logout Button -->
        <button onclick="handleLogout()"
          class="flex items-center gap-2 px-3.5 py-2 bg-white/10 hover:bg-red-500 border border-white/20 hover:border-transparent rounded-lg text-white text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg backdrop-blur-md"
          title="Logout">
          <span class="iconify" data-icon="mdi:logout" data-width="18"></span>
          <span class="hidden sm:inline">Logout</span>
        </button>
      </div>

    </div>
  </div>
</nav>

<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
<script>
  function handleLogout() {
    if (confirm('Are you sure you want to logout?')) {
      window.location.href = 'logout.php';
    }
  }
</script>