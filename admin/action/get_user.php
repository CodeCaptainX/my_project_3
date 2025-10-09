<?php
$cn = new mysqli("localhost", "root", "", "doorstap");
$cn ->set_charset("utf8");
if ($cn->connect_error) {
   die("Connection failed: " . $cn->connect_error);
}
  $searchOpt    = isset($_POST['search_opt']) ? trim($_POST['search_opt']) : '0';
  $searchVal    = isset($_POST['searchVal']) ? trim($_POST['searchVal']) : '';
  $searchField  = isset($_POST['searchField']) ? trim($_POST['searchField']) : '';

  $fieldMap     = [
    'u_id'      => 'id',
    'username'  => 'u_name',
  ];
  if ($searchOpt === "0") {
      // Default query to get all active users
      $sql = "SELECT * FROM tbl_user WHERE status = 1 ORDER BY id DESC";
  } else {
      // Search query based on user input
      $sql = "SELECT * FROM tbl_user 
      WHERE $fieldMap[$searchField] LIKE '$searchVal%' ORDER BY id DESC";
  }
//  $sql = "SELECT * FROM tbl_user WHERE status = 1";
 $res = $cn->query($sql);
 $data = array();
  if ($res->num_rows > 0) {
      while ($row = $res->fetch_array()) {
          $data[] = array(
              'id'        => $row[0],
              'username'  => $row[1],
              'u_email'   => $row[2],
              'u_pass'    => $row[3],
              'u_type'    => $row[4],
              'u_ip'      => $row[5],
              'code'      => $row[6],
              'status'    => $row[7]
          );
      }
}
  echo json_encode($data);
?>