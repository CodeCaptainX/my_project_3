<div class="container" style="top:15%; position:relative; width:300px; background-color: #e8e7e7;padding: 0 12px 10px 12px; border-radius: 10px;border: 1px solid #453e3e; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
  <form action="action/set_permission.php" method="POST" enctype="multipart/form-data" class="upl">
    <div class=" row">
      <div class="btn btn-secondary" style="margin-bottom: 20px;">
        <div class=" btn btn-danger">
          <i class="fa fa-times"></i>
        </div>
        <h6>User permission</h6>
      </div>
      <div class="col-xxl-lg-12 col-xl-lg-12 col-lg-12">
        <div class="box-input">
          <table class="table" id="tblPermission">
            <thead class="table-primary">
              <tr>
                <th scope="col">Menu</th>
                <th scope="col" width=120>Permission</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $menu_items = [
                  ['id' => 1, 'name' => 'Dashboard'],
                  ['id' => 2, 'name' => 'Attendance'],
                  ['id' => 3, 'name' => 'Employee'],
                  ['id' => 4, 'name' => 'Leave'],
                  ['id' => 5, 'name' => 'Report'],
                  ['id' => 6, 'name' => 'User'],
                  ['id' => 7, 'name' => 'UserApp']
              ];
              
              foreach ($menu_items as $item) {
                  echo '<tr>
                      <th scope="row">
                          <span>'.$item['id'].'</span>
                          '.$item['name'].'
                      </th>
                      <td>
                          <select name="permission_'.$item['id'].'" style="height: 30px;">
                              <option value="0">No Access</option>
                              <option value="1">Full Access</option>
                              <option value="2">Read Only</option>
                          </select>
                      </td>
                  </tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </form>
</div>