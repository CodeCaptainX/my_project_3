<?php
header('Content-Type: application/json');
$cn = new mysqli("localhost", "root", "", "doorstap");
$cn->set_charset("utf8");

if ($cn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $cn->connect_error]));
}

// Assuming "manager" is a self-join on employees table where manager_id refers to employees.id
$sql = "SELECT employees.id, employees.name_kh, employees.name_eng, employees.phone, 
                position.name AS position_name, 
                branch.name AS branch_name,
                employees.status 
                FROM 
                employees 
                LEFT JOIN 
                position ON employees.position_id = position.id 
                LEFT JOIN branch ON employees.branch_id = branch.id  WHERE status  = 1;";
$res = $cn->query($sql);
$data = array();

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_array()) {
        $data[] = array(
            'id' => $row[0],
            'name_kh' => $row[1],
            'name_eng' => $row[2],
            'phone' => $row[3],
            'position' => $row[4],
            'branch' => $row[5],
            'status' => $row[6]
        );
    }
    echo json_encode($data);
} else {
    echo json_encode(["error" => "No records found"]);
}
?>