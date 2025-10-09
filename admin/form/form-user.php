<?php
  $cn = new mysqli("localhost", "root", "", "doorstap");
?>
<div class="container"
  style="top:50px; position:relative; width:400px; background-color: #e8e7e7;padding: 0 12px 10px 12px; border-radius: 10px;border: 1px solid #453e3e; box-shadow: 0 0 10px rgba(0,0,0,0.5);">
  <!-- <form action="" class="upl"> -->
  <form action="action/save_employee.php" method="POST" enctype="multipart/form-data" class="upl">
    <div class=" row">
      <div class="btn btn-secondary">
        <div class=" btn btn-danger">
          <i class="fa fa-times"></i>
        </div>
        <h6>Add Admin & Users</h6>
      </div>
      <div class="col-xxl-lg-12 col-xl-lg-12 col-lg-12">
        <div class="box-input">
          <label for="name">ID</label>
          <input type="text" name="txt-id" id="txt-id">
          <label for="name">User Name</label>
          <input type="email" name="username" id="txt-username">
          <label for="name">User Email</label>
          <input type="email" name="email" id="txt-email">
          <label for="name">User Password</label>
          <input type="text" name="password" id="txt-password">
          <label for="name">User Type</label>
          <select name="user_type" id="txt-user-type">
            <option value="0">Please select user type</option>
            <option value="1">Admin</option>
            <option value="2">User</option>
          </select>
          <label for="name">Status</label>
          <select name="status" id="txt-status">
            <option value="0">Please select status</option>
            <option value="1">Active</option>
            <option value="2">Inactive</option>
          </select>
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