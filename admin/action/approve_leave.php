<?php 
include('db/cn.php');
$cn->set_charset("utf8");
// Manager approves/rejects (like cashier processing order)
$application_id = $_POST['app_id']; // Which request?
$action = $_POST['action'];         // "Approve" or "Reject"

if ($action == "Approve") {
  $sql = "UPDATE leave_applications SET status='Approved' WHERE id=$application_id";
  echo "Leave Approved!";
} else {
  $sql = "UPDATE leave_applications SET status='Rejected' WHERE id=$application_id";
  echo "Leave Rejected!";
}
?>