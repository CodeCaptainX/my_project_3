<?php
$cn = new mysqli("localhost", "root", "", "doorstep");
if ($cn->connect_error) {
    die("Connection failed: " . $cn->connect_error);
}
$cn->set_charset("utf8");
$sql ="INSERT INTO leave_applications 
(employee_id, leave_type_id, start_date, end_date, days_requested, reason, status, created_at)
VALUES 
(1, 1, '2023-08-01', '2023-08-03', 3.0, 'Family vacation', 'pending', NOW())";
if ($cn->query($sql) === TRUE) {
    echo "New leave application created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $cn->error;
}
?>