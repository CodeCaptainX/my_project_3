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

if (empty($input['id'])) {
    jsonErrorResponse("Missing employee ID", [], 400);
}

$employee_id = (int) $input['id'];
$deleted_by = $_SESSION['uid'] ?? 0;

// --- Soft delete ---
$sql = "UPDATE tbl_employees 
        SET deleted_at = NOW(), deleted_by = ?
        WHERE id = ? AND deleted_at IS NULL";

$stmt = $cn->prepare($sql);
if (!$stmt) {
    jsonErrorResponse("SQL prepare failed: " . $cn->error, [], 500);
}

$stmt->bind_param("ii", $deleted_by, $employee_id);

if (!$stmt->execute()) {
    jsonErrorResponse("Failed to delete employee: " . $stmt->error, [], 500);
}

if ($stmt->affected_rows === 0) {
    jsonErrorResponse("Employee not found or already deleted", [], 404);
}

jsonResponse("Employee soft-deleted successfully", [
    "employee_id" => $employee_id
]);

$stmt->close();
$cn->close();