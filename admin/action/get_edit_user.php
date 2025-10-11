<?php
  $cn   = new mysqli("localhost", "root", "", "doorstap");
  $cn->set_charset("utf8");
  $id   = $_POST['id'];
  $sql  = "SELECT * FROM tbl_users WHERE id = $id";
  $res  = $cn->query($sql);
  $row  = $res->fetch_array();

  $data = array(
    'id'        => $row[0],
    'username'  => $row[1],
    'u_email'   => $row[2],
    'password'  => $row[3],
    'u_type'    => $row[4],
    'u_ip'      => $row[5],
    'code'      => $row[6],
    'status'    => $row[7]
  );
  
  echo json_encode($data);
?>