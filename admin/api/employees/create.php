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

// --- Validate required fields ---
$required_fields = ['username', 'first_name', 'last_name', 'position', 'department', 'date_hired'];
foreach ($required_fields as $field) {
    if (empty($input[$field])) {
        jsonErrorResponse("Missing required field: $field", [], 400);
    }
}

// --- Prepare data ---
$uuid = bin2hex(random_bytes(16));
$full_name = trim($input['first_name'] . ' ' . $input['last_name']);
$status_id = isset($input['status_id']) ? (int)$input['status_id'] : 1;
$user_id = isset($input['user_id']) ? (int)$input['user_id'] : null;
$created_by = $_SESSION['uid'] ?? null;

// --- SQL ---
$sql = "INSERT INTO tbl_employees 
        (uuid, user_id, username, first_name, last_name, full_name, position, department, date_hired, status_id, created_at, created_by)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

$stmt = $cn->prepare($sql);
if (!$stmt) {
    jsonErrorResponse("SQL prepare failed: " . $cn->error, [], 500);
}

// ✅ There are exactly 11 placeholders => 11 bind parameters
$stmt->bind_param(
    "sissssssiii",
    $uuid,
    $user_id,
    $input['username'],
    $input['first_name'],
    $input['last_name'],
    $full_name,
    $input['position'],
    $input['department'],
    $input['date_hired'],
    $status_id,
    $created_by
);

if (!$stmt->execute()) {
    jsonErrorResponse("Failed to insert employee: " . $stmt->error, [], 500);
}

jsonResponse("Employee created successfully", [
    "id" => $stmt->insert_id,
    "uuid" => $uuid,
    "full_name" => $full_name
]);

$stmt->close();
$cn->close();