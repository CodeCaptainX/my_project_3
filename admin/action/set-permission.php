<?php
include('db/cn.php');
$cn->set_charset("utf8");

// Get parameters
$uid = isset($_POST['uid']) ? $_POST['uid'] : '';
$mid = isset($_POST['mid']) ? $_POST['mid'] : '';   
$aid = isset($_POST['aid']) ? $_POST['aid'] : '';

$res = ['edit' => true];

// Check if permission exists
$sql = "SELECT id FROM tbl_permission WHERE uid = '$uid' AND mid = '$mid'";
$res = $cn->query($sql);
if ( $res && $res->num_rows == 0) {
    // INSERT new permission
    $sql = "INSERT INTO tbl_permission VALUES (null,'$uid', '$mid', '$aid')";
} else {
     // UPDATE existing permission
    $sql = "UPDATE tbl_permission SET aid = '$aid' WHERE uid = '$uid' AND mid = '$mid'";
}
$cn->query($sql);
echo json_encode($res);
?>