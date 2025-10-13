<div class="navigation">
  <div class="logo">
    <img src="img/logo.png" alt="">
  </div>
  <div class="menu">
    <ul>
      <?php
      $current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
      $menu_items = [
        ['page' => 'dashboard', 'label' => 'Dashboard', 'mid' => 1],
        ['page' => 'attendance', 'label' => 'Attendance', 'mid' => 2],
        ['page' => 'employee', 'label' => 'Employee', 'mid' => 3],
        ['page' => 'leave', 'label' => 'Leave', 'mid' => 4],
        ['page' => 'report', 'label' => 'Report', 'mid' => 5],
        ['page' => 'user', 'label' => 'User', 'mid' => 6],
      ];

      // All users can access all menu items
      foreach ($menu_items as $index => $item) {
        $active_class = ($current_page === $item['label']) ? 'active' : '';
        echo '
            <li data-opt="' . $index . '" class="' . $active_class . '" data-role="1">
              <a href="?page=' . $item['page'] . '">
                <p>' . $item['label'] . '</p>
              </a>
            </li>';
      }
      ?>
    </ul>
  </div>
</div>