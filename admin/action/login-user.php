<?php
session_start();
include ('db/cn.php');
$cn->set_charset("utf8");
if ($cn->connect_error) {
    die("Connection failed: " . $cn->connect_error);
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$email = $cn->real_escape_string($email);

$pass = isset($_POST['password']) ? trim($_POST['password']) : '';
$pass = $cn->real_escape_string($pass);

$res['dpl'] = false;
$res['message'] = '';

$ip = $_SERVER['REMOTE_ADDR'];

$_SESSION['login'] = false;
$_SESSION['uid'] = 0;

// Query the corrected table structure
$dpl = "SELECT * FROM tbl_users WHERE email = '$email' AND deleted_at IS NULL";
$result = $cn->query($dpl);

if ($result->num_rows > 0) {
    $post_data = $result->fetch_assoc();
    
    // Check if user is active
    if ($post_data['status_id'] != 1) {
        $res['message'] = 'User account is inactive';
        echo json_encode($res);
        exit;
    }
    
    // Verify password using bcrypt (not md5)
    if (password_verify($pass, $post_data['password'])) {
        $sql = "UPDATE tbl_users SET updated_at = NOW() WHERE uuid = '" . $cn->real_escape_string($post_data['uuid']) . "'";
        $cn->query($sql);
        
        $res['dpl'] = true;
        $_SESSION['login'] = true;
        $_SESSION['uuid'] = $post_data['uuid'];
        $_SESSION['uid'] = $post_data['id'] ?? $post_data['uuid']; // Use id if exists, otherwise uuid
        $_SESSION['uemail'] = $post_data['email'];
        $_SESSION['uname'] = $post_data['username'];
        $_SESSION['ufull_name'] = $post_data['full_name'];
        $_SESSION['utype'] = $post_data['role'];
        $res['message'] = 'Login successful';
    } else {
        $res['message'] = 'Invalid credentials';
    }
} else {
    $res['message'] = 'User not found';
}

echo json_encode($res);
?>