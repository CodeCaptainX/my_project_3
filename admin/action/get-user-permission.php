<?php
include ('db/cn.php');
$cn->set_charset("utf8");

$data = array();
$uid = isset($_POST['uid']) ? $_POST['uid'] : '';  // Get user ID from POST request

$sql = "SELECT * FROM `tbl_permission` WHERE uid = '$uid'";  // Query to get permissions for the user";
$res = $cn->query($sql);
if($res && $res->num_rows > 0) {  // Check if query executed successfully and has rows
  while($row = $res->fetch_array()) {  // Use while loop to fetch rows
      $data[] = array(
          "mid" => $row[2],    // Use column names as array keys
          "aid" => $row[3]
      );
  }
}
echo json_encode($data);
?>