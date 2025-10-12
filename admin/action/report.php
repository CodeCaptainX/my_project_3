<?php
    header('Content-Type: application/json');
    $cn = new mysqli("localhost", "root", "", "doorstep");
    $cn->set_charset("utf8");
    if ($cn->connect_error) {
        die(json_encode(["error" => "Connection failed: " . $cn->connect_error]));
    }
    $from_date      = isset($_POST['from_date']) ? $_POST['from_date'] : null;
    $end_date       = isset($_POST['end_date']) ? $_POST['end_date'] : null;
    $position       = isset($_POST['position']) ? $_POST['position'] : null;
    $search_term    = isset($_POST['search_term']) ? $_POST['search_term'] : null;
    if(isset($from_date) && isset($end_date)) {
        $sql = "SELECT e.id AS employee_id, e.name_eng, e.name_kh, a.attendance_date,
        a.check_in_1, a.check_out_1, a.check_in_2, a.check_out_2, a.note 
        FROM 
        attendance a 
        JOIN 
        employees e ON a.employee_id = e.id
        WHERE 
        a.attendance_date 
        BETWEEN 
        '$from_date' AND '$end_date' 
        AND 
        e.position_id = '$position' 
        AND 
        (e.id LIKE '%$search_term%' 
        OR e.name_eng LIKE '%$search_term%' 
        OR e.name_kh LIKE '%$search_term%')
        ORDER BY a.attendance_date, e.id";
    }else {
        $sql = "SELECT e.id AS employee_id, e.name_eng, e.name_kh, a.attendance_date,
        a.check_in_1, a.check_out_1, a.check_in_2, a.check_out_2, a.note 
        FROM 
        attendance a 
        JOIN 
        employees e ON a.employee_id = e.id
        ORDER BY a.attendance_date, e.id";
    }
    $res    = $cn->query($sql);
    $data   = array();
    if ($res->num_rows >0){
        while ($row = $res->fetch_array()) {
            $data[] = array(
                    'employee_id'       => $row['0'],
                    'name_eng'          => $row['1'],
                    'name_kh'           => $row['2'],
                    'attendance_date'   => $row['3'],
                    'check_in_1'        => $row['4'],
                    'check_out_1'       => $row['5'],
                    'check_in_2'        => $row['6'],
                    'check_out_2'       => $row['7'],
                    'note'              => $row['8']
            );
        }
        echo json_encode($data);
    }
?>