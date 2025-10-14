<?php
session_start();
require_once __DIR__ . "/action/db/cn.php"; // Database connection

// --- 1️⃣ Session & Auth Check ---
if (empty($_SESSION['uid']) || empty($_SESSION['login_session'])) {
  header("Location: login.php");
  exit();
}

$uid = (int) $_SESSION['uid'];
$loginSession = $_SESSION['login_session'];

// --- 2️⃣ Verify user in DB ---
$stmt = $cn->prepare("SELECT id, email, role, login_session FROM tbl_users WHERE id = ? AND login_session = ? LIMIT 1");
$stmt->bind_param("is", $uid, $loginSession);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
  session_unset();
  session_destroy();
  header("Location: login.php");
  exit();
}

// --- 3️⃣ Determine page ---
$page = $_GET['page'] ?? 'dashboard';
$pagePath = __DIR__ . "/pages/{$page}.php";
$isAjax = isset($_GET['ajax']) && $_GET['ajax'] == '1';

// --- 4️⃣ Serve page for AJAX requests only ---
if ($isAjax) {
  if (file_exists($pagePath)) {
    include $pagePath;
  } else {
    http_response_code(404);
    echo "Page not found!";
  }
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once "inc/header.php"; ?>

<body class="bg-gray-100 text-gray-900">
  <?php include_once "inc/nav-top.php"; ?>

  <div class="flex max-h-[calc(100vh-64px)]">
    <?php include_once "inc/navigation.php"; ?>

    <main class="flex-1 p-6" id="content">
      <?php
      if (file_exists($pagePath)) {
        include $pagePath;
      } else {
        include "pages/404.html";
      }

      ?>
    </main>
  </div>

  <!-- <?php include_once "inc/footer.php"; ?> -->

  <!-- Scripts -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.iconify.design/3/3.2.0/iconify.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>

</html>


<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  #content {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    max-height: calc(100vh-64px);
  }
</style>