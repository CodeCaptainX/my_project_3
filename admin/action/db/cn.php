<?php
  $sname = "localhost";
  $unmae = "root";
  $password = ""; 
  $db_name = "doorstap";

  $cn = new mysqli($sname, $unmae, $password, $db_name);

  if ($cn->connect_error) {
      die("Connection failed: " . $cn->connect_error);
  }
?>