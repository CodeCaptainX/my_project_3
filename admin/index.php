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
