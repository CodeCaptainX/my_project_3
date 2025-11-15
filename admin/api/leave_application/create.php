<?php
header('Content-Type: application/json');
session_start();

include(__DIR__ . "/../../action/db/cn.php");
include(__DIR__ . "/../../utils/response.php");

if (!isset($cn)) {
    jsonErrorResponse("Database connection not initialized", [], 500);
}

$cn->set_charset("utf8");
if ($cn->connect_error) {
    jsonErrorResponse("Connection failed: " . $cn->connect_error, [], 500);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonErrorResponse("Method not allowed", [], 405);
}

$input = $_POST;

// Required fields
$required = ['employee_id', 'leave_type', 'start_date', 'end_date', 'reason', 'created_by'];
foreach ($required as $field) {
    if (!isset($input[$field])) {
        jsonErrorResponse("Missing required field: $field", [], 400);
    }
}

$uuid = bin2hex(random_bytes(16));
$employee_id = (int) $input['employee_id'];
$leave_type = $input['leave_type'];
$start_date = $input['start_date'];
$end_date = $input['end_date'];
$reason = $input['reason'];
$status_id = $input['status_id'] ?? 0;
$approved_by = $input['approved_by'] ?? null;
$created_at = date('Y-m-d H:i:s');
$created_by = (int) $input['created_by'];

$stmt = $cn->prepare("INSERT INTO tbl_leave_applications 
    (uuid, employee_id, leave_type, start_date, end_date, reason, status_id, approved_by, created_at, created_by)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sissssissi", $uuid, $employee_id, $leave_type, $start_date, $end_date, $reason, $status_id, $approved_by, $created_at, $created_by);

if ($stmt->execute()) {
    jsonResponse("Leave application created successfully", [
        "uuid" => $uuid,
        "id" => $stmt->insert_id
    ]);
} else {
    jsonErrorResponse("Failed to create leave application: " . $stmt->error, [], 500);
}

$cn->close();
