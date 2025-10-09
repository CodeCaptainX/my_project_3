<?php
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

</html>