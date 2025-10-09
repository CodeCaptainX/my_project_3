<?php
session_start();
include ('db/cn.php');
$cn->set_charset("utf8");
if ($cn->connect_error) {
    die("Connection failed: " . $cn->connect_error);
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$email = $cn->real_escape_string($email);

$pass = isset($_POST['password']) ? trim($_POST['password']) : '';
$pass = $cn->real_escape_string($pass);
$pass = md5($pass); // Hashing the password for security

$res['dpl'] = false;

$ip = $_SERVER['REMOTE_ADDR'];

$_SESSION['login'] = false;
$_SESSION['uid'] = 0;

$dpl = "SELECT * FROM tbl_user WHERE u_email = '$email'";
$result = $cn->query($dpl);
 if ($result->num_rows > 0){
  $post_data = $result->fetch_array();
  if(password_verify($pass, $post_data[3])) {
      $sql = "UPDATE tbl_user SET u_ip = '$ip' WHERE u_email = '$email'";
      $cn->query($sql);
      $res['dpl'] = true;
      $_SESSION['login'] = true;
      $_SESSION['uid'] = $post_data[0];
      $_SESSION['uemail'] = $email;
      $_SESSION['utype'] = $post_data[4];
  }
 }
echo json_encode($res);
?>