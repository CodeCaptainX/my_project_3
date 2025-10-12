<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Allow from anywhere (for testing)
header("Access-Control-Allow-Methods: POST");

// ✅ Database connection
$cn = new mysqli("localhost", "root", "", "doorstep");
if ($cn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}
$cn->set_charset("utf8");

// ✅ Get data safely
$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"] ?? '';
$password = $data["password"] ?? '';

// ✅ Prevent SQL injection
$stmt = $cn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["status" => "success", "user" => $row]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid username or password"]);
}

$stmt->close();
$cn->close();
?>
