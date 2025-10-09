<?php
 $cn = new mysqli("localhost", "root", "", "doorstap");
 $cn->set_charset("utf8");
 ?>

<div class="row pt-2">
  <form id="attendanceForm" method="POST">
    <!-- Added form ID -->
    <div class="row">
      <div class="col-xxl-lg-6 col-xl-lg-6 col-lg-6">
        <label style="padding: 5px; color: black;">From Date</label>
        <input type="date" name="from-date" id="txt-from-date" class="form-control" required>
        <label style="padding: 5px; color: black;">Position</label>
        <select name="position" id="txt-position" class="form-control" required>
          <?php
          $sql = "SELECT * FROM position WHERE id > 0";
          $result = $cn->query($sql);
          while ($row = $result->fetch_array()) {
            ?>
          <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
          <?php
          }
          ?>
        </select>
      </div>
      <div class="col-xxl-lg-6 col-xl-lg-6 col-lg-6">
        <label style="padding: 5px; color: black;">End Date</label>
        <input type="date" name="end-date" id="txt-end-date" class="form-control" required>
        <label style="padding: 5px; color: black; ">search</label>
        <div class="row">
          <div class="col-xxl-lg-9 col-xl-lg-9 col-lg-9">
            <input type="text" name="search_term" id="txt-search" value="" class="form-control"
              placeholder="Search by ID or Name">
          </div>
          <div class="col-xxl-lg-3 col-xl-lg-3 col-lg-3">
            <button type="button" id="btn-search-report" class="btn btn-primary" style="width: 100%; ">
              Search
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <div class="pt-2">
    <table class=" table" id="data-table">
    </table>
  </div>
  <div class=" row">
    <div class="row-page">
      <ul>
        <li>
          <select name="" id="" class="num2">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </li>
        <li class="btn btn-back">Back</li>
        <li class="page">
          <span class="current_page">1</span>/
          <span class="total_page">1</span>
          of
          <span class="total_data">0</span>
        </li>
        <li class="btn btn-next">Next</li>
      </ul>
    </div>
  </div>
</div>