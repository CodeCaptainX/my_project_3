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

// Pagination parameters (optional)
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$per_page = isset($_GET['per_page']) ? (int) $_GET['per_page'] : 10;
$offset = ($page - 1) * $per_page;

// Get total count for pagination
$totalResult = $cn->query("SELECT COUNT(*) as total FROM tbl_employees WHERE deleted_at IS NULL");
$totalRow = $totalResult->fetch_assoc();
$total = (int) $totalRow['total'];

// Fetch data with pagination
$sql = "
    SELECT 
        id,
        uuid,
        user_id,
        username,
        first_name,
        last_name,
        full_name,
        position,
        department,
        date_hired,
        status_id,
        created_at,
        updated_at
    FROM tbl_employees
    WHERE deleted_at IS NULL
    ORDER BY created_at DESC
    LIMIT $per_page OFFSET $offset
";

$res = $cn->query($sql);
$data = [];

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
}

// Prepare pagination object
$pagination = [
    "total" => $total,
    "page" => $page,
    "per_page" => $per_page,
    "total_pages" => ceil($total / $per_page)
];

// Return response
jsonResponseWithPagination(
    "Employee records fetched successfully",
    $data,
    $pagination
);

$cn->close();
