<?php
session_start();

// Optional: basic session check (you can remove this if not needed)
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Uncomment if you want to redirect unauthenticated users
    // header('Location: login.php');
    // exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Welcome</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    h1 {
      font-size: 3rem;
      color: #333;
      background: white;
      padding: 20px 40px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <h1>Hi 👋</h1>
</body>
</html>

<!-- <?php
session_start();
include("action/db/cn.php");
$ip = $_SERVER['REMOTE_ADDR'];

if(!$_SESSION['login'] || $_SESSION['login'] == false){
  header('Location: login.php');
  exit();
}
else{
  if(!$_SESSION['uid'] || !$_SESSION['uemail']){
    header('Location: login.php');
    exit();
  }else{
    $email = $_SESSION['uemail'];
    $uid = $_SESSION['uid'];
    $dpl = "SELECT * FROM tbl_user WHERE u_email = '$email' AND id = $uid AND u_ip='$ip'";
    $result = $cn->query($dpl);
    if(!$result || $result->num_rows == 0){
        header('Location: login.php');
        exit();
    }
  }
}
$uid=$_SESSION['uid'];
$utype=$_SESSION['utype'];
?>
<!DOCTYPE html>
<html lang="en">
  <?php require_once('inc/header.php')?>

  <body>
    <?php require_once('inc/navigation.php')?>
    <?php require_once('inc/nav-top.php')?>

    <div class="contain">
      <div class="container-fluid">
        <?php  $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard'; ?>
        <?php 
            if(!file_exists($page.".php") && !is_dir($page)){
                include '404.html';
            }else{
              if(is_dir($page)){
                  include $page.'/index.php';
              }else{
                include $page.'.php';
              }      
            }
          ?>
      </div>
    </div>
  </body>
  <?php require_once('inc/footer.php') ?>

</html> -->


