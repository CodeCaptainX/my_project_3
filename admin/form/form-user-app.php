<?php
  $cn = new mysqli("localhost", "root", "", "doorstep");
?>
<div class="container"
  style="top:50px; position:relative; width:400px; background-color: #e8e7e7;padding: 0 12px 10px 12px; border-radius: 10px;border: 1px solid #453e3e; box-shadow: 0 0 10px rgba(0,0,0,0.5);">
  <!-- <form action="" class="upl"> -->
  <form action="api/create_user.php" method="POST" enctype="multipart/form-data" class="upl">
    <div class=" row">
      <div class="btn btn-secondary">
        <div class=" btn btn-danger">
          <i class="fa fa-times"></i>
        </div>
        <h6>Login Application</h6>
      </div>
      <div class="col-xxl-lg-6 col-xl-lg-6 col-lg-6">
        <div class="box-input">
          <label for="name">Employees ID</label>
          <input type="text" name="employee_id" placeholder="Employee ID" required>
          <label for="name">User Name</label>
          <input type="text" name="username" placeholder="Username" required>
          <label for="name">User Password</label>
          <input type="password" name="password" placeholder="Password" required>
          <label for="name">User Email</label>
          <input type="email" name="email" placeholder="Email" required>
        </div>
      </div>
      <div class="col-xxl-lg-6 col-xl-lg-6 col-lg-6">
          <div class="box-input">

            <label for="name">Role</label>
            <select name="role" id="txt-user-type">  <!-- was user_type -->
              <option value="0">Please select role</option>
              <option value="employee">employee</option>
              <option value="manager">manager</option>
              <option value="admin">admin</option>
            </select>

            <label for="name">Status</label>
            <select name="status" id="txt-status">  <!-- was is_locked -->
              <option value="0">Please select status</option>
              <option value="1">Active</option>
              <option value="2">Inactive</option>
            </select>

            <label>Lock Until:</label>
            <input type="datetime-local" name="lock_until">
            <label>Initial Login Attempts</label>
            <input type="number" name="login_attempts" min="0" value="0">
            
          </div>
        </div>
      <div class="row">
        <div class="col-xxl-lg-12 col-xl-lg-12 col-lg-12">
          <div class="box-input">
            <button type="button" class="btn btn-primary" style="width:80px; margin-top: 10px; margin-right: -20px;">
              Save
            </button>
          </div>
        </div>
      </div>
  </form>
</div>