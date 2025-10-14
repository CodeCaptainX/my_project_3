<?php
/**
 * Sidebar Component
 * Displays the left navigation sidebar
 */
$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

$menu_items = [
    ['page' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'mdi:chart-box'],
    ['page' => 'attendance', 'label' => 'Attendance', 'icon' => 'mdi:clock-check-outline'],
    ['page' => 'employee', 'label' => 'Employee', 'icon' => 'mdi:account-multiple'],
    ['page' => 'leave', 'label' => 'Leave', 'icon' => 'mdi:calendar-check'],
    ['page' => 'report', 'label' => 'Report', 'icon' => 'mdi:file-document'],
    ['page' => 'user', 'label' => 'User', 'icon' => 'mdi:account-tie'],
];
?>

<aside class="sidebar">
    <!-- Logo Section -->
    <div class="px-6 py-6 border-b border-gray-700">
        <a href="?page=dashboard" class="flex items-center space-x-3 group">
            <div
                class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                <iconify-icon icon="mdi:shield-admin" width="24" height="24" class="text-white"></iconify-icon>
            </div>
            <span class="text-xl font-bold text-white">AdminHub</span>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6">
        <p class="px-4 text-xs text-gray-400 font-semibold uppercase tracking-wider mb-4">Main Menu</p>
        <ul class="space-y-2">
            <?php foreach ($menu_items as $index => $item):
                $is_active = $current_page === $item['page'];
                $active_class = $is_active ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white' : 'text-gray-300 hover:text-white hover:bg-gray-800';
                ?>
                <li>
                    <a href="?page=<?= $item['page']; ?>"
                        class="menu-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300 group relative <?= $active_class; ?>">
                        <span class="flex items-center justify-center w-5 h-5 flex-shrink-0">
                            <iconify-icon icon="<?= $item['icon']; ?>" width="20" height="20"></iconify-icon>
                        </span>
                        <span class="text-sm font-medium"><?= $item['label']; ?></span>

                        <?php if ($is_active): ?>
                            <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- User Profile Section -->
    <div class="px-4 py-4 border-t border-gray-700">
        <div
            class="flex items-center space-x-3 p-3 bg-gray-800 bg-opacity-50 rounded-lg hover:bg-opacity-70 transition-all cursor-pointer">
            <div
                class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <iconify-icon icon="mdi:account-circle" width="24" height="24" class="text-white"></iconify-icon>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-white truncate">
                    <?= htmlspecialchars($uname, ENT_QUOTES, 'UTF-8'); ?>
                </p>
                <p class="text-xs text-gray-400 truncate"><?= $utype == 1 ? 'Administrator' : 'User'; ?></p>
            </div>
        </div>
    </div>
</aside>