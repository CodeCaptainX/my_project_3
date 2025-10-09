<div class="nav-top">
    <div class="container-fluid">
      <div class="row"> 
        <div class="col-xl-12 col-lg-12 bar">
          <ul>
            <li class="title">
              <?= htmlspecialchars($_GET['page'] ?? 'Dashboard', ENT_QUOTES, 'UTF-8'); ?>
            </li>
            <li class="name-com">
              Doorstep Technology Co.,Ltd
            </li>
            <li class="user">
             <?= ($_SESSION['utype'] ?? 0) == 1 ? 'admin' : htmlspecialchars($_SESSION['uname'] ?? 'User'); ?>
            </li>
            <li class="logout">
              <i class="fa-solid fa-power-off"></i>
            </li>
          </ul>
        </div>
      </div>
    </div>
</div>