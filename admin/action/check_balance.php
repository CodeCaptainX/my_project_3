<?php
  include('db/cn.php');include('db/cn.php');
  $cn->set_charset("utf8");
  $employee_id = $_POST['employee_id'];

  // Check remaining leave (like checking account balance)
  $sql = "SELECT leave_type, remaining_days 
          FROM leave_balances 
          WHERE employee_id=$employee_id";
 $result = $cn->query($sql);
  while ($row = $result->fetch_assoc()) {
    echo $row['leave_type'] . ": " . $row['remaining_days'] . " days left\n";
  }
?>