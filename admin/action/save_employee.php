<?php
$cn = new mysqli("localhost", "root", "", "doorstap");
$cn ->set_charset("utf8");

$id           = isset($_POST['id']) ? $_POST['id'] : 0;
$name_kh      = trim($_POST['name-kh']);
$name_eng     = trim($_POST['name-eng']);
$email        = $_POST['email'];
$position_id  = $_POST['position'];
$manager_id   = $_POST['manager'];
$branch_id    = $_POST['branch'];
$join_date    = $_POST['join-date'];
$phone        = $_POST['phone'];
$address      = $_POST['address'];
$photo        = $_POST['photo'];
$gender       = $_POST['gender'];
$status       = $_POST['status'];

  if($id > 0){
    $sql = "UPDATE employees SET 
            name_kh     = '$name_kh',
            name_eng    = '$name_eng',
            email       = '$email',
            position_id = '$position_id',
            manager_id  = '$manager_id ',
            branch_id   = '$branch_id ',
            join_date   = '$join_date',
            phone       = '$phone',
            address     = '$address',
            photo       = '$photo',
            gender      = '$gender',
            status      = '$status'
            WHERE id    = $id";
  }else {
      $sql = "INSERT INTO employees 
            VALUES (null,
            '$name_kh',
            '$name_eng',
            '$email',
            '$position_id',
            '$manager_id','$branch_id',
            '$join_date' ,
            '$phone ',
            '$address',
            '$photo',
            '$gender',
            '$status'
            )";
  }
$cn->query($sql);

// If position is Manager (ID=1), insert into manager table
if ($position_id == 1 AND $status == 1) {
    $sql_manager = "INSERT INTO manager VALUES (null, '$name_eng')";
    $cn->query($sql_manager);
}elseif ($position_id != 1 AND $status == 1) {
    // If position is Manager and status is inactive, delete from manager table
    $sql_manager = "DELETE FROM manager WHERE name = '$name_eng'";
    $cn->query($sql_manager);
}
?>