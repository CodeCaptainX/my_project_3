<div class="navigation">
  <div class="logo">
    <img src="img/logo.png" alt="">
  </div>
  <div class="menu">
    <ul>
      <?php
      $current_page = isset($_GET['page']) ? $_GET['page'] : 'Dashboard';
      $menu_items = [
        ['page' => 'Dashboard', 'label' => 'Dashboard', 'mid' => 1],
        ['page' => 'Attendance', 'label' => 'Attendance', 'mid' => 2],
        ['page' => 'Employee', 'label' => 'Employee', 'mid' => 3],
        ['page' => 'Leave', 'label' => 'Leave', 'mid' => 4],
        ['page' => 'Report', 'label' => 'Report', 'mid' => 5],
        ['page' => 'User', 'label' => 'User', 'mid' => 6],
        ['page' => 'UserApp', 'label' => 'UserApp', 'mid' => 7]
      ];

      if ($_SESSION['utype'] === 'admin') {
        // Admin sees all menu items with full access
        foreach ($menu_items as $index => $item) {
          $active_class = ($current_page === $item['page']) ? 'active' : '';
          echo '
              <li data-opt="' . $index . '" class="' . $active_class . '" data-role="1">
                <a href="?page=' . $item['page'] . '">
                  <p>' . $item['label'] . '</p>
                </a>
              </li>';
        }
      } else {
        // Regular users - check permissions
        foreach ($menu_items as $index => $item) {

          if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $permission = $row['aid'];

            if ($permission > 0) { // Has some access
              $active_class = ($current_page === $item['page']) ? 'active' : '';
              echo '
                  <li data-opt="' . $index . '" class="' . $active_class . '" data-role= "' . $permission . '">
                    <a href="?page=' . $item['page'] . '">
                      <p>' . $item['label'] . '</p>
                    </a>
                  </li>';
            }
          }
        }
      }
      ?>
  </div>