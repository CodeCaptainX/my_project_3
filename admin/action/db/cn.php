<?php
  $sname = "localhost";
  $unmae = "root";
  $password = "123456"; 
  $db_name = "doorstep";

  $cn = new mysqli($sname, $unmae, $password, $db_name);

  if ($cn->connect_error) {
      die("Connection failed: " . $cn->connect_error);
  }
?>