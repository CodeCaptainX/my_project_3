<?php
  $cn   = new mysqli("localhost", "root", "", "doorstap");
  $cn->set_charset("utf8");
  $id   = $_POST['id'];
  $sql  = "SELECT * FROM employees WHERE id = $id";
  $res  = $cn->query($sql);
  $row  = $res->fetch_array();
  
  $data = array(
    'id'        => $row[0],
    'name_kh'   => $row[1],
    'name_eng'  => $row[2],
    'email'     => $row[3],
    'position'  => $row[4],
    'manager'   => $row[5],
    'branch'    => $row[6],
    'join_date' => $row[7],
    'phone'     => $row[8],
    'address'   => $row[9],
    'photo'     => $row[10],
    'gender'    => $row[11],
    'status'    => $row[12]
  );
  
  echo json_encode($data);
?>