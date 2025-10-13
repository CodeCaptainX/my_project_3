<?php
header('Content-Type: application/json');
session_start();

// ✅ Use absolute include path
include(__DIR__ . "/db/cn.php");

if (!isset($cn)) {
    die(json_encode(["error" => "Database connection not initialized"]));
}

$cn->set_charset("utf8");

// ✅ Safe input handling
$s = isset($_POST['s']) ? (int) $_POST['s'] : 0;
$e = isset($_POST['e']) ? (int) $_POST['e'] : 10;
$from_date = isset($_POST['from_date']) ? $_POST['from_date'] : null;
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;
$position = isset($_POST['position']) ? trim($_POST['position']) : null;
$search_term = isset($_POST['search_term']) ? trim($_POST['search_term']) : null;

// ✅ Count total attendance records (for pagination)
$sql_count = "SELECT COUNT(*) AS total FROM tbl_attendance_records WHERE deleted_at IS NULL";
$res_count = $cn->query($sql_count);
$total = ($res_count && $res_count->num_rows > 0) ? $res_count->fetch_assoc()['total'] : 0;

// ✅ Build base query
$sql = "
    SELECT 
        e.id AS employee_id,
        e.full_name,
        e.position,
        a.date AS attendance_date,
        a.check_time,
        a.check_type_id
    FROM 
        tbl_attendance_records a
    JOIN 
        tbl_employees e ON a.employee_id = e.id
    WHERE 
        a.deleted_at IS NULL
";

// ✅ Apply filters
if (!empty($from_date) && !empty($end_date)) {
    $sql .= " AND a.date BETWEEN '$from_date' AND '$end_date'";
}

if (!empty($position)) {
    $sql .= " AND e.position LIKE '%$position%'";
}

if (!empty($search_term)) {
    $sql .= " AND (e.full_name LIKE '%$search_term%' OR e.username LIKE '%$search_term%')";
}

$sql .= " ORDER BY a.date DESC, e.id ASC LIMIT $s, $e";

// ✅ Query the data
$res = $cn->query($sql);
$data = [];

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $data[] = [
            'employee_id' => $row['employee_id'],
            'full_name' => $row['full_name'],
            'position' => $row['position'],
            'attendance_date' => $row['attendance_date'],
            'check_time' => $row['check_time'],
            'check_type_id' => $row['check_type_id'],
            'total' => $total
        ];
    }

    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([]);
}

$cn->close();
?>