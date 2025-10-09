<?php
// Simple database connection
$conn = new mysqli("localhost", "root", "", "doorstap");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$employee_id = isset($_POST['txt-employee-id']) ? $_POST['txt-employee-id'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$role = isset($_POST['role']) ? $_POST['role'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$lock_until = !empty($_POST['lock_until']) ? $_POST['lock_until'] : null;
$login_attempts = isset($_POST['login_attempts']) ? (int)$_POST['login_attempts'] : 0;

// Insert into database
$sql = "INSERT INTO users (id, employee_id, username, email, password, role, status, login_attempts, lock_until, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssiis",null, $employee_id, $username, $email, $password, $role, $status, $login_attempts, $lock_until);

if ($stmt->execute()) {
    echo "User saved successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>