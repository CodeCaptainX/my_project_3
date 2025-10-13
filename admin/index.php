<?php
session_start();
include("action/db/cn.php"); // your DB connection

// Check if user is logged in
if (!isset($_SESSION['uid']) || !isset($_SESSION['login_session'])) {
  header('Location: login.php');
  exit();
}

$uid = (int) $_SESSION['uid'];
$loginSession = $_SESSION['login_session'];

// Fetch user from DB and validate login_session
$stmt = $cn->prepare("SELECT * FROM tbl_users WHERE id = ? AND login_session = ? LIMIT 1");
$stmt->bind_param("is", $uid, $loginSession);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
  session_unset();
  session_destroy();
  header('Location: login.php');
  exit();
}

$user = $result->fetch_assoc();
$utype = $user['role'];
$email = $user['email'];

// Determine page
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$ajax = isset($_GET['ajax']) && $_GET['ajax'] == 1;
$pagePath = "pages/" . $page . ".php";

if ($ajax) {
  if (file_exists($pagePath)) {
    include $pagePath;
  } else {
    echo "Page not found!";
  }
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php'); ?>

<body>
  <h1 class="bg-red-400 text-blue-400">dsfsdf</h1>
  <?php require_once('inc/nav-top.php'); ?>
  <?php require_once('inc/navigation.php'); ?>

  <div class="contain">
    <div class="container-fluid" id="content">
      <?php
      if (file_exists($pagePath)) {
        include $pagePath;
      } else {
        include 'pages/404.html';
      }
      ?>
    </div>
  </div>

  <?php require_once('inc/footer.php'); ?>
  <script src="./script.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.iconify.design/3/3.2.0/iconify.min.js"></script>

</body>

</html>