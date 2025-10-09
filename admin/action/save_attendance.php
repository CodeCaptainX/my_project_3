<?php
require_once 'db/cn.php';
header('Content-Type: application/json');

$employee_id = $_POST['employee_id'] ?? null;
$type        = $_POST['type'] ?? null; // 'in' or 'out'

if (!$employee_id || !in_array($type, ['in', 'out'])) {
    http_response_code(400);
    exit(json_encode(["status" => "fail", "message" => "Missing data"]));
}

$today = date("Y-m-d");
$now   = date("H:i:s");

// Check if attendance already exists today
$sql = "SELECT * FROM attendance WHERE employee_id = $employee_id AND attendance_date = $today";
$res = $cn->query($sql);

if ($row = $res->fetch_assoc()) {
    // Update time slots based on availability
    if ($type === 'in') {
        if (!$row['check_in_1']) {
            $update = "UPDATE attendance SET check_in_1 = $now WHERE id = $employee_id";
        } elseif (!$row['check_in_2']) {
            $update = "UPDATE attendance SET check_in_2 = $now WHERE id = $employee_id";
        } else {
            exit(json_encode(["status" => "fail", "message" => "Already checked in twice"]));
        }
    } else if ($type === 'out') {
        if (!$row['check_out_1']) {
            $update = "UPDATE attendance SET check_out_1 = $now WHERE id = $employee_id";
        } elseif (!$row['check_out_2']) {
            $update = "UPDATE attendance SET check_out_2 = ? WHERE id = ?";
        } else {
            exit(json_encode(["status" => "fail", "message" => "Already checked out twice"]));
        }
    }

    $res = $cn->query($update);

    echo json_encode(["status" => "success", "action" => $type, "time" => $now]);
} else {
    // First time for today, insert new record
    if ($type === 'in') {
        $insert = $cn->prepare("INSERT INTO attendance (employee_id, attendance_date, check_in_1) VALUES ($employee_id, $today, $now)");
    } else if ($type === 'out') {
        $insert ="INSERT INTO attendance (employee_id, attendance_date, check_out_1) VALUES ($employee_id, $today, $now)";
    }
    $res = $cn->query($insert);
    if (!$res) {
        http_response_code(500);
        exit(json_encode(["status" => "fail", "message" => "Database error"]));
    }
    echo json_encode(["status" => "success", "action" => $type, "time" => $now]);
}
?>
