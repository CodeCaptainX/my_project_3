<?php
  $cn = new mysqli("localhost", "root", "", "doorstep");
  $cn->set_charset("utf8");

  // Get search parameters from POST
  $searchOpt    = isset($_POST['search_opt']) ? trim($_POST['search_opt']) : '0';
  $searchVal    = isset($_POST['searchVal']) ? trim($_POST['searchVal']) : '';
  $searchField  = isset($_POST['searchField']) ? trim($_POST['searchField']) : '';

  $fieldMap = [
    'id'          => 'employees.id',
    'name_kh'     => 'employees.name_kh',
    'name_eng'    => 'employees.name_eng'
];
   
    
  // Base SQL for fetching employee data
  if( $searchOpt === "0"){
    $sql = "SELECT 
                    employees.id, employees.name_kh, employees.name_eng, employees.phone,
                    branch.name AS branch_name, 
                    manager.name AS manager_name, 
                    employees.join_date, 
                    employees.status 
             FROM 
                employees 
             LEFT JOIN 
                position ON employees.position_id = position.id 
             LEFT JOIN 
                branch ON employees.branch_id = branch.id 
             LEFT JOIN 
                manager ON employees.manager_id = manager.id
             WHERE status  = 1 ORDER BY id DESC;";
  }else{
    $sql = "SELECT 
                employees.id,
                employees.name_kh,
                employees.name_eng,
                employees.phone,
                branch.name AS branch_name,
                manager.name AS manager_name,
                employees.join_date,
                employees.status
              FROM 
                employees
              INNER JOIN 
                position ON employees.position_id = position.id
              INNER JOIN 
                branch ON employees.branch_id = branch.id
              INNER JOIN 
                manager ON employees.manager_id = manager.id 
              WHERE 
                $fieldMap[$searchField] LIKE '$searchVal%'
              ORDER BY id DESC";
  }
  $res = $cn->query($sql);
  $data = array();
  
  if ($res->num_rows > 0) {
      while ($row = $res->fetch_array()) {
          $data[] = array(
              'id'          => $row[0],
              'name_kh'     => $row[1],
              'name_eng'    => $row[2],
              'phone'       => $row[3], 
              'branch'      => $row[4], 
              'manager'     => $row[5], 
              'join_date'   => $row[6],    
              'status'      => $row[7],
          );
      }
  }
  echo json_encode($data);
?>