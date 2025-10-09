<?php
  $cn = new mysqli("localhost", "root", "", "doorstap");
?>
<div class="container"
  style="top:50px; position:relative; width:900px; background-color: #e8e7e7;padding: 0 12px 10px 12px; border-radius: 10px;border: 1px solid #453e3e; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
  <!-- <form action="" class="upl"> -->
  <form action="action/save_employee.php" method="POST" enctype="multipart/form-data" class="upl">
    <div class=" row">
      <div class="btn btn-secondary">
        <div class=" btn btn-danger">
          <i class="fa fa-times"></i>
        </div>
        <h6>Add New & Edit</h6>
      </div>
      <div class="col-xxl-lg-4 col-xl-lg-4 col-lg-4">
        <div class="box-input">
          <label for="name">Name KH</label>
          <input type="text" name="name-kh" id="name-kh">
          <label for="name">Email</label>
          <input type="email" name="email" id="txt-email">
          <label for="name">Line Manager</label>
          <select name="manager" id="txt-manager">
            <option value="0">Please select manager</option>
            <?php
              $sql = "SELECT * FROM manager WHERE id > 0";
              $result = $cn->query($sql);
              while ($row = $result->fetch_array()) {
               ?>
            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
            <?php
              }
            ?>

          </select>
          <label for="name">Join Date</label>
          <input type="date" name="join-date" id="join-date">

        </div>
      </div>
      <div class="col-xxl-lg-4 col-xl-lg-4 col-lg-4">
        <div class="box-input">
          <label for="name">Name ENG</label>
          <input type="text" name="name-eng" id="name-eng">
          <label for="name">Position</label>
          <select name="position" id="txt-position">
            <option value="0">Please select position</option>
            <?php
              $sql = "SELECT * FROM position WHERE id > 0";
              $result = $cn->query($sql);
              while ($row = $result->fetch_array()) {
                ?>
            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
            <?php
              }
                ?>
            <!-- <option value="1">chan</option>
            <option value="2">lay</option>
            <option value="3">rom</option> -->
          </select>
          <label for="name">Branch</label>
          <select name="branch" id="txt-branch">
            <option value="0">Please select Branch</option>
            <?php
              $sql = "SELECT * FROM branch WHERE id > 0";
              $result = $cn->query($sql);
              while ($row = $result->fetch_array()) {
                ?>
            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
            <?php
              }  
               ?>
            <!-- <option value="1">chan</option>
            <option value="2">lay</option>
            <option value="3">rom</option> -->
          </select>
          <label for="name">Phone</label>
          <input type="text" name="phone" id="txt-phone">
        </div>
      </div>
      <div class="col-xxl-lg-4 col-xl-lg-4 col-lg-4">
        <div class="box-input">
          <label for="">Photo</label>
          <div class="pl">
            <div class="img-box">
              <input type="file" name="txt-file" id="txt-file" class="txt-file">
            </div>
          </div>
          <label for="">Gender</label>
          <select name=" gender" id="txt-gender">
            <option value="0">Please select gender</option>
            <option value="1">Male</option>
            <option value="2">Female</option>
          </select>
          <input type="hidden" name="photo" id="txt-photo" alt="">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xxl-lg-4 col-xl-lg-4 col-lg-4">
        <div class="box-input">
          <label for="">Status</label>
          <select name="status" id="txt-status">
            <option value="0">Please select status</option>
            <option value="1">Active</option>
            <option value="2">Inactive</option>
          </select>
        </div>
      </div>
      <div class="col-xxl-lg-8 col-xl-lg-8 col-lg-8">
        <div class="box-input">
          <label for="">Address</label>
          <input type="text" name="address" id="address">
          <button type="button" class="btn btn-primary" style="width:80px; margin-top: 10px;">Save</button>
        </div>
      </div>
    </div>
  </form>
</div>