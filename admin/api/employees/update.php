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

// --- Read JSON body ---
$input = json_decode(file_get_contents("php://input"), true);
if (!$input) {
    jsonErrorResponse("Invalid or missing JSON body", [], 400);
}

// --- Validate ID ---
if (empty($input['id'])) {
    jsonErrorResponse("Missing employee ID", [], 400);
}

$employee_id = (int) $input['id'];

// --- Optional fields ---
$fields = ['full_name', 'email', 'position', 'department_id', 'status_id'];
$setSQL = [];
$params = [];
$types = '';

foreach ($fields as $field) {
    if (isset($input[$field])) {
        $setSQL[] = "$field = ?";
        $params[] = $input[$field];
        $types .= is_int($input[$field]) ? 'i' : 's';
    }
}

if (empty($setSQL)) {
    jsonErrorResponse("No fields to update", [], 400);
}

// --- Add updated_at and updated_by ---
$setSQL[] = "updated_at = NOW()";
$setSQL[] = "updated_by = ?";
$params[] = $_SESSION['uid'] ?? 0;
$types .= 'i';

// --- Final SQL ---
$sql = "UPDATE tbl_employees SET " . implode(", ", $setSQL) . " WHERE id = ? AND deleted_at IS NULL";
$params[] = $employee_id;
$types .= 'i';

$stmt = $cn->prepare($sql);
if (!$stmt) {
    jsonErrorResponse("SQL prepare failed: " . $cn->error, [], 500);
}

$stmt->bind_param($types, ...$params);

if (!$stmt->execute()) {
    jsonErrorResponse("Failed to update employee: " . $stmt->error, [], 500);
}

jsonResponse("Employee updated successfully", [
    "employee_id" => $employee_id
]);

$stmt->close();
$cn->close();