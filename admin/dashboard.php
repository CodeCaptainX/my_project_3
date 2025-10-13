<?php
include('action/db/cn.php');
$cn->set_charset("utf8");

// Get total employees count
$sql_total = "SELECT COUNT(*) as total FROM employees WHERE id != 0 AND status = 1";
$result_total = $cn->query($sql_total);
$total_employees = ($result_total && $row = $result_total->fetch_assoc()) ? $row['total'] : 0;

// Get leave count (you'll need to replace this with your actual leave query)
$sql_leave = "SELECT COUNT(*) as leave_count FROM leave_applications WHERE status = 'approved'"; // Modify this query as needed
$result_leave = $cn->query($sql_leave);
$leave_count = ($result_leave && $row = $result_leave->fetch_assoc()) ? $row['leave_count'] : 0;

// Calculate present count
$present_count = $total_employees - $leave_count;
?>
<div class="row" style="padding: 0px 10px 5px 10px; overflow-y: hidden; top: 5px; position: relative;height: 100%">
  <div class="col-xl-4 col-lg-4 box">
    <div class="box-dash">
      <div class="box1">
        <h4>Present</h4>
        <p>attendence</p>
      </div>
      <div class="present-num ">
        <a href=""><?php echo $present_count; ?> </a>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-4 box">
    <div class="box-dash">
      <div class="box1">
        <h4>Leave</h4>
        <p>Request Leave</p>
      </div>
      <div class="leave-num">
        <a href=""><?php echo $leave_count; ?></a>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-4 box">
    <div class="box-dash">
      <div class="box1">
        <h4>Employee</h4>
        <p>List all member</p>
      </div>
      <div class="total-num">
        <a href=""><?php echo $total_employees; ?></a>
      </div>
    </div>
  </div>
  <div class="tbl-box" style="border: 2px solid #ddd; margin-top: 10px; 
  position: fix; height: 70%;">
    <h5 style="color: #31ED66;">Present</h5>
    <table class="table" id="tblData">
      <thead class="table-secondary">
      </thead>

    </table>
  </div>
  <div class="tbl-box1" style="border: 2px solid #ddd; margin-top: 5px; 
  position: fix; height: 30%;">
    <h5 style="color: #F80404;">Leave</h5>
    <table class="table">
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
          <td>Mark</td>
          <td>Mark</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
          <td>Jacob</td>
          <td>Mark</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>